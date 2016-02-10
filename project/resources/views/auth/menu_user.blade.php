{{-- Dropdown usuario: incluido en header, sólo se muestra si hay usuario --}}
@if (Auth::check())
<div class="acceso-usuario-container dropdown">
    <a id="dropdownUsuario" class="fila-flex" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <figure class="foto-bg foto-usuario sin-foto"></figure>
        <h5 class="nombre-usuario {{ $home ? 'texto-blanco' : ''}}">
            {{-- if escuela --}}
            {{-- <strong>
                <strong class="nombre-docente">Juana Ana Triana</strong>
                <span class="nombre-entidad">Escuela de Educación Técnica N°1</span>
            </strong> --}}
            {{-- else --}}
            <strong>{{ Auth::user()->name }}</strong>
        </h5>
        <button class="btn-menu-usuario">
            <span class="sr-only">Menú usuario</span>
            <span class="glyphicon glyphicon-menu-down"></span>
        </button>
    </a>
    <ul class="dropdown-menu submenu-usuario" aria-labelledby="dropdownUsuario">
        @if (isset($home) && $home)
        <li><a href="{{ url('/acceso') }}" class="acceder-plataforma">Acceder a la Plataforma
                <span class="glyphicon glyphicon-arrow-right"></span></a>
        </li>
        @endif
        <li><a href="#ToDo">Ayuda y Soporte</a></li>
        <li><a href="{{ url('/logout') }}" class="cerrar-sesion"><strong>Cerrar sesión</strong></a></li>
    </ul>
</div>
@endif