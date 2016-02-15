{{-- HEADER CON USUARIO LOGUEADO: incluido en base_auth --}}
<header class="header-acceso">
    <div class="marca-container">
        <a href="{{ url('/') }}">
            <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-azul">
                <use xlink:href="#logoMPT"></use>
            </svg>
        </a>
    </div>

    @include('auth.menu_user', ['home' => false])
</header>