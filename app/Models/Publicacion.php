<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

use App\Models\User;

class Publicacion extends Model
{
    use HasFactory;

        protected $table = 'publicaciones';
    protected $primaryKey = 'id';

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


    public function usuario(){
        return $this -> belongsTo('App\Models\User');
    }
}
