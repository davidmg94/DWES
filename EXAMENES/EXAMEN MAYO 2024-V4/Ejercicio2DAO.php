<!DOCTYPE html>
<html>
<body>

    <!-- Formulario para buscar alumnos -->
    <form name='f1' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>

        <!-- Sección del formulario -->
        <fieldset>
            <legend>Busqueda del alumno</legend>

            <!-- Campos del formulario para ingresar los criterios de búsqueda -->
            <label for='Nombre'>Nombre </label><input type='text' name='Nombre'>
            <label for='Apellido1'>Apellido1 </label><input type='text' name='Apellido1'>
            <label for='Apellido2'>Apellido2 </label><input type='text' name='Apellido2'><br>
            <label for='Min'>Edad Min </label><input type='text' name='Min' size='3'>
            <label for='Max'>Edad Max </label><input type='text' name='Max' size='3'><br>

            <!-- Botón para enviar el formulario -->
            <input type='submit' name='Buscar' value='Buscar'>

        </fieldset>

        <?php
        // Incluimos el archivo que contiene la clase DaoAlumnos
        require_once 'DaoAlumnos.php';

        // Verificamos si se ha pulsado el botón Buscar
        if (isset($_POST['Buscar'])) {
            // Recuperamos los valores del formulario
            $nombre = $_POST['Nombre'];
            $apellido1 = $_POST['Apellido1'];
            $apellido2 = $_POST['Apellido2'];
            $min = $_POST['Min'];
            $max = $_POST['Max'];

            // Nombre de la base de datos
            $dbname = "mayo";
            // Instanciamos la clase DaoAlumnos
            $dao = new DaoAlumnos($dbname);

            // Llamamos al método buscarAlumnos para obtener los resultados
            $alumnos = $dao->buscarAlumnos($nombre, $apellido1, $apellido2, $min, $max);

            // Mostramos los resultados en una tabla
            echo "<table border='2'>";
            echo "<th>DNI</th>";
            echo "<th>Nombre</th>";
            echo "<th>Apellido1</th>";
            echo "<th>Apellido2</th>";
            echo "<th>Edad</th>";
            echo "<th>Telefono</th>";

            // Recorremos el array de resultados y los mostramos en filas usando foreach
            foreach ($alumnos as $alum) {
                echo "<tr>";
                echo "<td>" . $alum->__get("Dni") . "</td>";
                echo "<td>" . $alum->__get("Nombre") . "</td>";
                echo "<td>" . $alum->__get("Apellido1") . "</td>";
                echo "<td>" . $alum->__get("Apellido2") . "</td>";
                echo "<td>" . $alum->__get("Edad") . "</td>";
                echo "<td>" . $alum->__get("Telefono") . "</td>";
                echo "</tr>";
            }

            // Cerramos la tabla
            echo "</table>";
        }
        ?>

    </form>

</body>
</html>
