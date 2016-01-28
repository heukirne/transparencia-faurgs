<?php

$app->get('/faurgs/', 'UnidadeController@index');
$app->get('/faurgs/unidade/{id}', 'UnidadeController@unidade');

$app->get('/faurgs/projeto/{id}', 'ProjetoController@detail');
$app->get('/faurgs/projetos', 'ProjetoController@index');

$app->get('/faurgs/pessoa/', 'PessoaController@index');
$app->get('/faurgs/pessoa/{cpf}', 'PessoaController@detail');
$app->get('/faurgs/pessoa/coordenador/{nome}', 'PessoaController@coordenador');
$app->get('/faurgs/busca', 'PessoaController@search');

$app->get('/faurgs/empresa/', 'EmpresaController@index');
$app->get('/faurgs/empresa/{cnpj}', 'EmpresaController@detail');

$app->get('/faurgs/despesa/{id}', 'DespesaController@detail');
$app->get('/faurgs/despesa', 'DespesaController@index');