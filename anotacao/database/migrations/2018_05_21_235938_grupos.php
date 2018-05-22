<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Grupos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo', function (Blueprint $table) {
            $table->bigIncrements('idgrupo');
            $table->string('identificador');
            $table->string('nome');
            $table->string('cidade');
        });
        $x = [];
        $x[] = [
            'idgrupo' => 1,
            'identificador' => '857568257589250',
            'nome' => 'Fala Taquara 02',
            'cidade' => 'Taquara'
        ];

        $x[] = [
            'idgrupo' => 2,
            'identificador' => '819781408120253',
            'nome' => 'Fala Rolante',
            'cidade' => 'Rolante'
        ];

        $x[] = [
            'idgrupo' => 3,
            'identificador' => '160736474006171',
            'nome' => 'Fala Taquara',
            'cidade' => 'Taquara'
        ];

        $x[] = [
            'idgrupo' => 4,
            'identificador' => '160317500766953',
            'nome' => 'Fala Igrejinha',
            'cidade' => 'Igrejinha'
        ];

        $x[] = [
            'idgrupo' => 5,
            'identificador' => '408445882525894',
            'nome' => 'Fala Três Coroas',
            'cidade' => 'Três Coroas'
        ];

        DB::table('grupo')->insert($x);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupo');
    }
}
