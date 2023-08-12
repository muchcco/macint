<?php

namespace App\Http\Controllers\Inventari;

use DateTime;

use Response;
use DatePeriod;

use DateInterval;
use Carbon\Carbon;

use App\Models\Almacen;
use App\Models\Entidad;
use App\Models\Personal;

use App\Models\Asistencia;
use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Imports\AsistenciaImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class InventarioController extends Controller
{
    public function inventario(Request $request)
    {
        return view('inventario.inventario');
    }

    public function tb_inventario(Request $request)
    {
        $inventario = inventario::select('id', 'id_personal' , DB::raw("COUNT(*) as cantidad"))
                            ->groupBy('id');

        $query = Personal::from('personal as p')
                            ->select(DB::raw("CONCAT(p.ap_pat,' ',p.ap_mat,', ',p.nombre) as nombreu"), 'p.dni', 'e.nombre as nom_entidad', 'i.cantidad', 'p.id' )
                            ->leftJoinSub($inventario, 'i', function($join) {
                                    $join->on('p.id', '=', 'i.id_personal');
                                })
                            ->join('entidad as e', 'p.entidad', '=', 'e.id')
                            ->orderBy('e.nombre', 'ASC')
                            ->get();

        $view = view('inventario.tablas.tb_inventario', compact('query'))->render();

        return response()->json(['html' => $view]);
    }

    public function asignacion_inventario(Request $request, $id)
    {   
        $personal = Personal::where('id', $id)->first();

        return view('inventario.asignacion_inventario', compact('personal'));
    }

    public function tb_asig_b(Request $request)
    {
        $query = Inventario::join('almacen', 'almacen.id', '=', 'inventario.id_almacen')->where('id_personal', $request->id_personal)->get();

        $view = view('inventario.tablas.tb_asig_b', compact('query'))->render();

        return response()->json(['html' => $view]);    
    }

    public function md_add_producto(Request $request)
    {
        $view = view('inventario.modals.md_add_producto')->render();

        return response()->json(['html' => $view]); 
    }

    public function tb_add_producto(Request $request)
    {

        $inventario_almacen = DB::select("SELECT GROUP_CONCAT(id SEPARATOR ', ') 'nombres' FROM inventario");

        foreach($inventario_almacen as $s)
        {
            $sss = $s->nombres;
        }

        if($sss == NULL)
        {
            $almacen = Almacen::where(function($query) use ($request) {
                                            if($request->cod_pronsace != '' ){
                                                $query->where('cod_pronsace', $request->cod_pronsace);
                                            }
                                        })
                                ->get();
        }
        else
        {
            $almacen = Almacen::whereNotIn('id', [ '-1', $sss])
                                ->where(function($query) use ($request) {
                                    if($request->cod_pronsace != '' ){
                                        $query->where('cod_pronsace', $request->cod_pronsace);
                                    }
                                })
                                ->get();
        }

        // dd($almacen);

        $view = view('inventario.tablas.tb_add_producto', compact('almacen'))->render();

        return response()->json(['html' => $view]); 
    }
}
