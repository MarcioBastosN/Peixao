<?php

class daoSituacao {
    
    function getSituacao(){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $query = "SELECT * FROM `situacao` ;";
        $sql = mysqli_query($conn, $query);
        while($rs = mysqli_fetch_assoc($sql)){
            $dados[] = $rs;
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
}
