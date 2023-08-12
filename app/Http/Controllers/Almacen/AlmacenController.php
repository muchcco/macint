<?php

namespace App\Http\Controllers\Almacen;

use DateTime;

use Response;
use DatePeriod;

use DateInterval;
use Carbon\Carbon;

use App\Models\Almacen;
use App\Models\Entidad;
use App\Models\Personal;

use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Imports\AsistenciaImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AlmacenController extends Controller
{
    public function almacen()
    {
        return view('almacen.almacen');
    }

    public function tb_almacen(Request $request)
    {
        $query = Almacen::get();

        $view = view('almacen.tablas.tb_almacen', compact('query'))->render();

        return response()->json(['html' => $view]);
    }
}
