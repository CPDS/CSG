<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $fillable = ['data_solicitacao','data_realizacao','fk_servidor','fk_setor','fk_user','status'];
}
