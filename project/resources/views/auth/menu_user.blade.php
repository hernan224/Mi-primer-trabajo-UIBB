{{-- Dropdown usuario: incluido en header, sólo se muestra si hay usuario --}}
@if (Auth::check())
<div class="acceso-usuario-container dropdown">
    <a id="dropdownUsuario" class="fila-flex" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        {{-- <figure class="foto-bg foto-usuario sin-foto"></figure> --}}
        <h5 class="nombre-usuario {{ $home ? 'texto-blanco' : ''}}">
        @if (Auth::user()->esEscuela())
            <strong class="nombre-docente">{{ Auth::user()->name }}</strong>
            <span class="nombre-entidad">{{ Auth::user()->escuela->name }}</span>
        @else
            <strong>{{ Auth::user()->name }}</strong>
        @endif
        </h5>
        <button class="btn-menu-usuario">
            <span class="sr-only">Menú usuario</span>
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
    </a>
    <ul class="dropdown-menu submenu-usuario" aria-labelledby="dropdownUsuario">
        @if ($home)
        <li><a href="{{ url('/acceso') }}" class="acceder-plataforma">Acceder a la Plataforma
                <span class="glyphicon glyphicon-arrow-right"></span></a>
        </li>
        @endif
        <li><a href="#ToDo">Ayuda y Soporte</a></li>
        <li><a href="{{ url('/logout') }}" class="cerrar-sesion"><strong>Cerrar sesión</strong></a></li>
    </ul>
</div>
@endif