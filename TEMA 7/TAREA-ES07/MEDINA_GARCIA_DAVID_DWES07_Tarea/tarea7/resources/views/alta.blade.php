<!DOCTYPE html>
<html>

<head>
    <title>Insertar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-light">

    <div class="container mt-2">
        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <?php session()->forget('success'); ?>

            </div>
        @endif
        <h1 class="mt-3 text-center">Insertar Alumno</h1>
        <form action="{{ route('alta.alumno') }}" method="post" class="mt-3">
            @csrf
            <fieldset class="border border-dark w-50 mx-auto mb-3 p-3 rounded">

                <div class="mb-3 ">
                    <label for="dni" class="form-label">DNI:</label>
                    <input type="text" id="dni" name="dni" class="form-control ">
                </div>
                <div class="mb-3 ">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control">
                </div>
                <div class="mb-3 ">
                    <label for="apellido1" class="form-label">Primer Apellido:</label>
                    <input type="text" id="apellido1" name="apellido1" class="form-control">
                </div>
                <div class="mb-3 ">
                    <label for="apellido2" class="form-label">Segundo Apellido:</label>
                    <input type="text" id="apellido2" name="apellido2" class="form-control">
                </div>
            </fieldset>
            <div class="mb-3 w-50 mx-auto">
                <button type="submit" class=" btn btn-success">Insertar</button>
                <a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>
            </div>
        </form>
    </div>
</body>

</html>
