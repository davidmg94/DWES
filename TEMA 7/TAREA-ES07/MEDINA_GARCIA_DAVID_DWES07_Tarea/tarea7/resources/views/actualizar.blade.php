<!DOCTYPE html>
<html>

<head>
    <title>Actualizar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-light">

    <div class="container text-center mt-2">
        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <?php session()->forget('success'); ?>

            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <?php session()->forget('success'); ?>

            </div>
        @endif

        <h1 class="mt-3 text-center">Actualizar Alumno</h1>
        <form action="{{ route('buscar.alumno.actualizar') }}" method="GET" id="buscar-form">
            @csrf
            <fieldset class="border border-dark w-50 mx-auto mb-3 p-3 rounded text-center">
                <label for="dni_buscar" class="form-label me-2">Buscar por DNI:</label>
                <div class="d-inline-flex">
                    <input type="text" id="dni_buscar" name="dni_buscar" class="form-control me-2">
                    <button type="submit" class="btn btn-primary ms-2">Buscar</button>
                </div>
            </fieldset>
        </form>
        <!-- Si existe un alumno, mostrar el formulario de actualización -->
        @if (isset($alumno))
            <form action="{{ route('actualizar.alumno') }}" method="post" class="mt-3">
                @csrf
                @method('PUT')
                <fieldset class="border border-dark w-50 mx-auto mb-3 p-3 rounded">
                    <input type="hidden" name="dni" value="{{ $alumno->DNI ?? '' }}">
                    <div class="mb-3 text-start">
                        <label for="dni" class="form-label">DNI:</label>
                        <input type="text" id="dni" name="dni" class="form-control"
                            value="{{ $alumno->DNI ?? '' }}" >
                    </div>
                    <div class="mb-3 text-start">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            value="{{ $alumno->Nombre ?? '' }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="apellido1" class="form-label">Primer Apellido:</label>
                        <input type="text" id="apellido1" name="apellido1" class="form-control"
                            value="{{ $alumno->Apellido1 ?? '' }}">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="apellido2" class="form-label">Segundo Apellido:</label>
                        <input type="text" id="apellido2" name="apellido2" class="form-control"
                            value="{{ $alumno->Apellido2 ?? '' }}">
                    </div>
                </fieldset>
                <div>
                    <button type="submit" class="btn btn-warning me-2">Actualizar</button>
            </form>
        @endif
        <a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>
    </div>
    </div>

</body>

</html>
