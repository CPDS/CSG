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
use App\ServicoMaterial;
use App\Setor;
use App\Material;
use App\Servidor;
use App\SolicitacaoServico;

class SolicitacaoServicoController extends Controller
{
    public function index()
    {

        $setores = Servidor::where('status','Ativo')->get();
        $servidores = Servidor::where('status','Ativo')->get();
        $materiais = Material::where('status','Ativo')->get();
        return view('solicitacao_servico.index',compact('setores','servidores','materiais'));    
    } 

    public function list()
    {
		//'data_solicitacao','data_realizacao', 'nome_setor','nome_servidor','codigo_material','descricao_material','quantidade'

        $solicitacao_servico = SolicitacaoServico::JOIN('setors','solicitacao_servicos.fk_setor','=','setors.id')
        ->JOIN('servidors','solicitacao_servicos.fk_servidor','=','servidors.id')
        ->JOIN('servico_materials','servico_materials.fk_solicitacao_servico','=','solicitacao_servicos.id')
        ->JOIN('materials','servico_materials.fk_material','=','materials.id')
        ->where('solicitacao_servicos.status','Ativo')
        ->select('solicitacao_servicos.id','solicitacao_servicos.data_solicitacao','solicitacao_servicos.data_realizacao','solicitacao_servicos.fk_servidor','solicitacao_servicos.fk_setor','setors.nome as nome_setor','servidors.nome as nome_servidor',
        	'servico_materials.quantidade','materials.descricao as descricao_material','materials.codigo as codigo_material'
    )
        ->orderBy('solicitacao_servicos.created_at', 'desc')->get();

        return DataTables::of($solicitacao_servico)
            ->editColumn('acao', function ($solicitacao_servico){
                return $this->setBtns($solicitacao_servico);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(SolicitacaoServico $solicitacao_servicos){
        $dados = "data-id_del='$solicitacao_servicos->id' data-id='$solicitacao_servicos->id' data-data_solicitacao='$solicitacao_servicos->data_solicitacao' data-data_realizacao='$solicitacao_servicos->data_realizacao' data-fk_setor='$solicitacao_servicos->fk_setor' data-fk_servidor='$solicitacao_servicos->fk_servidor' data-nome_servidor='$solicitacao_servicos->nome_servidor' data-nome_setor='$solicitacao_servicos->nome_setor' data-quantidade='$solicitacao_servicos->quantidade' data-descricao_material='$solicitacao_servicos->descricao_material' data-codigo_material=$solicitacao_servicos->codigo_material ";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao_servico' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar solicitacao_servico' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar solicitacao_servico' $dados><i class='fa fa-trash'></i></a>";


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

            $solicitacao_servico = new SolicitacaoServico();
            $solicitacao_servico->data_solicitacao = $request->data_solicitacao;
            $solicitacao_servico->data_realizacao = $request->data_realizacao;
            $solicitacao_servico->fk_servidor = $request->fk_servidor;
            $solicitacao_servico->fk_setor = $request->fk_setor;
            $solicitacao_servico->status = 'Ativo';
            $solicitacao_servico->save();

            $servico_material = new ServicoMaterial();
            $servico_material->quantidade = $request->quantidade;
            $servico_material->fk_material = $request->fk_material;
            $servico_material->fk_solicitacao_servico = $solicitacao_servico->id;
            $servico_material->save();
            
            return response()->json($solicitacao_servico);
        }
    }

    public function update(Request $request)
    {
        $solicitacao_servico = SolicitacaoServico::find($request->id);
        $solicitacao_servico->data_solicitacao = $request->data_solicitacao;
        $solicitacao_servico->data_realizacao = $request->data_realizacao;
        $solicitacao_servico->fk_servidor = $request->fk_servidor;
        $solicitacao_servico->fk_setor = $request->fk_setor;
        $solicitacao_servico->save();
        
        return response()->json($solicitacao_servico);
    }

    public function destroy(Request $request)
    {
        $solicitacao_servico = SolicitacaoServico::find($request->id_del);
        $solicitacao_servico->status = 'Inativo';
        $solicitacao_servico->save();

        return response()->json($solicitacao_servico);
    }
}
