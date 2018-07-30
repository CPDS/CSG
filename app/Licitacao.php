<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Licitacao extends Model
{
     protected $fillable = ['numero','termo_aditivo','modalidade'];
}
