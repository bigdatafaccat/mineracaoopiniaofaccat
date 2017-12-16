<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Anotacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentenca', function (Blueprint $table) {
            $table->increments('idsentenca');
            $table->string('identificador');
            $table->text('texto');
            $table->timestamps();
        });

        Schema::create('anotacao', function (Blueprint $table) {
            $table->increments('idanotacao');
            $table->integer('idsentenca');
            $table->integer('idusuario');
            $table->string('opiniao')->nullable();


            $table->boolean('assunto_saude')->nullable();
            $table->boolean('assunto_educacao')->nullable();
            $table->boolean('assunto_seguranca')->nullable();
            $table->boolean('assunto_meioambiente')->nullable();
            $table->boolean('assunto_emprego')->nullable();
            $table->boolean('assunto_politica')->nullable();
            $table->boolean('assunto_naosei')->nullable();
            $table->boolean('assunto_nenhum')->nullable();
            $table->string('assunto_outro')->nullable();

            $table->boolean('sentimento_alegria')->nullable();
            $table->boolean('sentimento_surpresa')->nullable();
            $table->boolean('sentimento_medo')->nullable();
            $table->boolean('sentimento_tristeza')->nullable();
            $table->boolean('sentimento_raiva')->nullable();
            $table->boolean('sentimento_repugnancia')->nullable();
            $table->boolean('sentimento_confianca')->nullable();
            $table->boolean('sentimento_expectativa')->nullable();
            $table->boolean('sentimento_nenhum')->nullable();
            $table->boolean('sentimento_naosei')->nullable();
            $table->string('sentimento_outro')->nullable();

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
        Schema::drop('anotacao');
        Schema::drop('sentenca');
    }
}
