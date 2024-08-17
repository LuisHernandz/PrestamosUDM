<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfEncabezado extends Model
{
    use HasFactory; 

    protected $table = 'pdf_encabezado';
    protected $primaryKey = 'id';
}
