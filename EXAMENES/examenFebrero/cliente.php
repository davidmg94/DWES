<?php

class Cliente {
    private $nif;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $edad;

    function __construct($nif, $nombre, $apellido1, $apellido2, $edad) {
        $this->nif = $nif;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->edad = $edad;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
