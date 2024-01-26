<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    include_once '../../conn/conexao.php';
    include_once '../../dao/daoUsuario.php';
    
    $conexao = new conexao();
    $conn = $conexao->getConexao();

    $UserID = filter_input(INPUT_POST, "IdUsuario");
    $daoUser = new daoUsuario();
    echo $daoUser->ApagarUsuario($UserID);
    
}