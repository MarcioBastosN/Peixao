<?php

class daoProduto {

    private $SELECT = "SELECT * FROM produto;";

    function getProdutos() {
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $query = mysqli_query($conexao, $this->SELECT);
        while ($rs = mysqli_fetch_assoc($query)) {
            $dados[] = $rs;
        }
        $conn->fecharConexao();
        return $dados;
    }

    public function Inserir(Produto $p) {
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $nome = $p->getNome();
        $query = "INSERT INTO `produto` (`Nome`) values ('".$nome."')";
        $sql = mysqli_query($conexao, $query);
        if ($sql) {
            return "success";
        } else {
            return "Erro ao inserir o produto!";
        }
        $conexao->$conn->fecharConexao();
    }

    public function RetornaNome_Id($id) {
        $conn = new conexao();
        $conexao = $conn->getConexao();

        $SELECT_ID = "SELECT * FROM produto WHERE ID = " . $id . " LIMIT 1;";

        $query = mysqli_query($conexao, $SELECT_ID);
        while ($temp = mysqli_fetch_assoc($query)) {
            $dados[] = $temp;
        }
        $conn->fecharConexao();
        return $dados;
    }

    public function RetornaId_Nome(Produto $p) {
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $nomeProduto = $p->getNome();
        
        $ListNome = "SELECT * FROM `produto` WHERE `Nome` LIKE '$nomeProduto';";
        $query = mysqli_query($conexao, $ListNome);
        $dados = "";
        $conn->fecharConexao();
        if($query){
//            return "success";
            while ($rs = mysqli_fetch_assoc($query)) {
//                $dados[] = $rs;
                return $rs["ID"];
//            echo json_encode($rs);
            }
//            return $dados;
        }else{
            return $query;
        }        
//        return $ListNome;
    }

    public function Atualizar(Produto $p) {
        $conn = new conexao();
        $conexao = $conn->getConexao();
        $nome = $p->getNome();
        $codigo = $p->getId();
        $Atulizar = "UPDATE produto SET Nome = '$nome' WHERE ID = '$codigo';";
        $query = mysqli_query($conexao, $Atulizar);
        if ($query) {
            return "success";
        } else {
            return "Erro, não foi possivel atualizar o produto.";
        }
        $conn->fecharConexao();
    }
    
}
