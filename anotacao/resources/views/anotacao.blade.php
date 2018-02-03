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
                    <h1 class="well">
                        {{$sentenca->texto}}
                    </h1>
                    <hr />
                </div>
            </div>
        </div>

        <div class="row lead">
            <div class="col-md-4 col-md-offset-2">
                Esse texto apresenta opinião:
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2  col-md-offset-2">
                    <label class="radio-inline">
                        <input type="radio" name="opiniao" value="positiva">
                        Positiva
                    </label>
            </div>
            <div class="col-md-2">
                    <label class="radio-inline">
                        <input type="radio" name="opiniao" value="negativa">
                        Negativa
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
            <div class="col-md-7 col-md-offset-2">
                Quais são os assuntos mencionados:
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2 col-md-offset-2">
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
            <div class="col-md-2  col-md-offset-2">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="assunto_politica" value="t"> Política
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

        <hr />

        <div class="row lead">
            <div class="col-md-6 col-md-offset-2">
                Quais emoções/sentimentos você observa nesse texto:
            </div>
        </div>
        <div class="row lead">
            <div class="col-md-2 col-md-offset-2">
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
            <div class="col-md-2 col-md-offset-2">
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
