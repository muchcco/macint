<?php

namespace App\Http\Controllers\Asistencia;

use DateTime;

use Response;
use DatePeriod;

use DateInterval;
use Carbon\Carbon;

use App\Models\Entidad;
use App\Models\Personal;
use App\Models\Asistencia;

use Illuminate\Http\Request;
use App\Imports\AsistenciaImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AsistenciaController extends Controller
{
    public function asistencia()
    {
        return view('asistencia.asistencia');
    }

    public function tb_asistencia(Request $request)
    {
        $fecha = Carbon::now()->format('Y-m-d');  

        $query = Asistencia::join('personal', 'personal.dni', '=', 'asistencia.dni')
                            ->join('mac', 'mac.id', '=', 'asistencia.id_mac')
                            ->where('fecha', $fecha)
                            ->get();
        
        $view = view('asistencia.tablas.tb_asistencia', compact('query'))->render();

        return response()->json(['html' => $view]);
    }

    public function md_add_asistencia(Request $request)
    {
        $view = view('asistencia.modals.md_add_asistencia')->render();

        return response()->json(['html' => $view]); 
    }

    public function store_asistencia(Request $request)
    {
        $file = $request->file('txt_file');

        $fecha = Carbon::now()->format('Y-m-d');  

        $upload = Excel::import(new AsistenciaImport, $file);

        $query = DB::select("CALL add_correlativo_asistencia_fecha('".$fecha."')");

        return response()->json($upload);
    }
}
