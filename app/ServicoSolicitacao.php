<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicoSolicitacao extends Model
{
    protected $fillable = ['fk_solicitacao','fk_servico'];    
}
