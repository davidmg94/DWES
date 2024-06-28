<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Definición de la clase Alumno que extiende de la clase Model proporcionada por Eloquent
class Alumno extends Model
{
    // Especifica el nombre de la tabla en la base de datos asociada al modelo
    protected $table = 'alumnos';

    // Especifica los atributos del modelo que se pueden asignar masivamente
    protected $fillable = ['dni', 'nombre', 'apellido1', 'apellido2'];

    // Especifica los atributos del modelo que no se deben mostrar al serializar el objeto
    protected $hidden = [];

    // Deshabilita las marcas de tiempo de Eloquent (created_at y updated_at) para este modelo
    public $timestamps = false;
}
