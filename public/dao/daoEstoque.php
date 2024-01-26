<?php

class daoEstoque {

    private $SELECT = "SELECT * FROM estoque;";

    function getEstoque() {
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $query = mysqli_query($conexao, $this->SELECT);
        while ($rs = mysqli_fetch_assoc($query)) {
            $dados[] = $rs;
        }
        $conn->fecharConexao();
        return $dados;
    }

    function DadosEstoque() {
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $queryClientes = "SELECT ID FROM cliente ORDER BY `Nome`;";
        $ClienteAtual = mysqli_query($conexao, $queryClientes);
        $_var["TotalPeso"] = 0; $_var["TotalVolume"] = 0; $_var["flag"] = 0;
        while ($Cliente = mysqli_fetch_assoc($ClienteAtual)) {
            $IDCliente = $Cliente["ID"];
            $sql = "SELECT `c`.`Nome` AS `Cliente`, sum(`e`.`Volume`) AS `Total_Volume`,sum(`e`.`Peso`) AS `Total_Peso`
                        FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`)
                        where `e`.`ClienteID`  = $IDCliente AND `p`.`ID` = `e`.`ProdutoID` AND `e`.`ClienteID` = `c`.`ID` ;";
            $qry = mysqli_query($conexao, $sql);
            while ($resultado = mysqli_fetch_assoc($qry)) {
                if ($resultado['Total_Volume'] != 0 || $resultado['Total_Peso'] != 0) {
                    $dados[] = $resultado;
                }
            }
        }
        $conn->fecharConexao();
        return $dados;
    }

    function TotalEstoque() {
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $sqlClienteAtual = "SELECT ID FROM cliente;";
        $ClienteAtual = mysqli_query($conn, $sqlClienteAtual);
        $_var["TotalPeso"] = 0; $_var["TotalVolume"] = 0; $_var["flag"] = 0; $_SomaVolume = 0; $_SomaPeso = 0;
        while ($Cliente = mysqli_fetch_assoc($ClienteAtual)) {
            $IDCliente = $Cliente["ID"];
            $sql = "SELECT `c`.`Nome` AS `Cliente`, sum(`e`.`Volume`) AS `Total_Volume`,sum(`e`.`Peso`) AS `Total_Peso` 
                FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`) where `e`.`ClienteID`  = $IDCliente AND `p`.`ID` = `e`.`ProdutoID` AND `e`.`ClienteID` = `c`.`ID`";
            $qry = mysqli_query($conn, $sql);
            while ($resultado = mysqli_fetch_assoc($qry)) {
                if ($resultado['Total_Volume'] != 0 || $resultado['Total_Peso'] != 0) {
                    $volume = $resultado['Total_Volume']; $peso = $resultado['Total_Peso']; $_SomaVolume = $_SomaVolume + $volume; $_SomaPeso = $_SomaPeso + $peso;
                }
            }
        }
        $Volume = number_format($_SomaVolume, 0, ",", "."); $Peso = number_format($_SomaPeso, 3, ",", ".");
        $vetor = array('Volume' => $Volume, 'Peso' => $Peso);
        $conexao->fecharConexao();
        return "[" . json_encode($vetor) . "]";
    }

    function TotalEstoqueSituacao($cliente) {
        date_default_timezone_set('America/Belem'); $_var["data"] = date("d-m-Y"); $DataConsulta = date("Y-m-d", strtotime($_var["data"])); //data p/ realizar o calculo
        $_var["EmbalagemPeso"] = 0; $_var["EmbalagemVolume"] = 0; $_var["ExpedicaoPeso"] = 0; $_var["ExpedicaoVolume"] = 0; $_var["AcertoPeso"] = 0; $_var["AcertoVolume"] = 0; $_var["OlderPeso"] = 0; $_var["OlderVolume"] = 0;
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $ConsultaSituaçoes = "SELECT ID FROM situacao ;";
        $qrySituacao = mysqli_query($conn, $ConsultaSituaçoes);
        while ($TempSituacao = mysqli_fetch_assoc($qrySituacao)) {
            $Tsituacao = $TempSituacao["ID"];
            $consultaEstoqueS1 = "SELECT `c`.`Nome` AS `Cliente`, `e`.`situacao` ,sum(`e`.`Volume`) AS `Total_Volume`, sum(`e`.`Peso`) AS `Total_Peso`
                    FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`) where`e`.`Data_Estoque` = '$DataConsulta' AND `e`.`ClienteID` = `c`.`ID` AND `e`.`ProdutoID` = `p`.`ID` AND `e`.`situacao` = $Tsituacao AND `e`.`ClienteID` = $cliente ;";
            $qry = mysqli_query($conn, $consultaEstoqueS1);
            while ($TempResultado = mysqli_fetch_assoc($qry)) {
                if ($TempResultado["situacao"] == 1) { $_var["AcertoPeso"] = $TempResultado["Total_Peso"]; $_var["AcertoVolume"] = $TempResultado["Total_Volume"]; }
                if ($TempResultado["situacao"] == 2) { $_var["EmbalagemPeso"] = $TempResultado["Total_Peso"]; $_var["EmbalagemVolume"] = $TempResultado["Total_Volume"]; }
                if ($TempResultado["situacao"] == 3) { $_var["ExpedicaoPeso"] = $TempResultado["Total_Peso"]; $_var["ExpedicaoVolume"] = $TempResultado["Total_Volume"]; }
            }//fim do while interno
        }//fim do while externo
        $vetor = array('AcertoPeso' => $_var["AcertoPeso"], 'AcertoVolume' => $_var["AcertoVolume"], 'EmbalagemPeso' => $_var["EmbalagemPeso"], 'EmbalagemVolume' => $_var["EmbalagemVolume"], 'ExpedicaoPeso' => $_var["ExpedicaoPeso"], 'ExpedicaoVolume' => $_var["ExpedicaoVolume"]);
        $conexao->fecharConexao();
        return "[". json_encode($vetor). "]";
    }

    function Calcula_TotalEstoque_DataAnterio($cliente){
        date_default_timezone_set('America/Belem');
        $DiaAtual = date("Y-m-d");
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $EstoqueAnterior = "SELECT `c`.`Nome` AS `Cliente`, `e`.`situacao` , sum(`e`.`Volume`) AS `Total_Volume`, sum(`e`.`Peso`) AS `Total_Peso`
            FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`) where ((`e`.`Data_Estoque` < '$DiaAtual') AND (`e`.`ClienteID` = `c`.`ID`) AND (`e`.`ProdutoID` = `p`.`ID`) AND (`e`.`ClienteID` = $cliente ));";
        $qryOlderEstoque = mysqli_query($conn, $EstoqueAnterior);
        while($Estoque_Anterior = mysqli_fetch_assoc($qryOlderEstoque)){
            $Estoque_Anterior["Total_Peso"] = number_format($Estoque_Anterior["Total_Peso"],3,",",".");
            $Estoque_Anterior["Total_Volume"] = number_format($Estoque_Anterior["Total_Volume"],0,",",".");
            $dados[] = $Estoque_Anterior;
        }
        $conexao->fecharConexao();
        return json_encode($dados);
    }
    
    function TabelaEstoque_NFormatada($cliente){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $sqlProduto = "SELECT `ID` FROM `produto` ORDER BY `Nome` ;";
        $qryProduto = mysqli_query($conn, $sqlProduto);
        while ($produto = mysqli_fetch_assoc($qryProduto)) {
            $IDProduto = $produto["ID"];
            $sql = "SELECT `p`.`Nome`,`e`.`ProdutoID`, sum(`e`.`Volume`) AS `Volume`,sum(`e`.`Peso`) AS `Peso`
                    FROM (`estoque` `e` JOIN `produto` `p`) where `e`.`ClienteID` = $cliente AND `p`.`ID` = `e`.`ProdutoID` AND `e`.`ProdutoID` = $IDProduto ;";
            $qry = mysqli_query($conn, $sql);
            while ($resultado = mysqli_fetch_assoc($qry)) {
                if ($resultado["Peso"] != NULL && $resultado["Peso"] != 0 || $resultado["Volume"] != NULL && $resultado["Volume"] != 0) {
                    $resultado["Peso"] = number_format($resultado["Peso"],3,""," ");
                    $resultado["Volume"] = number_format($resultado["Volume"],0,""," ");
                    $dados[] = $resultado;
                }
            }
        }
        $conexao->fecharConexao();
        return json_encode($dados);
    }
    
    function TabelaEstoque_Formatada($cliente){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $sqlProduto = "SELECT `ID` FROM  `produto` ORDER BY `Nome` ;";
        $qryProduto = mysqli_query($conn, $sqlProduto);
        while ($produto = mysqli_fetch_assoc($qryProduto)) {
            $IDProduto = $produto["ID"];
            $sql = "SELECT `p`.`Nome`,`e`.`ProdutoID`, sum(`e`.`Volume`) AS `Volume`,sum(`e`.`Peso`) AS `Peso`
                    FROM (`estoque` `e` JOIN `produto` `p`) where `e`.`ClienteID` = $cliente AND `p`.`ID` = `e`.`ProdutoID` AND `e`.`ProdutoID` = $IDProduto ;";
            $qry = mysqli_query($conn, $sql);
            while ($resultado = mysqli_fetch_assoc($qry)) {
                if ($resultado["Peso"] != NULL && $resultado["Peso"] != 0 || $resultado["Volume"] != NULL && $resultado["Volume"] != 0) {
                    $resultado["Peso"] = number_format($resultado["Peso"],3,",",".");
                    $resultado["Volume"] = number_format($resultado["Volume"],0,",",".");
                    $dados[] = $resultado;               
                }
            }
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
    function TotalPorNota($nr){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $query = "SELECT SUM(`Volume`) AS `Volume`, SUM(`Peso`) AS `Peso` FROM `estoque` WHERE `NR` = '$nr';";
        $sql = mysqli_query($conn, $query);
        while($rs = mysqli_fetch_assoc($sql)){
            $rs['Volume'] = number_format($rs['Volume'],0,",",".");
            $rs['Peso'] = number_format($rs['Peso'],3,",",".");
            $dados[] = $rs;
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
    function TotalEstoqueSituacaoFormatado($cliente) {
        date_default_timezone_set('America/Belem'); $_var["data"] = date("d-m-Y"); $DataConsulta = date("Y-m-d", strtotime($_var["data"])); //data p/ realizar o calculo
        $_var["EmbalagemPeso"] = 0; $_var["EmbalagemVolume"] = 0; $_var["ExpedicaoPeso"] = 0; $_var["ExpedicaoVolume"] = 0; $_var["AcertoPeso"] = 0; $_var["AcertoVolume"] = 0; $_var["OlderPeso"] = 0; $_var["OlderVolume"] = 0;
        $conexao = new conexao(); $conn = $conexao->getConexao();
        $ConsultaSituaçoes = "SELECT ID FROM situacao ;";
        $qrySituacao = mysqli_query($conn, $ConsultaSituaçoes);
        while ($TempSituacao = mysqli_fetch_assoc($qrySituacao)) {
            $Tsituacao = $TempSituacao["ID"];
            $consultaEstoqueS1 = "SELECT `c`.`Nome` AS `Cliente`, `e`.`situacao` ,sum(`e`.`Volume`) AS `Total_Volume`, sum(`e`.`Peso`) AS `Total_Peso` FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`) where`e`.`Data_Estoque` = '$DataConsulta' AND `e`.`ClienteID` = `c`.`ID` AND `e`.`ProdutoID` = `p`.`ID` AND `e`.`situacao` = $Tsituacao AND `e`.`ClienteID` = $cliente ;";
            $qry = mysqli_query($conn, $consultaEstoqueS1);
            while ($TempResultado = mysqli_fetch_assoc($qry)) {
                if ($TempResultado["situacao"] == 1) { $_var["AcertoPeso"] = $TempResultado["Total_Peso"]; $_var["AcertoVolume"] = $TempResultado["Total_Volume"]; }
                if ($TempResultado["situacao"] == 2) { $_var["EmbalagemPeso"] = $TempResultado["Total_Peso"]; $_var["EmbalagemVolume"] = $TempResultado["Total_Volume"]; }
                if ($TempResultado["situacao"] == 3) { $_var["ExpedicaoPeso"] = $TempResultado["Total_Peso"]; $_var["ExpedicaoVolume"] = $TempResultado["Total_Volume"]; }
            }//fim do while interno
            $_resultado = '<tr class="success">'.'<td>Acerto</td>'.'<td>'. number_format(@$_var["AcertoVolume"],0,",",".").' un</td>'.'<td>'.  number_format(@$_var["AcertoPeso"],3,",","."). 'Kg</td>'.'</tr>'.
		'<tr class="info">'.'<td>Embalado</td>'.'<td>'. number_format(@$_var["EmbalagemVolume"],0,",",".").' un</td>'.'<td>'. number_format(@$_var["EmbalagemPeso"],3,",",".").' Kg</td>'.'</tr>'.
		'<tr class="danger">'.'<td>Expedido</td>'.'<td>'. number_format(@$_var["ExpedicaoVolume"],0,",",".").' un</td>'.'<td>'. number_format(@$_var["ExpedicaoPeso"],3,",",".").' Kg</td>'.'</tr>';
        }//fim do while externo
        $conexao->fecharConexao();
        return $_resultado;
    }
    
    function RetornaEstoqueAnteriorFormatado($cliente){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        date_default_timezone_set('America/Belem'); $DiaAtual = date("Y-m-d"); $DataAnterior = time() - (1 * 24 * 60 * 60) ; $_var["OlderData"] = date('d-m-Y', $DataAnterior); $data = $_var["OlderData"];
        $query = "SELECT `c`.`Nome` AS `Cliente`, `e`.`situacao` , sum(`e`.`Volume`) AS `Total_Volume`, sum(`e`.`Peso`) AS `Total_Peso`
                FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`) WHERE ((`e`.`Data_Estoque` < '$DiaAtual') AND (`e`.`ClienteID` = `c`.`ID`) AND (`e`.`ProdutoID` = `p`.`ID`) AND (`e`.`ClienteID` = $cliente ))";
        $sql = mysqli_query($conn, $query);
        $conexao->fecharConexao();
        while($rs = mysqli_fetch_assoc($sql)){
            $_var["OlderPeso"] = $rs["Total_Peso"];
            $_var["OlderVolume"] = $rs["Total_Volume"];
            $_Resultado = "<td>Saldo At&eacute;: "."<span class='text-info'>".$_var["OlderData"]."</span></td>"."<td>".number_format($_var["OlderVolume"],0,",",".")." un"."</td><td>".number_format($_var["OlderPeso"],3,",",".")." Kg"."</td>";
        }
        return $_Resultado;
    }
    
}
