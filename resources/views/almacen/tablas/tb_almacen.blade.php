@foreach ($query as $i => $q)
<tr>
    <th>{{ $i }}</th>
    <th>{{ $q->cod_patrimonial }}</th>
    <th> M00{{ $q->cod_pronsace }}</th>
    <th>{{ $q->descripcion }}</th>
    <th>{{ $q->marca }}</th>
    <th>{{ $q->modelo }}</th>
    <th>{{ $q->serie_medida }}</th>
    <th>{{ $q->estado }}</th>
    <th>{{ $q->ubicacion }}</th>
    <th></th>
</tr>
    
@endforeach