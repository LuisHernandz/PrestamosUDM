<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';
    protected $primaryKey = 'lib_id';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = $this->getTableColumns();
    }

    protected function getTableColumns()
    {
        $table = $this->getTable();
        $columns = Schema::getColumnListing($table);

        return $columns;
    }

    public $timestamps = false;




    public function editorial(){
        return $this -> belongsTo('App\Models\Editorial');
    }    
    
    public function tipo(){
        return $this -> belongsTo('App\Models\Tipo');
    }

    public function autores(){
        return $this -> belongsToMany('App\Models\Autor');
    }     
    
    public function alumnos(){
        return $this -> belongsToMany('App\Models\Alumno');
    } 

    public function carreraNivel(){
        return $this -> belongsToMany('App\Models\CarreraNivel');
    }

    public function prestamos(){
        return $this -> hasMany('App\Models\Prestamos');
    }
}
