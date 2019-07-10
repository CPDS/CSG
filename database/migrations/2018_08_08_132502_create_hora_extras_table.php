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
            $table->string('local');
            $table->date('dia');
            $table->integer('fk_user')->unsigned();
            $table->foreign('fk_user')->references('id')->on('users')->onDelete('cascade');
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
