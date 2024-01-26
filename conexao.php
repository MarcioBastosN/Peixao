<?php

class conexao {
    
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "mydb";
    private $port = "3306";
    private $conexao;

    function getConexao() {
        $this->conexao = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port) or die("Erro de Conexao ao Banco de Dados");
        return $this->conexao;
    }
    
    function fecharConexao(){
        return mysqli_close($this->conexao) or die("Erro ao Fechar a conexao");
    }
    
}
