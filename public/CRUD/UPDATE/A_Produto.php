<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include_once '../../conn/conexao.php';
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    
    $codigo = filter_input(INPUT_POST, "codigo");
    $nome = filter_input(INPUT_POST, "produto");

    $sql ="UPDATE `produto` SET `Nome` = '$nome' WHERE `ID` = '$codigo' ;";
    $qry = mysqli_query($conn, $sql);
    $conexao->fecharConexao();
    if($qry){
        echo "ok";
    }else{
        echo "erro";
    }
}else{
    echo "Erro de Acesso !";
}
