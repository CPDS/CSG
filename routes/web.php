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
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


