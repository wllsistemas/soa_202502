<?php
require_once './core/Request.php';
require_once './core/Response.php';
require_once './model/ClienteModel.php';
require_once './model/SeguimentoModel.php';

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

        $nome = trim($campos['nome']);
        $sexo = trim($campos['sexo']);
        $sexo = strtoupper($sexo);
        $seguimento = trim(strtoupper($campos['seguimento']));
        $idade = trim($campos['idade']);

        // VALIDAÇÃO
        if (empty($nome)) {
            return $response->json([
                'message' => 'O campo nome é obrigatório',
            ], 400);
        } else if (strlen($nome) < 3) {
            return $response->json([
                'message' => 'O campo nome deve ter no mínimo 3 caracteres',
            ], 400);
        }

        if (empty($sexo)) {
            return $response->json([
                'message' => 'O campo sexo é obrigatório',
            ], 400);
        } else if (strlen($sexo) != 1) {
            return $response->json([
                'message' => 'O campo sexo deve ter exatamente 1 caractere',
            ], 400);
        } else if (!in_array($sexo, ['M', 'F'])) {
            return $response->json([
                'message' => 'O campo sexo deve ser M ou F',
            ], 400);
        }

        if ($idade === '' || $idade === null) {
            return $response->json([
                'message' => 'O campo idade é obrigatório',
            ], 400);
        } else if (!is_numeric($idade) || $idade < 1 || $idade > 150) {
            return $response->json([
                'message' => 'O campo idade deve ser um número entre 1 e 150',
            ], 400);
        }

        if (empty($seguimento)) {
            return $response->json([
                'message' => 'O campo seguimento é obrigatório',
            ], 400);
        }

        $clienteModel = new ClienteModel();

        // TRANSFORMAÇÕES
        $nome = strtoupper($nome);

        // VERIFICA DUPLICAÇÕES NO BANCO DE DADOS
        $clienteExistente = $clienteModel->selectByNome($nome);
        if ($clienteExistente) {
            return $response->json([
                'message' => "Já existe um cliente cadastrado com o nome $nome",
            ], 406);
        }

        // VERIFICAR SE O SEGUIMENTO EXISTE
        $seguimentoModel = new SeguimentoModel();
        $seguimentoExistente = $seguimentoModel->selectByDescricao($seguimento);

        if (empty($seguimentoExistente)) {
            // CADASTRAR SEGUIMENTO
            $seguimentoModel->insert(['descricao' => $seguimento]);
            $seguimentoExistente = $seguimentoModel->selectByDescricao($seguimento);
        }

        // CAPTURAR O ID DO SEGUIMENTO
        $seguimento_id = $seguimentoExistente->id;

        // INSERE NO BANCO DE DADOS
        $sucesso = $clienteModel->insert([
            'nome' => $nome,
            'sexo' => $sexo,
            'idade' => $idade,
            'excluido' => 0,
            'status' => 'ATIVO',
            'seguimento_id' => $seguimento_id
        ]);

        if ($sucesso) {
            return $response->json([
                'message' => "Cliente $nome cadastrado com sucesso",
            ], 201);
        } else {
            return $response->json([
                'message' => "Houve um erro ao cadastrar o cliente",
            ], 500);
        }
    }

    public function edit(Request $request, Response $response, array $url)
    {
        $campos = $request->body();

        $id = $url[0];
        $nome = $campos['nome'];
        $sexo = $campos['sexo'];
        $idade = $campos['idade'];

        $clienteModel = new ClienteModel();
        $sucesso = $clienteModel->update([
            'nome' => $nome,
            'sexo' => $sexo,
            'idade' => $idade,
            'status' => 'ATIVO',
            'id' => $id
        ]);

        if ($sucesso) {
            return $response->json([
                'message' => "Cliente $nome atualizado com sucesso",
            ], 202);
        } else {
            return $response->json([
                'message' => "Houve um erro ao atualizar o cliente",
            ], 500);
        }
    }

    public function delete(Request $request, Response $response, array $url)
    {
        $id = $url[0];

        $clienteModel = new ClienteModel();

        $clienteExistente = $clienteModel->selectById($id);
        if (!$clienteExistente) {
            return $response->json([
                'message' => "Cliente com ID $id não encontrado",
            ], 404);
        }

        $sucesso = $clienteModel->delete($id);

        if ($sucesso) {
            return $response->json([
                'message' => 'Cliente excluído com sucesso',
            ], 202);
        } else {
            return $response->json([
                'message' => 'Houve um erro ao excluir o cliente',
            ], 500);
        }
    }

    public function inactive(Request $request, Response $response, array $url)
    {
        // $dados = $request->header('Authorization');
        // $dados = str_replace('Basic ', '', $dados);
        // $dados = base64_decode($dados);
        // var_dump($dados);
        // exit;

        $id = $url[0];

        $clienteModel = new ClienteModel();

        $clienteExistente = $clienteModel->selectById($id);
        if (!$clienteExistente) {
            return $response->json([
                'message' => "Cliente com ID $id não encontrado",
            ], 404);
        }

        $sucesso = $clienteModel->inactiveClient($id);

        if ($sucesso) {
            return $response->json([
                'message' => 'Cliente inativado com sucesso',
            ], 202);
        } else {
            return $response->json([
                'message' => 'Houve um erro ao inativar o cliente',
            ], 500);
        }
    }

    public function active(Request $request, Response $response, array $url)
    {
        $id = $url[0];

        $clienteModel = new ClienteModel();

        $clienteExistente = $clienteModel->selectById($id);
        if (!$clienteExistente) {
            return $response->json([
                'message' => "Cliente com ID $id não encontrado",
            ], 404);
        }

        $sucesso = $clienteModel->activeClient($id);

        if ($sucesso) {
            return $response->json([
                'message' => 'Cliente ativado com sucesso',
            ], 202);
        } else {
            return $response->json([
                'message' => 'Houve um erro ao ativar o cliente',
            ], 500);
        }
    }
}
