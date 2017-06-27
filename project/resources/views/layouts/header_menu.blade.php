<div class="container">
    <header class="header-acceso fila-flex">
        <div class="marca-container">
            <a href="{{ route('home') }}">
                <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-azul">
                    <use xlink:href="#logoMPT"></use>
                </svg>
            </a>
        </div> <!--.marca-container-->

        @include('layouts.menu', ['home' => false])
    </header>
</div>