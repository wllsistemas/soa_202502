<?php
require_once './core/Request.php';
require_once './core/Response.php';

class SeguimentoController
{
    public function show(Request $request, Response $response)
    {
        return $response->json([
            'message' => 'Listar todos os seguimentos'
        ], 200);
    }

    public function findById(Request $request, Response $response, array $url)
    {
        return $response->json([
            'message' => 'Listar todos os seguimentos por ID'
        ], 200);
    }

    public function add(Request $request, Response $response)
    {
        return $response->json([
            'message' => 'Adicionar um novo seguimento'
        ], 201);
    }

    public function edit(Request $request, Response $response, array $url)
    {
        return $response->json([
            'message' => 'Editar um seguimento existente'
        ], 202);
    }

    public function delete(Request $request, Response $response, array $url)
    {
        return $response->json([
            'message' => 'Excluir um seguimento existente'
        ], 202);
    }
}
