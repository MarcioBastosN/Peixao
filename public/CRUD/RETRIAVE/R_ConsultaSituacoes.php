<?php

@$_SG["cliente"] = filter_input(INPUT_POST, "Cliente");
@$_SG["dataInicio"] = filter_input(INPUT_POST, "Inicio");
@$_SG["datFim"] = filter_input(INPUT_POST, "Fim");

function RetornaAcerto(){
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    global $_SG;
    $sql = "SELECT count(ID) as`Lancamentos`, sum(volume) as`volume`, sum(Peso) as `Peso` FROM estoque
  	WHERE ClienteID = ".$_SG["cliente"]." and situacao = 1 and Data_Estoque between ('".$_SG["dataInicio"]."') and ('".$_SG["datFim"]."') ;";
    $query = mysqli_query($conn, $sql);
    $lancamento = 0; $volume = 0; $peso = 0;
    while(@$resultado = mysqli_fetch_assoc($query)){
        @$volume = $resultado["volume"];
        @$lancamento = $resultado["Lancamentos"];
        @$peso = $resultado["Peso"];
    };
    $lancamento = number_format($lancamento,0,"",".");
    $volume = number_format($volume,0,"",".");
    $peso = number_format($peso,3,",",".");
    $conexao->fecharConexao();
    return "Lançamentos: ".$lancamento." Volume: ".$volume." Peso: ".$peso;
}

function RetornaEmbalagem(){
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    global $_SG;
    $sql = "SELECT count(ID) as`Lancamentos`, sum(volume) as`volume`, sum(Peso) as `Peso` FROM estoque
  	WHERE ClienteID = ".$_SG["cliente"]." and situacao = 2 and Data_Estoque between ('".$_SG["dataInicio"]."') and ('".$_SG["datFim"]."') ;";
    $query = mysqli_query($conn, $sql);
    $lancamento = 0; $volume = 0; $peso = 0;
    while(@$resultado = mysqli_fetch_assoc($query)){
      @$volume = $resultado["volume"];
        @$lancamento = $resultado["Lancamentos"];
        @$peso = $resultado["Peso"];
    };
    $lancamento = number_format($lancamento,0,"",".");
    $volume = number_format($volume,0,"",".");
    $peso = number_format($peso,3,",",".");
    $conexao->fecharConexao();
    return "Lançamentos: ".$lancamento." Volume: ".$volume." Peso: ".$peso;
}

function RetornaExpedicao(){
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    global $_SG;
    $sql = "SELECT count(ID) as`Lancamentos`, sum(volume) as`volume`, sum(Peso) as `Peso` FROM estoque
  	WHERE ClienteID = ".$_SG["cliente"]." and situacao = 3 and Data_Estoque between ('".$_SG["dataInicio"]."') and ('".$_SG["datFim"]."') ;";
    $query = mysqli_query($conn, $sql);
    $lancamento = 0; $volume = 0; $peso = 0;
    while(@$resultado = mysqli_fetch_assoc($query)){
        @$volume = $resultado["volume"];
        @$lancamento = $resultado["Lancamentos"];
        @$peso = $resultado["Peso"];
    };
    $lancamento = number_format($lancamento,0,"",".");
    $volume = number_format($volume,0,"",".");
    $peso = number_format($peso,3,",",".");
    $conexao->fecharConexao();
    return "Lançamentos: ".$lancamento." Volume: ".$volume." Peso: ".$peso;
}