<!doctype html>
<html lang="es">

<head>
    <title>Examen Febrero</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

<body>

    <form method="post">
        <select name="familias" id="familias">
            <?php
            require_once("conexion.php");

            $result = $conexion->query("SELECT * FROM familias");

            echo "<option selected value=''></option>";
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                echo "<option value='$row->cod'>$row->nombre</option>";
            }
            ?>
        </select>

        <input type="submit" value="mostrar" name="mostrar">
        <?php
        if (isset($_POST['mostrar'])) {
            $familia = $_POST["familias"];
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre Corto</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($familia)) {
                        $query = $conexion->query("SELECT * FROM productos");
                    } else {
                        $query = $conexion->query("SELECT * FROM productos where familia='$familia'");
                    }
                    while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $row->id; ?>" name="select[]" />
                                <input type="hidden" value="<?php echo $row->nombre_corto; ?>" name="nombreCorto[]" />
                                <input type="hidden" name="precio[]" value="<?php echo $row->pvp; ?>" />

                                <?php echo $row->nombre_corto; ?>
                            </td>
                            <td>
                                <?php echo $row->pvp; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        }
        if (isset($_POST['mostrar'])) {
            echo '<input type="submit" value="stock" name="stock"> ';
            echo '<input type="submit" value="comprar" name="comprar">';
        } ?>
        <?php
        if (isset($_POST['stock'])) {
            if (isset($_POST['select'])) {
                $productosSeleccionados = $_POST['select'];
        ?>
                <table>
                    <thead>
                        <tr>
                            <th>producto</th>
                            <th>Stock</th>
                            <th>Tienda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($productosSeleccionados as $producto) {
                            $query = $conexion->query("SELECT * FROM stocks where producto='$producto'");
                            while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                                $nombreProducto = $conexion->query("SELECT nombre_corto FROM productos WHERE id='$producto'")->fetch(PDO::FETCH_OBJ);
                                $nombreTienda = $conexion->query("SELECT nombre FROM tiendas WHERE id='$row->tienda'")->fetch(PDO::FETCH_OBJ);

                        ?>
                                <tr>
                                    <td>
                                    <?php echo $nombreProducto->nombre_corto; ?>
                                    </td>
                                    <td>
                                        <?php echo $row->unidades; ?>
                                    </td>
                                    <td>
                                    <?php echo $nombreTienda->nombre; ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
        <?php
            }
        } else if (isset($_POST['comprar'])) {
            $file = "Pedidos.txt";
            if (isset($_POST['select'])) {
                $productosSeleccionados = $_POST['select'];
                $nombres = $_POST['nombreCorto'];
                $precios = $_POST['precio'];

                foreach ($productosSeleccionados as $key => $producto) {
                    $nombre = $nombres[$key];
                    $precio = $precios[$key];

                    $query = $conexion->query("SELECT * FROM productos where id='$producto'");
                    if (!file_exists($file)) {
                        $handle = fopen($file, 'w') or die('Cannot open file: ' . $file);
                    }
                    $current = file_get_contents($file);
                    if (strpos($current, $producto) === false) {
                        $current .= "$producto $nombre $precio 1\n";
                    } else {
                        $lines = explode("\n", $current);
                        foreach ($lines as $line) {
                            $items = explode(" ", $line);
                            if ($items[0] == $producto) {
                                $items[3]++;
                                $current = str_replace($line, implode(" ", $items), $current);
                            }
                        }
                    }
                    file_put_contents($file, $current);
                }
            }
            header("Location: compraRealizada.html");
            exit();
        }
        ?>
    </form>
</body>

</html>