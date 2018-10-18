<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicoSolicitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servico_solicitacaos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_servico')->unsigned();
            $table->foreign('fk_servico')->references('id')->on('servicos');
            $table->integer('fk_solicitacao')->unsigned();
            $table->foreign('fk_solicitacao')->references('id')->on('solicitacaos');
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
        Schema::dropIfExists('servico_solicitacaos');
    }
}
