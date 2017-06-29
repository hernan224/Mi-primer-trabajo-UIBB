//Inicialización general (DOM Ready)
$(document).ready(function(){

    // links disabled
    $(document).on('click','a[href="#ToDo"],a[href="#coming-soon"],a[href=#empty]',function(event) {
        event.preventDefault();
    });

    //Inicializando tooltips
    $('[data-toggle="tooltip"]').tooltip();


    //Lanzar modal para confirmar eliminación de egresado
    var $modalEliminar = $('#confirmarEliminar');
    $('.btn-eliminar').on('click', function(e){
        e.preventDefault();
        $modalEliminar.modal();
    });

    //Lanzar modal para enviar datos de contacto
    var $modalSolicitar = $('#solicitarContacto'),
        $formSolicitar = $modalSolicitar.find('form');
    $('#solicitarBtn').on('click', function(e){
        e.preventDefault();
        $modalSolicitar.find('.modal-body.formulario').show().find('.error').hide();
        $modalSolicitar.find('.modal-body.post-ok').hide();
        $modalSolicitar.modal();
    });
    // POST AJAX envío de mail
    $modalSolicitar.find('button#solicitar-datos-egresado').click(function() {
        var url = $formSolicitar.attr('action');
        $('.spinner-container').show();
        $.ajax({
            url: url,
            type: 'POST',
            data: $formSolicitar.serialize()
        })
        .done(function(resp) {
            if (resp.status && resp.status === 'ok') {
                $modalSolicitar.find('.modal-body.formulario').hide();
                $modalSolicitar.find('.modal-body.post-ok').fadeIn();
            }
            else {
                var $error = $modalSolicitar.find('.modal-body.formulario .error');
                $error.show();
                if (resp.mensaje) {
                    $error.find('.mensaje').html(resp.mensaje);
                }
                else {
                    $error.find('.mensaje').html('');
                }
            }
        })
        .fail(function() {
            var $error = $modalSolicitar.find('.modal-body.formulario .error');
            $error.show();
            $error.find('.mensaje').html('');
        })
        .always(function() {
            $('.spinner-container').hide();
        });

    });
    // prevent send form on enter key
    $(document).on("keypress", "form:not(.login-form) :input:not(textarea)", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });

});

/* exported cargarSelectsEspecialidad */
// Función usada tanto en form_egresado como en listado_egresados (filtros)
function cargarSelectsEspecialidad(data) {
    var especialidades = $.parseJSON(data.especialidades),
        rubros, // sólo tipo oficios
        $select_especialidad = $('select#especialidad'),
        $select_rubro; // sólo tipo oficios
    // Cacheo HTML de option placeholder
    var options_especialidad,
        placeholder_especialidad = $select_especialidad.html(),
        placeholder_rubro;
    if (data.tipo === 'tecnicos') {
        // No hay select rubro y el select especialidad no cambia de forma dinámica:
        //  se setea inicialmente y no se bindean cambios
        options_especialidad = placeholder_especialidad;
        $.each(especialidades,function(index,item){
            options_especialidad += '<option value="'+item+'">'+item+'</option>';
        });
        $select_especialidad.html(options_especialidad);
        // Seteo options seleccionadas (sólo edición)
        if (data.especialidad_selected) {
            $select_especialidad.val(data.especialidad_selected);
        }
    }
    else if (data.tipo === 'oficios') {
        rubros = $.parseJSON(data.rubros);
        $select_rubro = $('select#rubro');
        placeholder_rubro = $select_rubro.html();
        var options_rubro = placeholder_rubro;
        $.each(rubros,function(index,item){
            options_rubro += '<option value="'+item+'">'+item+'</option>';
        });
        $select_rubro.html(options_rubro);
        $select_especialidad.html('');
        // Bindeo cambios en rubro para setear options especialidades
        $select_rubro.change(function(){
            var rubro = $select_rubro.val();
            options_especialidad = placeholder_especialidad;
            if (especialidades[rubro]) {
                $.each(especialidades[rubro],function(index,item){
                    options_especialidad += '<option value="'+item+'">'+item+'</option>';
                });
                $select_especialidad.html(options_especialidad);
            }
            else {
                $select_especialidad.html('');
            }
        });
        // Seteo option seleccionada (sólo edición)
        if (data.rubro_selected) {
            $select_rubro.val(data.rubro_selected);
            $select_rubro.trigger('change');
            if (data.especialidad_selected) {
                $select_especialidad.val(data.especialidad_selected);
            }
        }
    }
}
//# sourceMappingURL=main.js.map
