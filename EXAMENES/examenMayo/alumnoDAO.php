<?php
// Incluir el archivo LibreriaPDO.php que contiene la clase DB y la configuración de la conexión a la base de datos
require_once ('LibreriaPDO.php');
// Incluir el archivo alumno.php que contiene la definición de la clase Alumno
require_once ('alumno.php');

// Definir la clase AlumnoDAO que extiende de la clase DB
class AlumnoDAO extends DB {
    // Método para insertar un nuevo alumno en la base de datos
    function insertar($alumno) {
        // Consulta SQL para insertar un nuevo registro en la tabla Alumnos
        $sql = "INSERT INTO Alumnos (nombre, apellido, pais_id, provincia_id, localidad_id) VALUES (?, ?, ?, ?, ?)";

        // Parámetros que se utilizarán en la consulta preparada
        $params = array(
            $alumno->nombre,
            $alumno->apellido,
            $alumno->pais_id,
            $alumno->provincia_id,
            $alumno->localidad_id,
        );

        // Llamar al método ConsultaSimple de la clase DB para ejecutar la consulta
        $this->ConsultaSimple($sql, $params);
    }

    // Método para buscar alumnos en la base de datos según diferentes criterios
    function search($nombre = null, $apellido = null, $pais_id = null, $provincia_id = null, $localidad_id = null) {
        // Inicializar el arreglo donde se almacenarán los datos de los alumnos encontrados
        $this->datos = array();

        // Consulta inicial para seleccionar todos los alumnos
        $sql = 'SELECT * FROM alumnos WHERE 1';

        // Inicializar un array para almacenar los parámetros de la consulta
        $params = [];

        // Agregar condiciones a la consulta según los parámetros proporcionados
        if ($nombre) {
            $sql .= ' AND nombre = ?';
            $params[] = $nombre;
        }
        if ($apellido) {
            $sql .= ' AND apellido = ?';
            $params[] = $apellido;
        }
        if ($pais_id) {
            $sql .= ' AND pais_id = ?';
            $params[] = $pais_id;
        }
        if ($provincia_id) {
            $sql .= ' AND provincia_id = ?';
            $params[] = $provincia_id;
        }
        if ($localidad_id) {
            $sql .= ' AND localidad_id = ?';
            $params[] = $localidad_id;
        }

        // Llamar al método Consulta de la clase DB para ejecutar la consulta preparada con los parámetros
        $this->Consulta($sql, $params);

        // Almacenar los resultados de la consulta en la variable $alumnos
        $alumnos = $this->datos;

        // Devolver todos los resultados de la consulta
        return $alumnos;
    }

    // Método para buscar el nombre de un país según su ID
    function buscarPais($idPais) {
        // Inicializar el arreglo donde se almacenarán los datos del país encontrado
        $this->datos = array();

        // Consulta SQL para seleccionar el país según su ID
        $sql = "SELECT * FROM paises WHERE id=?";

        // Parámetros de la consulta, el ID del país se pasa como argumento
        $param = array($idPais);

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $pais
        $pais = $this->datos;

        // Devolver el nombre del país encontrado
        return $pais[0]['nombre'];
    }

    // Método para buscar el nombre de una provincia según su ID
    function buscarProvincia($idProvincia) {
        // Inicializar el arreglo donde se almacenarán los datos de la provincia encontrada
        $this->datos = array();

        // Consulta SQL para seleccionar la provincia según su ID
        $sql = "SELECT * FROM provincias WHERE id=?";

        // Parámetros de la consulta, el ID de la provincia se pasa como argumento
        $param = array($idProvincia);

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $provincia
        $provincia = $this->datos;

        // Devolver el nombre de la provincia encontrada
        return $provincia[0]['nombre'];
    }

    // Método para buscar el nombre de una localidad según su ID
    function buscarLocalidad($idLocalidad) {
        // Inicializar el arreglo donde se almacenarán los datos de la localidad encontrada
        $this->datos = array();

        // Consulta SQL para seleccionar la localidad según su ID
        $sql = "SELECT * FROM localidades WHERE id=?";

        // Parámetros de la consulta, el ID de la localidad se pasa como argumento
        $param = array($idLocalidad);

        // Llamar al método Consulta de la clase DB para ejecutar la consulta
        $this->Consulta($sql, $param);

        // Almacenar los resultados de la consulta en la variable $localidad
        $localidad = $this->datos;

        // Devolver el nombre de la localidad encontrada
        return $localidad[0]['nombre'];
    }
}
?>