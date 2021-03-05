<?php

namespace App\Db;

class Pagination {

  /**
   * Núnero maxino de registro
   * @var integer
   */
  private $limit;

  /**
   * Quantidade total de resultados do banco
   * @var integer
   */
  private $results;

  /**
   * Quantidade de paginas
   * @var integer
   */
  private $pages;

  /**
   * Quantidade de paginas
   * @var integer
   */
  private $currentPage;

  /**
   * Construto da class
   */
  public function __construct($results, $currentPage = 1, $limit = 10) {
    $this->results = $results;
    $this->limit = $limit;
    $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
    $this->calculate();
  }

  /**
   * Metodo responsalve por calcular a pagimação
   */
  private function calculate() {
    //CALCULAR O TODAL DE PAGINA
    $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

    //VERIFICA SE A PAGINA ATUAL NÂO EXEDE O LIMITE DE PAGINA
    $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
  }

  /**
   * Metodo responsavel por retorna a clasula limit da sql
   * @return string
   */
  public function getLimit() {
    $offset = ($this->limit * ($this->currentPage - 1));
    return $offset.','.$this->limit;
  }
  
  /**
   * Metodo responssavel por retorna as opçõs de pagimas disponivl
   * @return array
   */
  public function getPages() {
    //NÂO RETORNA PAGINAS
    if($this->pages == 1) return [];

    //PAGINA
    $paginas = [];
    for ($i = 1; $i <= $this->pages; $i++) { 
      $paginas[] = [
        'pagina' => $i,
        'atual' => $i == $this->currentPage
      ];
    }
    return $paginas;
  }
}