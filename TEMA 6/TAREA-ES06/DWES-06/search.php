<?php
// Incluir el archivo que contiene la clase para manejar la base de datos
require_once 'LibreriaPDO.php';

// Verificar si se ha enviado el parámetro 'nombre' mediante POST
if (isset($_POST['nombre'])) {
    // Obtener el valor del parámetro 'nombre'
    $nombre = $_POST['nombre'];

    // Crear una instancia de la clase DB y conectar a la base de datos 'tarea6'
    $dbname = "tarea6";
    $db = new DB($dbname);
    // Definir la consulta SQL para buscar alumnos cuyo nombre empiece con el valor proporcionado
    $consulta = "SELECT * FROM alumnos WHERE Nombre LIKE ?";
    // Definir los parámetros de la consulta (en este caso, el valor del nombre con un comodín % al final)
    $parametros = ["$nombre%"];

    // Ejecutar la consulta con los parámetros proporcionados
    $db->ConsultaDatos($consulta, $parametros);
    $alumnos = $db->filas;
    // Mostrar resultados en una tabla HTML
    if (!empty($alumnos)) {

        ?>
         <!-- Si se encontraron resultados, mostrar una tabla con los datos -->
        <table class='table table-hover table-bordered'>
            <thead>
                <tr class='table-dark'>
                    <th scope='col'>DNI</th>
                    <th scope='col'>NOMBRE</th>
                    <th scope='col'>PRIMER APELLIDO</th>
                    <th scope='col'>SEGUNDO APELLIDO</th>
                </tr>
            </thead>
            <?php
            // Iterar sobre cada fila de resultados y mostrar los datos en la tabla
            foreach ($alumnos as $alumno) {
                echo "<tr>
                        <td>" . strtoupper($alumno["DNI"]) . "</td>
                        <td>" . strtoupper($alumno["Nombre"]) . "</td>
                        <td>" . strtoupper($alumno["Apellido1"]) . "</td>
                        <td>" . strtoupper($alumno["Apellido2"]) . "</td>
                    </tr>";
            }
            // Cerrar la tabla
            echo "</table>";
    } else {
        // Si no se encontraron resultados, mostrar un mensaje indicando esto
        echo "No se encontraron resultados.";
    }
}
?>