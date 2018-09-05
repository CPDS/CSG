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
use App\Servico;
use App\Material;
use App\User;
use App\Solicitacao;
use App\SolicitacaoTipo;

class SolicitacaoController extends Controller
{
    public function index()
    {

        $users = User::JOIN('escala_horarios','escala_horarios.fk_user','=','users.id')
            ->where('users.status','Ativo')
            ->where('escala_horarios.status','Ativo')
            ->select('users.id','users.name','escala_horarios.id as fk_escala')
            ->get();

        $solicitacao_tipos = SolicitacaoTipo::where('status','Ativo')->get();
        $servicos = Servico::where('status','Ativo')->get();
        $materiais = Material::where('status','Ativo')->get();

        return view('solicitacao.index',compact('users','solicitacao_tipos','servicos','materiais'));    
    } 

    public function list()
    {
		//'data_solicitacao','data_realizacao', 'nome_setor','nome_servidor','codigo_material','descricao_material','quantidade'
        $solicitacao = Solicitacao::orderBy('created_at', 'desc')
        ->where('status','Ativo')->get();
        /*
        $solicitacao = Solicitacao::JOIN('setors','solicitacaos.fk_setor','=','setors.id')
        ->JOIN('servidors','solicitacaos.fk_servidor','=','servidors.id')
        ->JOIN('servico_materials','servico_materials.fk_solicitacao','=','solicitacaos.id')
        ->JOIN('materials','servico_materials.fk_material','=','materials.id')
        ->where('solicitacaos.status','Ativo')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.data_realizacao','solicitacaos.fk_servidor','solicitacaos.fk_setor','setors.nome as nome_setor','servidors.nome as nome_servidor',
        	'servico_materials.quantidade','materials.descricao as descricao_material','materials.codigo as codigo_material'
    )

        ->orderBy('solicitacaos.created_at', 'desc')->get();
*/
        return DataTables::of($solicitacao)
            ->editColumn('acao', function ($solicitacao){
                return $this->setBtns($solicitacao);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Solicitacao $solicitacaos){
        $dados = "data-id_del='$solicitacaos->id' data-id='$solicitacaos->id' data-descricao='$solicitacaos->descricao' ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar solicitacao' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar solicitacao' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'data_solicitacao' => 'required',
            'fk_servidor' => 'required',
            'fk_setor' => 'required'
        );
        $attributeNames = array(
            'data_solicitacao' => 'Data da solicitação',
            'fk_servidor' => 'Servidor',
            'fk_setor' => 'Setor'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else { 
            $data = date("Y-m-d");

            $solicitacao = new Solicitacao();
            $solicitacao->data_solicitacao = $request->data_solicitacao;
            $solicitacao->data_realizacao = $request->data_realizacao;
            $solicitacao->fk_servidor = $request->fk_servidor;
            $solicitacao->fk_setor = $request->fk_setor;
            $solicitacao->status = 'Ativo';
            $solicitacao->save();

            $servico_material = new ServicoMaterial();
            $servico_material->quantidade = $request->quantidade;
            $servico_material->fk_material = $request->fk_material;
            $servico_material->fk_solicitacao = $solicitacao->id;
            $servico_material->save();
            
            return response()->json($solicitacao);
        }
    }

    public function update(Request $request)
    {
        $solicitacao = Solicitacao::find($request->id);
        $solicitacao->data_solicitacao = $request->data_solicitacao;
        $solicitacao->data_realizacao = $request->data_realizacao;
        $solicitacao->fk_servidor = $request->fk_servidor;
        $solicitacao->fk_setor = $request->fk_setor;
        $solicitacao->save();
        
        return response()->json($solicitacao);
    }

    public function destroy(Request $request)
    {
        $solicitacao = Solicitacao::find($request->id_del);
        $solicitacao->status = 'Inativo';
        $solicitacao->save();

        return response()->json($solicitacao);
    }
}
