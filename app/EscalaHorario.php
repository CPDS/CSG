<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalaHorario extends Model
{
    
    protected $fillable = ['horario_inicio','horario_pausa','horario_pos_pausa','horario_termino','fk_servidor'];

}
