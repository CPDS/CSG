<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = ['numero','valor_total','data_inicio','data_fim'];
}
