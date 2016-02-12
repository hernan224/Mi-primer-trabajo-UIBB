{{-- Formulario para creación / edición de alumno y curriculum --}}
@extends('layouts.base_auth')
{{-- La base incluye el header y footer --}}

@section('title')
    @if ($nuevo)
        Cargar alumno
    @else
        Editar alumno
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
                        <a id="eliminar" href="{{ route('alumnos.delete_get',['id'=>$id]) }}" class="link-nav-listado">
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
                            {{ Form::text('nacimiento',null,['class'=>'form-control','placeholder'=>'Fecha de nacimiento','required'=>'required']) }}
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
                            {{ Form::text('localidad',null,['class'=>'form-control','placeholder'=>'Localidad']) }}
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

                        <div class="form-group col-xs-12">
                            <label class="sr-only input-label small" for="especialidad">Especialidad cursada</label>
                            <input type="text" class="form-control" name="especialidad" id="especialidad" placeholder="Especialidad cursada">
                        </div> <!--/input especialidad cursada-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="promedioGeneral">Promedio general</label>
                            <input type="text" class="form-control" name="promedio" id="promedioGeneral" placeholder="Promedio general">
                        </div><!--/input promedio general /*FUNCIONA CON PLUGIN TOUCHSPIN*/-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="asignaturas">Asignaturas destacadas</label>
                            <input type="text" class="form-control" name="asignaturas" id="asignaturas" placeholder="Asignaturas destacadas">
                        </div> <!--/input Asignatura destacada-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="practicasProfesionales">Practicas profesionales</label>
                            <input type="text" class="form-control" name="practicas" id="practicasProfesionales" placeholder="Prácticas Profesionales">
                        </div><!--/input nombre practica profesional-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="lugarDesarrollo">¿Dónde se desarrollaron?</label>
                            <input type="text" class="form-control" name="lugar-desarrollo" id="lugarDesarrollo" placeholder="¿Dónde se desarrollaron?">
                        </div> <!--/input lugar desarrollo practica profesional-->
                    </fieldset> <!--/fieldset datos curriculares-->

                    <fieldset class="carga-info-adicional row">
                        <legend class="subtitulo h5 texto-azul">Información adicional</legend>

                        <div class="form-group col-xs-12">
                            <p><strong>Actitudes que se destacan:</strong></p>
                            <ul class="list-inline">

                                <li><div class="checkbox">
                                    <label for="responsabilidad">
                                        <input type="checkbox" value="responsabilidad" id="responsabilidad">
                                        Responsabilidad
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="puntualidad">
                                        <input type="checkbox" value="puntualidad" id="puntualidad">
                                        Puntualidad
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="proactivo">
                                        <input type="checkbox" value="Actitud Proactiva" id="proactivo">
                                        Actitud Proactiva
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="trabajoEquipo">
                                        <input type="checkbox" value="Trabajo en equipo" id="trabajoEquipo">
                                        Trabajo en equipo
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="creatividad">
                                        <input type="checkbox" value="Creatividad" id="creatividad">
                                        Creatividad
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="liderazgo">
                                        <input type="checkbox" value="Liderazgo positivo" id="liderazgo">
                                        Liderazgo positivo
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="conciliador">
                                        <input type="checkbox" value="Capacidad conciliadora" id="conciliador">
                                        Capacidad conciliadora
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="perseverancia">
                                        <input type="checkbox" value="Perseverancia" id="perseverancia">
                                        Perseverancia
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="asertividad">
                                        <input type="checkbox" value="Asertividad" id="asertividad">
                                        Asertividad
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="relacionesInter">
                                        <input type="checkbox" value="Buenas relaciones interpersonales" id="relacionesInter">
                                        Buenas relaciones interpersonales
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="objetivos">
                                        <input type="checkbox" value="Enfocado en objetivos" id="objetivos">
                                        Enfocado en objetivos
                                    </label>
                                </div></li>
                                <li><div class="checkbox">
                                    <label for="habitosSaludables">
                                        <input type="checkbox" value="Hábitos saludables" id="habitosSaludables">
                                        Hábitos saludables
                                    </label>
                                </div></li>
                            </ul>
                        </div> <!--/checkboxes actitudes destacables-->

                        <div class="form-group col-xs-12">
                            <label class="sr-only input-label small" for="hobbies">Hobbies, pasatiempos y aptitudes extra educacionales</label>
                            <input type="text" class="form-control" name="hobbies" id="hobbies" placeholder="Hobbies, pasatiempos y aptitudes extra educacionales">
                        </div> <!--/input Hobbies-->
                        <div class="form-group col-xs-12">
                            <label class="sr-only input-label small" for="participacioInst">Participación institucional, social y deportiva</label>
                            <input type="text" class="form-control" name="participacion-inst" id="participacioInst" placeholder="Participación institucional, social y deportiva">
                        </div> <!--/input participacion isntitucional-->

                    </fieldset> <!--/fieldset info-adicional-->

                    <fieldset class="carga-carta row">
                        <legend class="subtitulo h5 texto-azul">Carta de presentación</legend>
                        <div class="form-group col-xs-12">
                            <label class="sr-only" for="cartaPresentacion">Carta de presentación</label>
                            <textarea name="carta" class="form-control" id="cartaPresentacion" rows="6" placeholder="Carta de presentación"></textarea>
                        </div> <!--/textarea carta-->
                    </fieldset> <!--/.fieldset carta de presentacion-->
                </main> <!--.cargar-datos-->



                <aside class="datos-fijos">
                    <section class="cargar-foto">

                        <label for="cargarFoto" class="cargar-foto-btn text-center">

                            <figure class="foto-bg foto-alumno foto-placeholder"></figure> <!--/.foto-alumno-->

                            <strong>Cargar una foto del alumno</strong>
                            <input type="file" name="cargarFoto" id="cargarFoto" accept=".jpeg, .jpg, .png"> <!--/infput file-->
                        </label> <!--/.cargar-foto-btn-->

                        <span class="small">Tamaño mínimo: 360px x 360px. Formato: JPG, JPEG o PNG. Peso máximo: 1Mb. </span>
                    </section> <!--/.cargar-foto-->
                    <section class="guardar-datos panel-bg-color">
                        <div class="contenedor-datos-fijos">
                            <p><strong>Creado / Editado: </strong>25/10/2015</p>
                            <p><strong>Docente a cargo: </strong>Juana Ana Triana</p>
                            <p><strong>Servicio Educativo: </strong>Escuela de Educación Técnica N° 1</p>
                        </div> <!--/.contenedor-datos-fijos-->

                        <div class="contenedor-btns">
                            <button type="submit" class="btn btn-primary btn-guardar">Guardar cambios</button>
                            <button type="button" class="btn btn-link btn-descartar">Descartar / Eliminar</button>
                        </div> <!--/.contenedor-botones-->
                    </section> <!--/.guardar-datos-->

                </aside> <!--/.datos-fijos-->

            {{ Form::close() }} {{-- .fila-flex --}}
        </article> {{-- ./cargar-alumno --}}
    </div> {{-- ./container --}}

@endsection