<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $table = 'editoriales';
    protected $primaryKey = 'edi_id';
    protected $fillable = [
        'edi_nombre',
        // Otros campos fillable si los tienes
    ];
    public $timestamps = false;

    public function libros(){
        return $this -> hasMany('App\Models\Libro');
    }
}
