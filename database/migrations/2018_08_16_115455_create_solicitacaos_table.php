<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('solicitacaos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('local_servico');
            $table->string('titulo');
            $table->string('descricao');
            $table->date('data_solicitacao');
            $table->string('observacao_solicitado');
            $table->string('observacao_solicitante');
            $table->integer('fk_user_solicitante')->unsigned();
            $table->foreign('fk_user_solicitante')->references('id')->on('users');
            $table->integer('fk_user_solicitado')->unsigned();
            $table->foreign('fk_user_solicitado')->references('id')->on('users');
            $table->integer('fk_solicitacao_tipo')->unsigned();
            $table->foreign('fk_solicitacao_tipo')->references('id')->on('solicitacao_tipos');    
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
        Schema::dropIfExists('solicitacaos');
    }
}
