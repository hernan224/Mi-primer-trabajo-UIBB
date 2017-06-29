{{-- Formulario para creación / edición de egresado y curriculum --}}
@extends('layouts.base')

@section('title')
    @if ($nuevo)
        Cargar egresado
    @else
        Editar egresado: {{ $egresado->getFullName() }}
    @endif
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

{{-- Agrego estilos y scripts --}}
@section('styles')
    @parent
    <link rel="stylesheet" href="{{ url('css/vendor/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/vendor/jquery.bootstrap-touchspin.min.css') }}">
@endsection
@section('scripts')
    @parent
    <script src="{{ url('js/form_egresado.js') }}"></script>
    <script>
        var data_egresado = {
            tipo: '{{ $tipo }}',
            rubros: '{!! json_encode(config("categorias.$tipo.rubros"), JSON_UNESCAPED_UNICODE) !!}',
            especialidades: '{!! json_encode(config("categorias.$tipo.especialidades"), JSON_UNESCAPED_UNICODE) !!}'
        };
        @if (!$nuevo)
            data_egresado.rubro_selected = '{!! $egresado->curriculum->rubro !!}';
            data_egresado.especialidad_selected = '{!! $egresado->curriculum->especialidad !!}';
        @endif
    </script>
@endsection

@section('content')
    {{-- Barra superior --}}
    <nav class="nav-listado">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-5 col-md-3">
                    <a id="volverListado" href="{{ route('institucion.admin_egresados') }}" class="link-nav-listado texto-blanco text-left">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Volver al listado de egresados
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
        <article class="cargar-egresado">
            {{ Form::model($egresado, [
                'route' => ($nuevo) ? 'institucion.egresado_nuevo_post' : ['institucion.egresado_edit_put',$id],
                'method' => ($nuevo) ? 'POST' : 'PUT', 'files' => true,
                'role'=>"form", 'class'=>"fila-flex form-mpt" ] ) }}

                {{ Form::hidden('tipo',$tipo) }}

                <main class="cargar-datos">
                    <h3 class="titulo-seccion">
                        {{ ($nuevo) ? 'Cargar nuevo egresado' : 'Editar egresado' }}
                    </h3>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ ucfirst($error) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <fieldset class="row carga-datos-personales">
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            {{ Form::label('nombre', 'Nombres', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombres','required'=>'required']) }}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('apellido') ? ' has-error' : '' }}">
                            {{ Form::label('apellido', 'Apellidos', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('apellido',null,['class'=>'form-control','placeholder'=>'Apellido','required'=>'required']) }}
                        </div>

                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('dni') ? ' has-error' : '' }}">
                            {{ Form::label('dni', 'DNI', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('dni',($nuevo || !$egresado->dni) ? '' : null,['class'=>'form-control','placeholder'=>'DNI nº']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 cargar-sexo{{ $errors->has('sexo') ? ' has-error' : '' }}">
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

                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('nacimiento') ? ' has-error' : '' }}">
                            <!-- FUNCIONA CON PLUGIN DATEPICKER -->
                            {{ Form::label('nacimiento', 'Fecha de nacimiento', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('nacimiento',($nuevo || !$egresado->nacimiento) ? '' : null,['class'=>'form-control','placeholder'=>'Fecha de nacimiento']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('nacionalidad') ? ' has-error' : '' }}">
                            {{ Form::label('nacionalidad', 'Nacionalidad', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('nacionalidad',null,['class'=>'form-control','placeholder'=>'Nacionalidad']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
                        </div>
                    </fieldset>

                    <fieldset class="carga-datos-contacto row">

                        <legend class="subtitulo h5 texto-azul">Datos de contacto</legend>

                        <div class="form-group col-xs-12 col-xs-12{{ $errors->has('domicilio') ? ' has-error' : '' }}">
                            {{ Form::label('domicilio', 'Domicilio', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('domicilio',null,['class'=>'form-control','placeholder'=>'Domicilio']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
                        </div>

                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('localidad') ? ' has-error' : '' }}">
                            {{ Form::label('localidad', 'Localidad', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('localidad',null,['class'=>'form-control','placeholder'=>'Localidad']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('barrio') ? ' has-error' : '' }}">
                            {{ Form::label('barrio', 'Barrio', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('barrio',null,['class'=>'form-control','placeholder'=>'Barrio']) }}
                        </div>

                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('tel_fijo') ? ' has-error' : '' }}">
                            {{ Form::label('tel_fijo', 'Teléfono fijo', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('tel_fijo',null,['class'=>'form-control','placeholder'=>'Teléfono fijo']) }}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('celular') ? ' has-error' : '' }}">
                            {{ Form::label('celular', 'Teléfono móvil', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('celular',null,['class'=>'form-control','placeholder'=>'Teléfono móvil']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
                        </div>

                        <div class="form-group col-xs-12 col-sm-12{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', 'E-mail', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail']) }}
                                {{-- ToDo: setear atributo required si no es privado --}}
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

                        <div class="form-group col-xs-12">
                            <div class="row">
                                <div class="col-xs-12"><p><strong>Especialidad cursada:</strong></p></div>
                                @if ($tipo == \App\Models\Egresado::TIPO_OFICIOS_LABEL)
                                <div class="col-sm-5 col-xs-12 {{ $errors->has('rubro') ? ' has-error' : '' }}">
                                    {{ Form::label('rubro', 'Rubro', ["class"=>"sr-only input-label small"]) }}
                                    {{-- Las options y el valor seleccionado si no es nuevo se cargan inicialmente por js  --}}
                                    {{ Form::select('rubro', [], null ,
                                        ['class'=>'form-control select-carga-egresado','placeholder'=>'Elegir rubro...',
                                        'required'=>'required']) }}
                                </div>
                                @endif
                                <div class="col-sm-7 col-xs-12 {{ $errors->has('especialidad') ? ' has-error' : '' }}">
                                    {{ Form::label('especialidad', 'Especialidad', ["class"=>"sr-only input-label small"]) }}
                                    {{-- Las options y el valor seleccionado si no es nuevo se cargan por js
                                        Las opciones cambian de forma dinámica según rubro elegido, en caso de tipo=oficio--}}
                                    {{ Form::select('especialidad', [], null ,
                                        ['class'=>'form-control select-carga-egresado','placeholder'=>'Elegir especialidad...',
                                        'required'=> ($tipo == \App\Models\Egresado::TIPO_TECNICOS_LABEL) ? 'required' : false]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('promedio') ? ' has-error' : '' }}">
                            <!-- /*FUNCIONA CON PLUGIN TOUCHSPIN*/-->
                            {{ Form::label('promedio', 'Promedio general', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('promedio',
                                (!$nuevo && $egresado->curriculum->promedio) ? $egresado->curriculum->promedio : null ,
                                ['id'=>'promedio','class'=>'form-control','placeholder'=>'Promedio general']) }}
                                    {{-- ToDo: setear atributo required si no es privado --}}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('asignaturas') ? ' has-error' : '' }}">
                            {{ Form::label('asignaturas', 'Asignaturas destacadas', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('asignaturas',
                                (!$nuevo) ? $egresado->curriculum->asignaturas : null,
                                ['class'=>'form-control','placeholder'=>'Asignaturas destacadas']) }}
                        </div>

                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('practicas_tipo') ? ' has-error' : '' }}">
                            {{ Form::label('practicas_tipo', 'Prácticas profesionalizantes', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('practicas_tipo',
                                (!$nuevo) ? $egresado->curriculum->practicas_tipo : null,
                                ['class'=>'form-control','placeholder'=>'Prácticas profesionalizantes']) }}
                                    {{-- ToDo: setear atributo required si no es privado --}}
                        </div>
                        <div class="form-group col-xs-12 col-sm-6{{ $errors->has('practicas_lugar') ? ' has-error' : '' }}">
                            {{ Form::label('practicas_lugar', '¿Dónde se desarrollaron?', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('practicas_lugar',
                                (!$nuevo) ? $egresado->curriculum->practicas_lugar : null,
                                ['class'=>'form-control','placeholder'=>'¿Dónde se desarrollaron?']) }}
                                    {{-- ToDo: setear atributo required si no es privado --}}
                        </div>

                        <div class="form-group col-xs-12 estudios-superiores{{ $errors->has('estudios') ? ' has-error' : '' }}">
                            <div class="radio">
                                <strong>¿Continúa estudios terciarios o universitarios?</strong>
                                <label>
                                    <input class="radio-estudio-superior" type="radio" name="estudios"
                                        value="no" {{ ($nuevo || !$egresado->curriculum->estudios) ? 'checked' : '' }} >
                                    No
                                </label>
                                <label>
                                    <input class="radio-estudio-superior" type="radio" name="estudios"
                                        value="si" {{ (!$nuevo && $egresado->curriculum->estudios) ? 'checked' : '' }}>
                                    Sí
                                </label>
                            </div>
                        </div> {{-- /radio estudios terciarios --}}
                        <div class="form-group col-sm-6 col-xs-12 detalle-superior
                                {{ ($nuevo || !$egresado->curriculum->estudios) ? ' hidden' : '' }} {{ $errors->has('estudios_carrera') ? ' has-error' : '' }}">
                            {{ Form::label('estudios_carrera', 'Carrera', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('estudios_carrera',
                                (!$nuevo) ? $egresado->curriculum->estudios_carrera : null,
                                ['class'=>'form-control','placeholder'=>'Carrera']) }}
                        </div>
                        <div class="form-group col-sm-6 col-xs-12 detalle-superior
                                {{ ($nuevo || !$egresado->curriculum->estudios) ? ' hidden' : '' }} {{ $errors->has('estudios_lugar') ? ' has-error' : '' }}">
                            {{ Form::label('estudios_lugar', 'Entidad educativa', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('estudios_lugar',
                                (!$nuevo) ? $egresado->curriculum->estudios_lugar : null,
                                ['class'=>'form-control','placeholder'=>'Entidad educativa']) }}
                        </div>

                        <div class="form-group col-xs-12 {{ $errors->has('formacion_complementaria') ? ' has-error' : '' }}">
                            {{ Form::label('formacion_complementaria', 'Formación complementaria', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('formacion_complementaria',
                                (!$nuevo) ? $egresado->curriculum->formacion_complementaria : null,
                                ['class'=>'form-control','placeholder'=>'Formación complementaria']) }}
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
                                            !$nuevo && $egresado->curriculum->responsabilidad) }} {{-- Si es true, lo chequea --}}
                                        {{ trans('app.responsabilidad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','puntualidad',
                                            !$nuevo && $egresado->curriculum->puntualidad) }}
                                        {{ trans('app.puntualidad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','proactividad',
                                            !$nuevo && $egresado->curriculum->proactividad) }}
                                        {{ trans('app.proactividad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','equipo',
                                            !$nuevo && $egresado->curriculum->equipo) }}
                                        {{ trans('app.equipo') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','creatividad',
                                            !$nuevo && $egresado->curriculum->creatividad) }}
                                        {{ trans('app.creatividad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','liderazgo',
                                            !$nuevo && $egresado->curriculum->liderazgo) }}
                                        {{ trans('app.liderazgo') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','conciliador',
                                            !$nuevo && $egresado->curriculum->conciliador) }}
                                        {{ trans('app.conciliador') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','perseverancia',
                                            !$nuevo && $egresado->curriculum->perseverancia) }}
                                        {{ trans('app.perseverancia') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','asertividad',
                                            !$nuevo && $egresado->curriculum->asertividad) }}
                                        {{ trans('app.asertividad') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','relaciones',
                                            !$nuevo && $egresado->curriculum->relaciones) }}
                                        {{ trans('app.relaciones') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','objetivos',
                                            !$nuevo && $egresado->curriculum->objetivos) }}
                                        {{ trans('app.objetivos') }}
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label>
                                        {{ Form::checkbox('actitudes[]','saludable',
                                            !$nuevo && $egresado->curriculum->saludable) }}
                                        {{ trans('app.saludable') }}
                                    </label>
                                </div></li>
                            </ul>
                        </div>

                        <div class="form-group col-xs-12{{ $errors->has('extras') ? ' has-error' : '' }}">
                            {{ Form::label('extras', 'Hobbies, pasatiempos y aptitudes extra educacionales', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('extras',
                                (!$nuevo) ? $egresado->curriculum->extras : null,
                                ['class'=>'form-control','placeholder'=>'Hobbies, pasatiempos y aptitudes extra educacionales']) }}
                        </div>
                        <div class="form-group col-xs-12{{ $errors->has('participacion') ? ' has-error' : '' }}">
                            {{ Form::label('participacion', 'Participación institucional, social y deportiva', ["class"=>"sr-only input-label small"]) }}
                            {{ Form::text('participacion',
                                (!$nuevo) ? $egresado->curriculum->participacion : null,
                                ['class'=>'form-control','placeholder'=>'Participación institucional, social y deportiva']) }}
                        </div>

                    </fieldset> {{-- /fieldset info-adicional --}}

                    <fieldset class="carga-carta row">
                        <legend class="subtitulo h5 texto-azul">Carta de presentación</legend>
                        <div class="form-group col-xs-12{{ $errors->has('carta_presentacion') ? ' has-error' : '' }}">
                            {{ Form::label('carta_presentacion', 'Carta de presentación', ["class"=>"sr-only"]) }}
                            {{ Form::textarea('carta_presentacion',
                                (!$nuevo) ? $egresado->curriculum->carta_presentacion : null,
                                ['class'=>'form-control','placeholder'=>'Carta de presentación','rows' => 6]) }}
                                    {{-- ToDo: setear atributo required si no es privado --}}
                        </div>
                    </fieldset>

                </main> {{-- .cargar-datos --}}

                <aside class="datos-fijos">
                    <section class="cargar-foto">

                        <label class="cargar-foto-btn text-center">
                            <figure id='foto-preview' class="foto-bg foto-egresado foto-placeholder"
                            {!! (!$nuevo && $egresado->foto) ? 'style="background-image: url('.$egresado->getUrlFoto().');"' : '' !!} >
                            </figure>

                            <strong>{{ (!$nuevo && $egresado->foto) ? 'Cambiar la ' : 'Cargar una ' }}foto del egresado</strong>
                            {{ Form::file('foto',['id'=>"cargarFoto", 'accept'=>".jpeg, .jpg, .png"]) }}
                        </label>

                        <span class="error small"></span>
                        <span class="small">Tamaño mínimo: 360px x 360px. Formato: JPG, JPEG o PNG. Peso máximo: 1Mb. </span>
                    </section>
                    <section class="guardar-datos panel-bg-color">
                        <div class="contenedor-datos-fijos">
                        @if ($nuevo)
                            <p><strong>Docente a cargo: </strong>{{ Auth::user()->name }}</p>
                            <p><strong>Servicio Educativo: </strong><br>{{ Auth::user()->institucion->name }}</p>
                        @else
                            <p><strong>Creado / Editado: </strong>{{ $egresado->curriculum->updated_at }}</p>
                            <p><strong>Docente a cargo: </strong>{{ $egresado->docente->name }}</p>
                            <p><strong>Servicio Educativo: </strong><br>{{ $egresado->institucion->name }}</p>
                        @endif
                        </div>

                        <div class="contenedor-btns">
                            <div class="panel-privado">
                                <div class="panel-body bg-warning">
                                    <div class="checkbox">
                                        <label class="text-warning">
                                            {{ Form::checkbox('privado','si',!$nuevo && $egresado->privado) }}
                                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                            &nbsp; Mantener privado
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{ Form::button( ($nuevo) ? 'Cargar egresado' : 'Guardar cambios', ['type' => 'submit','class' => 'btn btn-primary btn-guardar']) }}
                            @if ($nuevo)
                                {{--<button type="reset" class="btn btn-link btn-descartar">Descartar</button>--}}
                                <a href="{{ route('institucion.admin_egresados') }}" class="btn btn-link btn-descartar">Descartar</a>
                            @else
                                <a href="{{ route('egresado_show',['id' => $id ]) }}" class="btn btn-link btn-descartar">Descartar cambios</a>
                                <a href="#" class="btn btn-link btn-descartar" data-toggle="modal" data-target="#confirmarEliminar">Eliminar nota</a>
                            @endif
                        </div>
                    </section>

                </aside> {{-- /.datos-fijos --}}

            {{ Form::close() }} {{-- .fila-flex --}}
        </article> {{-- ./cargar-egresado --}}
    </div> {{-- ./container --}}
    @include('layouts.spinner')

    @include('publicaciones.modal_eliminar')

@endsection