/**
 * Script para listado de publicaciones:
 * obtiene por AJAX la lista al cargar, cambiar de pagina u ordenar,
 *  y renderiza en template handlebars (requiere handlebars.js previamente)
 */
/* global Handlebars */
/* global urls */

var template_publicacion, $lista, $paginado,
    actual_page = 1, ordenamiento = false;

$(function () {
    $lista = $('#contenedorLista ul.lista-notas');
    $paginado =  $('.admin-notas #paginado');

    // compilo templates
    var $templatePublicacion = $lista.find('#template-publicacion');
    template_publicacion = Handlebars.compile($templatePublicacion.html());
    $templatePublicacion.remove();

    // obtengo del server lista de publicacion y renderizo
    getPublicaciones(); // inicialmente setea paginado

    /* Bindeo de eventos */
    bindOrdenamiento();

    bindEliminar();
});

// en html se setea urls[lists]: url para hacer get
function getPublicaciones(pag) {
    var $container = $('#contenedorLista');
    $container.addClass('loading');
    $container.removeClass('error-get sin-notas');

    var url_params = {};
    if(pag) {
        url_params.page = pag;
    }
    else {
        url_params.page = actual_page;
    }

    if (ordenamiento) {
        url_params.order = ordenamiento;
    }

    $.ajax({
        url: urls.list,
        type: 'GET',
        data: url_params,
    })
    .done(function(resp) {
        renderLista(resp);
        actual_page = resp.current_page;
        $container.removeClass('loading');
        if (!resp.data.length) {
            $container.addClass('sin-notas');
        }
    })
    .fail(function() {
        $container.addClass('error-get');
        $container.removeClass('loading');
    });
}

function renderLista(resp) {

    var html_publicaciones = template_publicacion({publicaciones: resp.data});
    $lista.html(html_publicaciones);

    // renderizo paginado si aún no lo había hecho. Sólo si hay más de una pagina
    if (resp.data.length && resp.last_page > 1 && !$paginado.children().length) {
        $paginado.twbsPagination({
            totalPages: resp.last_page,
            visiblePages: 5,
            start_page: resp.current_page,
            initiateStartPageClick: false,
            first: false,
            last: false,
            prev: '<span aria-hidden="true"><span class="glyphicon glyphicon-menu-left"></span></span>',
            next: '<span aria-hidden="true"><span class="glyphicon glyphicon-menu-right"></span></span>',
            onPageClick: function (event, page) {
                getPublicaciones(page);
            }
        });
    }
}

function bindOrdenamiento() {
    $('.select-ordenar').change(function() {
        var orden = $(this).val(),
        tipo = $('.ordenamiento-tipo:checked').val();

        ordenamiento = orden+'_'+tipo;
        getPublicaciones();
    });

    $('.ordenamiento-tipo').click (function(){
        var tipo = $(this).val(),
        orden = $('.select-ordenar').val();

        ordenamiento = orden+'_'+tipo;
        getPublicaciones();
    });

}

function bindEliminar() {
    var $modal = $('#confirmarEliminar.modal');

    $lista.on('click', '.eliminar-nota', function() {
        var id = $(this).data('id');
        $modal.modal('show');

        $modal.find('#confirmar-eliminar').data('id',id);
    });

    $modal.find('#confirmar-eliminar').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: urls.destroy +'/'+id,
            type: 'GET',
        })
        .done(function() {
            $lista.find('.item-nota[data-id="'+id+'"]').remove();
        })
        .always(function() {
            $modal.modal('hide');
        });
    });
}