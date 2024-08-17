<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    use HasFactory;
    protected $table = 'prestamos';
    protected $primaryKey = 'pre_id';

    public function alumnos(){
        return $this -> belongsTo('App\Models\Alumno');
    }  

    public function libros(){
        return $this -> belongsTo('App\Models\Libro');
    }  

    public function solicitudes(){
        return $this -> belongsTo('App\Models\Solicitudes');
    }
    
}
