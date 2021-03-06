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
use App\Permission;
use App\AlocacaoFuncionario;
use App\ModelHasPermission;
use App\Role;


class UserController extends Controller
{
    public function index()
    {
        $setores = Setor::where('status','Ativo')->get();
        return view('user.index',compact('setores'));    
    }  

    public function funcionarios()
    {
        $users =  User::where('status','Ativo')->get();
        return response()->json($users);
    }


    public function permissions()
    {
        $permissions = Permission::all();
        $models = Role::all();

        return view('user.permission',compact('permissions','models'));    
    }

    public function getPermissions($papel)
    {
        $permissions = ModelHasPermission::where('model_id',$papel)->get();

        return response()->json(['data' => $permissions ]);    
    }

    public function createPermissions(Request $request){
       
        ModelHasPermission::where('model_id',$request->fk_model)->delete();

        foreach ($request->permissao as $value) {
            $ModelHasPermission = new ModelHasPermission();
            $ModelHasPermission->permission_id = $value;
            $ModelHasPermission->model_id = $request->fk_model;
            $ModelHasPermission->model_type = 'App\User';
            $ModelHasPermission->save();
        }

        return response()->json($ModelHasPermission);
    } 

    public function list()
    {

        $user = User::LEFTJOIN('setors','users.fk_setor','=','setors.id')
        ->JOIN('model_has_roles','model_has_roles.model_id','=','users.id')
        ->JOIN('roles','model_has_roles.role_id','=','roles.id')
        ->where('users.status','Ativo')
        ->select('users.id','users.name as nome_user','users.cpf','users.telefone','users.endereco','setors.nome as nome_setor','setors.sigla','users.email', 'setors.id as fk_setor','roles.name as nome_role' , 'users.cpf', 'users.cnpj', 'users.responsavel', 'users.contato')
        ->orderBy('users.created_at', 'desc')->get();


        return DataTables::of($user)
            ->editColumn('acao', function ($user){
                return $this->setBtns($user);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(User $users){
        $dados = "data-id_del='$users->id' 
        data-id='$users->id' 
        data-nome_user='$users->nome_user' 
        data-cpf='$users->cpf' 
        data-cnpj='$users->cnpj' 
        data-responsavel='$users->responsavel' 
        data-contato='$users->contato' 
        data-telefone='$users->telefone' 
        data-email='$users->email' 
        data-fk_setor='$users->fk_setor' 
        data-endereco='$users->endereco' 
        data-nome_role='$users->nome_role' 
        data-nome_setor='$users->nome_setor' 
        data-sigla='$users->sigla' ";

        $btnEditar = '';
        $btnDeletar = '';

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver user' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar user' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar user' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;
    }

    private function validar_cpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
        // Valida tamanho
        if (strlen($cpf) != 11)
            return false;
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ((integer)$cpf{10} == ($resto < 2 ? 0 : 11 - $resto))
            return true;
        else
            return false;
    }
    function validar_cnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

    public function store(Request $request)
    { 
        $rules = array(
            'nome_role' => 'required',
            'nome_user' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'email' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        );
        if ($request->nome_role == "Empresa")
            $rules = $rules + ['cnpj' => 'required|unique:users,cnpj,null,id',];
        else
            $rules = $rules + ['cpf' => 'required|unique:users,cpf,null,id',];
        $attributeNames = array(
            'nome_role' => 'Tipo',
            'nome_user' => 'Nome',
            'telefone' => 'Telefone',
            'cpf' => 'CPF',
            'cnpj' => 'CNPJ',
            'endereco' => 'Endereco',
            'email' => 'E-mail',
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if (!$this->validar_cpf($request->cpf) and !$this->validar_cnpj($request->cnpj)) {
                return Response::json(array('errors' => ['CPF/CNPJ Inválido']));
        }
        else if ($validator->fails())
        {
           return Response::json(array('errors' => $validator->getMessageBag()->toArray())); 
        }
        else { 

            $data = date("Y-m-d");
 
            $user = new user();
            $user->name = $request->nome_user;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->cpf = $request->cpf;
            $user->telefone = $request->telefone;
            $user->endereco = $request->endereco;
            $user->fk_setor = $request->fk_setor;
            $user->cnpj = $request->cnpj;
            $user->responsavel = $request->responsavel;
            $user->contato = $request->contato;
            $user->status = 'Ativo';
            $user->save();

            $user->assignRole($request->nome_role);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'nome_role' => 'required',
            'nome_user' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'email' => 'required',
            //'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            //'password_confirmation' => 'min:6',
        );                
        if ($request->nome_role == "Empresa")
            $rules = $rules + ['cnpj' => 'required|unique:users,cnpj,' . $request->id.',id',];
        else
            $rules = $rules + ['cpf' => 'required|unique:users,cpf,' . $request->id.',id',];
        // dd($rules);
        $attributeNames = array(
            'nome_role' => 'Tipo',
            'nome_user' => 'Nome',
            'telefone' => 'Telefone',
            'cpf' => 'CPF',
            'cnpj' => 'CNPJ',
            'endereco' => 'Endereco',
            'email' => 'E-mail',
        );

        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if (!$this->validar_cpf($request->cpf) and !$this->validar_cnpj($request->cnpj)) {
                return Response::json(array('errors' => ['CPF/CNPJ Inválido']));
        }
        else if ($validator->fails())
        {
           return Response::json(array('errors' => $validator->getMessageBag()->toArray())); 
        }
        else { 

            $data = date("Y-m-d");
 
            $user = User::find($request->id);
            $user->name = $request->nome_user;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->cpf = $request->cpf;
            $user->telefone = $request->telefone;
            $user->endereco = $request->endereco;
            $user->fk_setor = $request->fk_setor;
            $user->cnpj = $request->cnpj;
            $user->responsavel = $request->responsavel;
            $user->contato = $request->contato;
            $user->status = 'Ativo';
            $user->save();

            $user->removeRole($user->getRoleNames()[0]);
            $user->assignRole($request->nome_role);
        }
    }

    public function destroy(Request $request)
    {
        $user = user::find($request->id_del);
        $user->status = 'Inativo';
        $user->save();

        return response()->json($user);
    }
}
