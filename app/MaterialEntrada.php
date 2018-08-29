<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialEntrada extends Model
{
    protected $fillable = ['quantidade','fk_user','fk_material'];
}
