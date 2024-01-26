<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once '../../conn/conexao.php';
    include_once '../../dao/daoLancamento.php';
    include_once '../../Classe/Lancamento.php';
    include_once '../../dao/daoProduto.php';
    include_once '../../dao/daoCliente.php';
    include_once '../../Classe/Produto.php';

    date_default_timezone_set('America/Belem');
    $data = date('Y-m-d');

    $valida = true;
    $dados = "";

    function removerFormatacaoNumero($strNumero) {

        $vetVirgula = explode(",", $strNumero);
        if (count($vetVirgula) == 1) {
            $acentos = array(".");
            $resultado = str_replace($acentos, "", $strNumero);
            return $resultado;
        } else if (count($vetVirgula) != 3) {
            return $strNumero;
        }
        $strNumero = $vetVirgula[0];
        $strDecimal = mb_substr($vetVirgula[1], 0, 2);

        $acentos = array(".");
        $resultado = str_replace($acentos, "", $strNumero);
        $resultado = $resultado . "." . $strDecimal;
        return $resultado;
    }

    function limparPonto($valor) {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        return $valor;
    }

    function limparVirgula($valor) {
        $valor = str_replace(",", ".", $valor);
        return $valor;
    }

    $lancamento = new daoLancamento();
    $dadosLancamento = new Lancamento();
    $produto = new daoProduto();
    $p = new Produto();

    $idProduto = filter_input(INPUT_POST, "Peixe");
    if (is_numeric($idProduto)) {
        //verifica se e o numero passado e valido
        foreach ($lancamento->ValidaIdProduto($idProduto) as $id => $valor) {
            if (!isset($valor["success"])) {
                $dados = ['Erro: ' => "Valor inserido nao e valido"];
            }
        }
    } else {
        $p->setNome(filter_input(INPUT_POST, "Peixe"));
        if ($produto->RetornaId_Nome($p) == 0) {
            $valida = false;
            $dados = ['Erro_Retorna_Nome' => "Erro produto inserido nao e valido."];
        } else {
            if ($produto->RetornaId_Nome($p)) {
                $idProduto = $produto->RetornaId_Nome($p);
            } else {
                $dados = ['ErroId' => "Erro retornou um Id invalido, "];
            }
        }
    }

    $dadosLancamento->setCliente(filter_input(INPUT_POST, "Cliente"));

    foreach ($lancamento->ValidaIdProduto($idProduto) as $id => $valor) {
        if (isset($valor["success"])) {
            $dadosLancamento->setProduto($idProduto);
        }
    }

    $dadosLancamento->setNr(filter_input(INPUT_POST, "NR"));
    $dadosLancamento->setDiaAtual($data);
    $dadosLancamento->setDataLancamento(filter_input(INPUT_POST, "Data"));
    $dadosLancamento->setSituacao(filter_input(INPUT_POST, "Situacao"));

//    $peso = removerFormatacaoNumero(filter_input(INPUT_POST, "Peso"));
    $peso = limparPonto(filter_input(INPUT_POST, "Peso"));
    $peso = limparVirgula($peso);
    
    $volume = filter_input(INPUT_POST, "Volume");

    if ($dadosLancamento->getSituacao() == 3) {
        if ($peso > 0) {
            $peso = abs($peso) * (-1);
        } else if ($peso == 0) {
            $peso = $peso;
        }
        if ($volume > 0) {
            $volume = abs($volume) * (-1);
        } else if ($volume == 0) {
            $volume = $volume;
        }
    }

    $dadosLancamento->setPeso($peso);
    $dadosLancamento->setVolume($volume);

    $dadosLancamento->setClass(filter_input(INPUT_POST, "Situacao"));
    $dadosLancamento->setObservacoes(filter_input(INPUT_POST, "Observacao"));

    if (empty($dadosLancamento->getCliente())) {
        $valida = false;
        array_push($dados, ['Cliente' => "Cliente, "]);
    }
    if (empty($dadosLancamento->getProduto())) {
        $valida = false;
        array_push($dados, ['Produto' => "nao possui valor valido, "]);
    }//retormando erro por nao converter array em string
    if (empty($dadosLancamento->getNr())) {
        $valida = false;
        array_push($dados, ['NR' => "nr, "]);
    }
    if (empty($dadosLancamento->getDiaAtual())) {
        $valida = false;
        array_push($dados, ['DiaAtual' => "Dia atual, "]);
    }
    if (empty($dadosLancamento->getDataLancamento())) {
        $valida = false;
        array_push($dados, ['DataLancamento' => "Data lancamento, "]);
    }
//    if(empty($dadosLancamento->getPeso())){ $valida = false; array_push($dados, ['Peso' => "Peso, "]);}
//    if(empty($dadosLancamento->getVolume())){ $valida = false; array_push($dados, ['Volume' => "Volume, "]);}
    if (empty($dadosLancamento->getSituacao())) {
        $valida = false;
        array_push($dados, ['Situacao' => "Situacao, "]);
    }
    if (empty($dadosLancamento->getClass())) {
        $valida = false;
        array_push($dados, ['Classe' => "Classe, "]);
    }

    if ($valida) {
        $lancamento->AlterarClienteAtivo($dadosLancamento->getCliente());
        echo $lancamento->Inserir($dadosLancamento);
    } else {
        echo "Erro :" . json_encode($dados);
    }
}    