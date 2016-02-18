{{-- Vista de alumno y curriculum --}}
@extends('layouts.base_auth')
{{-- La base incluye el header y footer --}}

@section('title')
    Alumno: {{ $alumno->getFullName() }}
@endsection

{{-- Agrego estilos y scripts --}}
@section('styles')
    @parent
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('css/print-pdf.css') }}" media="print">
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
                <div class="col-xs-2 {{ (Auth::user()->puedeEditar()) ? 'col-md-3': 'col-md-4' }}">
                    <a id="volverListado" href="{{ url('/listado-alumnos') }}" class="link-nav-listado texto-blanco text-left">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        <span class="hidden-sm hidden-xs">Volver al listado de alumnos</span>
                    </a>
                </div>

                <div class="col-xs-3 col-sm-2 col-md-3 {{ (Auth::user()->puedeEditar()) ? 'col-sm-offset-2 col-md-offset-0': 'col-md-offset-3 col-sm-offset-2 col-xs-offset-4' }}">
                    <a id="descargarPDF" href="#ToDo" class="link-nav-listado">
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

                @if (Auth::user()->puedeEditar())
                    {{-- BOTONES PARA MOSTRAR UNICAMENTE PARA ESCUELA --}}
                    <div class="col-xs-2 col-sm-2">
                        <a id="editar" href="{{ route('alumnos.edit',['id'=>$id]) }}" class="link-nav-listado">
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
                    <figure class="foto-bg foto-alumno">
                    @if($alumno->foto)
                        <img src="{{$alumno->getUrlFoto()}}" alt="{{$alumno->getFullName()}}" class="img-responsive alumno-img">
                    @else  {{-- Si no tiene foto muestra placeholder --}}
                        <img src="{{ ($alumno->sexo == 'm') ? url('img/alumno-sin-foto-femenino.jpg') : url('img/alumno-sin-foto-femenino.png')}}" alt="" class="img-responsive alumno-img">
                    @endif
                    </figure>
                </div>

                <div class="info-alumno">
                    <h2 class="nombre-alumno">{{ $alumno->getFullName() }}</h2>

                    <div class="datos-alumno">
                        <span class="sexo"><strong>Sexo:</strong> {{ ($alumno->sexo == 'm') ? 'Masculino' : 'Femenino' }}</span>
                        <span class="fec-nac"><strong>Fecha de Nac.:</strong> {{ $alumno->nacimiento }}</span>
                        <span class="edad"><strong>Edad:</strong> {{ $alumno->getEdad() }}</span>
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
                            @if ($alumno->domicilio)
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
                            @if ($alumno->tel_fijo)
                            <li>
                                <span class="sr-only">Teléfono: </span>
                                <i class="fa fa-li fa-phone"></i>{{ $alumno->tel_fijo }}
                            </li>
                            @endif
                            @if ($alumno->celular)
                            <li>
                                <span class="sr-only">Celular: </span>
                                <i class="fa fa-li fa-mobile"></i>{{ $alumno->celular }}
                            </li>
                            @endif
                            @if ($alumno->email)
                            <li>
                                <span class="sr-only">E-mail: </span>
                                <i class="fa fa-li fa-at"></i>
                                <a href="mailto:{{$alumno->email}}">{{$alumno->email}}</a>
                            </li>
                            @endif
                            {{-- Facebook, Twitter y LinkedIn deshabilitados
                            <li><span class="sr-only">Facebook: </span><i class="fa fa-li fa-facebook"></i><a href="#">facebook.com/hernan224</a></li> <!--Facebook-->
                            <li><span class="sr-only">Twitter: </span><i class="fa fa-li fa-twitter"></i><a href="#">@hernan224</a></li> <!--Twitter-->
                            <li><span class="sr-only">LinkedIn: </span><i class="fa fa-li fa-linkedin"></i><a href="#">linkedin.com/in/hernan224</a></li> <!--Linkedin--> --}}
                        </ul>
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
                        @if ($alumno->curriculum->practicas_tipo)
                        <p>
                            <strong>Práctica Profesional: </strong>
                            {{ $alumno->curriculum->practicas_tipo }}
                            @if ($alumno->curriculum->practicas_lugar )
                            <br>
                            (Realizada en <strong>{{ $alumno->curriculum->practicas_lugar }}</strong>)
                            @endif
                        </p>
                        @endif
                        <p><strong>Asignaturas destacadas: </strong>{{ $alumno->curriculum->asignaturas }}</p>
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

                    @if ($alumno->curriculum->carta)
                    <section class="carta-presentacion">
                        <h5 class="subtitulo texto-azul">Carta de presentación</h5>
                        <p>{!! nl2br($alumno->curriculum->carta) !!}</p>
                    </section>
                    @endif
                </main> {{-- /.info-detalle --}}

            </div> {{-- /.fila-flex --}}

        </article> {{-- /.alumno-individual --}}
    </div>

    @if (Auth::user()->puedeEditar())
        @include('alumnos.modal_eliminar',['alumno'=>$alumno])
    @endif
@endsection