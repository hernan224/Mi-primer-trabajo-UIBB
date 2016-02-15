{{-- Dropdown usuario: incluido en header, sólo se muestra si hay usuario --}}
@if (Auth::check())
<div class="acceso-usuario-container dropdown">
    <a id="dropdownUsuario" class="fila-flex" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        @if (Auth::user()->hasRole('escuela'))
            @if (Auth::user()->escuela->foto)
                <figure class="foto-bg foto-usuario foto-institucion" style="background-image: url('{{Auth::user()->escuela->getUrlFoto()}}')"></figure>
            @else
                <figure class="foto-bg foto-usuario sin-foto foto-institucion"></figure>
            @endif
        @elseif (Auth::user()->hasRole('empresa'))
            @if (Auth::user()->empresa->foto)
                <figure class="foto-bg foto-usuario foto-asociado" style="background-image: url('{{Auth::user()->empresa->getUrlFoto()}}')"></figure>
            @else
                <figure class="foto-bg foto-usuario sin-foto foto-asociado"></figure>
            @endif
        @else
            <figure class="foto-bg foto-usuario sin-foto foto-asociado"></figure>
        @endif
        <h5 class="nombre-usuario {{ $home ? 'texto-blanco' : ''}}">
        @if (Auth::user()->hasRole('escuela'))
            <strong class="nombre-docente">{{ Auth::user()->name }}</strong>
            <span class="nombre-entidad">{{ Auth::user()->escuela->name }}</span>
        @elseif (Auth::user()->hasRole('empresa'))
            <strong>{{ Auth::user()->empresa->name }}</strong>
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
        {{-- <li><a href="{{url('/ayuda')}}">Ayuda y Soporte</a></li> No está en los req. --}}
        <li><a href="{{ url('/logout') }}" class="cerrar-sesion"><strong>Cerrar sesión</strong></a></li>
    </ul>
</div>
@endif