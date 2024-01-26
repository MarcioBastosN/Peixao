<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoLancamento.php';

$l = new daoLancamento();

foreach ($l->RetornaValoresEdicao(filter_input(INPUT_GET, "cod")) as $id => $valores){
    $dados[] = $valores;
}

echo json_encode($dados);
