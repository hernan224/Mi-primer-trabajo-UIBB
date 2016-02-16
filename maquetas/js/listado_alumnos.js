/**
 * Script para listado de alumno:
 * obtiene por AJAX la lista al cargar, cambiar de pagina, filtrar u ordenar,
 *  y renderiza en template handlebars (requiere handlebars.js previamente)
 */
/* global Handlebars */
/* global moment */
/* global urls */

var template_alumno, template_busqueda, $lista, $paginado,
    actual_page = 1, ordenamiento = false, filtros = {};
$(function () {
    $lista = $('#contenedorLista ul.lista-alumnos');
    $paginado =  $('#contenedorLista #paginado');

    // compilo templates
    handlebarsHelpers();
    var $templateAlumno = $lista.find('#template-alumno');
    template_alumno = Handlebars.compile($templateAlumno.html());
    $templateAlumno.remove();
    var $templateBusqueda = $('#template-busqueda');
    template_busqueda = Handlebars.compile($templateBusqueda.html());
    $templateBusqueda.remove();

    // obtengo del server lista de alumnos y renderizo
    getAlumnos(); // inicialmente setea paginado

    /* Bindeo de eventos */
    bindOrdenamiento();

    bindFiltros();

    bindBusqueda();

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
function getAlumnos(pag) {
    var $container = $('#contenedorLista');
    $container.addClass('loading');
    $container.removeClass('error-get');

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
        data: url_params,
    })
    .done(function(resp) {
        renderLista(resp);
        actual_page = resp.current_page;
        $container.removeClass('loading');
    })
    .fail(function() {
        $container.addClass('error-get');
        $container.removeClass('loading');
    });
}

function renderLista(resp) {

    var html_alumnos = template_alumno({alumnos: resp.data});
    $lista.html(html_alumnos);

    if (!resp.data.length) {
        // ToDo: mostrar mensaje de no hay elementos
    }

    // renderizo paginado si no fue renderizado aún
    // inicialmente va a mostrar la cantidad total de paginas...
    // al hacer filtro la cantidad de paginas se va a achicar, pero en el paginado no se va a actualizar
    if (resp.data.length && !$paginado.children().length && resp.last_page > 1) {
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
                getAlumnos(page);
            }
        });
    }

}

function bindOrdenamiento() {
    $('.select-ordenar').change(function() {
        var orden = $(this).val(),
        tipo = $('.ordenamiento-tipo:checked').val();

        ordenamiento = orden+'_'+tipo;
        getAlumnos();
    });

    $('.ordenamiento-tipo').click (function(){
        var tipo = $(this).val(),
        orden = $('.select-ordenar').val();

        ordenamiento = orden+'_'+tipo;
        getAlumnos();
    });

    //Cambiar forma en que se muestra el listado de alumnos
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
    //Inicializar slider filtro promedio
    var slider_promedio = $("#filtro-promedio").slider({
        handle: 'triangle',
        tooltip_position: 'bottom',
        tooltip: 'always',
        tooltip_split: true,
        id: 'rangoPromedio'
    });

    //Mostrar/Ocultar filtros
    var $contenedorPrincipal = $('#bodyFiltro');
    var $btnMostrarFiltros = $('#mostrarFiltrosBtn');
    var $ocultarFiltros = $('.cerrar-filtros');

    $btnMostrarFiltros.on('click', function (e) {
       e.preventDefault();
       $contenedorPrincipal.addClass('mostrar-filtros');
    });
    // al cerrar filtro hago el get
    $ocultarFiltros.on('click', function (e) {
       e.preventDefault();
       $contenedorPrincipal.removeClass('mostrar-filtros');
       filtrar(slider_promedio);
    });

}

function filtrar(slider_promedio) {
    // reseteo filtros
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
        getAlumnos(1); //al filtrar siempre elijo la pag 1
    }
}

function bindBusqueda() {
    var $listaBusqueda = $('#lista-busqueda'),
        $inputBusqueda = $('#search-alumnos');
    $inputBusqueda.keyup(function() {
        var query = $(this).val();
        if (query.length >= 3) {
            $.ajax({
                url: urls.search,
                type: 'GET',
                data: {q: query},
            })
            .done(function(data) {
                var html_busqueda = template_busqueda({alumnos: data});
                $listaBusqueda.html(html_busqueda);
                $listaBusqueda.show();
            })
            .fail(function() {
                $listaBusqueda.hide();
                $listaBusqueda.html('');
            });
        }
        else {
            $listaBusqueda.hide();
            $listaBusqueda.html('');
        }
    }).click(function() {
        if($listaBusqueda.children().length) {
            $listaBusqueda.show();
        }
    });

    $(document).mouseup(function (e)
    {
        var $busqueda = $('.busqueda');
        if (!$busqueda.is(e.target) && // if the target of the click isn't the container...
              $busqueda.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $listaBusqueda.hide();
        }
    });
}

function bindEliminar() {
    var $modal = $('#confirmarEliminar.modal');

    $lista.on('click', '.eliminar-alumno', function() {
        var id = $(this).data('id');
        $modal.modal('show');

        $modal.find('#confirmar-eliminar').data('id',id);
    });

    $modal.find('#confirmar-eliminar').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: urls.delete +'/'+id,
            type: 'GET',
        })
        .done(function() {
            $lista.find('.item-alumno[data-id="'+id+'"]').remove();
        })
        .always(function() {
            $modal.modal('hide');
        });
    });
}