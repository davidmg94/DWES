<!DOCTYPE html>
<html lang="es">

<head>
    <title>Examen Mayo</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
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
require_once "alumno.php";
require_once "LibreriaPDO.php";
require_once "DaoAlumno.php";

$bbddname = "mayo";
$dao = new DaoAlumno($bbddname);
$alumnosActualizados = [];

if (isset($_POST['actualizar'])) {
    if (isset($_POST['DnisUpdate'])) {
        $Dnis = $_POST['DnisUpdate'];
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
            if (!empty($dni) && !empty($nombre) && !empty($apellido1) && !empty($apellido2)
                && !empty($edad) && !empty($telefono)) {

                $alumno = new Alumno($dni, $nombre, $apellido1, $apellido2,
                    $edad, $telefono);

                $dao->actualizar($alumno);
                $alumnosActualizados[] = $alumno;

                echo "Alumno con DNI; <strong>{$alumno->dni}</strong>, actualizado correctamente.<br>";
            } else {
                echo "Hay <Strong>campos vacios</strong> en el formulario.";
            }
        }

    }
} else if (isset($_POST['eliminar'])) {
    if (isset($_POST['Dnis'])) {
        $Dnis = $_POST['Dnis'];
        foreach ($Dnis as $dni) {
            $dao->eliminar($dni);
            echo "Alumno con DNI; <strong>{$dni}</strong>, eliminado correctamente.<br>";
        }
    } else {
        echo "No hay ningun alumno seleccionado";
    }
} else if (isset($_POST['eliminarTodos'])) {
    $dao->eliminarTodos();
    echo "Registros eliminados";
} else if (isset($_POST['insertarBBDD'])) {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $edad = $_POST['edad'];
    $telefono = $_POST['telefono'];
    if (!empty($dni) && !empty($nombre) && !empty($apellido1) && !empty($apellido2)
        && !empty($edad) && !empty($telefono)) {

        $alumno = new Alumno($dni, $nombre, $apellido1, $apellido2,
            $edad, $telefono);

        $dao->insertar($alumno);
        echo "Alumno con DNI; <strong>{$alumno->dni}</strong>, insertado correctamente.<br>";

    } else {
        echo "Hay <Strong>campos vacios</strong> en el formulario.";
    }
} else if (isset($_POST['volver'])) {
    header('Location: principal.php');
}
$alumnos = $dao->listar();

?>

<body class="bg-light">
    <div class="container">
        <h1 class="text-center">Gestion de alumnos</h1>
        <?php

        if (isset($_POST['insertar'])) {
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
                <div class="d-inline-flex">

                    <input class="btn btn-primary mx-2 btn-lg mb-3" type="submit" name="seleccionar" value="Seleccionar">
                    <input class="btn btn-success mx-2 btn-lg mb-3" type="submit" name="insertar" value="Insertar">
                    <input class="btn btn-warning mx-2 btn-lg mb-3" type="submit" name="eliminar" value="Eliminar">
                    <input class="btn btn-danger mx-2 btn-lg mb-3" type="submit" name="eliminarTodos"
                        value="Eliminar Todos">
                </div>

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
                    if (isset($_POST['seleccionar'])) {
                        if (!isset($_POST['Dnis'])) {
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
                        } else {
                            $Dnis = $_POST['Dnis'];
                            ?>
                    </form>
                </div>
            </body>
            <?php

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
            ?>

            </table>
            <h1 class="text-center mt-5">Formularios</h1>
            <?php
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

            echo '<input class="btn btn-warning mx-2 btn-lg" type="submit" name="actualizar" value="Actualizar">';
            echo '<input class="btn btn-secondary mx-2 btn-lg" type="submit" name="volver" value="Volver">';
                        }
                        ?>
        </form>
        </body>
        <?php
                    } else {
                        if (!empty($alumnosActualizados)) {
                            echo '<input class="btn btn-secondary mx-2 btn-lg mb-2" type="submit" name="volver" value="Volver">';
                            echo "<h3 class='text-center'>Alumnos actualizados.</h3>";
                            foreach ($alumnosActualizados as $alumno) {
                                echo "<tr>";
                                echo "<td><input class='form-check-input' type='checkbox' name='Dnis[]' value='{$alumno->dni}' checked/></td>";
                                echo "<td>{$alumno->dni}</td>";
                                echo "<td>{$alumno->nombre}</td>";
                                echo "<td>{$alumno->apellido1}</td>";
                                echo "<td>{$alumno->apellido2}</td>";
                                echo "<td>{$alumno->edad}</td>";
                                echo "<td>{$alumno->telefono}</td>";
                                echo "</tr>";
                            }

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