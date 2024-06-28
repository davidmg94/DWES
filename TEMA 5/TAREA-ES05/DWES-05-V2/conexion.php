<!-- Opciones de la conexión -->

<?php
// Incluye el archivo que contiene la definición de la clase PDODB
require 'LibreriaPDO.php';

// Crea una instancia de la clase PDODB para manejar la conexión a la base de datos
$db = new PDODB("localhost", "root", "", "tarea5");
