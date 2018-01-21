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
                        <input type="checkbox" name="assunto_saude" value="t"> Saúde
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_educacao" value="t"> Educação
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_seguranca" value="t"> Segurança
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_meioambiente" value="t"> Meio ambiente
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_emprego" value="t"> Emprego
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_politica" value="t"> Política
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_nenhum" value="t"> Nenhum
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_naosei" value="t"> Não sei
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="assunto_outro" value="t"> Outro
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
                        <input type="checkbox" name="sentimento_alegria" value="t"> Alegria
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_surpresa" value="t"> Surpresa
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_medo" value="t"> Medo
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_tristeza" value="t"> Tristeza
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_raiva" value="t"> Raiva
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_repugnancia" value="t"> Repugnância
                    </label>
                </div>
            </div>
            <div class="col-md-2">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_confianca" value="t"> Confiança
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_expectativa" value="t"> Expectativa
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_nenhum" value="t"> Nenhum
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_naosei" value="t"> Não sei
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="sentimento_outro" value="t"> Outro
                    </label>
                </div>
            </div>
        </div>

        <hr />

        <div>
            <button class="btn btn-default" type="submit" name="botao" value="ok">Enviar</button>
            <button class="btn btn-default" type="submit" name="botao" value="pular">Pular pergunta</button>
            <button class="btn btn-default" type="submit" name="botao" value="cancelar">Cancelar</button>
        </div>
    </div>
    <hr />
    <br />
</form>
@endsection
