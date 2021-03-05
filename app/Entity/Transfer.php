<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Transfer{

  /**
   * Identificado da transferencia
   * @var integer
   */
  public $id;

  /**
   * Identifição da conta que sera depositado o valor em dinheiro
   * @var number
   */
  public $contaFavorecida;

  /**
  * Identifição da conta que sera retirado o valor em dinheiro
  * @var number
  */
  public $contaPagante;

  /**
  * Identifição do valor em dinheiro
  * @var string
  */
  public $valor;

  /**
   * Data da publicação da vaga
   * @var string
   */
  public $data;

  /**
   * Saldo do usuario depois da transferencia
   * @var string
   */
  public $newSaldo;
  
  /**
   * Status da operação
   * @var string
   */
  public $status;

  /**
   * Método responsavel por transferir o valar
   * @return boolean 
   */
  public function transferir() {
    //Definir a data
    $this->data = date('Y-m-d H:i:s');
    //DATABASE
    $obDatabase = new Database('transferecias');

    //Verfica se existe saldo sulficiente na conta do pagante para realiza a operação
    $saldoContaPagante = self::getSaldo(''.$this->contaPagante.'', 'id');
    if($saldoContaPagante->saldo < $this->valor){
      $this->newSaldo = $saldoContaPagante->saldo;
      $this->status = "Sem saldo";
      return false;
    }

    //Verfica se o usuario esta tranferindo para si mesno
    if($this->contaFavorecida == $this->contaPagante) {
      $this->newSaldo = $saldoContaPagante->saldo;
      $this->status = "Não pode transferir essa e sua conta!";
      return false;
    }

    //Inserir a transferencia no banco
    $this->id = $obDatabase->insert(
    [
      'contaFavorecida' =>$this->contaFavorecida,
      'contaPagante'    =>$this->contaPagante,
      'valor'           =>$this->valor,
      'data'            =>$this->data
    ]);
    
    //Inserir o valor na conta do favorecedo
    //Pega o saldo da conta do favorecedo para calcula o total de saldo que o mesno ira ter
    $saldoContaFavorecida = self::getSaldo(''.$this->contaFavorecida.'', 'id');
    if(!$saldoContaFavorecida) {
      $this->newSaldo = $saldoContaPagante->saldo;
      $this->status = "Conta invalida!";
      return false;
    }
    $saldoContaFavorecida = $saldoContaFavorecida->saldo + $this->valor;
    self::atualizaSaldo(''.$this->contaFavorecida.'', ''.$saldoContaFavorecida.'');

    //Retirar valor da conta do pagante
    $saldoContaPagante = $saldoContaPagante->saldo - $this->valor;
    self::atualizaSaldo(''.$this->contaPagante.'', ''.$saldoContaPagante.'');
    
    //Retorna sucesso
    $this->newSaldo = $saldoContaPagante;
    $this->status = "Transferido!";
    return true;
  }

  /**
   * Método resonsalve por saldo das contas
   * @param integer @id
   * @param integer @saldo
   * @return string
   */
  public static function atualizaSaldo($id, $saldo) {
    //Definir data
    $data = date('Y-m-d H:i:s');
    return (new Database('contas'))->update('id = '.$id, [
      'saldo' => $saldo,
      'ult_altera' => $data
    ]);
  }

  /**
   * Método resonsalve por retorma o saldo do usuario
   * @param integer @idUsuario
   * @param integer @where
   * @return object
   */
  public static function getSaldo($idUsuario, $where) {
    return (new Database('contas'))->select(''.$where.' = "'.$idUsuario.'"')->fetchObject(self::class);
  }

}