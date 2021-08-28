<?php

namespace App\Db;

use \PDO;
use PDOException;

class Database
{

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
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsavel por executar query dentro do banco de dados
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
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
        $binds = array_pad([], count($fields), '?');

        //monta a query
        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        //executa o insert
        $this->execute($query, array_values($values));

        //retorna o ID inserido
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsavel por executar uma consulta no banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //dados da query
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        //monta query
        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        //executa a query
        return $this->execute($query);
    }


    /**
     * Método responsavel por atualizações no banco de dados
     * @param string $where
     * @param array $values [ field => value]
     * @return bolean
     */
    public function update($where, $values)
    {
        //dados query
        $fields = array_keys($values);

        //monta query
        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;

        //executa a query
        $this->execute($query, array_values($values));

        //retorna sucesso
        return true;
    }

    /**
     * Método responsavel por ecluir do banco de dados
     * @param string $where
     * @return bolean
     */
    public function delete($where)
    {

        //monta query
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;

        //executa query
        $this->execute($query);

        //retorna sucesso
        return true;
    }
}
