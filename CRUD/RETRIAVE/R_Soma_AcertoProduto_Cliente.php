<?php

include_once '../../conn/conexao.php';
$conexao = new conexao();
$conn = $conexao->getConexao();

@$Nome_Produto = $_GET["produto"];
@$Nome_Cliente = $_GET["cliente"];
@$Data_Inicio = $_GET["DataInicio"];
@$Data_Final = $_GET["DataFim"];

@$Data_Final = date('Y-m-d', strtotime($Data_Final));
@$Data_Inicio = date('Y-m-d', strtotime($Data_Inicio));

function Ret_ID_Cliente($cliente) {
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    $sql = "SELECT `ID` FROM `cliente` WHERE `Nome` = '$cliente' ;";
    $query = mysqli_query($conn, $sql);
    $conexao->fecharConexao();
    while ($resultado = mysqli_fetch_assoc($query)) {
        return $resultado["ID"];
    }
}

function Ret_ID_Produto($produto) {
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    $sql = "SELECT `ID` FROM `produto` WHERE `Nome` = '$produto' ;";
    $query = mysqli_query($conn, $sql);
    $conexao->fecharConexao();
    while ($resultado = mysqli_fetch_assoc($query)) {
        return $resultado["ID"];
    }
}

$TEMP_Produto = Ret_ID_Produto($Nome_Produto);
$TEMP_Cliente = Ret_ID_Cliente($Nome_Cliente);

$sql2 = "SELECT `ProdutoID` as `Nome`, sum(`Volume`) as `Volume`, format(sum(`Peso`), 3, 'pt-br') as `Peso` from `estoque` 
        where ((`ProdutoID` = $TEMP_Produto ) AND (`ClienteID` = $TEMP_Cliente ) AND (`Data_Estoque` between ('$Data_Inicio') AND ('$Data_Final') ) AND (`situacao` = 1));";

@$query = mysqli_query($conn, $sql2);
$conexao->fecharConexao();
while ($resultado = mysqli_fetch_assoc($query)) {
    if ($resultado['Nome'] === $TEMP_Produto) {
        $resultado['Nome'] = $Nome_Produto;
    }
    $dados[] = $resultado;
}

print json_encode($dados);
