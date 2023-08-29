@foreach ($query as $q)
<tr>
    <td></td>
    <td>{{ $q->nombre }} {{ $q->ap_pat }} {{ $q->ap_mat }}</td>
    <td>{{ $q->dni }}</td>
    <td>{{ $q->nombre_ent }}</td>
    <td>{{ $q->descripcion }}</td>
    <td>
        @if (date("H:i:s", strtotime($q->fecha_biometrico)) > '07:46:00')
            <span class="badge badge-danger-lighten">TARDE</span>
        @else
            <span class="badge badge-success-lighten">EN HORA</span>
        @endif
    </td>
    <td>{{ $q->fecha_biometrico }}</td>
    <td></td>
</tr>
    
@endforeach