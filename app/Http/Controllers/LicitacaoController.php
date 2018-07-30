<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use Response;
use DataTables;
use DB;
use Auth;
use App\Licitacao;

class LicitacaoController extends Controller
{
    public function index()
    {
        return view('licitacao.index');    
    } 

    public function list()
    {
        $licitacao = Licitacao::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($licitacao)
            ->editColumn('acao', function ($licitacao){
                return $this->setBtns($licitacao);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Licitacao $licitacaos){
        $dados = "data-id_del='$licitacaos->id' data-id='$licitacaos->id' data-numero='$licitacaos->numero' data-termo_aditivo='$licitacaos->termo_aditivo' data-modalidade='$licitacaos->modalidade'";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver licitacao' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar licitacao' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar licitacao' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {   
        $rules = array(
            'numero' => 'required',
            'termo_aditivo' => 'required',
            'modalidade' => 'required'
        );
        $attributeNames = array(
            'numero' => 'Número',
            'termo_aditivo' => 'Termo Aditivo',
            'modalidade' => 'Modalidade'
            
        );
        $messages = array(
            'same' => 'Essas senhas não coincidem.'
        );
        $validator = Validator::make(Input::all(), $rules, $messages);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $licitacao = new Licitacao();
            $licitacao->numero = $request->numero;
            $licitacao->termo_aditivo = $request->termo_aditivo;
            $licitacao->modalidade = $request->modalidade;
            $licitacao->status = 'Ativo';
            $licitacao->save();
       
            return response()->json($licitacao);
        }
    }

    public function update(Request $request)
    {
        $licitacao = Licitacao::find($request->id);
        $licitacao->numero = $request->numero;
        $licitacao->termo_aditivo = $request->termo_aditivo;
        $licitacao->modalidade = $request->modalidade;
        $licitacao->save();

        return response()->json($licitacao);
    }

    public function destroy(Request $request)
    {
        $licitacao = Licitacao::find($request->id_del);
        $licitacao->status = 'Inativo';
        $licitacao->save();

        return response()->json($licitacao);
    }
}
