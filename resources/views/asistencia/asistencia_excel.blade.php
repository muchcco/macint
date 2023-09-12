
        <table class="table table-bor">
            <thead style="background: #3D61B2; color:#fff;">
                <tr>
                    <th rowspan="2">N°</th>
                    <th rowspan="2">Entidad</th>
                    <th rowspan="2">Nombres y Apellidos</th>
                    <th rowspan="2">Cargo / Asesor(a)</th>
                    <th rowspan="2">DNI</th>
                    <th rowspan="2">Fecha</th>
                    <th rowspan="2">Hora de <br />Ingreso</th>
                    <th colspan="2" class="text-center">Refrigerio</th>
                    <th rowspan="2">Hora de <br />Salida</th>
                    <th rowspan="2">Salida <br />programado</th>
                    <th rowspan="2">Ingreso <br />Programada</th>
                    <th rowspan="2">Observación</th>
                </tr>
                <tr>
                    <th class="text-center">Salida</th>
                    <th class="text-center">Ingreso</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($query as $i => $q)
                    @php
                        $hora1 = strtotime($q->hora1); // Convierte la hora1 a un timestamp
                        $horaInicial1 = strtotime('06:00:00');
                        $horaFinal1 = strtotime('10:00:00');
                    @endphp
                    <tr>
                        <th>{{ $i + 1 }}</th>
                        <th>{{ $datos_persona->nombre_entidad }}</th>
                        <th>{{ $datos_persona->nombreu }}</th>
                        <th>Asesor de Servicio</th>
                        <th>{{ $datos_persona->dni }}</th>
                        <th>{{ date("d/m/Y", strtotime($q->fecha)) }}  </th>
                        @if($q->cn_dni > '2' )
                            <th>
                                {{-- @if ($hora1 >= $horaInicial1 && $hora1 <= $horaFinal1)
                                    {{ $q->hora1 }}
                                @endif --}}
                                {{$q->hora1}}
                            </th>
                            <th>
                                {{ $q->hora2 }}
                            </th>
                            <th>
                                {{ $q->hora3 }}
                            </th>
                            <th>
                                {{ $q->hora4 }}
                            </th>
                            <th>08:15 am</th>
                            <th>06.30 pm</th>
                            <th>
                                <?php setlocale(LC_TIME, 'es_PE', 'es_ES', 'es'); $fecha = utf8_decode(strftime('%A',strtotime($q->fecha)));  ?>

                                @if ($fecha == 's?bado')
                                    Sábado
                                @else

                                @endif

                            </th>
                        @elseif($q->cn_dni == '2' )
                            <th>
                                {{-- @if ($hora1 >= $horaInicial1 && $hora1 <= $horaFinal1)
                                    {{ $q->hora1 }}
                                @endif --}}
                                {{$q->hora1}}
                            </th>
                            <th>
                                --
                            </th>
                            <th>
                                --
                            </th>
                            <th>
                                {{ $q->hora2 }}
                            </th>
                            <th>08:15 am</th>
                            <th>06.30 pm</th>
                            <th>
                                <?php setlocale(LC_TIME, 'es_PE', 'es_ES', 'es'); $fecha = utf8_decode(strftime('%A',strtotime($q->fecha)));  ?>

                                @if ($fecha == 's?bado')
                                    Sábado
                                @else

                                @endif

                            </th>
                            @elseif($q->cn_dni == '1' )
                            <th>
                                {{-- @if ($hora1 >= $horaInicial1 && $hora1 <= $horaFinal1)
                                    {{ $q->hora1 }}
                                @endif --}}
                                {{$q->hora1}}
                            </th>
                            <th>
                                --
                            </th>
                            <th>
                                --
                            </th>
                            <th>
                                --
                            </th>
                            <th>08:15 am</th>
                            <th>06.30 pm</th>
                            <th>
                                <?php setlocale(LC_TIME, 'es_PE', 'es_ES', 'es'); $fecha = utf8_decode(strftime('%A',strtotime($q->fecha)));  ?>

                                @if ($fecha == 's?bado')
                                    Sábado
                                @else

                                @endif

                            </th>
                        @endif
                        
                    </tr>    
                @endforeach
            </tbody>
    
        </table>

