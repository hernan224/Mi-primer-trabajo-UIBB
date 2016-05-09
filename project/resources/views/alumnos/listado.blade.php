{{-- Listado de alumnos (sólo vista y template. La data se obtiene via AJAX).
    Cambia si es listado publico o de escuela
    URL listado publico: /listado-alumnos  [parametro $admin_escuela: false]
    URL listado escuela: /administrar-alumnos (route: escuela.admin_alumnos) [parametro $admin_escuela: true]
--}}

@extends('layouts.base')

@section('title')
    @if ($admin_escuela)
        Panel de administración
    @else
        Listado de alumnos
    @endif
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

{{-- Agrego estilos y scripts --}}
@section('styles')
    @parent
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.0.5/css/bootstrap-slider.min.css'>
@endsection
@section('scripts')
    @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.0.5/bootstrap-slider.min.js'></script>
    <script src="{{ url('js/listado_alumnos.js') }}"></script>
    <script>
        var urls = {
            list : "{{$urls['get_list']}}",
            fotos : "{{$urls['fotos']}}",
            show : "{{$urls['show']}}",
            search : "{{$urls['search']}}"
        }
        @if ($admin_escuela)
            urls.edit = "{{$urls['edit']}}";
            urls.delete = "{{$urls['delete']}}";
        @endif
    </script>
@endsection

@section('content')
    <div id="bodyFiltro">
        {{-- Barra superior --}}
        <nav class="nav-listado">
            <div class="container">
                <div class="row">
                @if ($admin_escuela)  {{-- sólo si es listado de escuela --}}
                {{-- Boton nuevo (eliminar no lo incluyo) --}}
                    <div class="col-md-2 col-sm-3 col-xs-6">
                        <a id="crearNuevo" href="{{ route('escuela.alumno_nuevo')}}" class="link-nav-listado">
                            <span class="glyphicon glyphicon-file"></span>
                            <span class="texto-nav">Nuevo</span>
                        </a>
                    </div>

                    {{-- No hay botón eliminar general
                    <div class="col-xs-2 col-sm-2">
                        <a id="eliminarItems" href="#" class="link-nav-listado disable btn-eliminar"
                           data-target="#confirmarEliminar">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="texto-nav hidden-sm">Eliminar</span>
                        </a>
                    </div> --}}
                @else
                {{-- Empresa: Cambiar vista (no se permite crear nuevo ni eliminar)  --}}
                    <div class="col-md-4 col-sm-3 hidden-xs">
                        <span class="texto-nav texto-vista hidden-sm">Cambiar vista </span>
                        <button type="button" title="Ver como mosaico" class="btn btn-default btn-cambiar-vista activo" disabled>
                            <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                        </button> {{-- btn vista mosaico --}}
                        <button type="button" title="Ver como lista" class="btn btn-default btn-cambiar-vista">
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        </button> {{-- btn vista listado --}}
                    </div> {{-- contenedor cambiar vista --}}
                @endif

                    <div class="col-md-2 col-sm-2 {{ ($admin_escuela) ? 'col-md-offset-2 col-xs-3' : 'col-xs-3' }}">
                        <div class="dropdown">
                        <form>
                            <a id="dropOrdenar" data-target="#" href="#" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false" class="link-nav-listado">
                               <span class="glyphicon glyphicon-sort"></span>
                               <span class="texto-nav texto-ordenar hidden-sm hidden-xs"> Ordenar</span>
                            </a>

                            <div id="contenedorOrdenar" class="contenedor-ordenar dropdown-menu"
                                 aria-labelledby="dropOrdenar">
                                <select class="form-control select-ordenar">
                                    <option value="ape">Apellido</option>
                                    <option value="fecha">Fecha</option>
                                    <option value="prom">Promedio</option>
                                    <option value="esp">Especialidad</option>
                                    <option value="nac">Edad</option>
                                    <option value="loc">Localidad</option>
                                    <option value="bar">Barrio</option>
                                @if ($admin_escuela)
                                    <option value="doc">Docente</option>
                                @else
                                    <option value="esc">Escuela</option>
                                @endif
                                </select>

                                <div class="modo-orden text-center">
                                    <label class="radio-inline ordenar-asc">
                                        <input type="radio" name="inlineRadioOptions" class="ordenamiento-tipo" value="asc" checked>
                                        <span class="sr-only">ASC</span><span class="glyphicon glyphicon-sort-by-alphabet"></span>
                                    </label>
                                    <label class="radio-inline ordenar-dsc">
                                        <input type="radio" name="inlineRadioOptions" class="ordenamiento-tipo" value="desc">
                                        <span class="sr-only">DESC</span><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                                    </label>
                                </div>

                            </div> {{-- ./dropdown-menu --}}
                        </form>
                        </div> {{-- .dropdown --}}
                    </div> {{-- contenedor ordenar --}}

                    <div class="col-md-2 col-sm-2 col-xs-3 }}">
                        <a id="mostrarFiltrosBtn" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-filter"></span>
                            <span class="texto-nav texto-filtrar hidden-sm hidden-xs">Filtrar</span>
                        </a>
                    </div> {{-- btn filtro --}}

                    <div class="busqueda col-md-4 col-sm-5 {{ $admin_escuela ? 'col-xs-12' : 'col-xs-6' }}">
                        <div class="input-group buscar-listado">
                            <input id="search-alumnos" type="text" class="form-control input-buscar" placeholder="Buscar">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-buscar" type="button">
                                    <span class="sr-only">Buscar</span>
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>{{-- /input-group --}}
                        <div class="dropdown">
                            <div id="lista-busqueda" class="dropdown-menu list-group">
                                <script id="template-busqueda" type="text/x-handlebars-template">
                                    @{{#each alumnos}}
                                    <a href="{{$urls['show']}}/@{{id}}" class="list-group-item">
                                        <h4 class="list-group-item-heading">@{{nombre}} @{{apellido}}</h4>
                                        <span class="list-group-item-text">@{{especialidad}}</span>
                                        <span class="list-group-item-text">@{{escuela}}</span>
                                    </a>
                                    @{{/each}}
                                </script>

                            </div> {{-- ./dropdown-menu --}}
                        </div> {{-- .dropdown --}}
                    </div>  {{-- buscador --}}

                </div>
            </div>
        </nav>
        {{-- Contenedor inicialmente con clase loading: muestra spinner, oculta lista y paginacion.
            Cuando se cargan y renderizan los alumnos, se quita la clase. --}}
        <div id="contenedorLista" class="container contenedor-lista loading {{ ($admin_escuela) ? 'vista-escuela vista-listado' : 'vista-empresa' }}">
            @include('layouts.spinner')

            <!--ERROR-->
            <div class="error panel panel-danger">
                <div class="panel-body bg-danger text-center">
                    <strong>Ocurrió un error al obtener el listado de alumnos. Por favor, recargue la página o
                        intente de nuevo más tarde.</strong>
                </div>
            </div>
            <!--ADVERTENCIA-->
            <div class="filtro-vacio panel panel-warning">
                <div class="panel-body bg-warning text-center">
                    <strong>No hemos encontrado resultados que se ajusten a su búsqueda. Por favor, modifique los parámetros</strong>
                </div>
            </div>
            <!--ADVERTENCIA-->
            <div class="sin-alumnos panel panel-warning">
                <div class="panel-body bg-warning text-center">
                    @if ($admin_escuela)
                    <strong>Aún no se han cargado alumnos de esta escuela.</strong>
                    @else
                    <strong>Por el momento no existen alumnos para mostrar. Por favor, intente de nuevo más tarde.</strong>
                    @endif
                </div>
            </div>

            @if (!$admin_escuela && Auth::check())
                @if (Auth::user()->hasRole('escuela'))
                    <div class="text-center">
                        <strong>Este es el listado público de todos los alumnos cargados en la plataforma.</strong><br>
                        Para ver y administrar los alumnos de su institución educativa:
                        <a href="{{ url('/acceso-escuela')}}">
                            Panel de administración <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </div>
                @endif
            @endif

            <ul class="list-unstyled lista-alumnos">
                {{-- Template handlebars: elemento de la lista (alumno). Por JS se procesa este script y se renderiza con los datos --}}
                <script id="template-alumno" type="text/x-handlebars-template">
                    @{{#each alumnos}}
                    <li class="item-alumno" data-id="@{{id}}">
                        <a class="link-foto-alumno" href="{{$urls['show']}}/@{{id}}">
                            @{{#if foto}}
                                {{-- Si hay foto, indico background_image: concateno el url de fotos recibido de parametro, y el nombre de archivo de la foto --}}
                                <figure class="foto-bg foto-alumno" style="background-image: url('{{$urls['fotos']}}/@{{foto}}');"></figure>
                            @{{else}}
                                {{-- Si no hay foto, se muestra foto generica desde CSS. --}}
                                <figure class="foto-bg foto-alumno sin-foto @{{#if_eq sexo 'm'}}masculino@{{else}}femenino@{{/if_eq}}"></figure>
                            @{{/if}}
                        </a>

                        <div class="info-alumno">
                            <h4 class="nombre-alumno">
                                <a href="{{$urls['show']}}/@{{id}}">@{{nombre}} @{{apellido}}</a>
                            </h4>

                            <div class="datos-alumno">
                                <div class="datos-personales">
                                @if ($admin_escuela)
                                    <span class="fec-nac">
                                        <strong>Creado/Editado:</strong> @{{format_date updated_at}}
                                    </span>
                                    <span class="edad">
                                        <strong>Docente:</strong> @{{docente}}
                                    </span>
                                @else
                                    <span class="fec-nac">
                                        <strong>Fecha de Nac.:</strong> @{{format_date nacimiento}}
                                    </span>
                                    <span class="edad">
                                        <strong>Edad:</strong> @{{edad nacimiento}} años
                                    </span>
                                    <span class="localidad">
                                        <strong>Localidad:</strong> @{{localidad}}
                                    </span>
                                @endif
                                </div>
                                <div class="datos-academicos">
                                    <span class="escuela">
                                        <strong>Servicio Educativo:</strong> @{{escuela}}
                                    </span>
                                    <span class="especialidad">
                                        <strong>Especialidad:</strong> @{{especialidad}}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="ultimo-bloque">
                            <div class="promedio">
                                <strong class="promedio-titulo">Promedio </strong>
                                <span class="promedio-valor">@{{format_decimal promedio}}</span>
                            </div>
                            <div class="btn-acciones">
                            @if ($admin_escuela)
                                <a href="{{$urls['edit']}}/@{{id}}" class="btn btn-default btn-editar" data-toggle="tooltip"
                                   data-placement="bottom" title="Editar alumno">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                                <a href="#" class="btn btn-default btn-eliminar eliminar-alumno" data-toggle="tooltip"
                                   data-placement="bottom" title="Eliminar alumno" data-id="@{{id}}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            @else
                                <a href="{{route('alumno_pdf')}}/@{{id}}" class="btn btn-default btn-descargar" data-toggle="tooltip"
                                   data-placement="bottom" title="Descargar CV como PDF">
                                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                                </a>
                                {{-- Boton imprimir no se incluye en esta pantalla
                                 <a href="#ToDo" class="btn btn-default btn-imprimir" data-toggle="tooltip"
                                   data-placement="bottom" title="Imprimir CV">
                                   <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                </a> --}}
                            @endif
                            </div>
                        </div>

                    </li>
                    @{{/each}}
                </script>

            </ul>

            <nav class="center-flex pagination-wrapper">
                <ul id="paginado" class="pagination"></ul>
            </nav>
        </div> {{-- #contenedorLista --}}

        {{-- MODAL FILTROS --}}
        <div class="filtros-bg estilo-modal-bg cerrar-filtros">
        </div>
        <div class="filtros-contenedor estilo-modal-container">
            <a href="#" class="btn-cerrar cerrar-filtros">Cerrar</a>
            <div class="filtros-contenido">
                <h3 class="texto-azul">Filtros</h3>
                <a href="#empty" class="btn-reset reset-filtros" title="Restaurar filtros">
                    <span class="sr-only">Reset</span>
                    <span class="glyphicon glyphicon-refresh"></span>
                </a>

                <div class="modulo-filtro modulo-promedio">
                    <h5 class="text-uppercase texto-azul">Promedio General</h5>
                    <b>1</b>
                    <input id="filtro-promedio" type="text" class="span2 filtro-promedio"
                                    value="" data-slider-min="1" data-slider-max="10" data-slider-step="0.1"
                                    data-slider-value="[1,10]"/>
                    <b>10</b>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Especialidad</h5>
                    <input type='text' class="form-control select-filtro filtro-simple" data-filtro='esp'/>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Servicio educativo</h5>
                    <select class="form-control select-filtro filtro-simple" data-filtro='esc'>
                        <option value=""></option>
                    @foreach ($escuelas as $escuela)
                        <option value="{{$escuela->id}}">{{$escuela->name}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Localidad</h5>
                    <input type='text' class="form-control select-filtro filtro-localidad filtro-simple" data-filtro='loc'/>
                    <h5 class="text-uppercase texto-azul">Barrio</h5>
                    <input type='text' class="form-control select-filtro filtro-barrio filtro-simple" data-filtro='bar'/>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Actitudes destacadas</h5>

                    <div class="checkbox-container">
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="responsabilidad"> Responsabilidad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="puntualidad"> Puntualidad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="proactividad"> Proactivo
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="equipo"> Trabajo en equipo
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="creatividad"> Creatividad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="liderazgo"> Liderazgo
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="conciliador"> Conciliador
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="perseverancia"> Perseverancia
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="asertividad"> Asertividad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="relaciones"> Buenas relaciones interpersonales
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="objetivos"> Enfocado en objetivos
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" class="filtro-actitudes" value="saludable"> Hábitos saludables
                        </label>

                    </div>
                </div> <!--.modulo-filtro-->

            </div> <!--.filtros-contenido-->
        </div> {{-- .filtros-contendor --}}
    </div>

    @if ($admin_escuela)
        @include('alumnos.modal_eliminar');
    @endif

@endsection