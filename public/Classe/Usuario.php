<?php

class Usuario {
    private $ID;
    private $nome;
    private $usuario;
    private $senha;
    private $nivel;
    
    function Usuario(){
        
    }

    function getID() {
        return $this->ID;
    }

    function getNome() {
        return $this->nome;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenha() {
        return $this->senha;
    }

    function getNivel() {
        return $this->nivel;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

}
