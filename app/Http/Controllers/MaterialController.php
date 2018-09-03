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
use App\User;
use App\Material;


class MaterialController extends Controller
{
    
    public function index()
    {
        return view('material.index');    
    } 

    public function list()
    {

        $material = Material::JOIN('users','users.id','=','materials.fk_user')
        ->select('users.name as nome_usuario','materials.tipo','materials.descricao', 'materials.id')
        ->orderBy('materials.created_at', 'desc')
        ->where('materials.status','Ativo')->get();

        return DataTables::of($material)
            ->editColumn('acao', function ($material){
                return $this->setBtns($material);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Material $materials){
        $dados = "data-id_del='$materials->id' data-id='$materials->id' data-tipo='$materials->tipo' data-descricao='$materials->descricao' data-nome_usuario='$materials->nome_usuario' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver material' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = " <a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar material' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = " <a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar material' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {   
      
        $rules = array(
            'descricao' => 'required',
            'tipo' => 'required'
        );
        $attributeNames = array(
            'descricao' => 'Descrição',
            'tipo' => 'Quantidade'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $material = new Material();
            $material->descricao = $request->descricao;
            $material->tipo = $request->tipo;
            $material->fk_user = Auth::User()->id;
            $material->status = 'Ativo';
            $material->save();
            
            return response()->json($material);
        }
    }

    public function update(Request $request)
    {

        $material = Material::find($request->id);
        $material->descricao = $request->descricao;
        $material->tipo = $request->tipo;
        $material->save();

        return response()->json($material);
    }

    public function destroy(Request $request)
    {
        $material = Material::find($request->id_del);
        $material->status = 'Inativo';
        $material->save();

        return response()->json($material);
    }
}
