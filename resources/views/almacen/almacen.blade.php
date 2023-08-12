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
    table_almacen();
});

var tabla = $("#table_almacen").DataTable();
var table_almacen = () => {
    $.ajax({
        type: 'GET',
        url: "{{ route('almacen.tablas.tb_almacen') }}" ,
        dataType: "json",
        success: function(data){
            tabla.destroy();
            $("#table_almacen_body").html(data.html);
            tabla = $("#table_almacen").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": false,
                language: {"url": "{{ asset('js/Spanish.json')}}"}, 
                "columns": [
                    { "width": "10px" },
                    { "width": "15px" },
                    { "width": "15px" },
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

var btnAddAsistencia = () => {

    $.ajax({
        type:'post',
        url: "{{ route('asistencia.modals.md_add_asistencia') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_asistencia").html(data.html);
            $("#modal_add_asistencia").modal('show');
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
            $("#modal_add_asistencia").modal('hide');
            table_almacen();
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


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Almacén del Centro Mac - junín</h4>
                <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddAsistencia()"> Agregar Producto</button>
                </div>
                <br />
                <ul class="nav nav-tabs nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#buttons-table-preview" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            
                        </a>
                    </li>
                </ul> <!-- end nav-->

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_almacen" class="table  dt-responsive table-hover">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Codigo patrimonial</th>
                                    <th>codigo pronsace</th>
                                    <th>Descripcion</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>    
                            <tbody id="table_almacen_body">

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
<div class="modal fade" id="modal_add_asistencia" tabindex="-1" role="dialog" ></div>

@endsection