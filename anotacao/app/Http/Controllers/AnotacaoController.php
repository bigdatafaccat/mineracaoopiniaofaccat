<?php

namespace App\Http\Controllers;

use \App\Anotacao;
use App\Sentenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AnotacaoController extends Controller
{
    public function exibirSentenca() {

        $min = Sentenca::min('idsentenca');
        $max = Sentenca::max('idsentenca');
        $random = rand($min, $max);

        //$teste = DB::connection('mongodb')->collection('posts')->take(1)->get();
        //var_dump($teste);

        /*Regras para apresentar anotação de sentenças

        1 - Pessoas anotarão sentenças
        2 - Cada sentença será anotada por no mínimo 2 pessoas
        3 - Enquanto duas pessoas não concordarem com a anotação da sentença, ela será candidata a nova anotação

        */

        $diaAleatorio = rand(1, 31);
        //primeiro verifica se existe alguma sentenca com apenas uma anotacao
        $string = "idsentenca in (select x.idsentenca from anotacao x group by x.idsentenca having count(*) = 1)
               and idsentenca not in (select x.idsentenca from anotacao x where x.idusuario = ?)
               and post_datahora::date >= '2017-01-01'::date
               and post_datahora::date <= '2017-07-01'::date
               and not similar_outra
               and tamanho_post_texto > 2
               and post_dia = ? 
               and similaridade_analisada";
        $sentenca = Sentenca::whereRaw($string, [Auth::user()->id, $diaAleatorio])->first();
        //var_dump($sentenca);

        //se não existir sentenca com apenas uma anotação, sorteia qualquer sentença
        if ($sentenca === null) {

            $filtrosDinamico = [];
            $filtrosDinamico[] = " and pre_aspecto_saude ";
            $filtrosDinamico[] = " and pre_aspecto_educacao ";
            $filtrosDinamico[] = " and pre_aspecto_seguranca ";
            $filtrosDinamico[] = " ";

            $quantidadeFiltros = count($filtrosDinamico);
            $valorAletorio = rand(0, ($quantidadeFiltros-1));
            $filtroDinamicoAleatorio = $filtrosDinamico[$valorAletorio];



            $string = "idsentenca not in (select x.idsentenca from anotacao x where x.idusuario = ?)
               and post_datahora::date >= '2017-01-01'::date
               and post_datahora::date <= '2017-07-01'::date
               and not similar_outra
               and similaridade_analisada
               and tamanho_post_texto > 2
               and post_dia = ?
               $filtroDinamicoAleatorio";
            $sentenca = Sentenca::whereRaw($string, [Auth::user()->id, $diaAleatorio])->first();
        }
        //var_dump($sentenca);
        //die('aqui');

        return view('anotacao', ['sentenca' => $sentenca]);
    }

    public function registrarAnotacao() {


        $idsentenca = Input::get('s');
        $texto = Input::get('t');

        $condicao = "idsentenca = ? and md5(idsentenca::text || 'anotacao') = ?";
        $sentenca = Sentenca::whereRaw($condicao, [$idsentenca, trim($texto)])->first();

        //var_dump($idsentenca, $texto, strlen($texto));
        if ($sentenca) {
            $anotacao = new Anotacao();
            $anotacao->idsentenca               = $sentenca->idsentenca;
            $anotacao->idusuario                = Auth::user()->id;
            $anotacao->opiniao                  = Input::get('opiniao');
            $anotacao->assunto_saude            = Input::get('assunto_saude');
            $anotacao->assunto_educacao         = Input::get('assunto_educacao');
            $anotacao->assunto_seguranca        = Input::get('assunto_seguranca');
            $anotacao->assunto_meioambiente     = Input::get('assunto_meioambiente');
            $anotacao->assunto_emprego          = Input::get('assunto_emprego');
            $anotacao->assunto_politica         = Input::get('assunto_politica');
            $anotacao->assunto_naosei           = Input::get('assunto_naosei');
            $anotacao->assunto_nenhum           = Input::get('assunto_nenhum');
            $anotacao->assunto_outro            = Input::get('assunto_outro');
            $anotacao->sentimento_alegria       = Input::get('sentimento_alegria');
            $anotacao->sentimento_surpresa      = Input::get('sentimento_surpresa');
            $anotacao->sentimento_medo          = Input::get('sentimento_medo');
            $anotacao->sentimento_tristeza      = Input::get('sentimento_tristeza');
            $anotacao->sentimento_raiva         = Input::get('sentimento_raiva');
            $anotacao->sentimento_repugnancia   = Input::get('sentimento_repugnancia');
            $anotacao->sentimento_confianca     = Input::get('sentimento_confianca');
            $anotacao->sentimento_expectativa   = Input::get('sentimento_expectativa');
            $anotacao->sentimento_nenhum        = Input::get('sentimento_nenhum');
            $anotacao->sentimento_naosei        = Input::get('sentimento_naosei');
            $anotacao->sentimento_outro         = Input::get('sentimento_outro');
            $anotacao->vale_paranhana           = Input::get('vale_paranhana');

            if (Input::get('botao') === 'pular') {
                $anotacao->pular = true;
            }
            $anotacao->save();

            //var_dump($anotacao->wasRecentlyCreated);
            //var_dump($anotacao->idanotacao);
        }

        //die('aqui');
        return redirect(route('anotacao'));
    }
}
