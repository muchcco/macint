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

class AsesoresController extends Controller
{
    public function asesores(Request $request)
    {
        return view('personal.asesores');
    }

    public function md_add_asesores(Request $request)
    {
        $entidad = Entidad::get();

        $view = view('personal.modals.md_add_asesores', compact('entidad'))->render();

        return response()->json(['html' => $view]); 
    }

    public function store_asesores(Request $request)
    {
        try{
            $validated = $request->validate([
                'nombre' => 'required',
                'ap_pat' => 'required',
                'ap_mat' => 'required',
                'dni' => 'required',
                'entidad' => 'required',
                'sexo' => 'required',
                'correo' => 'required',
                'telefono' => 'required',
            ]);


            $save = new Personal;
            $save->nombre = $request->nombre;
            $save->ap_pat = $request->ap_pat;
            $save->ap_mat = $request->ap_mat;
            $save->dni = $request->dni;
            $save->entidad = $request->entidad;
            $save->sexo = $request->sexo;
            $save->correo = $request->correo;
            $save->fech_nac = $request->fech_nac;
            $save->telefono = $request->telefono;
            $save->externo = 1;
            $save->save();

            $per = new Personalinter;
            $per->id_personal = $save->id;
            $per->validez = 0;
            $per->estado = 5;
            $per->save();

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

    public function md_edit_asesores(Request $request)
    {
        $entidad = Entidad::get();

        $asesor = Personal::where('id', $request->id)->first();

        // dd($asesor);

        $view = view('personal.modals.md_edit_asesores', compact('entidad', 'asesor'))->render();

        return response()->json(['html' => $view]); 
    }

    public function update_asesores(Request $request)
    {
        try{
            $save = Personal::findOrFail($request->id);
            $save->nombre = $request->nombre;
            $save->ap_pat = $request->ap_pat;
            $save->ap_mat = $request->ap_mat;
            $save->dni = $request->dni;
            $save->entidad = $request->entidad;
            $save->sexo = $request->sexo;
            $save->correo = $request->correo;
            $save->fech_nac = $request->fech_nac;
            $save->flag = $request->flag;
            $save->telefono = $request->telefono;
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

    public function delete_asesores(Request $request)
    {
        $delete = Personal::where('id',  $request->id)->delete();
        return $delete;
    }
}
