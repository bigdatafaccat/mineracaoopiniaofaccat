<?php

use Illuminate\Database\Seeder;

class ImportacaoMongoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $total = 179812;
        $contador_posts = 0;
        $limite = 900;
        $importados = [];

        for ($i = 1; $i <= 200; $i++) {
            $posts = DB::connection('mongodb')->collection('posts')->skip($contador_posts)->take($limite)->get();
            $contador_posts += $limite;

            foreach ($posts as $post) {
                if (isset($post['sentences']) and !in_array($post['post_id'], $importados)) {
                    foreach ($post['sentences'] as $post_sentenca) {
                        if (strlen($post_sentenca[1]) > 0
                        and strlen($post_sentenca[0]) > 0
                        and $this->filtrarSentencas($post_sentenca[1])) {
                            $sentenca = new \App\Sentenca();
                            $sentenca->post_id = $post['post_id'];
                            $sentenca->sentenca_id = $post_sentenca[0];
                            $sentenca->texto = $post_sentenca[1];
                            $sentenca->mongo_id = (string)$post['_id'];
                            $sentenca->grupo_id = $post['target']['id'];
                            $sentenca->save();
                        }
                    }
                }
                $importados[] = $sentenca->post_id;
            }
            echo "Posts: ".$contador_posts." (".round(($contador_posts / $total * 100), 2)."%)".PHP_EOL.PHP_EOL;
        }
    }

    public function filtrarSentencas($sentenca) {
        //Remove espaços do início e do final da sentença
        $sentenca = strtolower(trim($sentenca));

        //Remove números e caracteres especiais
        $sentenca = preg_replace(["/[^A-Za-z ]/"], "", $sentenca);


        //Verifica se frase possuí pelo menos dois caracteres de espaço, ou seja, no mínimo 3 palavras
        $palavras = explode(" ", $sentenca);
        if (count($palavras) <= 1) {
            return false;
        }

        //Setenças precisam ter no mínimo 10 caracteres
        if (strlen($sentenca) <= 20) {
            return false;
        }

        //TODO:
        //Setenças precisam ter alguma sentença que menciona saúde, educação, segurança, meio ambiente, política
        return true;
    }
}