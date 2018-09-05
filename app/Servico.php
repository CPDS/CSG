<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
	protected $fillable = ['fk_user','nome','status'];    
}
