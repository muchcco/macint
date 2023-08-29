@foreach ($query as $i => $q)
    <tr>
        <th>{{ $i+1 }}</th>
        <th>{{ $q->name }}</th>
        <th>{{ $q->dni }}</th>
        <th>{{ $q->nombre_ent }}</th>
        <th>{{ app\models\User::find($q->id_users)->getRoleNames()->implode(', ') }}</th>
        <th>
            @if ($q->flag == '1')
                activo
            @else
                inactivo
            @endif
        </th>        
        <th class="table-action text-center" style="width: 10px;">
            <button class="action-icon nobtn" title="Editar" data-toggle="modal" data-target="#large-Modal" onclick="btnEditUsuario('{{ $q->id }}')"> <i class="mdi mdi-pencil text-info"></i></button>
            <button class="action-icon nobtn" title="Eliminar" data-toggle="modal" data-target="#large-Modal" onclick="btnDeleteUsuario('{{ $q->id }}')"> <i class="mdi mdi-delete text-danger"></i></button>
        </th>
    </tr>
    
@endforeach