{{-- Header incluido en home --}}
<header class="header-home">

    <div class="header-bg">
        <div class="carousel slide carousel-fade" id="carouselBg" data-ride="carousel">
            {{-- Wrapper for slides --}}
            <div class="carousel-inner">

                <div class="item active"
                     style="background-image: url(img/bg-home-1.jpg);background-position: 65% center;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-2.jpg);background-position: left top;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-3.jpg);background-position: center top;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-4.jpg);background-position: 70% center;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-5.jpg);background-position: 75% top;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}

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

        <a href="{{ url('/listado-alumnos') }}" class="btn-acceder btn-linea-blanco btn-max-360" role="button">
            Acceder a la Plataforma
            <span class="glyphicon glyphicon-arrow-right"></span>
        </a>

        @if (Auth::check())
            @if (Auth::user()->hasRole('escuela'))
                <a href="{{ url('/acceso-escuela') }}" class="btn btn-registro">
                    <span class="glyphicon glyphicon-dashboard"></span>&nbsp; Panel de administración
                </a>
            @endif
        @else
            <a href="{{ url('/login') }}" class="btn btn-registro">
                <span class="glyphicon glyphicon-user"></span> &nbsp; Iniciar sesión
            </a>
        @endif
    </div> {{-- /.contenido-header-home --}}
</header> {{-- .header-home --}}