<?php
// Incluye el archivo que contiene la definición de la clase Alumno
include_once "alumno.php";

// Definición de la clase DaoAlumno
class DaoAlumno {
    // Propiedad privada para la conexión a la base de datos
    private $db;

    // Constructor que recibe la conexión a la base de datos como parámetro
    function __construct($db) {
        $this->db = $db;
    }

    // Método para insertar un nuevo alumno en la base de datos
    function insertar($alumno) {
        // Conecta a la base de datos
        $this->db->connect();

        // Construye la consulta SQL para insertar un nuevo alumno
        $sql = "INSERT INTO alumnos (Dni, Nombre, Apellido1, Apellido2, Edad, Telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $values = [$alumno->dni, $alumno->nombre, $alumno->apellido1, $alumno->apellido2, $alumno->edad, $alumno->telefono];
        // Ejecuta la consulta SQL
        $this->db->executeInstruction($sql, $values);

        // Cierra la conexión a la base de datos
        $this->db->close();
    }


    // Método para actualizar los datos de un alumno en la base de datos
    function actualizar($alumno) {
        // Conecta a la base de datos
        $this->db->connect();

        // Construye la consulta SQL para actualizar los datos del alumno
        $sql = "UPDATE alumnos SET Nombre=?, Apellido1=?, Apellido2=?, Edad=?, Telefono=? WHERE Dni=?";

        // Valores para la consulta preparada
        $values = [$alumno->nombre, $alumno->apellido1, $alumno->apellido2, $alumno->edad, $alumno->telefono, $alumno->dni];

        // Ejecuta la consulta SQL
        $this->db->executeInstruction($sql, $values);

        // Cierra la conexión a la base de datos
        $this->db->close();
    }

    // Método para obtener un alumno por su DNI
    function obtener($dni) {
        // Elimina posibles espacios en blanco del DNI
        $dni = trim($dni);
        
        // Conecta a la base de datos
        $this->db->connect();

        // Construye la consulta SQL para obtener un alumno por su DNI
        $sql = "SELECT * FROM alumnos WHERE Dni=?";

        // Ejecuta la consulta SQL y pasa los valores
        $alumno = $this->db->getDataSingle($sql, [$dni]);

        // Cierra la conexión a la base de datos
        $this->db->close();

        // Verifica si se encontró un alumno y crea un objeto Alumno con los datos obtenidos
        if ($alumno) {
            return new Alumno($alumno['Dni'], $alumno['Nombre'], $alumno['Apellido1'], $alumno['Apellido2'], $alumno['Edad'], $alumno['Telefono']);
        } else {
            return null;
        }
    }

    // Método para borrar un alumno por su DNI
    function eliminar($dni) {
        // Conecta a la base de datos
        $this->db->connect();
       
        // Construye la consulta SQL para borrar alumnos por sus DNIs
        $sql = "DELETE FROM alumnos WHERE Dni =?";

        // Ejecuta la consulta SQL
        $this->db->executeInstruction($sql, [$dni]);

        // Cierra la conexión a la base de datos
        $this->db->close();
    }

    // Método para listar todos los alumnos
    function listar() {
        // Conecta a la base de datos
        $this->db->connect();

        // Arreglo para almacenar los datos de los alumnos
        $datos = array();

        // Construye la consulta SQL para listar todos los alumnos
        $sql = "SELECT * FROM alumnos";

        // Obtiene los resultados de la consulta SQL
        $result = $this->db->getData($sql);

        // Recorre los resultados y crea objetos Alumno
        foreach ($result as $key => $value) {
            $alumno = new Alumno(
                $value['Dni'],
                $value['Nombre'],
                $value['Apellido1'],
                $value['Apellido2'],
                $value['Edad'],
                $value['Telefono']
            );
            array_push($datos, $alumno);
        }

        // Cierra la conexión a la base de datos
        $this->db->close();

        // Retorna el arreglo con los datos de los alumnos
        return $datos;
    }
}
