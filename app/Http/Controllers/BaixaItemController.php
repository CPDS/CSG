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
use App\MaterialSaida;

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
            'material_saidas.quantidade as quantidade_solicitada','material_saidas.status' ,'materials.descricao as descricao_material','materials.id as id_material', 'material_saidas.id as id_material_saida','material_saidas.quantidade_atendida')
        ->orderBy('solicitacaos.created_at', 'desc')->get();


        return DataTables::of($solicitacaos)
            ->editColumn('acao', function ($solicitacaos){
                return $this->setBtns($solicitacaos);
            })->escapeColumns([0])
            ->make(true); 
    }

    private function setBtns(Solicitacao $solicitacaos){
        $btnDeletar = '';

        $dados = "
        data-id_material_saida='$solicitacaos->id_material_saida' 
        data-id='$solicitacaos->id' 
        data-descricao_solicitacao='$solicitacaos->descricao_solicitacao'  
        data-titulo='$solicitacaos->titulo' 
        data-observacao_solicitado='$solicitacaos->observacao_solicitado' 
        data-observacao_solicitante='$solicitacaos->observacao_solicitante'
        data-status='$solicitacaos->status'
        data-quantidade_solicitada='$solicitacaos->quantidade_solicitada' 
        data-quantidade_atendida='$solicitacaos->quantidade_atendida' 
         ";

        $btnEditar = '';
        $btnDeletar = '';


        if(Auth::user()->can('ver-baixa-material')){
           $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao' $dados> <i class='fa fa-eye'></i></a> ";
        }

        if(Auth::user()->can('editar-baixa-material')){
            $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar baixa item' $dados> <i class='fa fa-edit'></i></a> ";
        }

        return $btnVer.$btnEditar;
    }

    public function update(Request $request)
    {
        $material_saidas = MaterialSaida::find($request->id_material_saida);
        $material_saidas->status = $request->status;
        $material_saidas->quantidade_atendida = $request->quantidade_atendida;
        $material_saidas->save();

        return response()->json($material_saidas);
    }

    public function destroy(Request $request)
    {
        $setor = Setor::find($request->id_del);
        $setor->status = 'Inativo';
        $setor->save();

        return response()->json($setor);
    }
}
