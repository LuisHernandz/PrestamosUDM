<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'generos';
    protected $primaryKey = 'gen_id';
    public $timestamps = false;


    public function administadores(){
        return $this -> hasMany('App\Models\Administrador');
    }    
    
    public function bibliotecarios(){
        return $this -> hasMany('App\Models\Bibliotecario');
    }    
    
    public function alumnos(){
        return $this -> hasMany('App\Models\Alumno');
    }
}
