<?php

namespace App\Http\Controllers;

use App\ResumoFinal;
use Illuminate\Http\Request;

class ResumoFinalController extends Controller
{
    public function obterResumoEmJson() {

        $assuntos = ['saude', 'seguranca', 'educacao'];
        $lista = [];

        foreach ($assuntos as $assunto) {
            $termos = ResumoFinal::obterResumoTermos($assunto);
            $termosFormatados = [];
            foreach ($termos as $termo) {
                $termosFormatados[] = [
                  'key' => $termo->termo,
                  'value' => $termo->qtd
                ];
            }

            $registro = ResumoFinal::obterResumoFinal($assunto)[0];
            $registroFormatado = [
                'topico' => $assunto,
                'qntPosts' => $registro->qtd,
                'qntPositivo' => $registro->qtdpositivas,
                'qttNegativo' => $registro->qtdnegativas,
                'porcentagemPositivo' => round((int)$registro->qtdpositivas / (int)$registro->qtd * 100, 2),
                'porcentagemNegativo' => round((int)$registro->qtdnegativas / (int)$registro->qtd * 100, 2),
                'palavras' => $termosFormatados
            ];

            $lista[] = $registroFormatado;
        }


        //$json = '[{"topico":"Saúde","qntPosts":1500,"qntPositivo":1000,"porcentagemPositivo":70,"qntNegativo":500,"porcentagemNegativo":30,"palavras":[{"key":"Médico","value":100},{"key":"Seringa","value":33},{"key":"Vacina","value":45},{"key":"Posto","value":15},{"key":"Enfermeiros","value":10},{"key":"Remédios","value":9}]},{"topico":"Segurança","qntPosts":2000,"qntPositivo":1500,"porcentagemPositivo":60,"qntNegativo":500,"porcentagemNegativo":40,"palavras":[{"key":"Policial","value":100},{"key":"Delegacia","value":33},{"key":"Bandido","value":45},{"key":"Arma","value":15},{"key":"Assalto","value":10},{"key":"Presidio","value":9}]},{"topico":"Educação","qntPosts":3000,"qntPositivo":1500,"porcentagemPositivo":50,"qntNegativo":1500,"porcentagemNegativo":50,"palavras":[{"key":"Professor","value":100},{"key":"Aluno","value":33},{"key":"Sala de aula","value":45},{"key":"Diretoria","value":15},{"key":"Merenda","value":10},{"key":"Lápis","value":9}]}]';
        //$dados = json_decode($json, true);


        $jsonFinal = json_encode($lista);
        return $jsonFinal;
    }

}
