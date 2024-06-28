<?php

use Illuminate\Support\Facades\Route;

// Ruta predeterminada para la aplicación
Route::get('/', function () {
    return view('welcome');  // Devuelve la vista "welcome"
});

// Ruta para listar todos los estudiantes
Route::get('/listar', 'App\Http\Controllers\AlumnoController@listar');

// Ruta para agregar un nuevo estudiante (solicitud GET)
Route::get('/alta', 'App\Http\Controllers\AlumnoController@showAlta');
// Ruta para agregar un nuevo estudiante (solicitud POST)
Route::post('/alta', 'App\Http\Controllers\AlumnoController@store')->name('alta.alumno');

// Ruta para actualizar la información del estudiante (solicitud GET)
Route::get('/actualizar', 'App\Http\Controllers\AlumnoController@showUpdate');
// Ruta para buscar un estudiante a actualizar (solicitud GET)
Route::get('/buscar-alumno-actualizar', 'App\Http\Controllers\AlumnoController@buscarAlumnoActualizar')->name('buscar.alumno.actualizar');
// Ruta para actualizar la información del estudiante (solicitud PUT)
Route::put('/buscar-alumno-actualizar', 'App\Http\Controllers\AlumnoController@actualizar')->name('actualizar.alumno');

// Ruta para eliminar un estudiante (solicitud GET)
Route::get('/eliminar', 'App\Http\Controllers\AlumnoController@showDelete');
// Ruta para buscar un estudiante a eliminar (solicitud GET)
Route::get('/buscar-alumno-eliminar', 'App\Http\Controllers\AlumnoController@buscarAlumnoEliminar')->name('buscar.alumno.eliminar');
// Ruta para eliminar un estudiante (solicitud DELETE)
Route::delete('/eliminar-alumno/{dni}', 'App\Http\Controllers\AlumnoController@eliminar')->name('eliminar.alumno');
