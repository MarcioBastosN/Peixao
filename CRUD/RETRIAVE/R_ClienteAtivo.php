<?php
    
    include_once '../../conn/conexao.php';
    include_once '../../dao/daoCliente.php';
    
    $ClienteAtivo = new daoCliente();
    
    $tempAtivo;
    foreach($ClienteAtivo->RetornaClienteAtivo() as $id => $dados){
        $tempAtivo = $dados["valor"];
    }
    
    foreach ($ClienteAtivo->getCliente() as $id => $dados){
        if($dados["ID"] == $tempAtivo){
            $dados["ativo"] = 1;
            $vetor[] = $dados;
        }else{
            $dados["ativo"] = 0;
            $vetor[] = $dados;
        }
    }
    echo json_encode($vetor);
    
    
