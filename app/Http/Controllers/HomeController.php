<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialEntrada;
use App\MaterialSaida;
use App\Material;
use App\Solicitacao;
use App\Contrato;
use App\User;
use App\Setor;
use App\Servico;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entradas = MaterialEntrada::select('quantidade')
                    ->sum('quantidade');
        $saidas = MaterialSaida::select('quantidade')
                    ->sum('quantidade');                    
        $material = $entradas-$saidas;

        $solicitacao = Solicitacao::where('status','')
                       ->select('id')
                       ->count('id'); 
        $contratos = Contrato::select('id')
                        ->count('id'); 
        $usuario = User::where('status','Ativo')
                        ->select('id')
                        ->count('id'); 
        $setor = Setor::select('id')
                        ->count('id'); 
        $materiais = Material::select('id')
                        ->count('id');
        $servicos = Servico::select('id')
                        ->count('id');
        return view('dashboard.index',compact('material','solicitacao','contratos','usuario','setor','materiais','servicos'));
    }
}
