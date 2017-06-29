{{-- Lista de publicaciones (notas informativas) de una categoría
        Incluido en capacitaciones y practicas.
        Template handlebars: data obtenida por AJAX, renderizado por JS
 --}}
<div id="contenedorLista" class="lista-publicaciones contenedor-lista vista-listado listado-instituciones">
    @include('layouts.spinner')
    {{-- Template handlebars: elementos de la lista (publicaciones). Por JS se procesa este script y se renderiza con los datos --}}
    <script id="template-publicaciones" type="text/x-handlebars-template">
    @{{#if publicaciones.length}}
        <h3 class="titulo-seccion texto-azul subtitulo"><strong>Notas informativas</strong></h3>
        <ul class="list-unstyled lista-2col">
        @{{#each publicaciones}}
            @{{#unless borrador}}
            <li class="item item-nota" data-id="@{{id}}">
                <div class="info-nota">
                    <h4 class="titulo-nota">
                        <a href="{{ route('publicacion_show') }}/@{{categoria}}/@{{id}}">
                            @{{titulo}}
                        </a>
                    </h4>
                    <div class="datos-nota">
                        <span class="dato fec-publicacion">
                            <strong>Creado/Editado:</strong> @{{ updated_at }}
                        </span>
                        <span class="dato autor">
                            <strong>Autor:</strong> @{{ autor_nombre }}
                        </span>
                    </div>
                    <div class="fila-flex nota-container-cuerpo">
                        @{{#if url_imagen}}
                        <figure class="nota-img-destacada hidden-xs"
                                style="background-image: url(@{{ url_imagen }})"></figure>
                        @{{/if}}
                        <p class="descripcion-nota">
                            @{{{ texto_preview }}}
                        </p>
                    </div>
                    <a href="{{ route('publicacion_show') }}/@{{categoria}}/@{{id}}" class="nota-ver-mas">
                        Seguir leyendo &rightarrow;
                    </a>
                </div>
            </li>
            @{{/unless}}
        @{{/each}}
        </ul>
    @{{/if}}
    </script>
</div>
<nav class="center-flex pagination-wrapper">
    <ul id="paginado-publicaciones" class="pagination"></ul>
</nav>