$(document).ready(function(){$(document).on("click",'a[href="#ToDo"],a[href="#coming-soon"],a[href=#empty]',function(o){o.preventDefault()}),$('[data-toggle="tooltip"]').tooltip();var o=$("#confirmarEliminar");$(".btn-eliminar").on("click",function(n){n.preventDefault(),o.modal()});var n=$("#solicitarContacto"),a=n.find("form");$("#solicitarBtn").on("click",function(o){o.preventDefault(),n.find(".modal-body.formulario").show().find(".error").hide(),n.find(".modal-body.post-ok").hide(),n.modal()}),n.find("button#solicitar-datos-alumno").click(function(){var o=a.attr("action");$(".spinner-container").show(),$.ajax({url:o,type:"POST",data:a.serialize()}).done(function(o){if(o.status&&"ok"==o.status)n.find(".modal-body.formulario").hide(),n.find(".modal-body.post-ok").fadeIn();else{var a=n.find(".modal-body.formulario .error");a.show(),o.mensaje?a.find(".mensaje").html(o.mensaje):a.find(".mensaje").html("")}}).fail(function(){var o=n.find(".modal-body.formulario .error");o.show(),o.find(".mensaje").html("")}).always(function(){$(".spinner-container").hide()})}),$(document).on("keypress",":input:not(textarea)",function(o){13==o.keyCode&&o.preventDefault()})});