<?php

use \App\Session\Login;

//DADOS DO USUARIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//DETALHES DO USUARIO
$usuario = $usuarioLogado ?
  '<div class="py-2 d-none d-md-block ">Usuario: ' . $usuarioLogado['nome'] . '</div><a href="logout.php" class="text-dark font-weight-bold ml-2"><button class="btn btn-danger">Sair</button></a>' :
  'Visitante <a href="login.php" class="text-dark font-weight-bold ml-2">Entrar</a>';

?>

<!doctype html>
<html lang="pt_br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <script src="https://kit.fontawesome.com/eb70eeb7b9.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>CRUD, PDO PHP</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Russo+One&display=swap');

    body>* {
      font-family: 'Russo One', sans-serif;
    }

    .titulo {
      font-size: calc(1.5vw + 0.5vh + 1.2vmin);
    }

  </style>
</head>

<body class="bg-dark text-light">
  <div class="bg-white text-dark mb-5">
    <div class="container text-center d-flex py-3">
      <div class="py-2 titulo">Transferencia de valores entre usuario</div>
      <hr class="border-dark">
      <div class="d-flex justify-content-center align-self-center">
        <?= $usuario ?>
      </div>
    </div>
  </div>
  <div class="container">