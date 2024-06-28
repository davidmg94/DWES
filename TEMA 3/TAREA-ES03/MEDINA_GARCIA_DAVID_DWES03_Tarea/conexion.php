<!-- Opciones de la conexión -->

<?php

// Variable para codificar en UTF-8 para evitar problemas con los acentos
$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

// Constantes de la base de datos

// Variables con usuario genérico
define("HOST_DB", "localhost");
define("USER_DB", "root");
define("PASS_DB", "");
define("NAME_DB", "proyecto");

// Conexión a la base de datos
try {
    // Crea una instancia de la clase PDO para establecer la conexión
    $conexion = new PDO(
        "mysql:host=" . HOST_DB . ";dbname=" . NAME_DB,
        USER_DB,
        PASS_DB,
        $opciones
    );
} catch (PDOException $e) {
    // Captura y muestra un mensaje de error en caso de falla en la conexión
    echo "Error: " . $e->getMessage() . "<br/>";
    // Sale del script en caso de error
    exit();
}
?>