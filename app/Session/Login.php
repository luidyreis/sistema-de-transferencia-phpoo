<?php

namespace App\Session;

class Login{

  /**
   * Metodo responsavel por inicia a sessão
   */
  private static function init() {
    //VERIFICA STATUS DA SESSAO
    if(session_status() !== PHP_SESSION_ACTIVE) {
      //INICIA A SESSÂO
      session_start();
    }
  }

  /**
   * Metodo responsavel por retorna os dados do usuario
   * @return array
   */
  public static function getUsuarioLogado() {
    //INICIA A SESSÃO
    self::init();

    //RETORNA OS DADOS DO USUARIO
    return self::isLogged() ? $_SESSION['usuario'] : null;

  }

  /**
   * Metodo responsavel por logar usuario
   * @param Usuario
   */
  public static function login($obUsuario) {
    //INICIA A SESSÃO
    self::init();

    //SESSÃO DE USUARIO
    $_SESSION['usuario'] = [
      'id' => $obUsuario->id,
      'nome' => $obUsuario->nome,
      'email' => $obUsuario->email
    ];

    //REDIRECIONA USUARIO PARA INDEX
    header('location: index.php');
    exit;
  }

  /**
   * Metodo responsavel por deslogar usuario
   */
  public static function logout() {
    //INICIA A SESSÃO
    self::init();
    
    //REMOVE A SESSAO DE USUARIO
    unset($_SESSION['usuario']);

     //REDIRECIONA USUARIO PARA LOGIN
     header('location: login.php');
     exit;
  }

  /**
   * Metodo responsalve por verifica se o usuario esta logado
   * @return boolean
   */
  public static function isLogged() {
    //INICIA A SESSÃO
    self::init();

    return isset($_SESSION['usuario']['id']);
  }

  /**
   * Metodo responsalve por obriga a esta logado para acessar
   */
  public static function requireLogin() {
    if(!self::isLogged()) {
      header('location: login.php');
      exit;
    }
  }

   /**
   * Metodo responsalve por obriga a esta deslogado para acessar
   */
  public static function requireLogout() {
    if(self::isLogged()) {
      header('location: index.php');
      exit;
    }
  }

}