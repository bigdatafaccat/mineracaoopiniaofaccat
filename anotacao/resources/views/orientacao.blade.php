@extends('layouts.app')

@section('content')
        <div class="container">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h1 class="text-center">Avaliação de opiniões</h1>
                </div>
            </div>

            <hr />

            <div class="row lead text-justify">
                <div class="col-md-10 col-md-offset-1">
                    Olá, estamos realizando uma pesquisa para identificar como a população do Vale do Paranhana
                    avalia assuntos temáticos (Saúde, Educação, Segurança) por meio de postagens e comentários no Facebook.
                    Está sendo desenvolvido um modelo de inteligência artificial (IA) que fará essa classificação automaticamente.

                </div>
            </div>

            <div class="row lead text-justify">
                <div class="col-md-10 col-md-offset-1">
                    Necessitamos que você leia alguns comentários e postagens e responda algumas questões.
                </div>
            </div>

            <div class="row lead text-justify">
                <div class="col-md-10 col-md-offset-1">
                    Caso você não se sinta a vontade ou confortável com algum dos textos apresentados, poderá pular
                    a questão ou interromper o processo de anotação.
                </div>
            </div>

            <div class="row lead text-justify">
                <div class="col-md-10 col-md-offset-1">
                    Desde já agradecemos sua colaboração.
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-md-offset-5 col-md-2">
                    <a href="{{route('anotacao')}}" class="btn btn-primary btn-lg" type="submit" name="botao">Prosseguir</a>
                </div>
            </div>
        </div>
        <hr />
        <br />
@endsection