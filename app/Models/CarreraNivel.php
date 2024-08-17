<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarreraNivel extends Model
{
    use HasFactory;

    protected $fillable = [
        'carreras_car_id',
        'nivel_niv_id'
        // Otros campos fillable si los tienes
    ];
    public $timestamps = false;


    public function alumnos(){
        return $this -> hasMany('App\Models\Alumno');
    }

    public function libros(){
        return $this -> hasMany('App\Models\Libro');
    }
}
