$(function () {
    //Inicializar datepicker
    var calendario = $('#nacimiento');
    calendario.datetimepicker({
        locale: 'es',
        format: 'DD/MM/YYYY',
        //defaultDate: '01/01/1998',
        viewMode: 'years'
    });
    calendario.on('dp.change', function(e){
        if(e.date != ''){
            calendario.parent('.form-group').addClass('cargado');
        }else{
            calendario.parent('.form-group').removeClass('cargado');
        }

    });

    //Inicializar contador para promedio
    $("#promedioGeneral").TouchSpin({
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
});