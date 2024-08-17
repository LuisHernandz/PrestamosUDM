<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PdfPiePagina extends Model
{
    use HasFactory;

    protected $table = 'pdf_pie_pagina';
    protected $primaryKey = 'id';
}
