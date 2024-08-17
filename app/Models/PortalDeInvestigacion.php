<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class PortalDeInvestigacion extends Model
{
    use HasFactory;

    protected $table = 'portal_de_investigacions';
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

    public $timestamps = false;
}
