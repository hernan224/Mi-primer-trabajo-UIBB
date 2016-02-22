{{-- Formulario para creación / edición de alumno y curriculum --}}
@extends('layouts.base_auth')
{{-- La base incluye el header y footer --}}

@section('title')
    @if ($nuevo)
        Cargar alumno
    @else
        Editar alumno: {{ $alumno->getFullName() }}
    @endif
@endsection

{{-- Agrego estilos y scripts --}}
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ url('css/vendor/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/vendor/jquery.bootstrap-touchspin.min.css') }}">
@endsection
@section('scripts')
    @parent
    <script src="{{ url('js/form_alumno.js') }}"></script>
@endsection

@section('content')
    {{-- Barra superior --}}
    <nav class="nav-listado">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-5 col-md-3">
                    <a id="volverListado" href="{{ url('/listado-alumnos') }}" class="link-nav-listado texto-blanco text-left">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Volver al listado de alumnos
                    </a>
                </div>
                @if (!$nuevo)
                {{-- Si esta editando: boton eliminar --}}
                    <div class="col-xs-3 col-sm-2 col-md-offset-7 col-sm-offset-5 col-xs-offset-3">
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
        <article class="cargar-alumno">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ ucfirst($error) }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            {{ Form::model($alumno, [
                'route' => ($nuevo) ? 'alumnos.nuevo_post' : ['alumnos.edit_put',$id],
                'method' => ($nuevo) ? 'POST' : 'PUT', 'files' => true,
                'role'=>"form", 'class'=>"fila-flex form-mpt" ] ) }}

                <main class="cargar-datos">
                    <h3 class="titulo-seccion">Cargar nuevo alumno</h3>

                    <fieldset class="row carga-datos-personales">
                        <div class="form-group col-sm-6{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            {{ Form::label('nombre', 'Nombres', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres','required'=>'required']) }}
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('apellido') ? ' has-error' : '' }}">
                            {{ Form::label('apellido', 'Apellidos', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('apellido',null,['class'=>'form-control','placeholder'=>'Apellido','required'=>'required']) }}
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('dni') ? ' has-error' : '' }}">
                            {{ Form::label('dni', 'DNI', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('dni',null,['class'=>'form-control','placeholder'=>'DNI nº','required'=>'required']) }}
                        </div>

                        <div class="form-group col-sm-6 cargar-sexo{{ $errors->has('sexo') ? ' has-error' : '' }}">
                            <div class="radio">
                                <strong>Sexo:</strong>
                                <label>
                                    {{ Form::radio('sexo', 'm') }}
                                    Masculino
                                </label>
                                <label>
                                    {{ Form::radio('sexo', 'f') }}
                                    Femenino
                                </label>
                            </div>
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('nacimiento') ? ' has-error' : '' }}">
                            {{ Form::label('nacimiento', 'Fecha de nacimiento', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('nacimiento',($nuevo) ? '' : null,['class'=>'form-control','placeholder'=>'Fecha de nacimiento','required'=>'required']) }}
                            <!-- FUNCIONA CON PLUGIN DATEPICKER -->
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('nacionalidad') ? ' has-error' : '' }}">
                            {{ Form::label('nacionalidad', 'Nacionalidad', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('nacionalidad',null,['class'=>'form-control','placeholder'=>'Nacionalidad','required'=>'required']) }}
                        </div>
                    </fieldset>

                    <fieldset class="carga-datos-contacto row">

                        <legend class="subtitulo h5 texto-azul">Datos de contacto</legend>

                        <div class="form-group col-xs-12{{ $errors->has('domicilio') ? ' has-error' : '' }}">
                            {{ Form::label('domicilio', 'Domicilio', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('domicilio',null,['class'=>'form-control','placeholder'=>'Domicilio']) }}
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('localidad') ? ' has-error' : '' }}">
                            {{ Form::label('localidad', 'Localidad', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('localidad',null,['class'=>'form-control','placeholder'=>'Localidad','required'=>'required']) }}
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('barrio') ? ' has-error' : '' }}">
                            {{ Form::label('barrio', 'Barrio', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('barrio',null,['class'=>'form-control','placeholder'=>'Barrio']) }}
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('tel_fijo') ? ' has-error' : '' }}">
                            {{ Form::label('tel_fijo', 'Teléfono fijo', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('tel_fijo',null,['class'=>'form-control','placeholder'=>'Teléfono fijo']) }}
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('celular') ? ' has-error' : '' }}">
                            {{ Form::label('celular', 'Teléfono móvil', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('celular',null,['class'=>'form-control','placeholder'=>'Teléfono móvil']) }}
                        </div>

                        <div class="form-group col-sm-12{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', 'E-mail', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail']) }}
                        </div>

                        {{-- Facebook, Twitter y Linkedin: deshabilitado
                        <div class="form-group col-sm-6{{ $errors->has('facebook') ? ' has-error' : '' }}">
                            {{ Form::label('facebook', 'Facebook ', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('facebook',null,['class'=>'form-control','placeholder'=>'Facebook']) }}
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('twitter') ? ' has-error' : '' }}">
                            {{ Form::label('twitter', 'Twitter', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('twitter',null,['class'=>'form-control','placeholder'=>'Twitter']) }}
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('linkedin') ? ' has-error' : '' }}">
                            {{ Form::label('linkedin', 'LinkedIn', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('linkedin',null,['class'=>'form-control','placeholder'=>'LinkedIn']) }}
                        </div>
                         --}}
                    </fieldset>

                    <fieldset class="carga-datos-curriculares row">
                        <legend class="subtitulo h5 texto-azul">Datos curriculares</legend>

                        <div class="form-group col-xs-12{{ $errors->has('especialidad') ? ' has-error' : '' }}">
                            {{ Form::label('especialidad', 'Especialidad cursada', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('especialidad',
                                (!$nuevo) ? $alumno->curriculum->especialidad : null ,
                                ['class'=>'form-control','placeholder'=>'Especialidad cursada','required' => 'required']) }}
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('promedio') ? ' has-error' : '' }}">
                            {{ Form::label('promedio', 'Promedio general', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('promedio',
                                (!$nuevo) ? $alumno->curriculum->promedio : null ,
                                ['id'=>'promedio','class'=>'form-control','placeholder'=>'Promedio general','required' => 'required']) }}
                            <!-- /*FUNCIONA CON PLUGIN TOUCHSPIN*/-->
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('asignaturas') ? ' has-error' : '' }}">
                            {{ Form::label('asignaturas', 'Asignaturas destacadas', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('asignaturas',
                                (!$nuevo) ? $alumno->curriculum->asignaturas : null,
                                ['class'=>'form-control','placeholder'=>'Asignaturas destacadas','required' => 'required']) }}
                        </div>

                        <div class="form-group col-sm-6{{ $errors->has('practicas_tipo') ? ' has-error' : '' }}">
                            {{ Form::label('practicas_tipo', 'Prácticas profesionalizantes', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('practicas_tipo',
                                (!$nuevo) ? $alumno->curriculum->practicas_tipo : null,
                                ['class'=>'form-control','placeholder'=>'Prácticas profesionalizantes']) }}
                        </div>
                        <div class="form-group col-sm-6{{ $errors->has('practicas_lugar') ? ' has-error' : '' }}">
                            {{ Form::label('practicas_lugar', '¿Dónde se desarrollaron?', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('practicas_lugar',
                                (!$nuevo) ? $alumno->curriculum->practicas_lugar : null,
                                ['class'=>'form-control','placeholder'=>'¿Dónde se desarrollaron?']) }}
                        </div>
                    </fieldset> {{-- /fieldset datos curriculares --}}

                    <fieldset class="carga-info-adicional row">
                        <legend class="subtitulo h5 texto-azul">Información adicional</legend>

                        <div class="form-group col-xs-12{{ $errors->has('actitudes') ? ' has-error' : '' }}">
                            <p><strong>Actitudes que se destacan:</strong></p>
                            <ul class="list-inline">

                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','responsabilidad',
                                            !$nuevo && $alumno->curriculum->responsabilidad) }} {{-- Si es true, lo chequea --}}
                                        {{ trans('app.responsabilidad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','puntualidad',
                                            !$nuevo && $alumno->curriculum->puntualidad) }}
                                        {{ trans('app.puntualidad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','proactividad',
                                            !$nuevo && $alumno->curriculum->proactividad) }}
                                        {{ trans('app.proactividad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','equipo',
                                            !$nuevo && $alumno->curriculum->equipo) }}
                                        {{ trans('app.equipo') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','creatividad',
                                            !$nuevo && $alumno->curriculum->creatividad) }}
                                        {{ trans('app.creatividad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','liderazgo',
                                            !$nuevo && $alumno->curriculum->liderazgo) }}
                                        {{ trans('app.liderazgo') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','conciliador',
                                            !$nuevo && $alumno->curriculum->conciliador) }}
                                        {{ trans('app.conciliador') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','perseverancia',
                                            !$nuevo && $alumno->curriculum->perseverancia) }}
                                        {{ trans('app.perseverancia') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','asertividad',
                                            !$nuevo && $alumno->curriculum->asertividad) }}
                                        {{ trans('app.asertividad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','relaciones',
                                            !$nuevo && $alumno->curriculum->relaciones) }}
                                        {{ trans('app.relaciones') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','objetivos',
                                            !$nuevo && $alumno->curriculum->objetivos) }}
                                        {{ trans('app.objetivos') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','saludable',
                                            !$nuevo && $alumno->curriculum->saludable) }}
                                        {{ trans('app.saludable') }}
                                    </label>
                                </div></li>
                            </ul>
                        </div>

                        <div class="form-group col-xs-12{{ $errors->has('extras') ? ' has-error' : '' }}">
                            {{ Form::label('extras', 'Hobbies, pasatiempos y aptitudes extra educacionales', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('extras',
                                (!$nuevo) ? $alumno->curriculum->extras : null,
                                ['class'=>'form-control','placeholder'=>'Hobbies, pasatiempos y aptitudes extra educacionales']) }}
                        </div>
                        <div class="form-group col-xs-12{{ $errors->has('participacion') ? ' has-error' : '' }}">
                            {{ Form::label('participacion', 'Participación institucional, social y deportiva', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('participacion',
                                (!$nuevo) ? $alumno->curriculum->participacion : null,
                                ['class'=>'form-control','placeholder'=>'Participación institucional, social y deportiva']) }}
                        </div>

                    </fieldset> {{-- /fieldset info-adicional --}}

                    <fieldset class="carga-carta row">
                        <legend class="subtitulo h5 texto-azul">Carta de presentación</legend>
                        <div class="form-group col-xs-12{{ $errors->has('carta') ? ' has-error' : '' }}">
                            {{ Form::label('carta', 'Carta de presentación', ["class"=>"sr-only"]) }}
                            {{ Form::textarea('carta',
                                (!$nuevo) ? $alumno->curriculum->carta : null,
                                ['class'=>'form-control','placeholder'=>'Carta de presentación','rows' => 6]) }}
                        </div>
                    </fieldset>

                </main> {{-- .cargar-datos --}}

                <aside class="datos-fijos">
                    <section class="cargar-foto">

                        <label class="cargar-foto-btn text-center">
                            <figure id='foto-preview' class="foto-bg foto-alumno foto-placeholder"
                            {!! (!$nuevo && $alumno->foto) ? 'style="background-image: url('.$alumno->getUrlFoto().');"' : '' !!} >
                            </figure>

                            <strong>{{ (!$nuevo && $alumno->foto) ? 'Cambiar la ' : 'Cargar una ' }}foto del alumno</strong>
                            {{ Form::file('foto',['id'=>"cargarFoto", 'accept'=>".jpeg, .jpg, .png"]) }}
                        </label>

                        <span class="error small"></span>
                        <span class="small">Tamaño mínimo: 360px x 360px. Formato: JPG, JPEG o PNG. Peso máximo: 1Mb. </span>
                    </section>
                    <section class="guardar-datos panel-bg-color">
                        <div class="contenedor-datos-fijos">
                        @if ($nuevo)
                            <p><strong>Docente a cargo: </strong>{{ Auth::user()->name }}</p>
                            <p><strong>Servicio Educativo: </strong><br>{{ Auth::user()->escuela->name }}</p>
                        @else
                            <p><strong>Creado / Editado: </strong>{{ $alumno->curriculum->updated_at }}</p>
                            <p><strong>Docente a cargo: </strong>{{ $alumno->docente->name }}</p>
                            <p><strong>Servicio Educativo: </strong><br>{{ $alumno->escuela->name }}</p>
                        @endif
                        </div>

                        <div class="contenedor-btns">
                            {{ Form::button( ($nuevo) ? 'Cargar alumno' : 'Guardar cambios', ['type' => 'submit','class' => 'btn btn-primary btn-guardar']) }}
                            @if ($nuevo)
                                <button type="reset" class="btn btn-link btn-descartar">Descartar</button>
                            @else
                                <a href="{{ route('alumnos.show',['id' => $id ]) }}" class="btn btn-link btn-descartar">Descartar cambios</a>
                            @endif
                        </div>
                    </section>

                </aside> {{-- /.datos-fijos --}}

            {{ Form::close() }} {{-- .fila-flex --}}
        </article> {{-- ./cargar-alumno --}}
    </div> {{-- ./container --}}
    @include('layouts.spinner')

    @include('alumnos.modal_eliminar',['alumno'=>$alumno])

@endsection