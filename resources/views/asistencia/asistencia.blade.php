@extends('layouts.layout')

@section('estilo')
    <!-- Datatables css -->
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('main')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Asistencia</a></li>
                    <li class="breadcrumb-item active">Hoy</li>
                </ol>
            </div>
            <h4 class="page-title">Asistencia</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 

<div class="row">
    <div class="col-12">
        <div class="card border-secondary border">
            <div class="card-body">
                <h5 class="card-title">Filtros de búsqueda avanzado</h5>
                
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Fecha</label>
                                <input type="date" name="fecha" id="fecha" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Entidad</label>
                                <select name="entidad" id="entidad" class="form-control">
                                    <option value="" disabled selected>-- Selecciones una opción --</option>
                                    @forelse ($entidad as $e)
                                        <option value="{{ $e->id }}">{{ $e->nombre }}</option>   
                                    @empty
                                        <option value="">No hay datos disponibles contactar con TI</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-4">
                            <div class="form-group">
                                <label for="">Estado</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="" disabled selected>-- Selecciones una opción --</option>
                                    <option value="1">EN HORA</option>
                                    <option value="2">TARDE</option>
                                </select>
                            </div>
                        </div>                       --}}
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" id="filtro" onclick="execute_filter()"><i class="mdi mdi-card-search-outline"></i> Buscar</button>
                                <button class="btn btn-dark btn-sm" id="limpiar"><i class="mdi mdi-broom"></i> Limpiar</button>
                            </div>
                        </div>
                    </div>
                    <br />
                    {{-- <div class="row">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm" id="filtro" onclick="execute_filter()">Buscar</button>
                            <button class="btn btn-dark btn-sm" id="limpiar">Limpiar</button>
                        </div>
                    </div> --}}
                               
            </div> <!-- end card-body-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Asistencia del Centro Mac - junín</h4>
                <div class="box-tools">
                    <button class="btn btn-success" data-toggle="modal" data-target="#large-Modal" onclick="btnAddAsistencia()"> Agregar Asistencia</button>
                    <a class="btn btn-info" href="{{ route('asistencia.det_entidad') }}"> Asistencia por entidad</a>
                </div>
                <br />
                <p>Horario de actualización de hora por dia: 10:00 am - 08.00 pm</p>
                <br />
                <ul class="nav nav-tabs nav-bordered mb-3">
                    <li class="nav-item">
                        <a href="#buttons-table-preview" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            
                        </a>
                    </li>
                </ul> <!-- end nav-->

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_asistencia" class="table  dt-responsive table-hover">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>DNI</th>
                                    <th>Entidad</th>
                                    <th>Centro MAC</th>
                                    <th>Status</th>
                                    <th>Fecha y Hora</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>    
                            <tbody id="table_asistencia_body">

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
    table_asistencia();
});

var tabla = $("#table_asistencia").DataTable();
var table_asistencia = ( fecha = '', entidad = '', estado = '' ) => {
    $.ajax({
        type: 'GET',
        url: "{{ route('asistencia.tablas.tb_asistencia') }}" ,
        dataType: "json",
        data: {fecha: fecha, entidad: entidad, estado: estado},
        success: function(data){
            tabla.destroy();
            $("#table_asistencia_body").html(data.html);
            tabla = $("#table_asistencia").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": true,
                language: {"url": "{{ asset('js/Spanish.json')}}"}, 
                "columns": [
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

$("#limpiar").on("click", function(e) {
    document.getElementById('fecha').value = "";
    document.getElementById('entidad').value = "";
    document.getElementById('estado').value = "";

    table_asistencia();

})

// EJECUTA LOS FILTROS Y ENVIA AL CONTROLLADOR PARA  MOSTRAR EL RESULTADO EN LA TABLA
var execute_filter = () =>{
   var fecha = $('#fecha').val();
    var entidad = $('#entidad').val();
    var estado = $('#estado').val();

    // var proc_data = "fecha="+fecha+"&entidad="+entidad+"$estado="+estado;

    // console.log(proc_data);

   $.ajax({
        type:'get',
        url: "{{ route('asistencia.tablas.tb_asistencia') }}" ,
        dataType: "json",
        data: {fecha : fecha, entidad : entidad , estado : estado},
        beforeSend: function () {
            document.getElementById("filtro").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Buscando';
            document.getElementById("filtro").style.disabled = true;
        },
        success:function(data){
            document.getElementById("filtro").innerHTML = '<i class="mdi mdi-card-search-outline"></i> Buscar';
            document.getElementById("filtro").style.disabled = false;
            table_asistencia(fecha, entidad, estado);
        }
   });
    
    // console.log('Fecha fecha: '+fecha,'Fecha Fin: ' +fechaFin,'Dependencia: ' +dependencia,'Estado: '+estado,'Usuario OEAS: '+us_oeas);
    //table_asistencia(fecha, entidad, estado);
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
    var currentDate = document.querySelector('input[id="fecha_reg"]');
    console.log(currentDate.value);
    var formData = new FormData();

    formData.append("fecha_reg", currentDate.value);
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
            table_asistencia();
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

var btnModalView = (dni, fecha) => {
    console.log(dni);
    $.ajax({
        type:'post',
        url: "{{ route('asistencia.modals.md_detalle') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}", dni_ : dni, fecha_ :fecha},
        success:function(data){
            $("#modal_add_asistencia").html(data.html);
            $("#modal_add_asistencia").modal('show');
        }
    });
}


</script>


@endsection