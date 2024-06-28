<?php
// Incluir el archivo que contiene la clase para manejar la base de datos
require_once "LibreriaPDO.php";
require_once "DaoAlumno.php";

// Verificar si se ha enviado el parámetro 'nombre' mediante POST
if (isset($_POST['criterio'])) {
    // Obtener el valor del parámetro 'nombre'
    $criterio = $_POST['criterio'];

    // Crear una instancia de la clase DB y conectar a la base de datos 'tarea6'
    $dbname = "mayo";
    $dao = new DaoAlumno($dbname);
    $alumnos = $dao->buscar($criterio);
    // Mostrar resultados en una tabla HTML
    if (!empty($alumnos)) {

        ?>
        <!-- Si se encontraron resultados, mostrar una tabla con los datos -->
        <table class="table table-striped table-bordered table-dark text-center">
        <thead>
                <tr class='table-dark'>
                    <th scope='col'></th>
                    <th scope='col'>DNI</th>
                    <th scope='col'>NOMBRE</th>
                    <th scope='col'>PRIMER APELLIDO</th>
                    <th scope='col'>SEGUNDO APELLIDO</th>
                    <th scope='col'>EDAD</th>
                    <th scope='col'>TELEFONO</th>
                </tr>
            </thead>
            <?php
            // Iterar sobre cada fila de resultados y mostrar los datos en la tabla
            foreach ($alumnos as $alumno) {
                echo "<tr>
                        <td><input class='form-check-input' type='checkbox' name='Dnis[]' value='{$alumno->dni}' /></td>
                        <td>" . $alumno->dni . "</td>
                        <td>" . $alumno->nombre . "</td>
                        <td>" . $alumno->apellido1 . "</td>
                        <td>" . $alumno->apellido2 . "</td>
                        <td>" . $alumno->edad . "</td>
                        <td>" . $alumno->telefono . "</td>
                    </tr>";
            }
            // Cerrar la tabla
            echo '</table>';
        } else {
        // Si no se encontraron resultados, mostrar un mensaje indicando esto
        echo "<p>No se encontraron resultados.</p>";
    }
}
?>