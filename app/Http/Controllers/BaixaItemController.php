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
use App\Setor;
use App\Solicitacao;

class BaixaItemController extends Controller
{
    public function index()
    {

        return view('baixa_item.index');    
    } 

    public function list()
    {

        $solicitacaos = Solicitacao::JOIN('users','users.id','=','solicitacaos.fk_user_solicitante')
        ->LEFTJOIN('material_saidas','material_saidas.fk_solicitacao','=','solicitacaos.id')
        ->LEFTJOIN('materials','materials.id','=','material_saidas.fk_material')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante',
            'material_saidas.quantidade','materials.descricao as descricao_material','materials.id as id_material')
        ->orderBy('solicitacaos.created_at', 'desc')->get();


        return DataTables::of($solicitacaos)
            ->editColumn('acao', function ($solicitacaos){
                return $this->setBtns($solicitacaos);
            })->escapeColumns([0])
            ->make(true); 
    }

    private function setBtns(Solicitacao $solicitacaos){
        $dados = "
        data-id_del='$solicitacaos->id_material' 
        data-id='$solicitacaos->id' 
        data-descricao_solicitacao='$solicitacaos->descricao_solicitacao'  
        data-titulo='$solicitacaos->titulo' 
        data-observacao_solicitado='$solicitacaos->observacao_solicitado' 
        data-observacao_solicitante='$solicitacaos->observacao_solicitante'
        data-quantidade='$solicitacaos->quantidade' 
         ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar solicitacao' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar solicitacao' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required',
            'sigla' => 'required',
            'telefone' => 'required',
            'email' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome',
            'sigla' => 'Sigla',
            'email' => 'E-mail',
            'telefone' => 'Telefone'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $setor = new Setor();
            $setor->nome = $request->nome;
            $setor->sigla = $request->sigla;
            $setor->email = $request->email;
            $setor->telefone = $request->telefone;
            $setor->status = 'Ativo';
            $setor->save();
            
            return response()->json($setor);
        }
    }

    public function update(Request $request)
    {
        $setor = Setor::find($request->id);
        $setor->nome = $request->nome;
        $setor->sigla = $request->sigla;
        $setor->email = $request->email;
        $setor->telefone = $request->telefone;
        $setor->save();

        return response()->json($setor);
    }

    public function destroy(Request $request)
    {
        $setor = Setor::find($request->id_del);
        $setor->status = 'Inativo';
        $setor->save();

        return response()->json($setor);
    }
}
