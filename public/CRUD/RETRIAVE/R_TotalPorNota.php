<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoEstoque.php';

$estoque = new daoEstoque();

$nota = filter_input(INPUT_POST, 'ConsultaNota');

foreach ($estoque->TotalPorNota(filter_input(INPUT_POST, 'ConsultaNota')) as $id => $valor){
    echo "<strong>Nota: ".$nota." Peso: ".$valor['Peso']."Kg Volume: ".$valor['Volume']."un</strong>";
}

