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
        url: "{{ route('m_bienes.tablas.tb_inv_p') }}" ,
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Mis Bienes</a></li>
                    <li class="breadcrumb-item active">Mi bien</li>
                </ol>
            </div>
            <h4 class="page-title">Perfil</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 

<div class="row">
    <div class="col-sm-12">
        <!-- Profile -->
        <div class="card bg-primary">
            <div class="card-body profile-user-box">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                {{-- <div class="avatar-lg">
                                    <span class="avatar-title bg-success rounded-circle">
                                        lg
                                    </span>
                                </div> --}}
                                <img src="{{ Avatar::create(auth()->user()->name[0])->toBase64() }}" />
                            </div>
                            <div class="col">
                                <div>
                                    <h4 class="mt-1 mb-1 text-white"> {{ $usuario_p->nombre }} {{ $usuario_p->ap_pat }} {{ $usuario_p->ap_mat }} </h4>
                                    <p class="font-13 text-white-50"> {{ $entidad->nom_ent }}</p>

                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item me-3">
                                            <h5 class="mb-1"> {{  $count }} </h5>
                                            <p class="mb-0 font-13 text-white-50">Total de bienes asignados</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-sm-4">
                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                            <button type="button" class="btn btn-light">
                                <i class="mdi mdi-account-edit me-1"></i> Editar Perfil
                            </button>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row -->

            </div> <!-- end card-body/ profile-user-box-->
        </div><!--end profile/ card -->
    </div> <!-- end col-->
</div>

<!-- end row-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Acta de entrega de bienes</h4>
                {{-- <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddProducto('{{ $personal->id }}')"> Agregar Producto</button>
                </div> --}}
                <br />
                <p>Verificar los bienes que se muestran en la siguiente tabla, una vez que haya validado la información acepte la asignacion de bienes</p>
                <div class="col-sm-12" id="estados_doc">
                    @if($est == '5')
                        <div class="text-center mt-sm-0 mt-3 text-sm-end">
                            <div class="form-group">
                                <span style="margin-right: 2em;">Aceptar los bienes asignados:</span>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#large-Modal" onclick="btnAsginar()">
                                    <i class="mdi mdi-check me-1"></i> Aceptar
                                </button>
                            </div>                            
                        </div>
                    @elseif($est == '4')
                        <div class="text-center mt-sm-0 mt-3 text-sm-end" >
                            <div class="form-group">
                                <span style="margin-right: 2em;">Descargar, firmar el formato y subir al servidor:</span>
                                <a href="{{ route('m_bienes.formt_pdf') }}" target="_blank" class="btn btn-secondary" >
                                    <i class="mdi mdi-arrow-down-bold-box-outline me-1"></i> Descargar
                                </a>
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#large-Modal" onclick="btnSendPdf()">
                                    <i class="mdi mdi-arrow-up-bold-box-outline me-1"></i> Subir
                                </button>
                            </div>                    
                        </div>
                    @elseif($est == '1')
                        <div class="text-center mt-sm-0 mt-3 text-sm-end" >
                            <div class="form-group">
                                <span style="" class="text-primary">En proceso de firmas... tiempo estimado 24 horas. {{ $por }} %</span><br />                                
                                <div class="progreso-firm" >
                                    <div  class="progress col-12 ">
                                        <div style="float:right; width:100%;  ">
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ $por }}%;" aria-valuenow="{{ $por }}" aria-valuemin="0" aria-valuemax="100">{{ $por }} %</div> 
                                        </div>                                           
                                    </div>                                        
                                </div>                                
                            </div>                    
                        </div>
                    @endif
                </div>
                <br />

                <div class="col-sm-12" id="cargar-datos">
                    <i class="fa fa-spinner fa-spin"></i> Cargando tabla...  Si no carga la tabla por favor actualize la página
                </div>

                <div class="tab-content" id="tabla_cont" style="display: none">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_inv_per" class="table  dt-responsive table-hover table-bordered">
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