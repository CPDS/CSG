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

class MaterialController extends Controller
{
    
    public function index()
    {
        return view('material.index');    
    } 

    public function list()
    {
        $material = Material::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($material)
            ->editColumn('acao', function ($material){
                return $this->setBtns($material);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Material $materials){
        $dados = "data-id_del='$materials->id' data-id='$materials->id' data-nome='$materials->nome' data-colaborador='$materials->colaborador' data-n_licitacao='$materials->n_licitacao' data-modalidade='$materials->modalidade' data-bens='$materials->bens'  data-valor_licitacao='$materials->valor_licitacao' data-valor_unitario='$materials->valor_unitario' data-termo_aditivo='$materials->termo_aditivo'";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver material' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar material' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar material' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required',
            'colaborador' => 'required',
            'n_licitacao' => 'required',
            'modalidade' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome',
            'colaborador' => 'Colaborador',
            'n_licitacao' => 'Nº da Licitação',
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

            $material = new Material();
            $material->nome = $request->nome;
            $material->colaborador = $request->colaborador;
            $material->bens = $request->bens;
            $material->n_licitacao = $request->n_licitacao;
            $material->termo_aditivo = $request->termo_aditivo;
            $material->modalidade = $request->modalidade;
            $material->valor_licitacao = $request->valor_licitacao;
            $material->valor_unitario = $request->valor_unitario;
            $material->status = 'Ativo';
            $material->save();
            //$material->setAttribute('buttons', $this->setDataButtons($material)); 
            return response()->json($material);
        }
    }

    public function update(Request $request)
    {
        $material = Material::find($request->id);
        $material->nome = $request->nome;
        $material->colaborador = $request->colaborador;
        $material->bens = $request->bens;
        $material->n_licitacao = $request->n_licitacao;
        $material->termo_aditivo = $request->termo_aditivo;
        $material->modalidade = $request->modalidade;
        $material->valor_licitacao = $request->valor_licitacao;
        $material->valor_unitario = $request->valor_unitario;
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
