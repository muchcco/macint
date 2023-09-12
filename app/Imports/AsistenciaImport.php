<?php

namespace App\Imports;

use App\Models\Asistencia;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');

class AsistenciaImport implements  ToModel, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        $fecha = Date::excelToDateTimeObject($row[6])->format('Y-m-d');
        $hora = Date::excelToDateTimeObject($row[6])->format('H:i:s');
        $año = Date::excelToDateTimeObject($row[6])->format('Y');
        $mes = Date::excelToDateTimeObject($row[6])->format('m');
        
        // dd($hora);
        $save = new Asistencia;
        $save->tipo_entidad = $row[1];
        $save->dni = $row[2];
        $save->fecha = $fecha;
        $save->hora = $hora;
        $save->año = $año;
        $save->mes = $mes;
        $save->id_mac = $row[4];
        $save->fecha_biometrico = Date::excelToDateTimeObject($row[6]);
        $save->corr_dia = $row[0];
        $save->save();
    }

    public function batchSize(): int
    {
        return 4000;
    }

    public function chunkSize(): int
    {
        return 4000;
    }
}
