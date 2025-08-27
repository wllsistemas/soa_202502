<?php

require_once './core/Conexao.php';
require_once './core/ExceptionPdo.php';

class SeguimentoModel
{
    public function selectByDescricao($descricao)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'SELECT * FROM seguimento WHERE descricao = ?';
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$descricao]);

            return $stmt->fetch(\PDO::FETCH_OBJ);
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

            $sql = 'INSERT INTO seguimento (descricao) VALUES (?)';
            $stmt = $conexao->prepare($sql);
            $retorno = $stmt->execute([$dados['descricao']]);

            return $retorno;
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
