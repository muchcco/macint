@foreach ($query as $i => $q)
    <tr>
        <th>{{ $i+1 }}</th>
        <th>{{ $q->nombreu}}</th>
        <th>{{ $q->nombre}}</th>
        <th>{{ $q->fec_entrega}}</th>
        <th class="text-center">
            @if (auth()->user()->hasRole('Coordinador'))
                @if ($q->firma_cor == '0')
                    <button class="btn btn-info">Agregar Documento Firmado <i class="dripicons-upload"></i></button>  
                @else
                    <span>Firmado</span>
                @endif                              
            @else
                @if ($q->firma_cor == '0')
                    <span class="badge badge-danger-lighten p-2">Sin firmar</span>  
                @else
                    <span class="badge badge-success-lighten p-2">Firmado</span>
                @endif 
            @endif
        </th>
        <th class="text-center">
            @if (auth()->user()->hasRole('Especialista TIC'))
                @if ($q->firma_tic == '0')
                    <button class="btn btn-info">Agregar Documento Firmado <i class="dripicons-upload"></i></button>  
                @else
                    <span class="badge badge-success-lighten p-2">Firmado</span>  
                @endif                              
            @else
                @if ($q->firma_tic == '0')
                    <span class="badge badge-danger-lighten p-2">Sin firmar</span>  
                @else
                    <span class="badge badge-success-lighten p-2">Firmado</span>
                @endif 
            @endif          
        </th>
        <th class="text-center">
            <button class="btn btn-primary">Ver Documentos <i class="mdi mdi-arrow-collapse-down"></i></button>
        </th>
    </tr>    
@endforeach