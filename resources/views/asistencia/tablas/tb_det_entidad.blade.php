@foreach ($query as $i => $q)
    <tr>
        <th>{{ $i + 1 }}  </th>
        <th>{{ $q->nombre }}</th>
        <th>
            @php
                setlocale(LC_TIME, 'es_ES', 'es_PE', 'es');
                $mes = Carbon\Carbon::create(null, $q->mes, 1);
                $nombreMES = $mes->formatLocalized('%B');
            @endphp
            {{ $nombreMES }}
        </th>
        <th>({{ $q->cantidad_personas_presentes }}) Asesores activos</th>
        <th class="text-center">
            @if ($q->flag == '1')
                <span class="badge badge-success-lighten">ACTIVO</span>
            @elseif($q->flag == '0')
                <span class="badge badge-danger-lighten">INACTIVO</span>
            @endif
        </th>        
        <th class="text-center">
            @php
                $cantidad_personas_presentes = $q->cantidad_personas_presentes;
                $dnisPorEntidad = $q->dnisPorEntidad;
                $id = $q->id;
                $mes = $q->mes;
                $año = $q->año;
            @endphp

            <button class="btn btn-success btn-sm" onclick="ExportarZIP('{{ $cantidad_personas_presentes }}', '{{ $dnisPorEntidad }}', '{{ $id }}', '{{ $mes }}', '{{ $año }}')">
                <i class="mdi mdi-file-excel-outline"></i> Exportar
            </button>
        </th>
    </tr>    
@endforeach 