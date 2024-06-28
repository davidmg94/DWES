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

if (isset($_POST['actualizar'])) {
    if (isset($_POST['Dnis'])) {
        $Dnis = $_POST['Dnis'];
        foreach ($Dnis as $dni) {
            $nombre = $_POST[$dni . '_nombre'];
            $apellido1 = $_POST[$dni . '_apellido1'];
            $apellido2 = $_POST[$dni . '_apellido2'];
            $edad = $_POST[$dni . '_edad'];
            $telefono = $_POST[$dni . '_telefono'];


            if (!empty($dni) && !empty($nombre) && !empty($apellido1) && !empty($apellido2)
                && !empty($edad) && !empty($telefono)) {

                $alumno = new Alumno($dni, $nombre, $apellido1, $apellido2,
                    $edad, $telefono);

                $dao->actualizar($alumno);
            } else {
                echo "Hay <Strong>campos vacios</strong> en el formulario.";
            }
        }
        echo "Registro de alumnos actualizado correctamente.";
    }
}
$alumnos = $dao->listar();

?>

<body class="bg-light">
    <div class="container">
        <h1 class="text-center">Listado de alumnos</h1>

        <form method="post">
            <input class="btn btn-success mx-2 btn-lg mb-3" type="submit" name="seleccionar" value="Seleccionar">
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
            echo "<td><input class='form-check-input' type='checkbox' name='Dnis[]' value='{$alum->dni}' checked/></td>";
            echo "<td>{$alum->dni}</td>";
            echo "<td>{$alum->nombre}</td>";
            echo "<td>{$alum->apellido1}</td>";
            echo "<td>{$alum->apellido2}</td>";
            echo "<td>{$alum->edad}</td>";
            echo "<td>{$alum->telefono}</td>";
            echo "</tr>";
        }
        ?>
        </form>

        </table>
        <div class="container">
            <h1 class="text-center mt-5">Formularios</h1>
            <form method="post">
                <?php
                foreach ($Dnis as $dni) {
                    $alum = $dao->obtener($dni);
                    echo "<fieldset class='w-50'>";
                    echo "<legend>Datos alumno con Dni: {$alum->dni} </legend>";
                    echo "<input type='hidden' name='Dnis[]' value='{$alum->dni}'>";
                    echo "Nombre:<input class='form-control' type='text' name='{$alum->dni}_nombre' value='{$alum->nombre}' />";
                    echo "Primer Apellido:<input class='form-control' type='text' name='{$alum->dni}_apellido1' value='{$alum->apellido1}' />";
                    echo "Segundo Apellido:<input class='form-control' type='text' name='{$alum->dni}_apellido2' value='{$alum->apellido2}' />";
                    echo "Edad: <input class='form-control' type='text' name='{$alum->dni}_edad' value='{$alum->edad}' />";
                    echo "Telefono: <input class='form-control' type='text' name='{$alum->dni}_telefono' value='{$alum->telefono}' />";
                    echo "</fieldset><br>";
                }
                echo '<input class="btn btn-warning mx-2 btn-lg" type="submit" name="actualizar" value="Actualizar">';
                    }
                    ?>
        </form>
    </div>

    </body>

    <?php
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
                ?>
</form>
</div>
</body>

</html>