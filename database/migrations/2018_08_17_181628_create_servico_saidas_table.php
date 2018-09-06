<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicoSaidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servico_saidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_servico');
            $table->foreign('fk_servico')->references('id')->on('servicos');
            $table->integer('fk_solicitacao');
            $table->foreign('fk_solicitacao')->references('id')->on('solicitacaos');
            $table->integer('fk_escala');
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
        Schema::dropIfExists('servico_saidas');
    }
}
