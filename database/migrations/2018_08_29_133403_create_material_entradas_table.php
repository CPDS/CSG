<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('material_entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade');
            $table->integer('fk_user')->unsigned();
            $table->foreign('fk_user')->references('id')->on('users');
            $table->integer('fk_material')->unsigned();
            $table->foreign('fk_material')->references('id')->on('materials');
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
        Schema::dropIfExists('material_entradas');
    }
}
