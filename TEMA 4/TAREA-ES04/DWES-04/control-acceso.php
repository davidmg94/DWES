<?php
// Se incluye el archivo de conexión a la base de datos
require_once ("conexion.php");

// Definición de constantes
define("MAX_INTENTOS", 5); // Máximo de intentos fallidos permitidos
define("INTERVALO_PARA_BLOQUEO", 3 * 60); // Tiempo máximo (en segundos) que se permite entre fallos de inicio de sesión antes de bloquear al usuario.
define("DURACION_BLOQUEO", 10 * 60); // Duración del bloqueo en segundos

// Tiempo total de bloqueo en segundos                                      
// se suman la duracion del bloqueo y el intervalo de bloqueo
// y el intervalo para el bloqueo para asegurarnos de que el usuario estara bloqueado
define("TIEMPO_BLOQUEO_TOTAL", DURACION_BLOQUEO + INTERVALO_PARA_BLOQUEO);
//el tiempo especificado a partir del ultimo fallo de registro

// Función para verificar si un usuario está bloqueado
function estaBloqueado($usuario, $conexion) {
    // Verifica si el usuario ha alcanzado el límite de intentos fallidos 
    if (verificarIntentosFallidos($usuario, $conexion)) {
        return true;
    }

    // Verifica si el usuario ha sido bloqueado por tiempo
    if (verificarTiempoBloqueo($usuario, $conexion)) {
        return true;
    }

    return false;
}


// Función para verificar si el usuario ha alcanzado el límite de intentos fallidos en un tiempo especifico
function verificarIntentosFallidos($usuario, $conexion) {
    $hora = time(); // Obtiene la hora actual

    // Consulta para obtener los últimos registros de intentos fallidos del usuario
    $stmt = $conexion->prepare("SELECT Hora FROM login WHERE Usuario = ? AND Acceso = 'D' ORDER BY Hora DESC LIMIT " . MAX_INTENTOS);
    $stmt->execute(array($usuario));
    $intentosFallidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si hay por lo menos el número de intentos fallidos permitidos
    // y el tiempo transcurrido desde el primer intento es menor que el tiempo para bloqueo, el usuario está bloqueado    
    return count($intentosFallidos) >= MAX_INTENTOS && ($hora - $intentosFallidos[MAX_INTENTOS - 1]['Hora']) < INTERVALO_PARA_BLOQUEO;
}

// Función para bloquear al usuario si supera el limite de intentos fallidos por un tiempo determinado
function verificarTiempoBloqueo($usuario, $conexion) {
    $hora = time(); // Obtiene la hora actual

    // Consulta para obtener los registros de intentos fallidos del usuario desde la hora actual menos el tiempo de bloqueo
    $stmt = $conexion->prepare("SELECT Hora FROM login WHERE Usuario = ? AND Acceso = 'D' AND ($hora - Hora) <=" . TIEMPO_BLOQUEO_TOTAL . " ORDER BY Hora ASC LIMIT " . MAX_INTENTOS);
    $stmt->execute(array($usuario));
    $intentosFallidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si el tiempo transcurrido desde el ultimo intento fallido es menor que el tiempo de bloqueo, el usuario está bloqueado
    return count($intentosFallidos) >= MAX_INTENTOS && ($hora - $intentosFallidos[0]['Hora']) < DURACION_BLOQUEO;
}

// Función para registrar un intento de inicio de sesión en la base de datos
function registrarIntentoLogin($usuario, $clave, $hora, $acceso, $conexion) {
    $stmt = $conexion->prepare("INSERT INTO login VALUES (?, ?, ?, ?)");
    $stmt->execute(array($usuario, $clave, $hora, $acceso));
}

// Función para verificar si un usuario existe en la base de datos
function usuarioExistente($usuario, $conexion) {
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute(array($usuario));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

// Funcion para verificar si el usuario y la contraseña son válidos
function validarCredenciales($usuario, $clave, $conexion) {
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?");
    $stmt->execute(array($usuario, $clave));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si se encontraron resultados, el usuario y la contraseña son válidos
    if ($result) {
        return true;
    } else {
        // Si el usuario está registrado pero la contraseña es incorrecta
        if (usuarioExistente($usuario, $conexion)) {
            $_SESSION['mensajeError'] = "Contraseña incorrecta.";
            return false;
        } else {
            // Si el usuario no está registrado
            $_SESSION['mensajeError'] = "Usuario no registrado.";
            return false;
        }
    }
}
function intentosFallidos($usuario, $conexion) {
    $stmt = $conexion->prepare("SELECT Usuario, Hora FROM login WHERE Usuario = ? AND Acceso = 'D' ORDER BY Hora DESC");
    $stmt->execute(array($usuario));
    $intentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $intentos;
}