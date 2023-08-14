@foreach ($query as $i => $q)
    <tr>
        <td>{{ $i }}</td>
        <td>M00{{ $q->cod_pronsace }}</td>
        <td>{{ $q->descripcion }}</td>
        <td>{{ $q->marca }}</td>
        <td>{{ $q->modelo }}</td>
        <td>{{ $q->serie_medida }}</td>
        <td>{{ $q->color }}</td>
        <td>{{ $q->estado }} </td>
        <td>
            @if ($q->observacion === NULL)
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#large-Modal"  onclick="btnAddObservacion('{{ $q->id_inventario }}')">Agregar observacion</button>
            @else
                <button class="nobtn" data-toggle="modal" data-target="#large-Modal"  onclick="btnAddObservacion('{{ $q->id_inventario }}')">{{ $q->observacion }}</button>
            @endif            
        </td>
        <td class="text-center">
            <button class="action-icon nobtn " data-toggle="modal" data-target="#large-Modal" onclick="btnDeleteInventario('{{ $q->id_inventario }}')"> <i class="mdi mdi-delete text-danger"></i></button>
        </td>
    </tr>
    
@endforeach