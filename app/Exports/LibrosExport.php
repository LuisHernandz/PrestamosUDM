<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\Libro;

class LibrosExport implements FromCollection, WithHeadings, WithEvents
{
    protected $registros;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function __construct($registros)
    {
        $this->registros = $registros;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function collection()
    {
        return collect($this->registros);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [
            'Título',
            'Ejemplares',
            'Año de publicación',
            'Autor',
            'Editorial',
            'Carrera',
            'Nivel',
        ];
    }

    /** 
     * Write code on Method
     *
     * @return response()
     */

     public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Agregar título principal en la primera fila
                $event->sheet->mergeCells('A1:G1'); // Fusionar celdas para el título
                $event->sheet->setCellValue('A1', 'INVENTARIO DE LIBROS'); // Agregar título
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Ajustar la anchura de las columnas según su contenido
                $event->sheet->autoSize();

                // Mover los títulos de las columnas a la segunda fila
                $event->sheet->insertNewRowBefore(2, 1); // Agregar una fila en la posición 2 (segunda fila)
                $event->sheet->setCellValue('A2', 'Título'); // Agregar títulos de columnas en la segunda fila
                $event->sheet->setCellValue('B2', 'Ejemplares');
                $event->sheet->setCellValue('C2', 'Año de publicación');
                $event->sheet->setCellValue('D2', 'Autor');
                $event->sheet->setCellValue('E2', 'Editorial');
                $event->sheet->setCellValue('F2', 'Carrera');
                $event->sheet->setCellValue('G2', 'Nivel');

                // Aplicar estilo al título de las columnas (segunda fila)
                $titleRange = 'A2:G2';
                $event->sheet->getStyle($titleRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'B4C6E7',
                        ],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Aplicar bordes a cada fila de registro (a partir de la tercera fila)
                $dataRange = 'A3:G' . ($this->registros->count() + 2);
                $event->sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
 }
 
