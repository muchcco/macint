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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AsistenciaExport;
use App\Imports\AsistenciaImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AsistenciaController extends Controller
{
    public function asistencia()
    {
        $entidad = Entidad::get();

        return view('asistencia.asistencia', compact('entidad'));
    }

    public function tb_asistencia(Request $request)
    {
        $fecha = Carbon::now()->format('Y-m-d');

        $entidad = Entidad::select('nombre_abrv as nombre_ent', 'id');

        $query = Asistencia::join('personal', 'personal.dni', '=', 'asistencia.dni')
                            ->join('mac', 'mac.id', '=', 'asistencia.id_mac')
                            ->leftJoinSub($entidad, 'i', function($join) {
                                $join->on('personal.entidad', '=', 'i.id');
                            })
                            ->select('*', 'asistencia.id as idAsistencia', 'asistencia.fecha as fecha_asistencia', 'personal.id as idPersonal')
                            // ->where('fecha', $fecha)
                            ->where(function($que) use ($request) {
                                $fecha_I = date("Y-m-d");
                                if($request->fecha != '' ){
                                    $que->where('fecha', $request->fecha);
                                }else{
                                    $que->where('fecha', $fecha_I);
                                }
                            })
                            // ->where('personal.entidad', '1')
                            ->where(function($que) use ($request) {
                                if($request->entidad != '' ){
                                    $que->where('personal.entidad', $request->entidad);
                                }
                            })
                            ->where('hora', '<=', '10:10:00')
                            ->get();
        // var_dump($request->all());  
        
        $view = view('asistencia.tablas.tb_asistencia', compact('query'))->render();

        return response()->json(['html' => $view]);
    }

    public function md_add_asistencia(Request $request)
    {
        $view = view('asistencia.modals.md_add_asistencia')->render();

        return response()->json(['html' => $view]); 
    }

    public function md_detalle(Request $request)
    {
        $fecha_ = $request->fecha_;
        $query = DB::select("SELECT fecha,
                                dni,
                                MAX(CASE WHEN correlativo = '1' THEN hora ELSE NULL END) AS hora1,
                                MAX(CASE WHEN correlativo = '2' THEN hora ELSE NULL END) AS hora2,
                                MAX(CASE WHEN correlativo = '3' THEN hora ELSE NULL END) AS hora3,
                                MAX(CASE WHEN correlativo = '4' THEN hora ELSE NULL END) AS hora4,
                                MAX(CASE WHEN correlativo = '5' THEN hora ELSE NULL END) AS hora5
                                FROM
                                asistencia
                                WHERE fecha = '".$fecha_."'
                                AND dni = ".$request->dni_."
                                GROUP BY
                            dni;");

        $view = view('asistencia.modals.md_detalle', compact('query', 'fecha_'))->render();

        return response()->json(['html' => $view]); 
    }

    public function store_asistencia(Request $request)
    {
        // $fecha =  date($request->fecha, strtotime(date("d-m-Y")));
        // setlocale(LC_TIME, 'es_PE', 'Spanish_Spain', 'Spanish');

        // $fecha = strftime('%d-%m-%Y',strtotime($request->fecha));

        // dd($request->fecha);

        $data = Asistencia::where('fecha', $request->fecha_reg)->count();

        // dd($data);

        if( $data > '0'){
            $eliminar = Asistencia::where('fecha', $request->fecha_reg)->delete();
        }

        $file = $request->file('txt_file');

        $fecha = $request->fecha_reg;  

        $upload = Excel::import(new AsistenciaImport, $file);

        //$query = DB::select("CALL add_correlativo_asistencia_fecha('".$fecha."')");

        $query = DB::select("UPDATE
                                        asistencia AS a
                                JOIN
                                ( SELECT ROW_NUMBER() OVER(PARTITION BY dni ORDER BY fecha, hora) AS cor, dni, id, hora, fecha
                                FROM asistencia
                                WHERE fecha = '".$fecha."'
                                ORDER BY hora ASC
                                ) AS sub
                                ON  a.id = sub.id
                                SET
                                a.correlativo = sub.cor + 0");


        return response()->json($query);
    }

    public function det_us(Request $request, $id)
    {
        $idPersonal = $id;

        $personal = Personal::where('dni', $idPersonal)->first();

        return view ('asistencia.det_us', compact('idPersonal', 'personal'));
    }

    public function tb_det_us(Request $request)
    {

        $datos_persona = Personal::join('entidad', 'entidad.id', '=', 'personal.entidad')
                                    ->select('personal.dni', DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"), 'entidad.nombre_abrv as nombre_entidad', 'personal.sexo', 'personal.telefono', 'personal.flag', 'personal.id' )
                                    ->where('dni', $request->dni)
                                    ->first();
                                    
        $query = DB::table('asistencia')
                        ->select('fecha', 'dni')
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora1', ['1'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora2', ['2'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora3', ['3'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora4', ['4'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora5', ['5'])
                        ->selectRaw('COUNT(dni) AS cn_dni')
                        ->where('dni', $request->dni)
                        ->where(function($que) use ($request) {
                            $fecha_mes_actual = Carbon::now()->format('m');
                            if($request->mes != '' ){
                                $que->where('mes', $request->mes);
                            }else{
                                $que->where('mes', $fecha_mes_actual);
                            }
                        })
                        ->where(function($que) use ($request) {
                            $fecha_año_actual = Carbon::now()->format('Y');
                            if($request->año != '' ){
                                $que->where('año', $request->año);
                            }else{
                                $que->where('año', $fecha_año_actual);
                            }
                        })
                        ->groupBy('dni', 'fecha')
                        ->orderBy('fecha', 'ASC')
                        ->get();

        $view = view('asistencia.tablas.tb_det_us', compact('query', 'datos_persona'))->render();

        return response()->json(['html' => $view]);
    }

    public function asistencia_pdf(Request $request)
    {
        // Establece la configuración regional a español
        setlocale(LC_TIME, 'es_ES', 'es_PE', 'es');

        // Crea una instancia de Carbon con el mes específico
        $fecha = Carbon::create(null, $request->mes, 1);

        // Obtiene el nombre completo del mes en español
        $nombreMES = $fecha->formatLocalized('%B');

        // dd($nombreMES);

        $datos_persona = Personal::join('entidad', 'entidad.id', '=', 'personal.entidad')
                                    ->select('personal.dni', DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"), 'entidad.nombre_abrv as nombre_entidad', 'personal.sexo', 'personal.telefono', 'personal.flag', 'personal.id' )
                                    ->where('dni', $request->dni)
                                    ->first();
        
        // dd($nombreMES);

        $query = DB::table('asistencia')
                        ->select('fecha', 'dni')
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora1', ['1'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora2', ['2'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora3', ['3'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora4', ['4'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora5', ['5'])
                        ->selectRaw('COUNT(dni) AS cn_dni')
                        ->where('dni', $request->dni)
                        ->where(function($que) use ($request) {
                            $fecha_mes_actual = Carbon::now()->format('m');
                            if($request->mes != '' ){
                                $que->where('mes', $request->mes);
                            }else{
                                $que->where('mes', $fecha_mes_actual);
                            }
                        })
                        ->where(function($que) use ($request) {
                            $fecha_año_actual = Carbon::now()->format('Y');
                            if($request->año != '' ){
                                $que->where('año', $request->año);
                            }else{
                                $que->where('año', $fecha_año_actual);
                            }
                        })
                        ->groupBy('dni', 'fecha')
                        ->orderBy('fecha', 'ASC')
                        ->get();

        $pdf = Pdf::loadView('asistencia.asistencia_pdf', compact('nombreMES', 'query', 'datos_persona'))->setPaper('a4', 'landscape');
        return $pdf->stream();

        // return view('asistencia.asistencia_pdf', compact('nombreMES', 'query', 'datos_persona'));
    }

    public function asistencia_excel(Request $request)
    {
        // Establece la configuración regional a español
        setlocale(LC_TIME, 'es_ES', 'es_PE', 'es');

        // Crea una instancia de Carbon con el mes específico
        $fecha = Carbon::create(null, $request->mes, 1);

        // Obtiene el nombre completo del mes en español
        $nombreMES = $fecha->formatLocalized('%B');

        // dd($nombreMES);

        $datos_persona = Personal::join('entidad', 'entidad.id', '=', 'personal.entidad')
                                    ->select('personal.dni', DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"), 'entidad.nombre_abrv as nombre_entidad', 'personal.sexo', 'personal.telefono', 'personal.flag', 'personal.id' )
                                    ->where('dni', $request->dni)
                                    ->first();

        $query = DB::table('asistencia')
                        ->select('fecha', 'dni')
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora1', ['1'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora2', ['2'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora3', ['3'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora4', ['4'])
                        ->selectRaw('MAX(CASE WHEN correlativo = ? THEN hora ELSE NULL END) AS hora5', ['5'])
                        ->selectRaw('COUNT(dni) AS cn_dni')
                        ->where('dni', $request->dni)
                        ->where(function($que) use ($request) {
                            $fecha_mes_actual = Carbon::now()->format('m');
                            if($request->mes != '' ){
                                $que->where('mes', $request->mes);
                            }else{
                                $que->where('mes', $fecha_mes_actual);
                            }
                        })
                        ->where(function($que) use ($request) {
                            $fecha_año_actual = Carbon::now()->format('Y');
                            if($request->año != '' ){
                                $que->where('año', $request->año);
                            }else{
                                $que->where('año', $fecha_año_actual);
                            }
                        })
                        ->groupBy('dni', 'fecha')
                        ->orderBy('fecha', 'ASC')
                        ->get();


        $export = Excel::download(new AsistenciaExport($query, $datos_persona), 'Datos.xlsx');

        return $export;
    }

}
