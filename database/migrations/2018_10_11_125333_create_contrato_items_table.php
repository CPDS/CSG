<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade');
            $table->integer('fk_item')->unsigned();
            $table->foreign('fk_item')->references('id')->on('item_contratos');   
            $table->integer('fk_contrato')->unsigned();
            $table->foreign('fk_contrato')->references('id')->on('contratos');
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
        Schema::dropIfExists('contrato_items');
    }
}
