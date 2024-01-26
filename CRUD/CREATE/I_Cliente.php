<?php

include_once '../../conn/conexao.php';
include_once '../../Classe/Cliente.php';
include_once '../../dao/daoCliente.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["Nome"];
    $daoCliente = new daoCliente();
    $cliente = new Cliente();
    $cliente->setNome($nome);
    echo $daoCliente->InserirCliente($cliente);
}

