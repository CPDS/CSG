<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncaminhamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encaminhamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_encaminhamento');
            $table->date('data_retorno');
            $table->integer('quantidade');
            $table->integer('valor_unitario');
            $table->descricao('descricao');
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
        Schema::dropIfExists('encaminhamentos');
    }
}
