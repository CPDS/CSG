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
use DB;

class RelatorioController extends Controller
{
    public function saidaDeItens(){
        
        $solicitacaos = Solicitacao::JOIN('users','users.id','=','solicitacaos.fk_user_solicitante')
        ->LEFTJOIN('material_saidas','material_saidas.fk_solicitacao','=','solicitacaos.id')
        ->LEFTJOIN('materials','materials.id','=','material_saidas.fk_material')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante',
            'material_saidas.quantidade as quantidade_solicitada','material_saidas.status' ,'materials.descricao as descricao_material','materials.id as id_material', 'material_saidas.id as id_material_saida','material_saidas.quantidade_atendida')
        ->orderBy('solicitacaos.created_at', 'desc')->get();
   
        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('baixa_item.relatorio', ['solicitacaos' => $solicitacaos]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream(); 
    }

    public function usuarios(){
        $usuarios = User::LEFTJOIN('setors','users.fk_setor','=','setors.id')
        ->JOIN('model_has_roles','model_has_roles.model_id','=','users.id')
        ->JOIN('roles','model_has_roles.role_id','=','roles.id')
        ->where('users.status','Ativo')
        ->select('users.id','users.name as nome_user','users.cpf','users.telefone','users.endereco','setors.nome as nome_setor','setors.sigla','users.email', 'setors.id as fk_setor','roles.name as nome_role' , 'users.cpf', 'users.cnpj', 'users.responsavel', 'users.contato')
        ->orderBy('users.created_at', 'desc')->get();
        
        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('user.relatorio', ['usuarios' => $usuarios]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();   
    }

    public function contratos(){
        $contratos = Contrato::leftjoin('contrato_items','contrato_items.fk_contrato','=','contratos.id')
        ->leftjoin('item_contratos','item_contratos.id','=','contrato_items.fk_item')
        ->select('contratos.*','contrato_items.quantidade as quantidade','item_contratos.nome as item','contrato_items.fk_item', 'contrato_items.valor_unitario as valor')
        ->where('contratos.status','Ativo')
        ->orderBy('contratos.id', 'asc')
        ->get();

        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('contrato.relatorio', ['contratos' => $contratos]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();
    }

    public function escalas(Request $request){

        $escala_horarios = EscalaHorario::JOIN('users','escala_horarios.fk_user','=','users.id')
        ->JOIN('setors','setors.id','=','escala_horarios.fk_setor')
        ->select('escala_horarios.*','escala_horarios.horario_termino','escala_horarios.dia_semana', 'users.name as nome_funcionario', 'users.id as fk_user','setors.nome as nome_setor' , 'escala_horarios.fk_setor');  

        if(isset($request->funcionariosEscala))
        {
           $escala_horarios = $escala_horarios->where('escala_horarios.fk_user',$request->funcionarios);  
        }
        if(isset($request->dia))
        {
           $escala_horarios = $escala_horarios->where('escala_horarios.dia_semana','like',$request->dia);  
        }
        if(isset($request->setoresEscala))
        {
           $escala_horarios = $escala_horarios->where('escala_horarios.fk_setor',$request->setores);  
        }
        $escala_horarios = $escala_horarios->where('escala_horarios.status','Ativo')->orderBy('escala_horarios.created_at', 'desc')->get();
        
        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('user.relatorio_escalas', ['escala_horarios' => $escala_horarios]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();  
    }

    public function horas(Request $request){
        $horas_extras = HoraExtra::JOIN('users','hora_extras.fk_user','=','users.id')
        ->select('hora_extras.*','users.name as nome_funcionario', 'users.id');

        if(isset($request->funcionariosHora))
        {
           $horas_extras = $horas_extras->where('hora_extras.fk_user',$request->funcionariosHora);  
        }
        if(isset($request->dataIni))
        {
           $horas_extras = $horas_extras->where('hora_extras.dia','>=',$request->dataIni);  
        }
        if(isset($request->dataFim))
        {
           $horas_extras = $horas_extras->where('hora_extras.dia','<=',$request->dataFim);  
        }

        $horas_extras = $horas_extras->where('hora_extras.status','Ativo')->orderBy('hora_extras.created_at', 'desc')->get();
        
        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('user.relatorio_horas', ['horas_extras' => $horas_extras]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();
    }

    public function materials(Request $request)
    {
        $entradas =  Material::LEFTJOIN('material_entradas','material_entradas.fk_material','=','materials.id')
        ->LEFTJOIN('material_saidas','material_saidas.fk_material','=','materials.id');

        if(isset($request->tipoRel) and $request->tipoRel == "resumido")
        {
            $materials = $materials->select('materials.*',DB::raw('SUM(material_entradas.quantidade) as entrada'),DB::raw('SUM(material_saidas.quantidade) as saida'))->groupBy('materials.id');
        }
        else
        {
            $materials = $materials->select('materials.*','material_entradas.quantidade as entrada','material_saidas.quantidade as saida');
        }
        if(isset($request->materiais))
            $materials = $materials->where('materials.id',$request->materiais);
        if(isset($request->tipoMov))
        {
            if($request->tipoMov == "entrada")
            {
                $materials = $materials->where('material_saidas.id',null);                
            }
            else
            {
                $materials = $materials->where('material_entradas.id',null);
            }
        }

        $materials = $materials->where('materials.status','Ativo')
                     ->orderBy('created_at','asc');

        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('material.relatorio_material', ['materials' => $entradas]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();  
    }

    public function setores(){
        $setores = Setor::orderBy('created_at', 'desc')->where('status','Ativo')->get();
        
        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('setor.relatorio', ['setores' => $setores]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();  
    }

    public function solicitacoes(){

        $solicitacaos = Solicitacao::JOIN('users','users.id','=','solicitacaos.fk_user_solicitante')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante')
        ->orderBy('solicitacaos.created_at', 'desc')->get();
        
        $footer = \View::make('relatorios.footer')->render();
        $header = \View::make('relatorios.header')->render();

        $pdf = PDF::loadView('solicitacao.relatorio', ['solicitacaos' => $solicitacaos]);
        $pdf->setPaper('a4')->setOption('header-html',$header)->setOption('footer-html',$footer);
        return $pdf->stream();
    }
}
