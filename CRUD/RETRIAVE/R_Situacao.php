<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoSituacao.php';

$s = new daoSituacao();

foreach ($s->getSituacao() as $id => $valor){
    $dados[] = $valor;
}
echo json_encode($dados);