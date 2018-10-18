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

class BaixaItemController extends Controller
{
    public function index()
    {
        return view('baixa_item.index');    
    } 

    public function list()
    {

        $setor = Setor::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($setor)
            ->editColumn('acao', function ($setor){
                return $this->setBtns($setor);
            })->escapeColumns([0])
            ->make(true);

       
    }

    private function setBtns(setor $setors){
        $dados = "data-id_del='$setors->id' data-id='$setors->id' data-nome='$setors->nome' data-sigla='$setors->sigla' data-email='$setors->email' data-telefone='$setors->telefone'";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver setor' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar setor' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar setor' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome' => 'required',
            'sigla' => 'required',
            'telefone' => 'required',
            'email' => 'required'
        );
        $attributeNames = array(
            'nome' => 'Nome',
            'sigla' => 'Sigla',
            'email' => 'E-mail',
            'telefone' => 'Telefone'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else {

            $setor = new Setor();
            $setor->nome = $request->nome;
            $setor->sigla = $request->sigla;
            $setor->email = $request->email;
            $setor->telefone = $request->telefone;
            $setor->status = 'Ativo';
            $setor->save();
            
            return response()->json($setor);
        }
    }

    public function update(Request $request)
    {
        $setor = Setor::find($request->id);
        $setor->nome = $request->nome;
        $setor->sigla = $request->sigla;
        $setor->email = $request->email;
        $setor->telefone = $request->telefone;
        $setor->save();

        return response()->json($setor);
    }

    public function destroy(Request $request)
    {
        $setor = Setor::find($request->id_del);
        $setor->status = 'Inativo';
        $setor->save();

        return response()->json($setor);
    }
}
