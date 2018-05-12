<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Indices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("create index on part_of_speech (idsentenca)");
        DB::statement("create index on part_of_speech (idsentenca) where pos = 'NOUN'");
        DB::statement("create index on sentenca (post_id, comentario_id, comentario_comentario_id, sentenca_id)");
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
