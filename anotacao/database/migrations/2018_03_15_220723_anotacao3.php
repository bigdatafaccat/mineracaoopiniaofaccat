<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Anotacao3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anotacao', function (Blueprint $table) {
            $table->boolean('assunto_transito')->nullable();
            $table->boolean('post_assunto_transito')->nullable();
            $table->boolean('comentario_assunto_transito')->nullable();
            $table->boolean('comentario_comentario_assunto_transito')->nullable();
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
