<?php
include_once "alumno.php";

class DaoAlumno extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
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
}
?>