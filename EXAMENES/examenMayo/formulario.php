<?php
// Incluir el archivo con la clase AlumnoDAO para manejar operaciones relacionadas con alumnos
require 'alumnoDAO.php';

// Incluir el archivo con otras clases DAO (Data Access Object) para manejar países, provincias y localidades
require 'daos.php';

// Nombre de la base de datos
$nameBBDD = "prueba";

// Crear instancias de los DAOs para países, provincias y localidades utilizando la base de datos especificada
$paisesDAO = new PaisesDAO($nameBBDD);
$provinciasDAO = new ProvinciasDAO($nameBBDD);
$localidadesDAO = new LocalidadesDAO($nameBBDD);

// Obtener todos los países, provincias y localidades desde la base de datos
$paises = $paisesDAO->getPaises();
$provincias = $provinciasDAO->getProvincias();
$localidades = $localidadesDAO->getLocalidades();

// Crear instancia del DAO para manejar operaciones con alumnos utilizando la base de datos especificada
$dao = new AlumnoDAO($nameBBDD);

// Verificar si se ha enviado el formulario de búsqueda de alumnos
if (isset($_POST['buscar'])) {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $pais_id = $_POST['pais_id'];
    $provincia_id = $_POST['provincia_id'];
    $localidad_id = $_POST['localidad_id'];

    // Realizar la búsqueda de alumnos según los criterios proporcionados
    $alumnos = $dao->search($nombre, $apellido, $pais_id, $provincia_id, $localidad_id);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Buscar Alumno</title>
</head>

<body>
    <!-- Formulario para buscar alumnos -->
    <form method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
        <?php
        // Verificar si se ha realizado la búsqueda de alumnos
        if (isset($_POST['buscar'])) {
            ?>
            <!-- Mostrar el listado de alumnos encontrados -->
            <fieldset>
                <legend>Listado alumnos</legend>
                <table border="2">
                    <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>País</th>
                        <th>Provincia</th>
                        <th>Localidad</th>
                    </thead>
                    <tbody>
                        <?php
                        // Iterar sobre los alumnos encontrados y mostrar cada uno en una fila de la tabla
                        foreach ($alumnos as $alumno) {
                            // Obtener el nombre del país, provincia y localidad del alumno utilizando métodos del DAO
                            $pais = $dao->buscarPais($alumno['pais_id']);
                            $provincia = $dao->buscarProvincia($alumno['provincia_id']);
                            $localidad = $dao->buscarLocalidad($alumno['localidad_id']);

                            // Mostrar cada dato del alumno en una fila de la tabla
                            echo "<tr>
                                <td>{$alumno['id']}</td>
                                <td>{$alumno['nombre']}</td>
                                <td>{$alumno['apellido']}</td>
                                <td>{$pais}</td>
                                <td>{$provincia}</td>
                                <td>{$localidad}</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </fieldset>
            <input type="submit" value="Volver" name="volver">
        <?php } else { ?>
            <!-- Mostrar el formulario para ingresar criterios de búsqueda -->
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre"><br>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido"><br>

            <label for="pais">País:</label>
            <select name="pais_id" id="pais">
                <option value="">Seleccionar País</option>
                <?php foreach ($paises as $pais): ?>
                    <!-- Iterar sobre los países y mostrar cada uno como opción en el select -->
                    <option value="<?= $pais['id'] ?>"><?= $pais['nombre'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="provincia">Provincia:</label>
            <select name="provincia_id" id="provincia">
                <option value="">Seleccionar Provincia</option>
                <?php foreach ($provincias as $provincia): ?>
                    <!-- Iterar sobre las provincias y mostrar cada una como opción en el select -->
                    <option value="<?= $provincia['id'] ?>"><?= $provincia['nombre'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="localidad">Localidad:</label>
            <select name="localidad_id" id="localidad">
                <option value="">Seleccionar Localidad</option>
                <?php foreach ($localidades as $localidad): ?>
                    <!-- Iterar sobre las localidades y mostrar cada una como opción en el select -->
                    <option value="<?= $localidad['id'] ?>"><?= $localidad['nombre'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <input type="submit" value="Buscar" name="buscar">
        </form>
    <?php } ?>
</body>

</html>