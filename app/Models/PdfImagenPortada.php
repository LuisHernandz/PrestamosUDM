<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfImagenPortada extends Model
{
    use HasFactory;
    protected $table = 'pdf_imagen_portada';
    protected $primaryKey = 'id'; 
}
