<?php
require_once 'LibreriaPDO.php';
require_once 'alumno.php';
class DaoAlumno extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
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