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


class BienesController extends Controller
{
    public function m_bien(Request $request)
    {
        $id = auth()->user()->id;

        $count = Inventario::where('id_personal', auth()->user()->id_persona)->count();

        $usuario_p = User::join('personal', 'personal.id', '=', 'users.id_persona')->where('users.id', $id)->first();

        $entidad = Personal::join('entidad', 'entidad.id', '=', 'personal.entidad')->select('entidad.nombre as nom_ent')->where('personal.id', $usuario_p->id_persona)->first();

        //calificacion de estados

        $estado = Personalinter::where('id_personal', auth()->user()->id_persona)->first();

        if( $estado == NULL){
            $est = 5;
            
        }elseif($estado->estado == '5'){
            $est = 5;
            
        }else{
            $est = $estado->estado;
        }

        //porcentaje de firmas

        if($estado->firma_tic  == '1'){
            $tic = '50';
        }else{
            $tic = '0';
        }

        if($estado->firma_cor  == '1'){
            $cor = '50';
        }else{
            $cor = '0';
        }

        $por = $cor + $tic;
        
        // dd($por);

        return view('m_bienes.m_bien', compact('usuario_p', 'entidad', 'count', 'est', 'por'));
    }

    public function tb_inv_p(Request $request)
    {
        $id = auth()->user()->id_persona;

        $query = Inventario::join('almacen', 'almacen.id', '=', 'inventario.id_almacen')->select('*','inventario.id as id_inventario')->where('inventario.id_personal', $id)->get();

        $view = view('m_bienes.tablas.tb_inv_p', compact('query'))->render();

        return response()->json(['html' => $view]);    
    }

    public function asig_bien(Request $request)
    {
        $id = auth()->user()->id_persona;

        $persona = Personalinter::where('id_personal', $id)->first();

        $val = Personalinter::where('id_personal', $id)->count();

        if($val == '0')
        {
            $save = new Personalinter;
            $save->id_personal = $id;
            $save->validez = 1;
            $save->estado =   1;
            $save->save();

        }
        else
        {
            // $save = Personalinter::findOrFail($persona->id);
            // $save->validez = 1;
            // $save->estado =  4;
            // $save->save();
            DB::table('personal_inter')
                    ->where('id_personal', $personal->id)
                    ->update([
                        'estado' => 4,
                        'validez' => 1,
                    ]);
        }

        return $save;
         
    }

    public function formt_pdf(Request $request)
    {
        $id = auth()->user()->id;

        $persona = Personalinter::where('id_personal', $id)->first();

        $personal = Personal::select(DB::raw("CONCAT(personal.ap_pat,' ',personal.ap_mat,', ',personal.nombre) as nombreu"),'personal.sexo', 'personal.id', 'personal.telefono', 'entidad.nombre', 'personal.ap_pat', 'personal.nombre as nombre_p')
                            ->join('entidad', 'entidad.id', '=', 'personal.entidad')->where('personal.id', auth()->user()->id_persona)->first();

                            

        $count = Inventario::where('id_personal', auth()->user()->id_persona)->count();

        $query = Inventario::join('almacen', 'almacen.id', '=', 'inventario.id_almacen')->select('*','inventario.id as id_inventario')->where('inventario.id_personal', auth()->user()->id_persona)->get();

        $pdf = Pdf::loadView('m_bienes.formt_pdf', compact('persona', 'personal', 'query', 'count'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function up_formato()
    {
        $view = view('m_bienes.modals.up_formato')->render();

        return response()->json(['html' => $view]); 
    }

    public function store_pdf(Request $request)
    {
        $personal = Personal::where('id', auth()->user()->id_persona)->first();

        $estructura_carp = 'archivos\\doc_pdf\\'.$personal->id;
    
        if (!file_exists($estructura_carp)) {
            mkdir($estructura_carp, 0777, true);
        }

        $save = new Archivoinv;
        $save->id_persona = auth()->user()->id_persona;
        $save->fec_entrega = carbon::now();
        $save->corr_archivo = 1;

        if($request->hasFile('pdf_file'))
        {
            $archivoPDF = $request->file('pdf_file');
            $nombrePDF = $archivoPDF->getClientOriginalName();
            // $nameruta = '/archivos/doc_pdf/'; // RUTA DONDE SE VA ALMACENAR EL DOCUMENTO PDF
            $nameruta = $estructura_carp;  // GUARDAR EN UN SERVIDOR
            $archivoPDF->move($nameruta, $nombrePDF);

            $save->nom_archivo = $nombrePDF;
            $save->ruta = $estructura_carp.'\\'.$nombrePDF;
        }

        $save->save();

        // $perint = Personalinter::findOrFail($personal->id);
        // $perint->estado = 1;
        // $perint->save();

        $perint = DB::table('personal_inter')->where('id_personal', $personal->id)->update(['estado' => 1]);

        return response()->json($save);
    }
}
