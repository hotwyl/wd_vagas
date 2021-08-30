<?php

namespace App\Session;

class Login
{

    /**
     * Método responsavel por iniciar a sessão
     */
    private static function init()
    {
        //verifica status da sessão
        if (session_status() !== PHP_SESSION_ACTIVE) {
            //inicia a sessão
            session_start();
        }
    }

    /**
     * Método responsavel por retornar os dados do usuario logado
     */
    public static function getUsuarioLogado()
    {
        //inicia a sessão
        self::init();

        //retorna dados do usuario
        return self::isLogged() ? $_SESSION['usuario'] : null;
    }

    /**
     * Método responsavel por logar usuario
     * @param Usuario $obUsuario
     */
    public static function login($obUsuario)
    {
        //inicia a sessão
        self::init();

        //sessão de usuario
        $_SESSION['usuario'] = [
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email
        ];

        //redirecionar usuario para index
        header('location: index.php');
        exit;
    }

    /**
     * Método responsavel por deslogar o usuario
     */
    public static function logout()
    {
        //inicia a sessão
        self::init();

        //Remove a sessão de usuario
        unset($_SESSION['usuario']);

        //redirecionar usuario para login
        header('location: login.php');
        exit;
    }

    /**
     * Método responsavel por verificar se o usuario está Logado
     * @return bolean
     */
    public static function isLogged()
    {
        //inicia a sessão
        self::init();

        //validação da sessão
        return isset($_SESSION['usuario']['id']);
    }

    /**
     * Método responsavel por obrigar o usuario estar Logado para acessar
     */
    public static function requireLogin()
    {
        if (!self::isLogged()) {
            header('location: login.php');
            exit;
        }
    }

    /**
     * Método responsavel por obrigar o usuario estar deslogado para acessar
     */
    public static function requireLogout()
    {
        if (self::isLogged()) {
            header('location: index.php');
            exit;
        }
    }
}
