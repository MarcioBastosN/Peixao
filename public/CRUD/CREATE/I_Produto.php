<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 	
    
    include_once '../../conn/conexao.php';
    include_once '../../Classe/Produto.php';
    include_once '../../dao/daoProduto.php';
    
    $nome = $_POST["Nome"];
    $daoProduto = new daoProduto();
    $produto = new Produto();
    $produto->setNome($nome);
    
    $rs = $daoProduto->Inserir($produto);
    
    echo $rs;
    
}
