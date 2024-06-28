<!DOCTYPE html>
<html lang="es">

<head>
    <title>Prueba</title>
</head>
<?php
// Incluir el archivo que contiene las definiciones de los DAOs y la configuración de la base de datos
require "daos.php";

// Nombre de la base de datos
$nameBBDD = "prueba2";

// Crear instancias de los DAOs para países, provincias y localidades
$paisesDAO = new PaisesDAO($nameBBDD);
$provinciasDAO = new ProvinciasDAO($nameBBDD);
$localidadesDAO = new LocalidadesDAO($nameBBDD);

// Obtener todos los países desde la base de datos
$paises = $paisesDAO->getPaises();

// Iniciar la sesión PHP
session_start();

// Inicializar variables de selección
$idPais = "";
$idProvincia = "";
$idLocalidad = "";
$provincias = [];
$localidades = [];

// Verificar si se ha enviado el formulario
if (isset($_POST['mostrar'])) {
    // Incrementar el contador de sesión
    $_SESSION['contador']++;

    // Obtener el id del país seleccionado del formulario
    $idPais = $_POST['pais'];

    // Obtener las provincias del país seleccionado
    $provincias = $provinciasDAO->getProvincias($idPais);

    // Si se ha mostrado al menos una provincia, continuar
    if ($_SESSION['contador'] >= 2) {
        // Obtener el id de la provincia seleccionada del formulario
        $idProvincia = $_POST['provincia'];

        // Obtener las localidades de la provincia seleccionada
        $localidades = $localidadesDAO->getLocalidades($idProvincia);
    }

    // Si se ha mostrado al menos una localidad, obtener el id de la localidad seleccionada
    if ($_SESSION['contador'] >= 3) {
        $idLocalidad = $_POST['localidad'];
    }
} else {
    // Si no se ha enviado el formulario (primera carga o recarga), restablecer el contador de sesión a 0
    $_SESSION['contador'] = 0;
}
?>

<body>
    <form method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
        <!-- Select para elegir el país -->
        <select name="pais">
            <?php foreach ($paises as $pais) { ?>
                <option value="<?php echo $pais['id_pais']; ?>" <?php echo ($pais['id_pais'] == $idPais) ? 'selected' : ''; ?>>
                    <?php echo $pais['nombre_pais']; ?>
                </option>
            <?php } ?>
        </select>

        <!-- Select para elegir la provincia, mostrado si se ha seleccionado un país -->
        <?php if ($_SESSION['contador'] >= 1) { ?>
            <select name="provincia">
                <?php foreach ($provincias as $provincia) { ?>
                    <option value="<?php echo $provincia['id_provincia']; ?>" <?php echo ($provincia['id_provincia'] == $idProvincia) ? 'selected' : ''; ?>>
                        <?php echo $provincia['nombre_provincia']; ?>
                    </option>
                <?php } ?>
            </select>
        <?php } ?>

        <!-- Select para elegir la localidad, mostrado si se ha seleccionado una provincia -->
        <?php if ($_SESSION['contador'] >= 2) { ?>
            <select name="localidad">
                <?php foreach ($localidades as $localidad) { ?>
                    <option value="<?php echo $localidad['id_localidad']; ?>" <?php echo ($localidad['id_localidad'] == $idLocalidad) ? 'selected' : ''; ?>>
                        <?php echo $localidad['nombre_localidad']; ?>
                    </option>
                <?php } ?>
            </select>
        <?php } ?>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Mostrar" name="mostrar">
    </form>
</body>

</html>