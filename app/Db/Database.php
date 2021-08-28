<?php

namespace App\Db;

use \PDO;
use PDOException;

class Database{

    /**
    * Host de Conexão com o banco de dados
    * @var string
    */
    const HOST = 'localhost';

    /**
    * Nome do banco de dados
    * @var string
    */
    const NAME = 'wdev_vagas';

    /**
    * Usuario do banco de dados
    * @var string
    */
    const USER = 'root';

    /**
    * Senha de acesso ao banco de dados
    * @var string
    */
    const PASS = '';

    /**
    * Nome da tabela a ser manipulada
    * @var string
    */
    private $table;

    /**
    * Instancia de conexão com banco de dados
    * @var PDO
    */
    private $connection;

    /**
    * Define a tabela e Instancia conexão
    * @var strint $table
    */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
    * Método responsavel por criar uma conexão com o banco de dados
    */
    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
           die('ERROR: '.$e->getMessage());
        }
    }

    /**
    * Método responsavel por executar query dentro do banco de dados
    * @param string $query
    * @param array $params
    * @return PDOStatement
    */
    public function execute($query, $params = []){
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
           die('ERROR: '.$e->getMessage());
        }
    }

    /**
    * Método responsavel por inserir dados no banco
    * @param array $values [field => value]
    * @return integer ID inserido
    */
    public function insert($values)
    {
        //dados da query
        $fields = array_keys($values);
        $binds = array_pad([],count($fields), '?');

        //monta a query
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        //executa o insert
        $this->execute($query, array_values($values));

        //retorna o ID inserido
        return $this->connection->lastInsertId();

    }


}