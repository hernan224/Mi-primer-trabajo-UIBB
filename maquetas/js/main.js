//Inicialización general (DOM Ready)
$(document).ready(function(){

    // links disabled
    $(document).on('click','a[href="#ToDo"],a[href="#coming-soon"],a[href=#empty]',function(event) {
        event.preventDefault();
    });

    //Inicializando tooltips
    $('[data-toggle="tooltip"]').tooltip();


    //Lanzar modal para confirmar eliminación de alumno
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
    $modalSolicitar.find('button#solicitar-datos-alumno').click(function() {
        var url = $formSolicitar.attr('action');
        $('.spinner-container').show();
        $.ajax({
            url: url,
            type: 'POST',
            data: $formSolicitar.serialize(),
        })
        .done(function(resp) {
            if (resp.status && resp.status == 'ok') {
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
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

});