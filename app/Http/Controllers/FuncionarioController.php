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
use App\AlocacaoFuncionario;


class FuncionarioController extends Controller
{
    public function index()
    {
        $setores = Setor::where('status','Ativo')->get();
        return view('funcionario.index',compact('setores'));    
    } 

    public function list()
    {

        $user = User::JOIN('setors','users.fk_setor','=','setors.id')
        ->JOIN('model_has_roles','model_has_roles.model_id','=','users.id')
        ->JOIN('roles','model_has_roles.role_id','=','roles.id')
        ->where('users.status','Ativo')
        ->select('users.id','users.name as nome_user','users.rg','users.telefone','users.endereco','setors.nome as nome_setor','setors.sigla','users.email', 'setors.id as fk_setor','roles.name as nome_role')
        ->orderBy('users.created_at', 'desc')->get();

        return DataTables::of($user)
            ->editColumn('acao', function ($user){
                return $this->setBtns($user);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(User $users){
        $dados = "data-id_del='$users->id' data-id='$users->id' data-nome_user='$users->nome_user' data-rg='$users->rg' data-telefone='$users->telefone' data-email='$users->email' data-fk_setor='$users->fk_setor' data-endereco='$users->endereco' data-nome_role='$users->nome_role' data-nome_setor='$users->nome_setor' data-sigla='$users->sigla' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver user' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar user' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar user' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'nome_user' => 'required',
            'rg' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'fk_setor' => 'required'
        );
        $attributeNames = array(
            'nome_user' => 'Nome',
            'rg' => 'RG',
            'telefone' => 'Telefone',
            'endereco' => 'Telefone',
            'fk_setor' => 'Setor'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else { 

            $data = date("Y-m-d");
 
            $user = new user();
            $user->name = $request->nome_user;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->rg = $request->rg;
            $user->telefone = $request->telefone;
            $user->endereco = $request->endereco;
            $user->fk_setor = $request->fk_setor;
            $user->status = 'Ativo';
            $user->save();

            $user->assignRole($request->nome_role);
        }
    }

    public function update(Request $request)
    {
       
        $user = User::find($request->id);


        $role = $user->getRoleNames();

        $user->removeRole($role);

        return response()->json($permissions);

        $user->name = $request->nome_user;
        $user->email = $request->email;
        $user->rg = $request->rg;
        $user->telefone = $request->telefone;
        $user->endereco = $request->endereco;
        $user->fk_setor = $request->fk_setor;
        $user->assignRole($request->nome_role);
        $user->save();
    
       

        
        return response()->json($user);
    }

    public function destroy(Request $request)
    {
        $user = user::find($request->id_del);
        $user->status = 'Inativo';
        $user->save();

        return response()->json($user);
    }
}