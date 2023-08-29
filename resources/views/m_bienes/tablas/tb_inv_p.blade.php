@foreach ($query as $i => $q)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>M00{{ $q->cod_pronsace }}</td>
        <td>{{ $q->descripcion }}</td>
        <td>{{ $q->marca }}</td>
        <td>{{ $q->modelo }}</td>
        <td>{{ $q->serie_medida }}</td>
        <td>{{ $q->color }}</td>
        <td>{{ $q->estado }} </td>
        <td>
            {{ $q->observacion }}           
        </td>
        <td class="text-center">
            
        </td>
    </tr>
    
@endforeach