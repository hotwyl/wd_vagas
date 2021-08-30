<?php

require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Editar Vaga');

use \App\Entity\Vaga;
use \App\Session\Login;

//obriga usuario a estar logado
Login::requireLogin();

//Validação do ID

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

//consulta vaga
$obVaga = Vaga::getVaga($_GET['id']);

//validação da vaga
if (!$obVaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}

//validação do post
if (isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {

    $obVaga->titulo = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo = $_POST['ativo'];
    //echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;
    $obVaga->atualizar();

    header('location: index.php?status=success');
    exit;
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario.php';
include __DIR__ . '/includes/footer.php';
