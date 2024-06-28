<?php
// Incluir el archivo LibreriaPDO.php que contiene la clase DB y la configuración de la conexión a la base de datos
require_once ('LibreriaPDO.php');

// Definir la clase PaisesDAO que extiende de la clase DB
class PaisesDAO extends DB {
    // Método para obtener todos los registros de la tabla Paises
    function getPaises() {
        // Inicializar el arreglo donde se almacenarán los datos de los países encontrados
        $this->datos = array();

        // Consulta SQL para seleccionar todos los países
        $sql = 'SELECT * FROM Paises';

        // No se requieren parámetros para esta consulta, se inicializa vacío
        $param = array();

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $paises
        $paises = $this->datos;

        // Devolver todos los resultados de la consulta
        return $paises;
    }
}

// Definir la clase ProvinciasDAO que extiende de la clase DB
class ProvinciasDAO extends DB {
    // Método para obtener todos los registros de la tabla Provincias
    function getProvincias() {
        // Inicializar el arreglo donde se almacenarán los datos de las provincias encontradas
        $this->datos = array();

        // Consulta SQL para seleccionar todas las provincias
        $sql = 'SELECT * FROM Provincias';

        // No se requieren parámetros para esta consulta, se inicializa vacío
        $param = array();

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $provincias
        $provincias = $this->datos;

        // Devolver todos los resultados de la consulta
        return $provincias;
    }
}

// Definir la clase LocalidadesDAO que extiende de la clase DB
class LocalidadesDAO extends DB {
    // Método para obtener todos los registros de la tabla Localidades
    function getLocalidades() {
        // Inicializar el arreglo donde se almacenarán los datos de las localidades encontradas
        $this->datos = array();

        // Consulta SQL para seleccionar todas las localidades
        $sql = 'SELECT * FROM Localidades';

        // No se requieren parámetros para esta consulta, se inicializa vacío
        $param = array();

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $localidades
        $localidades = $this->datos;

        // Devolver todos los resultados de la consulta
        return $localidades;
    }
}
?>