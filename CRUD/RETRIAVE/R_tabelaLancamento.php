<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoLancamento.php';
include_once '../../Classe/Lancamento.php';

$l = new Lancamento();
$daol = new daoLancamento();

$mesAnterior = time() - (30 * 24 * 60 * 60);
$olderdata = date('Y-m-d', $mesAnterior);
$atual = date('Y-m-d');
        
$l->setDiaAtual($olderdata);
$l->setDataLancamento($atual);

foreach ($daol->RetornaConsultaLancamento_porData($l) as $id => $valores){
    $valores["Volume"] = number_format($valores["Volume"],0,",",".");
    $valores["Peso"] = number_format($valores["Peso"],3,",",".");
    $dados[] = $valores;
}
echo json_encode($dados);

