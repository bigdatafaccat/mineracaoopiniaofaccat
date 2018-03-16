@extends('layouts.app')

@section('content')
<form name="formulario" action="{{route('anotar')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="t" value="{{md5($sentenca->idsentenca.'anotacao')}}" />
    <input type="hidden" name="s" value="{{$sentenca->idsentenca}}" />
    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1 class="text-center">Avaliação de opiniões</h1>
                <h1>Parte 1</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="">

                    @if($sentenca->tipo_texto == 'post')
                        <div class="lead">Leia o seguinte texto:</div>
                        <hr />
                        <h1 class="well">
                            {{$sentenca->post_texto}}
                        </h1>
                    @elseif($sentenca->tipo_texto == 'comentario')
                        <div class="lead">Leia o seguinte texto:</div>
                        <hr />
                        <h1 class="well">
                            {{$sentenca->post_texto}}
                        </h1>
                        <hr />
                        <div class="lead">Agora leia o seguinte texto:</div>
                        <hr />
                        <h1 class="well">
                            {{$sentenca->comentario_texto}}
                        </h1>
                    @elseif($sentenca->tipo_texto == 'comentario_de_comentario')
                        <div class="lead">Leia o seguinte texto:</div>
                        <hr />
                        <h1 class="well">
                            {{$sentenca->post_texto}}
                        </h1>
                        <hr />
                        <div class="lead">Agora leia o seguinte texto:</div>
                        <hr />
                        <h1 class="well">
                            {{$sentenca->comentario_comentario_texto}}
                        </h1>
                    @endif

                </div>
            </div>
        </div>


        <div class="row lead">
            <div class="col-md-9 col-md-offset-1">
                @if($sentenca->tipo_texto == 'post')
                    O texto acima fala sobre algum assunto que possa estar relacionado aos municípios do Vale do Paranhana (Taquara, Igrejinha, Parobé, Três Coroas, etc...)?
                @else
                    Os dois textos acima falam sobre algum assunto que possa estar relacionado aos municípios do Vale do Paranhana (Taquara, Igrejinha, Parobé, Três Coroas, etc...)?
                @endif
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2 col-md-offset-1">
                <label class="radio-inline">
                    <input type="radio" name="vale_paranhana" value="t"> Sim
                </label>
            </div>
            <div class="col-md-2">
                <label class="radio-inline">
                    <input type="radio" name="vale_paranhana" value="f"> Não
                </label>
            </div>
        </div>

        <hr />

        <div class="row lead">
            <div class="col-md-7 col-md-offset-1">
                Quais são os assuntos mencionados:
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2 col-md-offset-1">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_saude" value="t"> Saúde
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_educacao" value="t"> Educação
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_seguranca" value="t"> Segurança
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_meioambiente" value="t"> Meio ambiente
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_emprego" value="t"> Emprego
                </label>
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2  col-md-offset-1">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_politica" value="t"> Política
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_transito" value="t"> Trânsito
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_nenhum" value="t"> Nenhum
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="assunto_naosei" value="t"> Não sei
                </label>
            </div>
        </div>

        <br />
        <br />
        <hr />

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Parte 2</h1>
            </div>
        </div>

        <div class="row lead">
            <div class="col-md-10 col-md-offset-1">
                <div class="lead">
                    Agora leia o seguinte trecho e depois responda as perguntas abaixo:
                </div>


                <hr />
                <h1 class="well">
                    {{$sentenca->texto}}
                </h1>
            </div>
        </div>

        <div class="row lead">
            <div class="col-md-4 col-md-offset-1">
                Esse texto apresenta opinião:
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-3  col-md-offset-1">
                <label class="radio-inline">
                    <input type="radio" name="opiniao" value="positiva">
                    Algo de bom ou positivo é apresentado no texto
                </label>
            </div>
            <div class="col-md-4">
                <label class="radio-inline">
                    <input type="radio" name="opiniao" value="negativa">
                    Algo de ruim ou negativo é apresentado no texto
                </label>
            </div>
            <div class="col-md-2">
                <label class="radio-inline">
                    <input type="radio" name="opiniao" value="nenhuma">
                    Não há
                </label>
            </div>
            <div class="col-md-2">
                <label class="radio-inline">
                    <input type="radio" name="opiniao" value="naosei">
                    Não sei
                </label>
            </div>
        </div>


        <hr />

        <div class="row lead">
            <div class="col-md-6 col-md-offset-1">
                Quais emoções/sentimentos você observa nesse texto:
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2 col-md-offset-1">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_alegria" value="t"> Alegria
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_surpresa" value="t"> Surpresa
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_medo" value="t"> Medo
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_tristeza" value="t"> Tristeza
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_raiva" value="t"> Raiva
                </label>
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2 col-md-offset-1">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_repugnancia" value="t"> Repugnância
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_confianca" value="t"> Confiança
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_expectativa" value="t"> Expectativa
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_nenhum" value="t"> Nenhum
                </label>
            </div>
            <div class="col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="sentimento_naosei" value="t"> Não sei
                </label>
            </div>
        </div>

        <hr />

        <div>
            <button class="btn btn-primary btn-lg" type="submit" name="botao" value="ok">Enviar resposta</button>
            <button class="btn btn-default pull-right" type="submit" name="botao" value="pular">Pular pergunta</button>
            <button class="btn btn-default pull-right" type="submit" name="botao" value="cancelar">Cancelar</button>
        </div>
    </div>
    <hr />
    <br />
</form>
@endsection
