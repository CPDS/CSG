<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlocacaoServidorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alocacao_servidors', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->string('justificativa');
            $table->integer('fk_servidor')->unsigned();
            $table->integer('fk_setor')->unsigned();
            $table->foreign('fk_servidor')->references('id')->on('servidors');
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
        Schema::dropIfExists('alocacao_servidors');
    }
}
