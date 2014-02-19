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

(function($){	
    $.fn.cargarSelect=function(valor, perfil){	
		$(this).find('option[value="'+valor+'"]').attr('selected', 'selected');
		if(valor == 0 || perfil != '')
			$(this).removeAttr('readonly');
		else
			$(this).attr('readonly', true);	
	}
})(jQuery);

(function($){	
    $.fn.cargarInput=function(valor, perfil){		
		$(this).attr('value', valor);
		if(valor == '' || perfil != '')
			$(this).removeAttr('readonly');
		else
			$(this).attr('readonly', true);	
    }
})(jQuery);

(function($){	
    $.fn.cargarTextarea=function(valor){		
		$(this).attr('value', valor);
		$(this).removeAttr('readonly');
    }
})(jQuery);

(function($){	
    $.fn.verificarFechas=function(){
		if($('#guardar_entregas').is(':visible')){
			if($('#fecha_kit_aseo').attr('value') != '' && $('#fecha_mercado1').attr('value') != '' && $('#fecha_mercado2').attr('value') != '' && $('#fecha_mercado3').attr('value') != '' && $('#fecha_mercado4').attr('value') != '')
				return true;
			else
				return false;
		}		
		
		if($('#guardar_arriendo').is (':visible') && $('#comprobante').attr('value') != ''){
			if($('#fecha_arriendo').attr('value') != '')
				return true;
			else
				return false;
		}
		
		if($('#guardar_reparacion').is (':visible')){
			if($('#fecha_reparacion').attr('value') != '')
				return true;
			else
				return false;
		}
		return true;
    }
})(jQuery);

(function($){	
    $.fn.buscar=function(){
		if($('#input_buscar').obligatorio()){
			$("#buscar").attr("disabled","disabled");			
			$('#cargando').show();
			$.fn.limpiarDamnificado();													
			var datos = $('#form_buscar').serialize();			
			$.getJSON('php/buscar.php', datos, function(respuesta) {
				if(respuesta.login){
					$('#tabla').empty();
					if(respuesta.damnificado)					
						$('#tabla').append('<thead><tr><th width="10%"></th><th width="20%">Documento</th><th width="70%">Nombre Damnificado</th></tr></thead><tbody id="body_tabla"></tbody>');
					else
						$('#tabla').append('<thead><tr><th width="4%"></th><th width="10%">Documento</th><th width="38%">Nombre Damnificado</th><th width="10%">Documento</th><th width="38%">Nombre Arrendador</th></tr></thead><tbody id="body_tabla"></tbody>');
																						
					if(respuesta.consulta){						
						var i=0;
						
						for(i=0; i<respuesta.idDamnificado.length; i++){
							if(respuesta.damnificado)
								$('#body_tabla').append('<tr id="'+respuesta.idDamnificado[i]+'" class="cargar_damnificado"><td>'+(i+1)+'</td><td>'+respuesta.documentoDamnificado[i]+'</td><td>'+respuesta.nombreDamnificado[i]+'</td></tr>');	
							else		
								$('#body_tabla').append('<tr id="'+respuesta.idDamnificado[i]+'" class="cargar_damnificado"><td>'+(i+1)+'</td><td>'+respuesta.documentoDamnificado[i]+'</td><td>'+respuesta.nombreDamnificado[i]+'</td><td>'+respuesta.documentoArrendador[i]+'</td><td>'+respuesta.nombreArrendador[i]+'</td></tr>');	
						}
						if(i==1){							
							if(respuesta.documentoArrendador[0] != '')
								$("#resultados").slideDown(400);
							else
								$('#'+respuesta.idDamnificado[0]).click();	
						}
						else
							$("#resultados").slideDown(400);						
							
						$('#error').html('Se encontraron '+i+' damnificados');		
					}
					else{
						$("#resultados").slideDown(400);
						$('#body_tabla').append('<tr><td colspan="5" class="center">No se encontro ningun damnificado</td></tr>');
						$('#error').html('No se encontro ningun damnificado');	
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#buscar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#buscar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - buscar"); 
			});	
		}
		else{
			$("#resultados").slideUp(400);
			$('#tabla').empty();
		}
    }
})(jQuery);	

//formulario damnificado
(function($){	
    $.fn.limpiarDamnificado=function(){	
		$('#fase').cargarSelect(3);
		$("#fase_damnificado").cargarInput(3);
		$("#fase_arrendador").cargarInput(3);
		$("#fase_arriendo").cargarInput(3);
		$("#fase_entregas").cargarInput(3);
		$("#fase_reparacion").cargarInput(3);
					
		$('#form_damnificado').find('.input_error').removeClass('input_error');	
		$('#id_damnificado').cargarInput('');
		$('#td').cargarSelect(1);
		$('#documento_damnificado').cargarInput('');
		$('#primer_nombre').cargarInput('');
		$('#segundo_nombre').cargarInput('');
		$('#primer_apellido').cargarInput('');
		$('#segundo_apellido').cargarInput('');
		$('#genero').cargarSelect(0);
		$('#telefono_damnificado').cargarInput('');		
		$('#direccion_damnificado').cargarInput('');
		$('#barrio').cargarInput('');
		$('#fecha_observaciones_damnificado').html('');
		$('#usuario_observaciones_damnificado').html('');
		$('#observaciones_damnificado').cargarTextarea('');
				
		$('#id_damnificado_arriendo').cargarInput('');
		$('#id_damnificado_arrendador').cargarInput('');
		$('#id_damnificado_entregas').cargarInput('');
		$('#id_damnificado_reparacion').cargarInput('');
		
		$("#guardar_damnificado").hide();		
		if($('#perfil').attr('value') == '3'){			
			$("#damnificado_nuevo").show();
			$("#arriendo_nuevo").hide();
			$("#entregas_nuevo").hide();
			$("#reparacion_nueva").hide();
		}
		$.fn.limpiarArriendo();
		$.fn.limpiarReparacion();
		$.fn.limpiarEntregas();		
		$('#form_damnificado input[type="text"], #form_damnificado select, #form_damnificado textarea').attr('readonly', true);
	}
})(jQuery);

(function($){	
    $.fn.cargarDamnificado=function(respuesta){		
		var perfil='';
		if(respuesta.perfil == '2' || respuesta.perfil == '3')
			perfil='x'
			
		$('#form_damnificado').find('.input_error').removeClass('input_error');	
		$('#id_damnificado').cargarInput(respuesta.idDamnificado);
		$('#td').cargarSelect(respuesta.td, perfil);
		$('#documento_damnificado').cargarInput(respuesta.documento, perfil);
		$('#primer_nombre').cargarInput(respuesta.primerNombre, perfil);
		$('#segundo_nombre').cargarInput(respuesta.segundoNombre, perfil);
		$('#primer_apellido').cargarInput(respuesta.primerApellido, perfil);
		$('#segundo_apellido').cargarInput(respuesta.segundoApellido, perfil);
		$('#genero').cargarSelect(respuesta.genero, perfil);
		$('#telefono_damnificado').cargarInput(respuesta.telefono, 'x');		
		$('#direccion_damnificado').cargarInput(respuesta.direccion, 'x');
		$('#barrio').cargarInput(respuesta.barrio, 'x');
		$('#fecha_observaciones_damnificado').html(respuesta.fecha);
		$('#usuario_observaciones_damnificado').html(respuesta.user);
		$('#observaciones_damnificado').cargarTextarea(respuesta.observaciones);
				
		$('#id_damnificado_arriendo').cargarInput(respuesta.idDamnificado);
		$('#id_damnificado_arrendador').cargarInput(respuesta.idDamnificado);
		$('#id_damnificado_entregas').cargarInput(respuesta.idDamnificado);
		$('#id_damnificado_reparacion').cargarInput(respuesta.idDamnificado);
		
		$("#guardar_damnificado").show();
		if(respuesta.perfil == '3'){
			$("#damnificado_nuevo").hide();
			$("#arriendo_nuevo").show();
			$("#entregas_nuevo").show();
			$("#reparacion_nueva").show();
		}		
		$.fn.entregas('cargar');
		$.fn.arriendo('cargar');
		$.fn.reparacion('cargar');
	}
})(jQuery);	

(function($){	
    $.fn.damnificado=function(opc){		
		if((opc == 'nuevo' && $('#input_buscar').obligatorio()) || (opc == 'cargar' && $('#id_damnificado').obligatorio()) || ($('#id_damnificado').obligatorio() && $('#documento_damnificado').obligatorio() && $('#primer_nombre').obligatorio())){				
			$("#guardar_damnificado").attr("disabled","disabled");			
			$('#opc_damnificado').attr('value', opc);			
			$('#cargando').show();												
			var datos = $('#form_damnificado').serialize();			
			$.getJSON('php/damnificado.php', datos, function(respuesta) {
				if(respuesta.login){
					if(respuesta.consulta){											
						switch(respuesta.opc){
							case 'arriendo':$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);										
											break;							
							case 'cargar':  $.fn.cargarDamnificado(respuesta);											 
											$('#error').html('Damnificado cargado correctamente');										
											break;
							case 'entregas':$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);										
											break;												
							case 'guardar':	$.fn.cargarDamnificado(respuesta);
											$('#error').html('Damnificado modificado correctamente');	
											break;
							case 'nuevo':	$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);	
											break;
							case 'reparacion':$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);										
											break;									
						}
					}
					else{
						switch(respuesta.opc){
							case 'arriendo':$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);
											alert(respuesta.mensaje);										
											break;							
							case 'cargar':  $.fn.limpiarDamnificado();
											$('#error').html('Error al cargar el damnificado');	
											alert('Error al cargar el damnificado');									
											break;
							case 'entregas':$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);
											alert(respuesta.mensaje);										
											break;					
							case 'guardar':	$.fn.cargarDamnificado(respuesta);							
											$('#error').html(respuesta.mensaje);
											alert(respuesta.mensaje);
											break;
							case 'nuevo':	$.fn.limpiarDamnificado();									
											$('#error').html(respuesta.mensaje);												
											alert(respuesta.mensaje);
											break;
							case 'reparacion':$.fn.cargarDamnificado(respuesta);
											$('#error').html(respuesta.mensaje);
											alert(respuesta.mensaje);										
											break;									
						}								
					}
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#guardar_damnificado").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_damnificado").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - damnificado"); 
			});							
		}
		else{
			if($('#id_damnificado').attr('value') == ''){
				$.fn.limpiarDamnificado();
				$("#input_buscar").attr('value', '');
				$("#input_buscar").focus();	
			}
		}		
	}
})(jQuery);

(function($){	
    $.fn.limpiarArriendo=function(){
		$('#div_arriendo').hide();		
		$('#form_arriendo').find('.input_error').removeClass('input_error');
					
		$('#id_arrendador_arriendo').cargarInput('');
		$('#fecha_observaciones_arriendo').html('');
		$('#usuario_observaciones_arriendo').html('');			
		$('#observaciones_arriendo').cargarInput('');
		$('#fecha_arriendo').cargarInput('');
		$('#comprobante').cargarInput('');
		$('#cheque').cargarInput('');
				
		$("#bloquear_arriendo").hide();
		$('#guardar_arriendo').hide();
		$("#eliminar_arriendo").hide();
		$('#contrato').hide();
		$('#egreso').hide();
		
		$.fn.limpiarArrendador();
		$('#form_arrendador').hide();
		$('#form_cambiar_arrendador').hide();		
		$('#form_arriendo input[type="text"], #form_arriendo textarea').attr('readonly', true);		
	}
})(jQuery);

(function($){	
    $.fn.cargarArriendo=function(respuesta){
		var perfil='';
		if(respuesta.perfil == '3')
			perfil='x'
		
		$('#form_arriendo').find('.input_error').removeClass('input_error');
		$('#documento_cambiar_arrendador').cargarInput('');		
		$('#id_arrendador_arriendo').cargarInput(respuesta.idArrendador);				
		$('#fecha_observaciones_arriendo').html(respuesta.fecha, perfil);
		$('#usuario_observaciones_arriendo').html(respuesta.user, perfil);			
		$('#observaciones_arriendo').cargarTextarea(respuesta.observaciones);
		$('#fecha_arriendo').cargarInput(respuesta.fechaArriendo, perfil);
		$('#comprobante').cargarInput(respuesta.comprobante, perfil);
		$('#cheque').cargarInput(respuesta.cheque, perfil);		
		$('#bloquear_arriendo').removeAttr('checked');
		
		if(respuesta.idArrendador != '0'){
			$('#id_arrendador').cargarInput(respuesta.idArrendador);
			$.fn.arrendador('cargar');			
			$('#form_arrendador').show();			
		}
		else
			$('#form_arrendador').hide();			
		
		if(respuesta.perfil == '1'){
			$('#form_arriendo input[type="text"], #form_arriendo textarea').attr('readonly', true);
			$('#guardar_arriendo').hide();
			$('#contrato').hide();
			$('#egreso').hide();
		}
		else{
			$('#guardar_arriendo').show();
			$('#contrato').show();
			$('#egreso').show();
		}
		
		if(respuesta.perfil == '3'){
			$("#bloquear_arriendo").show();
			$("#eliminar_arriendo").show();
			if(respuesta.idArrendador == '0')
				$('#form_cambiar_arrendador').show();
			else
				$('#form_cambiar_arrendador').hide();
		}
		
		if(respuesta.estado == '1'){
			$('#bloquear_arriendo').attr('checked', true);
			$('#guardar_arriendo').hide();
			$("#eliminar_arriendo").hide();
			$('#contrato').hide();
			$('#egreso').hide();
			$('#form_arriendo input[type="text"], #form_arriendo textarea').attr('readonly', true);
		}
		else
			$('#bloquear_arriendo').removeAttr('checked');
	}
})(jQuery);	

(function($){	
    $.fn.arriendo=function(opc){
		if($('#id_damnificado_arriendo').obligatorio()){	
			$("#guardar_arriendo").attr("disabled","disabled");	
			$('#opc_arriendo').attr('value', opc);			
			$('#cargando').show();													
			var datos = $('#form_arriendo').serialize();			
			$.getJSON('php/arriendo.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){													
							case 'cargar':  $('#div_arriendo').show();	
											$.fn.cargarArriendo(respuesta);										
											break;
							case 'eliminar':$('#div_arriendo').hide();
											$.fn.limpiarArriendo();	
											$('#error').html('Arriendo eliminado correctamente');									
											break;				
							case 'guardar': $.fn.cargarArriendo(respuesta);
											$('#error').html('Arriendo guardado correctamente');										
											break;											
						}
					}
					else{	
						switch(respuesta.opc){						
							case 'cargar':  $('#div_arriendo').hide();
											$.fn.limpiarArriendo();
											$('#observaciones_arriendo').attr('value', 'El damnificado no esta autorizado para arriendo en esta fase');																																							
											break;
							case 'eliminar':$.fn.arriendo('cargar');
											$('#error').html('Error al eliminar el arriendo');
											alert('Error al eliminar el arriendo');										
											break;				
							case 'guardar': $.fn.cargarArriendo(respuesta);
											$('#error').html('Error al guardar el arriendo, el numero de comprobante ya fue registrado o el arrendador aparece como damnificado');
											alert('Error al guardar el arriendo, el numero de comprobante ya fue registrado o el arrendador aparece como damnificado');
											break;							
						}							
					}
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#guardar_arriendo").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_arriendo").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - arriendo"); 
			});							
		}
	}
})(jQuery);

(function($){	
    $.fn.limpiarArrendador=function(){
		$('#form_arrendador').find('.input_error').removeClass('input_error');	
		$('#id_arrendador').cargarInput('');	
		$('#id_arrendador_arriendo').cargarInput('');			
		$('#documento_arrendador').cargarInput('');
		$('#documento_cambiar_arrendador').cargarInput('');
		$('#nombre_arrendador').cargarInput('');
		$('#telefono_arrendador').cargarInput('');		
		$('#direccion_arrendador').cargarInput('');
		$('#usuario_observaciones_arrendador').html('');
		$('#fecha_observaciones_arrendador').html('');		
		
		$('#guardar_arrendador').hide();
		
		$('#form_arrendador input[type="text"], #form_arrendador textarea').attr('readonly', true);	
	}
})(jQuery);

(function($){	
    $.fn.cargarArrendador=function(respuesta){
		if((respuesta.opc == 'buscar' || respuesta.opc == 'nuevo') && respuesta.idArrendador != '0'){
			$('#id_arrendador_arriendo').cargarInput(respuesta.idArrendador);
			$.fn.arriendo('guardar');
			$('#form_cambiar_arrendador').hide();
			$('#form_arrendador').show();			
		}
		else{
			var perfil='';
			if(respuesta.perfil == '3' || respuesta.perfil == '2')
				perfil='x'
			
			$('#form_arrendador').find('.input_error').removeClass('input_error');	
			$('#id_arrendador').cargarInput(respuesta.idArrendador);						
			$('#documento_arrendador').cargarInput(respuesta.documento, perfil);
			$('#documento_cambiar_arrendador').cargarInput('');
			$('#nombre_arrendador').cargarInput(respuesta.nombre, perfil);
			$('#telefono_arrendador').cargarInput(respuesta.telefono, 'x');		
			$('#direccion_arrendador').cargarInput(respuesta.direccion, 'x');
			
			$('#usuario_arrendador').html(respuesta.user);
			$('#fecha_arrendador').html(respuesta.fecha);		
			
			/*if(respuesta.perfil == '1'){
				$('#form_arrendador input[type="text"]').attr('readonly', true);
				$('#guardar_arrendador').hide();			
			}
			else*/
			$('#guardar_arrendador').show();
				
			if(respuesta.perfil == '3')			
				$("#eliminar_arrendador").show();	
		}
	}
})(jQuery);	

(function($){	
    $.fn.arrendador=function(opc){
		if((opc == 'nuevo' && $('#id_damnificado_arrendador').obligatorio() && $('#documento_arrendador').obligatorio()) || (opc == 'cargar' && $('#id_damnificado_arrendador').obligatorio() && $('#id_arrendador').obligatorio()) || ($('#id_damnificado_arrendador').obligatorio() && $('#id_arrendador').obligatorio() && $('#documento_arrendador').obligatorio() && $('#nombre_arrendador').obligatorio())){	
			$("#guardar_arrendador").attr("disabled","disabled");
			$('#opc_arrendador').attr('value', opc);				
			$('#cargando').show();													
			var datos = $('#form_arrendador').serialize();			
			$.getJSON('php/arrendador.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){													
							case 'cargar':  $.fn.cargarArrendador(respuesta);										
											break;										
							case 'guardar': $.fn.cargarArrendador(respuesta);
											$('#error').html('Arrendador guardado correctamente');										
											break;											
						}	
					}
					else{	
						switch(respuesta.opc){						
							case 'cargar':  $.fn.limpiarArrendador();
											$('#error').html('Error al cargar el arrendador');																																										
											break;
							case 'guardar': $.fn.cargarArrendador(respuesta);	
											$('#error').html('Error al guardar el arrendador, el numero de documento ya existe o pertenece a un damnificado en esta fase');
											alert('Error al guardar el arrendador, el numero de documento ya existe o pertenece a un damnificado en esta fase');
											break;							
						}									
					}
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#guardar_arrendador").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_arrendador").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - arrendador"); 
			});							
		}
	}
})(jQuery);

(function($){	
    $.fn.cambiar_arrendador=function(opc){
		if($('#documento_cambiar_arrendador').obligatorio()){	
			$("#cambiar_arrendador").attr("disabled","disabled");
			$('#opc_cambiar_arrendador').attr('value', opc);				
			$('#cargando').show();													
			var datos = $('#form_cambiar_arrendador').serialize();			
			$.getJSON('php/arrendador.php', datos, function(respuesta) {
				if(respuesta.login){									
					if(respuesta.consulta){	
						switch(respuesta.opc){													
							case 'buscar':  $.fn.cargarArrendador(respuesta);
											$('#error').html('Arrendador adicionado correctamente');										
											break;
							case 'nuevo':  	$.fn.cargarArrendador(respuesta);
											$('#error').html('Arrendador creado correctamente');										
											break;																					
						}	
					}
					else{	
						switch(respuesta.opc){						
							case 'buscar':  $('#error').html('El arrendador no esta registrado');																																							
											break;
							case 'nuevo':  	$('#error').html(respuesta.mensaje);
											alert(respuesta.mensaje);																																							
											break;																	
						}									
					}
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#cambiar_arrendador").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#cambiar_arrendador").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - modificar_arrendador"); 
			});							
		}
	}
})(jQuery);

(function($){	
    $.fn.limpiarReparacion=function(){
		$('#form_reparacion').hide();	
		$('#form_reparacion').find('.input_error').removeClass('input_error');
		
		$('#fecha_observaciones_reparacion').html('');
		$('#usuario_observaciones_reparacion').html('');			
		$('#observaciones_reparacion').cargarInput('');
		$('#comprobante_reparacion').cargarInput('');
		$('#fecha_reparacion').cargarInput('');
				
		$("#bloquear_reparacion").hide();
		$('#guardar_reparacion').hide();
		$("#eliminar_reparacion").hide();		
				
		$('#form_reparacion input[type="text"], #form_reparacion textarea').attr('readonly', true);		
	}
})(jQuery);

(function($){	
    $.fn.cargarReparacion=function(respuesta){
		var perfil='';
		if(respuesta.perfil == '3')
			perfil='x'
		
		$('#form_reparacion').find('.input_error').removeClass('input_error');
		$('#fecha_observaciones_reparacion').html(respuesta.fecha, perfil);
		$('#usuario_observaciones_reparacion').html(respuesta.user, perfil);			
		$('#observaciones_reparacion').cargarTextarea(respuesta.observaciones);
		$('#comprobante_reparacion').cargarInput(respuesta.comprobante, perfil);
		$('#fecha_reparacion').cargarInput(respuesta.fechaReparacion, perfil);
		$('#bloquear_reparacion').removeAttr('checked');				
		
		if(respuesta.perfil == '1'){
			$('#form_reparacion input[type="text"], #form_reparacion textarea').attr('readonly', true);
			$('#guardar_reparacion').hide();
		}
		else
			$('#guardar_reparacion').show();
		
		if(respuesta.perfil == '3'){
			$("#bloquear_reparacion").show();
			$("#eliminar_reparacion").show();
		}
		
		if(respuesta.estado == '1'){
			$('#bloquear_reparacion').attr('checked', true);
			$('#guardar_reparacion').hide();
			$("#eliminar_reparacion").hide();
			$('#form_reparacion input[type="text"], #form_reparacion textarea').attr('readonly', true);
		}
		else
			$('#bloquear_reparacion').removeAttr('checked');
	}
})(jQuery);	

(function($){	
    $.fn.reparacion=function(opc){
		if($('#id_damnificado_reparacion').obligatorio()){	
			$("#guardar_reparacion").attr("disabled","disabled");	
			$('#opc_reparacion').attr('value', opc);			
			$('#cargando').show();													
			var datos = $('#form_reparacion').serialize();			
			$.getJSON('php/reparacion.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){													
							case 'cargar':  $('#form_reparacion').show();	
											$.fn.cargarReparacion(respuesta);										
											break;
							case 'eliminar':$('#form_reparacion').hide();
											$.fn.limpiarReparacion();	
											$('#error').html('Reparacion de vivienda eliminada correctamente');									
											break;				
							case 'guardar': $.fn.cargarReparacion(respuesta);
											$('#error').html('Reparacion de vivienda guardada correctamente');										
											break;											
						}
					}
					else{	
						switch(respuesta.opc){						
							case 'cargar':  $('#form_reparacion').hide();
											$.fn.limpiarReparacion();
											$('#observaciones_reparacion').attr('value', 'El damnificado no esta autorizado para reparacion de vivienda en esta fase');																																							
											break;
							case 'eliminar':$.fn.reparacion('cargar');
											$('#error').html('Error al eliminar la reparacion de vivienda');
											alert('Error al eliminar la reparacion de vivienda');										
											break;				
							case 'guardar': $.fn.cargarReparacion(respuesta);
											$('#error').html('Error al guardar la reparacion de vivienda, el numero de comprobante ya fue registrado');
											alert('Error al guardar la reparacion de vivienda, el numero de comprobante ya fue registrado');
											break;							
						}							
					}
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				} 
				$("#guardar_reparacion").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_reparacion").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - reparacion"); 
			});							
		}
	}
})(jQuery);

(function($){	
    $.fn.limpiarEntregas=function(){
		$("#form_entregas").hide();		
		$('#form_entregas').find('.input_error').removeClass('input_error');
		
		$('#fecha_observaciones_entregas').html('');
		$('#usuario_observaciones_entregas').html('');			
		$('#observaciones_entregas').cargarInput('');
		$('#ficho').cargarInput('');
		$('#fecha_kit_aseo').cargarInput('');
		$('#fecha_mercado1').cargarInput('');
		$('#fecha_mercado2').cargarInput('');
		$('#fecha_mercado3').cargarInput('');
		$('#fecha_mercado4').cargarInput('');
		$('#bloquear_entregas').removeAttr('checked');
				
		$('#form_entregas input[type="text"], #form_entregas textarea').attr('readonly', true);
		$("#bloquear_entregas").hide();
		$('#guardar_entregas').hide();
		$("#eliminar_entregas").hide();
		$('#entregar_todo').hide();
		$('#hoja_ayuda').hide();
	}
})(jQuery);

(function($){	
    $.fn.cargarEntregas=function(respuesta){
		var perfil='';
		if(respuesta.perfil == '3')
			perfil='x'
		
		$('#form_entregas').find('.input_error').removeClass('input_error');				
		$('#fecha_observaciones_entregas').html(respuesta.fecha, perfil);
		$('#usuario_observaciones_entregas').html(respuesta.user, perfil);			
		$('#observaciones_entregas').cargarTextarea(respuesta.observaciones);
		$('#ficho').cargarInput(respuesta.ficho, perfil);		
		$('#fecha_kit_aseo').cargarInput(respuesta.fechaKitAseo, perfil);		
		$('#fecha_mercado1').cargarInput(respuesta.fechaMercado1, perfil);
		$('#fecha_mercado2').cargarInput(respuesta.fechaMercado2, perfil);
		$('#fecha_mercado3').cargarInput(respuesta.fechaMercado3, perfil);
		$('#fecha_mercado4').cargarInput(respuesta.fechaMercado4, perfil);			
		
		if(respuesta.perfil == '1'){
			$('#form_entregas input[type="text"], #form_entregas textarea').attr('readonly', true);
			$('#guardar_entregas').hide();
			$('#entregar_todo').hide();
			$('#hoja_ayuda').hide();
		}
		else{
			$('#guardar_entregas').show();
			$('#entregar_todo').show();
			$('#hoja_ayuda').show();
		}
		
		if(respuesta.perfil == '3'){
			$("#bloquear_entregas").show();
			$("#eliminar_entregas").show();
		}
				
		if(respuesta.estado == '1'){
			$('#bloquear_entregas').attr('checked', true);
			$('#guardar_entregas').hide();
			$("#eliminar_entregas").hide();
			$('#entregar_todo').hide();
			$('#hoja_ayuda').hide();
			$('#form_entregas input[type="text"], #form_entregas textarea').attr('readonly', true);
		}
		else
			$('#bloquear_entregas').removeAttr('checked');
	}
})(jQuery);	

(function($){	
    $.fn.entregas=function(opc){
		if($('#id_damnificado_entregas').obligatorio()){	
			$("#guardar_entregas").attr("disabled","disabled");	
			$('#opc_entregas').attr('value', opc);			
			$('#cargando').show();													
			var datos = $('#form_entregas').serialize();			
			$.getJSON('php/entregas.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){
						switch(respuesta.opc){													
							case 'cargar':  $("#form_entregas").show();		
											$.fn.cargarEntregas(respuesta);										
											break;
							case 'eliminar':$("#form_entregas").hide();	
											$.fn.limpiarEntregas();	
											$('#error').html('Entregas eliminadas correctamente');										
											break;				
							case 'guardar': $.fn.cargarEntregas(respuesta);	
											$('#error').html('Entregas guardadas correctamente');										
											break;
							case 'todo': $.fn.cargarEntregas(respuesta);
											$('#error').html('Entregas guardadas correctamente');										
											break;												
						}	
					}
					else{	
						switch(respuesta.opc){						
							case 'cargar':  $("#form_entregas").hide();		
											$.fn.limpiarEntregas();
											$('#observaciones_entregas').attr('value', 'El damnificado no esta autorizado para entregas en esta fase');																																					
											break;
							case 'eliminar':$.fn.entregas('cargar');
											$('#error').html('Error al eliminar las entregas');
											alert('Error al eliminar las entregas');										
											break;				
							case 'guardar': $.fn.cargarEntregas(respuesta);	
											$('#error').html('Error al guardar las entregas, el numero de ficho ya fue registrado');
											alert('Error al guardar las entregas, el numero de ficho ya fue registrado');
											break;
							case 'todo': 	$.fn.cargarEntregas(respuesta);	
											$('#error').html('Error al guardar las entregas');
											alert('Error al guardar las entregas');													
											break;								
						}							
					}
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', '../');
				}
				$("#guardar_entregas").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_entregas").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - entregas"); 
			});							
		}
	}
})(jQuery);

$(document).ready(function(){
	$(window).on('beforeunload', function(){
		return 'Estas seguro de continuar';
	});
	
	$.fn.limpiarDamnificado();
	$("#input_buscar").focus();
	$("#fecha_arriendo").datepicker();
	$("#fecha_reparacion").datepicker();
	$("#fecha_kit_aseo").datepicker();
	$("#fecha_mercado1").datepicker();
	$("#fecha_mercado2").datepicker();
	$("#fecha_mercado3").datepicker();
	$("#fecha_mercado4").datepicker();
	
	$.getJSON('php/perfil.php', function(respuesta){
		if(respuesta.login){
			$('#nombre_user').html(respuesta.user);
			$('#perfil').attr('value', respuesta.perfil);
			$.fn.limpiarDamnificado();
		}
		else{
			$(window).off('beforeunload');
			$(location).attr('href', '../');
		}
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});
	
	$('#salir').click(function(event){	
		$(window).off('beforeunload');
		$(location).attr('href', 'php/salir.php'); 
	});
	
	$('#resumen').click(function(event){
		$(window).off('beforeunload');
		$(location).attr('href', 'resumen.php'); 
	});
	
	//limpiar
	$("#limpiar").click(function(event){		
		$('#error').html('');		
		$.fn.limpiarDamnificado();
		$('#arrendador').removeAttr('checked');
		$("#input_buscar").attr('value', '');
		$("#input_buscar").focus();	
	});
	
	//cambiar fase
	$("#fase").change(function(event){
		$("#fase_damnificado").cargarInput($(this).attr('value'));
		$("#fase_arrendador").cargarInput($(this).attr('value'));
		$("#fase_arriendo").cargarInput($(this).attr('value'));
		$("#fase_entregas").cargarInput($(this).attr('value'));
		$("#fase_reparacion").cargarInput($(this).attr('value'));
		
		$.fn.entregas('cargar');
		$.fn.arriendo('cargar');
		$.fn.reparacion('cargar');
	});
	
	$("#actualizar").click(function(event){		
		$('#error').html('');	
		$.fn.damnificado('cargar');		
	});
	
	//Mostrar - Ocultar	
	$("#resultado").click(function(event){
		$("#resultados").slideToggle(400);
	});		
	
	$("#arriendo").click(function(event){
		$("#div_arriendo").slideToggle(400);
	});
	
	$("#reparacion").click(function(event){
		$("#form_reparacion").slideToggle(400);
	});	
	
	$("#mercados").click(function(event){
		$("#form_entregas").slideToggle(400);
	});
	
	//botones
	$("#damnificado_nuevo").click(function(event){
		if(!isNaN($("#input_buscar").attr('value'))){
			$("#documento_damnificado").attr('value', $("#input_buscar").attr('value'));				
			$.fn.damnificado('nuevo');
		}
		else{
			$("#input_buscar").attr('value', '');
			$("#input_buscar").focus();			
			$('#error').html("Por favor digite el numero de documento"); 
		}
	});	
	
	$("#arriendo_nuevo").click(function(event){
		$.fn.damnificado('arriendo');
	});
	
	$("#entregas_nuevo").click(function(event){
		$.fn.damnificado('entregas');
	});
	
	$("#reparacion_nueva").click(function(event){
		$.fn.damnificado('reparacion');
	});
	
	$("#eliminar_arrendador").click(function(event){
		if(confirm('Desea quitar el arrendador!')){
			$('#id_arrendador_arriendo').cargarInput(0);
			$.fn.arriendo('guardar');
			$('#form_arrendador').hide();
			$('#form_cambiar_arrendador').show();
		}
	});
	
	$("#arrendador_nuevo").click(function(event){
		$.fn.cambiar_arrendador('nuevo');
	});
	
	$("#eliminar_arriendo").click(function(event){
		if(confirm('Desea eliminar el arriendo de esta fase!'))
			$.fn.arriendo('eliminar');
	});
	
	$("#contrato").click(function(event){
		var id = $('#id_damnificado').attr('value');
		var fase = $('#fase').attr('value');
		window.open('pdf/contrato.php?fase='+fase+'&id='+id,'contrato');
	});
	
	$("#egreso").click(function(event){
		var id = $('#id_damnificado').attr('value');
		var fase = $('#fase').attr('value');
		window.open('pdf/egreso.php?fase='+fase+'&id='+id,'egreso');
	});
	
	$("#eliminar_reparacion").click(function(event){
		if(confirm('Desea eliminar la reparacion de vivienda de esta fase!'))
			$.fn.reparacion('eliminar');
	});
	
	$("#eliminar_entregas").click(function(event){
		if(confirm('Desea eliminar las entregas de esta fase!'))
			$.fn.entregas('eliminar');
	});
	
	$("#entregar_todo").click(function(event){
		$.fn.entregas('todo');
	});
	
	$("#hoja_ayuda").click(function(event){
		var id = $('#id_damnificado').attr('value');		
		var fase = $('#fase').attr('value');
		window.open('pdf/hojaAyuda.php?fase='+fase+'&id='+id,'hojaAyuda');
	});
	
	//formularios	
	$("#form_buscar").submit(function(event){
		event.preventDefault();
		if($.fn.verificarFechas())
			$.fn.buscar();		
		else{
			if(confirm('Hay Fechas sin registrar, Desea continuar!'))
				$.fn.buscar();	
		}
	});	
		
	$("#form_damnificado").submit(function(event){		
		event.preventDefault();
		$.fn.damnificado('guardar');
	});	
	
	$("#form_damnificado input, #form_damnificado select, #form_damnificado textarea").change(function(event){
		$("#form_damnificado").submit();
	});		
	
	$("#form_arriendo").submit(function(event){
		event.preventDefault();
		$.fn.arriendo('guardar');
	});
	
	$("#form_arriendo input, #form_arriendo textarea").change(function(event){
		$("#form_arriendo").submit();
	});
	
	$("#form_cambiar_arrendador").submit(function(event){
		event.preventDefault();
		$.fn.cambiar_arrendador('buscar');
	});	
	
	$("#form_arrendador").submit(function(event){
		event.preventDefault();
		$.fn.arrendador('guardar');
	});
	
	$("#form_arrendador input").change(function(event){
		$("#form_arrendador").submit();
	});
	
	$("#form_entregas").submit(function(event){
		event.preventDefault();
		$.fn.entregas('guardar');
	});
	
	$("#form_entregas input, #form_entregas textarea").change(function(event){
		$("#form_entregas").submit();
	});
	
	$("#form_reparacion").submit(function(event){
		event.preventDefault();
		$.fn.reparacion('guardar');
	});
	
	$("#form_reparacion input, #form_reparacion textarea").change(function(event){
		$("#form_reparacion").submit();
	});	
	
	//cargar damnificado
	$(".cargar_damnificado").live('click', function(event){
		if($('#tabla tr').length == 1)
			$("#input_buscar").attr('value', '');
		else	
			$("#resultados").slideUp(400);
		$('#id_damnificado').attr('value', $(this).attr('id'))
		$.fn.damnificado('cargar');	
	});			
	
	//readonly
	$("input[readonly], textarea[readonly]").live('keydown', function(event){
		if(event.keyCode==8){
			event.preventDefault();
		}
	});
	
	$("input[readonly]").live('focus', function(event){
		$(".ui-datepicker").hide();		
	});	
		
	//keydown
	$(document).not("input[readonly]").keydown(function (event) {		
		if(event.keyCode==8){			
			if(!$('input').is (':focus') && !$('textarea').is (':focus'))
				event.preventDefault();			
		}
	});	
	
	$("#cargando").delay(400).slideUp(0);
});