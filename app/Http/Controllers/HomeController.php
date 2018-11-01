<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialEntrada;
use App\MaterialSaida;
use App\Solicitacao;

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

        return view('dashboard.index',compact('material','solicitacao'));
    }
}
