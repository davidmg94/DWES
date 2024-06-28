<?php

// Conexión a la base de datos
$db = new PDO('mysql:host=localhost;dbname=FebreroE', 'root', '');

// Obtener las familias de productos
$familias = $db->query('SELECT id, nombre FROM familias')->fetchAll(PDO::FETCH_ASSOC);

// Obtener los productos
$productos = $db->query('SELECT id, nombre_corto, precio, familia_id FROM productos')->fetchAll(PDO::FETCH_ASSOC);

// Si se ha seleccionado una familia
if (isset($_GET['familia'])) {
  $productos = array_filter($productos, function ($producto) {
    return $producto['familia_id'] == $_GET['familia'];
  });
}

// Procesar la acción de "Stock"
if (isset($_POST['stock'])) {
  $productos_seleccionados = $_POST['productos'] ?? [];
  header('Location: Consulta.php?stock=' . implode(',', $productos_seleccionados));
  exit;
}

// Procesar la acción de "Comprar"
if (isset($_POST['comprar'])) {
  $productos_seleccionados = $_POST['productos'] ?? [];
  $pedidos = [];

  foreach ($productos_seleccionados as $producto_id) {
    $producto = $db->query('SELECT id, nombre_corto, precio FROM productos WHERE id = ' . $producto_id)->fetch(PDO::FETCH_ASSOC);

    // Buscar si el producto ya está en el carrito
    $indice = array_search($producto['id'], array_column($pedidos, 'id'));

    if ($indice !== false) {
      // Incrementar la cantidad
      $pedidos[$indice]['cantidad']++;
    } else {
      // Agregar el producto al carrito
      $pedidos[] = array_merge($producto, ['cantidad' => 1]);
    }
  }

  // Guardar el pedido en el archivo
  $archivo = fopen('Pedidos.txt', 'a');

  foreach ($pedidos as $pedido) {
    fwrite($archivo, $pedido['id'] . ' ' . $pedido['nombre_corto'] . ' ' . $pedido['precio'] . ' ' . $pedido['cantidad'] . PHP_EOL);
  }

  fclose($archivo);

  header('Location: Consulta.php?compra_realizada');
  exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consulta de productos</title>
</head>
<body>

  <h1>Consulta de productos</h1>

  <form action="Consulta.php" method="get">
    <select name="familia">
      <option value="">Todas las familias</option>
      <?php foreach ($familias as $familia) : ?>
        <option value="<?php echo $familia['id']; ?>"><?php echo $familia['nombre']; ?></option>
      <?php endforeach; ?>
    </select>
    <input type="submit" value="Filtrar">
  </form>

  <table>
    <thead>
      <tr>
        <th></th>
        <th>Nombre</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $producto) : ?>
        <tr>
          <td><input type="checkbox" name="productos[]" value="<?php echo $producto['id']; ?>"></td>
          <td><?php echo $producto['nombre_corto']; ?></td>
          <td><?php echo $producto['precio']; ?>€</td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <form action="Consulta.php" method="post">
    <input type="hidden" name="stock" value="1">
    <input type="submit" value="Stock">
  </form>

  <form action="Consulta.php" method="post">
    <input type="hidden" name="comprar" value="1">
    <input type="submit" value="Comprar">
  </form>

  <?php if (isset($_GET['stock'])) : ?>
    <h2>Stock de productos</h2>

    <table>
      <thead>
        <tr>
