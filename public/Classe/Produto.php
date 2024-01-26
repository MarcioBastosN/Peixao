<?php

class Produto {
    
    private $id;
    private $nome;
    
    function Produto(){
        
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
    
    function toString(){
        return "['ID': '".$this->getId()."';Nome': '".$this->getNome()."'];";
    }
}
