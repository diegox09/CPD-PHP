(function($){	
    $.fn.numero=function(){
		if($(this).attr('value') != '' && !isNaN($(this).attr('value'))){
			$(this).removeClass('input_error');
			$('#error').hide();
			return true;
		}
		else{
			$('#error').html('Digite un numero de documento valido');
			$('#error').show();			
			$(this).addClass('input_error');	
			$(this).focus();
			return false;
		}
    }
})(jQuery);

(function($){
    $.fn.consulta=function(){
		$('#cargando').show();
		$('#tabla').empty();
		var datos = $('#form_consulta').serialize();				
		$.getJSON('php/ap/consulta_ap.php', datos, function(respuesta) {					
			if(respuesta.consulta){
				$('#tabla').append('<thead><tr><th width="20%">Municipio</th><th width="40%">Programa</th><th width="20%">Fecha</th><th width="20%">Valor</th></tr></thead><tbody id="body_tabla"></tbody>');
				$('#nombre').html(respuesta.nombreCliente[0]);
				for(var i=0; i<respuesta.nombreCliente.length; i++){
					$('#body_tabla').append('<tr><td>'+respuesta.nombreMunicipio[i]+'</td><td>'+respuesta.nombrePrograma[i]+'</td><td class="center">'+respuesta.fecha[i]+'</td><td class="right">'+respuesta.valorTotal[i]+'</td></tr>');		
				}											
				$('#tabla').tablesorter({widgets: ['zebra']});	
				$('#error').hide();
			}	
			else{
				$('#nombre').html("");
				$('#error').html("No se encontro ningun resultado!");
				$('#error').show();
			}
			$("#cargando").delay(400).slideUp(0);			
		})
		.error(function() { 			
			$("#cargando").delay(400).slideUp(0);
			$('#nombre').html("");
			$('#error').html("Error: Compruebe la conexion de red de su equipo!"); 
			$('#error').show();
		});	
    }
})(jQuery);

$(document).ready(function(){
	//keydown
	$('#form_consulta').submit(function(event){
		event.preventDefault();	
		$("#consulta").click();
	});
	
	$(document).not("input[readonly]").keydown(function (event) {		
		if(event.keyCode == 8){			
			if(!$('input').is (':focus') && !$('textarea').is (':focus'))
				event.preventDefault();			
		}
	});
	
	$("#consulta").click(function(event){
		if($("#documento").numero())
			$.fn.consulta();
	});
	
	$("#documento").focus();		
	$("#cargando").delay(400).slideUp(0);
});