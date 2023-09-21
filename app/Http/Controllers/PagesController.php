<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {   

        // Configura la configuración regional en español
        setlocale(LC_TIME, 'es_ES');
        Carbon::setLocale('es');

        $personal = Personal::select(DB::raw('CONCAT(personal.nombre, " ", personal.ap_pat, " ", personal.ap_mat) AS nombreu'), 'entidad.nombre as nombre', 'personal.fech_nac')
                                ->join('entidad', 'entidad.id', '=', 'personal.entidad')
                                ->whereNotNull('personal.fech_nac')->where('personal.flag', 1)
                                ->get();

        $fecha_actual = Carbon::now();
        $proximos_cumpleaños = [];

        // Calcular la fecha límite para el próximo año
        $fecha_limite_proximo_anio = $fecha_actual->copy()->addYear()->addMonths(6);

        foreach ($personal as $persona) {
            $fecha_nacimiento = Carbon::parse($persona->fech_nac);
            $proximo_cumpleaños = $fecha_actual->copy()->year($fecha_actual->year)->month($fecha_nacimiento->month)->day($fecha_nacimiento->day);

            // Compara si el próximo cumpleaños está dentro del rango actual y el próximo año
            if ($proximo_cumpleaños->gte($fecha_actual) && $proximo_cumpleaños->lte($fecha_limite_proximo_anio)) {
                // Calcula la diferencia de años, teniendo en cuenta si el cumpleaños ya ocurrió o no
                $edad = $proximo_cumpleaños->year - $fecha_nacimiento->year;

                if ($proximo_cumpleaños->lt($fecha_actual)) {
                    $edad++;
                }

                $persona->prox_cumpleanos = $proximo_cumpleaños;
                $persona->edad_proximo_cumpleanos = $edad;
                $persona->nombre_mes_proximo_cumpleanos = $proximo_cumpleaños->format('F'); // 'F' muestra el nombre completo del mes en español
                $proximos_cumpleaños[] = $persona;
            }
        }

        // Ordena la lista por la fecha de cumpleaños
        usort($proximos_cumpleaños, function ($a, $b) {
            return $a->prox_cumpleanos->gte($b->prox_cumpleanos) ? 1 : -1;
        });

        // Ahora $proximos_cumpleaños contiene la lista de personas con próximos cumpleaños en los próximos 6 meses del año actual y del próximo año
        //foreach ($proximos_cumpleaños as $persona) {
        //    echo $persona->nombre . ' cumple ' . $persona->edad_proximo_cumpleanos . ' años en ' . $persona->nombre_mes_proximo_cumpleanos . ' el día ' . $persona->prox_cumpleanos->day . '<br>';
        //}

        return view('inicio', compact('proximos_cumpleaños'));
    }

    public function capcha_reload(){

        return response()->json(['captcha_img1' => captcha_img()]);

    }
}