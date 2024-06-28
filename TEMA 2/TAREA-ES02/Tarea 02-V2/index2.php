<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tarea 02</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>

    <h1>Tarea 02 - David Medina Garcia</h1>

    <?php
    // Verificar si hay un mensaje de error en la URL y mostrarlo en rojo
    if (isset($_GET['error_message'])) {
        echo '<p style="color: red;">' . htmlspecialchars($_GET['error_message']) . '</p>';
    }
    // Verificar si hay un mensaje de éxito en la URL y mostrarlo en verde
    elseif (isset($_GET['success_message'])) {
        echo '<p style="color:green;">' . htmlspecialchars($_GET['success_message']) . '</p>';
    }
    // Verificar si hay un mensaje de información en la URL y mostrarlo
    elseif (isset($_GET['info_message'])) {
        echo '<p>' . htmlspecialchars($_GET['info_message']) . '</p>';
    }
    ?>

    <form method="POST" action="procesos2.php">
        <fieldset>
            <legend>Introduzca un registro en la Agenda</legend>
            <label for="dni">DNI </label>
            <input type="text" name="dni" id="dni"><br><br>

            <label for="nombre">Nombre </label>
            <input type="text" name="nombre" id="nombre"><br><br>

            <label for="apellido1">Apellido1 </label>
            <input type="text" name="apellido1" id="apellido1"><br><br>

            <label for="apellido2">Apellido2 </label>
            <input type="text" name="apellido2" id="apellido2"><br><br>

            <label for="telefono">Teléfono </label>
            <input type="text" name="telefono" id="telefono"><br><br>

            <div class="botones">
                <input type="submit" name="guardar" value="Guardar">
                <input type="submit" name="mostrar" value="Mostrar">
                <input type="submit" name="borrar" value="Borrar" onclick="borrarRegistro()">
                <input type="submit" name="vaciar" value="Vaciar Archivo" onclick="vaciarArchivo()">
            </div>
        </fieldset>
    </form>

    <script>
        function vaciarArchivo() {
            return confirm("¿Estás seguro de que quieres vaciar el archivo?");
        }
        function borrarRegistro() {
            return confirm("¿Estás seguro de que quieres borrar este registro?");
        }
    </script>
</body>

</html>
