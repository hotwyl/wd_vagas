<?php

namespace App\Entity;

use \App\Db\Database;
use PDO;

class Vaga
{

    /**
     * Identificador unico da vaga
     * @var integer
     */
    public $id;

    /**
     * Titulo da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga ativa
     * @var string(s/n)
     */
    public $ativo;

    /**
     * Data de publicação da vaga
     * @var string
     */
    public $data;

    /**
     * Método responsavel por cadastrar nova vaga no banco
     * @return boolean
     */
    public function cadastrar()
    {
        //definir a data
        $this->data = date('Y-m-d H:i:s');

        //inserir a vaga no banco e atribuir id da vaga na instancia
        $obDatabase = new Database('vagas');
        $this->id = $obDatabase->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        //retornar sucesso
        return true;
    }

    /**
     * Método responsavel por atualizar a vaga no banco
     * @return boolean
     */

    public function atualizar()
    {

        return (new Database('vagas'))->update('id = ' . $this->id, [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        //retornar sucesso
        return true;
    }

    /**
     * Método responsavel por exluir a vaga do banco
     * @return boolean
     */

    public function excluir()
    {

        return (new Database('vagas'))->delete('id = ' . $this->id);

        //retornar sucesso
        return true;
    }


    /**
     * Método responsavel por obter as vaga do banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('vagas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsavel por obter a quantidade de vagas do banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getQuantidadeVagas($where = null)
    {
        return (new Database('vagas'))->select($where, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
    }

    /**
     * Método responsavel por bucar uma vaga com base no seu id
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id)
    {
        return (new Database('vagas'))->select('id =' . $id)->fetchObject(self::class);
    }
}
