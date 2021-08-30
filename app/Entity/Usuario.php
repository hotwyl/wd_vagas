<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Usuario
{

    /**
     * Identificador único do usuario
     * @var Integer
     */
    public $id;

    /**
     * Nome do usuario
     * @var string
     */
    public $nome;

    /**
     * Email do usuario
     * @var string
     */
    public $email;

    /**
     * Hash da senha do usuario
     * @var string
     */
    public $senha;

    /**
     * Método responsável por cadastrar um novo usuário no banco
     * @return boolean
     */
    public function cadastrar()
    {
        //Database
        $obDatabase = new Database('usuarios');

        //insere um novo usuario
        $this->id = $obDatabase->insert([
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);

        //sucesso
        return true;
    }

    /**
     * Método responsável por retornar um usuario com base em seu email
     * @paream string $email
     * @return Usuario
     */
    public static function getUsuarioPorEmail($email)
    {
        return (new Database('usuarios'))->select('email="' . $email . '"')->fetchObject(self::class);
    }
}
