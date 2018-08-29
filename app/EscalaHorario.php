<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EscalaHorario extends Model
{
    
    protected $fillable = ['horario_inicio','horario_termino','dia_semana','fk_user','fk_setor'];

}
