@foreach ($query as $i => $q)
<tr>
    <th> {{ $i + 1 }} </th>
    <th>{{ $q->nombre }} {{ $q->ap_pat }} {{ $q->ap_mat }} <a href="{{ route('asistencia.det_us', $q->dni) }}">(Registros completos)</a> </th>
    <th>{{ $q->dni }}</th>
    <th>{{ $q->nombre_ent }}</th>
    <th>{{ $q->descripcion }}</th>
    <th>
        @if (date("H:i:s", strtotime($q->fecha_biometrico)) > '08:16:00')
            <span class="badge badge-danger-lighten">TARDE</span>
        @else
            <span class="badge badge-success-lighten">EN HORA</span>
        @endif
    </th>
    <th>{{ $q->fecha_biometrico }}</th>
    <th>
        <button class="btn btn-primary btn-sm" onclick="btnModalView('{{ $q->dni }}', '{{ $q->fecha_asistencia }}')">Ver completo (Hoy)</button>
    </th>
</tr>
@endforeach