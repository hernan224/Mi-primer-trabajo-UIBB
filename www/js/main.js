 $(document).ready()
 {
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

     //Mostrar label en carga de datos
     var inputAlumno = $('.form-mpt input.form-control');

     inputAlumno.on('change', function(){
         var este = $(this);
         var estePadre = este.parents('.form-group');

         if(este.val() != '' && !estePadre.hasClass('cargado')){
             estePadre.addClass('cargado');
         }
         else if(este.val() == '' && estePadre.hasClass('cargado'))
         {
             estePadre.removeClass('cargado');
         }
     });


     //Lanzar modal para confirmar eliminación de alumno
     var btnEliminar = $('.btn-eliminar');
     var modalEliminar = $('#confirmarEliminar');

     btnEliminar.on('click', function(e){
         e.preventDefault();
         modalEliminar.modal();
     });

 }
//# sourceMappingURL=main.js.map
