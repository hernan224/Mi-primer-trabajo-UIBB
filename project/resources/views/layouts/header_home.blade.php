{{-- Header incluido en home --}}
<header class="header-home">

    <div class="header-bg">
        <div class="carousel slide carousel-fade" id="carouselBg" data-ride="carousel">
            {{-- Wrapper for slides --}}
            <div class="carousel-inner">

                <div class="item active" style="background: url(img/bg-home-1.jpg) 65% center;"></div>
                <div class="item" style="background: url(img/bg-home-2.jpg) left top;"></div>
                <div class="item" style="background: url(img/bg-home-3.jpg) center top;"></div>
                <div class="item" style="background: url(img/bg-home-4.jpg) 70% center;"></div>
                <div class="item" style="background: url(img/bg-home-5.jpg) 75% top;"></div>

            </div> {{-- /.carousel-inner --}}
        </div> {{-- /#carouselBg --}}
    </div> {{-- /.carousel-bg-container --}}

    <div class="login-nav-home">
        <div class="fila-flex contenedor-acceso container">
            @include('layouts.menu', ['home' => true])
        </div> {{-- /.fila-flex contenedor-acceso --}}

    </div> {{-- /.login-nav-home --}}

    <div class="container contenido-header-home">

        <div class="marca-container marca-home">
            <a>
                <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-blanco">
                    <use xlink:href="#logoMPT"></use>
                </svg>
            </a>
        </div> {{-- .marca-home --}}

        <h1 class="h3 texto-blanco text-uppercase text-center">Plataforma virtual de inserción laboral</h1>

        <div class="mpt-by">
            <span class="texto-servicio texto-blanco">un servicio de:</span>
            <a class="logo-uibb uibb-blanco" href="http://uibb.org.ar/">Unión Industrial Bahía Blanca</a>
        </div> {{-- .mpt-by --}}

        <div class="botones-home botones-acceso">
            @if (Auth::check())
            <div class="fila-flex">
                <a href="{{ route('administracion') }}" class="btn btn-registro">
                    <span class="glyphicon glyphicon-dashboard"></span>&nbsp; Panel de administración
                </a>
            </div>
            @endif
            <p class="h2 texto-blanco text-center">¿Qué tipo de profesional está buscando?</p>
            <div class="fila-flex">
                <a href="{{ route('egresados', ['tipo'=>'tecnicos']) }}" class="btn-acceder btn-linea-blanco btn-max-360" role="button">
                    Egresados Técnicos
                </a>
                <a href="{{ route('egresados', ['tipo'=>'oficios']) }}" class="btn-acceder btn-linea-blanco btn-max-360" role="button">
                    Egresados de Oficios
                </a>
            </div>
            @if (!Auth::check())
            <div class="fila-flex">
                <a href="{{ route('login') }}" class="btn btn-registro">
                    <span class="glyphicon glyphicon-user"></span> &nbsp; Iniciar sesión
                </a>
            </div>
            @endif
            </div>
        </div>
    </div> {{-- /.contenido-header-home --}}
</header> {{-- .header-home --}}