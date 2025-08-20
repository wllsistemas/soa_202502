<?php
require_once './core/Request.php';
require_once './core/Response.php';
require_once './model/ClienteModel.php';

class ClienteController
{

    public function show(Request $request, Response $response)
    {
        $clienteModel = new ClienteModel();
        $registros = $clienteModel->selectAll();

        if (empty($registros)) {
            return $response->json([
                'message' => 'Não existem clientes'
            ], 404);
        }

        return $response->json([
            'clientes' => $registros
        ], 200);
    }

    public function findById(Request $request, Response $response, array $url)
    {
        $id = $url[0];

        if (!is_numeric($id)) {
            return $response->json([
                'message' => 'ID deve ser numérico'
            ], 406);
        }

        $clienteModel = new ClienteModel();
        $registro = $clienteModel->selectById($id);

        if (empty($registro)) {
            return $response->json([
                'message' => 'Cliente não encontrado'
            ], 404);
        }

        return $response->json([
            'cliente' => $registro
        ], 200);
    }

    public function add(Request $request, Response $response)
    {
        $campos = $request->body();

        $nome = $campos['nome'];
        $faculdade = $campos['instituicao'];

        return $response->json([
            'message' => "Cliente $nome cadastrado com sucesso",
        ], 201);
    }

    public function edit(Request $request, Response $response)
    {
        $campos = $request->body();

        $descricao = $campos['descricao'];
        $valor_unitario = $campos['valor'];

        return $response->json([
            'message' => "Produto $descricao atualizado com sucesso",
        ], 202);
    }

    public function delete(Request $request, Response $response)
    {
        return $response->json([
            'message' => 'Cliente excluído com sucesso',
        ], 202);
    }
}
