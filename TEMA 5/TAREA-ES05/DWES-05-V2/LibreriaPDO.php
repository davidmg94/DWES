<?php

// Definición de la clase PDODB para manejo de base de datos con PDO
class PDODB {
    // Propiedades para la conexión a la base de datos
    private $host;
    private $usuario;
    private $pass;
    private $db;

    // Conexión a la base de datos
    private $connection;

    // Constructor que inicializa los datos de conexión
    function __construct($host, $usuario, $pass, $db) {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->pass = $pass;
        $this->db = $db;
    }

    // Método para establecer la conexión a la base de datos
    function connect() {
        // Configuración de opciones para la conexión PDO
        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );

        // Creación de la conexión PDO
        $this->connection = new PDO(
            'mysql:host=' . $this->host . ';dbname=' . $this->db,
            $this->usuario,
            $this->pass,
            $opciones
        );
    }

    // Método para obtener datos de la base de datos
    function getData($sql) {
        try {
            // Prepara la consulta SQL
            $stmt = $this->connection->prepare($sql);

            // Ejecuta la consulta preparada
            $stmt->execute();

            // Retorna los resultados
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En caso de error, lanza una excepción
            throw new Exception($e->getMessage());
        }
    }

    // Método para obtener el número de filas afectadas por una consulta
    function numRows($sql) {
        try {
            // Prepara la consulta SQL
            $stmt = $this->connection->prepare($sql);

            // Ejecuta la consulta preparada
            $stmt->execute();

            // Retorna el número de filas afectadas
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // En caso de error, lanza una excepción
            throw new Exception($e->getMessage());
        }
    }

    // Método para obtener un solo registro de la base de datos
    function getDataSingle($sql,$params = []) {
        try {
            // Prepara la consulta SQL
            $stmt = $this->connection->prepare($sql);

            // Ejecuta la consulta preparada
            $stmt->execute($params);

            // Retorna el primer resultado
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // En caso de error, lanza una excepción
            throw new Exception($e->getMessage());
        }
    }


    // Método para obtener un solo valor de una propiedad de un registro de la base de datos
    function getDataSingleProp($sql, $prop) {
        try {
            // Prepara la consulta SQL
            $stmt = $this->connection->prepare($sql);

            // Ejecuta la consulta preparada
            $stmt->execute();

            // Retorna el valor de la propiedad especificada del primer resultado
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data[$prop];
        } catch (PDOException $e) {
            // En caso de error, lanza una excepción
            throw new Exception($e->getMessage());
        }
    }

    // Método para ejecutar una instrucción SQL que no devuelve resultados
    function executeInstruction($sql, $params = []) {
        try {
            // Prepara la consulta SQL
            $stmt = $this->connection->prepare($sql);

            // Si hay parámetros, los vincula a la consulta preparada
            if (!empty ($params)) {
                $stmt->execute($params);
            } else {
                $stmt->execute();
            }

            // Verifica si la consulta comienza con "select" (SELECT)
            if (strpos(strtolower($sql), 'select') === 0) {
                // Si es una consulta de selección (SELECT), retorna los resultados
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Para otras consultas (INSERT, UPDATE, DELETE), retorna el número de filas afectadas
                return $stmt->rowCount();
            }
        } catch (PDOException $e) {
            // En caso de que se produzca una excepción de PDO (error de conexión o consulta)
            // Imprime información sobre el error
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
            // Retorna false para indicar que ocurrió un error durante la ejecución de la consulta
            return false;
        }
    }


    // Método para cerrar la conexión a la base de datos
    function close() {
        $this->connection = null;
    }

    // Método para obtener el último ID insertado en la base de datos
    function getLastId() {
        return $this->connection->lastInsertId();
    }
}
