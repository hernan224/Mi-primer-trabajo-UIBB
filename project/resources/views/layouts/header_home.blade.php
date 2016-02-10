<header class="header-home acceso-entidad-educativa">

    <div class="header-bg">
        <div class="carousel slide carousel-fade" id="carouselBg" data-ride="carousel">
            {{-- Wrapper for slides --}}
            <div class="carousel-inner">

                <div class="item active"
                     style="background-image: url(img/bg-home-1.jpg);background-position: center right;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-2.jpg);background-position: top left;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-3.jpg);background-position: top center;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-4.jpg);background-position: center right;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}
                <div class="item"
                     style="background-image: url(img/bg-home-5.jpg);background-position: top right;">
                    {{-- <div class="slide-img"></div> --}} </div>{{-- /.item --}}

            </div> {{-- /.carousel-inner --}}
        </div> {{-- /#carouselBg --}}
    </div> {{-- /.carousel-bg-container --}}

    <div class="login-nav-home">
        <div class="fila-flex contenedor-acceso container">
            {{-- SI NO HAY USUARIO LOGEADO, EL CONTENDOR QUEDARÍA VACIO --}}
            @include('auth.menu_user')
        </div> {{-- /.fila-flex contenedor-acceso --}}

    </div> {{-- /.login-nav-home --}}

    <div class="container contenido-header-home">

        <div class="marca-container marca-home">
            <a href="#empty">
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

        <a href="{{ url('/acceso') }}" class="btn-acceder btn-linea-blanco btn-max-360" role="button">
            Acceder a la Plataforma
            <span class="glyphicon glyphicon-arrow-right"></span>
        </a>

    </div> {{-- /.contenido-header-home --}}
</header> {{-- .header-home --}}