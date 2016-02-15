/**
 * Script para listado de alumno:
 * obtiene por AJAX la lista al cargar, cambiar de pagina, filtrar u ordenar,
 *  y renderiza en template handlebars (requiere handlebars.js previamente)
 */
/* global Handlebars */
/* global moment */
/* global urls */
var template_alumno, $lista;
$(function () {
    $lista = $('#contenedorLista ul.lista-alumnos');
    // compilo template
    handlebarsHelpers();
    var $templateAlumno = $lista.find('#template-alumno');
    template_alumno = Handlebars.compile($templateAlumno.html());
    $templateAlumno.remove();

    // obtengo del server llista de alumnos y renderizo
    cargarAlumnos();

    /* Bindeo de eventos */

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

    //Mostrar/Ocultar filtros
    var $contenedorPrincipal = $('#bodyFiltro');
    var $btnMostrarFiltros = $('#mostrarFiltrosBtn');
    var $ocultarFiltros = $('.cerrar-filtros');

    $btnMostrarFiltros.on('click', function (e) {
       e.preventDefault();
       $contenedorPrincipal.addClass('mostrar-filtros');
    });
    $ocultarFiltros.on('click', function (e) {
       e.preventDefault();
       $contenedorPrincipal.removeClass('mostrar-filtros');
    });

    //Inicializar slider filtro promedio
    $("#filtroPromedio").slider({
        handle: 'triangle',
        tooltip_position: 'bottom',
        tooltip: 'always',
        tooltip_split: true,
        id: 'rangoPromedio'
    });
});

// en html se setea url_list: url para hacer get
// params: filtros u ordenamiento
function cargarAlumnos(pag,order,filtros) {
    var $container = $('#contenedorLista');
    $container.addClass('loading');
    $container.removeClass('error-get');

    var url_params = {};
    if (pag) {
        url_params.page = pag;
    }
    if (order) {
        url_params.order = order;
    }
    if (filtros) {
        $.extend(url_params,filtros);
    }

    $.ajax({
        url: urls.list,
        type: 'GET',
        data: url_params,
    })
    .done(function(resp) {
        renderLista(resp);
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


    console.log(resp);
}

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
