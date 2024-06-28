<?php

// Incluir la clase DaoAlumno
require_once 'DaoAlumno.php';

// Conectar a la base de datos
$bbdd = 'mayo'; // Reemplaza con el nombre de tu base de datos
$daoAlumno = new DaoAlumno($bbdd);

// Obtener el ID del alumno actual a mostrar desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener la lista de todos los alumnos
$alumnos = $daoAlumno->listar();

// Comprobar límites para evitar índices fuera de rango
if ($id < 0)
    $id = 0; // No permitir un ID negativo
if ($id >= count($alumnos))
    $id = count($alumnos) - 1; // No permitir un ID mayor al número de alumnos
$alumnoActual = $alumnos[$id]; // Obtener el alumno actual

// Mostrar los datos del alumno en el formulario
?>
<!DOCTYPE html>
<html>

<head>
    <title>Alumno</title>
</head>

<body>
    <form>
        <fieldset>
            <legend>Datos del alumno</legend>
            <!-- Mostrar los datos del alumno en campos de formulario -->
            DNI: <input type="text" name="dni" value="<?php echo $alumnoActual->dni; ?>"><br>
            Nombre: <input type="text" name="nombre" value="<?php echo $alumnoActual->nombre; ?>"><br>
            Apellido1: <input type="text" name="apellido1" value="<?php echo $alumnoActual->apellido1; ?>"><br>
            Apellido2: <input type="text" name="apellido2" value="<?php echo $alumnoActual->apellido2; ?>"><br>
            Edad: <input type="text" name="edad" value="<?php echo $alumnoActual->edad; ?>"><br>
            Teléfono: <input type="text" name="telefono" value="<?php echo $alumnoActual->telefono; ?>"><br>
        </fieldset>
    </form>
    <!-- Enlaces para navegar al alumno anterior y siguiente -->
    <a href="?id=<?php echo $id - 1; ?>"><<</a>
    <a href="?id=<?php echo $id + 1; ?>">>></a>
</body>

</html>