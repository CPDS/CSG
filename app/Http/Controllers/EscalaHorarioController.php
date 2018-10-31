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
use App\User;
use App\Setor;
use App\EscalaHorario;


class EscalaHorarioController extends Controller
{
    public function index()
    {
        $setors = Setor::where('status','Ativo')->get();
        $users = User::role(['Servidor','Ag-limpeza'])->where('status','Ativo')->get();
        return view('escala_horario.index',compact('users','setors'));    
    } 

    public function list()
    {
        
        $escala_horario = EscalaHorario::JOIN('users','escala_horarios.fk_user','=','users.id')
        ->JOIN('setors','setors.id','=','escala_horarios.fk_setor')
        ->where('escala_horarios.status','Ativo')
        ->select('escala_horarios.id','escala_horarios.horario_inicio','escala_horarios.dia_semana','escala_horarios.horario_termino', 'users.name as nome_funcionario', 'users.id as fk_user','setors.nome as nome_setor' , 'escala_horarios.fk_setor')
        ->orderBy('escala_horarios.created_at', 'desc')->get();

        return DataTables::of($escala_horario)
            ->editColumn('acao', function ($escala_horario){
                return $this->setBtns($escala_horario);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(EscalaHorario $escala_horarios){
        $dados = "data-id_del='$escala_horarios->id' data-id='$escala_horarios->id' data-horario_inicio='$escala_horarios->horario_inicio' data-dia_semana='$escala_horarios->dia_semana' data-horario_termino='$escala_horarios->horario_termino' data-nome_servidor='$escala_horarios->nome_funcionario' data-fk_user='$escala_horarios->fk_user' data-nome_setor='$escala_horarios->nome_setor' data-fk_setor='$escala_horarios->fk_setor' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver escala_horario' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar escala_horario' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar escala_horario' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'horario_inicio' => 'required',
            'dia_semana' => 'required',
            'horario_termino' => 'required',
            'fk_user' => 'required',
            'fk_setor' => 'required'
        );
        $attributeNames = array(
            'horario_inicio' => 'Horário início',
            'dia_semana' => 'Horário pós pausa',
            'horario_termino' => 'Horário término',
            'fk_user' => 'Funcionário',
            'fk_setor' => 'Setor'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $escala_horario = new EscalaHorario();
            $escala_horario->horario_inicio = $request->horario_inicio;
            $escala_horario->dia_semana = $request->dia_semana;
            $escala_horario->horario_termino = $request->horario_termino;
            $escala_horario->fk_user = $request->fk_user;
            $escala_horario->fk_setor = $request->fk_setor;
            $escala_horario->status = 'Ativo';
            $escala_horario->save();
            
            return response()->json($escala_horario);
        }
    }

    public function update(Request $request)
    {
        $escala_horario = EscalaHorario::find($request->id);
        $escala_horario->horario_inicio = $request->horario_inicio;
        $escala_horario->dia_semana = $request->dia_semana;
        $escala_horario->horario_termino = $request->horario_termino;
        $escala_horario->fk_setor = $request->fk_setor;
        $escala_horario->save();

        return response()->json($escala_horario);
    }

    public function destroy(Request $request)
    {
        $escala_horario = EscalaHorario::find($request->id_del);
        $escala_horario->status = 'Inativo';
        $escala_horario->save();

        return response()->json($escala_horario);
    }
}
