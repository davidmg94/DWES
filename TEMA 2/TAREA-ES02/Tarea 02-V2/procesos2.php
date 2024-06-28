<?php
    $dni = $_POST['dni'] ? strtoupper($_POST['dni']) : '';
    $nombre = $_POST['nombre'] ? strtoupper($_POST['nombre']) : '';
    $apellido1 = $_POST['apellido1'] ? strtoupper($_POST['apellido1']) : '';
    $apellido2 = $_POST['apellido2'] ? strtoupper($_POST['apellido2']) : '';
    $telefono = $_POST['telefono'];
    $file = 'Alumnos.txt';

    if (isset($_POST['guardar'])) {
        if (empty($dni) || !preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
            $error_message = empty($dni) ? "*El campo DNI no puede estar vacío." : "*DNI no válido. Debe contener 8 números seguidos de una letra.";
            header("Location: index2.php?error_message=" . urlencode($error_message));
            exit();
        }
        
        if (empty($nombre) || empty($apellido1) || !preg_match("/^[A-Z][A-Z-]*$/", $nombre)
            || !preg_match("/^[A-Z][A-Z-]*$/", $apellido1) || !preg_match("/^[A-Z][A-Z-]*$/", $apellido2)) {
            $error_message = empty($nombre) ? "*El campo Nombre no puede estar vacío." : (empty($apellido1) ? "*El campo Apellido1 no puede estar vacío." : "*Los nombres y apellidos no pueden contener números ni caracteres especiales, excepto guiones.");
            header("Location: index2.php?error_message=" . urlencode($error_message));
            exit();
        }

        if (empty($telefono) || !preg_match("/^[0-9]{9}$/", $telefono)) {
            $error_message = empty($telefono) ? "*El campo Teléfono no puede estar vacío." : "*Teléfono no válido. Debe contener 9 números.";
            header("Location: index2.php?error_message=" . urlencode($error_message));
            exit();
        }

        if (!file_exists($file)) {
            $handle = fopen($file, 'w') or die('Cannot open file: ' . $file);
        }

        $lines = file($file);
        foreach ($lines as $line) {
            $parts = explode(' ', trim($line));
            if ($parts[0] === $dni) {
                $error_message = "*ERROR. El DNI introducido ya existe.";
                header("Location: index2.php?error_message=" . urlencode($error_message));
                exit();
            }
        }

        $current = file_get_contents($file);
        $current .= "$dni $nombre $apellido1 $apellido2 $telefono\n";
        file_put_contents($file, $current);
        $success_message = "*Registro guardado en el archivo.";
        header("Location: index2.php?success_message=" . urlencode($success_message));
        exit();
    } elseif (isset($_POST['mostrar'])) {
        header("Location: mostrar2.php");
        exit();
    } elseif (isset($_POST['borrar'])) {
        if (!file_exists($file) || filesize($file) == 0) {
            $info_message = "*El archivo está vacío o no existe.";
            header("Location: index2.php?info_message=" . urlencode($info_message));
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
                $error_message = "*ERROR. El DNI introducido no existe.";
                header("Location: index2.php?error_message=" . urlencode($error_message));
                exit();
            }
            file_put_contents($file, $out);
            $info_message = "*Registro borrado.";
            header("Location: index2.php?info_message=" . urlencode($info_message));
            exit();
        }
        $error_message = "*ERROR. Introduzca un DNI para borrar un registro.";
        header("Location: index2.php?error_message=" . urlencode($error_message));
        exit();
    } elseif (isset($_POST['vaciar'])) {
        if (!file_exists($file) || filesize($file) == 0) {
            $info_message = "*El archivo está vacío o no existe.";
            header("Location: index2.php?info_message=" . urlencode($info_message));
            exit();
        }
        file_put_contents($file, "");
        $success_message = "Archivo borrado correctamente.";
        header("Location: index2.php?success_message=" . urlencode($success_message));
        exit();
    }

?>
