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
});

var tabla = $("#table_inventario").DataTable();
var table_inventario = () => {
    $.ajax({
        type: 'GET',
        url: "{{ route('inventario.tablas.tb_asig_b') }}" ,
        dataType: "json",
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



var btnStoreTxt = () => {
    var file_data = $("#txt_file").prop("files")[0];
    console.log(file_data);
    var formData = new FormData();

    formData.append("txt_file", file_data);
    formData.append("_token", $("input[name=_token]").val());

    $.ajax({
        type:'post',
        url: "{{ route('asistencia.store_asistencia') }}",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){        
            $("#modal_add_asignacion").modal('hide');
            table_inventario();
            Toastify({
                text: "Se agregó exitosamente los registros",
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
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Almacén del Centro Mac - junín</h4>
                <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddProducto('{{ $personal->id }}')"> Agregar Producto</button>
                </div>
                <br />

                <p>Con fecha <?php setlocale(LC_TIME, 'es_PE', 'Spanish_Spain', 'Spanish'); echo strftime('%d de %B del %Y',strtotime("now"));  ?>, la {{ $personal->sexo === '1' ? 'Sr.' : 'Srta.' }}  {{ $personal->nombre }} {{ $personal->ap_pat }} {{ $personal->ap_mat }} {{ $personal->sexo === '1' ? 'identificado' : 'identificada' }} con DNI {{ $personal->dni }}, realiza la entrega de bienes asignados para la ejecución de sus labores asignados como asesora de la MUNICIPALIDAD PROVINCIAL DE HUANCAYO en el Centro Mac Junín de la Subsecretaría de Calidad de Servicios de la Secretaría de Gestión Pública de la Presidencia del Consejo de Ministros. 
                    <br />
                    Cabe recalcar que todos los bienes asignados se encuentran en perfectas condiciones </p>
                <br />
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
<div class="modal fade" id="modal_add_asignacion" tabindex="-1" role="dialog" ></div>

@endsection