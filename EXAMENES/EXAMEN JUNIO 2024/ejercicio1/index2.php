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
session_start();
require_once 'DaoAlumno.php';

$bbdd = 'junio';
$dao = new DaoAlumno($bbdd);
$nifsAlumnos = $dao->obtenerNifs();

$alumnos = $dao->listar();

if (isset($_POST['primer'])) {
    $alumnoActual = $dao->obtenerPrimerAlumno();
    $_SESSION['index'] = 0;

} else
    if (isset($_POST['ultimo'])) {
        $alumnoActual = $dao->obtenerUltimoAlumno();
        $_SESSION['index'] = count($alumnos) - 1;

    } else
        if (isset($_POST['siguiente'])) {
            $alumnoActual = $dao->obtener($nifsAlumnos[$_SESSION['index']]);
            $_SESSION['index']++;
            if ($_SESSION['index']>=count($alumnos)) {
                $_SESSION['index']=count($alumnos)-1;
            }

        } else
            if (isset($_POST['anterior'])) {
                $alumnoActual = $dao->obtener($nifsAlumnos[$_SESSION['index']]);
                $_SESSION['index']--;
                if ($_SESSION['index']<0) {
                    $_SESSION['index']=0;
                }
            } else {
                $_SESSION['index'] = 0;

            }

if (isset($_POST['cerrar'])) {
    session_destroy();
}

if (isset($_POST['borrar'])) {
    $nif = $_POST['nif'];
    $dao->eliminar($nif);
    $_SESSION['index']++;

}else if (isset($_POST['actualizar'])) {

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

$alumnoActual = $dao->obtener($nifsAlumnos[$_SESSION['index']]);
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
        <br>
        <input type="submit" value="<<" name="primer"><a href="?nif=<?php echo $alumnoActual->nif; ?>"></a>
        <input type="submit" value="<" name="anterior"><a href="?nif=<?php echo $alumnoActual->nif; ?>"></a>
        <input type="submit" value=">" name="siguiente"><a href="?nif=<?php echo $alumnoActual->nif; ?>"></a>
        <input type="submit" value=">>" name="ultimo"><a href="?nif=<?php echo $alumnoActual->nif; ?>"></a>
        <input type="submit" value="cerrar sesion" name="cerrar">

    </form>
</body>

</html>