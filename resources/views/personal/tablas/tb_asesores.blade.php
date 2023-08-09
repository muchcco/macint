@foreach ($query as $i => $q)
<tr>
    <td>{{  $i }}</td>
    <td>
        <a href="">
            {{ $q->nombreu }}
        </a>        
    </td>
    <td>{{ $q->dni }}</td>
    <td>{{ $q->nombre_entidad }}</td>
    <td>
        @if ( $q->sexo == '0')
            <span class="">Mujer</span>
        @elseif ( $q->sexo == '1')
            <span class="">Hombre</span>
        @endif
    </td>
    <td>{{ $q->telefono }}</td>
    <td class="text-center">
        @if ( $q->flag == '0')
            <span class="badge badge-danger-lighten float-start">Inactivo</span>
        @elseif ( $q->flag == '1')
            <span class="badge badge-success-lighten float-start">Activo</span>
        @endif
    </td>    
    <td class="table-action" style="width: 90px;">
        <button class="action-icon nobtn" data-toggle="modal" data-target="#large-Modal" onclick="btnEditAsesor('{{ $q->id }}')"> <i class="mdi mdi-pencil text-info"></i></button>
        <button class="action-icon nobtn" data-toggle="modal" data-target="#large-Modal" onclick="btnDeleteAsesor('{{ $q->id }}')"> <i class="mdi mdi-delete text-danger"></i></button>
    </td>
</tr>    
@endforeach