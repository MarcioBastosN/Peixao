<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once '../conn/conexao.php';
    $conexao = new conexao();
    $conn = $conexao->getConexao();

    @$carregaInfo = filter_input(INPUT_POST, "produtoid");

@$sql = "SELECT `Nome` FROM `produto` WHERE `ID` = $carregaInfo ;";
$query = mysqli_query($conn, $sql);

$conexao->fecharConexao();

    while($resultado = mysqli_fetch_assoc($query)){
        $ProdutoNome = $resultado["Nome"];
    }
    echo $ProdutoNome;
}else{
    echo "Erro";
}