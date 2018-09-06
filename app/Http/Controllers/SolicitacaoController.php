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
use App\MaterialSaida;
use App\ServicoSaida;
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
        $solicitacaos = Solicitacao::JOIN('users','users.id','=','solicitacaos.fk_user_solicitante')
        ->LEFTJOIN('solicitacao_tipos','solicitacaos.id','=','solicitacaos.fk_solicitacao_tipo')
        ->LEFTJOIN('material_saidas','material_saidas.fk_solicitacao','=','solicitacaos.id')
        ->LEFTJOIN('servico_saidas','servico_saidas.fk_solicitacao','=','solicitacaos.id')
        ->LEFTJOIN('servicos','servicos.id','=','servico_saidas.fk_servico')
        ->LEFTJOIN('materials','materials.id','=','material_saidas.fk_material')
        ->where('solicitacaos.status','Ativo')
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.local_servico','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante',
        	'material_saidas.quantidade','materials.descricao as descricao_material')
        ->orderBy('solicitacaos.created_at', 'desc')->get();

        return DataTables::of($solicitacaos)
            ->editColumn('acao', function ($solicitacaos){
                return $this->setBtns($solicitacaos);
            })->escapeColumns([0])
            ->make(true);
    }
//descricao_solicitacao, data_solicitacao, local_servico, titulo, observacao_solicitado, observacao_solicitante, quantidade, descricao_material
    private function setBtns(Solicitacao $solicitacaos){
        $dados = "data-id_del='$solicitacaos->id' 
        data-id='$solicitacaos->id' 
        data-descricao_solicitacao='$solicitacaos->descricao_solicitacao'  
        data-data_solicitacao='$solicitacaos->data_solicitacao 
        data-local_servico='$solicitacaos->local_servico 
        data-titulo='$solicitacaos->titulo 
        data-observacao_solicitado='$solicitacaos->observacao_solicitado 
        data-observacao_solicitante='$solicitacaos->observacao_solicitante 
        data-quantidade='$solicitacaos->quantidade  
        data-descricao_material='$solicitacaos->descricao_material";

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao' $dados> <i class='fa fa-eye'></i></a> ";

        $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar solicitacao' $dados> <i class='fa fa-edit'></i></a> ";

        $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar solicitacao' $dados><i class='fa fa-trash'></i></a>";


        return $btnVer.$btnEditar.$btnDeletar;


    }

    public function store(Request $request)
    {   
        $rules = array(
            'data_solicitacao' => 'required'
        );
        $attributeNames = array(
            'data_solicitacao' => 'Data da solicitação'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
                return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else { 
            $data = date("Y-m-d");

            $dados = explode(',',$request->fk_user);

            $solicitacao = new Solicitacao();
            $solicitacao->local_servico = $request->local_servico;
            $solicitacao->titulo = $request->titulo;
            $solicitacao->descricao = $request->descricao;
            $solicitacao->data_solicitacao = $request->data_solicitacao;
            $solicitacao->observacao_solicitado = $request->observacao_solicitado;
            $solicitacao->observacao_solicitante = $request->observacao_solicitante;
            $solicitacao->fk_user_solicitante = Auth::User()->id;
            $solicitacao->fk_user_solicitado = $dados[0];
            $solicitacao->fk_solicitacao_tipo = $request->fk_solicitacao_tipo;
            $solicitacao->status = 'Ativo';
            $solicitacao->save();

            foreach ($request->materiais as $value) {   
                $material_saida = new MaterialSaida();
                $material_saida->quantidade = $value['quantidade'];
                $material_saida->fk_material = $value['fk_material'];
                $material_saida->fk_solicitacao = $solicitacao->id;
                $material_saida->save();
            }
            $servico_saida = new ServicoSaida();
            $servico_saida->fk_servico = $request->fk_servico;
            $servico_saida->fk_solicitacao = $solicitacao->id;
            $servico_saida->fk_escala = $dados[1];
            $servico_saida->status = 'Solicitado';
            $servico_saida->save();
            
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
