{{-- Footer, incluido en base (se ve en todas las pantallas) --}}
<footer class="pie-pagina {{ $home ? 'pie-home' : 'pie-home'}}">
    <div class="container">
        <div class="contenido-footer row">
            <div class="col-md-3 col-sm-4">
                <div class="marca-container">
                    <a href="{{ route('home') }}">
                        <svg viewBox="0 0 324.343 164.374" class="logo-mpt logo-blanco">
                            <use xlink:href="#logoMPT"></use>
                        </svg>
                    </a>
                </div> {{-- .marca-container --}}
                <div class="mpt-by">
                    <span class="texto-servicio">un servicio de:</span>
                    <a class="logo-uibb uibb-blanco" href="http://uibb.org.ar/">Unión Industrial Bahía Blanca</a>
                </div> {{-- .mpt-by --}}
            </div>
            <div class="col-md-9 col-sm-8">
                <ul class="list-inline nav-list menu-principal text-right">
                    <li><a href="{{ route('home') }}">
                        <strong>Inicio</strong>
                    </a></li>
                    <li><a href="{{ route('egresados', ['tipo'=>'tecnicos']) }}">
                        <strong>Egresados Técnicos</strong>
                    </a></li>
                    <li><a href="{{ route('egresados', ['tipo'=>'oficios']) }}">
                        <strong>Egresados de Oficios</strong>
                    </a></li>
                </ul>
                <ul class="list-inline nav-list menu-principal text-right">
                    <li><a href="{{ route('publicaciones_capacitaciones') }}">
                        <strong>Capacitaciones</strong>
                    </a></li>
                    <li><a href="{{ route('publicaciones_practicas') }}">
                        <strong>Prácticas profesionalizantes</strong>
                    </a></li>
                    <li><a href="{{ route('instituciones') }}">
                        <strong>Instituciones Educativas</strong>
                    </a></li>
                    {{-- <li><strong><a href="{{ url('/empresas')}}">Empresas</a></strong></li> --}}
                </ul> {{-- .menu-principal --}}
                <ul class="list-inline nav-list menu-tc-pp text-right">
                    <li><a href="{{ route('administracion') }}">
                        Panel de administración
                    </a></li>
                    <li><a href="{{ route('contacto') }}">
                        Contacto
                    </a></li>
                    <li><a href="{{ route('aviso_legal') }}">
                        Aviso legal
                    </a></li>

                    <!-- <li><a href="#ToDo">Políticas de privacidad</a></li> -->
                </ul> {{-- .menu-tc-pp --}}
            </div>
        </div> {{-- .contenido-footer --}}

        <div class="subfooter row">
            <div class="col-sm-6">
                <p class="copy text-left">Copyright:
                    <strong><a href="http://uibb.org.ar/">Unión Industrial Bahía Blanca</a> &copy;2016</strong>
                </p>
            </div>
            <div class="col-sm-6">
                <p class="imotion text-right">Diseño y desarrollo:
                    <strong><a href="http://www.imotionconsulting.com.ar">Imotion Consulting</a></strong>
                </p>
            </div>
        </div> {{-- .subfooter --}}
    </div> {{-- .container --}}
</footer>