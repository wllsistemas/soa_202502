<?php
require_once './core/Request.php';
require_once './core/Response.php';

class ClienteController{

    public function show(Request $request, Response $response){
       return $response->json([
        'message' => 'Não existem clientes'
       ], 404);
    }

    public function findById(Request $request, Response $response, array $url){
        $id = $url[0];

        if (!is_numeric($id)){
            return $response->json([
                'message' => 'ID deve ser numérico'
            ], 406);
        }

        return $response->json([
        'message' => 'Cliente encontrado'
       ], 200);
    }

    public function add(Request $request, Response $response){
        $campos = $request->body();

        $nome = $campos['nome'];
        $faculdade = $campos['instituicao'];

        return $response->json([
            'message' => "Cliente $nome cadastrado com sucesso",
        ], 201);
    }

    public function edit(Request $request, Response $response){
        $campos = $request->body();

        $descricao = $campos['descricao'];
        $valor_unitario = $campos['valor'];

        return $response->json([
            'message' => "Produto $descricao atualizado com sucesso",
        ], 202);
    }

    public function delete(Request $request, Response $response){
        return $response->json([
            'message' => 'Cliente excluído com sucesso',
        ], 202);
    }
    
}