<?php

define('SGBD', 'postgre');
define('HOST', 'localhost');
define('DBNAME', 'soa_202502');
define('CHARSET', 'utf8');
define('USER', 'postgres');
define('PASSWORD', 'postgres');
define('SERVER', 'windows');
define('PORTA_DB', 5433);

class Conexao
{
    private static $pdo;

    private function __construct() {}

    private static function existsExtension()
    {

        switch (SGBD):
            case 'mysql':
                $extensao = 'pdo_mysql';
                break;
            case 'mssql': {
                    if (SERVER == 'linux') :
                        $extensao = 'pdo_dblib';
                    else :
                        $extensao = 'pdo_sqlsrv';
                    endif;
                    break;
                }
            case 'postgre':
                $extensao = 'pdo_pgsql';
                break;
            default:
                $extensao = '';
        endswitch;

        if (empty($extensao) || !extension_loaded($extensao)) :
            echo "Extensão PDO '{$extensao}' não está habilitada!";
        endif;
    }

    public static function getInstance()
    {
        self::existsExtension();

        if (!isset(self::$pdo)) {

            try {
                switch (SGBD):
                    case 'mysql':
                        $opcoes = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
                        self::$pdo = new \PDO("mysql:host=" . HOST . "; dbname=" . DBNAME . ";port=" . PORTA_DB . ";", USER, PASSWORD, $opcoes);
                        break;
                    case 'mssql': {
                            if (SERVER == 'linux') :
                                self::$pdo = new \PDO("dblib:host=" . HOST . "; database=" . DBNAME . ";", USER, PASSWORD);
                            else :
                                self::$pdo = new \PDO("sqlsrv:server=" . HOST . "; database=" . DBNAME . ";", USER, PASSWORD);
                            endif;
                            break;
                        }
                    case 'postgre':
                        self::$pdo = new \PDO("pgsql:host=" . HOST . "; port=" . PORTA_DB . "; dbname=" . DBNAME . ";", USER, PASSWORD);
                        break;
                endswitch;

                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
        return self::$pdo;
    }

    public static function isConected()
    {

        if (self::$pdo) :
            return true;
        else :
            return false;
        endif;
    }
}

// $conexao = Conexao::getInstance();

// $sql = 'SELECT * FROM cliente WHERE excluido = 0 ORDER BY id';
// $stmt = $conexao->prepare($sql);
// $stmt->execute();
// $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($clientes);

// $sql = 'UPDATE cliente SET excluido = 1 WHERE id = ?';
// $stmt = $conexao->prepare($sql);
// $retorno = $stmt->execute([7]);

// if ($retorno) {
//     echo 'Excluído com sucesso';
// } else {
//     echo 'Falha ao excluir';
// }


// $sql = 'DELETE FROM cliente WHERE id = ?';
// $stmt = $conexao->prepare($sql);
// $retorno = $stmt->execute([8]);

// if ($retorno) {
//     echo 'Deletado com sucesso';
// } else {
//     echo 'Falha ao deletar';
// }

// $sql = 'UPDATE cliente SET nome = ?, sexo = ?, idade = ? WHERE id = ?';
// $stmt = $conexao->prepare($sql);
// $retorno = $stmt->execute(['João Editado', 'M', 45, 8]);

// if ($retorno) {
//     echo 'Editado com sucesso';
// } else {
//     echo 'Falha ao editar';
// }


// $sql = 'INSERT INTO cliente (nome, sexo, idade) VALUES (?, ?, ?)';
// $stmt = $conexao->prepare($sql);
// $retorno = $stmt->execute(['João', 'M', 30]);

// if ($retorno) {
//     echo 'Inserido com sucesso';
// } else {
//     echo 'Falha ao inserir';
// }

// $sql = 'SELECT * FROM cliente ORDER BY id';
// $stmt = $conexao->prepare($sql);
// $stmt->execute();
// $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

// echo "<pre>";
// var_dump($clientes);

// FETCH_ASSOC
// echo $clientes['id'];

// // FETCH_OBJ
// echo $clientes->id;