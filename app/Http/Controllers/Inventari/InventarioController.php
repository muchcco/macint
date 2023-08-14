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

use App\Models\Archivoinv;
use App\Models\Asistencia;
use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Models\Personalinter;
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
        $inventario = inventario::select('id_personal' , DB::raw("COUNT(*) as cantidad"))
                            ->groupBy('id_personal');        

        $query = Personal::from('personal as p')
                            ->select(DB::raw("CONCAT(p.ap_pat,' ',p.ap_mat,', ',p.nombre) as nombreu"), 'p.dni', 'e.nombre as nom_entidad', 'i.cantidad', 'p.id' )
                            ->leftJoinSub($inventario, 'i', function($join) {
                                    $join->on('p.id', '=', 'i.id_personal');
                                })
                            ->join('entidad as e', 'p.entidad', '=', 'e.id')
                            ->orderBy('e.nombre', 'ASC')
                            ->get();
                
        // dd($query);
        $view = view('inventario.tablas.tb_inventario', compact('query'))->render();

        return response()->json(['html' => $view]);
    }

    public function asignacion_inventario(Request $request, $id)
    {   
        $personal = Personal::select(DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"),'personal.sexo', 'personal.id', 'personal.telefono', 'entidad.nombre', 'personal.ap_pat', 'personal.nombre as nombre_p')
                            ->join('entidad', 'entidad.id', '=', 'personal.entidad')->where('personal.id', $id)->first();

        $count = Inventario::where('id_personal', $id)->count();

        $archivo_ent = Archivoinv::where('id_persona', $id)->where('corr_archivo', 1)->get();

        $per_inter = Personalinter::where('id_personal', $id)->first();

        $inventario_almacen = DB::select("SELECT GROUP_CONCAT(id_almacen SEPARATOR ', ') 'nombres' FROM inventario");

        foreach($inventario_almacen as $s)
        {
            $sss = $s->nombres;
        }

        // dd($sss);

        if($sss == NULL)
        {
            $almacen = Almacen::get();
        }
        else
        {
            $almacen = DB::select("SELECT * FROM `almacen` WHERE `id` NOT IN (".$sss.")");
        }
        // dd($almacen);

        return view('inventario.asignacion_inventario', compact('personal', 'almacen', 'count', 'per_inter', 'archivo_ent'));
    }

    public function tb_asig_b(Request $request)
    {
        $query = Inventario::join('almacen', 'almacen.id', '=', 'inventario.id_almacen')->select('*','inventario.id as id_inventario')->where('inventario.id_personal', $request->id)->get();

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

    public function storeproducto_ass(Request $request)
    {
        try{ 
            $validated = $request->validate([
                'id_almacen' => 'required',
            ]);

            $save = new Inventario;
            $save->id_almacen = $request->id_almacen;
            $save->id_personal = $request->id_personal;
            $save->save();

            return $save;

        } catch (\Exception $e) {
            //Si existe algún error en la Transacción
            $response_ = response()->json([
                'data' => null,
                'error' => $e->getMessage(),
                'message' => 'BAD'
            ], 400);

            return $response_;
        }
    
    }

    public function deleteproducto_ass(Request $request)
    {
        try{ 
            $delete = Inventario::where('id',  $request->id)->delete();
            return $delete;

        } catch (\Exception $e) {
            //Si existe algún error en la Transacción
            $response_ = response()->json([
                'data' => null,
                'error' => $e->getMessage(),
                'message' => 'BAD'
            ], 400);

            return $response_;
        }
    
    }

    public function md_add_observacion(Request $request)
    {
        $id = $request->id;

        $inv = Inventario::where('id', $id)->first();

        $view = view('inventario.modals.md_add_observacion', compact('id', 'inv'))->render();

        return response()->json(['html' => $view]); 
    }

    public function store_obser_ass(Request $request)
    {
        $save = Inventario::findOrFail($request->id_inventario);
        $save->observacion = $request->observacion;
        $save->save();

        return $save;
    }
}
