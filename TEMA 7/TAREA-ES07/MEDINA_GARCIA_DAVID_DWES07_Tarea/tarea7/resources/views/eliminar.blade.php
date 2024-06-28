<!DOCTYPE html>
<html>

<head>
    <title>Eliminar Alumno</title>
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
        <h1 class="mt-3 text-center">Eliminar Alumno</h1>
        <form method="GET" action="{{ route('buscar.alumno.eliminar') }}" id="buscar-form">
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
            <table class="table table-hover table-bordered  text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">DNI</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Primer Apellido</th>
                        <th scope="col">Segundo Apellido</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ strtoupper($alumno->DNI) }}</td>
                        <td>{{ strtoupper($alumno->Nombre) }}</td>
                        <td>{{ strtoupper($alumno->Apellido1) }}</td>
                        <td>{{ strtoupper($alumno->Apellido2) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="mb-3 d-inline-flex">
                <form method="POST" action="{{ route('eliminar.alumno', ['dni' => $alumno->DNI]) }}"
                    onsubmit="return confirm('¿Estás seguro de que quieres eliminar este alumno?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger me-2">Eliminar Alumno</button>
                </form>
        @endif
        <a href="{{ url('/') }}" class="btn btn-primary">Volver a Inicio</a>
    </div>
    </div>
</body>

</html>
