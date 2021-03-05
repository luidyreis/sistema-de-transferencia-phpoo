<?php

namespace App\Db;

use \PDO;
use PDOException;

class Database{

  /**
   * Host de conexão com o banco de dados
   * @var string
   */
  const HOST = 'localhost';

  /**
   * Nome do banco de dados
   * @var string
   */
  const NAME = 'db-dbv-system';

  /**
   * Usuario do banco
   * @var string
   */
  const USER = 'root';

  /**
   * Senha do banco de dados
   * @var string
   */
  const PASS = '';

  /**
   * Nome da tabela a ser manipulada
   * @var string
   */
  private $table;

  /**
   * Instancia de conexão com banco de dados
   * @var PDO
   */
  private $connection;

  /**
   * Define a tabel e instancia de conexão
   * @var string $table
   */
  public function __construct($table = null){
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Método responsavel por criar uma conexão com o banco de dados
   */
  private function setConnection() {
    try{
      $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
      die('ERRO: '.$e->getMessage());
    }
  }

  /**
   * Método responsavel por execulta queries dentro do banco de dados
   * @param string
   * @param array
   * @return PDOStatement
   */
  public function execute($query,$params = []) {
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e) {
      die('ERRO: '.$e->getMessage());
    }
  }

  /**
   * Método responsável por inserir dados no banco de dados
   * @param array $values [field = value]
   * @return integer ID inserido
   */
  public function insert($values) {
    //DADOS DA QUERY
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');

    //MONTA A QUERY
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
    
    //EXECUTA O INSERT
    $this->execute($query, array_values($values));

    //RETORNA O ID INSERIDO
    return $this->connection->lastInsertId();

  }

  /**
   * Método responsavel por executa uma consulta no banco de dados
   * @param string @where
   * @param string @order
   * @param string @limit
   * @param string @fields
   * @return PDOStatement
   */
  public function select($where = null, $order = null, $limit = null, $fields = '*') {
    //DADOS DA QUERY
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';

    //MONTA A QUERY
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

    //EXECULTA QUERY
    return $this->execute($query);
  }

  /**
   * Método responsavel por execulta atualização no banco de dados
   * @param string @where
   * @param arraay @values [ field => value]
   * @return boolean
   */
  public function update($where, $values) {
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;
    
    //EXCUTAR A QUERY
    $this->execute($query,array_values($values));
    
    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsavel por excluir uma vaga no banco de dados
   * @param string @where
   * @return boolean
   */
  public function delete($where) {
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECULTA A QUERY
    $this->execute($query);

    //RETORNA SUCESSO
    return true;
  }
}