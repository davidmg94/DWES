<?php

$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

define("HOST_DB", "localhost");
define("USER_DB", "root");
define("PASS_DB", "");
define("NAME_DB", "proyecto");

try {
    $conexion = new PDO(
        "mysql:host=" . HOST_DB . ";dbname=" . NAME_DB,
        USER_DB,
        PASS_DB,
        $opciones
    );
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br/>";
    exit();
}
