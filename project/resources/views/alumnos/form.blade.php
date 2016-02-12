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
                        <a id="eliminar" href="{{ route('alumnos.delete',['id'=>$id]) }}" class="link-nav-listado">
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
            <form method="POST"
                action="{{ ($nuevo) ? route('alumnos.nuevo_post') : route('alumnos.edit_put',['id' => $id]) }}"
                role="form" class="fila-flex form-mpt">
                @if (!$nuevo)
                    {!! method_field('put') !!}
                @endif

                <main class="cargar-datos">
                    <h3 class="titulo-seccion">Cargar nuevo alumno</h3>

                    <fieldset class="row carga-datos-personales">
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="nombre">Nombres</label>
                            <input type="text" class="form-control" name="nomnre" id="nombre" placeholder="Nombres">
                        </div><!--/input Nombre-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="apellido">Apellidos</label>
                            <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellidos">
                        </div><!--/input Apellido-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="dni">DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI N°">
                        </div> <!--/input DNI-->
                        <div class="form-group col-sm-6 cargar-sexo">
                            <div class="radio">
                                <strong>Sexo:</strong>
                                <label for="sexoMasculino">
                                    <input type="radio" name="sexo" id="sexoMasculino" value="masculino" >
                                    Masculino
                                </label>
                                <label for="sexoFemenino">
                                    <input type="radio" name="sexo" id="sexoFemenino" value="femenino" >
                                    Femenino
                                </label>
                            </div>
                        </div> <!--/radio seleccion sexo-->


                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="nacimiento">Fecha de Nacimiento</label>
                            <input type="text" class="form-control" name="nacimiento" id="nacimiento" placeholder="Fecha de Nacimiento">
                            <!--<div class='input-group date' id='datetimepicker1'>-->
                                <!--<input type='text' class="form-control" name="nacimiento" id="nacimiento" placeholder="Fecha de Nacimiento"/>-->
                                <!--<span class="input-group-addon">-->
                                    <!--<span class="glyphicon glyphicon-calendar"></span>-->
                                <!--</span>-->
                            <!--</div>-->
                        </div><!--/input Fecha de nacimiento /**FUNCIONA CON PLUGIN DATEPICKER**/-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="nacionalidad">Nacionalidad</label>
                            <input type="text" class="form-control" name="nacionalidad" id="nacionalidad" placeholder="Nacionalidad">
                        </div><!--/input Nacionalidad-->
                    </fieldset> <!--/fieldset datos personales-->

                    <fieldset class="carga-datos-contacto row">

                        <legend class="subtitulo h5 texto-azul">Datos de contacto</legend>

                        <div class="form-group col-xs-12">
                            <label class="sr-only input-label small" for="domicilio">Domicilio</label>
                            <input type="text" class="form-control" name="domicilio" id="domicilio" placeholder="Domicilio">
                        </div><!--/input domicilio-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="localidad">Loclidad</label>
                            <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad">
                        </div><!--/input localidad-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="barrio">Barrio</label>
                            <input type="text" class="form-control" name="barrio" id="barrio" placeholder="Barrio">
                        </div><!--/input barrio-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="telFijo">Teléfono fijo</label>
                            <input type="text" class="form-control" name="tel-fijo" id="telFijo" placeholder="Teléfono fijo">
                        </div><!--/input tel fijo-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="telMovil">Teléfono movil</label>
                            <input type="text" class="form-control" name="tel-movil" id="telMovil" placeholder="Teléfono movil">
                        </div><!--/input Tel movil-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
                        </div><!--/input email-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="facebook">Facebook</label>
                            <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook">
                        </div><!--/input facebook-->

                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="twitter">Twitter</label>
                            <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter">
                        </div><!--/input twitter-->
                        <div class="form-group col-sm-6">
                            <label class="sr-only input-label small" for="linkedin">LinkedIn</label>
                            <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="LinkedIn">
                        </div> <!--/input linkedin-->

                    </fieldset> <!--/fieldset datos contacto-->

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

            </form> <!--.fila-flex-->
        </article> <!--./cargar-alumno-->
    </div>

@endsection