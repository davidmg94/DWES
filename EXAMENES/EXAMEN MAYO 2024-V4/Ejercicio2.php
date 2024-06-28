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
        // Inicializamos la variable consulta
        $consulta = "";

        // Verificamos si se ha pulsado el botón Buscar
        if (isset($_POST['Buscar'])) {

            // Recuperamos los valores del formulario
            $nombre = $_POST['Nombre'];
            $apellido1 = $_POST['Apellido1'];
            $apellido2 = $_POST['Apellido2'];
            $min = $_POST['Min'];
            $max = $_POST['Max'];

            // Establecemos la consulta por defecto
            $consulta = "select * from Alumnos where 1 ";
            // "where 1" siempre evalúa a TRUE en SQL, lo que lista todas las filas
            // Es lo mismo que no poner un where, pero sirve para que solo tengamos que añadir AND para los campos necesarios
        
            // Para cada campo no vacío lo concatenamos a la consulta principal  
            if ($nombre != '') {
                $consulta .= " AND Nombre='$nombre'";
            }
            if ($apellido1 != '') {
                $consulta .= " AND  Apellido1='$apellido1'";
            }
            if ($apellido2 != '') {
                $consulta .= " AND  Apellido2='$apellido2'";
            }
            if ($min != '') {
                $consulta .= " AND  Edad>=$min";
            }
            if ($max != '') {
                $consulta .= " AND  Edad<=$max";
            }

            // Conectamos a la base de datos
            $db = mysqli_connect("localhost", "root", "", "mayo");

            // Verificamos si la conexión ha sido exitosa
            if (!$db) {
                // Mostramos el error si la conexión falla
                echo ("Error de conexión: " . mysqli_connect_error() . "<br>");
                echo ("Error numero: " . mysqli_connect_errno() . "<br>");
                exit();
            } else {
                // Si la conexión es correcta, ejecutamos la consulta
                $resul = mysqli_query($db, $consulta);

                // Mostramos los resultados en una tabla
                echo "<table border='2'>";
                echo "<th>DNI</th>";
                echo "<th>Nombre</th>";
                echo "<th>Apellido1</th>";
                echo "<th>Apellido2</th>";
                echo "<th>Edad</th>";
                echo "<th>Telefono</th>";

                // Recorremos los resultados y los mostramos en filas
                while (($fila = mysqli_fetch_assoc($resul)) != null) {
                    echo "<tr>";

                    echo "<td>$fila[Dni]</td>";
                    echo "<td>$fila[Nombre]</td>";
                    echo "<td>$fila[Apellido1]</td>";
                    echo "<td>$fila[Apellido2]</td>";
                    echo "<td>$fila[Edad]</td>";
                    echo "<td>$fila[Telefono]</td>";

                    echo "</tr>";
                }
                foreach ($resul as $fila) {
                    echo "<tr>";

                    echo "<td>$fila[Dni]</td>";
                    echo "<td>$fila[Nombre]</td>";
                    echo "<td>$fila[Apellido1]</td>";
                    echo "<td>$fila[Apellido2]</td>";
                    echo "<td>$fila[Edad]</td>";
                    echo "<td>$fila[Telefono]</td>";

                    echo "</tr>";
                }

                // Cerramos la tabla
                echo "</table>";

                // Cerramos la conexión a la base de datos
                mysqli_close($db);
            }
        }
        ?>
    </form>

</body>

</html>