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
use App\ContratoItem;
use App\User;

class ContratoController extends Controller
{
    public function index()
    {
    	$itens = ItemContrato::where('status','Ativo')->get();
        
        $empresas = User::role('empresa')->get();
        
        return view('contrato.index',compact('itens','empresas'));    
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

    public function itens($id)
    {
        $itens = Contrato::join('contrato_items','contrato_items.fk_contrato','=','contratos.id')
        ->join('item_contratos','item_contratos.id','=','contrato_items.fk_item')
        ->select('contrato_items.quantidade','item_contratos.nome','contrato_items.fk_item')
        ->orderBy('contratos.created_at', 'desc')
        ->where('contratos.id',$id)->get();

        return response()->json(['data'=>$itens]);
    }

    private function setBtns(Contrato $contratos){
        $dados = "data-id_del='$contratos->id' data-id='$contratos->id' data-numero='$contratos->numero' data-valor_total='$contratos->valor_total' data-data_inicio='$contratos->data_inicio' data-data_fim='$contratos->data_fim'";

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
            $contrato->fk_user = $request->fk_user;
            $contrato->status = 'Ativo';
            $contrato->save();

            foreach ($request->itens as $value) {   
                $contrato_item = new ContratoItem();
                $contrato_item->quantidade = $value['quantidade'];
                $contrato_item->fk_item = $value['fk_item'];
                $contrato_item->fk_contrato = $contrato->id;
                $contrato_item->save();
            }
            
            return response()->json($contrato);
        }
    }

    public function update(Request $request)
    {
        $contrato = Contrato::find($request->id);
        $contrato->valor_total = $request->valor_total;
        $contrato->data_inicio = $request->data_inicio;
        $contrato->data_fim = $request->data_fim;
        $contrato->numero = $request->numero;
        $contrato->save();

       if(isset($request->itens)){
            DB::table("contrato_items")->where("contrato_items.fk_contrato",$request->id)
                ->delete();
            
            foreach ($request->itens as $value) {   
                $contrato_item = new ContratoItem();
                $contrato_item->quantidade = $value['quantidade'];
                $contrato_item->fk_item = $value['fk_item'];
                $contrato_item->fk_contrato = $request->id;
                $contrato_item->save();
            }
        }

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
