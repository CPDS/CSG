<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscalaHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('escala_horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->time('horario_inicio');
            $table->time('horario_termino'); 
            $table->time('horario_inicio_tarde');
            $table->time('horario_termino_tarde');
            $table->string('dia_semana');
            $table->integer('fk_user')->unsigned();
            $table->foreign('fk_user')->references('id')->on('users');  
            $table->integer('fk_setor')->unsigned();
            $table->foreign('fk_setor')->references('id')->on('setors');
            $table->string('status');       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escala_horarios');
    }
}
