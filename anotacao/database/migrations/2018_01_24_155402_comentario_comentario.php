<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComentarioComentario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sentenca', function (Blueprint $table) {
            $table->string('post_autor_id')->nullable();
            $table->string('post_autor_name')->nullable();
            $table->string('comentario_id')->nullable();
            $table->string('comentario_autor_id')->nullable();
            $table->string('comentario_autor_name')->nullable();
            $table->integer('comentario_sentenca_id')->nullable();
            $table->text('tipo_texto')->nullable();
            $table->text('post_texto');
            $table->text('comentario_texto')->nullable();
            $table->text('post_datahora')->nullable();
            $table->string('comentario_comentario_id')->nullable();
            $table->integer('comentario_comentario_sentenca_id')->nullable();
            $table->string('comentario_comentario_autor_id')->nullable();
            $table->string('comentario_comentario_autor_name')->nullable();
            $table->text('comentario_comentario_texto')->nullable();
            $table->boolean('similar_outra');
            $table->boolean('similaridade_analisada');
            $table->boolean('pre_aspecto_educacao');
            $table->boolean('pre_aspecto_seguranca');
            $table->boolean('pre_aspecto_analisado');
            $table->integer('post_dia')->nullable();
            $table->integer('tamanho_sentenca_texto')->nullable();
            $table->integer('tamanho_comentario_texto')->nullable();
            $table->integer('tamanho_post_texto')->nullable();
            $table->integer('tamanho_comentario_comentario_texto')->nullable();

        });

        Schema::create('part_of_speech', function (Blueprint $table) {
            $table->bigIncrements('idpart_of_speech');
            $table->bigInteger('idsentenca');
            $table->text('termo');
            $table->string('pos');
            $table->string('termo_sem_acentuacao')->nullable();
            $table->string('termo_com_stem')->nullable();
            $table->boolean('normalizacao');
            $table->boolean('termo_analisado');
            $table->boolean('pre_aspecto_saude');
            $table->boolean('pre_aspecto_educacao');
            $table->boolean('pre_aspecto_seguranca');
            $table->boolean('pre_aspecto_analisado');
            $table->timestamps();
        });

        Schema::create('reacao', function (Blueprint $table) {
            $table->bigIncrements('idreacao');
            $table->string('post_id')->nullable();
            $table->string('comentario_id')->nullable();
            $table->string('autor_id')->nullable();
            $table->string('autor_name')->nullable();
            $table->string('type')->nullable();
            $table->string('tipo'); //post, comentario, comentario de comentario
            $table->timestamps();
        });

        Schema::create('similaridade', function (Blueprint $table) {
            $table->bigIncrements('idsimilaridade');
            $table->bigInteger('idsentenca1');
            $table->bigInteger('idsentenca2');
            $table->float('cosine_similarity');
        });

        DB::statement("create index on sentenca (idsentenca, post_dia)");
        DB::statement("create index on sentenca (idsentenca, post_dia) where pre_aspecto_educacao and not similar_outra and similaridade_analisada");
        DB::statement("create index on sentenca (idsentenca, post_dia) where pre_aspecto_saude and not similar_outra and similaridade_analisada");
        DB::statement("create index on sentenca (idsentenca, post_dia) where pre_aspecto_educacao and not similar_outra and similaridade_analisada");
        DB::statement("create index on sentenca (idsentenca, post_dia) where not similar_outra and not similar_outra and similaridade_analisada");


        DB::statement("create index on part_of_speech (idpart_of_speech) where normalizado");
        DB::statement("create index on part_of_speech (idsentenca) where normalizado");


        /*DB::statement("
        create temp table tmp as (
            select count(x.*), 
                   array_agg(x.idsentenca) as idsentenca  
              from sentenca x group by text having count(*) > 1
        );

        create temp table sentencas_duplicadas as (
          select * from sentenca where idsentenca in (
            select unnest(idsentenca) from tmp
          )
        )

        update sentenca set similar_outra = true where idsentenca in (select idsentenca from sentenca_refino_1);




        ");*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('part_of_speech');
        Schema::drop('reacao');
    }
}
