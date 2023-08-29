<?php

namespace App\Http\Controllers\Usuarios;

use DateTime;

use Response;
use DatePeriod;

use DateInterval;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Entidad;
use App\Models\Personal;

use App\Mail\CreaUsuario;
use Illuminate\Http\Request;
use App\Models\Personalinter;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;


class UsuarioController extends Controller
{
    public function index()
    {
        // dd(User::find(1)->getRoleNames());
        return view('usuarios.index');
        
    }

    public function tb_usuarios(Request $request)
    {

        $entidad = Entidad::select('nombre as nombre_ent', 'id');

        $query = User::join('personal', 'personal.id', '=', 'users.id_persona')
                        ->leftJoinSub($entidad, 'i', function($join) {
                                $join->on('personal.entidad', '=', 'i.id');
                            })
                        ->select('*', 'users.id as id_users')
                        ->get();

        //  dd(User::find(1)->personal);

        $view = view('usuarios.tablas.tb_usuarios', compact('query'))->render();

        return response()->json(["html" => $view]);
    }

    public function md_add_usuario(Request $request)
    {
        $query = Personal::where('flag', 1)->get();

        $roles = Role::pluck('name', 'id');

        $view = view('usuarios.modals.md_add_usuario', compact('query', 'roles'))->render();

        return response()->json(["html" => $view]);
    }

    public function store_user(Request $request)
    {
        // return $request->all();
        try{
            
            $personal = Personal::where('id', $request->id_usuario)->first();

            $save = new User;
            $save->name = $personal->nombre.' '.$personal->ap_pat.' '.$personal->ap_mat;
            $save->email = $personal->dni;
            $save->id_persona = $request->id_usuario;
            $save->password = bcrypt($personal->dni);
            $save->save();

            $save->syncRoles($request->roles);

            Mail::to("kevinmuchcco@gmail.com")->send(new CreaUsuario($personal));

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
}
