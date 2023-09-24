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
    table_personal();
});

var tabla = $("#table_personal").DataTable();
var table_personal = () => {
    $.ajax({
        type: 'GET',
        url: "{{ route('personal.tablas.tb_asesores') }}" ,
        dataType: "json",
        success: function(data){
            tabla.destroy();
            $("#table_personal_body").html(data.html);
            tabla = $("#table_personal").DataTable({
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

var btnAddAsesor = () => {

    $.ajax({
        type:'post',
        url: "{{ route('personal.modals.md_add_asesores') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_asesor").html(data.html);
            $("#modal_add_asesor").modal('show');
        }
    });
}

var btnStoreAsesor = () => {

    if ($('#nombre').val() == null || $('#nombre').val() == '') {
        $('#nombre').addClass("hasError");
    } else {
        $('#nombre').removeClass("hasError");
    }
    if ($('#ap_pat').val() == null || $('#ap_pat').val() == '') {
        $('#ap_pat').addClass("hasError");
    } else {
        $('#ap_pat').removeClass("hasError");
    } 
    if ($('#ap_mat').val() == null || $('#ap_mat').val() == '') {
        $('#ap_mat').addClass("hasError");
    } else {
        $('#ap_mat').removeClass("hasError");
    } 
    if ($('#dni').val() == null || $('#dni').val() == '') {
        $('#dni').addClass("hasError");
    } else {
        $('#dni').removeClass("hasError");
    }
    if ($('#correo').val() == null || $('#correo').val() == '') {
        $('#correo').addClass("hasError");
    } else {
        $('#correo').removeClass("hasError");
    } 
    if ($('#entidad').val() == null || $('#entidad').val() == '') {
        $('#entidad').addClass("hasError");
    } else {
        $('#entidad').removeClass("hasError");
    } 
    if ($('#sexo').val() == null || $('#sexo').val() == '') {
        $('#sexo').addClass("hasError");
    } else {
        $('#sexo').removeClass("hasError");
    } 
    if ($('#telefono').val() == null || $('#telefono').val() == '') {
        $('#telefono').addClass("hasError");
    } else {
        $('#telefono').removeClass("hasError");
    } 
        
    var formData = new FormData();
    formData.append("nombre", $("#nombre").val());
    formData.append("ap_pat", $("#ap_pat").val());
    formData.append("ap_mat", $("#ap_mat").val());
    formData.append("dni", $("#dni").val());
    formData.append("entidad", $("#entidad").val());
    formData.append("sexo", $("#sexo").val());
    formData.append("fech_nac", $("#fech_nac").val());
    formData.append("correo", $("#correo").val());
    formData.append("telefono", $("#telefono").val());
    formData.append("_token", $("input[name=_token]").val());

    $.ajax({
        type:'post',
        url: "{{ route('personal.store_asesores') }}",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        },
        success:function(data){        
            $("#modal_add_asesor").modal('hide');
            table_personal();
            Toastify({
                text: "Se guardo exitosamente el registro",
                className: "info",
                gravity: "bottom",
                style: {
                    background: "#47B257",
                }
            }).showToast();
        },
        error: function(){
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        }
    });

}

var btnEditAsesor = (id) => {

    $.ajax({
        type:'post',
        url: "{{ route('personal.modals.md_edit_asesores') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}", id:id},
        success:function(data){
            $("#modal_add_asesor").html(data.html);
            $("#modal_add_asesor").modal('show');
        }
    });
}


var btnUpdateAsesor = (id) => {

    var formData = new FormData();
    formData.append("id", id);
    formData.append("nombre", $("#nombre").val());
    formData.append("ap_pat", $("#ap_pat").val());
    formData.append("ap_mat", $("#ap_mat").val());    
    formData.append("fech_nac", $("#fech_nac").val());
    formData.append("dni", $("#dni").val());
    formData.append("correo", $("#correo").val());
    formData.append("entidad", $("#entidad").val());
    formData.append("sexo", $("#sexo").val());
    formData.append("flag", $("#flag").val());
    formData.append("telefono", $("#telefono").val());
    formData.append("_token", $("input[name=_token]").val());

    $.ajax({
        type:'post',
        url: "{{ route('personal.update_asesores') }}",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        },
        success:function(data){        
            $("#modal_add_asesor").modal('hide');
            table_personal();
            Toastify({
                text: "Se edito exitosamente el registro",
                className: "info",
                gravity: "bottom",
                style: {
                    background: "#6390F8",
                }
            }).showToast();
        },
        error: function(){
            document.getElementById("btnEnviarForm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> ESPERE';
            document.getElementById("btnEnviarForm").disabled = true;
        }
    });

}

var btnDeleteAsesor = (id) => {

    swal.fire({
        title: "Seguro que desea eliminar al peronal?",
        type: "warning",
        icon: 'error',
        showCancelButton: !0,
        confirmButtonText: "Si, Elimnar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
                $.ajax({
                    url: "{{ route('personal.delete_asesores') }}",
                    type: 'post',
                    data: {_token: $('input[name=_token]').val(), id: id},
                    success: function(response){
                        table_personal();
                    }
                });
        }

    })

}

var isNumber = (evt) =>{
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
  }
  return true;
}

var isMayus = (e) => {
    e.value = e.value.toUpperCase();
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Personal</a></li>
                    <li class="breadcrumb-item active">Asesores</li>
                </ol>
            </div>
            <h4 class="page-title">Asesores</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Registro de Asesores del Centro Mac - junín</h4>
                <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddAsesor()"> Agregar</button>
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
                        <table id="table_personal" class="table  dt-responsive table-hover">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>DNI</th>
                                    <th>Entidad</th>
                                    <th>Sexo</th>
                                    <th>teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>    
                            <tbody id="table_personal_body">

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
<div class="modal fade" id="modal_add_asesor" tabindex="-1" role="dialog" ></div>

@endsection