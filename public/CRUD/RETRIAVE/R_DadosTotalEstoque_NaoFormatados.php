<?php

include_once '../../conn/conexao.php';
//include_once '../../seguranca.php';
//protegePagina();
$conexao = new conexao();
$conn = $conexao->getConexao();

@$sqlClienteAtual = "SELECT ID FROM cliente";
@$ClienteAtual = mysqli_query($conn, $sqlClienteAtual);

@$_var["TotalPeso"] = 0;
@$_var["TotalVolume"] = 0;
@$_var["flag"] = 0;

while (@$Cliente = mysqli_fetch_assoc($ClienteAtual)) {
    @$IDCliente = $Cliente["ID"];
    @$sql = "SELECT `c`.`Nome` AS `Cliente`, sum(`e`.`Volume`) AS `Total_Volume`,sum(`e`.`Peso`) AS `Total_Peso` 
                FROM (`estoque` `e` JOIN `produto` `p` JOIN `cliente` `c`) WHERE `e`.`ClienteID`  = $IDCliente AND `p`.`ID` = `e`.`ProdutoID` AND `e`.`ClienteID` = `c`.`ID`";
    @$qry = mysqli_query($conn, $sql);

    while ($resultado = mysqli_fetch_assoc($qry)) {
        if ($resultado['Total_Volume'] != 0 || $resultado['Total_Peso'] != 0) {
            $vetor[] = $resultado;
        }
    }
}
$conexao->fecharConexao();
print json_encode($vetor);
