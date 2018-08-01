<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->decimal('valor_unitario',8,2);
            $table->decimal('valor_total',8,2);
            $table->string('status');
            $table->integer('quantidade');
            $table->integer('id_licitacao')->unsigned();
            $table->foreign('id_licitacao')->references('id')->on('licitacaos');
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
        Schema::dropIfExists('materials');
    }
}
