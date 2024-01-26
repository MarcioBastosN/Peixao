<?php

include_once '../../conn/conexao.php';
include_once '../../dao/daoEstoque.php';
include_once '../../dao/daoProduto.php';
include_once '../../dao/daoLancamento.php';
include_once '../../Classe/Produto.php';
include_once '../../Classe/Situacao.php';
include_once '../../dao/daoSituacao.php';

$temp = filter_input(INPUT_GET, "valor");

function removerFormatacaoNumero( $strNumero ){
    $strNumero = trim( str_replace( "R$", null, $strNumero ) );

    $vetVirgula = explode( ",", $strNumero );
    if ( count( $vetVirgula ) == 1 ){
        $acentos = array(".");
        $resultado = str_replace( $acentos, "", $strNumero );
        return $resultado;
    }
    else if ( count( $vetVirgula ) != 2 ){ return $strNumero; }

    $strNumero = $vetVirgula[0];
    $strDecimal = mb_substr( $vetVirgula[1], 0, 2 );

    $acentos = array(".");
    $resultado = str_replace( $acentos, "", $strNumero );
    $resultado = $resultado.".".$strDecimal;
    return $resultado;
    }

echo removerFormatacaoNumero($temp);