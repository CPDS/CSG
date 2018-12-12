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
use App\MaterialEntrada;

class EntradaMaterialController extends Controller
{
    public function index()
    {
        $users = User::where('status','Ativo')->get();
        $materials = Material::where('status','Ativo')->get();
        return view('entrada_material.index',compact('users','materials'));    
    } 

    public function list()
    {
        
        $material_entradas = Material::JOIN('material_entradas','material_entradas.fk_material','=','materials.id')
        ->JOIN('users','users.id','=','material_entradas.fk_user')
        ->where('material_entradas.status','Ativo')
        ->select('material_entradas.id','material_entradas.quantidade','materials.descricao','materials.tipo','users.name as usuario', 'material_entradas.fk_material')
        ->orderBy('material_entradas.created_at', 'desc')->get();


        return DataTables::of($material_entradas)
            ->editColumn('acao', function ($material_entradas){
                return $this->setBtns($material_entradas);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Material $material_entradas){
        $dados = "data-id_del='$material_entradas->id' data-id='$material_entradas->id' data-quantidade='$material_entradas->quantidade' data-descricao='$material_entradas->descricao' data-usuario='$material_entradas->usuario' data-tipo='$material_entradas->tipo'  data-fk_material='$material_entradas->fk_material' ";

        $btnEditar = '';
        $btnDeletar = '';

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver material_entradas' $dados> <i class='fa fa-eye'></i></a> ";

        if(Auth::user()->can('editar-estoque')){
            $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar material_entradas' $dados> <i class='fa fa-edit'></i></a> ";
        }
        
        if(Auth::user()->can('excluir-estoque')){
            $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar material_entradas' $dados><i class='fa fa-trash'></i></a>";
        }

        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {  
        $rules = array(
            'quantidade' => 'required',
            'fk_material' => 'required'
        );

        $attributeNames = array(
            'quantidade' => 'Quantidade',
            'fk_material' => 'Material'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $material_entradas = new MaterialEntrada();
            $material_entradas->quantidade = $request->quantidade;
            $material_entradas->fk_user = Auth::User()->id;
            $material_entradas->fk_material = $request->fk_material;
            $material_entradas->status = 'Ativo';
            $material_entradas->save();
            
            return response()->json($material_entradas);
        }
    }

    public function update(Request $request)
    {
        $material_entradas = MaterialEntrada::find($request->id);
        $material_entradas->quantidade = $request->quantidade;
        $material_entradas->fk_material = $request->fk_material;
        $material_entradas->save();

        return response()->json($material_entradas);
    }

    public function destroy(Request $request)
    {
        $material_entradas = MaterialEntrada::find($request->id_del);
        $material_entradas->status = 'Inativo';
        $material_entradas->save();

        return response()->json($material_entradas);
    }
}
