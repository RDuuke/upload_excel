<?php
namespace App\Excel\Models;

class Certicifate extends Model
{
    protected $table = 'generador_certificado';

    protected $fillable = ['tipo', 'template', 'codigo','titulo', 'contenido', 'duracion', 'fecha_finalizacion'];

    public $timestamps = false;

}