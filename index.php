<?php

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Transfer;
use \App\Db\Database;
use \App\Session\Login;
//OBRIGA O USUARIO A ESTAR LOGADO
Login::requireLogin();
//PEGA DADOS DO USUARIO LOGADO
$usuarioLogado = Login::getUsuarioLogado();
//PEGA O ID DA CONTA DO USUARIO LOGADO
$idConta = (new Database('contas'))->select('id_usuario = "'.$usuarioLogado['id'].'"')->fetchObject();
//PEGA SALDO DO USUARIO LOGADO
$saldo = Transfer::getSaldo(''.$usuarioLogado['id'].'', 'id_usuario');

include __DIR__.'/assets/view.global.header.php';
include __DIR__.'/assets/view.index.php';
include __DIR__.'/assets/view.footer.php';