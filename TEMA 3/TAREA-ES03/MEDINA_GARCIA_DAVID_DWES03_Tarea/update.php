<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Actualizar</title>
</head>

<body class="bg-info">
    <div class="container w-75">
        <h2 class="text-center">Modificar producto</h2>

        <!-- Incluye el archivo de conexión "conexion.php" y define mensajes de éxito y error -->
        <?php
        $successMessage = '';
        $errorMessage = 'Error al modificar el producto.';

        require_once("conexion.php");

        // Verifica si se ha proporcionado el ID y si se ha pulsado el botón de volver
        if (!isset($_GET['id']) || isset($_POST['volver'])) {
            // Redirige a la página de listado si no se proporciona el ID o se pulsa volver
            header('Location: listado.php');
            exit();
        } else {
            // Obtiene el ID del producto de la URL y consulta la información del producto
            $id = $_GET['id'];
            $sql = "SELECT * FROM productos WHERE id=$id";
            $result = $conexion->query($sql);
            $producto = $result->fetch(PDO::FETCH_OBJ);

            // Redirige a la página de listado si el producto no existe
            if ($producto == null) {
                header('Location: listado.php');
            }
        }

        // Procesa el formulario de actualización si se ha enviado
        if (isset($_POST['modificar'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $nombreCorto = $_POST['nombre-corto'];
            $precio = $_POST['precio'];
            $familia = $_POST['familia'];
            $descripcion = $_POST['descripcion'];

            // Actualiza los datos del producto en la base de datos
            $sql = "UPDATE PRODUCTOS SET nombre = '$nombre', nombre_corto = '$nombreCorto', descripcion = '$descripcion', pvp = $precio, familia = '$familia' WHERE id = $id";
            $update = $conexion->query($sql);

            // Muestra el mensaje de éxito o error según el resultado de la actualización
            if ($update) {
                $successMessage = 'Producto actualizado con éxito.';
                // Actualiza los datos del producto después de la modificación
                $result = $conexion->query("SELECT * FROM productos WHERE id=$id");
                $producto = $result->fetch(PDO::FETCH_OBJ);
            } else {
                $successMessage = $errorMessage;
            }
        }
        ?>

        <!-- Muestra el mensaje de éxito si existe -->
        <?php if (!empty($successMessage)) {
            echo "<div class='alert alert-success mt-3' role='alert'>";
            echo $successMessage;
            echo "</div>";
        }

     
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $producto->id; ?>">

            <div class="row">
                <div class="col-6">
                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $producto->nombre; ?>" placeholder="Nombre">
                </div>
                <div class="col-6">
                    <label for="nombre-corto">Nombre corto</label>
                    <input class="form-control" type="text" name="nombre-corto" id="nombre-corto" value="<?php echo $producto->nombre_corto; ?>" placeholder="Nombre corto">
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-6">
                    <label for="precio">Precio</label>
                    <input class="form-control" type="number" name="precio" id="precio" value="<?php echo $producto->pvp; ?>" placeholder="Precio (€)">
                </div>
                <div class="col-6">
                    <label for="familia">Familia</label>
                    <select class="form-select" name="familia" id="familia">
                        <?php
                        // Consulta las familias de productos en la base de datos
                        $result = $conexion->query("SELECT * FROM familias");
                        // Itera sobre las filas de resultados y muestra las opciones de la lista desplegable
                        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                            // Marca la opción como seleccionada si coincide con la familia actual del producto
                            if ($row->cod == $producto->familia) {
                                echo "<option selected value='$row->cod'>$row->nombre</option>";
                            } else {
                                echo "<option value='$row->cod'>$row->nombre</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mb-2 mt-1">
            <div class="col-9">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" cols="100" rows="10"><?php echo $producto->descripcion; ?></textarea>
                </div>
            </div>

            <input type="submit" class="btn btn-primary" name="modificar" value="Modificar">
            <input type="submit" class="btn btn-secondary" name="volver" value="Volver">
        </form>
    </div>
</body>

</html>