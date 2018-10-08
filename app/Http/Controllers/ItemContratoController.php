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
use App\ItemContrato;

class ItemContratoController  extends Controller
{
    public function index()
    {
        return view('item_contrato.index');    
    } 

    public function list()
    {

        $item_contrato = ItemContrato::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($item_contrato)
            ->editColumn('acao', function ($item_contrato){
                return $this->setBtns($item_contrato);
            })->escapeColumns([0])
            ->make(true);    
    }

    private function setBtns(ItemContrato $item_contratos){
        $dados = "data-id_del='$item_contratos->id' data-id='$item_contratos->id' data-nome='$item_contratos->nome' data-valor_unitario='$item_contratos->valor_unitario'";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver item_contrato' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar item_contrato' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar item_contrato' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required',
            'valor_unitario' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome',
            'valor_unitario' => 'Valor unitário'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $item_contrato = new ItemContrato();
            $item_contrato->nome = $request->nome;
            $item_contrato->valor_unitario = $request->valor_unitario;
            $item_contrato->status = 'Ativo';
            $item_contrato->save();
            
            return response()->json($item_contrato);
        }
    }

    public function update(Request $request)
    {
        $item_contrato = ItemContrato::find($request->id);
        $item_contrato->nome = $request->nome;
        $item_contrato->valor_unitario = $request->valor_unitario;
        $item_contrato->save();

        return response()->json($item_contrato);
    }

    public function destroy(Request $request)
    {
        $item_contrato = ItemContrato::find($request->id_del);
        $item_contrato->status = 'Inativo';
        $item_contrato->save();

        return response()->json($item_contrato);
    }
}
