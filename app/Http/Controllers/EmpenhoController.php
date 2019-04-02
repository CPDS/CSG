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
use App\Empenho;
use App\Contrato;
use App\EmpenhoItem;
use App\ContratoItem;


class EmpenhoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::all();
        $itens = ContratoItem::join('item_contratos','item_contratos.id','=','contrato_items.fk_item')
         ->get();


        return view('empenho.index',compact('contratos','itens'));    
    } 

    public function list()
    {

        $empenho = Empenho::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($empenho)
            ->editColumn('acao', function ($empenho){
                return $this->setBtns($empenho);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Empenho $empenhos){
        $contrato = $empenhos->contrato->valor_total;
        $dados = "data-id_del='$empenhos->id' 
        data-id='$empenhos->id' 
        data-valor='$empenhos->valor'
        data-fk_contrato='$empenhos->fk_contrato'  
        data-saldo_anterior='$empenhos->saldo_anterior'  
        data-valor_contrato='$contrato'  
        data-valor='$empenhos->data' ";

        $btnEditar = '';
        $btnDeletar = '';

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver empenho' $dados> <i class='fa fa-eye'></i></a> ";
        
        if(Auth::user()->can('editar-empenho')){
            $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar empenho' $dados> <i class='fa fa-edit'></i></a> ";
        }

        if(Auth::user()->can('excluir-empenho')){
            $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar empenho' $dados><i class='fa fa-trash'></i></a>";
        }

        $btnAdd = " <a class='btn btn-warning btn-sm btnAdd' data-toggle='tooltip' title='Adicionar itens' $dados><i class='fa fa-plus'></i></a> ";


        return $btnVer.$btnEditar.$btnAdd.$btnDeletar;
    }

    public function store(Request $request)
    {   
        $total = 0;
        $soma_total = 0;

        $empenho_anterior = Empenho::where('fk_contrato', $request->fk_contrato)
            ->orderBy('created_at', 'desc') 
            ->first();

        $contrato = Contrato::find($request->fk_contrato);

        $sum_empenho = Empenho::where('fk_contrato', $request->fk_contrato)
            ->where('status','!=','Inativo')
            ->select('valor') 
            ->sum('valor');
        $sum_empenho += $request->valor;

        
        if($sum_empenho > $contrato->valor_total){
            return response()->json('O valor do empenho ultrapassa o valor disponível do contrato',500);
        }

        if($empenho_anterior){

            $itens_empenho = EmpenhoItem::join('empenhos','empenhos.id','=','empenho_items.fk_empenho')
                ->join('item_contratos','item_contratos.id','=','empenho_items.fk_contrato_item')
                ->join('contrato_items','contrato_items.fk_item','=','item_contratos.id')
                ->select('contrato_items.valor_unitario', 'empenho_items.quantidade')
                ->where('empenho_items.fk_empenho', $empenho_anterior->id)
                ->get();

            foreach ($itens_empenho as $value) {
                $total += $value->quantidade * $value->valor_unitario;
            }

            if( $empenho_anterior->valor > $total ){
                $soma_total = $empenho_anterior->valor - $total;
            }
        }

        $rules = array(
            'valor' => 'required',
            'data' => 'required',
        );
        $attributeNames = array(
            'valor' => 'Nome',
            'data' => 'Data',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

        
            $empenho = new Empenho();
            $empenho->valor = $request->valor;
            $empenho->data = $request->data;
            $empenho->saldo_anterior = $soma_total;
            $empenho->fk_contrato = $request->fk_contrato;
            $empenho->status = 'Ativo';
            $empenho->save();
            
            return response()->json($empenho);
        }
    }

    public function itens(Request $request)
    {
        $itens = $request->itens; 

        $empenho = new EmpenhoItem();
        $empenho->fk_empenho = $itens[0]['fk_empenho'];
        $empenho->fk_contrato_item = $itens[0]['fk_item'];
        $empenho->quantidade = $itens[0]['quantidade'];
        $empenho->save();

        return response()->json($empenho);
    }


    public function getItens($id)
    {

        $empenho = EmpenhoItem::join('empenhos','empenhos.id','=','empenho_items.fk_empenho')
            ->join('item_contratos','item_contratos.id','=','empenho_items.fk_contrato_item')
            ->join('contrato_items','contrato_items.fk_item','=','item_contratos.id')
            ->select('contrato_items.valor_unitario as valor','empenho_items.quantidade','empenho_items.id','item_contratos.nome')
            ->where('empenhos.id',$id)
            ->orderBy('empenho_items.created_at','ASC')
            ->get();

        return response()->json(['data'=>$empenho]);
    }  

    public function deleteItem($id)
    {

        $empenho = EmpenhoItem::destroy($id);

        return response()->json(['data'=>$empenho]);
    }


    public function update(Request $request)
    {
        $empenho = Empenho::find($request->id);
        $empenho->valor = $request->valor;
        $empenho->data = $request->data;
        $empenho->save();

        return response()->json($empenho);
    }

    public function destroy(Request $request)
    {
        $empenho = Empenho::find($request->id_del);
        $empenho->status = 'Inativo';
        $empenho->save();

        return response()->json($empenho);
    }
}
