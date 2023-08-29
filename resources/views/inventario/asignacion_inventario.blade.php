@extends('layouts.layout')

@section('estilo')
    <!-- Datatables css -->
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css')}}" rel="stylesheet" type="text/css" />



@endsection

@section('script')
    <!-- Datatables js -->
<script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js')}}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/buttons.html5.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/buttons.flash.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/buttons.print.min.js')}}"></script>

<!-- script init -->

<script>

$(document).ready(function() {
    table_inventario();
    actualizar();
    $('#id_almacen').select2({
        width: '50 !important'
    });
});

var actualizar = () => {
    $('#count_inv').val();
}

var tabla = $("#table_inventario").DataTable();
var table_inventario = () => {

    var id = "{{ $personal->id }}";

    console.log(id);

    $.ajax({
        type: 'GET',
        url: "{{ route('inventario.tablas.tb_asig_b') }}" ,
        dataType: "json",
        data:{id:id},
        success: function(data){
            tabla.destroy();
            $("#table_inventario_body").html(data.html);
            tabla = $("#table_inventario").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": false,
                language: {"url": "{{ asset('js/Spanish.json')}}"}, 
                "columns": [
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },
                    { "width": "" },                    
                    { "width": "" }
                ]
            });
        },
        error: function(){
            console.log("error");
            // location.reload();
        }
    });
}

var btnAddProducto = ( id ) => {

    $.ajax({
        type:'post',
        url: "{{ route('inventario.modals.md_add_producto') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_asignacion").html(data.html);
            $("#modal_add_asignacion").modal('show');
        }
    });
}


var StoreProducto = (id) => {
    var formData = new FormData();

    formData.append("id_almacen", $("#id_almacen").val());
    formData.append("id_personal", id);
    formData.append("_token", $("input[name=_token]").val());

    $.ajax({
        type:'post',
        url: "{{ route('inventario.storeproducto_ass') }}",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btn_store_producto").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando...';
            document.getElementById("btn_store_producto").disabled = true;
        },
        success:function(data){       
            $( "#count_inv" ).load(window.location.href + " #count_inv" ); 
            table_inventario();
            document.getElementById("btn_store_producto").innerHTML = 'Agregar';
            document.getElementById("btn_store_producto").disabled = false;
            actualizar();
            Toastify({
                text: "Se agregó exitosamente el registros",
                className: "info",
                gravity: "bottom",
                style: {
                    background: "#47B257",
                }
            }).showToast();
        }
    });
}


var btnDeleteInventario = (id) => {
    $.ajax({
        type:'post',
        url: "{{ route('inventario.deleteproducto_ass') }}",
        dataType: "json",        
        data:{"_token": "{{ csrf_token() }}", id:id},
        success:function(data){       
            // $( "#id_almacen" ).load(window.location.href + " #id_almacen" ); 
            $( "#count_inv" ).load(window.location.href + " #count_inv" ); 
            table_inventario();
            Toastify({
                text: "Se eliminó el registro",
                className: "warning",
                gravity: "bottom",
                style: {
                    background: "#C71717",
                }
            }).showToast();
        }
    });
}

var btnAddObservacion = (id) => {

    $.ajax({
        type:'post',
        url: "{{ route('inventario.modals.md_add_observacion') }}",
        dataType: "json",        
        data:{"_token": "{{ csrf_token() }}", id:id},
        success:function(data){       
            // $( "#id_almacen" ).load(window.location.href + " #id_almacen" ); 
            $("#modal_add_observacion").html(data.html);
            $("#modal_add_observacion").modal('show');
        }
    });

}

var btnStoreObs = () => {
    var formData = new FormData();

    formData.append("observacion", $("#observacion").val());
    formData.append("id_inventario", $("#id_inventario").val());
    formData.append("_token", $("input[name=_token]").val());

    $.ajax({
        type:'post',
        url: "{{ route('inventario.store_obser_ass') }}",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btn_store_obs").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Cargando...';
            document.getElementById("btn_store_obs").disabled = true;
        },
        success:function(data){       
            $("#modal_add_observacion").modal('hide');
            table_inventario();
            Toastify({
                text: "Se agregó exitosamente la observacion",
                className: "info",
                gravity: "bottom",
                style: {
                    background: "#47B257",
                }
            }).showToast();
        }
    });
}


</script>


@endsection

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Almacén</a></li>
                    <li class="breadcrumb-item active">Hoy</li>
                </ol>
            </div>
            <h4 class="page-title">Almacén</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 
<?php
// setlocale(LC_TIME, 'es_PE');

// date_default_timezone_set('America/Lima');
// Unix
// setlocale(LC_TIME, 'es_PE.UTF-8');
// En windows
// setlocale(LC_TIME, 'spanish');

// setlocale(LC_TIME, 'es_PE', 'Spanish_Spain', 'Spanish'); 
// $date = str_replace("/","-","08/07/2016");
// echo strftime('%d de %B de %Y',strtotime("now")); // 08 julio 2016
?>

<div class="row">
    <div class="col-xl-4 col-lg-12">
        <div class="card border-secondary border">
            <div class="card-body" style="display: flex">
                <div class="col-md-4">
                    <div class="avatar-lg">
                        <span class="avatar-title bg-warning rounded-circle">
                            {{ $personal->nombre_p[0] }} {{ $personal->ap_pat[0] }}
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <h4 class="mt-1 mb-1">{{ $personal->nombreu }}</h4>
                    <p class="font-13"> Asesor de servicio de la entidad {{ $personal->nombre }}</p>
                    <p>Estado: {{ $per_inter != null ? $per_inter->estado: 'INICIADO' }} </p>
                    <p>Aprobado por el Asesor: {{ $per_inter != null ? 'si': 'no' }}</p>
                    <p class="" id="count_inv">Total de bienes asignados: {{ $count }} </p>
            
                    
                </div>
                
                <!-- end div-->
            </div>
            <!-- end card-body-->
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-secondary border">
            <div class="card-header">
                Entrega de bienes
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre del documento</th>
                            <th>Fecha de emisión </th>
                            <th>Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($archivo_ent as $a)
                            <tr>
                                <td>{{ $a->nom_archivo }}</td>
                                <td>{{ $a->created_at }}</td>
                                <td><a href="">Dow</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-danger">El usuario no ha subido el documento firmado</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="javascript: void(0);" class="btn btn-success btn-sm">Entregar</a>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>

    <div class="col-md-4">
        <div class="card border-secondary border">
            <div class="card-header">
                Devolución de bienes
            </div>
            <div class="card-body">
                <p class="card-text">With supporting text below as a natural lead-in to
                    additional content.</p>
                <a href="javascript: void(0);" class="btn btn-danger btn-sm">Devolver</a>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Lista de bienes asignados al asesor(a) {{ $personal->nombreu }}</h4>
                {{-- <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddProducto('{{ $personal->id }}')"> Agregar Producto</button>
                </div> --}}
                <br />

                <p>Con fecha <?php setlocale(LC_TIME, 'es_PE', 'Spanish_Spain', 'Spanish'); echo strftime('%d de %B del %Y',strtotime("now"));  ?>, la {{ $personal->sexo === '1' ? 'Sr.' : 'Srta.' }}  {{ $personal->nombreu }} {{ $personal->sexo === '1' ? 'identificado' : 'identificada' }} con DNI {{ $personal->dni }}, realiza la entrega de bienes asignados para la ejecución de sus labores asignados como asesora de la MUNICIPALIDAD PROVINCIAL DE HUANCAYO en el Centro Mac Junín de la Subsecretaría de Calidad de Servicios de la Secretaría de Gestión Pública de la Presidencia del Consejo de Ministros. 
                    <br />
                    Cabe recalcar que todos los bienes asignados se encuentran en perfectas condiciones </p>
                <br />

                <form action="" class="form">
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                    <div class="form-group" id="selecet_almacen" style="display: flex">
                        <div style="width: 90%" >                        
                            <select class="form-select" id="id_almacen" name="id_almacen" aria-label="Example select with button addon" >
                                <option selected="" disabled>-- Seleccionar --</option>
                                @forelse ($almacen as $a)
                                    <option value="{{ $a->id }}">{{ $a->cod_patrimonial }} - {{ $a->cod_pronsace }} - {{ $a->descripcion }}</option>
                                @empty
                                    
                                @endforelse
                            </select>                        
                        </div>
                        <button class="btn btn-primary" type="button" id="btn_store_producto" onclick="StoreProducto('{{ $personal->id }}')" >Agregar</button>
                    </div>
                    
                </form>
                <ul class="nav nav-tabs nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#buttons-table-preview" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            
                        </a>
                    </li>
                </ul> <!-- end nav-->
                

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_inventario" class="table  dt-responsive table-hover table-bordered">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Control patrimonial</th>
                                    <th>Descripcion</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie - Medida</th>
                                    <th>Color</th>
                                    <th>Estado</th>
                                    <th>Observación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="table_inventario_body">

                            </tbody>
                        </table>                                           
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
                
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->


{{-- Ver Archivo --}}
<div class="modal fade" id="modal_add_observacion" tabindex="-1" role="dialog" ></div>

@endsection