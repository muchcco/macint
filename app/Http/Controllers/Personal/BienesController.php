<?php

namespace App\Http\Controllers\Personal;

use DateTime;
use Response;


use DatePeriod;
use DateInterval;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Personal;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BienesController extends Controller
{
    public function m_bien(Request $request)
    {
        $id = auth()->user()->id;

        $usuario_p = User::join('personal', 'personal.id', '=', 'users.id_persona')->where('users.id', $id)->first();

        return view('m_bienes.m_bien', compact('usuario_p'));
    }
}
