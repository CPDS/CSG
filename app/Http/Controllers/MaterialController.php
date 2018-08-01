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
use App\Material;
use App\Licitacao;

class MaterialController extends Controller
{
    
    public function index()
    {
        $licitacoes = Licitacao::where('status','Ativo')->get();
        return view('material.index',compact('licitacoes'));    
    } 

    public function list()
    {

        $material = Material::JOIN('licitacaos','materials.id_licitacao','=','licitacaos.id')
        ->where('materials.status','Ativo')
        ->select('materials.id','materials.nome','materials.valor_unitario','materials.valor_total','materials.quantidade','licitacaos.termo_aditivo','licitacaos.numero','licitacaos.modalidade', 'licitacaos.id as id_licitacao')
        ->orderBy('materials.created_at', 'desc')->get();

        
        return DataTables::of($material)
            ->editColumn('acao', function ($material){
                return $this->setBtns($material);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Material $materials){
        $dados = "data-id_del='$materials->id' data-id='$materials->id' data-nome='$materials->nome' data-numero='$materials->numero' data-id_licitacao='$materials->id_licitacao' data-modalidade='$materials->modalidade' data-valor_total='$materials->valor_total' data-valor_unitario='$materials->valor_unitario' data-termo_aditivo='$materials->termo_aditivo' data-quantidade='$materials->quantidade' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver material' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar material' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar material' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required',
            'valor_unitario' => 'required',
            'valor_total' => 'required',
            'quantidade' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome',
            'valor_unitario' => 'Valor Unitário',
            'valor_total' => 'Valor Total',
            'quantidade' => 'Quantidade'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $material = new Material();
            $material->nome = $request->nome;
            $material->valor_unitario = $request->valor_unitario;
            $material->valor_total = $request->valor_total;
            $material->quantidade = $request->quantidade;
            $material->id_licitacao = $request->id_licitacao;
            $material->status = 'Ativo';
            $material->save();
            
            return response()->json($material);
        }
    }

    public function update(Request $request)
    {
        $material = Material::find($request->id);
        $material->nome = $request->nome;
        $material->valor_unitario = $request->valor_unitario;
        $material->valor_total = $request->valor_total;
        $material->quantidade = $request->quantidade;
        $material->id_licitacao = $request->id_licitacao;
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
