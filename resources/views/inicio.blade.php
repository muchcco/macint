@extends('layouts.layout')
@section('script')

<script>
    
</script>
@endsection
@section('main')
<div class="col-12">
    <div class="page-title-box">
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                <li class="breadcrumb-item active">Inicio</li>
            </ol>
        </div>
        <h4 class="page-title">Página de inicio</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <div class="card text-white bg-info overflow-hidden">
            <div class="card-body">
                <div class="toll-free-box text-center">
                    <h4> <i class="mdi mdi-robot-excited"></i> Próximos Cumpleaños del año  @php echo Carbon\Carbon::now()->format('Y'); @endphp </h4>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div>
</div>
<div class="row">
    @foreach ($proximos_cumpleaños as $p)
        <div class="col-xxl-3 col-lg-6">
            <div class="card widget-flat border-secondary border">
                <div class="card-body">
                    <div class="float-end">
                        <i class="widget-icon bg-danger rounded-circle text-white">{{ $p->nombreu[0] }}</i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Revenue"> {{ $p->nombreu }}</h5>
                    <h5 class="text-muted fw-normal mt-0" title="Revenue">{{ $p->nombre }}</h5>
                    <h3 class="mt-3 mb-3">{{ $p->prox_cumpleanos->format('d/m/Y') }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="badge bg-info me-4">
                             {{ $p->nombre_mes_proximo_cumpleanos }}</span>
                        <span class="text-nowrap">cumple: {{ $p->edad_proximo_cumpleanos }} años</span>
                    </p>
                </div>
            </div>
        </div>
    @endforeach    
</div>
@endsection