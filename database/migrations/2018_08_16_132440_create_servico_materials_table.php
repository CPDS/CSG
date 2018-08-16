<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicoMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servico_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade');
            $table->integer('fk_material')->nullable();
            $table->foreign('fk_material')->references('id')->on('materials');
            $table->integer('fk_solicitacao_servico')->unsigned();
            $table->foreign('fk_solicitacao_servico')->references('id')->on('solicitacao_servicos');
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
        Schema::dropIfExists('servico_materials');
    }
}
