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
                                <label for="">Mes</label>
                                <select name="mes" id="mes" class="form-control">
                                    <option value="" disabled selected>-- Seleccione una opción --</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Año</label>
                                <select name="año" id="año" class="form-control select2 año"></select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" id="filtro" onclick="execute_filter()"><i class="mdi mdi-card-search-outline"></i> Buscar</button>
                                <button class="btn btn-dark btn-sm" id="limpiar"><i class="mdi mdi-broom"></i> Limpiar</button>
                            </div>
                        </div>                      
                    </div>
                               
            </div> <!-- end card-body-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Asistencia del Centro Mac por Entidad</h4>

                {{-- <p>Exportar PDF</p> --}}

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_ent" class="table  dt-responsive table-hover table-bordered">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Entidad</th>
                                    <th>Mes</th>
                                    <th>Cantidad de asesores</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>    
                            <tbody id="table_ent_body">

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
    table_ent();
});

var tabla = $("#table_ent").DataTable();
var table_ent = ( año = '', mes = '') => {
    $.ajax({
        type: 'GET',
        url: "{{ route('asistencia.tablas.tb_det_entidad') }}" ,
        dataType: "json",
        data: {año: año, mes: mes},
        success: function(data){
            tabla.destroy();
            $("#table_ent_body").html(data.html);
            tabla = $("#table_ent").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ordering": true,
                language: {"url": "{{ asset('js/Spanish.json')}}"}, 
                "columns": [
                    { "width": "" },
                    { "width": "400px" },
                    { "width": "" },
                    { "width": "200px" },
                    { "width": "" },
                    { "width": "" }
                ]
            });
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            $( "#table_ent" ).load(window.location.href + " #table_ent" );
            location.reload();
        }
    });
}

var ExportarZIP = (can_per, n_dnis, id, mes, año)  => {

    console.log(can_per, n_dnis, id, mes, año);

    $.ajax({
        type: 'GET',
        url: "{{ route('asistencia.dow_resumen') }}" ,
        dataType: "json",  
        data: {can_per: can_per, n_dnis: n_dnis, id : id, mes : mes, año : año},
        success: function(data){

        }
    });


}

function ComboAno(){
   var n = (new Date()).getFullYear()
   var select = document.querySelector(".año");
   for(var i = n; i>=2023; i--)select.options.add(new Option(i,i)); 
};
window.onload = ComboAno;

// Obtén el elemento select por su ID
var mesSelect = document.getElementById('mes');

// Obtén el mes actual (0 = enero, 1 = febrero, ..., 11 = diciembre)
var mesActual = new Date().getMonth() + 1;

console.log(mesActual);

// Selecciona el mes actual en el select
mesSelect.selectedIndex = mesActual

</script>


@endsection