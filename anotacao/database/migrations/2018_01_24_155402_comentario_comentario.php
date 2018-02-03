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
        DB::statement("
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
        
        
        
        
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sentenca_refino_1');
    }
}
