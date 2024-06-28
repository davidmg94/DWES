<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-light">
    <div class="container">

        <h1 class="text-center mt-3">Listado de Alumnos</h1>
        <a href="{{ url('/') }}" class="btn btn-primary mb-3">Volver a Inicio</a>

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
                @foreach ($alumnos as $alumno)
                    <tr>
                        <td>{{ strtoupper($alumno->DNI) }}</td>
                        <td>{{ strtoupper($alumno->Nombre) }}</td>
                        <td>{{ strtoupper($alumno->Apellido1) }}</td>
                        <td>{{ strtoupper($alumno->Apellido2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
