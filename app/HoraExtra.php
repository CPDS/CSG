<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoraExtra extends Model
{
	protected $fillable = ['horas_excedidas','dia','fk_user'];
    
}
