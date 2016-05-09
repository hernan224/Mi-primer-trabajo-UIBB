{{-- Vista de alumno y curriculum --}}
@extends('layouts.base')
{{-- La base incluye el header y footer --}}

@section('title')
    Alumno: {{ $alumno->getFullName() }}
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

{{-- Agrego estilos y scripts --}}
@section('styles')
    @parent
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('css/print.css') }}" media="print">
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            $('a#imprimir').click(function(event) {
                event.preventDefault();
                window.print();
            });
        });
    </script>
@endsection

@section('content')
    {{-- Barra superior --}}
    <nav class="nav-listado">
        <div class="container">
            <div class="row">
                <div class="col-xs-2 {{ ($editable) ? 'col-md-3': 'col-md-4' }}">
                    <a id="volverListado" href="{{ ($editable) ? route('escuela.admin_alumnos') : url('/listado-alumnos') }}" class="link-nav-listado texto-blanco text-left">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        <span class="hidden-sm hidden-xs">Volver al listado de alumnos</span>
                    </a>
                </div>

                <div class="col-xs-3 col-sm-2 col-md-3 {{ ($editable) ? 'col-sm-offset-2 col-md-offset-0': 'col-md-offset-3 col-sm-offset-2 col-xs-offset-4' }}">
                    <a id="descargarPDF" href="{{route('alumno_pdf',['id'=>$id])}}" class="link-nav-listado">
                        <span class="glyphicon glyphicon-save"></span>
                        <span class="texto-nav hidden-sm hidden-xs">Descargar PDF</span>
                    </a>
                </div> {{-- btn pdf --}}
                <div class="col-xs-3 col-sm-2">
                    <a id="imprimir" href="#" class="link-nav-listado">
                        <span class="glyphicon glyphicon-print"></span>
                        <span class="texto-nav hidden-sm hidden-xs">Imprimir</span>
                    </a>
                </div> {{-- btn imprimir --}}

                @if ($editable) {{-- chequear ademas que sea de la escuela --}}
                    {{-- BOTONES PARA MOSTRAR UNICAMENTE PARA ESCUELA --}}
                    <div class="col-xs-2 col-sm-2">
                        <a id="editar" href="{{ route('escuela.alumno_edit',['id'=>$id]) }}" class="link-nav-listado">
                            <span class="glyphicon glyphicon-edit"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Editar</span>
                        </a>
                    </div> {{-- btn editar --}}
                    <div class="col-xs-2 col-sm-2">
                        <a id="eliminar" href="#" class="link-nav-listado" data-toggle="modal" data-target="#confirmarEliminar">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="texto-nav hidden-sm hidden-xs">Eliminar</span>
                        </a>
                    </div> {{-- btn eliminar --}}
                @endif
            </div> {{-- .row --}}
        </div>
    </nav> {{-- /.nav-listado --}}

    <div class="container">
        <article class="alumno-individual">
            <header class="alumno-info-principal">

                <div class="contenedor-foto">
                    @if($alumno->foto)
                        <figure class="foto-bg foto-alumno" style="background-image: url({{$alumno->getUrlFoto()}});">
                            {{-- El tag img se usa solo para impresion --}}
                            <img src="{{$alumno->getUrlFoto()}}" alt="{{ $alumno->getFullName() }}"
                                 class="img-responsive alumno-img visible-print-block">
                        </figure>
                    @else  {{-- Si no tiene foto muestra placeholder --}}
                        <figure class="foto-bg foto-alumno sin-foto {{ ($alumno->sexo == 'm') ? 'masculino' : 'femenino'}}"></figure>
                    @endif
                </div>

                <div class="info-alumno">
                    <h2 class="nombre-alumno">{{ $alumno->getFullName() }}</h2>

                    <div class="datos-alumno">
                        <span class="sexo"><strong>Sexo:</strong> {{ ($alumno->sexo == 'm') ? 'Masculino' : 'Femenino' }}</span>
                        <span class="fec-nac"><strong>Fecha de Nac.:</strong> {{ $alumno->nacimiento }}</span>
                        <span class="edad"><strong>Edad:</strong> {{ $alumno->getEdad() }} años</span>
                        <span class="nacionalidad"><strong>Nacionalidad:</strong> {{ $alumno->nacionalidad }}</span>
                        <span class="dni"><strong>DNI:</strong> {{ $alumno->dni }}</span>
                    </div>
                </div>

                <div class="promedio">
                    <strong class="promedio-titulo">Promedio General</strong>
                    <span class="promedio-valor">{{ number_format($alumno->curriculum->promedio,2,',','') }}</span>
                </div>

            </header> {{-- /header info principal --}}

            <div class="fila-flex">
                <aside class="info-contactos">
                    <section class="contacto-alumno panel-bg-color">
                        <h5 class="subtitulo texto-azul">Datos de contacto</h5>

                        <ul class="fa-ul lista-contacto">
                            @if ($editable && $alumno->domicilio)
                            {{-- Sólo se muestra si es de la escuela --}}
                            <li>
                                <span class="sr-only">Direccion: </span>
                                <i class="fa fa-li fa-home"></i> {{ $alumno->domicilio }}
                            </li>
                            @endif
                            @if ($alumno->localidad || $alumno->barrio)
                            <li>
                                <span class="sr-only">Localidad / barrio: </span>
                                <i class="fa fa-li fa-map-marker"></i>{{ $alumno->localidad or '' }}
                                {{ ($alumno->barrio) ? '(Barrio '.$alumno->barrio.')' : ''}}
                            </li>
                            @endif
                            @if ($editable && $alumno->tel_fijo)
                            {{-- Sólo se muestra si es de la escuela --}}
                            <li>
                                <span class="sr-only">Teléfono: </span>
                                <i class="fa fa-li fa-phone"></i>{{ $alumno->tel_fijo }}
                            </li>
                            @endif
                            @if ($editable && $alumno->celular)
                            {{-- Sólo se muestra si es de la escuela --}}
                            <li>
                                <span class="sr-only">Celular: </span>
                                <i class="fa fa-li fa-mobile"></i>{{ $alumno->celular }}
                            </li>
                            @endif
                            @if ($editable && $alumno->email)
                            {{-- Sólo se muestra si es de la escuela --}}
                            <li>
                                <span class="sr-only">E-mail: </span>
                                <i class="fa fa-li fa-at"></i>
                                <a href="mailto:{{$alumno->email}}">{{$alumno->email}}</a>
                            </li>
                            @endif
                            {{-- Facebook, Twitter y LinkedIn deshabilitados
                            <li><span class="sr-only">Facebook: </span><i class="fa fa-li fa-facebook"></i><a href="#">facebook.com/hernan224</a></li>
                            <li><span class="sr-only">Twitter: </span><i class="fa fa-li fa-twitter"></i><a href="#">@hernan224</a></li>
                            <li><span class="sr-only">LinkedIn: </span><i class="fa fa-li fa-linkedin"></i><a href="#">linkedin.com/in/hernan224</a></li> --}}
                        </ul>
                        @if (!$editable)
                            <a href="#solicitarContacto" id="solicitarBtn" class="btn btn-registro hide-print">Solicitar más información</a>
                            <p class="hide-screen">Por cuestiones de privacidad, los datos de contacto del alumno se proporcionan vía mail, desde la plataforma.</p>
                        @endif
                    </section> {{-- /.contacto-alumno --}}

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
                    </section>{{-- /.contacto-docente --}}
                </aside>{{-- /.info-contactos --}}

                <main class="info-detalle">
                    <section class="info-curricular">
                        <h5 class="subtitulo texto-azul">Información curricular educativa</h5>
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
                        @if ($alumno->curriculum->estudios)
                        <p>
                            <strong>Continúa estudios superiores</strong>
                        </p>
                            @if ($alumno->curriculum->estudios_carrera )
                                <p><strong>Carrera:</strong>
                                {{ $alumno->curriculum->estudios_carrera }}</p>
                            @endif
                            @if ($alumno->curriculum->estudios_lugar )
                                <p><strong>Entidad educativa:</strong>
                                {{ $alumno->curriculum->estudios_lugar }}</p>
                            @endif
                        @endif
                    </section> {{-- /.info-curricular --}}

                    <section class="actitudes">
                        <h5 class="subtitulo texto-azul">Actitudes destacadas</h5>

                        <ul class="list-inline fa-ul lista-actitudes">
                        @foreach ($alumno->curriculum->getActitudes() as $actitud)
                            <li><i class="fa fa-li fa-check texto-azul"></i>{{ trans('app.'.$actitud) }}</li>
                        @endforeach
                        </ul>
                    </section> {{-- /.actitudes --}}

                    @if ($alumno->curriculum->extras || $alumno->curriculum->participacion)
                    <section class="info-adicional">
                        <h5 class="subtitulo texto-azul">Información adicional</h5>
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
                    </section> {{-- /.info-adicional --}}
                    @endif

                    @if ($alumno->curriculum->carta_presentacion)
                    <section class="carta-presentacion">
                        <h5 class="subtitulo texto-azul">Carta de presentación</h5>
                        <p>{!! nl2br($alumno->curriculum->carta_presentacion) !!}</p>
                    </section>
                    @endif
                </main> {{-- /.info-detalle --}}

            </div> {{-- /.fila-flex --}}

        </article> {{-- /.alumno-individual --}}
    </div>

    @if ($editable)
        @include('alumnos.modal_eliminar',['alumno'=>$alumno])
    @endif
    @include('alumnos.modal_solicitar_mail',['alumno_id'=>$alumno->id])
@endsection