{{-- Listado de publicaciones para administrar (sólo vista y template. La data se obtiene via AJAX).
        Route: publicaciones.admin_publicaciones - URL: /administrar-publicaciones [GET, role admin]
--}}
@extends('layouts.base')

@section('title')
    Panel de administración
@endsection

@section('header')
    @include('layouts.header_menu')
@endsection

{{-- Agrego estilos y scripts --}}
@section('scripts')
    @parent
    <script src="{{ url('js/listado_publicaciones.js') }}"></script>
    <script>
        var urls = {
            list: "{{ route('publicaciones_public_list') }}",
            show: "{{ route('publicacion_show') }}",
            edit: "{{ route('publicaciones.publicacion_edit') }}",
            destroy: "{{ route('publicaciones.publicacion_delete') }}"
        };
    </script>
@endsection

@section('content')
    {{-- Barra superior --}}
    <nav class="nav-listado">
        <div class="container">
            <div class="row">
                {{-- Boton nuevo --}}
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <a id="crearNuevo" href="{{ route('publicaciones.publicacion_nueva')}}" class="link-nav-listado">
                        <span class="glyphicon glyphicon-file"></span>
                        <span class="texto-nav">Nuevo</span>
                    </a>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-3">
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
                                    <option value="fecha" selected>Fecha</option>
                                    <option value="categoria">Tipo información</option>
                                    <option value="titulo">Título</option>
                                    {{--<option value="autor">Autor</option>--}}
                                </select>

                                <div class="modo-orden text-center">
                                    <label class="radio-inline ordenar-asc">
                                        <input type="radio" name="inlineRadioOptions" class="ordenamiento-tipo" value="asc">
                                        <span class="sr-only">ASC</span><span class="glyphicon glyphicon-sort-by-alphabet"></span>
                                    </label>
                                    <label class="radio-inline ordenar-dsc">
                                        <input type="radio" name="inlineRadioOptions" class="ordenamiento-tipo" value="desc" checked>
                                        <span class="sr-only">DESC</span><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span>
                                    </label>
                                </div>
                            </div> {{-- ./dropdown-menu --}}
                        </form>
                    </div> {{-- .dropdown --}}
                </div> {{-- contenedor ordenar --}}
            </div>
        </div>
    </nav>

    {{-- Contenedor inicialmente con clase loading: muestra spinner, oculta lista y paginacion.
        Cuando se cargan y renderizan los alumnos, se quita la clase. --}}
    <div class="container">
        @include('layouts.spinner')
        <main class="admin-notas">
            <h3 class="titulo-seccion texto-azul">Administrar notas informativas</h3>

            <div id="contenedorLista" class="contenedor-lista vista-listado loading">
                <!--ERROR-->
                <div class="error panel panel-danger">
                    <div class="panel-body bg-danger text-center">
                        <strong>Ocurrió un error al obtener el listado de notas informativas. Por favor, recargue la página o
                            intente de nuevo más tarde.</strong>
                    </div>
                </div>
                <!--ADVERTENCIA-->
                <div class="sin-notas panel panel-warning">
                    <div class="panel-body bg-warning text-center">
                        <strong>Aún no se han cargado notas informativas.</strong>
                    </div>
                </div>

                <ul class="lista-publicaciones list-unstyled lista-notas">
                    {{-- Template handlebars: elementos de la lista (publicacion). Por JS se procesa este script y se renderiza con los datos --}}
                    <script id="template-publicaciones" type="text/x-handlebars-template">
                        @{{#each publicaciones}}
                        <li class="item item-nota" data-id="@{{id}}">
                            <div class="info-nota">
                                <h4 class="titulo-nota">
                                    <a href="{{ route('publicacion_show') }}/@{{categoria}}/@{{id}}">
                                        @{{titulo}}
                                        @{{#if borrador}}
                                            <small><span class="label label-warning label-privado">Borrador</span></small>
                                        @{{/if}}
                                    </a>
                                </h4>
                                <div class="datos-nota">
                                    <span class="dato fec-publicacion">
                                        <strong>Creado/Editado:</strong> @{{ updated_at }}
                                    </span>
                                    <span class="dato tipo-info">
                                        <strong>Tipo de Información:</strong> @{{ categoria_trans }}
                                    </span>
                                    <span class="dato autor">
                                        <strong>Autor:</strong> @{{ autor_nombre }}
                                    </span>

                                </div>
                            </div>

                            <div class="ultimo-bloque ultimo-bloque-nota">
                                <div class="btn-acciones">
                                    <a href="{{ route('publicaciones.publicacion_edit') }}/@{{id}}"
                                        class="btn btn-default btn-editar" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                    <a href="#" class="btn btn-default btn-eliminar eliminar-nota" data-id="@{{id}}" data-toggle="tooltip"
                                         data-placement="bottom" title="Eliminar" data-target="#confirmarEliminar">
                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </li>
                        @{{/each}}
                    </script>
                </ul>
            </div>
            <nav class="center-flex pagination-wrapper">
                <ul id="paginado-publicaciones" class="pagination"></ul>
            </nav>
        </main>
    </div> {{-- #contenedorLista --}}

    @include('publicaciones.modal_eliminar')

@endsection