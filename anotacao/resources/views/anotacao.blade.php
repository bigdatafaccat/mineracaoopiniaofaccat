@extends('layouts.app')

@section('content')
<form name="formulario" action="{{route('anotar')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="t" value="{{$sentenca->texto}}" />
    <input type="hidden" name="s" value="{{$sentenca->idsentenca}}" />
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <div class="">

                    <h1 class="text-center">Avaliação de opiniões</h1>
                    <hr />
                    <div class="lead">
                        {{$sentenca->texto}}
                    </div>
                    <hr />
                </div>
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-4 col-md-offset-2">
                Esse texto apresenta opinião:
            </div>
            <div class="col-md-5">
                <div class="radio">
                    <label>
                        <input type="radio" name="opiniao" value="positiva">
                        Positiva
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="opiniao" value="negativa">
                        Negativa
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="opiniao" value="nenhuma">
                        Não há
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="opiniao" value="naosei">
                        Não sei
                    </label>
                </div>
            </div>
        </div>
        <hr />
        <div class="row lead">
            <div class="col-md-4 col-md-offset-2">
                Quais são os assuntos mencionados:
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_saude"> Saúde
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_educacao"> Educação
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_seguranca"> Segurança
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_meioambiente"> Meio ambiente
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_emprego"> Emprego
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_politica"> Política
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_nenhum"> Nenhum
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_naosei"> Não sei
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_outro"> Outro
                    </label>
                </div>
            </div>
        </div>

        <hr />

        <div class="row lead">
            <div class="col-md-4 col-md-offset-2">
                Quais emoções/sentimentos você nota:
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_alegria"> Alegria
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_surpresa"> Surpresa
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_medo"> Medo
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_tristeza"> Tristeza
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_raiva"> Raiva
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_repugnancia"> Repugnância
                    </label>
                </div>
            </div>
            <div class="col-md-2">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_confianca"> Confiança
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_politica"> Expectativa
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_nenhum"> Nenhum
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_naosei"> Não sei
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_outro"> Outro
                    </label>
                </div>
            </div>
        </div>



    </div>
</form>
@endsection
