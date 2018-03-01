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
        });

        Schema::create('part_of_speech', function (Blueprint $table) {
            $table->bigIncrements('idpart_of_speech');
            $table->bigInteger('idsentenca');
            $table->string('termo');
            $table->string('pos');
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
        /*DB::statement("
        create temp table tmp as (
            select count(x.*), 
                   array_agg(x.idsentenca) as idsentenca  
              from sentenca x group by text having count(*) > 1
        );

        create table sentenca_refino_1 as (
          select * from sentenca where idsentenca not in (
            select unnest(idsentenca) from tmp
          )
        )




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
