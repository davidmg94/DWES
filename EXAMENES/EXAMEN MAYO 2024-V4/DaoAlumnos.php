<?php

// Necesitamos incluir la libreria y la clase entidad asociada al DAO
require_once 'LibreriaPDO.php';
require_once 'Alumno.php';

class DaoAlumnos extends DB {
    public $alumnos = array();  // Array de objetos con el resultado de las consultas

    public function __construct($base)  // Al instancial el dao especificamos sobre que BBDD queremos que actue 
    {
        $this->dbname = $base;
    }

    public function listar()       // Lista el contenido de la tabla
    {
        $consulta = "select * from Alumnos ";
        $param = array();
        $this->alumnos = array();  // Vaciamos el array de las situaciones entre consulta y consulta
        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $alu = new Alumno();
            $alu->__set("Dni", $fila['Dni']);
            $alu->__set("Nombre", $fila['Nombre']);
            $alu->__set("Apellido1", $fila['Apellido1']);
            $alu->__set("Apellido2", $fila['Apellido2']);
            $alu->__set("Edad", $fila['Edad']);
            $alu->__set("Telefono", $fila['Telefono']);
            $this->alumnos[] = $alu;   // Insertamos el objeto con los valores de esa fila en el array de objetos
        }
    }

    public function obtener($dni)          // Obtenemos el elemento a partir de su Id
    {
        $consulta = "select * from Alumnos where Dni=:Dni";
        $param = array(":Dni" => $dni);
        $this->ConsultaDatos($consulta, $param);

        $alu = new Alumno();
        if (count($this->filas) == 1) {
            $fila = $this->filas[0];  // Recuperamos la fila devuelta
            $alu = new Alumno();
            $alu->__set("Dni", $fila['Dni']);
            $alu->__set("Nombre", $fila['Nombre']);
            $alu->__set("Apellido1", $fila['Apellido1']);
            $alu->__set("Apellido2", $fila['Apellido2']);
            $alu->__set("Telefono", $fila['Telefono']);
            $alu->__set("Edad", $fila['Edad']);
        } else {
            echo "<b>El NIF introducido no corresponde con ningun alumno</b>";
        }
        return $alu;
    }

    public function actualizar($alu)     // Recibimos como parámetro un objeto con los datos a actualizar   
    {
        $consulta = "update Alumnos set Nombre=:Nombre,
                                     Apellido1=:Apellido1,
                                     Apellido2=:Apellido2,
                                     Edad=:Edad,  
                                     Telefono=:Telefono where Dni=:Dni";
        $param = array();
        $param[":Dni"] = $alu->__get("Dni");
        $param[":Nombre"] = $alu->__get("Nombre");
        $param[":Apellido1"] = $alu->__get("Apellido1");
        $param[":Apellido2"] = $alu->__get("Apellido2");
        $param[":Edad"] = $alu->__get("Edad");
        $param[":Telefono"] = $alu->__get("Telefono");

        $this->ConsultaSimple($consulta, $param);
    }
    // Método para buscar alumnos según criterios específicos
    public function buscarAlumnos($nombre, $apellido1, $apellido2, $min, $max) {
        $consulta = "select * from Alumnos where 1 "; // Consulta base, "where 1" siempre es verdadero
        $parametros = array(); // Array de parámetros de la consulta

        // Construimos la consulta dinámica según los criterios recibidos
        if ($nombre != '') {
            $consulta .= " AND Nombre = ?";
            $parametros[] = $nombre;
        }
        if ($apellido1 != '') {
            $consulta .= " AND Apellido1 = ?";
            $parametros[] = $apellido1;
        }
        if ($apellido2 != '') {
            $consulta .= " AND Apellido2 = ?";
            $parametros[] = $apellido2;
        }
        if ($min != '') {
            $consulta .= " AND Edad >= ?";
            $parametros[] = $min;
        }
        if ($max != '') {
            $consulta .= " AND Edad <= ?";
            $parametros[] = $max;
        }

        $this->alumnos = array();  // Vaciamos el array de las situaciones entre consulta y consulta
        $this->ConsultaDatos($consulta, $parametros); // Ejecutamos la consulta

        // Iteramos sobre los resultados y creamos objetos Alumno
        foreach ($this->filas as $fila) {
            $alu = new Alumno();
            $alu->__set("Dni", $fila['Dni']);
            $alu->__set("Nombre", $fila['Nombre']);
            $alu->__set("Apellido1", $fila['Apellido1']);
            $alu->__set("Apellido2", $fila['Apellido2']);
            $alu->__set("Edad", $fila['Edad']);
            $alu->__set("Telefono", $fila['Telefono']);
            $this->alumnos[] = $alu;   // Insertamos el objeto con los valores de esa fila en el array de objetos
        }
        return $this->alumnos; // Devolvemos el array de objetos Alumno
    }
}

?>