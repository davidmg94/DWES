<?php
// Incluir el archivo LibreriaPDO.php que contiene la clase DB y la configuración de la conexión a la base de datos
require_once ('LibreriaPDO.php');

// Clase PaisesDAO que extiende la clase DB para heredar la conexión a la base de datos
class PaisesDAO extends DB {
    // Método para obtener todos los registros de la tabla Paises
    function getPaises() {
        // Inicializar el arreglo donde se almacenarán los datos
        $this->datos = array();

        // Consulta SQL para seleccionar todos los países
        $sql = 'SELECT * FROM Paises';

        // Parámetros vacíos, ya que la consulta no requiere argumentos adicionales
        $param = array();

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $paises
        $paises = $this->datos;

        // Retornar el arreglo con los países obtenidos de la base de datos
        return $paises;
    }
}

// Clase ProvinciasDAO que extiende la clase DB para heredar la conexión a la base de datos
class ProvinciasDAO extends DB {
    // Método para obtener todos los registros de la tabla Provincias según el ID del país
    function getProvincias($idPais) {
        // Inicializar el arreglo donde se almacenarán los datos
        $this->datos = array();

        // Consulta SQL para seleccionar todas las provincias de un país específico
        $sql = 'SELECT * FROM provincias WHERE id_pais=?';

        // Parámetros de la consulta, el ID del país se pasa como argumento
        $param = array($idPais);

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $provincias
        $provincias = $this->datos;

        // Retornar el arreglo con las provincias obtenidas de la base de datos
        return $provincias;
    }
}

// Clase LocalidadesDAO que extiende la clase DB para heredar la conexión a la base de datos
class LocalidadesDAO extends DB {
    // Método para obtener todos los registros de la tabla Localidades según el ID de la provincia
    function getLocalidades($idProvincia) {
        // Inicializar el arreglo donde se almacenarán los datos
        $this->datos = array();

        // Consulta SQL para seleccionar todas las localidades de una provincia específica
        $sql = 'SELECT * FROM localidades WHERE id_provincia=?';

        // Parámetros de la consulta, el ID de la provincia se pasa como argumento
        $param = array($idProvincia);

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $localidades
        $localidades = $this->datos;

        // Retornar el arreglo con las localidades obtenidas de la base de datos
        return $localidades;
    }
}
?>