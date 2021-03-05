<?php

require '../vendor/autoload.php';

use \App\Entity\Transfer;
use \App\Db\Database;
use \App\Session\Login;

//OBRIGA O USUARIO A ESTAR LOGADO
Login::requireLogin();

$alertTransfer = '';

//PEGA DADOS DO USUARIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();

//PEGA O ID DA CONTA DO USUARIO LOGADO
$idConta = (new Database('contas'))->select('id_usuario = "'.$usuarioLogado['id'].'"')->fetchObject();

//PEGA SALDO DO USUARIO LOGADO
$saldo = Transfer::getSaldo(''.$usuarioLogado['id'].'', 'id_usuario');

$obTransfer = new Transfer;
//VALIDAÇÂO DO POST
if(isset($_POST['conta'], $_POST['valor'])) {
  $obTransfer->contaFavorecida  = $_POST['conta'];
  $obTransfer->contaPagante     = $idConta->id;
  $obTransfer->valor            = str_replace(",", ".", str_replace(".", "", $_POST['valor']));
  $obTransfer->transferir();
  $alertTransfer = array(
    "Status" => $obTransfer->status,
    "Saldo" => number_format($obTransfer->newSaldo, 2, ',', '.')
  );
} else {
  //Tratar que o usuario acesse esta api por meio da url
  echo "<h2>Erro HTTP: 403</h2>";
  echo "<h3>Acesso negado!</h3>";
  exit;
}

$return = json_encode($alertTransfer);

echo $return;
