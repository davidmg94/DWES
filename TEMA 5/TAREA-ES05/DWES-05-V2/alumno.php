<?php

// Definición de la clase alumno
class Alumno {
    // Propiedades privadas de la clase alumno
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $edad;
    private $telefono; // Nueva propiedad telefono

    // Método constructor que inicializa las propiedades del alumno
    function __construct($dni, $nombre, $apellido1, $apellido2, $edad, $telefono) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->edad = $edad;
        $this->telefono = $telefono; // Inicialización de la nueva propiedad telefono
    }

    // Método para obtener el valor de una propiedad específica del alumno
    public function __get($property) {
        // Verifica si la propiedad existe y la devuelve si es así
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    // Método para establecer el valor de una propiedad específica del alumno
    public function __set($property, $value) {
        // Verifica si la propiedad existe y la actualiza si es así
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}
