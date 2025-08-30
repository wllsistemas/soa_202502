<?php

require_once './core/Conexao.php';
require_once './core/ExceptionPdo.php';


class ClienteModel
{
    public function selectAll()
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'SELECT c.*, s.descricao as seguimento
                    FROM cliente c
                    JOIN seguimento s on s.id = c.seguimento_id
                    WHERE excluido = 0
                    ORDER BY id DESC';
            $stmt = $conexao->prepare($sql);
            $stmt->execute();
            $clientes = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $clientes;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function selectById($id)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'SELECT * FROM cliente WHERE id = ? and excluido = 0';
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$id]);
            $cliente = $stmt->fetch(PDO::FETCH_OBJ);

            return $cliente;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function selectByNome($nome)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'SELECT * FROM cliente WHERE nome = ? AND excluido = 0';
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$nome]);
            $cliente = $stmt->fetch(PDO::FETCH_OBJ);

            return $cliente;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function insert($dados)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'INSERT INTO cliente (nome, sexo, idade, excluido, status, seguimento_id) VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = $conexao->prepare($sql);
            $retorno = $stmt->execute([
                $dados['nome'],
                $dados['sexo'],
                $dados['idade'],
                $dados['excluido'],
                $dados['status'],
                $dados['seguimento_id']
            ]);

            return $retorno;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update($dados)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'UPDATE cliente SET nome = ?, sexo = ?, idade = ?, status = ? WHERE id = ?';
            $stmt = $conexao->prepare($sql);
            $retorno = $stmt->execute([$dados['nome'], $dados['sexo'], $dados['idade'], $dados['status'], $dados['id']]);

            return $retorno;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'UPDATE cliente SET excluido = ? WHERE id = ?';
            $stmt = $conexao->prepare($sql);
            $retorno = $stmt->execute([1, $id]);

            return $retorno;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function inactiveClient($id)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'UPDATE cliente SET status = ? WHERE id = ?';
            $stmt = $conexao->prepare($sql);
            $retorno = $stmt->execute(['INATIVO', $id]);

            return $retorno;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function activeClient($id)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'UPDATE cliente SET status = ? WHERE id = ?';
            $stmt = $conexao->prepare($sql);
            $retorno = $stmt->execute(['ATIVO', $id]);

            return $retorno;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
