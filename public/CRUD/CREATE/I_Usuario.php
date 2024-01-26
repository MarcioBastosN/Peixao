<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    include_once '../../conn/conexao.php';
    include_once '../../dao/daoUsuario.php';
    include_once '../../Classe/Usuario.php';

    $usuariodao = new daoUsuario();

    $usuario = filter_input(INPUT_POST, "usuario");
    $nome = filter_input(INPUT_POST, "nome");
    $senha = filter_input(INPUT_POST, "senha");
    $nivel = filter_input(INPUT_POST, "nivel");

    if($usuariodao->VerificaUsuario($usuario) == 1){
        echo "Usuario existe, cadastre um Usuario diferente !";
    }else{
        $senha = base64_encode($senha);
        $user = new Usuario();
        $user->setUsuario($usuario);
        $user->setNome($nome);
        $user->setSenha($senha);
        $user->setNivel($nivel);
        echo $usuariodao->InserirUsuario($user);
    }
}//fim POST
