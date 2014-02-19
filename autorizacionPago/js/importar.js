$(document).ready(function(){
	$.getJSON('../php/perfil.php', function(respuesta){
		$('#nombre_user').html(respuesta.user);	 
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});
	
	$('#salir').click(function(event){	
		$(window).off('beforeunload');
		$(location).attr('href', '../php/salir.php'); 
	});
	
	$("#regresar").click(function(event){
		window.location = '../administracion.php';
	});	
	
	$("#imprimir_ap").click(function(event){		
		var lista = $('#lista').attr('value');	
		window.open('../pdf/ap_pdf.php?id_ap='+lista);
	});
	
	$("#deshacer_ap").click(function(event){	
		if(confirm('Estas Seguro de Continuar')){	
			var lista = $('#lista').attr('value');
			$('#cargando').show();					
			$.getJSON('../php/ap/eliminar_ap.php', {id_ap:lista}, function(respuesta) {
				$('#tabla').empty();						
				if(respuesta.login){	
					if(respuesta.consulta){
						$('#tabla').append('<thead><tr><th width="10%">No.</th><th width="40%">Programa</th><th width="40%">Municipio</th><th width="10%">Eliminada</th></tr><tbody id="body_tabla"></tbody></thead>');														
						for(i=0; i<respuesta.consecutivo.length; i++){
							$('#body_tabla').append('<tr><td>'+respuesta.consecutivo[i]+'</td><td>'+respuesta.nombrePrograma[i]+'</td><td>'+respuesta.nombreMunicipio[i]+'</td><td>'+respuesta.eliminada[i]+'</td></tr>');	
						}
						$('#tabla').tablesorter({widgets: ['zebra']});
					}
					$('#deshacer').hide();					
				}
				else
					$(location).attr('href', 'index.php');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - eliminar'); 
			});							
		}
	});
	
	$("#imprimir_fe").click(function(event){		
		var lista = $('#lista').attr('value');	
		window.open('../pdf/fe_pdf.php?id_fe='+lista);
	});
	
	/*
	$("#deshacer_fe").click(function(event){	
		if(confirm('Estas Seguro de Continuar')){	
			var lista = $('#lista').attr('value');
			$('#cargando').show();					
			$.getJSON('../php/ap/eliminar_ap.php', {id_ap:lista}, function(respuesta) {
				$('#tabla').empty();						
				if(respuesta.login){	
					if(respuesta.consulta){
						$('#tabla').append('<thead><tr><th width="10%">No.</th><th width="40%">Programa</th><th width="40%">Municipio</th><th width="10%">Eliminada</th></tr><tbody id="body_tabla"></tbody></thead>');														
						for(i=0; i<respuesta.consecutivo.length; i++){
							$('#body_tabla').append('<tr><td>'+respuesta.consecutivo[i]+'</td><td>'+respuesta.nombrePrograma[i]+'</td><td>'+respuesta.nombreMunicipio[i]+'</td><td>'+respuesta.eliminada[i]+'</td></tr>');	
						}
						$('#tabla').tablesorter({widgets: ['zebra']});
					}
					$('#deshacer').hide();					
				}
				else
					$(location).attr('href', 'index.php');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - eliminar'); 
			});							
		}
	});
	*/	
	$("#cargando").delay(400).slideUp(0);
});