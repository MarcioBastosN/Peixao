<?php

include_once '../../conn/conexao.php';
//include_once '../../seguranca.php'; 
//protegePagina();
    $conexao = new conexao();
    $conn = $conexao->getConexao();
    
    $consulta = "SELECT * FROM `usuarios` ;";
    $sql = mysqli_query($conn, $consulta);
    $conexao->fecharConexao();
    while($resultado = mysqli_fetch_assoc($sql)){
        if($resultado['nivel'] == 1){
            $resultado['nivel'] = "Admin";
        }
        if($resultado['nivel'] == 2){
            $resultado['nivel'] = "Gerente";
        }
        if($resultado['nivel'] == 3){
            $resultado['nivel'] = "Usuario";
        }
    $vetor[] = $resultado;
}    

print json_encode($vetor);
