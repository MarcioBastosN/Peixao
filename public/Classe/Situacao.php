<?php

class Situacao {
    
    private $id;
    private $tipo;
    private $class;
    
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getClass() {
        return $this->class;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setClass($class) {
        $this->class = $class;
    }


    
}
