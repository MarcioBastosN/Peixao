<?php

require_once("seguranca.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
    $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';

    $senha = base64_encode($senha);
    
    RegistraAcesso($usuario);

    if (validaUsuario($usuario, $senha) == true) {
        header("Location: Home.php");
    } else {
        expulsaVisitante();
    }
}