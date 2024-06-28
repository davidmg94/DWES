<?php
$host = 'localhost';
$db = 'junio';
$user = 'root';
$pass = '';

// Función para verificar si un alumno ya existe en el archivo
function alumnoExiste($nif, $archivo) {
    if (file_exists($archivo)) {
        $file = fopen($archivo, 'r');
        while (($line = fgets($file)) !== false) {
            list($existingNif) = explode(" ", trim($line)); // Obtener el NIF existente en cada línea
            if ($existingNif == $nif) {
                fclose($file);
                return true;
            }
        }
        fclose($file);
    }
    return false;
}

// Función para verificar si un alumno ya existe en la base de datos
function alumnoExisteEnBBDD($nif, $pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM alumnos WHERE NIF = ?");
    $stmt->execute([$nif]);
    return $stmt->fetchColumn() > 0;
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        } else if ($opcion == 'bbdd') {
            try {
                // Conectar a la base de datos
                $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Verificar si el alumno ya existe en la base de datos
                if (alumnoExisteEnBBDD($nif, $pdo)) {
                    echo "El DNI ya existe en la base de datos.";
                } else {
                    // Si no existe, insertar en la base de datos
                    $stmt = $pdo->prepare("INSERT INTO alumnos (NIF, Nombre, Apellido1, Apellido2, Premios, Telefono) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$nif, $nombre, $apellido1, $apellido2, $premios, $telefono]);
                    echo "Alumno guardado en la base de datos.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
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
            try {
                // Conectar a la base de datos
                $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Abrir el archivo y leer cada línea
                $file = fopen($archivo, 'r');
                while (($line = fgets($file)) !== false) {
                    // Separar los datos de cada línea por espacios
                    $data = explode(" ", trim($line));
                    $nif = $data[0];
                    $nombre = $data[1];
                    $apellido1 = $data[2];
                    $apellido2 = $data[3];
                    $premios = $data[4];
                    $telefono = $data[5];

                    // Verificar si el alumno ya existe en la base de datos antes de insertar
                    if (!alumnoExisteEnBBDD($nif, $pdo)) {
                        $stmt = $pdo->prepare("INSERT INTO alumnos (NIF, Nombre, Apellido1, Apellido2, Premios, Telefono) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$nif, $nombre, $apellido1, $apellido2, $premios, $telefono]);
                    }
                }
                fclose($file);
                echo "Datos volcados a la base de datos.";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Alta de Alumnos</title>
</head>

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
