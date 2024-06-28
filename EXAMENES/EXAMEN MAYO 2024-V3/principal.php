<!DOCTYPE html>
<html lang="es">

<head>
    <title>Examen Mayo</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Inclusión del archivo JavaScript con Ajax -->
    <!-- <script src="ajax.js?v=1"></script> -->
    <script src="ajax2.js?v=1"></script>
    <style>
        fieldset {
            border-radius: 10px;
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>

</head>

<?php
require_once "DaoAlumno.php";

$bbddname = "mayo";
$dao = new DaoAlumno($bbddname);
$alumnosActualizados = [];
$alumnosPreUpdate = [];
$alumnosEliminados = [];
$alumnosRecuperados = [];
$alumnoInsertado = null;
session_start();

if (isset($_POST['actualizar'])) {
    if (isset($_POST['DnisUpdate'])) {
        $Dnis = $_POST['DnisUpdate'];

        $nombres = $_POST['nombres'];
        $apellidos1 = $_POST['apellidos1'];
        $apellidos2 = $_POST['apellidos2'];
        $edades = $_POST['edades'];
        $telefonos = $_POST['telefonos'];

        foreach ($Dnis as $index => $dni) {
            $alumnosPreUpdate[] = $dao->obtener($dni);
            $nombre = $nombres[$index];
            $apellido1 = $apellidos1[$index];
            $apellido2 = $apellidos2[$index];
            $edad = $edades[$index];
            $telefono = $telefonos[$index];
            if (!empty($dni) && !empty($nombre) && !empty($apellido1) && !empty($apellido2)
                && !empty($edad) && !empty($telefono)) {

                $alumno = new Alumno($dni, $nombre, $apellido1, $apellido2,
                    $edad, $telefono);

                $dao->actualizar($alumno);
                $alumnosActualizados[] = $alumno;

            } else {
                $_SESSION['errorUpdate'] = "*Hay <Strong>campos vacios</strong> en el formulario.";
            }
        }

    }
} else if (isset($_POST['eliminarTodos'])) {

    $dao->eliminarTodos();
    echo "<h4>Registros eliminados</h4>";

} else if (isset($_POST['insertarBBDD'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];

    if (!empty($dni) && !empty($nombre) && !empty($apellido1) && !empty($apellido2)
        && !empty($edad) && !empty($telefono)) {

        $alumnoInsertado = new Alumno($dni, $nombre, $apellido1, $apellido2,
            $edad, $telefono);

        $dao->insertar($alumnoInsertado);

    } else {
        $_SESSION['errorFormulario'] = "*Hay <Strong>campos vacios</strong> en el formulario.";
    }
} else if (isset($_POST['volver'])) {
    header('Location: principal.php');

} else if (isset($_POST['recuperar'])) {
    if (isset($_POST['DnisDelete'])) {
        $Dnis = $_POST['DnisDelete'];

        $nombres = $_POST['nombres'];
        $apellidos1 = $_POST['apellidos1'];
        $apellidos2 = $_POST['apellidos2'];
        $edades = $_POST['edades'];
        $telefonos = $_POST['telefonos'];
        foreach ($Dnis as $index => $dni) {
            $nombre = $nombres[$index];
            $apellido1 = $apellidos1[$index];
            $apellido2 = $apellidos2[$index];
            $edad = $edades[$index];
            $telefono = $telefonos[$index];
            $existe = $dao->obtener($dni);

            $alumno = new Alumno($dni, $nombre, $apellido1, $apellido2, $edad, $telefono);
            $dao->insertar($alumno);
            $alumnosRecuperados[] = $alumno;

        }
    } else {
        $_SESSION['errorRecuperar'] = "No hay marcado ningun alumno para recuperar";
    }
}
$alumnos = $dao->listar();

?>

<body class="bg-light">
    <div class="container">
        <?php
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }

        ?>
        <h1 class="text-center">Gestion de alumnos</h1>
        <?php
        if ($alumnoInsertado) {
            echo "<h3>Alumno insertado</h3>";
            echo "<form method='post'>";
            echo "<fieldset class='w-50'>";
            echo "DNI:<input class='form-control' type='text' name='dni' value='{$alumnoInsertado->dni}' disabled/>";
            echo "Nombre:<input class='form-control' type='text' name='nombre' value='{$alumnoInsertado->nombre}' disabled/>";
            echo "Primer Apellido:<input class='form-control' type='text' name='apellido1' value='{$alumnoInsertado->apellido1}' disabled/>";
            echo "Segundo Apellido:<input class='form-control' type='text' name='apellido2' value='{$alumnoInsertado->apellido2}' disabled/>";
            echo "Edad:<input class='form-control' type='text' name='edad' value='{$alumnoInsertado->edad}' disabled/>";
            echo "Telefono:<input class='form-control' type='text' name='telefono' value='{$alumnoInsertado->telefono}' disabled/>";
            echo "</fieldset>";
            echo '<input class="btn btn-secondary mx-2 btn-lg" type="submit" name="volver" value="Volver">';
            echo "</form>";
        } else if (isset($_POST['insertar']) || isset($_SESSION['errorFormulario'])) {
            if (isset($_SESSION['errorFormulario'])) {
                echo $_SESSION['errorFormulario'];
                unset($_SESSION['errorFormulario']);
            }
            echo "<form method='post'>";
            echo "<fieldset class='w-50'>";
            echo "<legend>Insertar nuevo alumno</legend>";
            echo "DNI:<input class='form-control' type='text' name='dni' value='' />";
            echo "Nombre:<input class='form-control' type='text' name='nombre' value='' />";
            echo "Primer Apellido:<input class='form-control' type='text' name='apellido1' value='' />";
            echo "Segundo Apellido:<input class='form-control' type='text' name='apellido2' value='' />";
            echo "Edad:<input class='form-control' type='text' name='edad' value='' />";
            echo "Telefono:<input class='form-control' type='text' name='telefono' value='' />";
            echo "</fieldset>";
            echo '<input class="btn btn-success mx-2 btn-lg" type="submit" name="insertarBBDD" value="Insertar">';
            echo '<input class="btn btn-secondary mx-2 btn-lg" type="submit" name="volver" value="Volver">';
            echo "</form>";

        } else {
            ?>
                <form method="post">
                    <div class="d-flex justify-content-between">
                        <div>
                            <input class="btn btn-primary me-3 btn-lg mb-3" type="submit" name="seleccionar"
                                value="Seleccionar">
                            <input class="btn btn-success me-3 btn-lg mb-3" type="submit" name="insertar" value="Insertar">
                            <input class="btn btn-warning me-3 btn-lg mb-3" type="submit" name="eliminar" value="Eliminar">
                            <input class="btn btn-danger me-3 btn-lg mb-3" type="submit" name="eliminarTodos"
                                value="Eliminar Todos">

                            <?php
                            if (isset($_POST['eliminar']) || isset($_POST['actualizar']) || isset($_POST['recuperar']) || isset($_POST['seleccionar'])) {
                                echo '<input class="btn btn-secondary me-3 btn-lg mb-3" type="submit" name="volver" value="Volver">';
                            } else {

                            }
                            ?>
                        </div>
                        <div class="w-25 p-1">
                            <?php
                            if (isset($_POST['eliminar']) || isset($_POST['actualizar']) || isset($_POST['recuperar']) || isset($_POST['seleccionar'])) {
                            } else {
                                echo '<input id="buscar" class="form-control p-2" type="text" name="buscar"
                                 placeholder="Buscar...">';

                            }
                            ?>
                        </div>
                    </div>
                    <table id="tabla" class="table table-striped table-bordered table-dark text-center">
                        <thead>
                            <tr>
                                <th></th>
                                <th scope="col">DNI</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">PRIMER APELLIDO</th>
                                <th scope="col">SEGUNDO APELLIDO</th>
                                <th scope="col">EDAD</th>
                                <th scope="col">TELEFONO</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($_POST['eliminar']) || isset($_SESSION['errorRecuperar'])) {
                            if (isset($_POST['Dnis'])) {
                                $Dnis = $_POST['Dnis'];
                                foreach ($Dnis as $dni) {
                                    $alumno = $dao->obtener($dni);
                                    $dao->eliminar($dni);
                                    $alumnosEliminados[] = $alumno;
                                }
                                if (isset($_SESSION['errorRecuperar'])) {
                                    echo $_SESSION['errorRecuperar'];
                                    unset($_SESSION['errorRecuperar']);
                                }
                                echo "<h3 class='text-center'>Alumnos eliminados.</h3>";
                                echo '<input class="btn btn-success mx-2 btn-lg mb-2" type="submit" name="recuperar" value="Recuperar">';

                                foreach ($alumnosEliminados as $alum) {
                                    echo "<tr>";
                                    echo "<td><input class='form-check-input' type='checkbox' name='DnisDelete[]' value='{$alum->dni}' checked /></td>";
                                    echo "<td><input type='hidden' name='dnis[]' value='{$alum->dni}' />{$alum->dni}</td>";
                                    echo "<td><input type='hidden' name='nombres[]' value='{$alum->nombre}' />{$alum->nombre}</td>";
                                    echo "<td><input type='hidden' name='apellidos1[]' value='{$alum->apellido1}' />{$alum->apellido1}</td>";
                                    echo "<td><input type='hidden' name='apellidos2[]' value='{$alum->apellido2}' />{$alum->apellido2}</td>";
                                    echo "<td><input type='hidden' name='edades[]' value='{$alum->edad}' />{$alum->edad}</td>";
                                    echo "<td><input type='hidden' name='telefonos[]' value='{$alum->telefono}' />{$alum->telefono}</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                echo '<input class="btn btn-secondary mx-2 btn-lg mb-2" type="submit" name="volver" value="Volver">';

                            } else {
                                $_SESSION['error'] = "No hay ningun alumno marcado para eliminar";
                                header('Location:principal.php');
                            }

                        } else if (isset($_POST['recuperar'])) {
                            if (!empty($alumnosRecuperados)) {

                                echo "<h3 class='text-center'>Alumnos recuperados.</h3>";

                                foreach ($alumnosRecuperados as $alum) {
                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td>{$alum->dni}</td>";
                                    echo "<td>{$alum->nombre}</td>";
                                    echo "<td>{$alum->apellido1}</td>";
                                    echo "<td>{$alum->apellido2}</td>";
                                    echo "<td>{$alum->edad}</td>";
                                    echo "<td>{$alum->telefono}</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                echo '<input class="btn btn-secondary mx-2 btn-lg mb-2" type="submit" name="volver" value="Volver">';

                            }
                        } else if (isset($_POST['seleccionar']) || isset($_SESSION['errorUpdate'])) {
                            if (isset($_POST['Dnis'])) {
                                $Dnis = $_POST['Dnis'];

                                if (isset($_POST['DnisUpdate'])) {
                                    $Dnis = $_POST['DnisUpdate'];
                                }
                                echo "</form>";
                                echo "</div>";
                                echo "</body>";


                                foreach ($Dnis as $dni) {
                                    $alum = $dao->obtener($dni);
                                    echo "<tr>";
                                    echo "<td><input class='form-check-input' type='checkbox' name='DnisUpdate[]' value='{$alum->dni}' checked /></td>";
                                    echo "<td>{$alum->dni}</td>";
                                    echo "<td>{$alum->nombre}</td>";
                                    echo "<td>{$alum->apellido1}</td>";
                                    echo "<td>{$alum->apellido2}</td>";
                                    echo "<td>{$alum->edad}</td>";
                                    echo "<td>{$alum->telefono}</td>";
                                    echo "</tr>";
                                }

                                echo "</table>";
                                echo "<h1 class='text-center mt-5'>Formularios</h1>";

                                if (isset($_SESSION['errorUpdate'])) {
                                    echo $_SESSION['errorUpdate'];
                                    unset($_SESSION['errorUpdate']);
                                }
                                foreach ($Dnis as $dni) {
                                    $alum = $dao->obtener($dni);
                                    echo "<fieldset class='w-50'>";
                                    echo "<legend>Datos alumno con Dni: {$alum->dni} </legend>";
                                    echo "<input type='hidden' name='Dnis[]' value='{$alum->dni}'>";
                                    echo "Nombre:<input class='form-control' type='text' name='nombres[]' value='{$alum->nombre}' />";
                                    echo "Primer Apellido:<input class='form-control' type='text' name='apellidos1[]' value='{$alum->apellido1}' />";
                                    echo "Segundo Apellido:<input class='form-control' type='text' name='apellidos2[]' value='{$alum->apellido2}' />";
                                    echo "Edad: <input class='form-control' type='text' name='edades[]' value='{$alum->edad}' />";
                                    echo "Telefono: <input class='form-control' type='text' name='telefonos[]' value='{$alum->telefono}' />";
                                    echo "</fieldset><br>";
                                }
                                echo '<input class="btn btn-warning mx-2 btn-lg mb-2" type="submit" name="actualizar" value="Actualizar">';
                                echo '<input class="btn btn-secondary mx-2 btn-lg mb-2" type="submit" name="volver" value="Volver">';

                                echo "</form>";
                                echo "</body>";

                            } else {
                                $_SESSION['error'] = "No hay ningun alumno seleccionado.";
                                header("Location:principal.php");
                            }

                        } else {
                            if (!empty($alumnosActualizados)) {
                                echo "<h3 class='text-center'>Datos de alumnos antes de la actualizacion.</h3>";

                                foreach ($alumnosPreUpdate as $alumno) {
                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td>{$alumno->dni}</td>";
                                    echo "<td>{$alumno->nombre}</td>";
                                    echo "<td>{$alumno->apellido1}</td>";
                                    echo "<td>{$alumno->apellido2}</td>";
                                    echo "<td>{$alumno->edad}</td>";
                                    echo "<td>{$alumno->telefono}</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                echo '<input class="btn btn-secondary mx-2 btn-lg mb-2" type="submit" name="volver" value="Volver">';

                                echo "<h3 class='text-center'>Datos de alumnos actualizados.</h3>";

                                ?>
                                        <table class="table table-striped table-bordered table-dark text-center">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th scope="col">DNI</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Primer Apellido</th>
                                                    <th scope="col">Segundo Apellido</th>
                                                    <th scope="col">Edad</th>
                                                    <th scope="col">Telefono</th>
                                                </tr>
                                            </thead>
                                    <?php
                                    foreach ($alumnosActualizados as $alumno) {
                                        echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td>{$alumno->dni}</td>";
                                        echo "<td>{$alumno->nombre}</td>";
                                        echo "<td>{$alumno->apellido1}</td>";
                                        echo "<td>{$alumno->apellido2}</td>";
                                        echo "<td>{$alumno->edad}</td>";
                                        echo "<td>{$alumno->telefono}</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                    echo '<input class="btn btn-secondary mx-2 btn-lg mb-2" type="submit" name="volver" value="Volver">';

                            } else {
                                if (!empty($alumnos)) {
                                    foreach ($alumnos as $alumno) {
                                        echo "<tr>";
                                        echo "<td><input class='form-check-input' type='checkbox' name='Dnis[]' value='{$alumno->dni}' /></td>";
                                        echo "<td>{$alumno->dni}</td>";
                                        echo "<td>{$alumno->nombre}</td>";
                                        echo "<td>{$alumno->apellido1}</td>";
                                        echo "<td>{$alumno->apellido2}</td>";
                                        echo "<td>{$alumno->edad}</td>";
                                        echo "<td>{$alumno->telefono}</td>";
                                        echo "</tr>";
                                    }
                                } else {

                                    echo "</table>";
                                    echo "<p>*NO HAY DATOS REGISTRADOS</p>";
                                }
                            }

                        }
        } ?>
        </form>
    </div>
</body>

</html>