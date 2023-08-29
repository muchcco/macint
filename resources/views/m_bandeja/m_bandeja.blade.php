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
    table_inv_per();
});



var tabla = $("#table_inv_per").DataTable();
var table_inv_per = () => {

    $.ajax({
        type: 'GET',
        url: "{{ route('m_bandeja.tablas.tb_ban') }}" ,
        dataType: "json",
        success: function(data){
            document.getElementById("cargar-datos").style.display = 'none';
            document.getElementById("tabla_cont").style.display = 'block';
            tabla.destroy();
            $("#table_inv_per_body").html(data.html);
            tabla = $("#table_inv_per").DataTable({
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

var btnAsginar = () => {

    swal.fire({
        title: "Seguro que desea aceptar los bienes?. Una vez asignado ya no se puede modificar los datos",
        type: "info",
        icon: 'info',
        showCancelButton: !0,
        confirmButtonText: "Si, Asignar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.value) {
                $.ajax({
                    url: "{{ route('m_bienes.asig_bien') }}",
                    type: 'post',
                    data: {_token: $('input[name=_token]').val()},
                    beforeSend: function () {
                        document.getElementById("estados_doc").innerHTML = '<div class="text-center mt-sm-0 mt-3 text-sm-end"><i class="fa fa-spinner fa-spin"></i> ESPERE</div>';
                    },
                    success: function(response){
                        $( "#estados_doc" ).load(window.location.href + " #estados_doc" ); 
                    }
                });
        }

    })
}

var btnSendPdf = () => {

    $.ajax({
        type:'post',
        url: "{{ route('m_bienes.modals.up_formato') }}",
        dataType: "json",
        data:{"_token": "{{ csrf_token() }}"},
        success:function(data){
            $("#modal_add_pdf").html(data.html);
            $("#modal_add_pdf").modal('show');
        }
    });
}

var btnStorePdf = () => {

    var file_data = $("#pdf_file").prop("files")[0];
    console.log(file_data);
    var formData = new FormData();

    formData.append("pdf_file", file_data);
    formData.append("_token", $("input[name=_token]").val());

    $.ajax({
        type:'post',
        url: "{{ route('m_bienes.store_pdf') }}",
        dataType: "json",
        data:formData,
        processData: false,
        contentType: false,
        success:function(data){
            $("#modal_add_pdf").modal('hide');
            $( "#estados_doc" ).load(window.location.href + " #estados_doc" ); 
            Toastify({
                text: "Se guardo exitosamente el archivo",
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Mi Bandeja</a></li>
                    <li class="breadcrumb-item active">Mi Bandeja</li>
                </ol>
            </div>
            <h4 class="page-title">Perfil</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 


<!-- end row-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Mi bandeja de documentos</h4>
                {{-- <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddProducto('{{ $personal->id }}')"> Agregar Producto</button>
                </div> --}}
                <br />
                <p>Verificar los documentos adjuntos a su bandeja</p>
                

                <div class="col-sm-12" id="cargar-datos">
                    <i class="fa fa-spinner fa-spin"></i> Cargando tabla...  Si no carga la tabla por favor actualize la página
                </div>

                <div class="tab-content" id="tabla_cont" style="display: none">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_inv_per" class="table  dt-responsive table-hover table-bordered">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Apellidos y Nombres</th>
                                    <th>Entidad</th>
                                    <th>Fecha de firma</th>
                                    <th>Firma coordinador</th>
                                    <th>Firma Especialista TIC</th>
                                    <th>Firmas Adjuntas</th>
                                </tr>
                            </thead>
                            <tbody id="table_inv_per_body">

                            </tbody>
                        </table>                                           
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
                
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


{{-- Ver Archivo --}}
<div class="modal fade" id="modal_add_pdf" tabindex="-1" role="dialog" ></div>

@endsection