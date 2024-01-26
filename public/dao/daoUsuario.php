<?php

class daoUsuario {
    
    private $SELECT = "SELECT * FROM usuarios;";
    
    function getUsuarios(){
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $query = mysqli_query($conexao, $this->SELECT);
        while($rs = mysqli_fetch_assoc($query)){
            $dados[] = $rs;
        }
        $conn->fecharConexao();
        return $dados;
    }
    
    function InserirUsuario(Usuario $u){
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $usuario = $u->getUsuario();
        $nome = $u->getNome();
        $senha = $u->getSenha();
        $nivel = $u->getNivel();
        $sql = "INSERT INTO `usuarios` (`usuario`,`nome`,`senha`,`nivel`) values ('$usuario', '$nome', '$senha', '$nivel')";
        $query = mysqli_query($conexao, $sql);
        $conn->fecharConexao();
        if($query){
            return "success";
        }else{
            return "erro ao inserir o Usuario.";
        }
    }
    
    function VerificaUsuario($usuario){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $sqlverifica = "SELECT * FROM `usuarios`";
        $queryverifica = mysqli_query($conn, $sqlverifica);
        $conexao->fecharConexao();
        $flag = 0;
        if($queryverifica){
            while($resultado = mysqli_fetch_assoc($queryverifica)){
                if($resultado['usuario'] == $usuario){
                  $flag = 1;  
                }
            }
        }
        return $flag;
    }
    
    function ApagarUsuario($usuario){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $sql = "DELETE FROM `usuarios` WHERE `id` = $usuario ;";
        $quey = mysqli_query($conn, $sql);
        $conexao->fecharConexao();
        if($quey){
            return "success";
        }else{
            return "Erro, Usuario nao foi apagado !";
        }
    }
}
