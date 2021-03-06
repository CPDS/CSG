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
use App\ServicoSolicitacao;
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
        ->select('solicitacaos.id','solicitacaos.data_solicitacao','solicitacaos.titulo','solicitacaos.descricao as descricao_solicitacao','solicitacaos.observacao_solicitado','solicitacaos.observacao_solicitante')
        ->orderBy('solicitacaos.created_at', 'desc')
        ->where('solicitacaos.status','!=','Inativo')->get();

        return DataTables::of($solicitacaos)
            ->editColumn('acao', function ($solicitacaos){
                return $this->setBtns($solicitacaos);
            })->escapeColumns([0])
            ->make(true);
    }

    private function setBtns(Solicitacao $solicitacaos){
        $dados = "
        data-id_del='$solicitacaos->id' 
        data-id='$solicitacaos->id' 
        data-descricao_solicitacao='$solicitacaos->descricao_solicitacao'  
        data-titulo='$solicitacaos->titulo' 
        data-observacao_solicitado='$solicitacaos->observacao_solicitado' 
        data-observacao_solicitante='$solicitacaos->observacao_solicitante'
        data-quantidade='$solicitacaos->quantidade' 
         ";

        $btnEditar = '';
        $btnDeletar = '';

        $btnVer = "<a class='btn btn-info btn-sm btnVer' data-toggle='tooltip' title='Ver solicitacao' $dados> <i class='fa fa-eye'></i></a> ";

        if(Auth::user()->can('editar-solicitacao')){
            $btnEditar = "<a class='btn btn-primary btn-sm btnEditar' data-toggle='tooltip' title='Editar solicitacao' $dados> <i class='fa fa-edit'></i></a> ";
        }
        if(Auth::user()->can('excluir-solicitacao')){
            $btnDeletar = "<a class='btn btn-danger btn-sm btnDeletar' data-toggle='tooltip' title='Deletar solicitacao' $dados><i class='fa fa-trash'></i></a>";
        }


        return $btnVer.$btnEditar.$btnDeletar;
    }

    public function store(Request $request)
    {   
        $rules = array(
            'titulo' => 'required'
        );
        $attributeNames = array(
            'titulo' => 'Título'
        );
        
        $validator = Validator::make(Input::all(), $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()){
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        }else { 
            $data = date("Y-m-d");

            $dados = explode(',',$request->fk_user);

            $solicitacao = new Solicitacao();
            $solicitacao->titulo = $request->titulo;
            $solicitacao->descricao = $request->descricao;
            $solicitacao->data_solicitacao = $data;
            $solicitacao->observacao_solicitado = $request->observacao_solicitado;
            $solicitacao->observacao_solicitante = $request->observacao_solicitante;
            $solicitacao->fk_user_solicitante = Auth::User()->id;
            $solicitacao->status = $request->status;

            $solicitacao->save();

            if (isset($request->materiais))
            {
                foreach ($request->materiais as $value) {   
                    $material_saida = new MaterialSaida();
                    $material_saida->quantidade = $value['quantidade'];
                    $material_saida->fk_material = $value['fk_material'];
                    $material_saida->fk_solicitacao = $solicitacao->id;
                    $material_saida->save();
                }
            }

            if (isset($request->servicos))
            {
                foreach ($request->servicos as $value) {   
                    $servico_solicitacao = new ServicoSolicitacao();
                    $servico_solicitacao->fk_servico = $value;
                    $servico_solicitacao->fk_solicitacao = $solicitacao->id;
                    $servico_solicitacao->save();
                }
            }
            
            return response()->json($solicitacao);
        }
    }

     public function materiais($id)
    {

        $itens = Solicitacao::LEFTJOIN('material_saidas','material_saidas.fk_solicitacao','=','solicitacaos.id')
            ->LEFTJOIN('materials','materials.id','=','material_saidas.fk_material')
            ->select('materials.id','material_saidas.quantidade', 'materials.descricao')
            ->orderBy('solicitacaos.created_at', 'desc')
            ->where('solicitacaos.id',$id)
            ->get();

        return response()->json(['data'=>$itens]);
    }

    public function update(Request $request)
    {
        $solicitacao = Solicitacao::find($request->id);  
        $solicitacao->titulo = $request->titulo;
        $solicitacao->descricao = $request->descricao;
        $solicitacao->save();

        DB::table("material_saidas")->where("material_saidas.fk_solicitacao",$request->id)
                ->delete();

        if(isset($request->materiais)){        
            foreach ($request->materiais as $value) {   
                $material_saida = new MaterialSaida();
                $material_saida->quantidade = $value['quantidade'];
                $material_saida->fk_material = $value['fk_material'];
                $material_saida->fk_solicitacao = $solicitacao->id;
                $material_saida->save();
            }
        }

        DB::table("servico_solicitacaos")->where("servico_solicitacaos.fk_solicitacao",$request->id)
                ->delete();

        if(isset($request->servicos)){ 
            foreach ($request->servicos as $value) {   
                $servico_solicitacao = new ServicoSolicitacao();
                $servico_solicitacao->fk_servico = $value;
                $servico_solicitacao->fk_solicitacao = $solicitacao->id;
                $servico_solicitacao->save();
            }
        }        
        
        return response()->json($solicitacao);
    }

    public function destroy(Request $request)
    {
        $solicitacao = Solicitacao::find($request->id_del);
        $solicitacao->status = 'Inativo';
        $solicitacao->save();

        dd($solicitacao->status);

        return response()->json($solicitacao);
    }
}
