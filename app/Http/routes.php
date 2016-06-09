<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

//Categorias
Route::group(['prefix' => 'categorias', 'middleware' => 'auth:api'], function () {
    Route::get('/index', 'CategoriaController@index')->name('categorias.index');
    Route::post('/store', 'CategoriaController@store')->name('categorias.store');
    Route::get('/show/{id}', 'CategoriaController@show')->name('categorias.show');
    Route::put('/update/{id}', 'CategoriaController@update')->name('categorias.update');
    Route::delete('/destroy/{id}', 'CategoriaController@destroy')->name('categorias.destroy');
});

//Categorias
Route::group(['prefix' => 'tiposrespuesta', 'middleware' => 'auth:api'], function () {
    Route::get('/index', 'TipoRespuestaController@index')->name('tiposrespuesta.index');
    Route::post('/store', 'TipoRespuestaController@store')->name('tiposrespuesta.store');
    Route::get('/show/{id}', 'TipoRespuestaController@show')->name('tiposrespuesta.show');
    Route::put('/update/{id}', 'TipoRespuestaController@update')->name('tiposrespuesta.update');
    Route::delete('/destroy/{id}', 'TipoRespuestaController@destroy')->name('tiposrespuesta.destroy');
});

//Preguntas
Route::group(['prefix' => 'preguntas', 'middleware' => 'auth:api'], function () {
    Route::get('/index', 'PreguntaController@index')->name('preguntas.index');
    Route::post('/store', 'PreguntaController@store')->name('preguntas.store');
    Route::get('/show/{id}', 'PreguntaController@show')->name('preguntas.show');
    Route::put('/update/{id}', 'PreguntaController@update')->name('preguntas.update');
    Route::delete('/destroy/{id}', 'PreguntaController@destroy')->name('preguntas.destroy');
});