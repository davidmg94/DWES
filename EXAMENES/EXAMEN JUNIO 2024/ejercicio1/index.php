<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>examen junio</title>
    <style>
        a {
            margin-right: 10px;
        }
    </style>
</head>
<?php
require_once 'DaoAlumno.php';

$bbdd = 'junio';
$dao = new DaoAlumno($bbdd);

if (isset($_POST['borrar'])) {
    $nif = $_POST['nif'];
    $dao->eliminar($nif);
}

if (isset($_POST['actualizar'])) {

    if (!isset($_POST['nif'])) {
        echo "NIF invalido";
    } else {
        $nif = $_POST['nif'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $premios = $_POST['premios'];
        $telefono = $_POST['telefono'];
        $alumno = new Alumno($nif, $nombre, $apellido1, $apellido2, $premios, $telefono);
        $dao->actualizar($alumno);
    }
}

$alumnos = $dao->listar();

$id = isset($_GET['nif']) ? intval($_GET['nif']) : 0;
if ($id < 0) {
    $id = 0;
}

if ($id >= count($alumnos)) {
    $id = count($alumnos) - 1;
}

$alumnoActual = $alumnos[$id];
?>

<body>
    <form method='post'>
        <fieldset>
            <legend>Datos del alumno</legend>
            NIF: <input type="text" name="nif" value="<?php echo $alumnoActual->nif; ?>" readonly><br>
            Nombre: <input type="text" name="nombre" value="<?php echo $alumnoActual->nombre; ?>"><br>
            Apellido1: <input type="text" name="apellido1" value="<?php echo $alumnoActual->apellido1; ?>"><br>
            Apellido2: <input type="text" name="apellido2" value="<?php echo $alumnoActual->apellido2; ?>"><br>
            Premios: <input type="text" name="premios" value="<?php echo $alumnoActual->premios; ?>"><br>
            Teléfono: <input type="text" name="telefono" value="<?php echo $alumnoActual->telefono; ?>"><br><br>
            <input type="submit" name="borrar" value="Borrar">
            <input type="submit" name="actualizar" value="Actualizar">
        </fieldset>
    </form>
    <a href="?nif=<?php echo $id - count($alumnos); ?>" name="primer"><< </a>
    <a href="?nif=<?php echo $id - 1; ?>"> < </a>
    <a href="?nif=<?php echo $id + 1; ?>">> </a>
    <a href="?nif=<?php echo $id + count($alumnos); ?>" name="ultimo">>> </a>
</body>

</html>