<?php

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Usuario;
use \App\Session\Login;

//OBRIGA O USUARIO A ESTAR LOGADO
Login::requireLogout();

//MENSAGEN DE ALERTA DOS FORMULARIOS
$alertLogin = '';
$alertCadastro = '';

//VALIDAÇÂO DO POST
if(isset($_POST['acao'])) {
  switch($_POST['acao']) {
    case 'logar':

      //BUSCA USUARIO POR EMAIL
      $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);

      //VALIDA A INSTANCIA E A SENHA
      if(!$obUsuario instanceof Usuario || !password_verify($_POST['senha'], $obUsuario->senha)) {
        $alertLogin = "E-mail ou senha inválidos";
        break;
      }

      //LOGA USUARIO
      Login::login($obUsuario);

      break;
    case 'cadastrar':

      //VALIDAÇÃO DOS CAMPOS OBRIGADORIOS
      if(isset($_POST['nome'],$_POST['email'],$_POST['senha'])) {
        
        //BUSCA USUARIO POR EMAIL
        $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);
        if($obUsuario instanceof Usuario) {
          $alertCadastro = 'O e-mail digitado já esta em uso';
          break;
        }

        //NOVO USUARIO
        $obUsuario = new Usuario;
        $obUsuario->nome = $_POST['nome'];
        $obUsuario->email = $_POST['email'];
        $obUsuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $obUsuario->cadastrar();
        
        //LOGA USUARIO
        Login::login($obUsuario);
      }

      break;
  }
}

include __DIR__.'/assets/view.login.header.php';
include __DIR__.'/assets/view.login.php';
/* echo '<pre>'; print_r($_POST); echo '</pre>'; exit; */