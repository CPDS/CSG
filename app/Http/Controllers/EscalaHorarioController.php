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
use App\Servidor;
use App\EscalaHorario;


class EscalaHorarioController extends Controller
{
    public function index()
    {
        $servidores = Servidor::where('status','Ativo')->get();
        return view('escala_horario.index',compact('servidores'));    
    } 

    public function list()
    {
        
        $escala_horario = EscalaHorario::JOIN('servidors','escala_horarios.id_servidor','=','servidors.id')
        ->where('escala_horarios.status','Ativo')
        ->select('escala_horarios.id','escala_horarios.horario_inicio','escala_horarios.horario_pausa','escala_horarios.horario_pos_pausa','escala_horarios.horario_termino', 'servidors.nome as nome_servidor', 'servidors.id as id_servidor')
        ->orderBy('escala_horarios.created_at', 'desc')->get();


        return DataTables::of($escala_horario)
            ->editColumn('acao', function ($escala_horario){
                return $this->setBtns($escala_horario);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(EscalaHorario $escala_horarios){
        $dados = "data-id_del='$escala_horarios->id' data-id='$escala_horarios->id' data-horario_inicio='$escala_horarios->horario_inicio' data-horario_pausa='$escala_horarios->horario_pausa' data-horario_pos_pausa='$escala_horarios->horario_pos_pausa' data-horario_termino='$escala_horarios->horario_termino' data-nome_servidor='$escala_horarios->nome_servidor' data-id_servidor='$escala_horarios->id_servidor' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver escala_horario' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar escala_horario' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar escala_horario' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'horario_inicio' => 'required',
            'horario_pausa' => 'required',
            'horario_pos_pausa' => 'required',
            'horario_termino' => 'required',
            'id_servidor' => 'required'
        );
        $attributeNames = array(
            'horario_inicio' => 'Horário início',
            'horario_pausa' => 'Horário pausa',
            'horario_pos_pausa' => 'Horário pós pausa',
            'horario_termino' => 'Horário término',
            'id_servidor' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $escala_horario = new EscalaHorario();
            $escala_horario->horario_inicio = $request->horario_inicio;
            $escala_horario->horario_pausa = $request->horario_pausa;
            $escala_horario->horario_pos_pausa = $request->horario_pos_pausa;
            $escala_horario->horario_termino = $request->horario_termino;
            $escala_horario->id_servidor = $request->id_servidor;
            $escala_horario->status = 'Ativo';
            $escala_horario->save();
            
            return response()->json($escala_horario);
        }
    }

    public function update(Request $request)
    {
        $escala_horario = EscalaHorario::find($request->id);
        $escala_horario->horario_inicio = $request->horario_inicio;
        $escala_horario->horario_pausa = $request->horario_pausa;
        $escala_horario->horario_pos_pausa = $request->horario_pos_pausa;
        $escala_horario->horario_termino = $request->horario_termino;
        $escala_horario->id_servidor = $request->id_servidor;
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
