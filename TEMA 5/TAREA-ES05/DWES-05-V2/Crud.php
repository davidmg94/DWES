<!DOCTYPE html>
<html lang="es">

<head>
    <title>Tarea 05</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-light">

    <?php
    // Se incluyen los archivos PHP necesarios y se crea una instancia del objeto DaoAlumno
    require_once "conexion.php";
    require_once "DaoAlumno.php";

    // Se crea una instancia del objeto DaoAlumno, utilizando la conexión a la base de datos proporcionada ($db)
    $dao = new DaoAlumno($db);

    // Procesamiento de formularios enviados por método POST
    if (isset($_POST['insertar'])) {
        // Procesa la inserción de un nuevo alumno
    
        // Recoge los datos insertados en el formulario
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $edad = $_POST['edad'];
        $telefono = $_POST['telefono'];

        // Comprueba que no haya campos vacios en el formulario
        if (!empty($dni)
            && !empty($nombre)
            && !empty($apellido1)
            && !empty($apellido2)
            && !empty($edad)
            && !empty($telefono)) {

            // Crea un nuevo objeto Alumno con los datos ingresados
            $alumno = new Alumno($dni, $nombre, $apellido1, $apellido2, $edad, $telefono);

            // Inserta el alumno en la base de datos a través del objeto DaoAlumno
            $dao->insertar($alumno);

            echo "Alumno insertado correctamente.";


        } else {
            // Si hay campos vacios se muestra un mensaje
            echo "Hay <Strong>campos vacios</strong> en el formulario.";
        }

    } else if (isset($_POST['actualizar'])) {
        // Procesa la actualización de datos de los alumnos seleccionados
        if (isset($_POST['Dnis'])) {
            // Verifica si se han seleccionado alumnos para actualizar
            $Dnis = $_POST['Dnis'];
            foreach ($Dnis as $key => $dni) {
                // Itera sobre cada DNI seleccionado y actualiza los datos correspondientes
                $nombre = $_POST[$dni . '_nombre'];
                $apellido1 = $_POST[$dni . '_apellido1'];
                $apellido2 = $_POST[$dni . '_apellido2'];
                $edad = $_POST[$dni . '_edad'];
                $telefono = $_POST[$dni . '_telefono'];

                // Comprueba que no haya campos vacios en el formulario
                if (!empty($dni)
                    && !empty($nombre)
                    && !empty($apellido1)
                    && !empty($apellido2)
                    && !empty($edad)
                    && !empty($telefono)) {

                    // Crea un nuevo objeto Alumno con los datos actualizados
                    $alumno = new Alumno(
                        $dni,
                        $nombre,
                        $apellido1,
                        $apellido2,
                        $edad,
                        $telefono
                    );

                    // Llama al método actualizar del objeto DaoAlumno para actualizar los alumnos en la base de datos
                    $dao->actualizar($alumno);
                } else {
                    // Si hay campos vacios se muestra un mensaje
                    echo "Hay <Strong>campos vacios</strong> en el formulario.";
                }
            }
            echo "Registro de alumnos actualizado correctamente.";

        } else {
            echo "Debes seleccionar <Strong>al menos un alumno</Strong> para actualizar sus datos.";
        }
    } else if (isset($_POST['eliminar'])) {
        // Procesa la eliminacion de datos de los alumnos seleccionados
        if (isset($_POST['Dnis'])) {
            // Verifica si se han seleccionado alumnos para eliminar
            $Dnis = $_POST['Dnis'];
            foreach ($Dnis as $key => $dni) {
                // Llama al método eliminar del objeto DaoAlumno para eliminar los alumnos en la base de datos
                $dao->eliminar($dni);
            }
            echo "Alumnos eliminados correctamente.";

        } else {
            echo "Debes seleccionar <Strong>al menos un alumno</Strong> para eliminar sus datos.";
        }
    } else if (isset($_POST['obtener'])) {
        // Procesa la obtención de un alumno por su DNI
        $Dni = $_POST['dni'];

        if (!empty($Dni)) {
            // Si el DNI no está vacío, se intenta obtener el alumno correspondiente
            $alumnoBuscado = $dao->obtener($Dni);

            if (is_null($alumnoBuscado)) {
                // Si el alumno buscado es nulo, significa que no existe en la base de datos
                echo "No existe un alumno con el DNI: <strong>" . $Dni . "</strong>";
            }
        } else {
            // Si el DNI está vacío, se muestra un mensaje indicando que está vacío
            echo "El campo <strong>DNI</strong> está vacío.";

        }
    }

    // Vuelve a obtener la lista de alumnos después de las posibles modificaciones
    $alumnos = $dao->listar();
    ?>

    <body class="bg-light">
        <div class="container">
            <h1 class="text-center">Gestión de alumnos</h1>

            <!-- Formulario para mostrar instrucciones -->
            <form class="mb-2" method="post">
                <!-- Botón para mostrar instrucciones -->
                <input class="btn btn-primary" type="submit" value="Instrucciones" name="instrucciones">

                <?php
                // Verifica si se ha enviado el formulario de instrucciones
                if (isset($_POST['instrucciones'])) {
                    ?>
                    <!-- Se muestran las instrucciones -->
                    <p class="mb-1">* Rellene los campos de la fila vacía
                        <!-- Se muestran las instrucciones -->
                    <p class="mb-1">* Rellene los campos de la fila vacía para insertar un alumno.</p>
                    <p class="mb-1">* Rellene el campo DNI de la fila vacía para buscar un alumno.</p>
                    <p class="mb-1">* Modifique los campos de las filas para actualizar alumnos.</p>
                    <p class="mb-1">* Para actualizar o eliminar alumnos debe marcar la casilla de la fila correspondiente.
                    </p>

                    <!-- Botón para ocultar las instrucciones -->
                    <input class="btn btn-secondary" type="submit" value="Ocultar" name="ocultar">
                    <?php
                } else if (isset($_POST['ocultar'])) {
                    // Código para manejar la ocultación de las instrucciones
                }
                ?>
            </form>
            <form method="post">
                <!-- Botones de acción para realizar operaciones -->
                <div class="text-center mb-3">
                    <input class="btn btn-success mx-2 btn-lg" type="submit" name="insertar" value="Insertar">
                    <input class="btn btn-warning mx-2 btn-lg" type="submit" name="actualizar" value="Actualizar">
                    <input class="btn btn-dark mx-2 btn-lg" type="submit" name="obtener" value="Buscar">
                    <input class="btn btn-danger btn-lg mx-2" type="submit" name="eliminar" value="Eliminar"
                        onclick="return confirmarBorrado()">
                </div>
                <table class="table table-striped table-bordered table-dark text-center">
                    <tr>
                        <th></th>
                        <th scope="col">DNI</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Primer Apellido</th>
                        <th scope="col">Segundo Apellido</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Teléfono</th> <!-- Nuevo encabezado para el teléfono -->
                    </tr>
                    <!-- Fila para insertar un nuevo alumno -->
                    <tr>
                        <td></td>
                        <td>
                            <input class='form-control' type="text" name="dni" value="<?php if (isset($alumnoBuscado)) {
                                echo $alumnoBuscado->dni;
                            } ?>" />
                        </td>

                        <td>
                            <input class='form-control' type="text" name="nombre" value="<?php if (isset($alumnoBuscado)) {
                                echo $alumnoBuscado->nombre;
                            } ?>" />
                        </td>
                        <td>
                            <input class='form-control' type="text" name="apellido1" value="<?php if (isset($alumnoBuscado)) {
                                echo $alumnoBuscado->apellido1;
                            } ?>" />
                        </td>
                        <td>
                            <input class='form-control' type="text" name="apellido2" value="<?php if (isset($alumnoBuscado)) {
                                echo $alumnoBuscado->apellido2;
                            } ?>" />
                        </td>
                        <td>
                            <input class='form-control' type="text" name="edad" value="<?php if (isset($alumnoBuscado)) {
                                echo $alumnoBuscado->edad;
                            } ?>" />
                        </td>
                        <td>
                            <input class='form-control' type="text" name="telefono" value="<?php if (isset($alumnoBuscado)) {
                                echo $alumnoBuscado->telefono; // Mostrar el teléfono si está definido
                            } ?>" />
                        </td>
                    </tr>
                    <?php
                    // Itera sobre la lista de alumnos para mostrarlos en la tabla
                    foreach ($alumnos as $key => $alumno) {
                        echo "<tr>";

                        // Checkbox para seleccionar cada alumno
                        echo "<td>";
                        echo "<input class='form-check-input' type='checkbox' name='Dnis[]' value='" . $alumno->dni . "' />";
                        echo "</td>";

                        // Muestra el DNI del alumno (no editable)
                        echo "<td>";
                        echo $alumno->dni;
                        echo "</td>";

                        // Campos de texto para editar los datos del alumno
                        echo "<td>";
                        echo "<input class='form-control' type='text' name='" . $alumno->dni . "_nombre' value='" . $alumno->nombre . "' />";
                        echo "</td>";

                        echo "<td>";
                        echo "<input class='form-control' type='text' name='" . $alumno->dni . "_apellido1' value='" . $alumno->apellido1 . "' />";
                        echo "</td>";

                        echo "<td>";
                        echo "<input class='form-control' type='text' name='" . $alumno->dni . "_apellido2' value='" . $alumno->apellido2 . "' />";
                        echo "</td>";

                        echo "<td>";
                        echo "<input class='form-control' type='text' name='" . $alumno->dni . "_edad' value='" . $alumno->edad . "' />";
                        echo "</td>";

                        echo "<td>";
                        echo "<input class='form-control' type='text' name='" . $alumno->dni . "_telefono' value='" . $alumno->telefono . "' />";
                        echo "</td>";

                        echo "</tr>";
                    }
                    ?>
                </table>

            </form>
        </div>
        <script>
            // Función para mostrar un cuadro de diálogo de confirmación
            function confirmarBorrado() {
                return confirm("¿Estás seguro de que quieres eliminar este alumno?");
            }
        </script>
    </body>

</html>