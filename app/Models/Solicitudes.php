<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';
    protected $primaryKey = 'sol_id';

    public function alumnos(){
        return $this -> belongsTo('App\Models\Alumno');
    }  

    public function prestamos(){
        return $this -> hasMany('App\Models\Prestamos');
    }
}
