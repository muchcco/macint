<div class="leftside-menu">
    
    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{  asset('assets/images/logo.png')}}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm.png" alt="" height="16">
        </span>
    </a>


    <!-- Help Box -->
    {{-- <div class="help-box text-white text-center">
        
        <div class="avatar-md txt-mid">
            <span class="avatar-title bg-success rounded linesa">
                {{ auth()->user()->name[0] }}
            </span>
        </div>
        <h5 class="mt-3">{{ auth()->user()->name }}</h5>
        <p class="mb-3">{{ auth()->user()->email }}</p>
        <a href="javascript: void(0);" class="btn btn-outline-light btn-sm">Editar</a>
    </div> --}}
    <!-- end Help Box -->

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="@if (Request::is('/')) menuitem-active @endif">
                <a href="{{ route('inicio') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Panel de Inicio </span>
                </a>
            </li> 

            <li class="side-nav-title side-nav-item">MODULOS</li>

            <li class="side-nav-item @if (Request::is('asistencia*')) menuitem-active @endif"">
                <a href="{{ route('asistencia.asistencia') }}" class="side-nav-link">
                    <i class="uil-globe"></i>
                    <span> Asistencia </span>
                </a>
            </li>

            <li class="side-nav-item @if (Request::is('personal*')) menuitem-active @endif">
                <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false" aria-controls="sidebarLayouts" class="side-nav-link">
                    <i class="uil-window"></i>
                    <span> Personal </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                    <ul class="side-nav-second-level">
                        <li class="@if (Request::is('personal/asesores*')) menuitem-active @endif">
                            <a href="{{ route('personal.asesores') }}">Asesores</a>
                        </li>
                        {{-- <li class="@if (Request::is('personal/pcm*')) menuitem-active @endif">
                            <a href="layouts-detached.html">PCM</a>
                        </li> --}}
                    </ul>
                </div>
            </li>

            <li class="side-nav-title side-nav-item mt-1">CONTROL DE BIENES</li>
            

            <li class="side-nav-item @if (Request::is('inventario*')) menuitem-active @endif"">
                <a href="{{ route('inventario.inventario') }}" class="side-nav-link">
                    <i class="dripicons-photo-group"></i>
                    <span> Inventario </span>
                </a>
            </li>

            <li class="side-nav-item @if (Request::is('almacen*')) menuitem-active @endif"">
                <a href="{{ route('almacen.almacen') }}" class="side-nav-link">
                    <i class="dripicons-store"></i>
                    <span> Almacen </span>
                </a>
            </li>         
        </ul>

        
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>