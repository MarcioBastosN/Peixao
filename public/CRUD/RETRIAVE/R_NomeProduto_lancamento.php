<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoProduto.php';

$p = new daoProduto();

foreach ($p->RetornaNome_Id(filter_input(INPUT_GET, "cod")) as $id => $valores){
    $dados[] = $valores;
}

echo json_encode($dados);



