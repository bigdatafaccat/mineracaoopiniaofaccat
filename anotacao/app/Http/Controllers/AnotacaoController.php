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


        $string = "idsentenca not in (select x.idsentenca from anotacao x where x.idusuario <> ?)
               and idsentenca > ?";
        $sentenca = Sentenca::whereRaw($string, [Auth::user()->id, $random])->first();
        return view('anotacao', ['sentenca' => $sentenca]);
    }

    public function registrarAnotacao() {

        $idsentenca = Input::get('s');
        $texto = Input::get('t');

        $condicao = "idsentenca = ? and trim(texto) = ?";
        $sentenca = Sentenca::whereRaw($condicao, [$idsentenca, trim($texto)])->first();

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
            if (Input::get('botao') === 'pular') {
                $anotacao->pular = true;
            }
            $anotacao->save();

            //var_dump($anotacao->wasRecentlyCreated);
        }

        return redirect(route('anotacao'));
    }
}
