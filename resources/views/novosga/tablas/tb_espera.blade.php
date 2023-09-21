@foreach ($query as $i => $q)
    <tr>
        <th>{{ $i+1 }}</th>
        <th>
            {{ $q->hora_llegada }}
        </th>
        <th>{{ $q->Ticket }}</th>
        <th>{{ $q->Entidad }}</th>
        <th>{{ $q->Estado }}</th>
        <th>{{ $q->Ciudadano }}</th>        
        <th>{{ $q->num_docu }}</th>
    </tr>    
@endforeach