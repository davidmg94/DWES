<?php
session_start(); // Inicia la sesión o reanuda la sesión existente

// Verifica si se ha enviado el formulario para insertar un nuevo registro
if (isset($_POST['insertar'])) {
    $dni = $_POST['dni']; // Obtiene el valor del campo DNI enviado por el formulario
    $nombre = $_POST['nombre']; // Obtiene el valor del campo Nombre enviado por el formulario

    // Verifica si el DNI no está ya en la sesión antes de añadirlo
    if (!isset($_SESSION['datos'][$dni])) {
        $_SESSION['datos'][$dni] = $nombre; // Añade el nuevo registro a la sesión
    }
}

// Verifica si se ha enviado el formulario para eliminar todos los datos
if (isset($_POST['eliminar'])) {
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Formulario HTML para insertar, mostrar y eliminar datos -->
    <form method="post">
        <fieldset style="margin-bottom: 5px;">
            <legend>Gestión de alumnos</legend>
            DNI: <input type="text" name="dni"><br> <!-- Campo para ingresar el DNI -->
            Nombre: <input type="text" name="nombre"><br> <!-- Campo para ingresar el Nombre -->
        </fieldset>
        <input type="submit" name="insertar" value="Insertar"> <!-- Botón para insertar un nuevo registro -->
        <input type="submit" name="mostrar" value="Mostrar"> <!-- Botón para mostrar los registros almacenados -->
        <input type="submit" name="eliminar" value="Eliminar"> <!-- Botón para eliminar todos los registros -->
    </form>
    <?php // Verifica si se ha enviado el formulario para mostrar los datos
    if (isset($_POST['mostrar'])) {
        echo '<br><fieldset style="margin-bottom: 5px;" >';
        echo "<legend>Listado de alumnos</legend>";

        echo "<table border='2'>";
        echo "<tr><th>DNI</th><th>Nombre</th></tr>";
        // Itera sobre los datos almacenados en la sesión y los muestra en una tabla
        foreach ($_SESSION['datos'] as $dni => $nombre) {
            echo "<tr><td>$dni</td><td>$nombre</td></tr>";
        }
        echo "</table>";
        echo "</fieldset>";
    } ?>
</body>

</html>