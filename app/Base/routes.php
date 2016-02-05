<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('faurgs/', function () {
        return view('welcome');
    });

	Route::get('/faurgs/unidades', 'UnidadeController@index');
	Route::get('/faurgs/unidade/{id}', 'UnidadeController@unidade');

	Route::get('/faurgs/projeto/{id}', 'ProjetoController@detail');
	Route::get('/faurgs/projetos', 'ProjetoController@index');

	Route::get('/faurgs/pessoa/', 'PessoaController@index');
	Route::get('/faurgs/pessoa/{cpf}', 'PessoaController@detail');
	Route::get('/faurgs/pessoa/coordenador/{nome}', 'PessoaController@coordenador');
	Route::get('/faurgs/busca', 'PessoaController@search');
	Route::get('/faurgs/fetch/{cpf}', 'PessoaController@fetch');

	Route::get('/faurgs/empresa/', 'EmpresaController@index');
	Route::get('/faurgs/empresa/{cnpj}', 'EmpresaController@detail');

	Route::get('/faurgs/despesa/{id}', 'DespesaController@detail');
	Route::get('/faurgs/despesa', 'DespesaController@index');

	Route::get('/faurgs/auth/social/{provider}', 'SocialLoginController@redirectToProvider');
	Route::get('/faurgs/auth/{provider}/callback', 'SocialLoginController@handleProviderCallback');
	Route::get('/faurgs/auth/logout', 'SocialLoginController@getLogout');

});