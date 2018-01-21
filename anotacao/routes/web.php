<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Auth::routes();
//Route::get('login', 'Auth\LoginController@redirectToProvider');

//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home', 'AnotacaoController@exibirSentenca')->name('anotacao')->middleware('auth');
Route::get('/anotacao', 'AnotacaoController@exibirSentenca')->name('anotacao')->middleware('auth');
Route::post('/anotar', 'AnotacaoController@registrarAnotacao')->name('anotar')->middleware('auth');