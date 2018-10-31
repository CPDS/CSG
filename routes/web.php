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

Route::get('/contratada', function () {
    return view('contratada.index');
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

Route::group(['prefix' => 'gerenciar-baixa-itens', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-baixa-itens.index', 'uses' => 'BaixaItemController@index']);
        Route::get('/list',['as' => 'gerenciar-baixa-itens.list', 'uses' => 'BaixaItemController@list']);
        Route::post('/store', ['as' => 'gerenciar-baixa-itens.store', 'uses' => 'BaixaItemController@store']);
        Route::post('/update', ['as' => 'gerenciar-baixa-itens.update', 'uses' => 'BaixaItemController@update']);
        Route::post('/delete', ['as' => 'gerenciar-baixa-itens.destroy', 'uses' => 'BaixaItemController@destroy']);
});     

Route::group(['prefix' => 'gerenciar-contratos', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-contratos.index', 'uses' => 'ContratoController@index']);
        Route::get('/list',['as' => 'gerenciar-contratos.list', 'uses' => 'ContratoController@list']);
        Route::get('/itens/{id}',['as' => 'gerenciar-contratos.itens', 'uses' => 'ContratoController@itens']);
        Route::post('/store', ['as' => 'gerenciar-contratos.store', 'uses' => 'ContratoController@store']);
        Route::post('/update', ['as' => 'gerenciar-contratos.update', 'uses' => 'ContratoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-contratos.destroy', 'uses' => 'ContratoController@destroy']);
}); 	


Route::group(['prefix' => 'gerenciar-setores', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-setores.index', 'uses' => 'SetorController@index']);
        Route::get('/list',['as' => 'gerenciar-setores.list', 'uses' => 'SetorController@list']);
        Route::post('/store', ['as' => 'gerenciar-setores.store', 'uses' => 'SetorController@store']);
        Route::post('/update', ['as' => 'gerenciar-setores.update', 'uses' => 'SetorController@update']);
        Route::post('/delete', ['as' => 'gerenciar-setores.destroy', 'uses' => 'SetorController@destroy']);
}); 

Route::group(['prefix' => 'gerenciar-servicos', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-servicos.index', 'uses' => 'ServicoController@index']);
        Route::get('/list',['as' => 'gerenciar-servicos.list', 'uses' => 'ServicoController@list']);
        Route::post('/store', ['as' => 'gerenciar-servicos.store', 'uses' => 'ServicoController@store']);
        Route::post('/update', ['as' => 'gerenciar-servicos.update', 'uses' => 'ServicoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-servicos.destroy', 'uses' => 'ServicoController@destroy']);
});     

Route::group(['prefix' => 'gerenciar-users', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-users.index', 'uses' => 'UserController@index']);
        Route::get('/list',['as' => 'gerenciar-users.list', 'uses' => 'UserController@list']);
        Route::post('/store', ['as' => 'gerenciar-users.store', 'uses' => 'UserController@store']);
        Route::post('/update', ['as' => 'gerenciar-users.update', 'uses' => 'UserController@update']);
        Route::post('/delete', ['as' => 'gerenciar-users.destroy', 'uses' => 'UserController@destroy']);
});    

Route::group(['prefix' => 'gerenciar-escalas', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-escalas.index', 'uses' => 'EscalaHorarioController@index']);
        Route::get('/list',['as' => 'gerenciar-escalas.list', 'uses' => 'EscalaHorarioController@list']);
        Route::post('/store', ['as' => 'gerenciar-escalas.store', 'uses' => 'EscalaHorarioController@store']);
        Route::post('/update', ['as' => 'gerenciar-escalas.update', 'uses' => 'EscalaHorarioController@update']);
        Route::post('/delete', ['as' => 'gerenciar-escalas.destroy', 'uses' => 'EscalaHorarioController@destroy']);
}); 

Route::group(['prefix' => 'gerenciar-itens', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-itens.index', 'uses' => 'ItemContratoController@index']);
        Route::get('/list',['as' => 'gerenciar-itens.list', 'uses' => 'ItemContratoController@list']);
        Route::post('/store', ['as' => 'gerenciar-itens.store', 'uses' => 'ItemContratoController@store']);
        Route::post('/update', ['as' => 'gerenciar-itens.update', 'uses' => 'ItemContratoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-itens.destroy', 'uses' => 'ItemContratoController@destroy']);
}); 

Route::group(['prefix' => 'gerenciar-horas', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-horas.index', 'uses' => 'HoraExtraController@index']);
        Route::get('/list',['as' => 'gerenciar-horas.list', 'uses' => 'HoraExtraController@list']);
        Route::post('/store', ['as' => 'gerenciar-horas.store', 'uses' => 'HoraExtraController@store']);
        Route::post('/update', ['as' => 'gerenciar-horas.update', 'uses' => 'HoraExtraController@update']);
        Route::post('/delete', ['as' => 'gerenciar-horas.destroy', 'uses' => 'HoraExtraController@destroy']);
}); 

Route::group(['prefix' => 'gerenciar-solicitacao-tipos', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-solicitacao-tipos.index', 'uses' => 'SolicitacaoTipoController@index']);
        Route::get('/list',['as' => 'gerenciar-solicitacao-tipos.list', 'uses' => 'SolicitacaoTipoController@list']);
        Route::post('/store', ['as' => 'gerenciar-solicitacao-tipos.store', 'uses' => 'SolicitacaoTipoController@store']);
        Route::post('/update', ['as' => 'gerenciar-solicitacao-tipos.update', 'uses' => 'SolicitacaoTipoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-solicitacao-tipos.destroy', 'uses' => 'SolicitacaoTipoController@destroy']);
}); 

Route::group(['prefix' => 'gerenciar-entradas-materiais', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-entradas-materiais.index', 'uses' => 'EntradaMaterialController@index']);
        Route::get('/list',['as' => 'gerenciar-entradas-materiais.list', 'uses' => 'EntradaMaterialController@list']);
        Route::post('/store', ['as' => 'gerenciar-entradas-materiais.store', 'uses' => 'EntradaMaterialController@store']);
        Route::post('/update', ['as' => 'gerenciar-entradas-materiais.update', 'uses' => 'EntradaMaterialController@update']);
        Route::post('/delete', ['as' => 'gerenciar-entradas-materiais.destroy', 'uses' => 'EntradaMaterialController@destroy']);
}); 

Route::group(['prefix' => 'gerenciar-encaminhamentos', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-encaminhamentos.index', 'uses' => 'EncaminhamentoController@index']);
        Route::get('/list',['as' => 'gerenciar-encaminhamentos.list', 'uses' => 'EncaminhamentoController@list']);
        Route::post('/store', ['as' => 'gerenciar-encaminhamentos.store', 'uses' => 'EncaminhamentoController@store']);
        Route::post('/update', ['as' => 'gerenciar-encaminhamentos.update', 'uses' => 'EncaminhamentoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-encaminhamentos.destroy', 'uses' => 'EncaminhamentoController@destroy']);
}); 


Route::group(['prefix' => 'gerenciar-solicitacoes', 'where' => ['id' => '[0-9]+'], 'middleware' => ['role:Administrador']] ,function() {
        Route::get('', ['as' => 'gerenciar-solicitacoes.index', 'uses' => 'SolicitacaoController@index']);
        Route::get('/list',['as' => 'gerenciar-solicitacoes.list', 'uses' => 'SolicitacaoController@list']);
        Route::post('/store', ['as' => 'gerenciar-solicitacoes.store', 'uses' => 'SolicitacaoController@store']);
        Route::post('/update', ['as' => 'gerenciar-solicitacoes.update', 'uses' => 'SolicitacaoController@update']);
        Route::post('/delete', ['as' => 'gerenciar-solicitacoes.destroy', 'uses' => 'SolicitacaoController@destroy']);
}); 

});


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


