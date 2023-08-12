<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use DateTime;
use Response;
use DatePeriod;

use DateInterval;
use Carbon\Carbon;

use App\Models\Personal;

use Illuminate\Support\Facades\DB;

class AsesoresTabController extends Controller
{
    public function tb_asesores(Request $request)
    {

        $query = Personal::join('entidad', 'entidad.id', '=', 'personal.entidad')
                            ->select('personal.dni', DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"), 'entidad.nombre_abrv as nombre_entidad', 'personal.sexo', 'personal.telefono', 'personal.flag', 'personal.id' )
                            ->where('externo' , '1')
                            ->orderBy('nombre_entidad', 'ASC')
                            ->get();

        $view = view('personal.tablas.tb_asesores', compact('query'))->render();

        return response()->json(['html' => $view]);
    }
}
