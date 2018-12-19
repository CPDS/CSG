<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Solicitacao;
use App\User;
use App\Contrato;
use App\EscalaHorario;
use App\HoraExtra;
use App\Material;
use App\Setor;

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

    public function usuarios(){
        $usuarios = User::LEFTJOIN('setors','users.fk_setor','=','setors.id')
        ->JOIN('model_has_roles','model_has_roles.model_id','=','users.id')
        ->JOIN('roles','model_has_roles.role_id','=','roles.id')
        ->where('users.status','Ativo')
        ->select('users.id','users.name as nome_user','users.cpf','users.telefone','users.endereco','setors.nome as nome_setor','setors.sigla','users.email', 'setors.id as fk_setor','roles.name as nome_role' , 'users.cpf', 'users.cnpj', 'users.responsavel', 'users.contato')
        ->orderBy('users.created_at', 'desc')->get();
   
        $pdf = PDF::loadView('user.relatorio', ['usuarios' => $usuarios])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }

    public function contratos(){
        $contratos = Contrato::join('contrato_items','contrato_items.fk_contrato','=','contratos.id')
        ->join('item_contratos','item_contratos.id','=','contrato_items.fk_item')
        ->select('contrato_items.quantidade','item_contratos.nome','contrato_items.fk_item', 'contrato_items.valor_unitario')
        ->orderBy('contratos.created_at', 'desc')
        ->get();
   
        $pdf = PDF::loadView('contrato.relatorio', ['contratos' => $contratos])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }

    public function escalas(){

        $escala_horarios = EscalaHorario::JOIN('users','escala_horarios.fk_user','=','users.id')
        ->JOIN('setors','setors.id','=','escala_horarios.fk_setor')
        ->where('escala_horarios.status','Ativo')
        ->select('escala_horarios.id','escala_horarios.horario_inicio','escala_horarios.dia_semana','escala_horarios.horario_termino', 'users.name as nome_funcionario', 'users.id as fk_user','setors.nome as nome_setor' , 'escala_horarios.fk_setor')
        ->orderBy('escala_horarios.created_at', 'desc')->get();
   
        $pdf = PDF::loadView('user.relatorio_escalas', ['escala_horarios' => $escala_horarios])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }

    public function horas(){
        $horas_extras = HoraExtra::JOIN('users','hora_extras.fk_user','=','users.id')
        ->where('hora_extras.status','Ativo')
        ->select('hora_extras.id','hora_extras.horas_excedidas','hora_extras.dia','users.name as nome_funcionario', 'users.id as fk_user')
        ->orderBy('hora_extras.created_at', 'desc')->get();
   
        $pdf = PDF::loadView('user.relatorio_horas', ['horas_extras' => $horas_extras])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }

    public function materiais(){
        
        $materiais = Material::orderBy('created_at', 'desc')->get();
   
        $pdf = PDF::loadView('material.relatorio', ['materiais' => $materiais])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }

    public function setores(){
        
        $setores = Setor::orderBy('created_at', 'desc')->get();
   
        $pdf = PDF::loadView('setor.relatorio', ['setores' => $setores])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }

    public function solicitacoes(){

        $solicitacaos = Solicitacao::JOIN('users','users.id','=','solicitacaos.fk_user_solicitante')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante')
        ->orderBy('solicitacaos.created_at', 'desc')->get();
   
        $pdf = PDF::loadView('solicitacao.relatorio', ['solicitacaos' => $solicitacaos])->setPaper('a4', 'portrait');
        
        return $pdf->stream();   
    }
}
