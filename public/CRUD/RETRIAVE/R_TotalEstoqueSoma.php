<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoEstoque.php';

$estoque = new daoEstoque();
print $estoque->TotalEstoque();