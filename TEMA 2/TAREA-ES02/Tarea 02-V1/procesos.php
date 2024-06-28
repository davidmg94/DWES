<?php
// Inicia la sesión PHP
session_start();

    // Obtiene y valida los datos del formulario
    $dni = $_POST['dni'] ? strtoupper($_POST['dni']) : '';
    $nombre = $_POST['nombre'] ? strtoupper($_POST['nombre']) : '';
    $apellido1 = $_POST['apellido1'] ? strtoupper($_POST['apellido1']) : '';
    $apellido2 = $_POST['apellido2'] ? strtoupper($_POST['apellido2']) : '';
    $telefono = $_POST['telefono'];
    
    $file = 'Alumnos.txt';

    // Comprueba qué botón del formulario se presionó
    if (isset($_POST['guardar'])) {

        // Validaciones de los datos ingresados
        if (empty($dni) || !preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
            if (empty($dni)) {
                $_SESSION['error_message'] = "*El campo DNI no puede estar vacío.";
            } else {
                $_SESSION['error_message'] = "*DNI no válido. Debe contener 8 números seguidos de una letra.";
            }
            header("Location: index.php");
            exit();
        }
        
        // Apellido2 puede estar vacio pues en algunas culturas solo se tiene un apellido
        if (
            empty($nombre) || empty($apellido1) || !preg_match("/^[A-Z][A-Z-]*$/", $nombre)
            || !preg_match("/^[A-Z][A-Z-]*$/", $apellido1) || !preg_match("/^[A-Z][A-Z-]*$/", $apellido2)
        ) {
            if (empty($nombre)) {
                $_SESSION['error_message'] = "*El campo Nombre no puede estar vacío.";
            } else if (empty($apellido1)) {
                $_SESSION['error_message'] = "*El campo Apellido1 no puede estar vacío.";
            } else {
                $_SESSION['error_message'] = "*Los nombres y apellidos no pueden contener números ni caracteres especiales, excepto guiones.";
            }
            header("Location: index.php");
            exit();
        }

        if (empty($telefono) || !preg_match("/^[0-9]{9}$/", $telefono)) {
            if (empty($nombre)) {
                $_SESSION['error_message'] = "*El campo Telefono no puede estar vacío.";
            } else {
                $_SESSION['error_message'] = "*Teléfono no válido. Debe contener 9 números.";
            }
            header("Location: index.php");
            exit();
        }

        // Verifica si el DNI ya existe en el archivo
        // $file = 'Alumnos.txt';
        if (!file_exists($file)) {
            // Si el archivo no existe, crea un nuevo archivo
            $handle = fopen($file, 'w') or die('Cannot open file: ' . $file);
        }
        // Comprobar si ya existe el dni introducido
        $lines = file($file);  // Se guardan las lineas del archivo en un array
        foreach ($lines as $line) {

            $parts = explode(' ', trim($line));  // Separa los elementos de cada linea del archivo tomando un espacio como referencia

            if ($parts[0] === $dni) {
                $_SESSION['error_message'] = "*ERROR. El DNI introducido ya existe.";
                header("Location: index.php");
                exit();
            }
        }

        // Añade el nuevo registro al archivo
        $current = file_get_contents($file);    // Se almacena el contenido del archivo en una variable
        $current .= "$dni $nombre $apellido1 $apellido2 $telefono\n";   // Se añaden los datos del formulario a la variable
        file_put_contents($file, $current);   // Se vuelca el contenido de la variable en el archivo
        $_SESSION['success_message'] = "*Registro guardado en el archivo.";
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['mostrar'])) {

        // Redirige a la página "mostrar.php"
        header("Location: mostrar.php");
        exit();
    } elseif (isset($_POST['borrar'])) {

        // Borra un registro del archivo según el DNI proporcionado
        // $file = 'Alumnos.txt';
        if (!file_exists($file) || filesize($file) == 0) {
            $_SESSION['info_message'] = "*El archivo está vacío o no existe.";
            header("Location: index.php");
            exit();
        }
        if (!empty($dni)) {

            $lines = file($file);
            $out = array();
            $found = false;
            foreach ($lines as $line) {
                $parts = explode(' ', trim($line));
                if ($parts[0] === $dni) {
                    $found = true;
                } else {
                    $out[] = $line;
                }
            }
            if (!$found) {
                $_SESSION['error_message'] = "*ERROR. El DNI introducido no existe.";
                header("Location: index.php");
                exit();
            }
            file_put_contents($file, $out);
            $_SESSION['info_message'] = "*Registro borrado.";
            header("Location: index.php");
            exit();
        }
        $_SESSION['error_message'] = "*ERROR. Introduzca un DNI para borrar un registro.";
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['vaciar'])) {

        // Vacía completamente el archivo
        // $file = 'Alumnos.txt';
        if (!file_exists($file) || filesize($file) == 0) {
            $_SESSION['info_message'] = "*El archivo está vacío o no existe.";
            header("Location: index.php");
            exit();
        }

        // Vacia el archivo
        file_put_contents($file, "");
        $_SESSION["success_message"] = "Archivo borrado correctamente.";

        // Elimina el archivo del equipo
        // if (unlink($file)) {
        //     $_SESSION["success_message"] = "Archivo borrado correctamente.";
        // } else {
        //     $_SESSION["error_message"] = "Error al intentar borrar el archivo.";
        // }

        header("Location: index.php");
        exit();
    }

