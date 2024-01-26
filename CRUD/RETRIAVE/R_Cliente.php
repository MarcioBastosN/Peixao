<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoCliente.php';

$cliente = new daoCliente();

echo json_encode($cliente->getCliente());
