<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoLancamento.php';

$l = new daoLancamento();
echo $l->ApagarLancamento(filter_input(INPUT_POST, "id"));
//echo $l->ApagarLancamento(filter_input(INPUT_GET, "id"));
