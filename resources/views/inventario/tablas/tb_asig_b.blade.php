@foreach ($query as $i => $q)
    <tr>
        <td>{{ $i }}</td>
        <td>{{ $q->cod_patrimonial }}</td>
        <td>{{ $q->descripcion }}</td>
        <td>{{ $q->marca }}</td>
        <td>{{ $q->modelo }}</td>
        <td>{{ $q->serie_medida }}</td>
        <td>{{ $q->color }}</td>
        <td>{{ $q->estado }}</td>
        <td>
            @if ($q->observacion === NULL)
                <button class="btn btn-primary btn-sm" >Agregar observacion</button>
            @else
                {{ $q->observacion }}
            @endif            
        </td>
    </tr>
    
@endforeach