@foreach ($query as $q)
<tr>
    <td></td>
    <td>{{ $q->nombre }} {{ $q->ap_pat }} {{ $q->ap_mat }}</td>
    <td>{{ $q->dni }}</td>
    <td>{{ $q->entidad }}</td>
    <td>{{ $q->descripcion }}</td>
    <td>
        @if (date("H:i:s", strtotime($q->fecha_biometrico)) > '07:45:00')
            <span class="label label-danger">TARDE</span>
        @else
            <span class="label label-success">EN HORA</span>
        @endif
    </td>
    <td>{{ $q->fecha_biometrico }}</td>
    <td></td>
</tr>
    
@endforeach