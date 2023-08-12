@forelse ($almacen as $a)
    <tr>
        <td>{{ $a->cod_pronsace }}</td>
        <td>{{ $a->descripcion }}</td>
        <td>{{ $a->marca }}</td>
        <td>{{ $a->modelo }}</td>
        <td>{{ $a->serie_medida }}</td>
    </tr>                            
@empty
    <tr>
        <td colspan="5"> No hay datos disponibles</td>
    </tr>
@endforelse