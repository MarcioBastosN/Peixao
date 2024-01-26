<?php

class daoCliente {
    
    private $SELECT = "SELECT * FROM cliente";
    
    function getCliente(){
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $query = mysqli_query($conexao, $this->SELECT);
        while($rs = mysqli_fetch_assoc($query)){
            $dados[] = $rs;
        }
        $conn->fecharConexao();
        return $dados;
    }
    
    function InserirCliente(Cliente $c){
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $nome = $c->getNome();
        $query = "INSERT INTO `cliente` (`Nome`) VALUES ('".$nome."')";
        $sql = mysqli_query($conexao, $query);
        if($sql){
            return "success";
        }else{
            return "erro ao inserir Cliente";
        }
        $conn->fecharConexao();
    }
    
    function AtualizarCliente(Cliente $c){
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $nome = $c->getNome();
        $codigo = $c->getID();
        $query = "UPDATE cliente set `Nome` = '$nome' WHERE `ID` = '$codigo';";
        $sql = mysqli_query($conexao, $query);
        if($sql){
            return "success";
        }else{
            return "Erro ao atualizar o Cliente";
        }
        $conn->fecharConexao();
    }
    
    function RetornaClienteAtivo(){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $query = "SELECT `valor` FROM `temp_lancamento` WHERE `col_lancamento` = 1 ;";
        $sql = mysqli_query($conn, $query);
        while($rs = mysqli_fetch_assoc($sql)){
            $dados[] = $rs;
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
}
