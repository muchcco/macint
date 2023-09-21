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


<script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js" integrity="sha512-dDguQu7KUV0H745sT2li8mTXz2K8mh3mkySZHb1Ukgee3cNqWdCFMFsDjYo9vRdFRzwBmny9RrylAkAmZf0ZtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- script init -->

<script >

$(document).ready(function() {
    table_cuid_espera();   
    // askNotificationPermission();
});



var tabla = $("#table_cuid_espera").DataTable();
var table_cuid_espera = () => {

    $.ajax({
        type: 'GET',
        url: "{{ route('novosga.tablas.tb_espera') }}" ,
        dataType: "json",
        success: function(data){
            document.getElementById("cargar-datos").style.display = 'none';
            document.getElementById("tabla_cont").style.display = 'block';
            tabla.destroy();
            $("#table_cuid_espera_body").html(data.html);
            tabla = $("#table_cuid_espera").DataTable({
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

// Configuramos la actualización cada 5 segundos (5000 milisegundos)
setInterval(table_cuid_espera, 5000);


// Función para mostrar la hora actual
var actHora = function() {
    const ahora = new Date();
    const horaActual = ahora.toLocaleTimeString();
    const miDiv = document.getElementById('hora');
    miDiv.textContent = 'Hora actual: ' + horaActual;
};

actHora();

// Configuramos la actualización de la hora cada 5 segundos
setInterval(actHora, 1000);

const baseUrl = "{{ url('/novosga/nuevo_registro') }}"
console.log(baseUrl);
const resultadosContainer = document.getElementById('resultados-container');

const botonActivarDesactivarSonido = document.getElementById('boton-activar-desactivar-sonido');
const sonidoAlerta = document.getElementById('sonido-alerta');
let sonidoActivado = false; // Variable para rastrear el estado del sonido

// Función para alternar entre activar y desactivar el sonido
function alternarSonido() {
    sonidoActivado = !sonidoActivado; // Cambiar el estado del sonido
    sonidoAlerta.muted = !sonidoActivado; // Habilitar o deshabilitar el sonido según el estado
}

// Agregar un evento de clic al botón
botonActivarDesactivarSonido.addEventListener('click', alternarSonido);

const eventSource = new EventSource(`${baseUrl}`);
console.log(eventSource);
eventSource.addEventListener('message', function(event) {
    // Recibe los datos del evento SSE
    const nuevosResultados = JSON.parse(event.data);

    // Actualiza el contenido de la vista con los nuevos resultados
    resultadosContainer.innerHTML = '';

    if (nuevosResultados.length > 0) {
        nuevosResultados.forEach(function(resultado) {
            const resultadoDiv = document.createElement('div');
            resultadoDiv.textContent = JSON.stringify(resultado);
            resultadosContainer.appendChild(resultadoDiv);
            console.log(JSON.stringify(resultado.nm_cli));

            // Reproduce el sonido de alerta
            sonidoAlerta.muted = false;
            sonidoAlerta.play();

            //BOTON
            

        });
    } else {
        resultadosContainer.textContent = 'No hay nuevos resultados.';
    }
});

/** ===================================================== LAS ALERTAS SE CONFIGURAN CUANDO INGRESEN A PRODUCCION Y TENGAN HTTPS OCONFIGURADA  ======================================================================= **/

// Verifica si el navegador admite notificaciones
if ("Notification" in window) {
    // Verifica si las notificaciones están permitidas o bloqueadas
    if (Notification.permission === "granted") {
        // Las notificaciones están permitidas, puedes mostrar una notificación
        
    } else if (Notification.permission !== "denied") {
        // Las notificaciones no están bloqueadas, solicita permiso
        Notification.requestPermission().then(function(permission) {
            if (permission === "granted") {
                // El usuario permitió las notificaciones, puedes mostrar una notificación
                
            }
        });
    }
}
function notifyMe() {
    //Vamos a comprobar si el navegador es compatible con las notificaciones
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }
    // Vamos a ver si ya se han concedido permisos de notificación
    else if (Notification.permission === "granted") {
        // Si está bien vamos a crear una notificación
        var body = "Hola";
        var icon = "{{ asset('assets/images/logo-pcm.png') }}";
        var title = "Notificación";
        var tag = "notificacion-unico"; // Proporciona una etiqueta no vacía
        var options = {
            body: body,
            icon: icon,
            lang: "ES",
            renotify: true, // Puedes utilizar true en lugar de "true"
            tag: tag // Especifica la etiqueta aquí
        };
        var notification = new Notification(title,options);
        console.log(notification);
        var audio = new Audio('https://www.quecodigo.com/web/antigua/sounds/notificacion.mp3');
        audio.play();
        notification.onclick = function () {
            //action
        };
        setTimeout(notification.close.bind(notification), 5000);
    }
    // De lo contrario, tenemos que pedir permiso al usuario
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            // Si el usuario acepta, vamos a crear una notificación
            if (permission === "granted") {
                var notification = new Notification("Gracias, Ahora podras recibir notifiaciones de nuestra página");
            }
        });
    }
    // Por fin, si el usuario ha denegado notificaciones, y usted
    // Quiere ser respetuoso no hay necesidad de preocuparse más sobre ellos.
}


/* ======================================================== FIN NOTIFICACION ESCRITORIO  ======================================================================== */

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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Mi Perfil</a></li>
                    <li class="breadcrumb-item active">Lista NOVO</li>
                </ol>
            </div>
            <h4 class="page-title">Lista de cuidadanos en espera</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 


<!-- end row-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">Lista de cuidadanos en espera del día de hoy <strong>( @php echo Carbon\Carbon::now()->format('d/m/Y')  @endphp )</strong></h4>
                {{-- <div class="box-tools">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#large-Modal" onclick="btnAddUsuario()"> Agregar Usuario</button>
                </div> --}}
                <button id="boton-activar-desactivar-sonido" style="display: none">Activar/Deshabilitar Sonido</button>
                <audio id="sonido-alerta" src="{{ asset('song/llamado/ding_dong.mp3') }}" preload="auto" muted style="display: none"></audio>
                <button onclick="notifyMe()">Notificame!</button>
                <div id="resultados-container" ></div>
                <br />
                <div id="hora">Contenido inicia </div>
                <div class="col-sm-12" id="cargar-datos">
                    <i class="fa fa-spinner fa-spin"></i> Cargando tabla...  Si no carga la tabla por favor actualize la página
                </div>

                <div class="tab-content" id="tabla_cont" style="display: none">
                    <div class="tab-pane show active" id="buttons-table-preview">
                        <table id="table_cuid_espera" class="table  dt-responsive table-hover table-bordered">
                            <thead class="bg-dark" style="color: #fff;">
                                <tr>
                                    <th>N°</th>
                                    <th>Hora de LLegada</th>
                                    <th>Ticket</th>
                                    <th>Entidad</th>
                                    <th>Estado</th>
                                    <th>Cuidadano</th>
                                    <th>N° de Documento</th>
                                </tr>
                            </thead>
                            <tbody id="table_cuid_espera_body">

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