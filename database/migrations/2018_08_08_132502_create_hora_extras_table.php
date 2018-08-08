<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoraExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('hora_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('horas_excedidas');
            $table->date('dia');
            $table->integer('id_servidor')->unsigned();
            $table->foreign('id_servidor')->references('id')->on('servidors');
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
        Schema::dropIfExists('hora_extras');
    }
}
