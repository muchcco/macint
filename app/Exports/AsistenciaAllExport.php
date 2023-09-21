<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class AsistenciaAllExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        // dd($this->query);

        return collect($this->query)->map(function ($row) {
            return [
                $row->id,           
                $row->dni,        
                $row->año,         
                $row->mes,
                $row->fecha_biometrico,
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'DNI',
            'mes',
            'año',
            'fecha y hora',
        ];
    }

    public function store($filePath)
    {
        return $this->download($filePath); // Utilizamos el método download para generar y descargar el archivo
    }

}