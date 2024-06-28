<!-- Opciones de la conexión -->

<?php

// Variable para codificar en UTF-8 para evitar problemas con los acentos
$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

// Constantes de la base de datos

// Constantes con usuario genérico
define("HOST_DB", "localhost");
define("NAME_DB", "tarea4");
define("USER_DB", "root");
define("PASS_DB", "");
define("DSN", "mysql:host=" . HOST_DB . ";dbname=" . NAME_DB);

// Conexión a la base de datos
try {
    // Crea una instancia de la clase PDO para establecer la conexión
    $conexion = new PDO(
        DSN,
        USER_DB,
        PASS_DB,
        $opciones
    );
} catch (PDOException $e) {
    // Captura y muestra un mensaje de error en caso de falla en la conexión
    die("Error en la conexión: " . $e->getMessage());
}
function cerrar(&$con) {
    try {
        // Cerrar la conexión a la base de datos
        $con = null;
    } catch (PDOException $e) {
        // Manejar la excepción si ocurre algún error al cerrar la conexión
        echo "Error al cerrar la conexión: " . $e->getMessage();
    }
}

function cerrarTodo(&$con, &$st) {
    try {
        // Cerrar la declaración preparada
        $st = null;
        // Cerrar la conexión a la base de datos
        $con = null;
    } catch (PDOException $e) {
        // Manejar la excepción si ocurre algún error al cerrar la conexión o la declaración
        echo "Error al cerrar la conexión o la declaración: " . $e->getMessage();
    }
}
