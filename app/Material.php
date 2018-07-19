<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['nome','colaborador','bens', 'n_licitacao','termo_aditivo','modalidade',
    						'valor_licitacao','valor_unitario'
    					];
}
