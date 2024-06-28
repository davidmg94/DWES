<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Crear</title>
</head>

<body class="bg-info">
    <div class="container w-75">
        <h2 class="text-center">Crear producto</h2>

        <?php
        // Definición de mensajes de éxito y error
        $successMessage = '';
        $errorMessage = 'Error al crear el producto.';

        // Requiere el archivo de conexión "conexion.php"
        require_once("conexion.php");

        // Verifica si se ha enviado el formulario con el botón "crear"
        if (isset($_POST['crear'])) {
            // asociar el ultimo id sin que sea autoincrementado 
            // Obtener el último ID de la tabla productos 
            // $result = $conexion->query("SELECT MAX(id) as max_id FROM productos"); 
            // $maxIdRow = $result->fetch(PDO::FETCH_ASSOC); 
            // $maxId = $maxIdRow['max_id']; 
            // Calcular el nuevo ID sumando 1 al último ID 
            // $newId = $maxId + 1; 
            
            // Obtiene los datos del formulario
            $nombre = $_POST['nombre'];
            $nombreCorto = $_POST['nombre-corto'];
            $precio = $_POST['precio'];
            $familia = $_POST['familia'];
            $descripcion = $_POST['descripcion'];
            
            // Crea la consulta SQL para insertar un nuevo producto
            $sql = "INSERT INTO PRODUCTOS (nombre, nombre_corto, descripcion, pvp, familia) VALUES('$nombre', '$nombreCorto', '$descripcion', $precio, '$familia')";
           
            // sin ID autoincrementado
            // $sql = "INSERT INTO PRODUCTOS (id,nombre, nombre_corto, descripcion, pvp, familia) VALUES('$newId','$nombre', '$nombreCorto', '$descripcion', $precio, '$familia')";

            // Ejecuta la consulta mediante la conexión establecida
            $insert = $conexion->query($sql);

            // Verifica si la inserción fue exitosa y muestra el mensaje correspondiente
            if ($insert) {
                $successMessage = 'Producto creado con éxito.';
            } else {
                $successMessage = $errorMessage;
            }
        } else if (isset($_POST['volver'])) {
            // Redirige a la página "listado.php" si se hace clic en el botón "volver"
            header('Location: listado.php');
            exit();
        }
        ?>

        <!-- Muestra el mensaje de éxito si existe -->
        <?php if (!empty($successMessage)) {

            echo "<div class='alert alert-success mt-3' role='alert'>$successMessage</div>";

            // Obtiene los datos del producto recién creado
            $id = $conexion->lastInsertId();
            $result = $conexion->query("SELECT * FROM PRODUCTOS WHERE id=$id");
            $nuevoProducto = $result->fetch(PDO::FETCH_OBJ);
            // Muestra los detalles del producto recién creado
            echo "<div class='alert alert-info mt-3' role='alert'>";
            echo "<h5>Datos del nuevo producto:</h5>";
            echo "<p class='mb-1'><span class='fw-bold'>ID: </span><span>{$nuevoProducto->id}</span></p>";
            echo "<p class='mb-1'><span class='fw-bold'>Nombre: </span><span>{$nuevoProducto->nombre}</span></p>";
            echo "<p class='mb-1'><span class='fw-bold'>Nombre corto: </span><span>{$nuevoProducto->nombre_corto}</span></p>";
            echo "<p class='mb-1'><span class='fw-bold'>Código familia: </span><span>{$nuevoProducto->familia}</span></p>";
            echo "<p class='mb-1'><span class='fw-bold'>PVP (€): </span><span>{$nuevoProducto->pvp}</span></p>";
            echo "<p class='mb-1'><span class='fw-bold'>Descripción: </span><span>{$nuevoProducto->descripcion}</span></p>";
            echo "</div>";
        }
        ?>

        <form method="post">
            <div class="row">
                <div class="col-6">
                    <label for="nombre">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre">
                </div>
                <div class="col-6">
                    <label for="nombre-corto">Nombre corto</label>
                    <input class="form-control" type="text" name="nombre-corto" id="nombre-corto" placeholder="Nombre corto">
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-6">
                    <label for="precio">Precio</label>
                    <input class="form-control" type="number" name="precio" id="precio" step="0.01" placeholder="Precio (€)">
                </div>
                <div class="col-6">
                    <label for="familia">Familia</label>
                    <!-- Selección de familia utilizando un menú desplegable -->
                    <select class="form-select" name="familia" id="familia">
                        <?php
                        // Consulta las familias disponibles en la base de datos
                        $result = $conexion->query("SELECT * FROM familias");

                        // Muestra las opciones en el menú desplegable
                        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                            echo "<option value='$row->cod'>$row->nombre</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-2 mt-1">
                <div class="col-9">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" cols="100" rows="10"></textarea>
                </div>
            </div>

            <input type="submit" class="btn btn-primary" name="crear" value="Crear">
            <input type="reset" class="btn btn-success" value="Limpiar">
            <input type="submit" class="btn btn-secondary" name="volver" value="Volver">

        </form>
    </div>
</body>

</html>