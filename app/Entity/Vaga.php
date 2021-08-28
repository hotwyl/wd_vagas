<?php

namespace App\Entity;

use \App\Db\Database;

class Vaga{

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
    public function cadastrar(){
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

    //    echo "<pre>"; print_r($this); echo "</pre>"; exit;

        //retornar sucesso
        return true;
    }

}