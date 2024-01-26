<?php

class daoLancamento {
    
    private $SELECT = "SELCT * FROM estoque ;";
    
    function Inserir(Lancamento $l){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $cliente = $l->getCliente(); $peixe = $l->getProduto(); $nr = $l->getNr(); $Temp_Volume = $l->getVolume();
        $Temp_Peso = $l->getPeso(); $situacao = $l->getSituacao(); $data = $l->getDataLancamento();
        $Dia_atual = $l->getDiaAtual(); $class = $l->getClass(); $observacao = $l->getObservacoes();
        $query = "INSERT INTO `estoque` (`ClienteID`,`ProdutoID`,`NR`,`Volume`,`Peso`,`situacao`,`Data_Estoque`,`Data_Digitacao`,`Class`, `observacao`) "
            . "VALUES ('$cliente','$peixe','$nr','$Temp_Volume','$Temp_Peso','$situacao','$data','$Dia_atual', '$class', '$observacao');";
        $sql = mysqli_query($conn, $query);
        $conexao->fecharConexao();
        if($sql){
            return "success";
        }else{
            return "Erro ao realizar o lançamento";
        }
    }
    
    function AlterarClienteAtivo($cliente){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $clienteAtivo = new daoCliente();
        $tempCliente = $clienteAtivo->RetornaClienteAtivo();
        if($tempCliente != $cliente){
            $query = "UPDATE `temp_lancamento` SET `valor`= $cliente WHERE `col_lancamento` = 1";
            $sql = mysqli_query($conn, $query);
            $conexao->fecharConexao();
            if($sql){
                return "success";
            }else{
                return "Erro ao atualizar o Cliente Ativo";
            }
        }
    }
    
    function ValidaIdProduto($id){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $query = "SELECT ID FROM produto;";
        $sql = mysqli_query($conn, $query);
        while($rs = mysqli_fetch_assoc($sql)){
            if($rs["ID"] == $id){
                $rs["success"] = "success";
                $dados[] = $rs;
            }else{
                $dados[] = $rs;
            }
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
    function AtualizarLancamento(Lancamento $l){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $cliente = $l->getCliente(); $peixe = $l->getProduto(); $nr = $l->getNr(); $volume = $l->getVolume();
        $peso = $l->getPeso(); $situacao = $l->getSituacao(); $data = $l->getDataLancamento();
        $Dia_atual = $l->getDiaAtual(); $class = $l->getClass(); $observacao = $l->getObservacoes(); $ID = $l->getId();
        $query = "UPDATE `estoque` SET `ClienteID`='$cliente',`ProdutoID`='$peixe',`NR`='$nr',"
                . "`Volume`='$volume',`Peso`='$peso',`situacao`='$situacao',`Data_Estoque`= '$data', "
                . "`Class`='$situacao',`observacao`='$observacao' WHERE `ID` = '$ID';";
        $sql = mysqli_query($conn, $query);
        $conexao->fecharConexao();
        if($sql){
            return "success";
        }else{
            return "Erro ao realizar o lançamento";
        }
    }
    
    function RetornaValoresEdicao($cod){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $query = "SELECT * FROM `estoque` WHERE `ID` = '$cod' ;";
        $sql = mysqli_query($conn, $query);
        while($rs = mysqli_fetch_assoc($sql)){
            $dados[] = $rs;
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
    function RetornaConsultaLancamento_porData(Lancamento $l){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $olderdata = $l->getDiaAtual();
        $atual = $l->getDataLancamento();
        $query = "SELECT `E`.`ID` AS `ID`, `C`.`Nome` AS `ClienteID`, `P`.`Nome` AS `ProdutoID`, `E`.`NR` AS `NR`, `E`.`Volume` AS `Volume`,
            `E`.`Peso` AS `Peso`, `S`.`Tipo` AS `situacao`, `E`.`Data_Estoque` AS `Data_Estoque`, `E`.`Data_Digitacao` AS `Data_Digitacao`,
            `tc`.`estado` AS `Class`,`E`.`observacao` AS `Observacao`
        FROM ((((`cliente` `C` JOIN `produto` `P`) JOIN `estoque` `E`) JOIN `classe` `tc`) JOIN `situacao` `S`)
        WHERE ((`E`.`ClienteID` = `C`.`ID`) and (`E`.`ProdutoID` = `P`.`ID`) and (`E`.`Class`= `tc`.`id`) and (`E`.`situacao` = `S`.`id`)
            and (`E`.`Data_Estoque` BETWEEN ('$olderdata') and ('$atual'))) ORDER BY `E`.`ID` desc, Data_Estoque desc, NR desc";
        $sql = mysqli_query($conn, $query);
        while($rs = mysqli_fetch_assoc($sql)){
            $dados[] = $rs;
        }
        $conexao->fecharConexao();
        return $dados;
    }
    
    function ApagarLancamento($id){
        $conexao = new conexao();
        $conn = $conexao->getConexao();
        $query = "DELETE FROM `estoque` WHERE `ID` = $id";
        $sql = mysqli_query($conn, $query);
        $conexao->fecharConexao();
        if($sql){
            return "success";
        }else{
            return "Erro ao apagar o lancamento.";
        }
    }
}
