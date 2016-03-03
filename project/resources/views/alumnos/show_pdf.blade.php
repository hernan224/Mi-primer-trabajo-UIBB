<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//ES"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $alumno->getFullName() }} | Mi Primer Trabajo</title>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
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

            <article class="alumno-individual">
                <header class="alumno-info-principal">

                    <div class="contenedor-foto">
                        <figure class="foto-bg foto-alumno">
                            @if($alumno->foto)
                                <img src="{{$alumno->getUrlFoto()}}" alt="{{ $alumno->getFullName() }}"
                                     class="img-responsive alumno-img">
                            @else
                                <img src="{{ ($alumno->sexo == 'm') ? url('img/alumno-sin-foto-masculino.png') : url('img/alumno-sin-foto-femenino.png')}}"
                                     class="img-responsive alumno-img">
                            @endif
                        </figure>
                    </div>

                    <div class="info-alumno">
                        <h2 class="nombre-alumno">{{ $alumno->getFullName() }}</h2>

                        <div class="datos-alumno">
                            <span class="li-falso sexo"><strong>Sexo:</strong> {{ ($alumno->sexo == 'm') ? 'Masculino' : 'Femenino' }}</span> &nbsp;&nbsp;
                            <span class="li-falso fec-nac"><strong>Fecha de Nac.:</strong> {{ $alumno->nacimiento }}</span> &nbsp;&nbsp;
                            <span class="li-falso edad"><strong>Edad:</strong> {{ $alumno->getEdad() }} años</span>
                            <br>
                            <span class="li-falso nacionalidad"><strong>Nacionalidad:</strong> {{ $alumno->nacionalidad }}</span> &nbsp;&nbsp;
                            <span class="li-falso dni"><strong>DNI:</strong> {{ $alumno->dni }}</span>
                        </div>
                    </div>

                    <div class="promedio">
                        <strong class="promedio-titulo">Promedio General</strong>
                        <span class="promedio-valor">{{ number_format($alumno->curriculum->promedio,2,',','') }}</span>
                    </div> <!--.promedio-->

                </header> <!--/header info principal-->
                <div class="fila-flex">
                    <aside class="info-contactos">
                        <section class="contacto-alumno panel-bg-color">
                            <h5 class="subtitulo texto-azul">Datos de contacto</h5>

                            <ul class="lista-contacto list-unstyled">
                                @if ($alumno->domicilio)
                                <li>
                                    <strong class="small">Direccion: </strong>
                                    {{ $alumno->domicilio }}
                                </li>
                                @endif
                                @if ($alumno->localidad || $alumno->barrio)
                                <li>
                                    <strong class="small">Localidad / barrio: </strong>
                                    {{ $alumno->localidad or '' }}
                                    {{ ($alumno->barrio) ? '(Barrio '.$alumno->barrio.')' : ''}}
                                </li>
                                @endif
                                @if ($alumno->tel_fijo)
                                <li>
                                    <strong class="small">Teléfono: </strong>
                                    {{ $alumno->tel_fijo }}
                                </li>
                                @endif
                                @if ($alumno->celular)
                                <li>
                                    <strong class="small">Celular: </strong>
                                    {{ $alumno->celular }}
                                </li>
                                @endif
                                @if ($alumno->email)
                                <li>
                                    <strong class="small">E-mail: </strong>
                                    {{$alumno->email}}
                                </li>
                                @endif
                            </ul>
                        </section> <!--/.contacto-alumno-->

                        <section class="contacto-docente panel-bg-color">
                            <h5 class="subtitulo texto-azul">Docente de contacto</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <span class="sr-only">Nombre: </span>
                                    <strong>{{ $alumno->docente->name }}</strong>
                                </li>
                                @if ($alumno->docente->telefono)
                                <li>
                                    <span class="sr-only">Teléfono: </span>
                                    {{ $alumno->docente->telefono }}
                                </li>
                                @endif
                                <li>
                                    <span class="sr-only">E-mail: </span>
                                    {{ $alumno->docente->email }}
                                </li>
                            </ul>
                        </section><!--/.contacto-docente-->
                    </aside><!--/.info-contactos-->

                    <main class="info-detalle">
                        <section class="info-curricular">
                            <h5 class="subtitulo texto-azul">Informacion curricular educativa</h5>
                            <p>
                                <strong>Servicio Educativo: </strong>
                                {{ $alumno->escuela->name }}
                            </p>
                            <p>
                                <strong>Especialidad: </strong>
                                {{ $alumno->curriculum->especialidad }}
                            </p>
                            @if ($alumno->curriculum->asignaturas)
                                <p>
                                    <strong>Asignaturas destacadas: </strong>
                                    {{ $alumno->curriculum->asignaturas }}
                                </p>
                            @endif
                            @if ($alumno->curriculum->practicas_tipo)
                                <p>
                                    <strong>Prácticas Profesionalizantes: </strong>
                                    {{ $alumno->curriculum->practicas_tipo }}
                                </p>
                                @if ($alumno->curriculum->practicas_lugar )
                                    <p><strong>Prácticas desarrolladas en:</strong>
                                        {{ $alumno->curriculum->practicas_lugar }}</p>
                                @endif
                            @endif
                        </section> <!--/.info-curricular-->

                        <section class="actitudes">
                            <h5 class="subtitulo texto-azul">Actitudes destacadas</h5>

                            <div class="lista-actitudes">
                                @foreach ($alumno->curriculum->getActitudes() as $actitud)
                                    <span class="li-falso"><i class="fa fa-li fa-check texto-azul"></i>{{ trans('app.'.$actitud) }}</span> &nbsp;&nbsp;
                                @endforeach
                            </div>
                        </section> <!--/.actitudes-->

                        @if ($alumno->curriculum->extras || $alumno->curriculum->participacion)
                        <section class="info-adicional">
                            <h5 class="subtitulo texto-azul">Informacion adicional</h5>
                            <div class="datos-alumno">
                                @if ($alumno->curriculum->extras)
                                <p>
                                    <strong>Hobbies, pasatiempos o actividades extracurriculares: </strong>
                                    {{ $alumno->curriculum->extras }}
                                </p>
                                @endif
                                @if ($alumno->curriculum->participacion)
                                <p>
                                    <strong>Participación institucional, social o deportiva: </strong>
                                    {{ $alumno->curriculum->participacion }}
                                </p>
                                @endif
                            </div>
                        </section> <!--/.info-adicional-->
                        @endif

                    </main> <!--/.info-detalle-->

                </div> <!--/.fila-flex-->

                @if ($alumno->curriculum->carta)
                <section class="carta-presentacion">
                    <h5 class="subtitulo texto-azul">Carta de presentacion</h5>
                    <p>{!! nl2br($alumno->curriculum->carta) !!}</p>
                </section> <!--/.carta-presntacion-->
                @endif

            </article> <!--/.alumno-individual-->


        </div> <!--/.container-->
    </div> <!--/#contenedorPrincipal-->
</div>

</body>
</html>