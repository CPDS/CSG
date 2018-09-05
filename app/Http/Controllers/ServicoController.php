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
use App\Servico;


class ServicoController extends Controller
{
    
    public function index()
    {
        return view('servico.index');    
    } 

    public function list()
    {

        $servico = Servico::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($servico)
            ->editColumn('acao', function ($servico){
                return $this->setBtns($servico);
            })->escapeColumns([0])
            ->make(true);

        
        return DataTables::of($servico)
            ->editColumn('acao', function ($servico){
                return $this->setBtns($servico);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Servico $servicos){
        $dados = "data-id_del='$servicos->id' data-id='$servicos->id' data-nome='$servicos->nome' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver servico' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar servico' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar servico' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $servico = new servico();
            $servico->nome = $request->nome;
            $servico->fk_user = Auth::User()->id;
            $servico->status = 'Ativo';
            $servico->save();
            
            return response()->json($servico);
        }
    }

    public function update(Request $request)
    {
        $servico = Servico::find($request->id);
        $servico->nome = $request->nome;
        $servico->save();

        return response()->json($servico);
    }

    public function destroy(Request $request)
    {
        $servico = Servico::find($request->id_del);
        $servico->status = 'Inativo';
        $servico->save();

        return response()->json($servico);
    }
}
