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
use App\Contratada;

class ContratadaController extends Controller
{
     public function index()
    {
        return view('contratada.index');    
    } 

    public function list()
    {

        $contratada = contratada::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($contratada)
            ->editColumn('acao', function ($contratada){
                return $this->setBtns($contratada);
            })->escapeColumns([0])
            ->make(true);

        
        return DataTables::of($contratada)
            ->editColumn('acao', function ($contratada){
                return $this->setBtns($contratada);
            });
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(contratada $contratadas){
        $dados = "data-id_del='$contratadas->id' data-id='$contratadas->id' data-nome='$contratadas->nome' data-sigla='$contratadas->sigla' data-email='$contratadas->email' data-telefone='$contratadas->telefone'";
        $btnEditar = '';
        $btnDeletar = '';

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver contratada' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar contratada' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar contratada' $dados><i class='fa fa-trash'></i></a>";


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

            $contratada = new contratada();
            $contratada->nome = $request->nome;
            $contratada->sigla = $request->sigla;
            $contratada->email = $request->email;
            $contratada->telefone = $request->telefone;
            $contratada->status = 'Ativo';
            $contratada->save();
            
            return response()->json($contratada);
        }
    }

    public function update(Request $request)
    {
        $contratada = contratada::find($request->id);
        $contratada->nome = $request->nome;
        $contratada->sigla = $request->sigla;
        $contratada->email = $request->email;
        $contratada->telefone = $request->telefone;
        $contratada->save();

        return response()->json($contratada);
    }

    public function destroy(Request $request)
    {
        $contratada = contratada::find($request->id_del);
        $contratada->status = 'Inativo';
        $contratada->save();

        return response()->json($contratada);
    }
}
