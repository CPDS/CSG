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
            $table->time('horario_pausa');
            $table->time('horario_pos_pausa');
            $table->time('horario_termino');
            $table->integer('id_servidor')->unsigned();
            $table->foreign('id_servidor')->references('id')->on('servidors');
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
