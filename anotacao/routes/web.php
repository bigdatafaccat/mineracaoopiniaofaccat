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



Route::get('login', 'Auth\LoginController@redirectToProvider');
Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
//Auth::routes();
Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');
Route::post('logout', 'Auth\LoginController@App\Http\Controllers\Auth\LoginController@logout')->name('logout');


//Route::get('login', 'Auth\LoginController@redirectToProvider');

//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'AnotacaoController@exibirSentenca')->name('anotacao')->middleware('auth');
Route::get('/home', 'AnotacaoController@exibirSentenca')->name('anotacao')->middleware('auth');
Route::get('/anotacao', 'AnotacaoController@exibirSentenca')->name('anotacao')->middleware('auth');
Route::get('/anotacaodivergente', 'AnotacaoController@exibirSentencaDivergente')->name('anotacaodivergente')->middleware('auth');

Route::post('/anotar', 'AnotacaoController@registrarAnotacao')->name('anotar')->middleware('auth');
Route::post('/anotardivergente', 'AnotacaoController@registrarAnotacaoDivergente')->name('anotardivergente')->middleware('auth');

Route::get('/orientacao', 'AnotacaoController@orientacao')->name('orientacao')->middleware('auth');