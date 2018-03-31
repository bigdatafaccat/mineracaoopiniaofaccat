<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Anotacao2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anotacao', function (Blueprint $table) {
            $table->string( 'post_opiniao')->nullable();
            $table->boolean('post_assunto_saude')->nullable();
            $table->boolean('post_assunto_educacao')->nullable();
            $table->boolean('post_assunto_seguranca')->nullable();
            $table->boolean('post_assunto_meioambiente')->nullable();
            $table->boolean('post_assunto_emprego')->nullable();
            $table->boolean('post_assunto_politica')->nullable();
            $table->boolean('post_assunto_naosei')->nullable();
            $table->boolean('post_assunto_nenhum')->nullable();
            $table->string( 'post_assunto_outro')->nullable();
            $table->boolean('post_sentimento_alegria')->nullable();
            $table->boolean('post_sentimento_surpresa')->nullable();
            $table->boolean('post_sentimento_medo')->nullable();
            $table->boolean('post_sentimento_tristeza')->nullable();
            $table->boolean('post_sentimento_raiva')->nullable();
            $table->boolean('post_sentimento_repugnancia')->nullable();
            $table->boolean('post_sentimento_confianca')->nullable();
            $table->boolean('post_sentimento_expectativa')->nullable();
            $table->boolean('post_sentimento_nenhum')->nullable();
            $table->boolean('post_sentimento_naosei')->nullable();
            $table->string( 'post_sentimento_outro')->nullable();

            $table->string( 'comentario_opiniao')->nullable();
            $table->boolean('comentario_assunto_saude')->nullable();
            $table->boolean('comentario_assunto_educacao')->nullable();
            $table->boolean('comentario_assunto_seguranca')->nullable();
            $table->boolean('comentario_assunto_meioambiente')->nullable();
            $table->boolean('comentario_assunto_emprego')->nullable();
            $table->boolean('comentario_assunto_politica')->nullable();
            $table->boolean('comentario_assunto_naosei')->nullable();
            $table->boolean('comentario_assunto_nenhum')->nullable();
            $table->string( 'comentario_assunto_outro')->nullable();
            $table->boolean('comentario_sentimento_alegria')->nullable();
            $table->boolean('comentario_sentimento_surpresa')->nullable();
            $table->boolean('comentario_sentimento_medo')->nullable();
            $table->boolean('comentario_sentimento_tristeza')->nullable();
            $table->boolean('comentario_sentimento_raiva')->nullable();
            $table->boolean('comentario_sentimento_repugnancia')->nullable();
            $table->boolean('comentario_sentimento_confianca')->nullable();
            $table->boolean('comentario_sentimento_expectativa')->nullable();
            $table->boolean('comentario_sentimento_nenhum')->nullable();
            $table->boolean('comentario_sentimento_naosei')->nullable();
            $table->string( 'comentario_sentimento_outro')->nullable();

            $table->string( 'comentario_comentario_opiniao')->nullable();
            $table->boolean('comentario_comentario_assunto_saude')->nullable();
            $table->boolean('comentario_comentario_assunto_educacao')->nullable();
            $table->boolean('comentario_comentario_assunto_seguranca')->nullable();
            $table->boolean('comentario_comentario_assunto_meioambiente')->nullable();
            $table->boolean('comentario_comentario_assunto_emprego')->nullable();
            $table->boolean('comentario_comentario_assunto_politica')->nullable();
            $table->boolean('comentario_comentario_assunto_naosei')->nullable();
            $table->boolean('comentario_comentario_assunto_nenhum')->nullable();
            $table->string( 'comentario_comentario_assunto_outro')->nullable();
            $table->boolean('comentario_comentario_sentimento_alegria')->nullable();
            $table->boolean('comentario_comentario_sentimento_surpresa')->nullable();
            $table->boolean('comentario_comentario_sentimento_medo')->nullable();
            $table->boolean('comentario_comentario_sentimento_tristeza')->nullable();
            $table->boolean('comentario_comentario_sentimento_raiva')->nullable();
            $table->boolean('comentario_comentario_sentimento_repugnancia')->nullable();
            $table->boolean('comentario_comentario_sentimento_confianca')->nullable();
            $table->boolean('comentario_comentario_sentimento_expectativa')->nullable();
            $table->boolean('comentario_comentario_sentimento_nenhum')->nullable();
            $table->boolean('comentario_comentario_sentimento_naosei')->nullable();
            $table->string( 'comentario_comentario_sentimento_outro')->nullable();

            $table->string( 'sentenca_opiniao')->nullable();
            $table->boolean('sentenca_assunto_saude')->nullable();
            $table->boolean('sentenca_assunto_educacao')->nullable();
            $table->boolean('sentenca_assunto_seguranca')->nullable();
            $table->boolean('sentenca_assunto_meioambiente')->nullable();
            $table->boolean('sentenca_assunto_emprego')->nullable();
            $table->boolean('sentenca_assunto_politica')->nullable();
            $table->boolean('sentenca_assunto_naosei')->nullable();
            $table->boolean('sentenca_assunto_nenhum')->nullable();
            $table->string( 'sentenca_assunto_outro')->nullable();
            $table->boolean('sentenca_sentimento_alegria')->nullable();
            $table->boolean('sentenca_sentimento_surpresa')->nullable();
            $table->boolean('sentenca_sentimento_medo')->nullable();
            $table->boolean('sentenca_sentimento_tristeza')->nullable();
            $table->boolean('sentenca_sentimento_raiva')->nullable();
            $table->boolean('sentenca_sentimento_repugnancia')->nullable();
            $table->boolean('sentenca_sentimento_confianca')->nullable();
            $table->boolean('sentenca_sentimento_expectativa')->nullable();
            $table->boolean('sentenca_sentimento_nenhum')->nullable();
            $table->boolean('sentenca_sentimento_naosei')->nullable();
            $table->string( 'sentenca_sentimento_outro')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
