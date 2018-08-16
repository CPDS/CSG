<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    protected $fillable = ['nome','rg','cargo','fk_setor'];
}
