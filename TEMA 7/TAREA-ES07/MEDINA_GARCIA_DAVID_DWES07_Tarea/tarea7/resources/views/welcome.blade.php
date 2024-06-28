<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-light text-center">
    <div class="container mt-3 text-center">
        <h1>Gestión de Alumnos</h1>
        <div class="row mt-4 w-75 mx-auto">
            <div class="col-md-6">
                <a href="{{ url('/listar') }}" class="btn btn-info btn-lg mb-3 w-100">Listar Alumnos</a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/alta') }}" class="btn btn-success btn-lg mb-3 w-100">Insertar Alumno</a>
            </div>
        </div>
        <div class="row mt-4 w-75 mx-auto">

            <div class="col-md-6">
                <a href="{{ url('/actualizar') }}" class="btn btn-warning mb-3 btn-lg w-100">Actualizar Alumno</a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/eliminar') }}" class="btn btn-danger btn-lg  w-100">Eliminar Alumno</a>
            </div>
        </div>
    </div>
</body>

</html>
