<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlocacaoServidor extends Model
{
   	protected $fillable = ['data','justificativa','status','fk_setor','fk_servidor'];

}
