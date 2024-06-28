<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Detalles</title>
    <style>
        .card,
        .btn {
            color: white;
            background-color: steelblue;
        }
    </style>
</head>

<body class="bg-info">
    <div class="container">
        <h2 class="text-center">Detalle de producto</h2>

        <?php
        // Verifica si no se ha pasado un ID a través de la URL y redirige a la página de listado
        if (!isset($_GET['id'])) {
            header('Location: listado.php');
            exit();
        } else {
            // Requiere el archivo de conexión "conexion.php"
            require_once("conexion.php");

            // Obtiene el ID del producto de la URL
            $id = $_GET['id'];

            // Crea la consulta SQL para seleccionar el producto con el ID dado
            $sql = "SELECT * FROM productos WHERE id=$id";

            // Ejecuta la consulta y obtiene el primer resultado como objeto
            $result = $conexion->query($sql);
            $producto = $result->fetch(PDO::FETCH_OBJ);

            // Verifica si no se encontró un producto con el ID dado y redirige a la página de listado
            if ($producto == null) {
                header('Location: listado.php');
            }
        }
        ?>
        <div class="m-auto w-75">
            <div class="card mt-5">
                <h5 class="text-center card-header">
                    <?php echo $producto->nombre; ?>
                </h5>
                <div class="card-body">
                    <h5 class="text-center card-title">
                        <?php echo "<p>Codigo: $producto->id" ?>
                    </h5>
                    <div class="card-text">
                        <p>
                            <span class="fw-bold">Nombre: </span>
                            <span><?php echo $producto->nombre; ?></span>
                        </p>
                        <p>
                            <span class="fw-bold">Nombre corto: </span>
                            <span><?php echo $producto->nombre_corto; ?></span>
                        </p>
                        <p>
                            <span class="fw-bold">Código familia: </span>
                            <span><?php echo $producto->familia; ?></span>
                        </p>
                        <p>
                            <span class="fw-bold">PVP (€): </span>
                            <span><?php echo $producto->pvp; ?></span>
                        </p>
                        <p>
                            <span class="fw-bold">Descripción: </span>
                            <span><?php echo $producto->descripcion; ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-2 text-center">
                <form action="listado.php">
                    <input type="submit" class="btn" value="Volver">
                </form>
            </div>
        </div>
    </div>
</body>

</html>