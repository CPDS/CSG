<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContratoItem extends Model
{
    protected $fillable = ['fk_item','fk_contrato','quantidade']; 
}
