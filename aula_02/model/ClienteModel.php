<?php

require_once './core/Conexao.php';
require_once './core/ExceptionPdo.php';


class ClienteModel
{
    public function selectAll()
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'SELECT * FROM cliente WHERE excluido = 0 ORDER BY id';
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

            $sql = 'SELECT * FROM cliente WHERE id = ?';
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

    public function insert($dados)
    {
        try {
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update($dados)
    {
        try {
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function inactiveClient($id)
    {
        try {
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
