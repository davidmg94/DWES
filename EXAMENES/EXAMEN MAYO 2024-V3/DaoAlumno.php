<?php
require_once 'LibreriaPDO.php';
require_once 'Alumno.php';
class DaoAlumno extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }
    function insertar($alumno) {
        $sql = "INSERT INTO alumnos Values (?, ?, ?, ?, ?,?)";

        $params = array(
            $alumno->dni,
            $alumno->nombre,
            $alumno->apellido1,
            $alumno->apellido2,
            $alumno->edad,
            $alumno->telefono
        );

        $this->ConsultaSimple($sql, $params);
    }
    function actualizar($alumno) {
        $sql = "UPDATE alumnos SET Nombre=?, Apellido1=?, Apellido2=?, Edad=?, Telefono=? WHERE Dni=?";

        $params = array(
            $alumno->nombre,
            $alumno->apellido1,
            $alumno->apellido2,
            $alumno->edad,
            $alumno->telefono,
            $alumno->dni
        );

        $this->ConsultaSimple($sql, $params);
    }

    function eliminar($dni) {
        $sql = "DELETE FROM alumnos WHERE Dni = ?";
        $params = array($dni);
        $this->ConsultaSimple($sql, $params);
    }
    function eliminarTodos() {
        $sql = "DELETE FROM alumnos";
        $params = array();
        $this->ConsultaSimple($sql, $params);
    }
    function obtener($dni) {
        $dni = trim($dni);

        $sql = "SELECT * FROM alumnos WHERE Dni=?";

        $this->datos = array();

        $params = array($dni);

        $this->Consulta($sql, $params);

        $alumno = $this->datos;

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

    function listar() {
        $sql = "SELECT * FROM alumnos";

        $this->datos = array();

        $this->Consulta($sql, array());

        $datosAlumnos = array();

        $alumnos = $this->datos;

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

        return $datosAlumnos;
    }

    function buscarPorNombre($nombre) {
        
        $sql = "SELECT * FROM alumnos WHERE Nombre LIKE ?";
        $params = ["$nombre%"];
        $this->datos = array();
        $this->Consulta($sql, $params);
        $datosAlumnos = array();
        $alumnos = $this->datos;
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
        return $datosAlumnos;
    }
    function buscar($criterio) {
        
        $sql = "SELECT * FROM alumnos WHERE Nombre LIKE ? OR Apellido1 LIKE ? OR Apellido2 LIKE ? OR Dni LIKE ? OR Telefono LIKE ? OR Edad LIKE ?";
        $params = ["$criterio%", "$criterio%", "$criterio%", "$criterio%", "$criterio%","$criterio%"];
        $this->datos = array();
        $this->Consulta($sql, $params);
        $datosAlumnos = array();
        $alumnos = $this->datos;
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
        return $datosAlumnos;
    }
}
?>