@foreach ($query as $i => $q)
<tr>
    <td>{{ $i }}</td>
    <td>{{ $q->cod_patrimonial }}</td>
    <td> M00{{ $q->cod_pronsace }}</td>
    <td>{{ $q->descripcion }}</td>
    <td>{{ $q->marca }}</td>
    <td>{{ $q->modelo }}</td>
    <td>{{ $q->serie_medida }}</td>
    <td>{{ $q->estado }}</td>
    <td></td>
</tr>
    
@endforeach