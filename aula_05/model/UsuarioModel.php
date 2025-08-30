<?php

require_once './core/Conexao.php';
require_once './core/ExceptionPdo.php';

class UsuarioModel
{

    public function selectByEmailAndPassword($email, $senha)
    {
        try {
            $conexao = Conexao::getInstance();

            $sql = 'SELECT * FROM usuario WHERE email = ? AND senha = ?';
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$email, $senha]);

            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
