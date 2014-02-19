(function($){	
    $.fn.obligatorio=function(){
		if($(this).attr('value') != ''){
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

$(document).ready(function(){	
	$("#fecha").datepicker();	
		
	$.getJSON('php/perfil.php', function(respuesta){
		if(respuesta.login){
			$('#nombre_user').html(respuesta.user);
			$('#perfil').attr('value', respuesta.perfil);
			
			$('#fase').find('option[value="3"]').attr('selected', 'selected');			
			if(respuesta.perfil == '3'){
				$('#base_datos').show();			
				$('#leer').show();
				$('#repetidos').show();
				$('#fraudes').show();
				$('#leer').show();
				$('#leer_todo').show();
				$('#leer_comprobantes').show();
				$('#entrega_beneficiario').show();
				$('#entrega_beneficiario_arriendo').show();
				$('#entrega_beneficiario_reparacion').show();
				$('#entrega_operador').show();
				$('#alojamientos_temporales').show();
				$('#reparacion_alojamientos_temporales').show();
				$('#ejecucion_total').show();
				$('#ejecucion_resumen').show();
				$('#ejecucion_fecha').show();
				$('#reparacion_ejecucion_total').show();
				$('#reparacion_ejecucion_resumen').show();
				$('#reparacion_ejecucion_fecha').show();			
			}
		}
		else{
			$(window).off('beforeunload');
			$(location).attr('href', '../');
		} 
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});
	
	//formularios		
	$("#form_resumen").submit(function(event){
		event.preventDefault();
		if($('#fecha').obligatorio()){			
			$('#cargando').show();												
			var datos = $('#form_resumen').serialize();			
			$.getJSON('php/resumen.php', datos, function(respuesta) {
				if(respuesta.login){					
					$('#tabla').empty();					
					$('#resumen').empty();
					
					if(respuesta.pendientes)
							$('#tabla').append('<thead><tr><th width="5%"></th><th width="10%">Documento</th><th width="20%">Nombre Damnificado</th><th width="10%">Telefono</th><th width="20%">Nombre Arrendador</th><th width="10%">Telefono</th><th width="5%">Arriendo</th><th width="5%">Reparacion</th><th width="5%">Comprob.</th><th width="5%">Mercados</th><th width="5%">Kit de Aseo</th></tr></thead><tbody id="body_tabla"></tbody>');																		
						else
							$('#tabla').append('<thead><tr><th width="5%"></th><th width="10%">Documento</th><th width="30%">Nombre Damnificado</th><th width="25%">Nombre Arrendador</th><th width="5%">Arriendo</th><th width="5%">Reparacion</th><th width="5%">Comprob.</th><th width="5%">Mercados</th><th width="5%">Kit de Aseo</th><th width="5%">Hora</th></tr></thead><tbody id="body_tabla"></tbody>');
																														
					if(respuesta.consulta){							
						$('#resumen').append('<h4> Damnificados Registrados: '+respuesta.damnificados+'</h4><h4>'+respuesta.titulo+'</h4><ul><li> Damnificados: '+respuesta.totalDamnificados+'</li><li> Arriendos: '+respuesta.totalArriendos+'</li><li> Reparaciones: '+respuesta.totalReparaciones+'</li><li> Mercados: '+respuesta.totalMercados+'</li><li> Kits de Aseo: '+respuesta.totalKitsAseo+'</li></ul>');
						
						if(respuesta.pendientes)
							$('#resumen').append('<h4> Entregado a la Fecha </h4><ul><li> Damnificados Atendidos: '+respuesta.damnificadosAtendidos+'</li><li> Arriendos: '+respuesta.arriendosEntregados+'</li><li> Reparaciones: '+respuesta.reparacionesEntregadas+'</li><li> Mercados: '+respuesta.mercadosEntregados+'</li><li> Kits de Aseo: '+respuesta.kitsAseoEntregados+'</li></ul>');				
					
						var i=0;
						if(respuesta.totalDamnificados != '0'){	
							for(i=0; i<respuesta.documentoDamnificado.length; i++){
								if(respuesta.pendientes)
									$('#body_tabla').append('<tr class="cargar_damnificado"><td width="5%">'+(i+1)+'</td><td width="10%">'+respuesta.documentoDamnificado[i]+'</td><td width="20%">'+respuesta.nombreDamnificado[i]+'</td><td width="10%">'+respuesta.telefonoDamnificado[i]+'</td><td width="20%">'+respuesta.nombreArrendador[i]+'</td><td width="10%">'+respuesta.telefonoArrendador[i]+'</td><td class="center" width="5%">'+respuesta.arriendo[i]+'</td><td class="center" width="5%">'+respuesta.reparacion[i]+'</td><td class="center" width="5%">'+respuesta.comprobante[i]+'</td><td class="center" width="5%">'+respuesta.mercados[i]+'</td><td class="center" width="5%">'+respuesta.kitAseo[i]+'</td></tr>');	
								else
									$('#body_tabla').append('<tr class="cargar_damnificado"><td>'+(i+1)+'</td><td>'+respuesta.documentoDamnificado[i]+'</td><td>'+respuesta.nombreDamnificado[i]+'</td><td>'+respuesta.nombreArrendador[i]+'</td><td class="center">'+respuesta.arriendo[i]+'</td><td class="center">'+respuesta.reparacion[i]+'</td><td class="center">'+respuesta.comprobante[i]+'</td><td class="center">'+respuesta.mercados[i]+'</td><td class="center">'+respuesta.kitAseo[i]+'</td><td class="center">'+respuesta.hora[i]+'</td></tr>');		
							}
						}
						if(i > 0){
							$("#resultados").slideDown(400);						
							if(respuesta.pendientes)
								$('#error').html('Quedan entregas pendientes a '+i+' damnificados');
							else	
								$('#error').html('Se realizaron entregas a '+i+' damnificados');
						}
						else
							$('#error').html('No se realizaron entregas en esta fecha');
					}	
					else{
						$("#resultados").slideDown(400);
						if(respuesta.pendientes){
							$('#error').html('No hay entregas pendientes en esta fase');
							$('#body_tabla').append('<tr><td colspan="11" class="center">No hay entregas pendientes en esta fase</td></tr>');								
						}
						else{
							$('#error').html('No se realizaron entregas en esta fecha');
							$('#body_tabla').append('<tr><td colspan="10" class="center">No se realizaron entregas en esta fecha</td></tr>');
						}
							
							
					}			
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - resumen"); 
			});	
		}
		else{
			$("#resultados").slideUp(400);
			$('#tabla').empty();
		}
	});	
	
	$("#repetidos").click(function(event){	
		$('#cargando').show();												
		var datos = $('#form_resumen').serialize();			
		$.getJSON('php/repetidos.php', datos, function(respuesta) {
			if(respuesta.login){					
				$('#tabla').empty();
				$('#tabla').append('<thead><tr><th width="10%"></th><th width="20%">Documento</th><th width="60%">Nombre Damnificado</th><th width="10%">Porcentaje</th></tr></thead><tbody id="body_tabla"></tbody>');
																													
				if(respuesta.consulta){	
					var i=0;					
					for(i=0; i<respuesta.documentoDamnificado.length; i++){
						$('#body_tabla').append('<tr class="cargar_damnificado"><td>'+(i+1)+'</td><td>'+respuesta.documentoDamnificado[i]+'</td><td>'+respuesta.nombreDamnificado[i]+'</td><td class="center">'+respuesta.porcentaje[i]+'%</td></tr>');		
					}
					if(i > 0)
						$("#resultados").slideDown(400);
					
					$('#error').html('Se encontraron '+i+' damnificados repetidos');	
				}	
				else{
					$("#resultados").slideDown(400);
					$('#body_tabla').append('<tr><td colspan="3" class="center">No se encontraron damnificados repetidos</td></tr>');
					$('#error').html('No se encontraron damnificados repetidos');	
				}			
			}
			else{
				$(window).off('beforeunload');
				$(location).attr('href', '../');
			} 
			$("#cargando").delay(400).slideUp(0);
		})
		.error(function() { 
			$("#cargando").delay(400).slideUp(0);
			$('#error').html("Error: Compruebe la conexion de red de su equipo! - repetidos"); 
		});	
	});	
	
	$("#fraudes").click(function(event){	
		$('#cargando').show();												
		var datos = $('#form_resumen').serialize();			
		$.getJSON('php/fraudes.php', datos, function(respuesta) {
			if(respuesta.login){					
				$('#tabla').empty();
				$('#tabla').append('<thead><tr><th width="10%"></th><th width="20%">Documento</th><th width="70%">Nombre Damnificado</th></tr></thead><tbody id="body_tabla"></tbody>');
																													
				if(respuesta.consulta){	
					var i=0;					
					for(i=0; i<respuesta.documentoDamnificado.length; i++){
						$('#body_tabla').append('<tr class="cargar_damnificado"><td>'+(i+1)+'</td><td>'+respuesta.documentoDamnificado[i]+'</td><td>'+respuesta.nombreDamnificado[i]+'</td></tr>');		
					}
					if(i > 0)
						$("#resultados").slideDown(400);
					
					$('#error').html('Se encontraron '+i+' posibles fraudes');	
				}	
				else{
					$("#resultados").slideDown(400);
					$('#body_tabla').append('<tr><td colspan="3" class="center">No se encontraron posibles fraudes</td></tr>');
					$('#error').html('No se encontraron posibles fraudes');	
				}			
			}
			else{
				$(window).off('beforeunload');
				$(location).attr('href', '../');
			} 
			$("#cargando").delay(400).slideUp(0);
		})
		.error(function() { 
			$("#cargando").delay(400).slideUp(0);
			$('#error').html("Error: Compruebe la conexion de red de su equipo! - fraudes"); 
		});	
	});
	
	$("#form_resumen input, #form_resumen select").change(function(event){
		$("#form_resumen").submit();
	});	
	
	$("#limpiar").click(function(event){
		$('#fase').find('option[value="3"]').attr('selected', 'selected');
		$('#fecha').attr('value', '');
			
	});	
	
	$("#actualizar").click(function(event){
		if($('#fecha').attr('value') == '')
			$('#fecha').attr('value', '00/00/0000');
		$("#form_resumen").submit();
	});	
		
	$("#base_datos").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/base_datos.php?fase='+fase;
	});
			
	$("#leer").click(function(event){
		if($('#userfile').obligatorio()){
			var fase = $('#fase').attr('value');
			if(confirm('Desea subir el archivo para la fase '+fase)){
				$('#fase_importar').attr('value', fase);
				$('#form_importar').attr('action', 'informes/leer.php');
				$('#form_importar').submit();
			}
		}
	});
	
	$("#leer_todo").click(function(event){
		if($('#userfile').obligatorio()){
			var fase = $('#fase').attr('value');
			if(confirm('Desea subir el archivo si restricciones, para la fase '+fase)){
				$('#fase_importar').attr('value', fase);
				$('#form_importar').attr('action', 'informes/leer_todo.php');
				$('#form_importar').submit();
			}
		}
	});
	
	$("#leer_comprobantes").click(function(event){
		if($('#userfile').obligatorio()){
			var fase = $('#fase').attr('value');
			if(confirm('Desea subir los numeros de comprobante para la fase '+fase)){
				$('#fase_importar').attr('value', fase);
				$('#form_importar').attr('action', 'informes/leer_comprobantes.php');
				$('#form_importar').submit();
			}
		}
	});
	
	$("#entrega_beneficiario").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/entrega_beneficiario.php?fase='+fase;
	});

	$("#entrega_beneficiario_arriendo").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/entrega_beneficiario_arriendo.php?fase='+fase;
	});

	$("#entrega_beneficiario_reparacion").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/entrega_beneficiario_reparacion.php?fase='+fase;
	});
	
	$("#entrega_operador").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/entrega_operador.php?fase='+fase;
	});
	
	$("#alojamientos_temporales").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/alojamientos_temporales.php?fase='+fase;
	});
	
	$("#reparacion_alojamientos_temporales").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/reparacion_alojamientos_temporales.php?fase='+fase;
	});
	
	$("#ejecucion_total").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/ejecucion_total.php?fase='+fase;
	});
	
	$("#ejecucion_resumen").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/ejecucion_resumen.php?fase='+fase;
	});
	
	$("#ejecucion_fecha").click(function(event){				
		var fase = $('#fase').attr('value');
		var fecha = $('#fecha').attr('value');
		if($('#fecha').obligatorio())
			window.location = 'informes/ejecucion_fecha.php?fase='+fase+'&fecha='+fecha;
	});
	
	$("#reparacion_ejecucion_total").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/reparacion_ejecucion_total.php?fase='+fase;
	});
	
	$("#reparacion_ejecucion_resumen").click(function(event){				
		var fase = $('#fase').attr('value');
		window.location = 'informes/reparacion_ejecucion_resumen.php?fase='+fase;
	});
	
	$("#reparacion_ejecucion_fecha").click(function(event){				
		var fase = $('#fase').attr('value');
		var fecha = $('#fecha').attr('value');
		if($('#fecha').obligatorio())
			window.location = 'informes/reparacion_ejecucion_fecha.php?fase='+fase+'&fecha='+fecha;
	});
	
	$("#cargando").delay(400).slideUp(0);
});