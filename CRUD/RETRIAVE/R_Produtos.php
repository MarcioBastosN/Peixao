<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoProduto.php';

$produtos = new daoProduto();
$listProdutos = $produtos->getProdutos();

print json_encode($listProdutos);

