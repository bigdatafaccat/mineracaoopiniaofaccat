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
        $limite = 225;
        //$limite = 2;
        $importados = [];

        for ($i = 1; $i <= 800; $i++) {
            $posts = DB::connection('mongodb')->collection('posts')->skip($contador_posts)->take($limite)->get();
            $contador_posts += $limite;

            foreach ($posts as $post) {
                //importa sentencas do post
                if (isset($post['sentences']) and !in_array($post['post_id'], $importados)) {
                    foreach ($post['sentences'] as $post_sentenca) {
                        if (strlen($post_sentenca[1]) > 0
                        and strlen($post_sentenca[0]) > 0
                        and $this->filtrarSentencas($post_sentenca[1])) {
                            $sentenca = new \App\Sentenca();
                            $sentenca->post_id = $post['post_id'];
                            $sentenca->sentenca_id = $post_sentenca[0];
                            $sentenca->texto = $post_sentenca[1];
                            $sentenca->post_texto = $post['message_description'];
                            $sentenca->mongo_id = (string)$post['_id'];
                            $sentenca->grupo_id = $post['target']['id'];
                            $sentenca->post_datahora = $post['created_time'];
                            $sentenca->tipo_texto = "post";
                            $sentenca->post_autor_id = $post['from']['id'];
                            $sentenca->post_autor_name = $post['from']['name'];
                            $sentenca->similar_outra = false;
                            $sentenca->similaridade_analisada = false;
                            $sentenca->save();
                            //part of speech
                            if (isset($post_sentenca[2])) {
                                foreach ($post_sentenca[2] as $pos) {
                                    $partOfSpeech = new \App\PartOfSpeech();
                                    $partOfSpeech->idsentenca = $sentenca->idsentenca;
                                    $partOfSpeech->termo = $pos[0];
                                    $partOfSpeech->pos = $pos[1];
                                    $partOfSpeech->termo_analisado = false;
                                    $partOfSpeech->normalizado = false;
                                    $partOfSpeech->save();
                                    unset($partOfSpeech);
                                }
                            }
                            unset($sentenca);
                        }
                    }
                    //grava reacoes de post
                    if (isset($post['reactions']['data'])) {
                        foreach ($post['reactions']['data'] as $post_reacoes) {
                            $reacao = new \App\Reacao();
                            $reacao->post_id = $post['post_id'];
                            $reacao->tipo = 'post';
                            $reacao->autor_id = $post_reacoes['id'];
                            $reacao->autor_name = $post_reacoes['name'];
                            $reacao->type = $post_reacoes['type'];
                            $reacao->save();
                            unset($reacao);
                        }
                    }
                }
                //importa sentencas dos comentarios do post
                if (isset($post['comments']) and isset($post['message_description'])) {
                    $comentarios = $post['comments']['data'];
                    foreach ($comentarios as $comentario) {
                        //grava reacoes de comentario
                        if (isset($comentario['reactions']['data'])) {
                            foreach ($comentario['reactions']['data'] as $comentario_reacoes) {
                                $reacao = new \App\Reacao();
                                $reacao->comentario_id = $comentario['id'];
                                $reacao->tipo = 'comentario';
                                $reacao->autor_id = $comentario_reacoes['id'];
                                $reacao->autor_name = $comentario_reacoes['name'];
                                $reacao->type = $comentario_reacoes['type'];
                                $reacao->save();
                                unset($reacao);
                            }
                        }
                        if (isset($comentario['message'])) {
                            $comentario_sentencas = $comentario['comment_sentences'];
                            foreach ($comentario_sentencas as $comentario_sentenca) {
                                if (strlen($comentario_sentenca[1]) > 0
                                    and strlen($comentario_sentenca[0]) > 0
                                    and $this->filtrarSentencas($comentario_sentenca[1])) {
                                    $sentenca = new \App\Sentenca();
                                    $sentenca->post_id = $post['post_id'];
                                    $sentenca->post_texto = $post['message_description'];
                                    $sentenca->comentario_id = $comentario['id'];
                                    $sentenca->comentario_texto = $comentario['message'];
                                    $sentenca->sentenca_id = $comentario_sentenca[0];
                                    $sentenca->texto = $comentario_sentenca[1];
                                    $sentenca->mongo_id = (string)$post['_id'];
                                    $sentenca->grupo_id = $post['target']['id'];
                                    $sentenca->post_datahora = $post['created_time'];
                                    $sentenca->tipo_texto = "comentario";
                                    $sentenca->post_autor_id = $post['from']['id'];
                                    $sentenca->post_autor_name = $post['from']['name'];
                                    $sentenca->comentario_autor_id = $comentario['from']['id'];
                                    $sentenca->comentario_autor_name = $comentario['from']['name'];
                                    $sentenca->similar_outra = false;
                                    $sentenca->similaridade_analisada = false;
                                    $sentenca->save();
                                    //part of speech
                                    if (isset($comentario_sentenca[2])) {
                                        foreach ($comentario_sentenca[2] as $pos) {
                                            $partOfSpeech = new \App\PartOfSpeech();
                                            $partOfSpeech->idsentenca = $sentenca->idsentenca;
                                            $partOfSpeech->termo = $pos[0];
                                            $partOfSpeech->pos = $pos[1];
                                            $partOfSpeech->termo_analisado = false;
                                            $partOfSpeech->normalizado = false;
                                            $partOfSpeech->save();
                                            unset($partOfSpeech);
                                        }
                                    }
                                    unset($sentenca);
                                }
                            }
                            //importa os comentários do comentário
                            if (isset($comentario['comments'])) {
                                $comentarios_de_comentario = $comentario['comments']['data'];
                                foreach ($comentarios_de_comentario as $comentario_comentario) {
                                    if (isset($comentario_comentario['message']) and isset($comentario_comentario['comment_sentences'])) {
                                        $comentario_comentario_sentencas = $comentario_comentario['comment_sentences'];
                                        foreach ($comentario_comentario_sentencas as $comentario_comentario_sentenca) {
                                            if (strlen($comentario_comentario_sentenca[1]) > 0
                                                and strlen($comentario_comentario_sentenca[0]) > 0
                                                and $this->filtrarSentencas($comentario_comentario_sentenca[1])
                                            ) {
                                                $sentenca = new \App\Sentenca();
                                                $sentenca->post_id = $post['post_id'];
                                                $sentenca->post_texto = $post['message_description'];
                                                $sentenca->comentario_id = $comentario['id'];
                                                $sentenca->comentario_texto = $comentario['message'];
                                                $sentenca->sentenca_id = $comentario_sentenca[0];
                                                $sentenca->texto = $comentario_sentenca[1];
                                                $sentenca->mongo_id = (string)$post['_id'];
                                                $sentenca->grupo_id = $post['target']['id'];
                                                $sentenca->post_datahora = $post['created_time'];
                                                $sentenca->tipo_texto = "comentario_de_comentario";
                                                $sentenca->comentario_comentario_id = $comentario_comentario['id'];
                                                $sentenca->comentario_comentario_sentenca_id = $comentario_comentario_sentenca[0];
                                                $sentenca->comentario_comentario_texto = $comentario_comentario_sentenca[1];
                                                $sentenca->post_autor_id = $post['from']['id'];
                                                $sentenca->post_autor_name = $post['from']['name'];
                                                $sentenca->comentario_autor_id = $comentario['from']['id'];
                                                $sentenca->comentario_autor_name = $comentario['from']['name'];
                                                $sentenca->comentario_comentario_autor_id = $comentario_comentario['from']['id'];
                                                $sentenca->comentario_comentario_autor_name = $comentario_comentario['from']['name'];
                                                $sentenca->similar_outra = false;
                                                $sentenca->similaridade_analisada = false;
                                                $sentenca->save();
                                                //part of speech
                                                if (isset($comentario_comentario_sentenca[2])) {
                                                    foreach ($comentario_comentario_sentenca[2] as $pos) {
                                                        $partOfSpeech = new \App\PartOfSpeech();
                                                        $partOfSpeech->idsentenca = $sentenca->idsentenca;
                                                        $partOfSpeech->termo = $pos[0];
                                                        $partOfSpeech->pos = $pos[1];
                                                        $partOfSpeech->termo_analisado = false;
                                                        $partOfSpeech->normalizado = false;
                                                        $partOfSpeech->save();
                                                        unset($partOfSpeech);
                                                    }
                                                }
                                                unset($sentenca);
                                            }
                                        }
                                    }
                                    //grava reacoes de comentario de comentario
                                    if (isset($comentario_comentario['reactions']['data'])) {
                                        foreach ($comentario_comentario['reactions']['data'] as $comentario_reacoes) {
                                            $reacao = new \App\Reacao();
                                            $reacao->comentario_id = $comentario_comentario['id'];
                                            $reacao->tipo = 'comentario de comentario';
                                            $reacao->autor_id = $comentario_reacoes['id'];
                                            $reacao->autor_name = $comentario_reacoes['name'];
                                            $reacao->type = $comentario_reacoes['type'];
                                            $reacao->save();
                                            unset($reacao);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                //$importados[] = $sentenca->post_id;
                unset($post);
            }
            echo "Posts: ".$contador_posts." (".round(($contador_posts / $total * 100), 2)."%)".PHP_EOL.PHP_EOL;
            unset($posts);
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
