/**
 * Script para listado de egresado:
 * obtiene por AJAX la lista al cargar, cambiar de pagina, filtrar u ordenar,
 *  y renderiza en template handlebars (requiere handlebars.js previamente)
 */
/* global Handlebars */
/* global moment */
/* global urls */
/* global cargarSelectsEspecialidad */

var template_egresado, $container, $lista, $paginado,
    actual_page = 1, ordenamiento = false, filtros = {};
$(function () {
    $container = $('#contenedorLista');
    $lista = $container.find('ul.lista-egresados');
    $paginado =  $container.find('#paginado');

    // compilo templates
    handlebarsHelpers();
    var $templateEgresado = $lista.find('#template-egresado');
    template_egresado = Handlebars.compile($templateEgresado.html());
    $templateEgresado.remove();
    // var $templateBusqueda = $('#template-busqueda');
    // template_busqueda = Handlebars.compile($templateBusqueda.html());
    // $templateBusqueda.remove();

    // obtengo del server lista de egresados y renderizo
    getEgresados(); // inicialmente setea paginado

    /* Bindeo de eventos */
    bindOrdenamiento();

    bindFiltros();

    // bindBusqueda();

    bindEliminar();
});

function handlebarsHelpers() {
    // helper {{#if_eq}}: compara que 2 valores sean iguales
    Handlebars.registerHelper('if_eq', function(a, b, opts) {
        if (a === b) {
            return opts.fn(this);
        } else {
            return opts.inverse(this);
        }
    });

    // formatea fecha con formato yyyy-mm-dd
    Handlebars.registerHelper("format_date", function(fecha) {
        return moment(fecha,'YYYY-MM-DD').format('DD/MM/YYYY');
    });

    Handlebars.registerHelper("edad", function(fecha) {
        var nacim = moment(fecha,'YYYY-MM-DD');
        return moment().diff(nacim,'years');
    });

    Handlebars.registerHelper("format_decimal", function(value) {
        return parseFloat(value).toFixed(2).replace(".", ",");
    });
}

// en html se setea urls[lists]: url para hacer get
// params: filtros u ordenamiento
function getEgresados(pag,es_filtro,sin_loading) {
    var $container = $('#contenedorLista');
    if (!sin_loading) {
        $container.addClass('loading');
    }
    $container.removeClass('error-get sin-egresados filtro-vacio');

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
    $.extend(url_params,filtros);

    $.ajax({
        url: urls.list,
        type: 'GET',
        data: url_params
    })
    .done(function(resp) {
        renderLista(resp,es_filtro);
        actual_page = resp.current_page;
        $container.removeClass('loading');
        if (!resp.data.length) {
            if (es_filtro) {
                $container.addClass('filtro-vacio');
            }
            else {
                $container.addClass('sin-egresados');
            }
        }
    })
    .fail(function() {
        $container.addClass('error-get');
        $container.removeClass('loading');
    });
}

function renderLista(resp, reset_paginado) {
    var html_egresados = template_egresado({egresados: resp.data});
    $lista.html(html_egresados);

    // si hace un filtro o lo resetea, se debe eliminar el paginado
    if (reset_paginado && $paginado.children().length) {
        $paginado.twbsPagination('destroy');
        $paginado.html('');
    }
    // renderizo paginado si aún no lo había hecho, o si se debe resetar. Sólo si hay más de una pagina
    if (resp.data.length && resp.last_page > 1 && (!$paginado.children().length || reset_paginado)) {
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
                getEgresados(page); // Mantiene ordenamiento y filtros
            }
        });
    }
}

function bindOrdenamiento() {
    $('.select-ordenar').change(function() {
        var orden = $(this).val(),
        tipo = $('.ordenamiento-tipo:checked').val();

        ordenamiento = orden+'_'+tipo;
        getEgresados(); // Mantiene pag actual y filtros
    });

    $('.ordenamiento-tipo').click (function(){
        var tipo = $(this).val(),
        orden = $('.select-ordenar').val();

        ordenamiento = orden+'_'+tipo;
        getEgresados(); // Mantiene pag actual y filtros
    });

    //Cambiar forma en que se muestra el listado de egresados
    var $btnVista = $('.btn-cambiar-vista');
    var $contenedorLista = $('#contenedorLista');

    $btnVista.on('click', function (e) {
        e.preventDefault();
        var btnActual = $(this);
        var btnDisabled = btnActual.siblings('button[disabled]');
        $contenedorLista.toggleClass('vista-listado');
        btnActual.attr('disabled', true).addClass('activo');
        btnDisabled.attr('disabled', false).removeClass('activo');
    });
}

function bindFiltros() {
    // Carga selects de rubro y especialidad
    //  Bindea cambios en select rubro para cambiar options de especialidad si tipo es oficios
    if (window.categorias) {
        // función definida en main.js
        cargarSelectsEspecialidad(window.categorias);
    }

    //Inicializar slider filtro promedio
    var slider_promedio = $("#filtro-promedio").slider({
        handle: 'triangle',
        tooltip_position: 'bottom',
        tooltip: 'always',
        tooltip_split: true,
        id: 'rangoPromedio'
    });

    //Mostrar/Ocultar filtros
    var $contenedorPrincipal = $('#bodyFiltro'),
        $btnMostrarFiltros = $('#mostrarFiltrosBtn'),
        $contenedorFiltros = $contenedorPrincipal.find('.filtros-contenido'),
        $aplicarFiltros = $contenedorFiltros.find('#aplicar-filtro'),
        $ocultarFiltros = $('.cerrar-filtros'),
        $resetFiltros = $contenedorFiltros.find('#reset-filtros'),
        $inputBusqueda = $('#search-egresados');

    $btnMostrarFiltros.on('click', function (e) {
       e.preventDefault();
       $contenedorPrincipal.addClass('mostrar-filtros');
       $('body').addClass('modal-open');
    });
    $aplicarFiltros.on('click', function (e) {
       e.preventDefault();
       filtrar(slider_promedio);
    });
    $ocultarFiltros.on('click', function (e) {
        e.preventDefault();
        $contenedorPrincipal.removeClass('mostrar-filtros');
        $('body').removeClass('modal-open');
    });

    $resetFiltros.click(function(){
        $contenedorFiltros.find('input, select').val('');
        $contenedorFiltros.find('input[type="checkbox"]').attr('checked', false);
        slider_promedio.slider('setValue',[1,10]);
        $('#search-egresados').val('');
        filtros = {};
        getEgresados(1, true); // hay que volver a renderizar la paginación
    });

    // Búsqueda rápida: usada como filtro.
    //  Para evitar exceso de requests al tipear espera 500ms
    var timeoutBusqueda = null,
        query = null;
    $inputBusqueda.keyup(function() {
        if (timeoutBusqueda !== null) clearTimeout(timeoutBusqueda); // quita timeout previo
        query = $(this).val();
        timeoutBusqueda = setTimeout(function () {
            filtrarBusqueda(query);
        }, 500);
    });
}

function filtrar(slider_promedio) {
    // vacio filtros
    var force_get = false;
    if (!$.isEmptyObject(filtros)) {
        force_get = true;
    }
    filtros = {};
    var $filtro, actitud;
    $('.filtro-simple').each(function(index, el) {
        $filtro = $(el);
        if ($filtro.val()) {
            filtros[$filtro.data('filtro')] = $filtro.val();
        }
    });
    $('.filtro-actitudes:checked').each(function(index, el) {
        actitud = $(el).val();
        if (!filtros.actit) {
            filtros.actit = actitud;
        }
        else {
            filtros.actit += ','+actitud;
        }
    });
    var promedio = slider_promedio.slider('getValue');
    if (promedio[0] > 1) {
        filtros.prom_min = promedio[0];
    }
    if (promedio[1] < 10) {
        filtros.prom_max = promedio[1];
    }
    if(force_get || !$.isEmptyObject(filtros)) {
        getEgresados(1,true); //al filtrar siempre elijo la pag 1 y vuelve a renderizar paginado
    }
}

function filtrarBusqueda(search) {
    if (search.length >= 3) {
        if (search !== filtros.search) { // Cambió la búsqueda
            filtros.search = search;
            getEgresados(1,true,true); // No muestra spinner - Al filtrar siempre elijo la pag 1 y vuelve a renderizar paginado
        }
    }
    else { // Sin query
        if (filtros.search) { // Antes había busqueda, la quito
            filtros.search = '';
            // Vuelve a hacer get, ahora sin search
            getEgresados(1,true,true); // No muestra spinner - al filtrar siempre elijo la pag 1 y vuelve a renderizar paginado
        }
    }
}

// La búsqueda rápida ahora se integra a los filtros, actualizando el listado principal
// function bindBusqueda() {
//     var $listaBusqueda = $('#lista-busqueda'),
//         $inputBusqueda = $('#search-egresados');
//     $inputBusqueda.keyup(function() {
//         var query = $(this).val();
//         if (query.length >= 3) {
//             $.ajax({
//                 url: urls.search,
//                 type: 'GET',
//                 data: {q: query}
//             })
//             .done(function(data) {
//                 var html_busqueda = template_busqueda({egresados: data});
//                 $listaBusqueda.html(html_busqueda);
//                 $listaBusqueda.show();
//             })
//             .fail(function() {
//                 $listaBusqueda.hide();
//                 $listaBusqueda.html('');
//             });
//         }
//         else {
//             $listaBusqueda.hide();
//             $listaBusqueda.html('');
//         }
//     }).click(function() {
//         if($listaBusqueda.children().length) {
//             $listaBusqueda.show();
//         }
//     });
//
//     $(document).mouseup(function (e)
//     {
//         var $busqueda = $('.busqueda');
//         if (!$busqueda.is(e.target) && // if the target of the click isn't the container...
//               $busqueda.has(e.target).length === 0) // ... nor a descendant of the container
//         {
//             $listaBusqueda.hide();
//         }
//     });
// }

function bindEliminar() {
    var $modal = $('#confirmarEliminar.modal');

    $lista.on('click', '.eliminar-egresado', function() {
        var id = $(this).data('id');
        $modal.modal('show');

        $modal.find('#confirmar-eliminar').data('id',id);
    });

    $modal.find('#confirmar-eliminar').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: urls.delete +'/'+id,
            type: 'GET'
        })
        .done(function() {
            $lista.find('.item-egresado[data-id="'+id+'"]').remove();
        })
        .always(function() {
            $modal.modal('hide');
        });
    });
}