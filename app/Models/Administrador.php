<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;
    protected $table = 'administradores';
    protected $primaryKey = 'adm_id';
    public $timestamps = false;

    public function genero(){
        return $this -> belongsTo('App\Models\Genero');
    }    
    
    public function user(){
        return $this -> belongsTo('App\Models\User');
    }
}
