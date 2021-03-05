<?php
  use \App\Session\Login;

  //DADOS DO USUARIO LOGADO
  $usuarioLogado = Login::getUsuarioLogado();

  //DETALHES DO USUARIO
  $usuario = $usuarioLogado ? 
              $usuarioLogado['nome'].' <a href="logout.php" class="text-light font-weight-bold ml-2">Sair</a>' :
              'Visitante <a href="login.php" class="text-light font-weight-bold ml-2">Entrar</a>';

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
</head>
<body class="bg-dark text-light">
  <div class="container">
    <div class="jumbotron bg-danger">
      <h1>CRUD <strong>PHP</strong></h1>
      <p>Exemplo de crud com <strong>PHP</strong> orientados a objetos</p>
    
      <hr class="border-light">

      <div class="d-flex justitf-content-start">
        <?=$usuario?>
      </div>

    </div>
  