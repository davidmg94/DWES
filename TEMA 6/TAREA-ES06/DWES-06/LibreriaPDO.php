<?php
// Clase que permite acceder a la base de datos
class DB {

    // Definimos propiedades para establecer los parámetros de conexión
    private $host = "localhost";   // Dirección del servidor de base de datos
    private $dbname;               // Nombre de la base de datos
    private $user = "root";        // Nombre de usuario para la base de datos
    private $pass = "";            // Contraseña para la base de datos
    private $db;                   // Propiedad para guardar el objeto PDO

    public $filas = array();       // Propiedad pública para guardar el resultado de las consultas de selección

    // Constructor de la clase, se ejecuta al crear una instancia de DB
    public function __construct($base) {
        $this->dbname = $base;  // Al instanciar el objeto DB, establecemos la base de datos en la que vamos a trabajar
    }

    // Método privado para conectar a la base de datos
    private function Conectar() {
        try {
            // Creamos la conexión usando PDO
            $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            // Establecemos parámetros básicos de configuración
            $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            // Establecemos el juego de caracteres a utf8mb4
            $this->db->exec("set names utf8mb4");

        } catch (PDOException $e) { // Controlamos si se ha producido una excepción
            echo "<p>Error: No puede conectarse con la base de datos.</p>\n\n";
            echo "<p>Error: " . $e->getMessage() . "</p>\n";
        }
    }

    // Método privado para cerrar la conexión a la base de datos
    private function Cerrar() {
        $this->db = NULL;  // Asignamos NULL al objeto PDO para cerrar la conexión
    }

    // Método público para ejecutar consultas simples (INSERT, UPDATE, DELETE)
    public function ConsultaSimple($consulta, $param) {
        // Conectamos a la base de datos
        $this->Conectar();

        // Preparamos la consulta SQL
        $sta = $this->db->prepare($consulta);

        // Ejecutamos la consulta con los parámetros proporcionados
        if (!$sta->execute($param)) {
            echo "Error al ejecutar la consulta";
        }

        // Cerramos la conexión
        $this->Cerrar();
    }

    // Método público para ejecutar consultas que devuelven datos (SELECT)
    public function ConsultaDatos($consulta, $param) {
        // Conectamos a la base de datos
        $this->Conectar();

        // Preparamos la consulta SQL
        $sta = $this->db->prepare($consulta);

        // Ejecutamos la consulta con los parámetros proporcionados
        if (!$sta->execute($param)) {
            echo "Error al ejecutar la consulta";
        } else {
            // Inicializamos el array para borrar posibles filas de consultas anteriores
            $this->filas = array();

            // Recorremos las filas del objeto statement y las guardamos en un array
            foreach ($sta as $fila) {
                $this->filas[] = $fila;
            }
        }

        // Cerramos la conexión
        $this->Cerrar();
    }
}
?>