<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['nome','valor_unitario','valor_total','quantidade','id_licitacao'];
}
