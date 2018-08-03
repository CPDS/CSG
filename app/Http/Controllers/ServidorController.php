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
use App\Servidor;
use App\Setor;

class ServidorController extends Controller
{
    public function index()
    {
        $setores = Setor::where('status','Ativo')->get();
        return view('servidor.index',compact('setores'));    
    } 

    public function list()
    {

        $servidor = Servidor::JOIN('setors','servidors.id_setor','=','setors.id')
        ->where('servidors.status','Ativo')
        ->select('servidors.id','servidors.nome as nome_servidor','servidors.rg','servidors.cargo','setors.nome as nome_setor','setors.sigla','setors.email', 'setors.id as id_setor')
        ->orderBy('servidors.created_at', 'desc')->get();

        
        return DataTables::of($servidor)
            ->editColumn('acao', function ($servidor){
                return $this->setBtns($servidor);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Servidor $servidors){
        $dados = "data-id_del='$servidors->id' data-id='$servidors->id' data-nome_servidor='$servidors->nome_servidor' data-rg='$servidors->rg' data-id_setor='$servidors->id_setor' data-cargo='$servidors->cargo' data-nome_setor='$servidors->nome_setor' data-sigla='$servidors->sigla' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver servidor' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar servidor' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar servidor' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome_servidor' => 'required',
            'rg' => 'required',
            'cargo' => 'required',
            'id_setor' => 'required'
        );
        $attributeNames = array(
            'nome_servidor' => 'Nome',
            'rg' => 'RG',
            'cargo' => 'Cargo',
            'id_setor' => 'Setor'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $servidor = new Servidor();
            $servidor->nome = $request->nome_servidor;
            $servidor->rg = $request->rg;
            $servidor->cargo = $request->cargo;
            $servidor->id_setor = $request->id_setor;
            $servidor->status = 'Ativo';
            $servidor->save();
            
            return response()->json($servidor);
        }
    }

    public function update(Request $request)
    {
        $servidor = Servidor::find($request->id);$servidor->cargo = $request->cargo;
        $servidor->id_setor = $request->id_setor;
        $servidor->nome = $request->nome_servidor;
        $servidor->rg = $request->rg;
        $servidor->cargo = $request->cargo;
        $servidor->id_setor = $request->id_setor;
        $servidor->save();

        return response()->json($servidor);
    }

    public function destroy(Request $request)
    {
        $servidor = Servidor::find($request->id_del);
        $servidor->status = 'Inativo';
        $servidor->save();

        return response()->json($servidor);
    }
}
