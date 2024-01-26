<?php

class Estoque {
    
    private $ID;
    private $clienteID;
    private $produtoId;
    private $nr;
    private $volume;
    private $peso;
    private $situacao;
    private $data_Estoque;
    private $data_Digitacao;
    private $class;
    private $observacoes;
    
    function __construct() {
        
    }

    function getID() {
        return $this->ID;
    }

    function getClienteID() {
        return $this->clienteID;
    }

    function getProdutoId() {
        return $this->produtoId;
    }

    function getNr() {
        return $this->nr;
    }

    function getVolume() {
        return $this->volume;
    }

    function getPeso() {
        return $this->peso;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getData_Estoque() {
        return $this->data_Estoque;
    }

    function getData_Digitacao() {
        return $this->data_Digitacao;
    }

    function getClass() {
        return $this->class;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setClienteID($clienteID) {
        $this->clienteID = $clienteID;
    }

    function setProdutoId($produtoId) {
        $this->produtoId = $produtoId;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setVolume($volume) {
        $this->volume = $volume;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setData_Estoque($data_Estoque) {
        $this->data_Estoque = $data_Estoque;
    }

    function setData_Digitacao($data_Digitacao) {
        $this->data_Digitacao = $data_Digitacao;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

}