<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $primaryKey = 'car_id';
    protected $fillable = [
        'car_nombre',
        // Otros campos fillable si los tienes
    ];
    public $timestamps = false;


    public function niveles(){
        return $this -> belongsToMany('App\Models\Nivel');
    }
}
