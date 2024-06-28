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
    // Inicia la sesión PHP
    session_start();

    // Verifica si hay un mensaje de error en la sesión y lo muestra en rojo
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        // Elimina el mensaje de error de la sesión para evitar repeticiones
        unset($_SESSION['error_message']);
    }
    // Verifica si hay un mensaje de éxito en la sesión y lo muestra
    elseif (isset($_SESSION['success_message'])) {
        echo '<p style="color:green;">' . $_SESSION['success_message'] . '</p>';
        // Elimina el mensaje de éxito de la sesión
        unset($_SESSION['success_message']);
    }
    // Verifica si hay un mensaje de información en la sesión y lo muestra
    elseif (isset($_SESSION['info_message'])) {
        echo '<p>' . $_SESSION['info_message'] . '</p>';
        // Elimina el mensaje de información de la sesión
        unset($_SESSION['info_message']);
    }
    ?>
    <!-- Formulario que se enviará al archivo "procesos.php" mediante el método POST -->
    <form method="POST" action="procesos.php">
        <fieldset>
            <legend>Introduzca un registro en la Agenda</legend>
            <!-- Campo para introducir el DNI -->
            <label for="dni">DNI </label>
            <input type="text" name="dni" id="dni"><br><br>

            <!-- Campo para introducir el nombre -->
            <label for="nombre">Nombre </label>
            <input type="text" name="nombre" id="nombre"><br><br>

            <!-- Campo para introducir el primer apellido -->
            <label for="apellido1">Apellido1 </label>
            <input type="text" name="apellido1" id="apellido1"><br><br>

            <!-- Campo para introducir el segundo apellido -->
            <label for="apellido2">Apellido2 </label>
            <input type="text" name="apellido2" id="apellido2"><br><br>

            <!-- Campo para introducir el número de teléfono -->
            <label for="telefono">Teléfono </label>
            <input type="text" name="telefono" id="telefono"><br><br>

            <!-- Grupo de botones del formulario -->
            <div class="botones">
                <input type="submit" name="guardar" value="Guardar">
                <input type="submit" name="mostrar" value="Mostrar">
                <input type="submit" name="borrar" value="Borrar" onclick="return borrarRegistro()">
                <input type="submit" name="vaciar" value="Vaciar Archivo" onclick="return vaciarArchivo()">
            </div>
        </fieldset>
    </form>
    <script>
        // Función para mostrar un cuadro de diálogo de confirmación
        function vaciarArchivo() {
            return confirm("¿Estás seguro de que quieres vaciar el archivo?");
        }
        function borrarRegistro() {
            return confirm("¿Estás seguro de que quieres borrar este registro?");
        }
    </script>
</body>

</html>
