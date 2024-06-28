<?php

include ("conexion/classConexion.php");

/*require_once("../conexion/classConexion.php");*/
require_once ("entidad/letra.php");

class daoletra extends Conexion {

	public function Insertar($letra) {

		$consulta = "insert into letras values (:letra,:veces)";

		$param = array(":letra" => $letra->__get("letra"), ":veces" => $letra->__get("veces"));

		$this->ConsultaSimple($consulta, $param);

	}

	public function Actualizar($letra) {

		$consulta = "update letras set Veces=Veces + :veces where Letra=:letra";

		$param = array(":veces" => $letra->__get("veces"), ":letra" => $letra->__get("letra"));

		$this->ConsultaSimple($consulta, $param);

	}

	public function existe($letra) {

		$consulta = "select * from letras where BINARY Letra like :letra";

		$param = array(":letra" => $letra);

		$this->Consulta($consulta, $param);

		return count($this->datos);

	}

}

?>