<?php

require_once 'Http.php';

Http::get('/clientes', 'ClienteController@show');
Http::get('/clientes/{id}', 'ClienteController@findById');
Http::post('/clientes', 'ClienteController@add');
Http::put('/clientes/{id}', 'ClienteController@edit');
Http::delete('/clientes/{id}', 'ClienteController@delete');
