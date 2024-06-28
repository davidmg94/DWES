<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Borrar</title>
</head>

<body>
    <?php
    // Requiere el archivo de conexión "conexion.php"
    require_once("conexion.php");

    // Verifica si se recibió el parámetro 'id' mediante el método POST
    if (isset($_POST['id'])) {
        // Obtiene el valor de 'id' desde el formulario
        $id = $_POST['id'];
        // Crea una consulta SQL para eliminar el producto con el ID proporcionado
        $sql = "DELETE FROM productos WHERE id=$id";
        // Ejecuta la consulta mediante la conexión establecida
        $delete = $conexion->query($sql);
    } else {
        // Redirige a la página "listado.php" si no se proporciona el parámetro 'id'
        header('Location: listado.php');
    }
    ?>
    <!-- Muestra un mensaje indicando que el producto con el código 'id' se ha borrado correctamente -->
    <span class="fw-bold fs-4">Producto de código: <?php echo $id ?> Borrado correctamente</span>
    <div class="d-inline-block">
    <!-- Crea un formulario y un botón para volver a la página "listado.php" -->
        <form action="listado.php">
            <button class="btn btn-secondary">Volver</button>
        </form>
    </div>
</body>

</html>