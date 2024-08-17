<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $table = 'nivel';
    protected $primaryKey = 'niv_id';

    

    public function carreras(){
        return $this -> belongsToMany('App\Models\Carrera');
    }
}
