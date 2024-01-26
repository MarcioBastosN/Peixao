<?php

class Lancamento {
    private $id;
    private $produto;
    private $cliente;
    private $volume;
    private $peso;
    private $diaAtual;
    private $dataLancamento;
    private $situacao;
    private $nr;
    private $observacoes;
    private $class;
    
    function getClass() {
        return $this->class;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function getDiaAtual() {
        return $this->diaAtual;
    }

    function getDataLancamento() {
        return $this->dataLancamento;
    }

    function setDiaAtual($diaAtual) {
        $this->diaAtual = $diaAtual;
    }

    function setDataLancamento($dataLancamento) {
        $this->dataLancamento = $dataLancamento;
    }

    function getId() {
        return $this->id;
    }

    function getProduto() {
        return $this->produto;
    }
    
    function getCliente() {
        return $this->cliente;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
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

    function getNr() {
        return $this->nr;
    }

    function getObservacoes() {
        return $this->observacoes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProduto($produto) {
        $this->produto = $produto;
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

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }
    
}