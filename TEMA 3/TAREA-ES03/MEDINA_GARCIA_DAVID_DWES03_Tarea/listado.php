<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Listado</title>
</head>

<body class="bg-info">
    <div class="container">
        <h2 class="text-center">Gestión de productos</h2>

        <form action="crear.php" class="mb-1">
            <button class="btn btn-success">Crear</button>
        </form>

        <table class="table table-striped table-dark text-center">
            <thead>
                <tr>
                    <th scope="col">Detalle</th>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Requiere el archivo de conexión "conexion.php"
                require_once("conexion.php");

                // Realiza una consulta para obtener todos los productos
                $query = $conexion->query("SELECT * FROM productos");
                // Itera sobre los resultados y muestra cada producto en una fila de la tabla
                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                ?>
                    <tr>
                        <!-- Formulario y botón para redirigir a la página de detalles del producto -->
                        <td>
                            <form action="detalle.php" method="get">
                                <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                <button class="btn btn-info">Detalle</button>
                            </form>
                        </td>
                        <td>
                            <?php echo $row->id; ?>
                        </td>
                        <td>
                            <?php echo $row->nombre; ?>
                        </td>
                        <td>
                            <!-- Formulario y botón para redirigir a la página de actualización del producto -->
                            <form class="d-inline-block" action="update.php" class="mb-1" method="get">
                                <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                <button class="btn btn-warning">Actualizar</button>
                            </form>
                            <!-- Formulario y botón para borrar el producto -->
                            <form class="d-inline-block" action="borrar.php" class="mb-1" method="post" onsubmit="return confirmarBorrado()">
                                <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                                <button class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?> 
            </tbody>
        </table>
    </div>
    <script>
        // Función para mostrar un cuadro de diálogo de confirmación
        function confirmarBorrado() {
            return confirm("¿Estás seguro de que quieres borrar este producto?");
        }
    </script>
</body>

</html>