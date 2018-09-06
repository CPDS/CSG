<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialSaidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_saidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade');
            $table->integer('fk_material')->nullable();
            $table->foreign('fk_material')->references('id')->on('materials');
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
        Schema::dropIfExists('material_saidas');
    }
}
