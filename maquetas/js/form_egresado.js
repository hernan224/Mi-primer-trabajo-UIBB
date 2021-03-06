/** Script para formulario de creación/edición de egresado */
/* global cargarSelectsEspecialidad */

$(function () {
    // Carga selects de rubro y especialidad (y opción selected si es indicada)
    //  Bindea cambios en select rubro para cambiar options de especialidad
    if (window.categorias) {
        // función definida en main.js
        cargarSelectsEspecialidad(window.categorias);
    }

    //Inicializar datepicker
    var calendario = $('#nacimiento');
    calendario.datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        //defaultDate: '01/01/1998',
        viewMode: 'years'
    });
    calendario.on('dp.change', function(e){
        if(e.date){
            calendario.parent('.form-group').addClass('cargado');
        }else{
            calendario.parent('.form-group').removeClass('cargado');
        }
    });

    //Inicializar contador para promedio
    $("#promedio").TouchSpin({
        min: 1,
        max: 10,
        step: 0.01,
        decimals: 2,
        verticalbuttons: true,
        verticalupclass: 'glyphicon glyphicon-plus',
        verticaldownclass: 'glyphicon glyphicon-minus',
        buttondown_class: "btn btn-promedio",
        buttonup_class: "btn btn-promedio"
    });

    //Mostrar label en carga de datos
    var $inputsEgresado = $('.form-mpt input.form-control');

    $inputsEgresado.on('change', function(){
        var este = $(this);
        var estePadre = este.parents('.form-group');

        if(este.val()){
            estePadre.addClass('cargado');
        }
        else {
            estePadre.removeClass('cargado');
        }
        estePadre.removeClass('has-error');
    });

    // si tiene texto al cargar la pagina, agregar clase cargado (formulario con la data cargada)
    $inputsEgresado.each(function(index, el) {
        if ($(el).val()) {
            $(el).closest('.form-group').addClass('cargado');
        }
    });

    $('.form-mpt button.btn-descartar').click(function() {
        $('.form-mpt .form-group').removeClass('cargado has-error');
    });

    // Vista previa imagen de perfil
    imgPreview("input#cargarFoto","figure#foto-preview");

    // mostrar spinner
    $('form').submit(function() {
        $('.spinner-container').show();
    });

    //Mostrar/ocultar opciones de estudio superior
    var $detalleSuperior = $('.detalle-superior');
    $('.radio-estudio-superior').on('change', function(){
       var valor = $(this).val();
        if (valor === 'si'){
            $detalleSuperior.removeClass('hidden');
        }else{
            $detalleSuperior.addClass('hidden')
                    .children('input[type="text"]').val('');
        }
    });


    // Mask inputs telefonos (usa plugin jquery.mask.js: https://igorescobar.github.io/jQuery-Mask-Plugin/)
    $('input#tel_fijo, input#celular').mask('(000NN) 000000NNNN', {
        translation: {
            'N': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
});


function imgPreview(input_selector,preview_selector) {
    // http://www.phpgang.com/how-to-show-image-thumbnail-before-upload-with-jquery_573.html
    var input = $(input_selector);
    input.change(function() {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) { // no file selected, or no FileReader support
            input.closest('section.cargar-foto').addClass('has-error')
                .find('span.error').html("No puede cargarse el archivo");
            return;
        }
        if (!(/^image/).test( files[0].type)){ // no es una imagen
            input.closest('section.cargar-foto').addClass('has-error')
                .find('span.error').html("No es una imagen");
            input.val("");
            return;
        }
        if (this.files[0].size > 1000000) {   // mayor a 1mb   1048576
            input.closest('section.cargar-foto').addClass('has-error')
                .find('span.error').html("Tamaño máximo superado");
            input.val("");
            return;
        }
        input.closest('section.cargar-foto').removeClass('has-error')
            .find('span.error').html("");
        var reader = new FileReader(); // instance of the FileReader
        reader.readAsDataURL(files[0]); // read the local file
        reader.onloadend = function(){ // set image data as background of div
            $(preview_selector).css("background-image", "none"); // reset preview
            $(preview_selector).css("background-image", "url("+this.result+")");
        };
    });
}