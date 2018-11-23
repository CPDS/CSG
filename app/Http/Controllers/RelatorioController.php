<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Solicitacao;

class RelatorioController extends Controller
{
    public function saidaDeItens(){
        
        $solicitacaos = Solicitacao::JOIN('users','users.id','=','solicitacaos.fk_user_solicitante')
        ->LEFTJOIN('material_saidas','material_saidas.fk_solicitacao','=','solicitacaos.id')
        ->LEFTJOIN('materials','materials.id','=','material_saidas.fk_material')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante',
            'material_saidas.quantidade as quantidade_solicitada','material_saidas.status' ,'materials.descricao as descricao_material','materials.id as id_material', 'material_saidas.id as id_material_saida','material_saidas.quantidade_atendida')
        ->orderBy('solicitacaos.created_at', 'desc')->get();
   
        $pdf = PDF::loadView('baixa_item.relatorio', ['solicitacaos' => $solicitacaos])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }
}
