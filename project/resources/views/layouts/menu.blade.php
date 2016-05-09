{{-- Dropdown menú, con o sin usuario logueado --}}
<div class="acceso-usuario-container dropdown">
    <a id="dropdownMenu" class="fila-flex" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        @if (Auth::check())
            @if (Auth::user()->hasRole('escuela'))
                @if (Auth::user()->escuela->foto)
                    <figure class="foto-bg foto-usuario foto-institucion" style="background-image: url('{{Auth::user()->escuela->getUrlFoto()}}');  border-radius: 0;"></figure>
                @else
                    <figure class="foto-bg foto-usuario sin-foto foto-institucion"></figure>
                @endif
            {{-- no hay usuarios empresa
            @elseif (Auth::user()->hasRole('empresa'))
                @if (Auth::user()->empresa->foto)
                    <figure class="foto-bg foto-usuario foto-asociado" style="background-image: url('{{Auth::user()->empresa->getUrlFoto()}}')"></figure>
                @else
                    <figure class="foto-bg foto-usuario sin-foto foto-asociado"></figure>
                @endif
            --}}
            @else
                <figure class="foto-bg foto-usuario sin-foto foto-asociado"></figure>
            @endif
            <h5 class="nombre-usuario {{ $home ? 'texto-blanco' : ''}}">
            @if (Auth::user()->hasRole('escuela'))
                <strong class="nombre-docente">{{ Auth::user()->name }}</strong>
                <span class="nombre-entidad">{{ Auth::user()->escuela->name }}</span>
            {{-- @elseif (Auth::user()->hasRole('empresa'))
                <strong>{{ Auth::user()->empresa->name }}</strong> --}}
            @else
                <strong>{{ Auth::user()->name }}</strong>
            @endif
            </h5>
        @else {{-- sin usuario logueado --}}
            <h5 class="nombre-usuario {{ $home ? 'texto-blanco' : ''}}">
            <strong class="nombre-docente">Menú</strong></h5>
        @endif
        <button class="btn-menu-usuario">
            <span class="sr-only">Menú</span>
            <span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
    </a>
    <ul class="dropdown-menu submenu-usuario" aria-labelledby="dropdownMenu">
    @if (Auth::check() && Auth::user()->hasRole('escuela'))
        <li><a href="{{ url('/acceso-escuela') }}" class="acceder-panel">
            <span class="glyphicon glyphicon glyphicon-dashboard"></span>&nbsp;
            <strong>Panel de administración</strong>
        </a></li>
        <hr class="separador-menu">
    @endif
        <li><a href="{{ url('/')}}">Inicio</a></li>
        <li><a href="{{ url('/listado-alumnos') }}" class="acceder-plataforma">
            Acceder a la Plataforma
        </a></li>
        <li><a href="{{ url('/capacitaciones') }}" class="acceder-plataforma">
            Capacitaciones
        </a></li>
        <li><a href="{{ url('/practicas-profesionalizantes') }}" class="acceder-plataforma">
            Prácticas Profesionalizantes
        </a></li>
        <li><a href="{{ url('/instituciones-educativas') }}" class="acceder-plataforma">
            Instituciones Educativas
        </a></li>
        <li><a href="{{ url('/contacto')}}" class="acceder-plataforma">
            Contacto
        </a></li>
        <hr class="separador-menu">
    @if (Auth::check())
        <li><a href="{{ url('/logout') }}" class="text-center">
            <span class="glyphicon glyphicon glyphicon-log-out"></span>&nbsp;
            <strong>Cerrar sesión</strong>
        </a></li>
    @else
        <li><a href="{{ url('/login') }}" class="text-center">
            <span class="glyphicon glyphicon glyphicon-user"></span>&nbsp;
            <strong>Iniciar sesión</strong></a>
        </li>
    @endif
    </ul>
</div>