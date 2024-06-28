<?php
require_once 'DaoAlumno.php';

$daoAlumno = new DaoAlumno('junio');
$alumno = $daoAlumno->obtenerPrimerAlumno();

$nifActual = $_GET['nif'] ?? $alumno->__get('nif');

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'first':
            $alumno = $daoAlumno->obtenerPrimerAlumno();
            break;
        case 'previous':
            $alumno = $daoAlumno->obtenerAnterior($nifActual);
            if (!$alumno) {

                $alumno = $daoAlumno->obtenerPrimerAlumno();
            }

            break;
        case 'next':
            $alumno = $daoAlumno->obtenerSiguiente($nifActual);
            if (!$alumno) {

                $alumno = $daoAlumno->obtenerUltimoAlumno();
            }
            break;
        case 'last':
            $alumno = $daoAlumno->obtenerUltimoAlumno();
            break;
    }
} 
if (isset($_POST['delete'])) {
    $nifActual = $_POST['nif'];
    $daoAlumno->eliminar($nifActual);
    $alumno = $daoAlumno->obtenerPrimerAlumno(); 
} elseif (isset($_POST['update'])) {
    $nifActual = $_POST['nif'];
    $alumnoActualizado = new Alumno(
        $nifActual,
        $_POST['nombre'],
        $_POST['apellido1'],
        $_POST['apellido2'],
        $_POST['premios'],
        $_POST['telefono']
    );
    $daoAlumno->actualizar($alumnoActualizado);
    $alumno = $daoAlumno->obtener($nifActual);
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Alumnos</title>
    <style>
        a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <form method='POST'>
        <fieldset>
            <legend>Datos del alumno</legend>
            <label>NIF: </label>
            <input type="text" name="nif" value="<?php echo $alumno->__get('nif'); ?>" readonly><br>
            <label>Nombre: </label>
            <input type="text" name="nombre" value="<?php echo $alumno->__get('nombre'); ?>"><br>
            <label>Apellido 1: </label>
            <input type="text" name="apellido1" value="<?php echo $alumno->__get('apellido1'); ?>"><br>
            <label>Apellido 2: </label>
            <input type="text" name="apellido2" value="<?php echo $alumno->__get('apellido2'); ?>"><br>
            <label>Premios: </label>
            <input type="text" name="premios" value="<?php echo $alumno->__get('premios'); ?>"><br>
            <label>Teléfono: </label>
            <input type="text" name="telefono" value="<?php echo $alumno->__get('telefono'); ?>"><br>
        </fieldset>
        <a href="?action=first">
            << </a>
                <a href="?action=previous&nif=<?php echo $alumno->__get('nif'); ?>">
                    < </a>
                        <a href="?action=next&nif=<?php echo $alumno->__get('nif'); ?>">></a>
                        <a href="?action=last&nif=<?php echo $alumno->__get('nif'); ?>">>></a><br>
                        <br>
                        <button type="submit" name="delete">Borrar</button>
                        <button type="submit" name="update">Actualizar</button>
    </form>
</body>

</html>