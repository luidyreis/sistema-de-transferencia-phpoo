<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Usuario{

  /**
   * Identificado do usuario
   * @var integer
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
   * Método responsavel por cadastra novo usuario no banco
   * @return boolean
   */
  public function cadastrar() {
    //DATABASE
    $obDatabase = new Database('usuarios');

    //inseri uma novo usuario
    $this->id = $obDatabase->insert([
      'nome' => $this->nome,
      'email' => $this->email,
      'senha' => $this->senha
    ]);
    
    //sucesso
    return true;
  }

  /**
   * Metodo responsavel por retorma uma instancia do usuario
   * @param string @email
   * @return Usuario
   */
  public static function getUsuarioPorEmail($email) {
    return (new Database('Usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
  }
}