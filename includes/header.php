<?php

use \App\Session\Login;

//dados do usuario logado
$usuarioLogado = Login::getUsuarioLogado();

//detalhes do usuario
$usuario = $usuarioLogado ?
  $usuarioLogado['nome'] . '<a href="logout.php" class="text-light font-weight-bold ml-2">Sair</a>' :
  'Visitante <a href="login.php" class="text-light font-weight-bold ml-2">Entrar</a>';

?>

<!doctype html>
<html lang="pt_br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <title>CRUD - Vagas</title>
</head>

<body class="bg-dark text-light">

  <div class="container">

    <div class="jumbotron bg-danger">
      <h1>CRUD - Vagas</h1>
      <p> Exemplo de CRUD com PHP orientado a objetos</p>

      <hr class="border-light">

      <div class="d-flex justify-content-start"><?= $usuario ?></div>
    </div>