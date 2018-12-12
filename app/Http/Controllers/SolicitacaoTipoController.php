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
use App\SolicitacaoTipo;

class SolicitacaoTipoController extends Controller
{
     public function index()
    {
        return view('solicitacao_tipo.index');    
    } 

    public function list()
    {

        $solicitacao_tipo = SolicitacaoTipo::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($solicitacao_tipo)
            ->editColumn('acao', function ($solicitacao_tipo){
                return $this->setBtns($solicitacao_tipo);
            })->escapeColumns([0])
            ->make(true);

        
        return DataTables::of($solicitacao_tipo)
            ->editColumn('acao', function ($solicitacao_tipo){
                return $this->setBtns($solicitacao_tipo);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(SolicitacaoTipo $solicitacao_tipos){
        $dados = "data-id_del='$solicitacao_tipos->id' data-id='$solicitacao_tipos->id' data-nome='$solicitacao_tipos->nome' data-descricao='$solicitacao_tipos->descricao'";

        $btnEditar = '';
        $btnDeletar = '';

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao_tipo' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar solicitacao_tipo' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar solicitacao_tipo' $dados><i class='fa fa-trash'></i></a>";

        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required',
            'descricao' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome',
            'descricao' => 'Descrição'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $solicitacao_tipo = new SolicitacaoTipo();
            $solicitacao_tipo->nome = $request->nome;
            $solicitacao_tipo->descricao = $request->descricao;
            $solicitacao_tipo->status = 'Ativo';
            $solicitacao_tipo->save();
            
            return response()->json($solicitacao_tipo);
        }
    }

    public function update(Request $request)
    {
        $solicitacao_tipo = SolicitacaoTipo::find($request->id);
        $solicitacao_tipo->nome = $request->nome;
        $solicitacao_tipo->descricao = $request->descricao;
        $solicitacao_tipo->save();

        return response()->json($solicitacao_tipo);
    }

    public function destroy(Request $request)
    {
        $solicitacao_tipo = SolicitacaoTipo::find($request->id_del);
        $solicitacao_tipo->status = 'Inativo';
        $solicitacao_tipo->save();

        return response()->json($solicitacao_tipo);
    }
}
