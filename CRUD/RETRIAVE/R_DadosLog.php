<?php

include_once '../../conn/conexao.php';

    $conexao = new conexao();
    $conn = $conexao->getConexao();
    $sql = "SELECT `id`, `User`, date_format( `Data_Tempo`, '%d-%c-%Y %H:%i:%s') AS `Data_Tempo`, `Acesso` FROM `registraacessos` ORDER BY `id` DESC LIMIT 30";
    $query = mysqli_query($conn, $sql);
    $conexao->fecharConexao();
    while($resultado = mysqli_fetch_assoc($query)){
        $vetor[] = $resultado;
    }    
    
    print json_encode($vetor);