<?php

class Alumno {
    private $id;
    private $nombre;
    private $apellido;
    private $pais_id;
    private $provincia_id;
    private $localidad_id;

    function __construct($id, $nombre, $apellido, $pais_id, $provincia_id, $localidad_id) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->$apellido = $apellido;
        $this->pais_id = $pais_id;
        $this->provincia_id = $provincia_id;
        $this->localidad_id = $localidad_id;
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
