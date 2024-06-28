<?php

class DB {

	private $con; // Variable para almacenar la conexión a la base de datos
	private $bbdd; // Variable para almacenar el nombre de la base de datos
	private $host = "localhost"; // Host de la base de datos
	private $usu = "root"; // Usuario de la base de datos
	private $clave = ""; // Contraseña de la base de datos
	public $datos; // Variable para almacenar los datos de la consulta

	// Constructor de la clase que establece la conexión con la base de datos
	public function __construct($base) {

		try {
			$this->bbdd = $base;
			// Establece la conexión con la base de datos utilizando PDO
			$this->con = new PDO("mysql:host=$this->host;dbname=$this->bbdd", $this->usu, $this->clave);
			$this->con->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); // Configura el uso de consultas almacenadas en búfer
			$this->con->exec("set names utf8mb4"); // Establece la codificación de caracteres a UTF-8

		} catch (PDOException $e) {
			// Muestra un mensaje de error si no se puede establecer la conexión con la base de datos
			echo "  <p>Error: No puede conectarse con la base de datos.</p>\n\n";
			echo "  <p>Error: " . $e->getMessage() . "</p>\n";

			exit(); // Sale del script PHP
		}

	}

	// Método para ejecutar consultas que no devuelven datos
	public function ConsultaSimple($consulta, $param) {

		$sta = $this->con->prepare($consulta); // Prepara la consulta para su ejecución y desinfección

		if ($sta->execute($param)) {
			// La consulta se ejecutó correctamente
			// Puede mostrar un mensaje de éxito si es necesario
			// echo "  <p>Consulta ejecutada correctamente.</p>\n";
		} else {
			// La consulta falló, muestra un mensaje de error
			echo "  <p>Error en la consulta<p>\n";
		}
	}

	// Método para ejecutar consultas que devuelven datos
	public function Consulta($consulta, $param) {

		$sta = $this->con->prepare($consulta); // Prepara la consulta para su ejecución y desinfección

		if ($sta->execute($param)) {
			// La consulta se ejecutó correctamente

			// Almacena los datos obtenidos de la consulta en la variable $datos
			while ($fila = $sta->fetch()) {
				$this->datos[] = $fila;
			}

		} else {
			// La consulta falló, muestra un mensaje de error
			echo "  <p>Error en la consulta<p>\n";
		}
	}

	// Método para cerrar la conexión con la base de datos
	public function Cerrar() {
		$this->con = null; // Cierra la conexión
	}
}
?>