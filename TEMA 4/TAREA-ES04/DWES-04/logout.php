<?php
// Inicia la sesión
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual
session_destroy();

// Redirecciona al usuario a la página de inicio de sesión (login.php)
header("location: login.php");
exit; // Termina el script para evitar ejecución adicional
