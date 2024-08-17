<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function Backup()
    {

        $fecha = date('d-m-Y');
        $nombreArchivo = 'Biblioteca' . $fecha . '.zip';

        $comando = "php " . base_path() . "/artisan backup:run --only-db --filename=" . $nombreArchivo;
        exec($comando);

        $rutaArchivo = storage_path('app/Laravel/' . $nombreArchivo);

        return response()->download($rutaArchivo)->deleteFileAfterSend();
    }
}
