<?php

//include_once '../../seguranca.php';
//protegePagina();
include_once '../../conn/conexao.php';
include_once '../../dao/daoEstoque.php';

$estoque = new daoEstoque();

foreach ($estoque->DadosEstoque() as $id => $dados) {
    $dados['Total_Volume'] = number_format($dados['Total_Volume'], 0, ",", ".");
    $dados['Total_Peso'] = number_format($dados['Total_Peso'], 3, ",", ".");
    $listaProdutos[] = $dados;
}

print json_encode($listaProdutos);


