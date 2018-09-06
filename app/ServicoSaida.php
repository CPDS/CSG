<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicoSaida extends Model
{
     protected $fillable = ['fk_servico','fk_solicitacao','fk_escala','status'];
}
