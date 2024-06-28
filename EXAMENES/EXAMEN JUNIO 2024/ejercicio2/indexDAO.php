<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Alta de Alumnos</title>
</head>

<?php
// Incluir el archivo que contiene la clase DaoAlumno y la configuración de conexión
require_once 'DaoAlumno.php';

// Crear una instancia de DaoAlumno con la base de datos 'junio'
$daoAlumno = new DaoAlumno('junio');

// Función para verificar si un alumno ya existe en un archivo
function alumnoExiste($nif, $archivo) {
    if (file_exists($archivo)) {
        $file = fopen($archivo, 'r');
        while (($line = fgets($file)) !== false) {
            list($existingNif) = explode(" ", trim($line));
            if ($existingNif == $nif) {
                fclose($file);
                return true;
            }
        }
        fclose($file);
    }
    return false;
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nif = $_POST['nif'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $premios = $_POST['premios'];
    $telefono = $_POST['telefono'];
    $opcion = $_POST['opcion'];

    // Si se hace clic en "Guardar"
    if (isset($_POST['guardar'])) {
        if ($opcion == 'archivo') {
            $archivo = 'Alumnos.txt';
            // Verificar si el alumno ya existe en el archivo
            if (alumnoExiste($nif, $archivo)) {
                echo "El DNI ya existe en el archivo.";
            } else {
                // Si no existe, agregar al archivo
                $file = fopen($archivo, 'a');
                fwrite($file, "$nif $nombre $apellido1 $apellido2 $premios $telefono\n");
                fclose($file);
                echo "Alumno guardado en el archivo.";
            }
        } elseif ($opcion === 'bbdd') {
            // Crear objeto Alumno con los datos recibidos
            $alumno = new Alumno($nif, $nombre, $apellido1, $apellido2, $premios, $telefono);

            // Verificar si el alumno ya existe en la base de datos
            $existe = $daoAlumno->obtener($nif);
            if ($existe) {
                echo "El NIF $nif ya existe en la base de datos.";
            } else {
                // Si no existe, insertar el alumno en la base de datos
                $daoAlumno->insertar($alumno);
                echo "Alumno guardado correctamente en la base de datos.";
            }
        }
    }

    // Si se hace clic en "Volcar"
    if (isset($_POST['volcar'])) {
        $archivo = 'Alumnos.txt';
        // Verificar si el archivo existe
        if (!file_exists($archivo)) {
            echo "No hay datos en el archivo para volcar.";
        } else {
            $handle = fopen($archivo, 'r');

            while (($line = fgets($handle)) !== false) {
                // Obtener los datos de cada línea del archivo
                $datos = explode(" ", trim($line));
                $nif = $datos[0];
                $nombre = $datos[1];
                $apellido1 = $datos[2];
                $apellido2 = $datos[3];
                $premios = $datos[4];
                $telefono = $datos[5];

                // Crear objeto Alumno con los datos obtenidos
                $alumno = new Alumno($nif, $nombre, $apellido1, $apellido2, $premios, $telefono);

                // Verificar si el alumno ya existe en la base de datos antes de insertarlo
                $existe = $daoAlumno->obtener($nif);
                if (!$existe) {
                    // Insertar el alumno en la base de datos
                    $daoAlumno->insertar($alumno);
                }
            }

            fclose($handle);
            echo "Datos volcados correctamente a la base de datos desde el archivo.";
        }
    }
}
?>

<body>
    <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
        <fieldset>
            <legend>Formulario de Alta de Alumnos</legend>
            <label for="nif">DNI:</label>
            <input type="text" id="nif" name="nif"><br><br>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre"><br><br>

            <label for="apellido1">Primer Apellido:</label>
            <input type="text" id="apellido1" name="apellido1"><br><br>
            <label for="apellido2">Segundo Apellido:</label>
            <input type="text" id="apellido2" name="apellido2"><br><br>

            <label for="premios">Premios:</label>
            <input type="text" id="premios" name="premios"><br><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono"><br><br>

            <label for="opcion">Guardar en:</label><br>
            <input type="radio" id="archivo" name="opcion" value="archivo" checked>
            <label for="archivo">Archivo</label><br>
            <input type="radio" id="bbdd" name="opcion" value="bbdd">
            <label for="bbdd">BBDD</label><br>
        </fieldset>
        <br>
        <button type="submit" name="guardar">Guardar</button>
        <button type="submit" name="volcar">Volcar</button>
    </form>
</body>

</html>
