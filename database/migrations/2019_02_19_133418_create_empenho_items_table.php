<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpenhoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empenho_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade');
            $table->integer('fk_empenho')->unsigned();
            $table->foreign('fk_empenho')->references('id')->on('empenhos');
            $table->integer('fk_contrato_item')->unsigned();
            $table->foreign('fk_contrato_item')->references('id')->on('contrato_items');
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
        Schema::dropIfExists('empenho_items');
    }
}
