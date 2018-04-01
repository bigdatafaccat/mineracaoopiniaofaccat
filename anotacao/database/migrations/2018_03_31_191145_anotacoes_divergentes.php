<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnotacoesDivergentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacao_divergente', function (Blueprint $table) {
            $table->bigIncrements('idanotacao_divergente');
            $table->bigInteger('idsentenca');
            $table->string('tipo');
            $table->timestamps();
        });

        Schema::create('documento_para_treino', function (Blueprint $table) {
            $table->bigIncrements('documento_para_treino');
            $table->bigInteger('idsentenca');
            $table->string('tipo');
            $table->string('variavel_dependente');
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
        Schema::dropIfExists('anotacao_divergente');
        Schema::dropIfExists('documento_para_treino');
    }
}
