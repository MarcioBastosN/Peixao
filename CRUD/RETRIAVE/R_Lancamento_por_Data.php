<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoLancamento.php';
include_once '../../Classe/Lancamento.php';

$l = new Lancamento();
$daol = new daoLancamento();

$l->setDiaAtual(filter_input(INPUT_GET, "DataDe"));
$l->setDataLancamento(filter_input(INPUT_GET, "DataAte"));

foreach ($daol->RetornaConsultaLancamento_porData($l) as $id => $valores){
    $dados[] = $valores;
}
echo json_encode($dados);