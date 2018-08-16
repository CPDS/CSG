<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitacaoServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacao_servicos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_solicitacao');
            $table->date('data_realizacao');
            $table->integer('fk_servidor')->nullable();
            $table->foreign('fk_servidor')->references('id')->on('servidors');
            $table->integer('fk_setor')->unsigned();
            $table->foreign('fk_setor')->references('id')->on('setors');
            $table->integer('fk_user')->unsigned();
            $table->foreign('fk_user')->references('id')->on('users');
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
        Schema::dropIfExists('solicitacao_servicos');
    }
}
