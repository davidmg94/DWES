<?php
// Incluye el archivo que contiene la definición de la clase Alumno
include_once "alumno.php";
include_once "LibreriaPDO.php";

// Definición de la clase DaoAlumno que hereda de DB
class DaoAlumno extends DB {
    // Constructor que llama al constructor de la clase padre
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }

    // Método para insertar un nuevo alumno en la base de datos
    function insertar($alumno) {
        // Construye la consulta SQL para insertar un nuevo alumno
        $sql = "INSERT INTO alumnos Values (?, ?, ?, ?, ?,?)";

        // Parámetros de la consulta
        $params = array(
            $alumno->dni,
            $alumno->nombre,
            $alumno->apellido1,
            $alumno->apellido2,
            $alumno->edad,
            $alumno->telefono
        );

        // Ejecuta la consulta SQL
        $this->ConsultaSimple($sql, $params);
    }

    // Método para actualizar los datos de un alumno en la base de datos
    function actualizar($alumno) {
        // Construye la consulta SQL para actualizar los datos del alumno
        $sql = "UPDATE alumnos SET Nombre=?, Apellido1=?, Apellido2=?, Edad=?, Telefono=? WHERE Dni=?";

        // Parámetros de la consulta
        $params = array(
            $alumno->nombre,
            $alumno->apellido1,
            $alumno->apellido2,
            $alumno->edad,
            $alumno->telefono,
            $alumno->dni
        );

        // Ejecuta la consulta SQL
        $this->ConsultaSimple($sql, $params);
    }

    // Método para obtener un alumno por su DNI
    function obtener($dni) {
        // Limpia el array de datos de alumnos para evitar repeticiones
        $this->datos = array();

        // Elimina posibles espacios en blanco del DNI
        $dni = trim($dni);

        // Construye la consulta SQL para obtener un alumno por su DNI
        $sql = "SELECT * FROM alumnos WHERE Dni=?";

        // Parámetros de la consulta
        $params = array($dni);

        // Ejecuta la consulta SQL
        $this->Consulta($sql, $params);

        // Obtiene los datos del alumno
        $alumno = $this->datos;

        // Si se encontró el alumno, crea un objeto Alumno con los datos obtenidos
        if (!empty($alumno)) {
            $alumno = new Alumno(
                $alumno[0]['Dni'],
                $alumno[0]['Nombre'],
                $alumno[0]['Apellido1'],
                $alumno[0]['Apellido2'],
                $alumno[0]['Edad'],
                $alumno[0]['Telefono']
            );
            return $alumno;
        }
        return null;
    }

    // Método para borrar un alumno por su DNI
    function eliminar($dni) {
        // Construye la consulta SQL para borrar alumnos por sus DNIs
        $sql = "DELETE FROM alumnos WHERE Dni = ?";
        // Parámetros de la consulta
        $params = array($dni);
        // Ejecuta la consulta SQL
        $this->ConsultaSimple($sql, $params);
    }

    // Método para borrar todos los datos de la tabla
    function eliminarTodos() {
        // Construye la consulta SQL para borrar todos los datos de la tabla
        $sql = "DELETE FROM alumnos";
        // Parámetros de la consulta
        $params = array();
        // Ejecuta la consulta SQL
        $this->ConsultaSimple($sql, $params);
    }
    
    // Método para listar todos los alumnos
    function listar() {
        // Construye la consulta SQL para listar todos los alumnos
        $sql = "SELECT * FROM alumnos";

        // Limpia el array de datos de alumnos para evitar repeticiones
        $this->datos = array();

        // Ejecuta la consulta SQL (se le pasa un array vacio pues no tenemos parametros para la consulta)
        $this->Consulta($sql, array());

        // Arreglo para almacenar los datos de los alumnos
        $datosAlumnos = array();

        // Obtiene los resultados de la consulta SQL
        $alumnos = $this->datos;

        // Recorre los resultados y crea objetos Alumno
        foreach ($alumnos as $alumno) {
            $objAlumno = new Alumno(
                $alumno['Dni'],
                $alumno['Nombre'],
                $alumno['Apellido1'],
                $alumno['Apellido2'],
                $alumno['Edad'],
                $alumno['Telefono']
            );
            array_push($datosAlumnos, $objAlumno);
        }

        // Retorna el arreglo con los datos de los alumnos
        return $datosAlumnos;
    }
}
?>