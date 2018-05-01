<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DocumentosClassificados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_classificado', function (Blueprint $table) {
            $table->bigIncrements('iddocumento_classificado');
            $table->bigInteger('idexperimentos_avaliacao_resultado');
            $table->string('sentenca_id')->nullable();
            $table->string('post_id')->nullable();
            $table->string('comentario_id')->nullable();
            $table->string('comentario_comentario_id')->nullable();
            $table->text('texto');
            $table->text('tipo_texto');
            $table->text('oqueclassifica');
            $table->text('variavel_dependente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento_classificado');
    }
}
