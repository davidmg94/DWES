<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"]) || empty($_SESSION["usuario"])) {
    // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: login.php");
    exit; // Termina el script para evitar ejecución adicional
}
?>

<!Doctype html>
<html lang="es">

<head>
    <title>Principal</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container text-center w-25 mt-5">
        <!-- Muestra un mensaje de bienvenida al usuario -->
        <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>

        <!-- Botón para cerrar sesión -->
        <a href="logout.php">
            <button type="button" class="btn btn-outline-dark">Cerrar sesion</button>
        </a>
    </div>
</body>

</html>