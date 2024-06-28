<?php
require_once 'LibreriaPDO.php';
require_once 'alumno.php';
class DaoAlumno extends DB {
    function __construct($bbdd) {
        parent::__construct($bbdd);
    }
    function insertar($alumno) {

        $sql = "INSERT INTO alumnos (NIF, Nombre, Apellido1, Apellido2, Premios, Telefono) VALUES (?, ?, ?, ?, ?, ?)";
        $params = array(
            $alumno->nif,
            $alumno->nombre,
            $alumno->apellido1,
            $alumno->apellido2,
            $alumno->premios,
            $alumno->telefono
        );

        $this->ConsultaSimple($sql, $params);
    }
    function actualizar($alumno) {
        $sql = "UPDATE alumnos SET Nombre=?, Apellido1=?, Apellido2=?, Premios=?, Telefono=? WHERE NIF=?";

        $params = array(
            $alumno->nombre,
            $alumno->apellido1,
            $alumno->apellido2,
            $alumno->premios,
            $alumno->telefono,
            $alumno->nif
        );

        $this->ConsultaSimple($sql, $params);
    }

    function eliminar($nif) {
        $sql = "DELETE FROM alumnos WHERE NIF = ?";
        $params = array($nif);
        $this->ConsultaSimple($sql, $params);
    }

    function obtenerNifs() {
        $sql = "SELECT * FROM alumnos ORDER BY NIF ASC";

        $this->datos = array();

        $this->Consulta($sql, array());

        $nifsAlumnos = array();

        $alumnos = $this->datos;

        foreach ($alumnos as $alumno) {
            $nif = $alumno['NIF'];
            array_push($nifsAlumnos, $nif);
        }

        return $nifsAlumnos;
    }

    function obtenerSiguiente($nif) {
        $nif = trim($nif);

        $sql = "SELECT * FROM alumnos WHERE  NIF>? ORDER BY NIF LIMIT 1";

        $this->datos = array();

        $params = array($nif);

        $this->Consulta($sql, $params);

        $alumnos = $this->datos;

        if (!empty($alumnos)) {
            $alumno = new Alumno(
                $alumnos[0]['NIF'],
                $alumnos[0]['Nombre'],
                $alumnos[0]['Apellido1'],
                $alumnos[0]['Apellido2'],
                $alumnos[0]['Premios'],
                $alumnos[0]['Telefono']
            );
            return $alumno;
        }
        return null;
    }

    function obtenerAnterior($nif) {
        $nif = trim($nif);

        $sql = "SELECT * FROM alumnos WHERE  NIF<? ORDER BY NIF DESC LIMIT 1";

        $this->datos = array();

        $params = array($nif);

        $this->Consulta($sql, $params);

        $alumnos = $this->datos;

        if (!empty($alumnos)) {
            $alumno = new Alumno(
                $alumnos[0]['NIF'],
                $alumnos[0]['Nombre'],
                $alumnos[0]['Apellido1'],
                $alumnos[0]['Apellido2'],
                $alumnos[0]['Premios'],
                $alumnos[0]['Telefono']
            );
            return $alumno;
        }
        return null;
    }

    function obtener($nif) {
        $nif = trim($nif);

        $sql = "SELECT * FROM alumnos WHERE  NIF=?";

        $this->datos = array();

        $params = array($nif);

        $this->Consulta($sql, $params);

        $alumnos = $this->datos;

        if (!empty($alumnos)) {
            $alumno = new Alumno(
                $alumnos[0]['NIF'],
                $alumnos[0]['Nombre'],
                $alumnos[0]['Apellido1'],
                $alumnos[0]['Apellido2'],
                $alumnos[0]['Premios'],
                $alumnos[0]['Telefono']
            );
            return $alumno;
        }
        return null;
    }

    function obtenerPrimerAlumno() {

        $sql = "SELECT * FROM alumnos ORDER BY NIF ASC LIMIT 1";

        $this->datos = array();

        $params = array();

        $this->Consulta($sql, $params);

        $alumnos = $this->datos;

        if (!empty($alumnos)) {
            $alumno = new Alumno(
                $alumnos[0]['NIF'],
                $alumnos[0]['Nombre'],
                $alumnos[0]['Apellido1'],
                $alumnos[0]['Apellido2'],
                $alumnos[0]['Premios'],
                $alumnos[0]['Telefono']
            );
            return $alumno;
        }
        return null;
    }
    function obtenerUltimoAlumno() {

        $sql = "SELECT * FROM alumnos ORDER BY NIF DESC LIMIT 1";

        $this->datos = array();

        $params = array();

        $this->Consulta($sql, $params);

        $alumnos = $this->datos;

        if (!empty($alumnos)) {
            $alumno = new Alumno(
                $alumnos[0]['NIF'],
                $alumnos[0]['Nombre'],
                $alumnos[0]['Apellido1'],
                $alumnos[0]['Apellido2'],
                $alumnos[0]['Premios'],
                $alumnos[0]['Telefono']
            );
            return $alumno;
        }
        return null;
    }
    function listar() {
        $sql = "SELECT * FROM alumnos ORDER BY NIF ASC";

        $this->datos = array();

        $this->Consulta($sql, array());

        $datosAlumnos = array();

        $alumnos = $this->datos;

        foreach ($alumnos as $alumno) {
            $objAlumno = new Alumno(
                $alumno['NIF'],
                $alumno['Nombre'],
                $alumno['Apellido1'],
                $alumno['Apellido2'],
                $alumno['Premios'],
                $alumno['Telefono']
            );
            array_push($datosAlumnos, $objAlumno);
        }

        return $datosAlumnos;
    }
}

?>