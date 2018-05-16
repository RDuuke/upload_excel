<?php
namespace App\Excel\Models;

class Student extends Model
{
    protected $table = "usuario";

    protected $fillable = ['usuario', 'clave', 'nombres', 'correo', 'apellidos', 'documento', 'institucion', 'genero', 'ciudad', 'departamento', 'pais', 'telefono', 'celular', 'direccion'];

    public $timestamps = false;


}