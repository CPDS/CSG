<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empenho extends Model
{
    protected $fillable = ['valor','saldo_anterior','status'];

    public function contrato(){
      return $this->belongsTo(Contrato::class,'fk_contrato');
    }
}
