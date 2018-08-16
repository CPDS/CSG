<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicoMaterial extends Model
{
    protected $fillable = ['quantidade','fk_solicitacao_servico','fk_material'];
}
