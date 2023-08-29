@extends('layouts.layout')

@section('estilo')
    <!-- Datatables css -->
<link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css')}}" rel="stylesheet" type="text/css" />

<style>
    .progreso-firm{
        float: right;
        /* border: 1px solid red; */
        width: 45%;
        padding-left: 28em;
    }

    

    @media (max-width: 1436px) {
        .progreso-firm{
            float: right;
            /* border: 1px solid red; */
            width: 73%;
            padding-left: 28em;
        }
    }

    @media (max-width: 1440px) {
        .progreso-firm{
            float: right;
            /* border: 1px solid red; */
            width: 73%;
            padding-left: 28em;
        }
    }

    @media (max-width: 1024px) {
        .progreso-firm{
            float: right;
            /* border: 1px solid red; */
            width: 93%;
            padding-left: 28em;
        }
    }

    
</style>

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
    table_usuarios();
});



var tabla = $("#table_usuarios").DataTable();
var table_usuarios = () => {

    $.ajax({
        type: 'GET',
        url: "{{ route('usuarios.tablas.tb_usuarios') }}" ,
        dataType: "json",
        success: function(data){
            document.getElementById("cargar-datos").style.display = 'none';
            document.getElementById("tabla_cont").style.display = 'block';
            tabla.destroy();
            $("#table_usuarios_body").html(data.html);
            tabla = $("#table_usuarios").DataTable({
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
                    { "width": "" }
                ]
            });
        },
        error: function(){
            console.log("error");
            $( "#tabla_cont" ).load(window.location.href + " #tabla_cont" ); 
            // location.reload();
        }
    });
}

var btnAddUsuario = () => {

    $.ajax({
        type:'post',
        url: "{{ route('usuarios.modals.md_add_usuario') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_user").html(data.html);
            $("#modal_add_user").modal('show');
        }
    });
}


var btnStoreUser = () => {

    
    var roles = [];
        $("[name='roles[]']:checked").each(function (i) {
        roles[i] = $(this).val();
    });
    if (roles.length === 0){ //tell you if the array is empty
        alert("Por favor seleccione un perfil");
    }
    else {
        var formData = new FormData();
        formData.append("id_usuario", $("#id_usuario").val());
        formData.append('roles', roles);            
        formData.append("_token", $("input[name=_token]").val());

        $.ajax({
            type:'post',
            url: "{{ route('usuarios.store_user') }}",
            dataType: "json",
            data:formData,
            processData: false,
            contentType: false,
            success:function(data){
                $("#modal_add_user").modal('hide');
                table_usuarios();
                Toastify({
                    text: "Se agregó exitosamente el usuario",
                    className: "info",
                    gravity: "bottom",
                    style: {
                        background: "#47B257",
                    }
                }).showToast();
            }
        });
    }
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Administrador</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </div>
            <h4 class="page-title">Usuarios del sistema</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 


<!-- end row-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Lista de usuarios registrados en el sistema  </h4>
                <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddUsuario()"> Agregar Usuario</button>
                </div>
                <br />

                <div class="col-sm-12" id="cargar-datos">
                    <i class="fa fa-spinner fa-spin"></i> Cargando tabla...  Si no carga la tabla por favor actualize la página
                </div>

                <div class="tab-content" id="tabla_cont" style="display: none">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_usuarios" class="table  dt-responsive table-hover table-bordered">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Usuario</th>
                                    <th>Entidad</th>
                                    <th>Perfil</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="table_usuarios_body">

                            </tbody>
                        </table>                                           
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
                
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


{{-- Ver Archivo --}}
<div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" ></div>

@endsection