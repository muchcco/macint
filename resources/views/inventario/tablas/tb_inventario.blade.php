@foreach ($query as $i => $q)
    <tr>
        <td>{{ $i }}</td>
        <td>{{ $q->nombreu }}</td>
        <td>{{ $q->dni }}</td>
        <td>{{ $q->nom_entidad }}</td>
        <td>            
            @if ($q->cantidad === NULL)
                <div class="text-center text-danger"> 0</div>
            @else
                <div class="text-center "> {{ $q->cantidad }}</div>
            @endif
        </td>
        <td class="table-action">
            <a href="{{ route('inventario.asignacion_inventario', $q->id) }}" class="btn btn-info" >Asignación bienes</a>
        </td>
    </tr>
    
@endforeach