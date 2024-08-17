<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\LibrosExport;
 
use Maatwebsite\Excel\Facades\Excel;
 
use App\Models\Libro;

 
class ExcelCSVController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
       return view('excel-csv-import');
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function importExcelCSV(Request $request) 
    {
        $validatedData = $request->validate([
 
           'file' => 'required',
 
        ]); 
 
        Excel::import(new LibrosImport,$request->file('file'));
 
            
        return redirect('excel-csv-file')->with('status', 'The file has been excel/csv imported to database in Laravel 10');
    }
 
    /**
    * @return \Illuminate\Support\Collection 
    */
    public function exportExcelCSV() 
    {
        $registros = DB::table('autor_libros AS al')
        ->leftJoin('autores AS a', 'al.autores_aut_id', '=', 'a.aut_id')
        ->leftJoin('libros AS l', 'al.libros_lib_id', '=', 'l.lib_id')
        ->leftJoin('editoriales AS e', 'l.editoriales_edi_id', '=', 'e.edi_id')
        ->leftJoin('carrera_nivels AS cn', 'l.carreraNiveles_id', '=', 'cn.id')
        ->leftJoin('carreras AS c', 'cn.carreras_car_id', '=', 'c.car_id')
        ->leftJoin('nivel AS n', 'cn.nivel_niv_id', '=', 'n.niv_id')
        ->select(
            'l.lib_titulo',
            'l.lib_ejemplares',
            'l.lib_aPublicacion',
            'a.aut_nombre',
            'e.edi_nombre',
            'c.car_nombre',
            'n.niv_nombre'
        )
        ->whereNull('l.lib_archivo')
        ->get();
        
        return Excel::download(new LibrosExport($registros), 'InventarioLibros.xlsx');
    }
    
    
}