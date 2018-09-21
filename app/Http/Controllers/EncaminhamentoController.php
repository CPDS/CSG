<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncaminhamentoController extends Controller
{
     public function index()
    {
        return view('encaminhamento.index');    
    } 

    public function list()
    {

        $encaminhamento = encaminhamento::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        return DataTables::of($encaminhamento)
            ->editColumn('acao', function ($encaminhamento){
                return $this->setBtns($encaminhamento);
            })->escapeColumns([0])
            ->make(true);

        
        return DataTables::of($encaminhamento)
            ->editColumn('acao', function ($encaminhamento){
                return $this->setBtns($encaminhamento);
            })
            ->editColumn('img', function ($encaminhamento){
                return '<img src="https://www.google.com.br/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwj0v5Pp4szdAhXHXSwKHaSQBr4QjRx6BAgBEAU&url=https%3A%2F%2Fwww.saudedica.com.br%2Fos-beneficios-do-cha-verde-para-saude%2F&psig=AOvVaw2l93Hhx_4KeTS7MIfFUQDc&ust=1537642496133458" />';
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(encaminhamento $encaminhamentos){
        $dados = "data-id_del='$encaminhamentos->id' data-id='$encaminhamentos->id' data-nome='$encaminhamentos->nome' data-sigla='$encaminhamentos->sigla' data-email='$encaminhamentos->email' data-telefone='$encaminhamentos->telefone'";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver encaminhamento' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar encaminhamento' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar encaminhamento' $dados><i class='fa fa-trash'></i></a>";


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

            $encaminhamento = new encaminhamento();
            $encaminhamento->nome = $request->nome;
            $encaminhamento->sigla = $request->sigla;
            $encaminhamento->email = $request->email;
            $encaminhamento->telefone = $request->telefone;
            $encaminhamento->status = 'Ativo';
            $encaminhamento->save();
            
            return response()->json($encaminhamento);
        }
    }

    public function update(Request $request)
    {
        $encaminhamento = encaminhamento::find($request->id);
        $encaminhamento->nome = $request->nome;
        $encaminhamento->sigla = $request->sigla;
        $encaminhamento->email = $request->email;
        $encaminhamento->telefone = $request->telefone;
        $encaminhamento->save();

        return response()->json($encaminhamento);
    }

    public function destroy(Request $request)
    {
        $encaminhamento = encaminhamento::find($request->id_del);
        $encaminhamento->status = 'Inativo';
        $encaminhamento->save();

        return response()->json($encaminhamento);
    }
}
