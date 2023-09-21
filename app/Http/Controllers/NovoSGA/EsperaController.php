<?php

namespace App\Http\Controllers\NovoSGA;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EsperaController extends Controller
{
    public function p_espera()
    {
        return view('novosga.p_espera');
    }

    public function tb_espera(Request $request)
    {



        $query = DB::connection('mysql2')->select('SELECT DATE(dt_cheg) Fecha,
                                                CONCAT(sigla_senha,num_senha) Ticket,
                                                ss.nome Entidad, 
                                                ss.`id`,
                                                IFNULL(ss2.nome,"No atendido") "tipo_servicio",
                                                TIME_FORMAT(IFNULL(dt_cheg,"00:00:00"),"%H:%i:%s") "hora_llegada",
                                                TIME_FORMAT(IFNULL(dt_cha,"00:00:00"),"%H:%i:%s") "hora_llamado",
                                                IFNULL(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, dt_cheg,dt_cha)),"00:00:00") "Tiempo de espera",
                                                TIME_FORMAT(IFNULL(dt_ini,"00:00:00"),"%H:%i:%s") "Hora Inicio de atencion",
                                                IFNULL(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, dt_ini,dt_fim)),"00:00:00") "Tiempo de atención",
                                                TIME_FORMAT(IFNULL(dt_fim,"00:00:00"),"%H:%i:%s") "Fin de Atención",
                                                IFNULL(SEC_TO_TIME(((TIMESTAMPDIFF(SECOND, dt_ini,dt_fim))+(TIMESTAMPDIFF(SECOND, dt_cheg,dt_cha)))),"00:00:00") "Tiempo total",
                                                IFNULL(CONCAT(uu.nome, " ", uu.sobrenome),"No Atendido") Asesor,
                                                (CASE
                                                    WHEN (att.status = 1) THEN "En espera"
                                                    WHEN (att.status = 2) THEN "Llamando"
                                                    WHEN (att.status = 3) THEN "Atención Iniciada"
                                                    WHEN (att.status = 4) THEN "Atención Cerrada"
                                                    WHEN (att.status = 5) THEN "Abandono"
                                                    WHEN (att.status = 6) THEN "Cancelado"
                                                    WHEN (att.status = 7) THEN "Error de selección"
                                                    WHEN (att.status = 8) THEN "Terminado"
                                                    ELSE att.status
                                                END) AS Estado,
                                                CONCAT(uu2.nome, " ", uu2.sobrenome) "Derivado de",
                                                att.nm_cli Ciudadano,
                                                att.ident_cli num_docu
                                            FROM atendimentos att
                                                LEFT JOIN atend_codif sss ON sss.atendimento_id = att.id
                                                LEFT JOIN servicos ss ON ss.id = att.servico_id
                                                LEFT JOIN servicos ss2 ON ss2.id = sss.servico_id
                                                LEFT JOIN usuarios uu ON uu.id = att.usuario_id
                                                LEFT JOIN usuarios uu2 ON uu2.id = att.usuario_tri_id
                                            
                                            ORDER BY att.dt_cheg DESC');

        $view = view('novosga.tablas.tb_espera', compact('query'))->render();

        return response()->json(['html' => $view]);
    }

    public function nuevo_registro(Request $request)
    {
        $response = new StreamedResponse(function () {

            $ultimaActualizacion = null;

            while (true) {
                $consulta_NOVO = DB::connection('mysql2')->select("SELECT * FROM atendimentos att WHERE att.status = 1 ORDER BY att.dt_cheg DESC LIMIT 1");
            
                $registrosActuales = json_encode($consulta_NOVO);
            
                if ($registrosActuales !== $ultimaActualizacion) {
                    echo "data: " . $registrosActuales . "\n\n";
                    ob_flush();
                    flush();
                    $ultimaActualizacion = $registrosActuales;
                }
                sleep(5); // Espera 5 segundos
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;

    }
}
