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
use App\Servidor;
use App\HoraExtra;

class HoraExtraController extends Controller
{
    public function index()
    {
        $servidores = Servidor::where('status','Ativo')->get();
        return view('hora_extra.index',compact('servidores'));    
    } 

    public function list()
    {
        
        $hora_extra = HoraExtra::JOIN('servidors','hora_extras.fk_servidor','=','servidors.id')
        ->where('hora_extras.status','Ativo')
        ->select('hora_extras.id','hora_extras.horas_excedidas','hora_extras.dia','servidors.nome as nome_servidor', 'servidors.id as fk_servidor')
        ->orderBy('hora_extras.created_at', 'desc')->get();


        return DataTables::of($hora_extra)
            ->editColumn('acao', function ($hora_extra){
                return $this->setBtns($hora_extra);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(HoraExtra $hora_extras){
        $dados = "data-id_del='$hora_extras->id' data-id='$hora_extras->id' data-horas_excedidas='$hora_extras->horas_excedidas' data-dia='$hora_extras->dia' data-nome_servidor='$hora_extras->nome_servidor' data-fk_servidor='$hora_extras->fk_servidor' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver hora_extra' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar hora_extra' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar hora_extra' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {  
        $rules = array(
            'horas_excedidas' => 'required',
            'dia' => 'required',
            'fk_servidor' => 'required'
        );
        $attributeNames = array(
            'horas_excedidas' => 'Horas excedidasd',
            'dia' => 'Dia',
            'fk_servidor' => 'required'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {
            $hora_extra = new HoraExtra();
            $hora_extra->horas_excedidas = $request->horas_excedidas;
            $hora_extra->dia = $request->dia;
            $hora_extra->fk_servidor = $request->fk_servidor;
            $hora_extra->status = 'Ativo';
            $hora_extra->fk_user = Auth::User()->id;
            $hora_extra->save();
            
            return response()->json($hora_extra);
        }
    }

    public function update(Request $request)
    {
        $hora_extra = HoraExtra::find($request->id);
        $hora_extra->horas_excedidas = $request->horas_excedidas;
        $hora_extra->dia = $request->dia;
        $hora_extra->fk_servidor = $request->fk_servidor;
        $hora_extra->save();

        return response()->json($hora_extra);
    }

    public function destroy(Request $request)
    {
        $hora_extra = HoraExtra::find($request->id_del);
        $hora_extra->status = 'Inativo';
        $hora_extra->save();

        return response()->json($hora_extra);
    }
}
