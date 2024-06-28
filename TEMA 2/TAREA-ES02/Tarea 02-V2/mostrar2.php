<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar</title>
    <link rel="stylesheet" href="estilosTabla.css">
</head>

<body>
    <?php
    // Inicia la sesión PHP
    session_start();
    // Define la ruta del archivo
    $file = 'Alumnos.txt';

    // Verifica si el archivo no existe o está vacío
    if (!file_exists($file) || filesize($file) == 0) {
        // Almacena un mensaje de información en la sesión y redirige a "tarea02.php"
        $_SESSION['info_message'] = "*El archivo está vacío o no existe.";
        header("Location: index2.php");
        exit();
    }

    // Lee las líneas del archivo
    $lines = file($file);
    ?>
    <!-- Crea una tabla para mostrar los datos -->
    <table>
        <!-- Agrega una leyenda a la tabla -->
        <caption>Listado Agenda</caption>
        <!-- Crea la primera fila de encabezados -->
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido 1</th>
            <th>Apellido 2</th>
            <th>Telefono</th>
        </tr>
        <?php
        // Itera sobre las líneas del archivo y muestra los datos en la tabla
        foreach ($lines as $line) {
            $parts = explode(' ', $line);
            echo '<tr>';
            // Itera sobre las partes de cada línea y crea celdas en la tabla
            foreach ($parts as $part) {
                echo "<td>$part</td>";
            }
            echo '</tr>';
        }
        ?>
    </table>
    <!-- Agrega un salto de línea y un enlace para volver a "tarea02.php" -->
    <br>
    <div style="text-align:center">
        <a href="index2.php">Volver a Tarea 02</a>
    </div>
</body>

</html>