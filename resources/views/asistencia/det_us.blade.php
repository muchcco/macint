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
                                <button class="btn btn-danger btn-sm" id="pdf" onclick="ExportPDF()"><i class="mdi mdi-file-pdf-outline"></i> PDF</button>
                                <button class="btn btn-success btn-sm" id="excel" onclick="ExportEXCEL()"><i class="mdi mdi-file-excel-outline"></i> Excel</button>
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

                <h4 class="header-title">Asistencia del Centro Mac - {{ $personal->nombre }}</h4>

                {{-- <p>Exportar PDF</p> --}}

                <div class="tab-content">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_det_us" class="table  dt-responsive table-hover table-bordered">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th rowspan="2">N°</th>
                                    <th rowspan="2">Entidad</th>
                                    <th rowspan="2">Nombres y Apellidos</th>
                                    <th rowspan="2">Cargo / Asesor(a)</th>
                                    <th rowspan="2">DNI</th>
                                    <th rowspan="2">Fecha</th>
                                    <th rowspan="2">Hora de <br />Ingreso</th>
                                    <th colspan="2" class="text-center">Refrigerio</th>
                                    <th rowspan="2">Hora de <br />Salida</th>
                                    <th rowspan="2">Salida <br />programado</th>
                                    <th rowspan="2">Ingreso <br />Programada</th>
                                    <th rowspan="2">Observación</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Salida</th>
                                    <th class="text-center">Ingreso</th>
                                </tr>
                            </thead>    
                            <tbody id="table_det_us_body">

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
    table_det_us();
});

var tabla = $("#table_det_us").DataTable();
var table_det_us = ( año = '', mes = '' ) => {

    var dni = "{{ $idPersonal }}"

    $.ajax({
        type: 'GET',
        url: "{{ route('asistencia.tablas.tb_det_us') }}" ,
        dataType: "json",
        data: {dni : dni, año : año , mes : mes},
        success: function(data){
            tabla.destroy();
            $("#table_det_us_body").html(data.html);
            tabla = $("#table_det_us").DataTable({
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
    // document.getElementById('año').value = "";
    // document.getElementById('mes').value = "";

    table_det_us();

})

// EJECUTA LOS FILTROS Y ENVIA AL CONTROLLADOR PARA  MOSTRAR EL RESULTADO EN LA TABLA
var execute_filter = () =>{
   var año = $('#año').val();
    var mes = $('#mes').val();
   $.ajax({
        type:'get',
        url: "{{ route('asistencia.tablas.tb_det_us') }}" ,
        dataType: "json",
        data: {año : año, mes : mes },
        beforeSend: function () {
            document.getElementById("filtro").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Buscando';
            document.getElementById("filtro").style.disabled = true;
        },
        success:function(data){
            document.getElementById("filtro").innerHTML = 'Buscar';
            document.getElementById("filtro").style.disabled = false;
            table_det_us(año, mes);
        }
   });
    
    // console.log('Fecha fecha: '+fecha,'Fecha Fin: ' +fechaFin,'Dependencia: ' +dependencia,'Estado: '+estado,'Usuario OEAS: '+us_oeas);
    //table_asistencia(fecha, entidad, estado);
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

/******************************************* METODOS PARA EXPORTAR DATOS ***********************************************************/

var ExportPDF = () => {

    var año = document.getElementById('año').value;
    var mes = document.getElementById('mes').value;
    var dni = "{{ $idPersonal }}";

    // Definimos la vista dende se enviara
    var link_up = "{{ route('asistencia.asistencia_pdf') }}";

    // Crear la URL con las variables como parámetros de consulta
    var href = link_up +'?año=' + año + '&mes=' + mes + '&dni=' + dni;

    console.log(href);

    var blank = "_blank";

    window.open(href, blank);
}

var ExportEXCEL = () => {

    var año = document.getElementById('año').value;
    var mes = document.getElementById('mes').value;
    var dni = "{{ $idPersonal }}";

    // Definimos la vista dende se enviara
    var link_up = "{{ route('asistencia.asistencia_excel') }}";

    // Crear la URL con las variables como parámetros de consulta
    var href = link_up +'?año=' + año + '&mes=' + mes + '&dni=' + dni;

    console.log(href);

    var blank = "_blank";

    window.open(href);


}

</script>


@endsection