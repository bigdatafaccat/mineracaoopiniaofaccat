<?php

use Illuminate\Database\Seeder;

class DadosTesteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 100; $i++) {
            $sentenca = new \App\Sentenca();
            $sentenca->identificador = $faker->text();
            $sentenca->texto = $faker->text();
            $sentenca->save();
        }
    }
}
