<?php

namespace App\Http\Controllers\Personal;

use DateTime;
use Response;


use DatePeriod;
use DateInterval;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Personal;

use App\Models\Archivoinv;

use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Models\Personalinter;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BandejaController extends Controller
{
    public function m_bandeja(Request $request)
    {
        // dd(Personal::find(auth()->user()->id_persona));

        return view('m_bandeja.m_bandeja');
    }

    public function tb_ban(Request $request)
    {
        $query = Personal::from('personal as p')
                            ->join('personal_inter as pt', 'pt.id_personal', '=', 'p.id')
                            ->join('entidad as e', 'e.id', '=', 'p.entidad')
                            ->select(DB::raw("CONCAT(p.ap_pat,' ',p.ap_mat,', ',p.nombre) as nombreu"), 'e.nombre', 'pt.fec_entrega', 'pt.firma_tic', 'pt.firma_cor', 'pt.validez')
                            ->where('pt.validez', 1)
                            ->get();

        $view = view('m_bandeja.tablas.tb_ban', compact('query'))->render();

        return response()->json(['html' => $view]);
    }
}
