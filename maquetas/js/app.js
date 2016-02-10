// Script con agregados al integrar maquetas en sistema
//Inicialización general (DOM Ready)
$(document).ready(function(){

    var links_disabled = $('a[href="#ToDo"],a[href="#coming-soon"],a[href=#empty]');

    links_disabled.click(function(event) {
        event.preventDefault();
    });
});