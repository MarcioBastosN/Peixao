<?php

class Cliente {
    private $ID;
    private $Nome;
    
    function __construct() {
        
    }

    function getID() {
        return $this->ID;
    }

    function getNome() {
        return $this->Nome;
    }

    function setID($ID) {
        $this->ID = $ID;
    }

    function setNome($Nome) {
        $this->Nome = $Nome;
    }

}
