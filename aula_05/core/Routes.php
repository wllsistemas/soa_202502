<?php

require_once 'Http.php';

Http::get('/clientes', 'ClienteController@show');
Http::get('/clientes/{id}', 'ClienteController@findById');
Http::post('/clientes', 'ClienteController@add');
Http::put('/clientes/{id}', 'ClienteController@edit');
Http::patch('/clientes/inativar/{id}', 'ClienteController@inactive');
Http::patch('/clientes/ativar/{id}', 'ClienteController@active');
Http::delete('/clientes/{id}', 'ClienteController@delete');

Http::get('/seguimentos', 'SeguimentoController@show');
Http::get('/seguimentos/{id}', 'SeguimentoController@findById');
Http::post('/seguimentos', 'SeguimentoController@add');
Http::put('/seguimentos/{id}', 'SeguimentoController@edit');
Http::delete('/seguimentos/{id}', 'SeguimentoController@delete');
