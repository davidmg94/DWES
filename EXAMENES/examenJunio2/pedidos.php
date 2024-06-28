<?php
require_once ('DAOS.php');

$nameBBDD = "junio";
// Crear instancias de los DAOs
$clienteDAO = new ClienteDAO($nameBBDD);
$cocheDAO = new CocheDAO($nameBBDD);
$pedidoDAO = new PedidoDAO($nameBBDD);
$extrasDAO = new ExtraDAO($nameBBDD);

// Obtener datos de clientes y coches
$clientes = $clienteDAO->obtenerTodos();
$coches = $cocheDAO->obtenerTodos();
$extras = $extrasDAO->obtenerTodos();

// Variables para mantener la selección después de enviar el formulario
$cliente_seleccionado = isset($_POST['cliente']) ? $_POST['cliente'] : '';
$coche_seleccionado = isset($_POST['coche']) ? $_POST['coche'] : [];
$extras_seleccionados = isset($_POST['extras']) ? $_POST['extras'] : [];

// Procesar formulario si se envió
if (isset($_POST['pedir'])) {
    if (isset($_POST['cliente']) && isset($_POST['coche'])) {
        $cliente_id = $_POST['cliente'];
        $coche_id = $_POST['coche'];
        $extras_seleccionados = isset($_POST['extras']) ? $_POST['extras'] : [];

        // Insertar pedido en la base de datos
        $pedidoDAO->insertarPedido($coche_id, $cliente_id);

        // Calcular precio total
        $precio = $cocheDAO->obtenerPrecio($coche_id);
        $precio_total = $pedidoDAO->obtenerPrecioTotal($precio, $extras_seleccionados);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Página de Pedidos</title>
</head>

<body>
    <h1>Realizar Pedido</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label>Cliente:</label>
        <select name="cliente">
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['NIF']; ?>" <?php if ($cliente['NIF'] == $cliente_seleccionado)
                       echo 'selected'; ?>>
                    <?php echo $cliente['Apellido1'] . " " . $cliente['Apellido2'] . ", " . $cliente['Nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Coche:</label>
        <select name="coche">
            <?php foreach ($coches as $coche): ?>
                <option value="<?php echo $coche['Id']; ?>" <?php if ($coche['Id'] == $coche_seleccionado)
                       echo 'selected'; ?>>
                    <?php echo $coche['Marca'] . " " . $coche['Modelo']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Extras:</label><br>
        <?php foreach ($extras as $extra): ?>
            <input type="checkbox" name="extras[]" value="<?php echo $extra['Id']; ?>" <?php if (in_array($extra['Id'], $extras_seleccionados))
                   echo 'checked'; ?>>
            <?php echo $extra['Nombre']; ?><br>
        <?php endforeach; ?>

        <br><input type="submit" name="pedir" value="Pedir">
    </form>

    <?php if (isset($precio_total)): ?>
        <h2>Precio Total del Pedido:</h2>
        <p><?php echo $precio_total; ?>$</p>
    <?php endif; ?>
</body>

</html>