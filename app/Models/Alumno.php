<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function user(){
        return $this -> belongsTo('App\Models\User');
    }    
    
    public function genero(){
        return $this -> belongsTo('App\Models\Genero');
    }    
    
    public function carreraNivel(){
        return $this -> belongsTo('App\Models\CarreraNivel');
    }    
    
    public function grado(){
        return $this -> belongsTo('App\Models\Grado');
    }    
    
    public function grupo(){
        return $this -> belongsTo('App\Models\Grupo');
    }

    public function libros(){
        return $this -> belongsToMany('App\Models\Libro');
    } 

    public function solicitudes(){
        return $this -> hasMany('App\Models\Solicitudes');
    }

    public function prestamos(){
        return $this -> hasMany('App\Models\Prestamos');
    }
}
