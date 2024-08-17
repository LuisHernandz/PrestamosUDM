<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    protected $table = 'autores';
    protected $primaryKey = 'aut_id';
    protected $fillable = [
        'aut_nombre',
        // Otros campos fillable si los tienes
    ];
    public $timestamps = false;

    public function libros(){
        return $this -> belongsToMany('App\Models\Libro');
    }
}
