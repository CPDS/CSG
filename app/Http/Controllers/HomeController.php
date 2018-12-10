<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialEntrada;
use App\MaterialSaida;
use App\Solicitacao;
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

       /*
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.gmail.com
        MAIL_PORT=465
        MAIL_USERNAME=fabricacpds@gmail.com
        MAIL_PASSWORD=Tsi<C0Uh
        MAIL_ENCRYPTION=ssl

        php artisan make:mail SendMailUser

       //Mail::to('marlon.batista02@gmail.com')
        ->send(new SendMailUser());
    */

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
