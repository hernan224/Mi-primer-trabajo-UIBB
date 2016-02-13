//Inicialización general (DOM Ready)
$(document).ready(function(){

    //Inicializando tooltips
    $('[data-toggle="tooltip"]').tooltip();

    //Cabiar forma en que se muestra el listado de alumnos
    var btnVista = $('.btn-cambiar-vista');
    var contenedorLista = $('#contenedorLista');

    btnVista.on('click', function (e) {
        e.preventDefault();
        var btnActual = $(this);
        var btnDisabled = btnActual.siblings('button[disabled]');
        contenedorLista.toggleClass('vista-listado');
        btnActual.attr('disabled', true).addClass('activo');
        btnDisabled.attr('disabled', false).removeClass('activo');
    });

    //Mostrar/Ocultar filtros
    var contenedorPrincipal = $('#bodyFiltro');
    var btnMostrarFiltros = $('#mostrarFiltrosBtn');
    var ocultarFiltros = $('.cerrar-filtros');

    btnMostrarFiltros.on('click', function (e) {
       e.preventDefault();
       contenedorPrincipal.addClass('mostrar-filtros');
    });
    ocultarFiltros.on('click', function (e) {
       e.preventDefault();
       contenedorPrincipal.removeClass('mostrar-filtros');
    });

    //Marcar item alumno
    var checkAlumno = $('input.check-alumno');

    checkAlumno.on('click', function(){
        var este = $(this);
        var itemAlumno = este.parents('li.item-alumno');

        if(este.prop("checked")){
            itemAlumno.addClass('item-marcado');
        }else{
            itemAlumno.removeClass('item-marcado');
        }
    });



    //Lanzar modal para confirmar eliminación de alumno
    var btnEliminar = $('.btn-eliminar');
    var modalEliminar = $('#confirmarEliminar');

    btnEliminar.on('click', function(e){
        e.preventDefault();
        modalEliminar.modal();
    });

});
// Script con agregados al integrar maquetas en sistema
//Inicialización general (DOM Ready)
$(document).ready(function(){

    var links_disabled = $('a[href="#ToDo"],a[href="#coming-soon"],a[href=#empty]');

    links_disabled.click(function(event) {
        event.preventDefault();
    });
});
//# sourceMappingURL=main.js.map
