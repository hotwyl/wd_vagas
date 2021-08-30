<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Usuario;
use \App\Session\Login;


//obriga usuario a não estar logado
Login::requireLogout();

//mensagens de alerta dos formularios
$alertaLogin = '';
$alertaCadastro = '';

//validação do post
if (isset($_POST['acao'])) {
    switch ($_POST['acao']) {
        case 'logar':

            //busca usuario por email
            $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);

            //valida a instancia e a senha
            if (!$obUsuario instanceof Usuario || !password_verify($_POST['senha'], $obUsuario->senha)) {
                $alertaLogin = 'E-mail ou senha inválidos';
                break;
            }

            //loga usuario
            Login::login($obUsuario);

            break;
        case 'cadastrar':

            //validação dos campos obrigatórios
            if (isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {

                //busca usuario por email
                $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);
                if ($obUsuario instanceof Usuario) {
                    $alertaCadastro = 'O e-mail digitado já está em uso';
                    break;
                }

                //novo usuario
                $obUsuario = new Usuario;
                $obUsuario->nome = $_POST['nome'];
                $obUsuario->email = $_POST['email'];
                $obUsuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $obUsuario->cadastrar();

                //loga usuario
                Login::login($obUsuario);
            }

            break;
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario-login.php';
include __DIR__ . '/includes/footer.php';
