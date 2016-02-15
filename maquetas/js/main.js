//Inicialización general (DOM Ready)
$(document).ready(function(){

    // links disabled
    $(document).on('click','a[href="#ToDo"],a[href="#coming-soon"],a[href=#empty]',function(event) {
        event.preventDefault();
    });

    //Inicializando tooltips
    $('[data-toggle="tooltip"]').tooltip();


    //Lanzar modal para confirmar eliminación de alumno
    var btnEliminar = $('.btn-eliminar');
    var modalEliminar = $('#confirmarEliminar');

    btnEliminar.on('click', function(e){
        e.preventDefault();
        modalEliminar.modal();
    });

});