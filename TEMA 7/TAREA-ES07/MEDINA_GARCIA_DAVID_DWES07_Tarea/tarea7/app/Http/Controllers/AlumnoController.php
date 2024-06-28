<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;

class AlumnoController extends Controller {

    // Método para mostrar todos los alumnos
    public function listar() {
        // Obtener todos los registros de alumnos de la base de datos
        $alumnos = Alumno::all();
        // Retornar la vista 'listar' con los alumnos obtenidos
        return view('listar', ['alumnos' => $alumnos]);
    }

    // Método para mostrar el formulario de alta de alumno
    public function showAlta() {
        // Retornar la vista 'alta' para crear un nuevo alumno
        return view('alta');
    }

    // Método para almacenar un nuevo alumno en la base de datos
    public function store(Request $request) {
        // Crear una nueva instancia de Alumno
        $alumno = new Alumno;
        // Asignar los valores del formulario a los atributos del alumno
        $alumno->DNI = $request->dni;
        $alumno->Nombre = $request->nombre;
        $alumno->Apellido1 = $request->apellido1;
        $alumno->Apellido2 = $request->apellido2;
        // Guardar el alumno en la base de datos
        $alumno->save();
        // Redirigir de vuelta al formulario de alta con un mensaje de éxito
        return redirect()->back()->with('success', 'Alumno insertado con éxito.');
    }

    // Método para mostrar el formulario de actualización de alumno
    public function showUpdate() {
        // Retornar la vista 'actualizar' para buscar un alumno a actualizar
        return view('actualizar');
    }

    // Método para buscar un alumno a actualizar y mostrar su información en el formulario
    public function buscarAlumnoActualizar(Request $request) {

        // Obtener el DNI del formulario de búsqueda
        $dni = $request->input('dni_buscar');
        // Buscar el alumno en la base de datos por su DNI
        $alumno = Alumno::where('DNI', $dni)->first();
        // Si se encuentra el alumno, mostrar la vista 'actualizar' con la información del alumno
        if ($alumno) {
            // Almacena el dni del alumno buscado en una variable de sesion
            session(['alumnoBuscado' => $alumno->DNI]);
            // Mostrar la vista 'actualizar' con la información del alumno
            return view('actualizar', ['alumno' => $alumno]);
        } else {
            // Si no se encuentra el alumno, redirigir de vuelta con un mensaje de error
            return redirect()->back()->with('error', 'El alumno no existe.');
        }
    }

    // Método para actualizar los datos de un alumno en la base de datos
    public function actualizar(Request $request) {
        // Obtener el DNI de la variable de sesion (alumno buscado)
        $dni = session('alumnoBuscado');

        // Actualiza los datos del alumno con el dni buscado en la base de datos
        Alumno::where('DNI', $dni)
            ->update([
                'DNI' => $request->input('dni'),
                'Nombre' => $request->input('nombre'),
                'Apellido1' => $request->input('apellido1'),
                'Apellido2' => $request->input('apellido2')
            ]);
        // Redirigir de vuelta con un mensaje de éxito
        $request->session()->flash('success', 'Alumno actualizado con éxito');
        return view('actualizar');
    }

    // Método para mostrar el formulario de eliminación de alumno
    public function showDelete() {
        // Retornar la vista 'eliminar' para buscar un alumno a eliminar
        return view('eliminar');
    }

    // Método para buscar un alumno a eliminar y mostrar su información en el formulario
    public function buscarAlumnoEliminar(Request $request) {
        // Obtener el DNI del formulario de búsqueda
        $dni = $request->input('dni_buscar');
        // Buscar el alumno en la base de datos por su DNI
        $alumno = Alumno::where('DNI', $dni)->first();
        // Si se encuentra el alumno, mostrar la vista 'eliminar' con la información del alumno
        if ($alumno) {
            return view('eliminar', ['alumno' => $alumno]);
        } else {
            // Si no se encuentra el alumno, redirigir de vuelta con un mensaje de error
            return redirect()->back()->with('error', 'El alumno no existe.');
        }
    }

    // Método para eliminar un alumno de la base de datos
    public function eliminar($dni) {
        // Eliminar el alumno de la base de datos
        $alumno = Alumno::where('DNI', $dni)->delete();
        // Redirigir a la página de eliminación con un mensaje de éxito
        return redirect('/eliminar')->with('success', 'El alumno ha sido eliminado exitosamente');
    }
}
