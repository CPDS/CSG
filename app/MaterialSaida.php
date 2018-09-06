<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialSaida extends Model
{
    protected $fillable = ['quantidade','fk_solicitacao','fk_material'];
}
