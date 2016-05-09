{{-- Header para pantallas estáticas, con link de acceso a la plataforma --}}
<div class="container">
    <header class="header-acceso sin-acceso fila-flex">
        <div class="marca-container">
            <a href="{{ url('/') }}">
                <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-azul">
                    <use xlink:href="#logoMPT"></use>
                </svg>
            </a>
        </div> <!--.marca-container-->

        <a href="{{ url('/listado-alumnos') }}" class="btn-acceder btn-linea-azul" role="button">
            Acceder a la Plataforma <span class="glyphicon glyphicon-arrow-right"></span>
        </a>
    </header>
</div>