<?php
namespace App\Excel\Models;

class Student_Certificate extends Model
{
    protected $table = "certificado_usuario";

    protected $fillable = ["certificado_id", "usuario_id", "estado"];

    public $timestamps = false;

}