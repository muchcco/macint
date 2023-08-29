<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acta de Entrega</title>
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css')}}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css')}}">

    <style>
        .td-mid {
            text-align:center;
            padding-top: .3em;
        }

        .texto {
            font-size: .8em;
            padding-left: 1em;
            padding-right: 1em;
            text-align: justify;
            text-justify: inter-word;
        }

        .table-bor{
            font-size: .8em;
            padding-left: 1em;
            padding-right: 1em;
        }

        .t-d-h {
            border: 1px solid #000;
            padding: .2em;
        }

        .footer{
            margin-top: 8em;
        }
    </style>

</head>
<body>

<header>
    <div class="container ">
        <div class="row">
            {{-- <div class="col max">
                <img src="{{ asset('assets/images/mac-general.png') }}" alt="" height="25" style="border: 1px solid black">
                <h2 style="border: 1px solid green; width: 40%">MESA DE PARTES DIGITAL</h2>
                <img src="{{ asset('assets/images/logo-pcm.png') }}" alt="" height="25" style="border: 1px solid blue">
            </div> --}}
            <table class="table">
                <tr>
                    <td style="text-align: left; padding-left: 1em;" class="col-2" ><img src="{{ asset('assets/images/mac-general.png') }}" alt="" height="40" ></td>
                    <th class="td-mid col-8">ACTA DE BIENES EN CUSTODIA DE LA ENTIDAD "{{ $personal->nombre }}"</th>
                    <td style="text-align: right; padding-right: 1em;" class="col-2"><img src="{{ asset('assets/images/logo-pcm.png') }}" alt="" height="40" ></td>
                </tr>
            </table>
        </div>
    </div>
</header>

<section>
    <div class="">
        <p class="texto">Con fecha <?php setlocale(LC_TIME, 'es_PE', 'Spanish_Spain', 'Spanish'); echo strftime('%d de %B del %Y',strtotime("now"));  ?>, la {{ $personal->sexo === '1' ? 'Sr.' : 'Srta.' }}  {{ $personal->nombreu }} {{ $personal->sexo === '1' ? 'identificado' : 'identificada' }} con DNI {{ $personal->dni }}, realiza la entrega de bienes asignados para la ejecución de sus labores asignados como asesora de la <strong>{{ $personal->nombre }}</strong> en el Centro Mac Junín de la Subsecretaría de Calidad de Servicios de la Secretaría de Gestión Pública de la Presidencia del Consejo de Ministros. 
        <br />
        <br />
            Cabe recalcar que todos los bienes asignados se encuentran en perfectas condiciones. </p>
        <br />
    </div>
</section>


<section>
    <table class="table table-bor">
        <thead style="background: #3D61B2; color:#fff;">
            <tr>
                <th class="t-d-h">N°</th>
                <th class="t-d-h">Cod. Patrimonial</th>
                <th class="t-d-h">Descripción </th>
                <th class="t-d-h">Marca </th>
                <th class="t-d-h">Modelo </th>
                <th class="t-d-h">Número de Serie</th>
                <th class="t-d-h">Color</th>
                <th class="t-d-h">Estado</th>
                <th class="t-d-h">Obervación</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($query as $i => $q)
                <tr>                    
                    <td class="t-d-h">{{ $i }}</td>
                    <td class="t-d-h">{{ $q->cod_pronsace }}</td>
                    <td class="t-d-h">{{ $q->descripcion }}</td>
                    <td class="t-d-h">{{ $q->marca }}</td>
                    <td class="t-d-h">{{ $q->modelo }}</td>
                    <td class="t-d-h">{{ $q->serie_medida }}</td>
                    <td class="t-d-h">{{ $q->color }}</td>
                    <td class="t-d-h">{{ $q->estado }}</td>
                    <td class="t-d-h">{{ $q->observacion }}</td>                    
                </tr>
            @empty
                <tr><td colspan="9">NO HAY DATOS DISPONIBLES PARA ESTE USUARIO</td></tr> 
            @endforelse
        </tbody>

    </table>
</section>
<p class="texto">Con un total de <strong>{{ $count }}</strong> bienes asignados</p>
<section class="footer">
    <div class="row">
        <table class="table">
            <tr>
                <td style="text-align: center; padding-left: 1em;" class="col-4" >
                    ___________________________________<br />
                    Coordinadora
                </td>
                <td class="td-mid col-4">
                    ___________________________________<br />
                    Especialista TIC
                </td>
                <td style="text-align: center; padding-right: 1em;" class="col-4">
                    ___________________________________<br />
                    {{ $personal->sexo === '1' ? 'Asesor' : 'Asesora' }}
                </td>
            </tr>
        </table>
    </div>

</section>



<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js')}}" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>