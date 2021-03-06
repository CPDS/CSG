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
            $table->string('titulo')->nullable();
            $table->string('descricao')->nullable();
            $table->date('data_solicitacao');
            $table->string('observacao_solicitado')->nullable();
            $table->string('observacao_solicitante')->nullable();
            $table->string('enviado')->nullable();
            $table->integer('fk_user_solicitante')->unsigned();
            $table->foreign('fk_user_solicitante')->references('id')->on('users');   
            $table->string('status')->nullable();
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
