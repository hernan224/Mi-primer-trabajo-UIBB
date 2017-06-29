{{-- Listado de egresados (sólo vista y template. La data se obtiene via AJAX).
    Cambia si es listado publico o de institucion
    URL listado publico: /egresados/{tipo}  [parametro $admin_institucion: false - $tipo: tecnicos u oficios]
    URL listado institucion: /administrar-egresados (route: institucion.admin_egresados) [parametro $admin_institucion: true]
--}}

@extends('layouts.base')

@section('title')
    @if ($admin_institucion)
        Panel de administración
    @else
        Listado de egresados {{ trans("app.$tipo") }}
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
    <script src="{{ url('js/listado_egresados.js') }}"></script>
    <script>
        var urls = {
            list : "{{$urls['get_list']}}",
            fotos : "{{$urls['fotos']}}",
            show : "{{$urls['show']}}",
            search : "{{$urls['search']}}"
        };
        @if ($admin_institucion)
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
                @if ($admin_institucion)  {{-- sólo si es listado de institucion --}}
                {{-- Boton nuevo (eliminar no lo incluyo) --}}
                    <div class="col-md-2 col-sm-3 col-xs-6">
                        <a id="crearNuevo" href="{{ route('institucion.egresado_nuevo')}}" class="link-nav-listado">
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
                {{-- Publico: Cambiar vista (no se permite crear nuevo ni eliminar)  --}}
                    <div class="col-md-4 col-sm-3 hidden-xs">
                        <span class="texto-nav texto-vista hidden-sm">Cambiar vista </span>
                        <button type="button" title="Ver como lista" class="btn btn-default btn-cambiar-vista activo" disabled>
                            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        </button> {{-- btn vista listado --}}
                        <button type="button" title="Ver como mosaico" class="btn btn-default btn-cambiar-vista">
                            <span class="glyphicon glyphicon-th" aria-hidden="true"></span>
                        </button> {{-- btn vista mosaico --}}
                    </div> {{-- contenedor cambiar vista --}}
                @endif

                    <div class="col-md-2 col-sm-2 {{ ($admin_institucion) ? 'col-md-offset-2 col-xs-3' : 'col-xs-3' }}">
                        <div class="dropdown">
                            <a id="dropOrdenar" data-target="#" href="#" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false" class="link-nav-listado">
                               <span class="glyphicon glyphicon-sort"></span>
                               <span class="texto-nav texto-ordenar hidden-sm hidden-xs"> Ordenar</span>
                            </a>
                            <div id="contenedorOrdenar" class="contenedor-ordenar dropdown-menu"
                                 aria-labelledby="dropOrdenar">
                                <form action="#" class="form-ordenar">
                                    <select class="form-control select-ordenar">
                                        <option value="ape">Apellido</option>
                                        <option value="prom">Promedio</option>
                                    @if($tipo == 'oficios')
                                        <option value="rub">Rubro</option>
                                    @endif
                                        <option value="esp">Especialidad</option>
                                        <option value="nac">Edad</option>
                                        <option value="loc">Localidad</option>
                                        {{--<option value="bar">Barrio</option>--}}
                                    @if ($admin_institucion)
                                        <option value="fecha">Fecha creación/edición</option>
                                        <option value="doc">Docente</option>
                                    @else
                                        <option value="inst">Institución</option>
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
                                </form>
                            </div> {{-- ./dropdown-menu --}}

                        </div> {{-- .dropdown --}}
                    </div> {{-- contenedor ordenar --}}

                    <div class="col-md-2 col-sm-2 col-xs-3 }}">
                        <a id="mostrarFiltrosBtn" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-filter"></span>
                            <span class="texto-nav texto-filtrar hidden-sm hidden-xs">Filtrar</span>
                        </a>
                    </div> {{-- btn filtro --}}

                    <div class="busqueda col-md-4 col-sm-5 {{ $admin_institucion ? 'col-xs-12' : 'col-xs-6' }}">
                        <div class="input-group buscar-listado">
                            <input id="search-egresados" type="text" class="form-control input-buscar" placeholder="Buscar">
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
                                    @{{#each egresados}}
                                    <a href="{{$urls['show']}}/@{{id}}" class="list-group-item">
                                        <h4 class="list-group-item-heading">@{{nombre}} @{{apellido}}</h4>
                                        <span class="list-group-item-text">@{{especialidad}}</span>
                                        <span class="list-group-item-text">@{{institucion}}</span>
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
            Cuando se cargan y renderizan los egresados, se quita la clase. --}}
        <div id="contenedorLista" class="container contenedor-lista vista-listado loading {{ ($admin_institucion) ? 'vista-institucion' : 'vista-empresa' }}">
            @include('layouts.spinner')

            <!--ERROR-->
            <div class="error panel panel-danger">
                <div class="panel-body bg-danger text-center">
                    <strong>Ocurrió un error al obtener el listado de egresados. Por favor, recargue la página o
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
            <div class="sin-egresados panel panel-warning">
                <div class="panel-body bg-warning text-center">
                    @if ($admin_institucion)
                    <strong>Aún no se han cargado egresados de esta institución.</strong>
                    @else
                    <strong>Por el momento no existen egresados para mostrar. Por favor, intente de nuevo más tarde.</strong>
                    @endif
                </div>
            </div>

            @if (!$admin_institucion && Auth::check())
                @if (Auth::user()->hasRole('institucion'))
                    <div class="text-center">
                        <strong>Este es el listado público de todos los egresados {{ trans("app.$tipo") }} cargados en la plataforma.</strong><br>
                        Para ver y administrar los egresados de su institución educativa:
                        <a href="{{ route('administracion') }}">
                            Panel de administración <span class="glyphicon glyphicon-arrow-right"></span>
                        </a>
                    </div>
                @endif
            @endif

            <ul class="list-unstyled lista-egresados">
                {{-- Template handlebars: elemento de la lista (egresado). Por JS se procesa este script y se renderiza con los datos --}}
                <script id="template-egresado" type="text/x-handlebars-template">
                    @{{#each egresados}}
                    <li class="item-egresado @{{#if privado}}egresado-privado bg-warning@{{/if}}" data-id="@{{id}}">
                        <a class="link-foto-egresado" href="{{$urls['show']}}/@{{id}}">
                            @{{#if foto}}
                                {{-- Si hay foto, indico background_image: concateno el url de fotos recibido de parametro, y el nombre de archivo de la foto --}}
                                <figure class="foto-bg foto-egresado" style="background-image: url('{{$urls['fotos']}}/@{{foto}}');"></figure>
                            @{{else}}
                                {{-- Si no hay foto, se muestra foto generica desde CSS. --}}
                                <figure class="foto-bg foto-egresado sin-foto @{{#if_eq sexo 'm'}}masculino@{{else}}femenino@{{/if_eq}}"></figure>
                            @{{/if}}
                        </a>

                        <div class="info-egresado">
                            <h4 class="nombre-egresado">
                                <a href="@{{#if privado}}{{$urls['edit']}}@{{else}}{{$urls['show']}}@{{/if}}/@{{id}}">
                                    @{{nombre}} @{{apellido}}
                                    @{{#if privado}}
                                    <small><span class="label label-warning label-privado">
                                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                        Privado
                                    </span></small>
                                    @{{/if}}
                                </a>
                            </h4>

                            <div class="datos-egresado">
                                <div class="datos-personales">
                                @if ($admin_institucion)
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
                                @endif
                                @{{#if nacimiento}}
                                <span class="edad">
                                    <strong>Edad:</strong> @{{edad nacimiento}} años
                                </span>
                                @{{/if}}
                                @{{#if localidad}}
                                <span class="localidad">
                                    <strong>Localidad:</strong> @{{localidad}}
                                </span>
                                @{{/if}}
                                </div>
                                <div class="datos-academicos">
                                    <span class="institucion">
                                        <strong>Servicio Educativo:</strong> @{{institucion}}
                                    </span>
                                    @{{#if rubro}}
                                    <span class="especialidad">
                                        <strong>Rubro:</strong> @{{rubro}}
                                    </span>
                                    @{{/if}}
                                    @{{#if especialidad}}
                                    <span class="especialidad">
                                        <strong>Especialidad:</strong> @{{especialidad}}
                                    </span>
                                    @{{/if}}
                                    <span class="dato-promedio">
                                        <strong>Promedio: </strong>
                                        @{{#if promedio}}
                                            @{{format_decimal promedio}}
                                        @{{else}}-@{{/if}}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="ultimo-bloque">
                            {{-- Promedio no mostrado en administración de egresados,
                                y en listado se muestra como una línea de texto
                            <div class="promedio">
                                <strong class="promedio-titulo">Promedio </strong>
                                @{{#if promedio}}
                                    <span class="promedio-valor">@{{format_decimal promedio}}</span>
                                @{{else}}
                                    <span class="promedio-valor">-</span>
                                @{{/if}}
                            </div>--}}
                            <div class="btn-acciones">
                            @if ($admin_institucion)
                                <a href="{{$urls['edit']}}/@{{id}}" class="btn btn-default btn-editar" data-toggle="tooltip"
                                   data-placement="bottom" title="Editar egresado">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                                <a href="#" class="btn btn-default btn-eliminar eliminar-egresado" data-toggle="tooltip"
                                   data-placement="bottom" title="Eliminar egresado" data-id="@{{id}}">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                                {{-- ToDo: reemplazar boton eliminar por cambiar privado o publico
                                Si es publico, boton cambiar a privado: [POST AJAX]
                                    <a href="#" class="btn btn-default btn-privado" data-toggle="tooltip"
                                       data-placement="bottom" title="Mantener egresado como privado">
                                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                                    </a>
                                Si es privado, boton cambiar a publico: [POST AJAX]
                                    <a href="#" class="btn btn-default btn-publico" data-toggle="tooltip"
                                       data-placement="bottom" title="Volver público" >
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                --}}
                            @else
                                <a href="{{route('egresado_pdf')}}/@{{id}}" class="btn btn-default btn-descargar" data-toggle="tooltip"
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
                    <select class="form-control select-filtro filtro-simple" data-filtro='inst'>
                        <option value=""></option>
                    @foreach ($instituciones as $institucion)
                        <option value="{{$institucion->id}}">{{$institucion->name}}</option>
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

    @if ($admin_institucion)
        @include('publicaciones.modal_eliminar')
    @endif

@endsection