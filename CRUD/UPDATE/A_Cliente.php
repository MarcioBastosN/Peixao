<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    include_once '../../conn/conexao.php';
    $conexao = new conexao();
    $conn = $conexao->getConexao();
	
    @$codigo = filter_input(INPUT_POST, "codigo");
    @$nome = filter_input(INPUT_POST, "cliente");
    // @$telefone = $_POST['telefone'];
    // @$email = $_POST['email'];

	// $sql ="UPDATE cliente SET Nome = '$nome', Telefone = '$telefone', Email = '$email' WHERE ID = '$codigo'";
    $sql ="UPDATE cliente SET Nome = '$nome' WHERE ID = '$codigo' ;";
    $qry = mysqli_query($conn, $sql);

    if($qry){
        echo "ok";	
    }else{
        echo "erro";
    }
}else{
    echo "Erro de Acesso !";
}