(function($){	
    $.fn.obligatorio=function(){
		if($(this).attr('value') != '' && $(this).attr('value') != '0'){
			$(this).removeClass('input_error');
			return true;
		}
		else{
			$('#error').html($(this).attr('label'));			
			$(this).addClass('input_error');	
			$(this).focus();
			return false;
		}
    }
})(jQuery);

(function($){	
    $.fn.cargarSelect=function(valor, perfil){	
		$(this).find('option[value="'+valor+'"]').attr('selected', 'selected');
	}
})(jQuery);

(function($){
    $.fn.mostrar=function(div){	
		if(div == 'passwd')
			$.fn.passwd('cargar');	
		$(".formulario").hide();
		$("#div_"+div).show();
		$("form:not(.filter) :input:visible:enabled:first").focus();
    }
})(jQuery);

(function($){
    $.fn.lista=function(nombre, ruta, lista, seleccionar){
		$('#cargando').show();
		$('#'+nombre).empty();				
		$.getJSON(ruta, {opc:'lista', id_lista:lista}, function(respuesta) {						
			if(respuesta.login){	
				$('#'+nombre).append('<option value="0" selected > - Seleccionar - </option>');						
				if(respuesta.consulta){	
					for(var i=0; i<respuesta.id.length; i++)
						$('#'+nombre).append('<option value="'+respuesta.id[i]+'" >'+respuesta.nombre[i]+'</option>');
					
					if(seleccionar != '')
						$('#'+nombre).cargarSelect(seleccionar);
				}															
			}									
			else{
				$(window).off('beforeunload');
				$(location).attr('href', 'index.php');
			}			
			$("#cargando").delay(400).slideUp(0);
		})
		.error(function() { 			
			$("#cargando").delay(400).slideUp(0);
			$('#error').html("Error: Compruebe la conexion de red de su equipo! - listaYear"); 
		});	
    }
})(jQuery);

$(document).ready(function(){
	/*
	$(window).bind('beforeunload', function(){
		return 'Estas seguro de continuar';
	});
	*/	
	$("#fecha_inicial_ap").datepicker();
	$("#fecha_final_ap").datepicker();
	$("#fecha_inicial_ap_pdf").datepicker();	
	$("#fecha_final_ap_pdf").datepicker();
	
	$.getJSON('php/perfil.php',{opc:'perfil'}, function(respuesta){
		if(respuesta.login){
			if(respuesta.perfil == 2){
				$('li').hide();
				$('#consulta').show();
				$('input, select').attr('disabled', 'disabled');
			}
			else
				$('#menu').show();
				
			if(respuesta.perfil == 3){
				$('#li_importar_ap').show();
				$('#li_importar_fe').show();
			}
			
			$('#nombre_user').html(respuesta.user); 			
			$.fn.lista('programa_ap','php/programa.php','');
			$.fn.lista('programa_ap_pdf','php/programa.php','');	
		}
		else{
			$(window).off('beforeunload');
			$(location).attr('href', 'index.php');
		}	
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});
	
	$("#importar_ap").click(function(event){		
		if($("#file_importar_ap").obligatorio()){
			if(confirm('Importar Autorizacion de Pago: Estas Seguro de Continuar')){
				$("#cargando").show();
				$("#form_importar_ap").submit();
			}
		}
	});
	
	$("#importar_fe").click(function(event){		
		if($("#file_importar_fe").obligatorio()){
			if(confirm('Importar Factura Equivalente: Estas Seguro de Continuar')){
				$("#cargando").show();
				$("#form_importar_fe").submit();
			}
		}
	});
	
	$("#exportar_ap").click(function(event){
		if($("#programa_ap").obligatorio() || ($("#fecha_inicial_ap").obligatorio() && $("#fecha_final_ap").obligatorio())){
			var fecha_inicial = $('#fecha_inicial_ap').attr('value');
			var fecha_final = $('#fecha_final_ap').attr('value');	
			var programa = $('#programa_ap').attr('value');		
			window.location = 'xls/exportar_ap.php?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&programa='+programa;
		}
	});
		
	$("#listado_ap_pdf").click(function(event){
		if($("#programa_ap_pdf").obligatorio() || ($("#fecha_inicial_ap_pdf").obligatorio() && $("#fecha_final_ap_pdf").obligatorio())){
			var fecha_inicial = $('#fecha_inicial_ap_pdf').attr('value');
			var fecha_final = $('#fecha_final_ap_pdf').attr('value');	
			var programa = $('#programa_ap_pdf').attr('value');	
			window.open('pdf/listado_ap.php?fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&programa='+programa);
		}
	});
		
	$('.lista').click(function(event){			
		$.fn.mostrar($(this).attr('label'));
	})
	
	//keydown
	$(document).not("input[readonly]").keydown(function (event) {		
		if(event.keyCode == 8){			
			if(!$('input').is (':focus') && !$('textarea').is (':focus'))
				event.preventDefault();			
		}
	});
			
	$("#cargando").delay(400).slideUp(0);
});