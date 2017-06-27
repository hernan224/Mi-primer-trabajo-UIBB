{{-- Menú desktop o tablet, con o sin usuario logueado --}}
<nav class="navegacion-principal-pc hidden-sm hidden-xs">
    <ul class="list-unstyled fila-flex">
        <li>
            <a href="{{ route('egresados', ['tipo'=>'tecnicos']) }}"
               class="{{ (Request::route()->getName() == 'egresados' && Request::route()->getParameter('tipo') == 'tecnicos') ? 'activo' : '' }}">
                Egresados Técnicos
            </a>
        </li>
        <li>
            <a href="{{ route('egresados', ['tipo'=>'oficios'])  }}"
               class="{{ (Request::route()->getName() == 'egresados' && Request::route()->getParameter('tipo') == 'oficios') ? 'activo' : '' }}">
                Egresados de Oficios
            </a>
        </li>
        <li>
            <a href="{{ route('publicaciones_capacitaciones') }}" class="{{ Request::route()->getName() == 'publicaciones_capacitaciones' ? 'activo' : '' }}">
                Capacitaciones
            </a>
        </li>
        <li>
            <a href="{{ route('publicaciones_practicas') }}" class="{{ Request::route()->getName() == 'publicaciones_practicas' ? 'activo' : '' }}">
                Prácticas
            </a>
        </li>
        <li>
            <a href="{{ route('instituciones') }}" class="{{ Request::route()->getName() == 'instituciones' ? 'activo' : '' }}">
                Instituciones
            </a>
        </li>
        <li>
            <a href="{{ route('contacto')}}" class="{{ Request::route()->getName() == 'contacto' ? 'activo' : '' }}">
                Contacto
            </a>
        </li>
        <li class="dropdown">
            <a id="dropdownLoginMenu" class="fila-flex" data-target="#" href="#" data-toggle="dropdown"
               role="button" aria-haspopup="true" aria-expanded="false" title="Acceso Usuarios Registrados">
                <button class="btn-menu-usuario">
                    <span class="sr-only">{{ (Auth::check()) ? 'Acceso usuario registrado' : 'Iniciar sesión' }}</span>
                    <span class="glyphicon glyphicon glyphicon-user"></span>
                </button>
            </a>
            <ul class="dropdown-menu submenu-usuario" aria-labelledby="dropdownLoginMenu">
                @if (Auth::check())
                    <li class="menu-nombre-usuario">
                        @if(Auth::check() and Auth::user()->hasRole('institucion') and Auth::user()->institucion->foto)
                            <span class="foto-bg foto-usuario foto-institucion"
                                  style="background-image: url('{{Auth::user()->institucion->getUrlFoto()}}'); border-radius: 0;">
                            </span>
                        @endif
                        <small>Bienvenido:</small>
                        <h5 class="nombre-usuario texto-azul mm0">
                            <strong class="nombre-docente">{{ Auth::user()->name }}</strong>
                        </h5>
                    </li>
                    <hr class="separador-menu">
                    <li>
                        <a href="{{ route('administracion') }}" class="acceder-panel">
                            <span class="glyphicon glyphicon glyphicon-dashboard"></span>
                            <strong>Panel de administración</strong>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="cerrar-sesion ">
                            <span class="glyphicon glyphicon glyphicon-log-out"></span>
                            <strong>Cerrar sesión</strong>
                        </a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="text-center">&nbsp;<strong>Iniciar sesión</strong></a></li>
                @endif
            </ul> <!--//dropdown-menu-->



        </li>
    </ul>
</nav>

{{-- Dropdown menú (mobile), con o sin usuario logueado --}}
<div class="acceso-usuario-container dropdown  hidden-lg hidden-md">
    <a id="dropdownMenu" class="fila-flex" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        @if (Auth::check())
            @if (Auth::user()->hasRole('institucion'))
                @if (Auth::user()->institucion->foto)
                    <figure class="foto-bg foto-usuario foto-institucion" style="background-image: url('{{Auth::user()->institucion->getUrlFoto()}}');  border-radius: 0;"></figure>
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
            @if (Auth::user()->hasRole('institucion'))
                <strong class="nombre-docente">{{ Auth::user()->name }}</strong>
                <span class="nombre-entidad">{{ Auth::user()->institucion->name }}</span>
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
    @if (Auth::check())
        <li>
            <a href="{{ route('administracion') }}" class="acceder-panel">
                <span class="glyphicon glyphicon-dashboard"></span>&nbsp;
                <strong>Panel de administración</strong>
            </a>
        </li>
        <hr class="separador-menu">
    @endif
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="{{ route('egresados', ['tipo'=>'tecnicos']) }}" class="acceder-plataforma">
            Egresados Técnicos
        </a></li>
        <li><a href="{{ route('egresados', ['tipo'=>'oficios']) }}" class="acceder-plataforma">
            Egresados de Oficios
        </a></li>
        <li><a href="{{ route('publicaciones_capacitaciones') }}" class="acceder-plataforma">
            Capacitaciones
        </a></li>
        <li><a href="{{ route('publicaciones_practicas') }}" class="acceder-plataforma">
            Prácticas Profesionalizantes
        </a></li>
        <li><a href="{{ route('instituciones') }}" class="acceder-plataforma">
            Instituciones Educativas
        </a></li>
        <li><a href="{{ route('contacto') }}" class="acceder-plataforma">
            Contacto
        </a></li>
        <hr class="separador-menu">
    @if (Auth::check())
        <li><a href="{{ route('logout') }}" class="text-center">
            <span class="glyphicon glyphicon glyphicon-log-out"></span>&nbsp;
            <strong>Cerrar sesión</strong>
        </a></li>
    @else
        <li><a href="{{ route('login') }}" class="text-center">
            <span class="glyphicon glyphicon glyphicon-user"></span>&nbsp;
            <strong>Iniciar sesión</strong></a>
        </li>
    @endif
    </ul>
</div>