<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Experimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experimentos_avaliacao_resultado', function (Blueprint $table) {
            $table->bigIncrements('idexperimentos_avaliacao_resultado');
            $table->string('algoritmo')->nullable();
            $table->string('descricao')->nullable();
            $table->string('oqueclassifica')->nullable();
            $table->text('configuracao')->nullable();
            $table->string('acuracia_train_test')->nullable();
            $table->text('resultados_train_test')->nullable();
            $table->string('acuracia_cross_validation')->nullable();
            $table->text('resultados_cross_validation')->nullable();
            $table->integer('lote_numero')->nullable();
            $table->string('lote_inicio')->nullable();
            $table->string('lote_fim')->nullable();
            $table->string('experimento_inicio')->nullable();
            $table->string('experimento_fim')->nullable();
            $table->text('matriz_confusao_train_test')->nullable();
            $table->text('melhor_classificador')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experimentos_avaliacao_resultado');
    }
}
