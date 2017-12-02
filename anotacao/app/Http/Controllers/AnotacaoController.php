<?php

namespace App\Http\Controllers;

use \App\Anotacao;
use App\Sentenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnotacaoController extends Controller
{
    public function exibirSentenca() {

        $sentenca = Sentenca::whereRaw('idsentenca not in (select x.idsentenca from anotacao x where x.idusuario <> ?)', [Auth::user()->id])->first();
        return view('anotacao', ['sentenca' => $sentenca]);
    }

    public function registrarAnotacao() {

    }
}
