<?php
// Inicia la sesión
session_start();
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';
// Incluye los procesos para realizar las consultas y modificaciones a la base de datos
include 'control-acceso.php';

try {

    // Verifica si se ha enviado un formulario mediante el método POST
    if (isset($_POST['iniciarSesion'])) {
        // Obtiene el nombre de usuario y la contraseña del formulario
        $usuario = $_POST['usuario'];
        $clave = sha1($_POST['clave']);
        $hora = time();
        // $acceso = 'D';

        // Comprueba si el usuario está bloqueado
        if (estaBloqueado($usuario, $conexion)) {
            $_SESSION["mensajeBloqueado"] = "El usuario " . $_POST['usuario'] . " está bloqueado.";
            $intentosFallidos = intentosFallidos($usuario, $conexion);
            // header("Location: login.php");
            // exit();
        } else {

            // Realiza la consulta para verificar si el usuario y la contraseña son válidos
            if (validarCredenciales($usuario, $clave, $conexion)) {
                $_SESSION['usuario'] = $usuario;
                registrarIntentoLogin($usuario, $clave, $hora, 'C', $conexion); // 'A' de Acceso exitoso
                header("location: principal.php");
            } else {
                registrarIntentoLogin($usuario, $clave, $hora, 'D', $conexion); // 'D' de Denegado
                if (estaBloqueado($usuario, $conexion)) {
                    $_SESSION["mensajeBloqueado"] = "El usuario " . $_POST['usuario'] . " está bloqueado.";
                    $intentosFallidos = intentosFallidos($usuario, $conexion);
                }
            }

            // Registra el intento de inicio de sesión en la base de datos
            // registrarIntentoLogin($usuario, $clave, $hora, $acceso, $conexion);
        }
        // // Llamamos otra vez a la funcion para que salte el mensaje de error justo cuando se llega al limite de intentos
        // if (estaBloqueado($usuario, $conexion)) {
        //     $_SESSION["mensajeError"] = "El usuario " . $_POST['usuario'] . " está bloqueado.";
        //     $intentosFallidos = intentosFallidos($usuario, $conexion);
        // }

        // Cerrar la conexión y el statement después de su uso
        // cerrarTodo($conexion, $stmt);
    }
} catch (PDOException $e) {
    // Captura cualquier excepción PDO que pueda ocurrir
    // print_r($_SESSION["errorConexion"] = "Error de conexión a la base de datos: " . $e->getMessage());
    $_SESSION["errorConexion"] = "Error de conexión a la base de datos: " . $e->getMessage();
    // Cierra la conexión a la base de datos en caso de error
    cerrar($conexion);
}

?>

<!Doctype html>
<html lang="es">

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        fieldset {
            border-radius: 10px;
            border: 1px solid grey;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['errorConexion'])) {
        echo '<p style="color: red;">' . $_SESSION['errorConexion'] . '</p>';
        unset($_SESSION['errorConexion']);
    }
    ?>

    <div class="container w-25 mt-5 text-center">
        <form method="post">
            <legend class="fw-bold">Iniciar Sesión</legend>
            <fieldset>
                <div class="mb-3 text-start">
                    <label for="usuario" class="form-label">Nombre de usuario</label>
                    <input type="text" id="usuario" name="usuario" class="form-control">
                </div>
                <div class="mb-3 text-start">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input type="password" id="clave" name="clave" class="form-control">
                </div>
                <?php if (isset($_SESSION['mensajeError'])) { ?>
                    <p class="text-start" style="color: red;"><?php echo $_SESSION['mensajeError']; ?></p>
                    <?php unset($_SESSION['mensajeError']);
                } ?>

                <?php if (isset($_SESSION['mensajeBloqueado'])) { ?>
                    <p class="text-start" style="color: red;"><?php echo $_SESSION['mensajeBloqueado']; ?></p>
                    <?php unset($_SESSION['mensajeBloqueado']);
                } ?>
            </fieldset>
            <button type="submit" class="btn btn-primary" name="iniciarSesion">Iniciar Sesión</button>
        </form>
        <?php if (isset($intentosFallidos) && !empty($intentosFallidos)) {
            echo "<br><table  class='table table-bordered'>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Hora Intento Login</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($intentosFallidos as $intento) {
                echo "<tr>
                    <td>" . $intento['Usuario'] . "</td>
                    <td>" . date('H:i:s', $intento['Hora']) . "</td>
                  </tr>";
            }
            echo "</tbody></table>";
        } ?>
    </div>
</body>

</html>