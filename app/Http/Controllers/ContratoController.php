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
use App\Contrato;
use App\ItemContrato;

class ContratoController extends Controller
{
    public function index()
    {
    	$itens = ItemContrato::where('status','Ativo')->get();	
        
        return view('contrato.index',compact('itens'));    
    } 

    public function list()
    {

        $contrato = Contrato::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($contrato)
            ->editColumn('acao', function ($contrato){
                return $this->setBtns($contrato);
            })->escapeColumns([0])
            ->make(true);

       
    }

    private function setBtns(Contrato $contratos){
        $dados = "data-id_del='$contratos->id' data-id='$contratos->id' data-nome='$contratos->nome' data-sigla='$contratos->sigla' data-email='$contratos->email' data-telefone='$contratos->telefone'";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver contrato' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar contrato' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar contrato' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'valor_total' => 'required',
            'data_inicio' => 'required',
            'data_fim' => 'required',
            'numero' => 'required'
        );
        $attributeNames = array(
            'valor_total' => 'Valor total',
            'data_inicio' => 'Data início',
            'numero' => 'Número',
            'data_fim' => 'Data fim'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $contrato = new Contrato();
            $contrato->valor_total = $request->valor_total;
            $contrato->data_inicio = $request->data_inicio;
            $contrato->data_fim = $request->data_fim;
            $contrato->numero = $request->numero;
            $contrato->status = 'Ativo';
            $contrato->save();
            
            return response()->json($contrato);
        }
    }

    public function update(Request $request)
    {
        $contrato = Contrato::find($request->id);
        $contrato->nome = $request->nome;
        $contrato->sigla = $request->sigla;
        $contrato->email = $request->email;
        $contrato->telefone = $request->telefone;
        $contrato->save();

        return response()->json($contrato);
    }

    public function destroy(Request $request)
    {
        $contrato = Contrato::find($request->id_del);
        $contrato->status = 'Inativo';
        $contrato->save();

        return response()->json($contrato);
    }
}
