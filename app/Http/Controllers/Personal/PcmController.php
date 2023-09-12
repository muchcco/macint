<?php

namespace App\Http\Controllers\Personal;
use DateTime;

use Response;
use DatePeriod;

use DateInterval;
use Carbon\Carbon;

use App\Models\Entidad;
use App\Models\Personal;
use Illuminate\Http\Request;

use App\Models\Personalinter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PcmController extends Controller
{
    public function pcm()
    {
        return view('personal.pcm');
    }

    public function tb_pcm(Request $request)
    {
        $query = Personal::join('entidad', 'entidad.id', '=', 'personal.entidad')
                            ->select('personal.dni', DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"), 'entidad.nombre_abrv as nombre_entidad', 'personal.sexo', 'personal.telefono', 'personal.flag', 'personal.id' )
                            ->where('externo' , '0')
                            ->orderBy('nombre_entidad', 'ASC')
                            ->get();

        $view = view('personal.tablas.tb_pcm', compact('query'))->render();

        return response()->json(['html' => $view]);
    }
}
