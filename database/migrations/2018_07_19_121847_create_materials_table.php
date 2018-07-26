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
            $table->string('colaborador');
            $table->string('bens');
            $table->string('n_licitacao');
            $table->string('termo_aditivo');
            $table->string('modalidade');
            $table->decimal('valor_licitacao',8,2);
            $table->decimal('valor_unitario',8,2);
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
        Schema::dropIfExists('materials');
    }
}
