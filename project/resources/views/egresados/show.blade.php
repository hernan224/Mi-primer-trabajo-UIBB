{{-- Vista de egresado y curriculum --}}
@extends('layouts.base')
{{-- La base incluye el header y footer --}}

@section('title')
    Alumno: {{ $egresado->getFullName() }}
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
                    <a id="volverListado" href="{{ $url_back }}" class="link-nav-listado texto-blanco text-left">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        <span class="hidden-sm hidden-xs">Volver al listado de egresados</span>
                    </a>
                </div>

                <div class="col-xs-3 col-sm-2 col-md-3 {{ ($editable) ? 'col-sm-offset-2 col-md-offset-0': 'col-md-offset-3 col-sm-offset-2 col-xs-offset-4' }}">
                    <a id="descargarPDF" href="{{route('egresado_pdf',['id'=>$id])}}" class="link-nav-listado">
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

                @if ($editable) {{-- chequear ademas que sea de la institucion --}}
                    {{-- BOTONES PARA MOSTRAR UNICAMENTE PARA INSTITUCIÓN --}}
                    <div class="col-xs-2 col-sm-2">
                        <a id="editar" href="{{ route('institucion.egresado_edit',['id'=>$id]) }}" class="link-nav-listado">
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
        <article class="egresado-individual">
            <header class="egresado-info-principal">

                <div class="contenedor-foto">
                    @if($egresado->foto)
                        <figure class="foto-bg foto-egresado" style="background-image: url({{$egresado->getUrlFoto()}});">
                            {{-- El tag img se usa solo para impresion --}}
                            <img src="{{$egresado->getUrlFoto()}}" alt="{{ $egresado->getFullName() }}"
                                 class="img-responsive egresado-img visible-print-block">
                        </figure>
                    @else  {{-- Si no tiene foto muestra placeholder --}}
                        <figure class="foto-bg foto-egresado sin-foto {{ ($egresado->sexo == 'm') ? 'masculino' : 'femenino'}}"></figure>
                    @endif
                </div>

                <div class="info-egresado">
                    <h2 class="nombre-egresado">{{ $egresado->getFullName() }}</h2>

                    <div class="datos-egresado">
                        <span class="fec-nac"><strong>Fecha de Nac.:</strong> {{ $egresado->nacimiento }}</span>
                        <span class="edad"><strong>Edad:</strong> {{ $egresado->getEdad() }} años</span>
                        <span class="sexo"><strong>Sexo:</strong> {{ ($egresado->sexo == 'm') ? 'Masculino' : 'Femenino' }}</span>
                        <span class="nacionalidad"><strong>Nacionalidad:</strong> {{ $egresado->nacionalidad }}</span>
                        {{-- <span class="dni"><strong>DNI:</strong> {{ $egresado->dni }}</span> --}}
                    </div>
                </div>

                {{--<div class="promedio">
                    <strong class="promedio-titulo">Promedio General</strong>
                    <span class="promedio-valor">{{ number_format($egresado->curriculum->promedio,2,',','') }}</span>
                </div>--}}

            </header> {{-- /header info principal --}}

            <div class="fila-flex">
                <aside class="info-contactos">
                    <section class="contacto-egresado panel-bg-color">
                        <h5 class="subtitulo texto-azul">Datos de contacto</h5>

                        <ul class="fa-ul lista-contacto">
                            @if ($editable && $egresado->domicilio)
                            {{-- Sólo se muestra si es egresado de la institución del usuario logueado (si no, debe pedirse por mail) --}}
                            <li>
                                <span class="sr-only">Direccion: </span>
                                <i class="fa fa-li fa-home"></i> {{ $egresado->domicilio }}
                            </li>
                            @endif
                            @if ($egresado->localidad || $egresado->barrio)
                            <li>
                                <span class="sr-only">Localidad / barrio: </span>
                                <i class="fa fa-li fa-map-marker"></i>{{ $egresado->localidad or '' }}
                                {{ ($egresado->barrio) ? '(Barrio '.$egresado->barrio.')' : ''}}
                            </li>
                            @endif
                            @if ($editable && $egresado->tel_fijo)
                            {{-- Sólo se muestra si es egresado de la institución del usuario logueado (si no, debe pedirse por mail) --}}
                            <li>
                                <span class="sr-only">Teléfono: </span>
                                <i class="fa fa-li fa-phone"></i>{{ $egresado->tel_fijo }}
                            </li>
                            @endif
                            @if ($editable && $egresado->celular)
                            {{-- Sólo se muestra si es egresado de la institución del usuario logueado (si no, debe pedirse por mail) --}}
                            <li>
                                <span class="sr-only">Celular: </span>
                                <i class="fa fa-li fa-mobile"></i>{{ $egresado->celular }}
                            </li>
                            @endif
                            @if ($editable && $egresado->email)
                            {{-- Sólo se muestra si es egresado de la institución del usuario logueado (si no, debe pedirse por mail) --}}
                            <li>
                                <span class="sr-only">E-mail: </span>
                                <i class="fa fa-li fa-at"></i>
                                <a href="mailto:{{$egresado->email}}">{{$egresado->email}}</a>
                            </li>
                            @endif
                            {{-- Facebook, Twitter y LinkedIn deshabilitados
                            <li><span class="sr-only">Facebook: </span><i class="fa fa-li fa-facebook"></i><a href="#">facebook.com/hernan224</a></li>
                            <li><span class="sr-only">Twitter: </span><i class="fa fa-li fa-twitter"></i><a href="#">@hernan224</a></li>
                            <li><span class="sr-only">LinkedIn: </span><i class="fa fa-li fa-linkedin"></i><a href="#">linkedin.com/in/hernan224</a></li> --}}
                        </ul>
                        @if (!$editable)
                            <a href="#solicitarContacto" id="solicitarBtn" class="btn btn-registro hide-print">Solicitar más información</a>
                            <p class="hide-screen">Por cuestiones de privacidad, los datos de contacto del egresado se proporcionan vía mail, desde la plataforma.</p>
                        @endif
                    </section> {{-- /.contacto-egresado --}}

                    {{-- Docente de contacto: sólo se muestra si el egresado es de la institución del usuario logueado --}}
                    @if ($editable)
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
                    </section>{{-- /.contacto-docente --}}
                    @endif

                </aside>{{-- /.info-contactos --}}

                <main class="info-detalle">
                    <section class="info-curricular">
                        <h5 class="subtitulo texto-azul">Información curricular educativa</h5>
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
                        @if ($egresado->curriculum->estudios)
                        <p>
                            <strong>Continúa estudios superiores</strong>
                        </p>
                            @if ($egresado->curriculum->estudios_carrera )
                                <p><strong>Carrera:</strong>
                                {{ $egresado->curriculum->estudios_carrera }}</p>
                            @endif
                            @if ($egresado->curriculum->estudios_lugar )
                                <p><strong>Entidad educativa:</strong>
                                {{ $egresado->curriculum->estudios_lugar }}</p>
                            @endif
                        @endif
                        @if ($egresado->curriculum->formacion_complementaria)
                            <p>
                                <strong>Formación complementaria: </strong>
                                {{ $egresado->curriculum->formacion_complementaria }}
                            </p>
                        @endif
                    </section> {{-- /.info-curricular --}}

                    @if (count($egresado->curriculum->getActitudes()))
                    <section class="actitudes">
                        <h5 class="subtitulo texto-azul">Actitudes destacadas</h5>

                        <ul class="list-inline fa-ul lista-actitudes">
                        @foreach ($egresado->curriculum->getActitudes() as $actitud)
                            <li><i class="fa fa-li fa-check texto-azul"></i>{{ trans('app.'.$actitud) }}</li>
                        @endforeach
                        </ul>
                    </section> {{-- /.actitudes --}}
                    @endif

                    @if ($egresado->curriculum->extras || $egresado->curriculum->participacion)
                    <section class="info-adicional">
                        <h5 class="subtitulo texto-azul">Información adicional</h5>
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
                    </section> {{-- /.info-adicional --}}
                    @endif

                    @if ($egresado->curriculum->carta_presentacion)
                    <section class="carta-presentacion">
                        <h5 class="subtitulo texto-azul">Carta de presentación</h5>
                        <p>{!! nl2br($egresado->curriculum->carta_presentacion) !!}</p>
                    </section>
                    @endif
                </main> {{-- /.info-detalle --}}

            </div> {{-- /.fila-flex --}}

        </article> {{-- /.egresado-individual --}}
    </div>

    @if ($editable)
        @include('egresados.modal_eliminar')  {{-- Ya está seteado $egresado --}}
    @endif
    @include('egresados.modal_solicitar_mail',['egresado_id'=>$egresado->id])
    @include('layouts.spinner')
@endsection