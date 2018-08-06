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
    return view('material.index');
});

Route::group(['middleware' => 'auth'], function () {

Route::group(['prefix' => 'gerenciar-materiais', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-materiais.index', 'uses' => 'MaterialController@index']);
        Route::get('/list',['as' => 'gerenciar-materiais.list', 'uses' => 'MaterialController@list']);
        Route::post('/store', ['as' => 'gerenciar-materiais.store', 'uses' => 'MaterialController@store']);
        Route::post('/update', ['as' => 'gerenciar-materiais.update', 'uses' => 'MaterialController@update']);
        Route::post('/delete', ['as' => 'gerenciar-materiais.destroy', 'uses' => 'MaterialController@destroy']);
}); 	

Route::group(['prefix' => 'gerenciar-licitacoes', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-licitacoes.index', 'uses' => 'LicitacaoController@index']);
        Route::get('/list',['as' => 'gerenciar-licitacoes.list', 'uses' => 'LicitacaoController@list']);
        Route::post('/store', ['as' => 'gerenciar-licitacoes.store', 'uses' => 'LicitacaoController@store']);
        Route::post('/update', ['as' => 'gerenciar-licitacoes.update', 'uses' => 'LicitacaoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-licitacoes.destroy', 'uses' => 'LicitacaoController@destroy']);
}); 	


Route::group(['prefix' => 'gerenciar-setores', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-setores.index', 'uses' => 'SetorController@index']);
        Route::get('/list',['as' => 'gerenciar-setores.list', 'uses' => 'SetorController@list']);
        Route::post('/store', ['as' => 'gerenciar-setores.store', 'uses' => 'SetorController@store']);
        Route::post('/update', ['as' => 'gerenciar-setores.update', 'uses' => 'SetorController@update']);
        Route::post('/delete', ['as' => 'gerenciar-setores.destroy', 'uses' => 'SetorController@destroy']);
});     

Route::group(['prefix' => 'gerenciar-servidores', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-servidores.index', 'uses' => 'ServidorController@index']);
        Route::get('/list',['as' => 'gerenciar-servidores.list', 'uses' => 'ServidorController@list']);
        Route::post('/store', ['as' => 'gerenciar-servidores.store', 'uses' => 'ServidorController@store']);
        Route::post('/update', ['as' => 'gerenciar-servidores.update', 'uses' => 'ServidorController@update']);
        Route::post('/delete', ['as' => 'gerenciar-servidores.destroy', 'uses' => 'ServidorController@destroy']);
});    

Route::group(['prefix' => 'gerenciar-escalas', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-escalas.index', 'uses' => 'EscalaHorarioController@index']);
        Route::get('/list',['as' => 'gerenciar-escalas.list', 'uses' => 'EscalaHorarioController@list']);
        Route::post('/store', ['as' => 'gerenciar-escalas.store', 'uses' => 'EscalaHorarioController@store']);
        Route::post('/update', ['as' => 'gerenciar-escalas.update', 'uses' => 'EscalaHorarioController@update']);
        Route::post('/delete', ['as' => 'gerenciar-escalas.destroy', 'uses' => 'EscalaHorarioController@destroy']);
}); 

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


