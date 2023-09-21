@foreach ($query as $i => $q)
<tr>
    <th> {{ $i + 1 }} </th>
    <th>{{ $q->nombreu }} <a href="{{ route('asistencia.det_us', $q->n_dni) }}">(Registros completos)</a> </th>
    <th>{{ $q->n_dni }}</th>
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
        <button class="btn btn-primary btn-sm" onclick="btnModalView('{{ $q->n_dni }}', '{{ $q->fecha_asistencia }}')">Ver completo (Hoy)</button>
    </th>
</tr>
@endforeach