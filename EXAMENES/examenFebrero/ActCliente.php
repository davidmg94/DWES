<?php
// Se incluye el archivo DaoClientes.php que contiene la clase DaoCliente
require_once 'DaoClientes.php';

// Se instancia un nuevo objeto DaoCliente con la base de datos 'febrero'
$dao = new DaoCliente('febrero');

// Se verifica si se ha enviado el formulario de actualización
if (isset($_POST['actualizar'])) {
    // Se recuperan los datos enviados por el formulario
    $nif = $_POST['nif'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $edad = $_POST['edad'];

    // Se crea un nuevo objeto Cliente con los datos recibidos
    $cliente = new Cliente($nif, $nombre, $apellido1, $apellido2, $edad);

    // Se llama al método actualizar del objeto DaoCliente para actualizar los datos del cliente en la base de datos
    $dao->actualizar($cliente);

    // Se muestra un mensaje indicando que los datos del cliente han sido actualizados
    echo "Los datos del cliente han sido actualizados.";

    // Se obtiene nuevamente el cliente actualizado de la base de datos
    $clienteObtenido = $dao->obtener($nif);

// Se verifica si se ha enviado el formulario de selección
} else if (isset($_POST['seleccionar'])) {
    // Se recupera el NIF enviado por el formulario
    $nif = $_POST['nif'];

    // Se obtiene el cliente correspondiente al NIF de la base de datos
    $clienteObtenido = $dao->obtener($nif);
}

// Se obtienen todos los clientes de la base de datos
$clientes = $dao->listar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Formulario para seleccionar un cliente -->
    <form method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
        <fieldset>
            <legend>Obtener cliente</legend>
            <!-- Dropdown para seleccionar un cliente por su NIF -->
            Cliente: <select name='nif'>
                <?php
                // Se itera sobre la lista de clientes obtenida de la base de datos
                foreach ($clientes as $cliente) {
                    // Se establece la opción seleccionada si coincide con el cliente obtenido
                    $selected = '';
                    if ($clienteObtenido !== null && $cliente->nif == $clienteObtenido->nif) {
                        $selected = 'selected';
                    }
                    // Se crea una opción en el dropdown por cada cliente
                    echo "<option value='{$cliente->nif}' {$selected}>{$cliente->apellido1} {$cliente->apellido2}, {$cliente->nombre} </option>";
                }
                ?>
            </select><br>
        </fieldset>
        <input type='submit' value='Seleccionar' name="seleccionar">
    </form>
    <br>
    <?php
    // Se verifica si se ha enviado el formulario de selección o de actualización
    if (isset($_POST['seleccionar']) || isset($_POST['actualizar'])) { ?>
        <!-- Formulario para mostrar y actualizar los datos del cliente -->
        <form method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
            <fieldset>
                <legend>Datos del cliente</legend>
                <!-- Campos de entrada para los datos del cliente -->
                NIF: <input type='text' name='nif' value='<?php echo $clienteObtenido->nif; ?>' readonly><br>
                Nombre: <input type='text' name='nombre' value='<?php echo $clienteObtenido->nombre; ?>'><br>
                Apellido1: <input type='text' name='apellido1' value='<?php echo $clienteObtenido->apellido1; ?>'><br>
                Apellido2: <input type='text' name='apellido2' value='<?php echo $clienteObtenido->apellido2; ?>'><br>
                Edad: <input type='text' name='edad' value='<?php echo $clienteObtenido->edad; ?>'><br>
            </fieldset>
            <input type='submit' value='Actualizar' name="actualizar">
        </form>
        <?php
    }
    ?>
</body>

</html>
