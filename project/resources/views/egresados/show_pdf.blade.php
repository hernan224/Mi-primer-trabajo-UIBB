<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//ES"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $egresado->getFullName() }} | Mi Primer Trabajo</title>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="{{ url('css/generar-pdf.css') }}" media="print">

</head>
<body>

<div class="container-general-flex">
    <div class="contenedor-principal">
        <div class="container">

            <header class="header-acceso acceso-asociado fila-flex">
                <div class="marca-container">
                    <figure class="logo-mpt">
                        <img src="{{ url('img/logo-mpt.png') }}" alt="Mi Primer Trabajo"
                             class="img-responsive logo-pdf">
                    </figure>
                </div> <!--.marca-container-->
            </header>

            <article class="egresado-individual">
                <header class="egresado-info-principal">

                    <div class="contenedor-foto">
                        <figure class="foto-bg foto-egresado">
                            @if($egresado->foto)
                                <img src="{{$egresado->getUrlFoto()}}" alt="{{ $egresado->getFullName() }}"
                                     class="img-responsive egresado-img">
                            @else
                                <img src="{{ ($egresado->sexo == 'm') ? url('img/alumno-sin-foto-masculino.png') : url('img/alumno-sin-foto-femenino.png')}}"
                                     class="img-responsive egresado-img" alt="{{ $egresado->getFullName() }}">
                            @endif
                        </figure>
                    </div>

                    <div class="info-egresado">
                        <h2 class="nombre-egresado">{{ $egresado->getFullName() }}</h2>

                        <div class="datos-egresado">
                            <span class="li-falso sexo"><strong>Sexo:</strong> {{ ($egresado->sexo == 'm') ? 'Masculino' : 'Femenino' }}</span> &nbsp;&nbsp;
                            <span class="li-falso fec-nac"><strong>Fecha de Nac.:</strong> {{ $egresado->nacimiento }}</span> &nbsp;&nbsp;
                            <span class="li-falso edad"><strong>Edad:</strong> {{ $egresado->getEdad() }} años</span>
                            <br>
                            <span class="li-falso nacionalidad"><strong>Nacionalidad:</strong> {{ $egresado->nacionalidad }}</span> &nbsp;&nbsp;
                            <span class="li-falso dni"><strong>DNI:</strong> {{ $egresado->dni }}</span>
                        </div>
                    </div>

                    {{--<div class="promedio">
                        <strong class="promedio-titulo">Promedio General</strong>
                        <span class="promedio-valor">{{ number_format($egresado->curriculum->promedio,2,',','') }}</span>
                    </div> --}}

                </header> <!--/header info principal-->
                <div class="fila-flex">
                    <aside class="info-contactos">
                        <section class="contacto-egresado panel-bg-color">
                            <h5 class="subtitulo texto-azul">Datos de contacto</h5>

                            <ul class="lista-contacto list-unstyled">
                                @if ($editable && $egresado->domicilio)
                                {{-- Sólo se muestra si es de la institucion --}}
                                <li>
                                    <strong class="small">Direccion: </strong>
                                    {{ $egresado->domicilio }}
                                </li>
                                @endif
                                @if ($egresado->localidad || $egresado->barrio)
                                <li>
                                    <strong class="small">Localidad / barrio: </strong>
                                    {{ $egresado->localidad or '' }}
                                    {{ ($egresado->barrio) ? '(Barrio '.$egresado->barrio.')' : ''}}
                                </li>
                                @endif
                                @if ($editable && $egresado->tel_fijo)
                                {{-- Sólo se muestra si es de la institucion --}}
                                <li>
                                    <strong class="small">Teléfono: </strong>
                                    {{ $egresado->tel_fijo }}
                                </li>
                                @endif
                                @if ($editable && $egresado->celular)
                                {{-- Sólo se muestra si es de la institucion --}}
                                <li>
                                    <strong class="small">Celular: </strong>
                                    {{ $egresado->celular }}
                                </li>
                                @endif
                                @if ($editable && $egresado->email)
                                {{-- Sólo se muestra si es de la institucion --}}
                                <li>
                                    <strong class="small">E-mail: </strong>
                                    {{$egresado->email}}
                                </li>
                                @endif
                            </ul>
                            @if (!$editable)
                                <p>Por cuestiones de privacidad, los datos de contacto del egresado se proporcionan vía mail, desde la plataforma.</p>
                            @endif
                        </section>

                        <section class="contacto-docente panel-bg-color">
                            <h5 class="subtitulo texto-azul">Docente de contacto</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <span class="sr-only">Nombre: </span>
                                    <strong>{{ $egresado->docente->name }}</strong>
                                </li>
                                @if ($egresado->docente->telefono)
                                <li>
                                    <span class="sr-only">Teléfono: </span>
                                    {{ $egresado->docente->telefono }}
                                </li>
                                @endif
                                <li>
                                    <span class="sr-only">E-mail: </span>
                                    {{ $egresado->docente->email }}
                                </li>
                            </ul>
                        </section><!--/.contacto-docente-->
                    </aside><!--/.info-contactos-->

                    <main class="info-detalle">
                        <section class="info-curricular">
                            <h5 class="subtitulo texto-azul">Informacion curricular educativa</h5>
                            <p>
                                <strong>Servicio Educativo: </strong>
                                {{ $egresado->institucion->name }}
                            </p>
                            @if ($egresado->curriculum->rubro) {{-- Sólo va a estar definido en oficios --}}
                            <p>
                                <strong>Rubro: </strong>
                                {{ $egresado->curriculum->rubro }}
                            </p>
                            @endif
                            @if ($egresado->curriculum->especialidad)
                                <p>
                                    <strong>Especialidad: </strong>
                                    {{ $egresado->curriculum->especialidad }}
                                </p>
                            @endif
                            @if ($egresado->curriculum->promedio)
                                <p>
                                    <strong>Promedio General: </strong>
                                    {{ number_format($egresado->curriculum->promedio,2,',','') }}
                                </p>
                            @endif
                            @if ($egresado->curriculum->asignaturas)
                                <p>
                                    <strong>Asignaturas destacadas: </strong>
                                    {{ $egresado->curriculum->asignaturas }}
                                </p>
                            @endif
                            @if ($egresado->curriculum->practicas_tipo)
                                <p>
                                    <strong>Prácticas Profesionalizantes: </strong>
                                    {{ $egresado->curriculum->practicas_tipo }}
                                </p>
                                @if ($egresado->curriculum->practicas_lugar )
                                    <p><strong>Prácticas desarrolladas en:</strong>
                                        {{ $egresado->curriculum->practicas_lugar }}</p>
                                @endif
                            @endif
                            @if ($egresado->curriculum->formacion_complementaria)
                                <p>
                                    <strong>Formación complementaria: </strong>
                                    {{ $egresado->curriculum->formacion_complementaria }}
                                </p>
                            @endif
                        </section> <!--/.info-curricular-->

                        @if (count($egresado->curriculum->getActitudes()))
                        <section class="actitudes">
                            <h5 class="subtitulo texto-azul">Actitudes destacadas</h5>

                            <div class="lista-actitudes">
                                @foreach ($egresado->curriculum->getActitudes() as $actitud)
                                    <span class="li-falso"><i class="fa fa-li fa-check texto-azul"></i>{{ trans('app.'.$actitud) }}</span> &nbsp;&nbsp;
                                @endforeach
                            </div>
                        </section> <!--/.actitudes-->
                        @endif

                        @if ($egresado->curriculum->extras || $egresado->curriculum->participacion)
                        <section class="info-adicional">
                            <h5 class="subtitulo texto-azul">Informacion adicional</h5>
                            <div class="datos-egresado">
                                @if ($egresado->curriculum->extras)
                                <p>
                                    <strong>Hobbies, pasatiempos o actividades extracurriculares: </strong>
                                    {{ $egresado->curriculum->extras }}
                                </p>
                                @endif
                                @if ($egresado->curriculum->participacion)
                                <p>
                                    <strong>Participación institucional, social o deportiva: </strong>
                                    {{ $egresado->curriculum->participacion }}
                                </p>
                                @endif
                            </div>
                        </section> <!--/.info-adicional-->
                        @endif

                    </main> <!--/.info-detalle-->

                </div> <!--/.fila-flex-->

                @if ($egresado->curriculum->carta_presentacion)
                <section class="carta-presentacion">
                    <h5 class="subtitulo texto-azul">Carta de presentacion</h5>
                    <p>{!! nl2br($egresado->curriculum->carta_presentacion) !!}</p>
                </section> <!--/.carta-presntacion-->
                @endif

            </article> <!--/.egresado-individual-->


        </div> <!--/.container-->
    </div> <!--/#contenedorPrincipal-->
</div>

</body>
</html>