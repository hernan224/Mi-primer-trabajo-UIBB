{{-- Listado de alumnos (sólo vista y template. La data se obtiene via AJAX).
    Cambia si tipo de usuairo es escuela o empresa. URL: /alumnos --}}

@extends('layouts.base_auth')
{{-- La base incluye el header y footer --}}

@section('title')
    Listado de alumnos
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
            edit : "{{$urls['edit']}}"
        };
    </script>
@endsection

@section('content')
    <div id="bodyFiltro">
        {{-- Barra superior --}}
        <nav class="nav-listado">
            <div class="container">
                <div class="row">
                @if (Auth::user()->puedeEditar())
                {{-- Boton nuevo (eliminar no lo incluyo) --}}
                    <div class="col-md-2 col-sm-3 col-xs-3">
                        <a id="crearNuevo" href="{{ route('alumnos.nuevo')}}" class="link-nav-listado">
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

                    <div class="col-md-2 col-sm-2 {{ Auth::user()->puedeEditar() ? 'col-md-offset-2 col-xs-2' : 'col-xs-3' }}">
                        <div class="dropdown">
                            <a id="dropOrdenar" data-target="#" href="#" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false" class="link-nav-listado">
                               <span class="glyphicon glyphicon-sort"></span>
                               <span class="texto-nav texto-ordenar hidden-sm hidden-xs"> Ordenar</span>
                            </a>

                            <div id="contenedorOrdenar" class="contenedor-ordenar dropdown-menu"
                                 aria-labelledby="dropOrdenar">
                                <form action="#" class="form-ordenar">
                                    <select class="form-control select-ordenar" name="ordenar">
                                        <option>Fecha</option>
                                        <option>Promedio</option>
                                        <option>Nombre</option>
                                        <option>Especialidad</option>
                                        <option>Docente</option>
                                    </select>

                                    <div class="modo-orden text-center">
                                        <label class="radio-inline ordenar-asc">
                                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
                                            <span class="sr-only">ASC</span><span class="glyphicon glyphicon-sort-by-alphabet"></span>
                                        </label>
                                        <label class="radio-inline ordenar-dsc">
                                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                            <span class="sr-only">DSC</span><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                                        </label>
                                    </div>
                                </form> {{-- form.form-ordenar --}}

                            </div> {{-- ./dropdown-menu --}}
                        </div> {{-- .dropdown --}}
                    </div> {{-- contenedor ordenar --}}

                    <div class="col-md-2 col-sm-2 {{ Auth::user()->puedeEditar() ? 'col-xs-2' : 'col-xs-3' }}">
                        <a id="mostrarFiltrosBtn" href="#" class="link-nav-listado">
                            <span class="glyphicon glyphicon-filter"></span>
                            <span class="texto-nav texto-filtrar hidden-sm hidden-xs">Filtrar</span>
                        </a>
                    </div> {{-- btn filtro --}}

                    <div class="col-md-4 col-sm-5 {{ Auth::user()->puedeEditar() ? 'col-xs-5' : 'col-xs-6' }}">
                        <div class="input-group buscar-listado">
                            <input type="text" class="form-control input-buscar" placeholder="Buscar">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-buscar" type="button">
                                    <span class="sr-only">Buscar</span>
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>{{-- /input-group --}}
                    </div>  {{-- buscador --}}

                </div>
            </div>
        </nav>
        {{-- Contenedor inicialmente con clase loading: muestra spinner, oculta lista y paginacion.
            Cuando se cargan y renderizan los alumnos, se quita la clase. --}}
        <div id="contenedorLista" class="container contenedor-lista loading vista-listado {{ (Auth::user()->puedeEditar()) ? 'vista-escuela' : 'vista-empresa' }}">
            @include('layouts.spinner')
            <div class="error text-center">
                <strong>Ocurrió un error al obtener el listado de alumnos. Por favor, recargue la página o intente de nuevo más tarde.</strong>
            </div>

            <ul class="list-unstyled lista-alumnos">
                {{-- Template handlebars: elemento de la lista (alumno). Por JS se procesa este script y se renderiza con los datos --}}
                <script id="template-alumno" type="text/x-handlebars-template">
                    @{{#each alumnos}}
                    <li class="item-alumno">
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
                                @if (Auth::user()->hasRole('escuela'))
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
                            @if (Auth::user()->hasRole('escuela'))
                                <a href="{{$urls['edit']}}/@{{id}}" class="btn btn-default btn-editar" data-toggle="tooltip"
                                   data-placement="bottom" title="Editar alumno">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                </a>
                                <a href="#" class="btn btn-default btn-eliminar" data-toggle="tooltip"
                                   data-placement="bottom" title="Eliminar alumno" data-target="#confirmarEliminar">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                            @else
                                <a href="#ToDo" class="btn btn-default btn-descargar" data-toggle="tooltip"
                                   data-placement="bottom" title="Descargar CV como PDF">
                                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                                </a>
                                <a href="#ToDo" class="btn btn-default btn-imprimir" data-toggle="tooltip"
                                   data-placement="bottom" title="Imprimir CV">
                                   <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                </a>
                            @endif
                            </div>
                        </div>

                    </li>
                    @{{/each}}
                </script>

            </ul>

            <nav class="center-flex">
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

                <div class="modulo-filtro modulo-promedio">
                    <h5 class="text-uppercase texto-azul">Promedio General</h5>
                    <b>1</b>
                    <input id="filtroPromedio" name="filtro-promedio" type="text" class="span2 filtro-promedio"
                                    value="" data-slider-min="1" data-slider-max="10" data-slider-step="0.1"
                                    data-slider-value="[1,10]"/>
                    <b>10</b>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Especialidad</h5>
                    <input type='text' class="form-control select-filtro" name="filtro[especialidad]"/>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Servicio educativo</h5>
                    <select class="form-control select-filtro" name="filtro[escuela]">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Localidad</h5>
                    <input type='text' class="form-control select-filtro filtro-localidad" name="filtro[localidad]"/>
                    <h5 class="text-uppercase texto-azul">Barrio</h5>
                    <input type='text' class="form-control select-filtro filtro-barrio" name="filtro[barrio]"/>
                </div>

                <div class="modulo-filtro">
                    <h5 class="text-uppercase texto-azul">Actitudes destacadas</h5>

                    <div class="checkbox-container">
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][responsabilidad]"> Responsabilidad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][puntualidad]"> Puntualidad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][proactividad]"> Proactivo
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][equipo]"> Trabajo en equipo
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][creatividad]"> Creatividad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][liderazgo]"> Liderazgo
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][conciliador]"> Conciliador
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][perseverancia]"> Perseverancia
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][asertividad]"> Asertividad
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][relaciones]"> Buenas relaciones interpersonales
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][objetivos]"> Enfocado en objetivos
                        </label>
                        <label class="checkbox">
                            <input type="checkbox" name="filtro[actitudes][saludable]"> Hábitos saludables
                        </label>

                    </div>
                </div> <!--.modulo-filtro-->

            </div> <!--.filtros-contenido-->
        </div> {{-- .filtros-contendor --}}
    </div>

    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN DE ALUMNO --}}
    @if (Auth::user()->puedeEditar())
        <div class="modal estilo-modal-bg fade" id="confirmarEliminar" tabindex="-1" role="dialog" aria-labelledby="confirmarEliminación">
            <div class="modal-dialog">
                <div class="modal-content estilo-modal-container">
                    <div class="modal-header">
                        <a href="#ToDo" class="btn-cerrar close" data-dismiss="modal" aria-label="Close">Cerrar</a>
                        <h4 class="modal-title texto-azul">Confirmar eliminación</h4>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que quiere eliminar el siguiente alumno?</p>
                        <ul class="alumnos-eliminados">
                            <li>Nombre alumno</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-primary">SI</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection