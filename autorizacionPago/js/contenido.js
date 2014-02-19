(function($){
    $.fn.mostrar=function(mostrar, overlay){
		$("#lista_ap").hide();		
		switch(mostrar){			
			case 'cambiar': $("#form_cambiar").show();
							$("#overlay_cambiar").show();
							break;
			case 'lista_ap':	$('#tabla').empty();
								$("form").hide();								
								$("#lista_ap").show();
								break;
			default:	$('#tabla').empty();		
						if(overlay == true && ($('#form_ap').is (':visible'))){				
							overlay = true;
							var form = new Array();							
							form[0] = 'ap';
							if($('#form_item_ap').is (':visible'))
								form[1] = 'item_ap';								
						}
						else
							overlay = false;	
							
						$("form").hide();
						$("#overlay_cambiar").hide();								
						if(overlay){
							for (i in form){
								$("#form_"+form[i]).show();
							}							
							$("#overlay").show();			
						}
						else
							$("#overlay").hide();		
							
						$("#form_"+mostrar).show();
						break;					
		}
		$("#form_buscar").show();
    }
})(jQuery);

(function($){
    $.fn.ocultar=function(ocultar, overlay){
		switch(ocultar){
			case 'cambiar':	$("#form_cambiar").hide();
							$("#overlay_cambiar").hide();
							break;
			case 'lista_ap':	$("#lista_ap").hide();
								break;	
			default:	$('#tabla').empty();
						if(overlay == true && $('#form_ap').is (':visible')){							
							$("#overlay").show();
							
							if(ocultar == 'municipio'){
								$("#overlay").hide();
							}
						}
						else	
							$("#overlay").hide();
							
						$("#form_"+ocultar).hide();	
						break;			
		}
    }
})(jQuery);

(function($){
    $.fn.lista=function(nombre, form, lista, seleccionar){
		$('#cargando').show();			
		var id_select = nombre+'_'+form;
		$('#'+id_select).empty();	
			
		var ruta =	'php/'+nombre+'.php';		
		var id = 'id_'+nombre;	
		
		$.getJSON(ruta, {id:'', opc:'lista', id_lista:lista}, function(respuesta) {						
			if(respuesta.login){				
				$('#'+id_select).append('<option value="0" selected >Seleccionar</option>');
						
				if(respuesta.consulta){	
					for(var i=0; i<respuesta.id.length; i++){
						$('#'+id_select).append('<option value="'+respuesta.id[i]+'" >'+respuesta.nombre[i]+'</option>');
					}
					
					if(seleccionar != ''){
						$('#'+nombre+'_'+form).cargar_select(seleccionar);
					}
				}															
			}									
			else				
				$(location).attr('href', 'index.php');
			$('#cargando').delay(400).slideUp(1);	
		})
		.error(function() { 	
			$('#cargando').delay(400).slideUp(1); 	
			$('#error').html('Error: Compruebe la conexion de red de su equipo! - lista');		
		});	
    }
})(jQuery);	

(function($){	
    $.fn.obligatorio=function(form){		
		if($(this).attr('value') != '' && $(this).attr('value') != '0'){
			$('#error_'+form).html('');	
			$(this).removeClass('error_input');		
			return true;
		}
		else{
			$('#error_'+form).html('* Campo obligatorio: '+$(this).attr('label'));
			$('#error_'+form).css('color', '#d14836');			
			$(this).addClass('error_input');	
			$(this).focus();
			return false;
		}
    }
})(jQuery);

(function($){
	$.fn.correo=function(form){	
		if(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/.test($(this).val())){
			$('#error_'+form).html('');	
			$(this).removeClass('error_input');	
			return true;
		}
		else{
			$('#error_'+form).html('* Valor invalido: '+$(this).attr('label'));
			$('#error_'+form).css('color', '#d14836');			
			$(this).addClass('error_input');	
			$(this).focus();
			return false;
		}
	}
})(jQuery);

(function($){	
    $.fn.porcentaje=function(form){	
		var porcentaje = $(this).attr('value');
		porcentaje = porcentaje.replace(/[%]/gi,'');	 
		if(!isNaN(porcentaje)){
			$('#error_'+form).html('');	
			$(this).removeClass('error_input');		
			return true;
		}
		else{
			$('#error_'+form).html('* Valor Incorrecto: '+$(this).attr('label'));
			$('#error_'+form).css('color', '#d14836');			
			$(this).addClass('error_input');	
			$(this).focus();
			return false;
		}
    }
})(jQuery);

(function($){	
    $.fn.reteica=function(form){	
		var reteica, array, numero1, numero2, error = false;
		reteica = $(this).attr('value');
		if(reteica != ''){
			array = reteica.split('*');	
			if(array.length == 2){
				numero1 = array[0];
				numero2 = array[1];
				if(!isNaN(numero1) && !isNaN(numero2)){
					$('#error_'+form).html('');	
					$(this).removeClass('error_input');		
					return true;
				}
				else
					error = true;
			}
			else
				error = true;
			
			if(error){
				$('#error_'+form).html('* Valor Incorrecto: '+$(this).attr('label'));
				$('#error_'+form).css('color', '#d14836');			
				$(this).addClass('error_input');	
				$(this).focus();
				return false;
			}
		}
		else
			return true;
    }
})(jQuery);

(function($){	
    $.fn.cargar_select=function(valor){
		$(this).find('option[value="'+valor+'"]').attr('selected', 'selected');
	}
})(jQuery);

(function($){	
    $.fn.cargar_input=function(valor){	
		$(this).attr('value', valor);
    }
})(jQuery);

(function($){	
    $.fn.limpiar=function(form){
		$('#form_'+form).find('.error_input').removeClass('error_input');			
		$('#guardar_'+form).hide();		
		$('#eliminar_'+form).hide();
		$('#error_'+form).html('');	
	}
})(jQuery);

(function($){	
    $.fn.fecha=function(form){	
		$('#cargando').show();	
		$.getJSON('php/fecha.php', function(respuesta){	
			if(respuesta.login){
				$('#fecha_'+form).attr('value', respuesta.fecha);
				if(respuesta.administrador)
					$('#municipio_'+form).removeAttr('disabled');
				else	
					$('#municipio_'+form).attr('disabled', true);
			}
			else				
				$(location).attr('href', 'index.php');		
			$('#cargando').delay(400).slideUp(1);	
		})
		.error(function() { 
			$('#cargando').delay(400).slideUp(1);			
			$('#error').html('Error: Compruebe la conexion de red de su equipo! - fecha'); 
		});	
    }
})(jQuery);

(function($){
    $.fn.subtotal=function(){
		var valor = 0, subtotal = 0, total, iva, reteiva, retefuente, reteica, valor_iva, valor_reteiva, valor_retefuente, valor_reteica, array;
		
		$('#tabla_item_ap tr').each(function (index) {
			valor = $(this).children('.valor').text();
			valor = valor.replace(/[$ .]/gi,'');
			subtotal = subtotal + parseInt(valor);						
		});	
		$('#number_format_ap').attr('value', subtotal).priceFormat();	
		$('#subtotal_ap').html($('#number_format_ap').attr('value'));
		
		iva = $('#iva_ap').attr('value');
		valor_iva = $('#valor_iva_ap').attr('value');
		reteiva = $('#retencion_iva_ap').attr('value');
		valor_reteiva = $('#valor_retencion_iva_ap').attr('value');
		retefuente = $('#retencion_fuente_ap').attr('value');
		valor_retefuente = $('#valor_retencion_fuente_ap').attr('value');
		reteica = $('#retencion_ica_ap').attr('value');
		valor_reteica = $('#valor_retencion_ica_ap').attr('value');
		
		if(iva != '0.0%'){	
			iva = iva.replace(/[%]/gi,'');
			valor_iva = subtotal * (iva / 100);
			$('#number_format_ap').attr('value', Math.round(valor_iva)).priceFormat();						
			$('#valor_iva_ap').attr('value', $('#number_format_ap').attr('value'));
		}
		else
			valor_iva = parseInt(valor_iva.replace(/[$ .]/gi,''));
		
		if(reteiva != '0.0%'){		
			reteiva = reteiva.replace(/[%]/gi,'');		
			valor_reteiva = valor_iva * (reteiva / 100);
			$('#number_format_ap').attr('value', Math.round(valor_reteiva)).priceFormat();	
			$('#valor_retencion_iva_ap').attr('value', $('#number_format_ap').attr('value'));
		}
		else
			valor_reteiva = parseInt(valor_reteiva.replace(/[$ .]/gi,''));
		
		if(retefuente != '0.0%'){
			retefuente = retefuente.replace(/[%]/gi,'');
			valor_retefuente = subtotal * (retefuente/100)
			$('#number_format_ap').attr('value', Math.round(valor_retefuente)).priceFormat();	
			$('#valor_retencion_fuente_ap').attr('value', $('#number_format_ap').attr('value'));
		}
		else
			valor_retefuente = parseInt(valor_retefuente.replace(/[$ .]/gi,''));
		
		if(reteica != ''){
			array = reteica.split('*');			
			if(array.length == 2){
				valor_reteica = (array[0] / array[1]) * subtotal;
				$('#number_format_ap').attr('value', Math.round(valor_reteica)).priceFormat();	
				$('#valor_retencion_ica_ap').attr('value', $('#number_format_ap').attr('value'));
			}
			else
				valor_reteica = 0;
		}
		else{
			if(valor_reteica == '')
				valor_reteica = 0;
			else
				valor_reteica = parseInt(valor_reteica.replace(/[$ .]/gi,''));	
		}
		
		if($('#sumar_iva').is(':checked'))
			total = (subtotal + (valor_iva - valor_reteiva) - (valor_retefuente + valor_reteica));
		else		
			total = (subtotal - (valor_retefuente + valor_reteica));
				
		$('#number_format_ap').attr('value', Math.round(total)).priceFormat();				
		$('#total_ap').html($('#number_format_ap').attr('value'));
    }
})(jQuery);

//Formulario Programa
(function($){	
    $.fn.limpiar_programa=function(){
		$('#id_programa').attr('value', '');
		$('#nombre_programa').attr('value', '');
		$('#descripcion_programa').attr('value', '');
		$('#nombre_programa').focus();	
		$('#municipio_programa').cargar_select(0);
		$.fn.limpiar('programa');	
	}
})(jQuery);	

(function($){	
    $.fn.cargar_programa=function(respuesta){
		if(respuesta == ''){
			$.fn.limpiar_programa();
			$('#guardar_programa').hide();			
			$('#eliminar_programa').hide();
		}
		else{				
			$('#id_programa').cargar_input(respuesta.id[0]);
			$('#nombre_programa').cargar_input(respuesta.nombre[0]);				
			$('#descripcion_programa').cargar_input(respuesta.descripcion[0]);				
			$('#municipio_programa').cargar_select(respuesta.idMunicipio[0]);
			$('#guardar_programa').show();						
			if(respuesta.administrador)
				$('#eliminar_programa').show();			
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_programas=function(respuesta){
		$('#tabla').empty();		
		$('#tabla').append('<thead><tr id="cabecera"><th width="5%">No.</th><th width="35%">Programa</th><th width="30%">Municipio</th><th width="30%">Departamento</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_programa">'+respuesta.nombre[i]+'</a></td><td class="municipio">'+respuesta.municipio[i]+'</td><td class="departamento">'+respuesta.departamento[i]+'</td></tr>');		
		}											
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.programa=function(opc){			
		if(opc == 'todos' || (opc == 'buscar' && ($('#id_programa').obligatorio('programa') || $('#nombre_programa').obligatorio('programa'))) || (opc == 'eliminar' && $('#id_programa').obligatorio('programa')) || opc == 'ap' || ($('#nombre_programa').obligatorio('programa') && $('#municipio_programa').obligatorio('programa'))){					
			$('#cargando').show();
			$('#opc_programa').attr('value', opc);
			if(opc != 'buscar')		
				$('#'+opc+'_programa').css('visibility', 'hidden');										
			var datos = $('#form_programa').serialize();			
			$.getJSON('php/programa.php', datos, function(respuesta) {																	
				if(respuesta.login){					
					if(respuesta.consulta){
						switch(respuesta.opc){
							case 'ap': 	$('#id_municipio_ap').attr('value', respuesta.idMunicipio[0]);
										$('#nombre_municipio_ap').attr('value', respuesta.municipio[0]);
										$('#municipio_ap').cargar_select(respuesta.idMunicipio[0]);										
										break;
							case 'buscar':  $.fn.cargar_programa(respuesta);
											$('#error_programa').html('Programa cargado correctamente');										
											break;
							case 'eliminar':$.fn.cargar_programa('');																		
											$('#error_programa').html('Programa eliminado correctamente');	
											$.fn.lista('programa', 'usuario', '', '');
											$.fn.lista('programa', 'responsable', '', '');
											if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla').tablesorter({widgets: ['zebra']});										
											break;		
							case 'guardar':	$.fn.cargar_programa(respuesta);							
											$('#error_programa').html('Programa guardado correctamente');
											$.fn.lista('programa', 'usuario', '', '');
											$.fn.lista('programa', 'responsable', '', '');
											if($('#'+respuesta.id).length){				
												$('#'+respuesta.id+' > td > a.cargar_programa').text(respuesta.nombre[0]);
												$('#'+respuesta.id+' > td.municipio').html(respuesta.municipio[0]);	
												$('#'+respuesta.id+' > td.departamento').html(respuesta.departamento[0]);
											}	
											else{
												$('#body_tabla').append('<tr id="'+respuesta.id[0]+'"><td>1</td><td><a href="#" class="cargar_programa">'+respuesta.nombre[0]+'</a></td><td class="municipio">'+respuesta.municipio[0]+'</td><td class="departamento">'+respuesta.departamento[0]+'</td></tr>');
												$('#tabla').tablesorter({widgets: ['zebra']});
											}
											break;									
							case 'todos':	$('#error_programa').html('Programas Registrados');
											$.fn.cargar_todos_programas(respuesta);																																			
											break;	
						}						
						$('#error_programa').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'ap': 	$('#id_municipio_ap').attr('value', '');
										$('#nombre_municipio_ap').attr('value', '');										
										break;
							case 'buscar':  $('#error_programa').html('No existe un programa con ese nombre');
											$('#guardar_programa').show();
											break;
							case 'eliminar':$('#error_programa').html('Error no se puede eliminar el programa');
											break;		
							case 'guardar':	$('#error_programa').html('Error al guardar la informacion, el programa ya existe');
											if($('#id_programa').attr('value') != '')
												$.fn.cargar_programa(respuesta);
											break;
							case 'todos':	$('#error_programa').html('No existe un programa con ese nombre');	
											$('#body_tabla').empty();
											break;						
						}
						$('#error_programa').css('color', '#d14836');				
					}	
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_programa').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_programa').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - programa'); 
			});							
		}
	}
})(jQuery);

//Formulario Departamento
(function($){	
    $.fn.limpiar_departamento=function(){
		$('#id_departamento').attr('value', '');
		$('#nombre_departamento').attr('value', '');
		$('#nombre_departamento').focus();
		$.fn.limpiar('departamento');	
	}
})(jQuery);

(function($){	
    $.fn.cargar_departamento=function(respuesta){
		if(respuesta == ''){
			$.fn.limpiar_departamento();
			$('#guardar_departamento').hide();			
			$('#eliminar_departamento').hide();
		}
		else{
			$('#id_departamento').cargar_input(respuesta.id[0]);
			$('#nombre_departamento').cargar_input(respuesta.nombre[0]);
			$('#guardar_departamento').show();			
			if(respuesta.administrador)
				$('#eliminar_departamento').show();	
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_departamentos=function(respuesta){
		$('#tabla').empty();		
		$('#tabla').append('<thead><tr id="cabecera"><th width="10%">No.</th><th width="90%">Departamento</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_departamento">'+respuesta.nombre[i]+'</a></td></tr>');		
		}											
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.departamento=function(opc){			
		if(opc == 'todos' || (opc == 'buscar' && ($('#id_departamento').obligatorio('departamento') || $('#nombre_departamento').obligatorio('departamento'))) || (opc == 'eliminar' && $('#id_departamento').obligatorio('departamento')) || $('#nombre_departamento').obligatorio('departamento')){					
			$('#cargando').show();
			$('#opc_departamento').attr('value', opc);
			if(opc != 'buscar')	
				$('#'+opc+'_departamento').css('visibility', 'hidden');										
			var datos = $('#form_departamento').serialize();			
			$.getJSON('php/departamento.php', datos, function(respuesta) {	
				if(respuesta.login){															
					if(respuesta.consulta){
						switch(respuesta.opc){
							case 'buscar':  $.fn.cargar_departamento(respuesta);
											$('#error_departamento').html('Departamento cargado correctamente');										
											break;
							case 'eliminar':$.fn.cargar_departamento('');
											$('#error_departamento').html('Departamento eliminado correctamente');	
											$.fn.lista('departamento', 'cambiar', '', '');
											$.fn.lista('departamento', 'municipio', '', '');
											if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla').tablesorter({widgets: ['zebra']});									
											break;		
							case 'guardar':	$.fn.cargar_departamento(respuesta);
											$('#error_departamento').html('Departamento guardado correctamente');
											$.fn.lista('departamento', 'cambiar', '', '');
											$.fn.lista('departamento', 'municipio', '', '');										
											if($('#'+respuesta.id).length)				
												$('#'+respuesta.id+' > td > a.cargar_departamento').text(respuesta.nombre[0]);											else{
												$('#body_tabla').append('<tr id="'+respuesta.id[0]+'"><td>1</td><td><a href="#" class="cargar_departamento">'+respuesta.nombre[0]+'</a></td>');
												$('#tabla').tablesorter({widgets: ['zebra']});
											}
											break;									
							case 'todos':	$('#error_departamento').html('Departamentos Registrados');
											$.fn.cargar_todos_departamentos(respuesta);																																			
											break;											
						}						
						$('#error_departamento').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar':  $('#error_departamento').html('No existe un departamento con ese nombre');
											$('#guardar_departamento').show();
											break;
							case 'eliminar':$('#error_departamento').html('Error no se puede eliminar el departamento');
											break;		
							case 'guardar':	$('#error_departamento').html('Error al guardar la informacion, el departamento ya existe');
											if($('#id_departamento').attr('value') != '')
												$.fn.cargar_departamento(respuesta);
											break;
							case 'todos':	$('#error_departamento').html('No existe un departamento con ese nombre');	
											$('#body_tabla').empty();
											break;												
						}
						$('#error_departamento').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_departamento').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_departamento').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - departamento'); 
			});							
		}
	}
})(jQuery);

//Formulario Municipio
(function($){	
    $.fn.limpiar_municipio=function(){
		$('#id_municipio').attr('value', '');
		$('#nombre_municipio').attr('value', '');
		$('#nombre_municipio').focus();
		$('#departamento_municipio').cargar_select(0);
		$.fn.limpiar('municipio');
	}
})(jQuery);

(function($){	
    $.fn.cargar_municipio=function(respuesta){
		if(respuesta == ''){
			$.fn.limpiar_municipio();
			$('#guardar_municipio').hide();			
			$('#eliminar_municipio').hide();
		}
		else{
			$('#id_municipio').cargar_input(respuesta.id[0]);
			$('#nombre_municipio').cargar_input(respuesta.nombre[0]);	
			$('#departamento_municipio').cargar_select(respuesta.idDepartamento[0]);
			$('#guardar_municipio').show();			
			if(respuesta.administrador)
				$('#eliminar_municipio').show();
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_municipios=function(respuesta){
		$('#tabla').empty();		
		$('#tabla').append('<thead><tr id="cabecera"><th width="10%">No.</th><th width="60%">Municipio</th><th width="30%">Departamento</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_municipio">'+respuesta.nombre[i]+'</a></td><td class="departamento">'+respuesta.departamento[i]+'</td></tr>');		
		}											
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.municipio=function(opc){
		if(opc == 'todos' || (opc == 'buscar'  && ($('#id_municipio').obligatorio('municipio') || $('#nombre_municipio').obligatorio('municipio'))) || (opc == 'eliminar' && $('#id_municipio').obligatorio('municipio')) || ($('#nombre_municipio').obligatorio('municipio') && $('#departamento_municipio').obligatorio('municipio'))){				
			$('#cargando').show();
			$('#opc_municipio').attr('value', opc);
			if(opc != 'buscar')	
				$('#'+opc+'_municipio').css('visibility', 'hidden');										
			var datos = $('#form_municipio').serialize();			
			$.getJSON('php/municipio.php', datos, function(respuesta) {		
				if(respuesta.login){															
					if(respuesta.consulta){					
						switch(respuesta.opc){
							case 'buscar':  $.fn.cargar_municipio(respuesta);
											$('#error_municipio').html('Municipio cargado correctamente');
											break;
							case 'eliminar':$.fn.cargar_municipio('');
											$('#error_municipio').html('Municipio eliminado correctamente');
											$.fn.lista('municipio', 'programa', '', '');
											$.fn.lista('municipio', 'barrio', '', '');	
											$.fn.lista('municipio', 'usuario', '', '');
											$.fn.lista('municipio', 'responsable', '', '');	
											if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla').tablesorter({widgets: ['zebra']});									
											break;		
							case 'guardar':	$.fn.cargar_municipio(respuesta);
											$('#error_municipio').html('Municipio guardado correctamente');
											$.fn.lista('municipio', 'programa', '', '');
											$.fn.lista('municipio', 'barrio', '', '');	
											$.fn.lista('municipio', 'usuario', '', '');
											$.fn.lista('municipio', 'responsable', '', '');	
											if($('#'+respuesta.id).length){				
												$('#'+respuesta.id+' > td a.cargar_municipio').text(respuesta.nombre[0]);
												$('#'+respuesta.id+' > td.departamento').html(respuesta.departamento[0]);
											}	
											else{
												$('#body_tabla').append('<tr id="'+respuesta.id[0]+'"><td>1</td><td><a href="#" class="cargar_municipio">'+respuesta.nombre[0]+'</a></td><td class="departamento">'+respuesta.departamento[0]+'</td></tr>');
												$('#tabla').tablesorter({widgets: ['zebra']});
											}
											break;	
							case 'todos':	$('#error_municipio').html('Municipios Registrados');
											$.fn.cargar_todos_municipios(respuesta);																																			
											break;					
						}						
						$('#error_municipio').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar':  $('#error_municipio').html('No existe un municipio con ese nombre');
											$('#guardar_municipio').show();
											break;
							case 'eliminar':$('#error_municipio').html('Error no se puede eliminar el municipio');
											break;		
							case 'guardar':	$('#error_municipio').html('Error al guardar la informacion, el municipio ya existe');
											if($('#id_municipio').attr('value') != '')
												$.fn.cargar_municipio(respuesta);
											break;
							case 'todos':	$('#error_municipio').html('No existe un municipio con ese nombre');	
											$('#body_tabla').empty();
											break;						
						}
						$('#error_municipio').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_municipio').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_municipio').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - municipio'); 
			});							
		}
	}
})(jQuery);	

//Formulario Barrio
(function($){	
    $.fn.limpiar_barrio=function(){
		$('#id_barrio').attr('value', '');
		$('#nombre_barrio').attr('value', '');
		$('#nombre_barrio').focus();		
		$('#municipio_barrio').cargar_select(0);
		$.fn.limpiar('barrio');	
	}
})(jQuery);

(function($){	
    $.fn.cargar_barrio=function(respuesta){
		if(respuesta == ''){
			$.fn.limpiar_barrio();	
			$('#guardar_barrio').hide();					
			$('#eliminar_barrio').hide();
		}
		else{
			$('#id_barrio').cargar_input(respuesta.id[0]);
			$('#nombre_barrio').cargar_input(respuesta.nombre[0]);
			$('#municipio_barrio').cargar_select(respuesta.idMunicipio[0]);
			$('#guardar_barrio').show();			
			if(respuesta.administrador)
				$('#eliminar_barrio').show();
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_barrios=function(respuesta){
		$('#tabla').empty();		
		$('#tabla').append('<thead><tr id="cabecera"><th width="5%">No.</th><th width="35%">Barrio</th><th width="30%">Municipio</th><th width="30%">Departamento</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_barrio">'+respuesta.nombre[i]+'</a></td><td class="municipio">'+respuesta.municipio[i]+'</td><td class="departamento">'+respuesta.departamento[i]+'</td></tr>');		
		}											
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.barrio=function(opc){		
		if(opc == 'todos' || (opc == 'buscar' && ($('#id_barrio').obligatorio('barrio') || $('#nombre_barrio').obligatorio('barrio'))) || (opc == 'eliminar' && $('#id_barrio').obligatorio('barrio')) || ($('#nombre_barrio').obligatorio('barrio') && $('#municipio_barrio').obligatorio('barrio'))){				
			$('#cargando').show();
			$('#opc_barrio').attr('value', opc);
			if(opc != 'buscar')	
				$('#'+opc+'_barrio').css('visibility', 'hidden');										
			var datos = $('#form_barrio').serialize();			
			$.getJSON('php/barrio.php', datos, function(respuesta) {
				if(respuesta.login){																	
					if(respuesta.consulta){										
						switch(respuesta.opc){
							case 'buscar':  $.fn.cargar_barrio(respuesta);
											$('#error_barrio').html('Barrio cargado correctamente');
											break;
							case 'eliminar':$.fn.cargar_barrio('');
											$('#error_barrio').html('Barrio eliminado correctamente');
											if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla').tablesorter({widgets: ['zebra']});	
											break;		
							case 'guardar':	$.fn.cargar_barrio(respuesta);
											$('#error_barrio').html('Barrio guardado correctamente');
											if($('#'+respuesta.id).length){				
												$('#'+respuesta.id+' > td a.cargar_barrio').text(respuesta.nombre[0]);
												$('#'+respuesta.id+' > td.municipio').html(respuesta.municipio[0]);	
												$('#'+respuesta.id+' > td.departamento').html(respuesta.departamento[0]);
											}	
											else{
												$('#body_tabla').append('<tr id="'+respuesta.id[0]+'"><td>1</td><td><a href="#" class="cargar_barrio">'+respuesta.nombre[0]+'</a></td><td class="municipio">'+respuesta.municipio[0]+'</td><td class="departamento">'+respuesta.departamento[0]+'</td></tr>');
												$('#tabla').tablesorter({widgets: ['zebra']});
											}
											break;
							case 'todos':	$('#error_barrio').html('Barrios Registrados');
											$.fn.cargar_todos_barrios(respuesta);																										
											break;						
						}						
						$('#error_barrio').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar':  $('#error_barrio').html('No existe un barrio con ese nombre');
											$('#guardar_barrio').show();
											break;
							case 'eliminar':$('#error_barrio').html('Error no se puede eliminar el barrio');
											break;		
							case 'guardar':	$('#error_barrio').html('Error al guardar la informacion, el barrio ya existe');
											if($('#id_barrio').attr('value') != '')
												$.fn.cargar_barrio(respuesta);
											break;
							case 'todos':	$('#error_barrio').html('No existe un barrio con ese nombre');	
											$('#body_tabla').empty();
											break;							
						}
						$('#error_barrio').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_barrio').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_barrio').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - barrio'); 
			});							
		}
	}
})(jQuery);	

//Formulario Persona
(function($){	
    $.fn.limpiar_persona=function(){
		$('#form_persona').find('.error_input').removeClass('error_input');	
		$('#id_persona').attr('value', '');
		$('#nombre_persona').attr('value', '');
		$('#nombre_persona').focus();
		$('#identificacion_persona').attr('value', '');		
		$('#telefono_persona').attr('value', '');
		$('#celular_persona').attr('value', '');
		$('#email_persona').attr('value', '');		
		$('#direccion_persona').attr('value', '');	
		$.fn.lista('barrio', 'persona', $('#id_municipio_user').attr('value'), 0);
		$.fn.limpiar('persona');	
	}
})(jQuery);

(function($){	
    $.fn.cargar_persona=function(respuesta){
		if(respuesta == ''){
			$.fn.limpiar_persona();	
			$('#guardar_persona').hide();					
			$('#eliminar_persona').hide();
		}
		else{			
			$('#id_persona').cargar_input(respuesta.id[0]);			
			$('#nombre_persona').cargar_input(respuesta.nombre[0]);			
			$('#identificacion_persona').cargar_input(respuesta.identificacion[0]);
			$('#telefono_persona').cargar_input(respuesta.telefono[0]);		
			$('#celular_persona').cargar_input(respuesta.celular[0]);		
			$('#email_persona').cargar_input(respuesta.email[0]);
			$('#direccion_persona').cargar_input(respuesta.direccion[0]);
			$.fn.lista('barrio', 'persona', respuesta.idMunicipio[0], respuesta.idBarrio[0]);									
			$('#guardar_persona').show();			
			if(respuesta.administrador)
				$('#eliminar_persona').show();
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_personas=function(respuesta){
		$('#tabla').empty();		
		$('#tabla').append('<thead><tr id="cabecera"><th width="10%">No.</th><th width="60%">Nombre</th><th width="30%">Identificacion</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_persona">'+respuesta.nombre[i]+'</a></td><td class="identificacion">'+respuesta.identificacion[i]+'</td></tr>');		
		}											
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.persona=function(opc){
		if(opc == 'todos' || (opc == 'buscar' && ($('#id_persona').obligatorio('persona') || $('#nombre_persona').obligatorio('persona') || $('#identificacion_persona').obligatorio('persona'))) || (opc == 'eliminar' && $('#id_persona').obligatorio('persona')) || ($('#nombre_persona').obligatorio('persona') && $('#identificacion_persona').obligatorio('persona') && ($('#email_persona').attr('value') == '' || $('#email_persona').correo('persona')))){				
			$('#cargando').show();
			$('#opc_persona').attr('value', opc);
			if(opc != 'buscar')	
				$('#'+opc+'_persona').css('visibility', 'hidden');										
			var datos = $('#form_persona').serialize();			
			$.getJSON('php/persona.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){										
						switch(respuesta.opc){
							case 'buscar':  $.fn.cargar_persona(respuesta);
											$('#error_persona').html('Persona cargada correctamente');
											break;
							case 'eliminar':$.fn.cargar_persona('');
											$('#error_persona').html('Persona eliminada correctamente');
											if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla').tablesorter({widgets: ['zebra']});	
											break;		
							case 'guardar':	$.fn.cargar_persona(respuesta);
											$('#error_persona').html('Persona guardada correctamente');
											if($('#'+respuesta.id).length){				
												$('#'+respuesta.id+' > td a.cargar_persona').text(respuesta.nombre[0]);
												$('#'+respuesta.id+' > td.identificacion').html(respuesta.identificacion[0]);
											}	
											else{
												$('#body_tabla').append('<tr id="'+respuesta.id[0]+'"><td>1</td><td><a href="#" class="cargar_persona">'+respuesta.nombre[0]+'</a></td><td class="identificacion">'+respuesta.identificacion[0]+'</td></tr>');
												$('#tabla').tablesorter({widgets: ['zebra']});
											}
											break;
							case 'todos':	$('#error_persona').html('Personas Registrados');
											$.fn.cargar_todos_personas(respuesta);																										
											break;						
						}						
						$('#error_persona').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar':  $('#error_persona').html('No existe una persona con ese nombre');
											$('#guardar_persona').show();
											break;
							case 'eliminar':$('#error_persona').html('Error no se puede eliminar la persona');
											break;		
							case 'guardar':	$('#error_persona').html('Error al guardar la informacion, numero de identificacion ya existe');
											if($('#id_persona').attr('value') != '')
												$.fn.cargar_persona(respuesta);
											break;
							case 'todos':	$('#error_persona').html('No existe una persona con ese nombre');
											$('#guardar_persona').show();	
											$('#body_tabla').empty();
											break;							
						}
						$('#error_persona').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_persona').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_persona').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - persona'); 
			});							
		}
	}
})(jQuery);	

//Formulario Usuario
(function($){	
    $.fn.limpiar_usuario=function(){
		$('#nombre_usuario').removeAttr('disabled');
		$('#id_usuario').attr('value', '');		
		$('#nombre_usuario').attr('value', '');
		$('#nombre_usuario').focus();
		$('#usuario').attr('value', '');
		$('#perfil_usuario').cargar_select(0);
		$('#municipio_usuario').cargar_select(0);
		$('#programa_registrado_usuario').empty();
		$('#programa_usuario').cargar_select(0);
		$.fn.limpiar('usuario');		
	}
})(jQuery);

(function($){	
    $.fn.cargar_usuario=function(respuesta){
		if(respuesta == ''){	
			$.fn.limpiar_usuario();			
			$('#guardar_usuario').hide();				
			$('#eliminar_usuario').hide();
		}
		else{					
			$('#id_usuario').cargar_input(respuesta.id[0]);			
			$('#nombre_usuario').cargar_input(respuesta.nombre[0]);
			$('#nombre_usuario').attr('disabled', true);			
			$('#usuario').cargar_input(respuesta.user[0]);				
			$('#perfil_usuario').cargar_select(respuesta.idPerfil[0]);
			$('#municipio_usuario').cargar_select(respuesta.idMunicipio[0]);
			$('#programa_registrado_usuario').empty();
			$('#programa_registrado_usuario').append('<option value="0" selected >Seleccionar</option>');
			if(respuesta.programa[0]){
				for(var i=0; i<respuesta.programas[0].id.length; i++){
					$('#programa_registrado_usuario').append('<option value="'+respuesta.programas[0].id[i]+'" >'+respuesta.programas[0].nombre[i]+'</option>');
				}
			}
			$('#programa_usuario').cargar_select(0);
			
			if(!respuesta.bloquear[0]){			
				$('#guardar_usuario').show();			
				$('#eliminar_usuario').show();			
			}
			else{
				$('#guardar_usuario').hide();			
				$('#eliminar_usuario').hide();	
			}
			$('#modificar_persona_usuario').focus();		
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_usuarios=function(respuesta){
		$('#tabla').empty();			
		$('#tabla').append('<thead><tr id="cabecera"><th width="5%">No.</th><th width="35%">Nombre</th><th width="30%">Identificacion</th><th width="30%">Usuario</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_usuario">'+respuesta.nombre[i]+'</a></td><td class="identificacion">'+respuesta.identificacion[i]+'</td><td class="usuario">'+respuesta.user[i]+'</td></tr>');		
		}					
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.usuario=function(opc){			
		if(opc == 'todos' || opc == 'guardar_prog' || opc == 'eliminar_prog' || (opc == 'buscar' && ($('#id_usuario').obligatorio('usuario') || $('#nombre_usuario').obligatorio('usuario'))) || (opc == 'eliminar' && $('#id_usuario').obligatorio('usuario')) || ($('#id_usuario').obligatorio('usuario') && $('#usuario').obligatorio('usuario') && $('#perfil_usuario').obligatorio('usuario'))){									
			$('#cargando').show();			
			$('#opc_usuario').attr('value', opc);
			if(opc != 'buscar')	
				$('#'+opc+'_usuario').css('visibility', 'hidden');										
			var datos = $('#form_usuario').serialize();	
			$.getJSON('php/usuario.php', datos, function(respuesta) {				
				if(respuesta.login){		
					if(respuesta.consulta){										
						switch(respuesta.opc){
							case 'buscar':  $.fn.cargar_usuario(respuesta);
											$('#error_usuario').html('Usuario cargado correctamente');
											break;
							case 'eliminar':$.fn.cargar_usuario('');
											$('#error_usuario').html('Usuario eliminado correctamente');
											if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla').tablesorter({widgets: ['zebra']});	
											break;
							case 'eliminar_prog':	$.fn.cargar_usuario(respuesta);
													$('#error_usuario').html('Programa eliminado correctamente');
													break;							
							case 'guardar':	$.fn.cargar_usuario(respuesta);										
											$('#error_usuario').html('Usuario guardado correctamente');												
											if($('#'+respuesta.id).length){				
												$('#'+respuesta.id+' > td a.cargar_usuario').text(respuesta.nombre[0]);
												$('#'+respuesta.id+' > td.identificacion').html(respuesta.identificacion[0]);
												$('#'+respuesta.id+' > td.usuario').html(respuesta.user[0]);
											}	
											else{
												$('#body_tabla').append('<tr id="'+respuesta.id[0]+'"><td>1</td><td><a href="#" class="cargar_usuario">'+respuesta.nombre[0]+'</a></td><td class="identificacion">'+respuesta.identificacion[0]+'</td><td class="usuario">'+respuesta.user[0]+'</td></tr>');
												$('#tabla').tablesorter({widgets: ['zebra']});
											}
											break;
							case 'guardar_prog':$.fn.cargar_usuario(respuesta);
												$('#error_usuario').html('Programa guardado correctamente');
												break;					
							case 'todos':	$('#error_usuario').html('Usuarios Registrados');
											$.fn.cargar_todos_usuarios(respuesta);																										
											break;						
						}						
						$('#error_usuario').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar':  $('#error_usuario').html('No existe una persona con ese nombre');
											break;
							case 'eliminar':$('#error_usuario').html('Error no se puede eliminar el usuario');
											break;
							case 'eliminar_prog':	$('#error_usuario').html('Error no se puede eliminar el programa');
													break;							
							case 'guardar':	$('#error_usuario').html('Error al guardar la informacion, el usuario ya existe');
											if($('#id_usuario').attr('value') != '' && !respuesta.nuevo)
												$.fn.cargar_usuario(respuesta);
											break;
							case 'guardar_prog':$('#error_usuario').html('Error al guardar el programa');
												break;					
							case 'todos':	$('#error_usuario').html('No existe una persona con ese nombre');	
											$('#body_tabla').empty();
											break;							
						}
						$('#error_usuario').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_usuario').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_usuario').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - usuario'); 
			});							
		}
	}
})(jQuery);

//Formulario Passwd
(function($){	
    $.fn.limpiar_passwd=function(){
		$('#passwd_actual').attr('value', '');		
		$('#passwd_nuevo').attr('value', '');
	}
})(jQuery);

(function($){	
    $.fn.passwd=function(opc){			
		if($('#email_user').correo('passwd') && $('#passwd_actual').obligatorio('passwd') && $('#passwd_nuevo').obligatorio('passwd')){	
			$('#cargando').show();
			$('#opc_passwd').attr('value', opc);
			$('#cambiar_passwd').css('visibility', 'hidden');													
			var datos = $('#form_passwd').serialize();			
			$.getJSON('php/usuario.php', datos, function(respuesta) {	
				if(respuesta.login){															
					if(respuesta.consulta){
						$('#error_passwd').html('Contraseña cambiada correctamente');
						$.fn.limpiar_passwd();
						$('#error_passwd').css('color', '#15c');
					}
					else{	
						$('#error_passwd').html('Error no se cambio la contraseña');
						$('#passwd_actual').focus();
						$('#error_passwd').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#cambiar_passwd').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#cambiar_passwd').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - passwd'); 
			});	
		}
	}
})(jQuery);	

//Formulario Responsable
(function($){	
    $.fn.limpiar_responsable=function(){
		$('#nombre_responsable').removeAttr('disabled');
		$('#id_responsable').attr('value', '');
		$('#nombre_responsable').attr('value', '');
		$('#nombre_responsable').focus();
		$('#programa_registrado_responsable').empty();
		$('#programa_responsable').cargar_select(0);		
		$.fn.limpiar('responsable');
		$('#modificar_persona_responsable').show();	
	}
})(jQuery);

(function($){	
    $.fn.cargar_responsable=function(respuesta){
		if(respuesta == ''){
			$.fn.limpiar_responsable();	
			$('#guardar_responsable').hide();
			$('#eliminar_responsable').hide();
		}
		else{			
			$('#id_responsable').cargar_input(respuesta.id[0]);		
			$('#nombre_responsable').cargar_input(respuesta.nombre[0]);	
			$('#nombre_responsable').attr('disabled', true);
			$('#programa_registrado_responsable').empty();
			$('#programa_registrado_responsable').append('<option value="0" selected >Seleccionar</option>');
			if(respuesta.programa[0]){
				for(var i=0; i<respuesta.programas[0].id.length; i++){
					$('#programa_registrado_responsable').append('<option value="'+respuesta.programas[0].id[i]+'" >'+respuesta.programas[0].nombre[i]+'</option>');
				}
			}
			$('#programa_responsable').cargar_select(0);
			$('#guardar_responsable').show();
			$('#modificar_persona_responsable').focus();
			$('#eliminar_responsable').show();
		}
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_responsables=function(respuesta){
		$('#tabla').empty();		
		$('#tabla').append('<thead><tr id="cabecera"><th width="10%">No.</th><th width="60%">Nombre</th><th width="30%">Identificacion</th></tr></thead>');				
		$('#tabla').append('<tbody id="body_tabla"></tbody>');	
		for(var i=0; i<respuesta.id.length; i++){
			$('#body_tabla').append('<tr id="'+respuesta.id[i]+'"><td>'+(i+1)+'</td><td><a href="#" class="cargar_responsable">'+respuesta.nombre[i]+'</a></td><td class="identificacion">'+respuesta.identificacion[i]+'</td></tr>');		
		}											
		$('#tabla').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.responsable=function(opc){	
		if(opc == 'todos' || (opc == 'buscar' && ($('#id_responsable').obligatorio('responsable') || $('#nombre_responsable').obligatorio('responsable'))) || (opc == 'eliminar' && $('#id_responsable').obligatorio('responsable')) || ($('#id_responsable').obligatorio('responsable') && $('#programa_responsable').obligatorio('responsable'))){				
			$('#cargando').show();
			$('#opc_responsable').attr('value', opc);
			if(opc != 'buscar')	
				$('#'+opc+'_responsable').css('visibility', 'hidden');										
			var datos = $('#form_responsable').serialize();			
			$.getJSON('php/responsable.php', datos, function(respuesta) {
				if(respuesta.login){																	
					if(respuesta.consulta){										
						switch(respuesta.opc){
							case 'buscar':  $.fn.cargar_responsable(respuesta);
											$('#error_responsable').html('Responsable cargado correctamente');											
											break;
							case 'eliminar':$.fn.cargar_responsable(respuesta);
											$('#error_responsable').html('Programa eliminado correctamente');
											break;		
							case 'guardar':	$.fn.cargar_responsable(respuesta);											
											$('#error_responsable').html('Programa guardado correctamente');
											break;
							case 'todos':	$('#error_responsable').html('Responsables Registrados');
											$.fn.cargar_todos_responsables(respuesta);																										
											break;						
						}						
						$('#error_responsable').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar':  $('#error_responsable').html('No existe una persona con ese nombre');												
											break;
							case 'eliminar':$('#error_responsable').html('Error no se puede eliminar el programa');
											break;		
							case 'guardar':	$('#error_responsable').html('Error al guardar el programa');
											break;
							case 'todos':	$('#error_responsable').html('No existe una persona con ese nombre');	
											$('#body_tabla').empty();
											break;							
						}
						$('#error_responsable').css('color', '#d14836');				
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#'+opc+'_responsable').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#'+opc+'_responsable').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - responsable'); 
			});							
		}
	}
})(jQuery);	

//Formulario AP
(function($){	
    $.fn.limpiar_ap=function(){
		$('#informacion_ap').hide();
		$('#cambiar_consecutivo_ap').hide();
		$('#ver_ap').hide();	
		$('#desbloquear_ap').hide();	
		$('#form_item_ap').hide();
		$('#id_ap').attr('value', '');		
			
		$('#programa_ap').cargar_select(0);
		$('#programa_ap').removeAttr('disabled');
		$('#responsable_ap').empty();	
		$('#municipio_ap').cargar_select(0);
		$('#municipio_ap').attr('disabled', true);
		
		$('#id_programa_ap').attr('value', '');	
		$('#nombre_programa_ap').attr('value', '');	
		$('#id_responsable_ap').attr('value', '');	
		$('#nombre_responsable_ap').attr('value', '');	
		$('#id_municipio_ap').attr('value', '');	
		$('#nombre_municipio_ap').attr('value', '');	
		
		$('#consecutivo_ap').html('-');
		$('#fecha_ap').attr('value', '');		
		$('#id_cliente_ap').attr('value', '');
		$('#nombre_cliente_ap').attr('value', '');
		$('#identificacion_cliente_ap').attr('value', '');
		$('#concepto_ap').attr('value', '');
		$('#tipo_pago_ap_n').attr('checked', true);
		
		$('#banco_ap').attr('value', '');
		$('#tipo_cuenta_ap').cargar_select(0);
		$('#numero_cuenta_ap').attr('value', '');
		$('#estado_ap').cargar_select(0);
		//Pagos
		$('#tabla_item_ap').empty();
		$('#id_ap_item_ap').attr('value', '');
		$('#id_item_ap').attr('value', '');
		$('#numero_pago_ap').attr('value', '');
		$('#comprobante_egreso_ap').attr('value', '');
		$('#descripcion_pago_ap').attr('value', '');
		$('#centro_costo_ap').attr('value', '');
		$('#valor_pago_ap').attr('value', '');
		//Retenciones
		$('#sumar_iva').removeAttr('checked');
		$('#iva_ap').attr('value', '');
		$('#valor_iva_ap').attr('value', '');
		$('#retencion_iva_ap').attr('value', '');
		$('#valor_retencion_iva_ap').attr('value', '');
		$('#retencion_fuente_ap').attr('value', '');
		$('#valor_retencion_fuente_ap').attr('value', '');
		$('#retencion_ica_ap').attr('value', '');
		$('#valor_retencion_ica_ap').attr('value', '');
		$('#total_ap').html('');
		$('#form_item_ap table tfoot tr th').find('.error_input').removeClass('error_input');	
	}
})(jQuery);	

(function($){	
    $.fn.cargar_ap=function(respuesta){
		$('#id_ap').cargar_input(respuesta.id[0]);			
		if(respuesta.idCreador[0] == respuesta.idUser[0])				
			$('#informacion_ap').attr('title', 'Creado por: '+respuesta.nombreCreador[0]+' - Fecha: '+respuesta.fechaActualizacion[0]);
		else	
			$('#informacion_ap').attr('title', 'Creado por: '+respuesta.nombreCreador[0]+' - Modificado por: '+respuesta.nombreUsuario[0]+' - Fecha: '+respuesta.fechaActualizacion[0]);
		$('#ver_ap').attr('href', 'pdf/ap_pdf.php?id_ap='+respuesta.id[0]);
		
		$('#programa_ap').cargar_select(0);
		$('#programa_ap').attr('disabled', true);		
		$('#programa_ap').cargar_select(respuesta.idPrograma[0])
		$.fn.lista('responsable', 'ap', respuesta.idPrograma[0], respuesta.idResponsable[0]);
		$('#municipio_ap').cargar_select(respuesta.idMunicipio[0]);		
		
		$('#id_programa_ap').cargar_input(respuesta.idPrograma[0]);	
		$('#nombre_programa_ap').cargar_input(respuesta.nombrePrograma[0]);	
		$('#id_responsable_ap').cargar_input(respuesta.idResponsable[0]);	
		$('#nombre_responsable_ap').cargar_input(respuesta.nombreResponsable[0]);	
		$('#id_municipio_ap').cargar_input(respuesta.idMunicipio[0]);	
		$('#nombre_municipio_ap').cargar_input(respuesta.nombreMunicipio[0]);
		
		$('#consecutivo_ap').html(respuesta.consecutivo[0]);
		$('#fecha_ap').cargar_input(respuesta.fecha[0]);
		$('#id_cliente_ap').cargar_input(respuesta.idCliente[0]);
		$('#nombre_cliente_ap').cargar_input(respuesta.nombreCliente[0]);
		$('#identificacion_cliente_ap').cargar_input(respuesta.identificacionCliente[0]);
		$('#concepto_ap').cargar_input(respuesta.concepto[0]);
		switch(respuesta.tipoPago[0]){
			case '1':	$('#tipo_pago_ap_c').attr('checked', true);	
						break;
			case '2':	$('#tipo_pago_ap_t').attr('checked', true);
						break;
			default:	$('#tipo_pago_ap_n').attr('checked', true);					
						break;
		}
		
		$('#banco_ap').cargar_input(respuesta.banco[0]);
		$('#tipo_cuenta_ap').cargar_select(respuesta.tipoCuenta[0]);
		$('#numero_cuenta_ap').cargar_input(respuesta.numeroCuenta[0]);
		$('#estado_ap').cargar_select(respuesta.estado[0]);
		
		if(respuesta.sumarIva == 1)
			$('#sumar_iva').attr('checked', true);			
		else
			$('#sumar_iva').removeAttr('checked');	
		
		$('#iva_ap').attr('value', respuesta.iva);
		$('#valor_iva_ap').attr('value', respuesta.valorIva);
		$('#retencion_iva_ap').attr('value', respuesta.retencionIva);
		$('#valor_retencion_iva_ap').attr('value', respuesta.valorRetencionIva);
		$('#retencion_fuente_ap').attr('value', respuesta.retencionFuente);
		$('#valor_retencion_fuente_ap').attr('value', respuesta.valorRetencionFuente);
		$('#retencion_ica_ap').attr('value', respuesta.retencionIca);
		$('#valor_retencion_ica_ap').attr('value', respuesta.valorRetencionIca);
		$('#total_ap').html('');
		$('#form_item_ap table tfoot tr th').find('.error_input').removeClass('error_input');	
						
		$('#informacion_ap').show();
		$('#ver_ap').show();
		if(respuesta.administrador){
			$('#municipio_ap').removeAttr('disabled');
			$('#cambiar_consecutivo_ap').show();
		}
		else{	
			$('#municipio_ap').attr('disabled', true);
			$('#cambiar_consecutivo_ap').hide();
		}
			
		if(respuesta.bloqueo[0])	
			$('#desbloquear_ap').show();	
		else					
			$('#desbloquear_ap').hide();	
		$('#form_item_ap').show();
		
		$.fn.item_ap('todos');		
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todas_ap=function(respuesta){
		$('#tabla_ap').empty();	
		$('#tabla_ap').append('<thead><tr><td width="3%" class="center"><input type="checkbox" id="todos_ap_pdf" name="todos_ap_pdf" checked></td><td width="3%" class="center"><a href="#" id="ver_todas_ap"><img src="img/page_white_stack.png" title="Ver Autorizacion" /></a></td><th width="5%">No.</th><th width="15%">Programa</th><th width="22%">Solicitado por</th><th width="22%">A Favor de</th><th width="27%">Concepto</th><td width="3%"></td></tr></thead>');				
		$('#tabla_ap').append('<tbody id="body_tabla_ap"></tbody>');
		var checkbox, pdf, editable;			
		for(var i=0; i<respuesta.id.length; i++){
			
			if(respuesta.pdf[i] || respuesta.administrador){
				checkbox = '<input type="checkbox" name="ap_pdf" value="'+respuesta.id[i]+'" checked>';
				if(respuesta.bloqueo[i])
					pdf = '<a href="pdf/ap_pdf.php?id_ap='+respuesta.id[i]+'" target="_blank" class="ver_ap"><img src="img/page_white_key.png" title="Ver Autorizacion" /></a>';
				else	
					pdf = '<a href="pdf/ap_pdf.php?id_ap='+respuesta.id[i]+'" target="_blank" class="ver_ap"><img src="img/page_white_acrobat.png" title="Ver Autorizacion" /></a>';
			}
			else{
				checkbox = '';
				pdf = '';
			}
			
			if(respuesta.editable[i])
				editable = '<a href="#" class="cargar_ap">&nbsp;'+respuesta.consecutivo[i]+'&nbsp;</a>';
			else
				editable = respuesta.consecutivo[i];	
			
			if(respuesta.administrador)
				eliminar = '<a href="#" class="eliminar_ap" ><img src="img/delete.png" title="Eliminar Autorizacion"/></a>';				
			else	
				eliminar = '';
				
			$('#body_tabla_ap').append('<tr id="'+respuesta.id[i]+'"><td>'+checkbox+'</td><td>'+pdf+'</td><td title="'+respuesta.fecha[i]+'">'+editable+'</td><td>'+respuesta.nombrePrograma[i]+'</td><td>'+respuesta.nombreResponsable[i]+'</td><td>'+respuesta.nombreCliente[i]+'</td><td title="'+respuesta.concepto[i]+'">'+respuesta.conceptoLista[i]+'</td><td>'+eliminar+'</td></tr>');		
		}											
		$('#tabla_ap').tablesorter({widgets: ['zebra']});
	}
})(jQuery);

(function($){	
    $.fn.ap=function(opc){	
		if((opc == 'buscar_ap' && $('#id_ap').obligatorio('ap')) || (opc == 'buscar_cliente' && $('#id_cliente_ap').obligatorio('ap')) || (opc == 'eliminar' && $('#id_ap').obligatorio('ap')) || (opc == 'desbloquear' && $('#id_ap').obligatorio('ap')) || (opc == 'cambiar_consecutivo' && $('#consecutivo_nuevo_ap').obligatorio('ap')) || $('#id_programa_ap').obligatorio('ap') && $('#id_responsable_ap').obligatorio('ap') && $('#id_municipio_ap').obligatorio('ap') && $('#fecha_ap').obligatorio('ap') && $('#id_cliente_ap').obligatorio('ap') && $('#concepto_ap').obligatorio('ap')){				
			$('#cargando').show();
			$('#opc_ap').attr('value', opc);
			$('#guardar_ap').css('visibility', 'hidden');										
			var datos = $('#form_ap').serialize();			
			$.getJSON('php/ap/ap.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){
						switch(respuesta.opc){
							case 'buscar_ap':  	$.fn.ocultar('lista_ap', false);
												$.fn.mostrar('ap', false);
												$.fn.cargar_ap(respuesta);
												$('#error_ap').html('Autorizacion cargada correctamente');	
												break;
							case 'buscar_cliente':  $('#nombre_cliente_ap').attr('value', respuesta.nombreCliente[0]);
													$('#identificacion_cliente_ap').attr('value', respuesta.identificacionCliente[0]);							
													break;
							case 'cambiar_consecutivo':	$.fn.cargar_ap(respuesta);
														$('#error_ap').html('Consecutivo cambiado correctamente');	
														break;
							case 'desbloquear':	$.fn.cargar_ap(respuesta);
												$('#error_ap').html('Autorizacion desbloqueada correctamente');	
												break;											
							case 'eliminar':if($('#'+respuesta.id).length)
												$('#'+respuesta.id).remove();
											$('#tabla_ap').tablesorter({widgets: ['zebra']});
											alert('Autorizacion eliminada correctamente');																	
											break;						
							case 'guardar':	$.fn.cargar_ap(respuesta);
											$('#error_ap').html('Autorizacion guardada correctamente');						
											break;																
						}
						$('#error_ap').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){
							case 'buscar_ap':	$('#error_ap').html('Error al cargar la Autorizacion');						
												break;
							case 'buscar_cliente':  $('#nombre_cliente_ap').attr('value', '');
													$('#identificacion_cliente_ap').attr('value', '');	
													break;
							case 'cambiar_consecutivo': $('#error_ap').html('Error al cambiar el consecutivo');	
														break;
							case 'desbloquear':	$('#error_ap').html('Error al desbloquear la Autorizacion');	
												break;													
							case 'eliminar':alert('Error no se puede eliminar la Autorizacion');						
											break;						
							case 'guardar':	$('#error_ap').html('Error al guardar la Autorizacion');						
											break;																
						}	
						$('#error_ap').css('color', '#d14836');		
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#guardar_ap').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#guardar_ap').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - ap'); 
			});							
		}
	}
})(jQuery);	

//Formulario Item_AP
(function($){	
    $.fn.limpiar_item_ap=function(){
		$('#id_ap_item_ap').attr('value', '');
		$('#id_item_ap').attr('value', '');
		$('#numero_pago_ap').attr('value', '');
		$('#comprobante_egreso_ap').attr('value', '');
		$('#descripcion_pago_ap').attr('value', '');
		$('#centro_costo_ap').attr('value', '');
		$('#valor_pago_ap').attr('value', '');
	}
})(jQuery);	

(function($){	
    $.fn.cargar_item_ap=function(respuesta){
		$.fn.limpiar_item_ap();
		if($('#item_'+respuesta.id).length){
			$('#item_'+respuesta.id+' > td.numeroPago').text(respuesta.numeroPago[0]);
			$('#item_'+respuesta.id+' > td.ce').html(respuesta.comprobanteEgreso[0]);
			$('#item_'+respuesta.id+' > td.descripcion').html(respuesta.descripcion[0]);	
			$('#item_'+respuesta.id+' > td.cc').html(respuesta.centroCosto[0]);
			$('#item_'+respuesta.id+' > td.valor').html(respuesta.valor[0]);	
		}
		else{		
			$('#tabla_item_ap').append('<tr id="item_'+respuesta.id[0]+'" class="cargar_item_ap"><td class="numeroPago">'+respuesta.numeroPago[0]+'</td><td class="ce">'+respuesta.comprobanteEgreso[0]+'</td><td class="descripcion">'+respuesta.descripcion[0]+'</td><td class="cc">'+respuesta.centroCosto[0]+'</td><td class="valor">'+respuesta.valor[0]+'</td><td><a href="#" class="eliminar_item_ap"><img src="img/delete.png" title="Eliminar Pago" /></a></td></tr>');
			$('#tabla_item_ap').tablesorter({widgets: ['zebra']});
		}
		$.fn.subtotal();
	}
})(jQuery);	

(function($){	
    $.fn.cargar_todos_item_ap=function(respuesta){
		$.fn.limpiar_item_ap();
		$('#tabla_item_ap').empty();	
		for(var i=0; i<respuesta.id.length; i++){
			$('#tabla_item_ap').append('<tr id="item_'+respuesta.id[i]+'" class="cargar_item_ap"><td class="numeroPago">'+respuesta.numeroPago[i]+'</td><td class="ce">'+respuesta.comprobanteEgreso[i]+'</td><td class="descripcion">'+respuesta.descripcion[i]+'</td><td class="cc">'+respuesta.centroCosto[i]+'</td><td class="valor">'+respuesta.valor[i]+'</td><td><a href="#" class="eliminar_item_ap"><img src="img/delete.png" title="Eliminar Pago" /></a></td></tr>');		
		}											
		$('#tabla_item_ap').tablesorter({widgets: ['zebra']});
		$.fn.subtotal();
	}
})(jQuery);

(function($){	
    $.fn.item_ap=function(opc){		
		if(opc == 'retenciones' || opc == 'todos' || ((opc == 'eliminar' || opc == 'buscar') && $('#id_item_ap').obligatorio('item_ap')) || ($('#descripcion_pago_ap').obligatorio('item_ap') && $('#centro_costo_ap').obligatorio('item_ap') && $('#valor_pago_ap').obligatorio('item_ap'))){						
			$('#cargando').show();
			$('#id_ap_item_ap').attr('value', $('#id_ap').attr('value'));
			$('#opc_item_ap').attr('value', opc);			
			$('#guardar_item_ap').css('visibility', 'hidden');										
			var datos = $('#form_item_ap').serialize();						
			$.getJSON('php/ap/item_ap.php', datos, function(respuesta) {
				if(respuesta.login){
					if(respuesta.consulta){
						switch(respuesta.opc){
							case 'buscar':	$('#numero_pago_ap').attr('value', respuesta.numeroPago[0]);
											$('#comprobante_egreso_ap').attr('value', respuesta.comprobanteEgreso[0]);
											$('#descripcion_pago_ap').attr('value', respuesta.descripcion[0]);
											$('#centro_costo_ap').attr('value', respuesta.centroCosto[0]);
											$('#valor_pago_ap').attr('value', respuesta.valor[0]);
											$('#error_item_ap').html('Pago cargado correctamente');						
											break;
							case 'eliminar':$.fn.limpiar_item_ap();
											if($('#item_'+respuesta.id).length)
												$('#item_'+respuesta.id).remove();
											$('#error_item_ap').html('Pago eliminado correctamente');
											$.fn.subtotal();							
											break;
							case 'guardar':	$.fn.cargar_item_ap(respuesta);
											$('#error_item_ap').html('Pago guardado correctamente');						
											break;
							case 'retenciones':	$('#iva_ap').attr('value', respuesta.iva);
												$('#retencion_iva_ap').attr('value', respuesta.retencionIva);
												$('#retencion_fuente_ap').attr('value', respuesta.retencionFuente);
												$('#valor_retencion_fuente_ap').attr('value', respuesta.valorRetencionFuente);
												$('#retencion_ica_ap').attr('value', respuesta.retencionIca);
												$('#error_item_ap').html('Retencion modificada correctamente');
												$.fn.subtotal();
												break;					
							case 'todos':  	$.fn.cargar_todos_item_ap(respuesta);
											$('#error_item_ap').html('Pagos cargados correctamente');
											break;																					
						}						
						$('#error_item_ap').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){							
							case 'buscar':	$('#error_item_ap').html('Error al cargar el pago');						
											break;
							case 'eliminar':$('#error_item_ap').html('Error al eliminar el pago');						
											break;
							case 'guardar':	$('#error_item_ap').html('Error al guardar el pago');						
											break;	
							case 'retenciones':	$('#error_item_ap').html('Error al modificar la retencion');
												break;									
							case 'todos':  	$('#tabla_item_ap').empty();
											$('#error_item_ap').html('');
											$.fn.subtotal();
											break;									
						}	
						$('#error_item_ap').css('color', '#d14836');		
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#guardar_item_ap').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#guardar_item_ap').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - item_ap'); 
			});							
		}
	}
})(jQuery);	

//Formulario Buscar
(function($){	
    $.fn.buscar=function(form){	
		if($('#buscar').obligatorio('buscar') || $('#programa_buscar').obligatorio('buscar') ){
			$("#s_0").slideDown(300);					
			$('#cargando').show();
			$('#opc_buscar').attr('value', form);
			$('#buscar_todo').css('visibility', 'hidden');
			var ruta =	'php/'+form+'/'+form+'.php';									
			var datos = $('#form_buscar').serialize();
			$.getJSON(ruta, datos, function(respuesta) {				
				if(respuesta.login){																	
					if(respuesta.consulta){
						switch(respuesta.opc){							
							case 'ap': 	$('#error_buscar').html('Se encontraron '+respuesta.id.length+' autorizaciones');
										$.fn.cargar_todas_ap(respuesta);
										break;										
						}
						$('#error_buscar').css('color', '#15c');
					}
					else{	
						switch(respuesta.opc){							
							case 'ap': 	$('#tabla_ap').empty();										
										$('#error_buscar').html('No se encontro ningun resultado!');
										break;									
						}	
						$('#error_buscar').css('color', '#d14836');	
					}
				}
				else
					$(location).attr('href', 'index.php');
				$('#buscar_todo').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
			})
			.error(function() { 
				$('#buscar_todo').css('visibility', 'visible');	
				$('#cargando').delay(400).slideUp(1);
				$('#error').html('Error: Compruebe la conexion de red de su equipo! - buscar'); 
			});
		}
	}
})(jQuery);	

/*Diego Rodriguez*/
$(document).ready(function(){	
	$("#fecha_ap").datepicker();
	$("#valor_pago_ap").priceFormat();
	
	$.fn.lista('departamento', 'municipio', '', '');	
	$.fn.lista('perfil', 'usuario', '', '');	
		
	$.fn.lista('municipio', 'ap', '', '');
	$.fn.lista('municipio', 'programa', '', '');
	$.fn.lista('municipio', 'barrio', '', '');	
	$.fn.lista('municipio', 'usuario', '', '');
	$.fn.lista('municipio', 'responsable', '', '');	
	
	$.fn.lista('programa', 'buscar', '*', '');
	$.fn.lista('programa', 'usuario', '', '');	
	$.fn.lista('programa', 'responsable', '', '');	
			
	//Menu	
	$.getJSON('php/menu.php', function(respuesta) {
		if(respuesta.login){
			$('#nombre_user').html('<strong>'+respuesta.nombre+'</strong>');
			$('#municipio_user').html(respuesta.nombreMunicipio);			
			if(!respuesta.administrador){
				$('#cambiar_municipio').hide();
				$('#adicionar_programa_ap').hide();
				$('#adicionar_responsable_ap').hide();
				$('#adicionar_municipio_ap').hide();
			}
			$('#id_departamento_user').attr('value', respuesta.idDepartamento);
			$('#id_municipio_user').attr('value', respuesta.idMunicipio);
			$('#email_user').attr('value', respuesta.email);
			
			$.fn.lista('departamento', 'cambiar', '', '');
			$.fn.lista('municipio', 'cambiar', respuesta.idDepartamento, '');
																
			var submenu = '';	
			$('#menu').html('<ul class="topnav"></ul>');
			if(respuesta.menu[0]){
				for(var i=0; i<respuesta.menu.length; i++){
					submenu = respuesta.menu[i].submenu;	
					$('.topnav').append('<li><a href="#" title="'+submenu+'">'+submenu+'</a><ul id="s_'+i+'"></ul></li>');
					for(var j=0; j<respuesta.menu[i].items.length; j++){
						items = respuesta.menu[i].items[j];					
						iniciales = respuesta.menu[i].iniciales[j];					
						$('#s_'+i).append('<li><a href="#" id="'+iniciales+'" title="'+submenu+' - '+items+'">'+items+'</a></li>');					
					}
				}
			}
			
			$(".topnav").accordion({
				accordion:false,
				speed: 500,
				closedSign: '[+]',
				openedSign: '[-]'
			});	
			
			if($.browser.msie)
				$(".topnav span").css('display', 'none');
			
			$("#s_0").slideDown(300);
			$('#apn').trigger('click');			
		}								
		else				
			$(location).attr('href', 'index.php');
		$('#cargando').delay(400).slideUp(1);	
	})
	.error(function() { 	
		$('#cargando').delay(400).slideUp(1); 	
		$('#error').html('Error: Compruebe la conexion de red de su equipo!');		
	});	
	
	$('#form_buscar, #form_ap, #form_item_ap, #form_cambiar, #form_programa, #form_barrio, #form_departamento, #form_municipio, #form_persona, #form_usuario, #form_cliente, #form_responsable').submit(function(event){
		event.preventDefault();	
	});
	
	$('#salir').click(function(event){
		$(location).attr('href', 'php/salir.php'); 
	});	

	/***********/
	$('#apn').live('click', function(){
		$('#opcion_menu').html('AUTORIZACION DE PAGO NUEVA');
		$.fn.mostrar('ap', false);
		$.fn.fecha('ap');
		$.fn.lista('programa', 'ap', '*', '');			
		$.fn.limpiar_ap();
		$('#error_ap').html('');		
	});	
	
	$('#apl').live('click', function(){
		$('#opcion_menu').html('LISTADO DE AUTORIZACIONES DE PAGO');
		$.fn.mostrar('lista_ap', false);		
		$('#lista_ap').slideDown('slow');
	});	
		
	$('#prog').live('click', function(){
		$('#opcion_menu').html('PROGRAMAS');
		$.fn.mostrar('programa', false);
		$('#atras_programa').attr('value', '');	
		$.fn.limpiar_programa();	
	});
	
	$('#barr').live('click', function(){
		$('#opcion_menu').html('BARRIOS');
		$.fn.mostrar('barrio', false);
		$('#atras_barrio').attr('value', '');
		$.fn.limpiar_barrio();
	});
		
	$('#user').live('click', function(){
		$('#opcion_menu').html('USUARIOS');
		$.fn.mostrar('usuario', false);
		$.fn.limpiar_usuario();	
	});
	
	$('#cc').live('click', function(){
		$('#opcion_menu').html('CAMBIAR CONTRASEÑA');
		$.fn.mostrar('passwd', false);
		$.fn.limpiar_passwd();	
	});
	
	$('#ter').live('click', function(){
		$('#opcion_menu').html('TERCEROS');
		$.fn.mostrar('persona', false);
		$('#atras_persona').attr('value', '');
		$.fn.limpiar_persona();
	});
	
	$('#fun').live('click', function(){
		$('#opcion_menu').html('FUNCIONARIOS');
		$.fn.mostrar('responsable', false);
		$.fn.limpiar_responsable();
	});
		
	//Listas
	$('#departamento_cambiar').live('change', function(){
		var lista = $(this).attr('value');
		var nombre = '';
		if(lista != 0)
			nombre = $('#departamento_cambiar :selected').text();
		$('#id_departamento_user').attr('value', lista);
		$('#departamento_user').html(nombre);
		$('#id_municipio_user').attr('value', 0);
		$('#municipio_user').html('Seleccionar');
		$.fn.lista('municipio', 'cambiar', lista, '');
		
		$.fn.lista('barrio', 'persona', 0, '');	
	});
	
	$('#municipio_cambiar').live('change', function(){
		var lista = $(this).attr('value');
		var nombre = '';
		if(lista != 0)
			nombre = $('#municipio_cambiar :selected').text();
		$('#id_municipio_user').attr('value', lista);
		$('#municipio_user').html(nombre);
		
		$.fn.lista('barrio', 'persona', lista, '');			
		$.fn.ocultar('cambiar', false);	
	});
	
	$('#programa_ap').live('change', function(){
		var lista = $(this).attr('value');
		var nombre = '';
		if(lista != 0)
			nombre = $('#programa_ap :selected').text();
		$.fn.lista('responsable', 'ap', lista, '');	
		$('#id_programa').attr('value', lista);	
		$.fn.programa('ap');			
		$('#id_programa_ap').attr('value', lista);
		$('#nombre_programa_ap').attr('value', nombre);
	});
	
	$('#municipio_ap').live('change', function(){
		var lista = $(this).attr('value');
		var nombre = '';
		if(lista != 0)
			nombre = $('#municipio_ap :selected').text();
		$('#id_municipio_ap').attr('value', lista);
		$('#nombre_municipio_ap').attr('value', nombre);
	});
	
	$('#responsable_ap').live('change', function(){
		var lista = $(this).attr('value');
		var nombre = '';
		if(lista != 0)
			nombre = $('#responsable_ap :selected').text();		
		$('#id_responsable_ap').attr('value', lista);
		$('#nombre_responsable_ap').attr('value', nombre);
	});
			
	//Formulario Programa
	$('#nuevo_programa').live('click', function(){
		$.fn.limpiar_programa();
		$.fn.programa('todos');
	});
	
	$('#nombre_programa').live('change', function(){
		if($('#id_programa').attr('value') == '' && $('#form_programa').is (':visible'))
			$.fn.programa('buscar');
	});	
	
	$('#nombre_programa').live('keyup', function (e) {
		if($('#id_programa').attr('value') == '' && $('#form_programa').is (':visible')){
			if($('#nombre_programa').obligatorio('programa'))
				$.fn.programa('todos');
			else
				$('#tabla').empty();	
		}
	});	
	
	$('#adicionar_municipio_prog').live('click', function(){
		$.fn.mostrar('municipio', true);
		$('#atras_municipio').attr('value', 'programa');
		$.fn.limpiar_municipio();
	});
	
	$('#guardar_programa').live('click', function(){
		$.fn.programa('guardar');
	});	
	
	$('#eliminar_programa').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar el Programa?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$.fn.programa('eliminar');	
			}
		});			
	});
	
	$('#cancelar_programa').live('click', function(){
		$.fn.ocultar('programa', false);
		var mostrar = $('#atras_programa').attr('value');
		if(mostrar != '')
			$.fn.mostrar(mostrar, true);
	});
	
	$('.cargar_programa').live('click', function(){
		$('#id_programa').attr('value', $(this).parent().parent().attr('id'));
		$.fn.programa('buscar');		 
	});
	
	//Formulario Departamento	
	$('#nuevo_departamento').live('click', function(){
		$.fn.limpiar_departamento();
		$.fn.departamento('todos');
	});
	
	$('#nombre_departamento').live('change', function(){
		if($('#id_departamento').attr('value') == '' && $('#form_departamento').is (':visible'))
			$.fn.departamento('buscar');
	});
	
	$('#nombre_departamento').live('keyup', function (e) {
		if($('#id_departamento').attr('value') == '' && $('#form_departamento').is (':visible')){
			if($('#nombre_departamento').obligatorio('departamento'))
				$.fn.departamento('todos');
			else
				$('#tabla').empty();		
		}
	});	
		
	$('#guardar_departamento').live('click', function(){
		$.fn.departamento('guardar');
	});
	
	$('#eliminar_departamento').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar el Departamento?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$.fn.departamento('eliminar');	
			}
		});			
	});
	
	$('#cancelar_departamento').live('click', function(){
		$.fn.ocultar('departamento', true);	
		var mostrar = $('#atras_departamento').attr('value');
		if(mostrar != '')
			$.fn.mostrar(mostrar, true);
	});
	
	$('.cargar_departamento').live('click', function(){
		$('#id_departamento').attr('value', $(this).parent().parent().attr('id'));
		$.fn.departamento('buscar');		 
	});
	
	//Formulario Municipio	
	$('#nuevo_municipio').live('click', function(){
		$.fn.limpiar_municipio();
		$.fn.municipio('todos');
	});
	
	$('#nombre_municipio').live('change', function(){
		if($('#id_municipio').attr('value') == '' && $('#form_municipio').is (':visible'))
			$.fn.municipio('buscar');
	});	
	
	$('#nombre_municipio').live('keyup', function (e) {
		if($('#id_municipio').attr('value') == '' && $('#form_municipio').is (':visible')){
			if($('#nombre_municipio').obligatorio('municipio'))
				$.fn.municipio('todos');
			else
				$('#tabla').empty();		
		}
	});	
	
	$('#adicionar_departamento_municipio').live('click', function(){
		$.fn.mostrar('departamento', true);
		$('#atras_departamento').attr('value', 'municipio');
		$.fn.limpiar_departamento();
	});	
	
	$('#guardar_municipio').live('click', function(){
		$.fn.municipio('guardar');
	});
	
	$('#eliminar_municipio').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar el Municipio?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$.fn.municipio('eliminar');	
			}
		});			
	});
	
	$('#cancelar_municipio').live('click', function(){
		$.fn.ocultar('municipio', true);
		var mostrar = $('#atras_municipio').attr('value');
		if(mostrar != '' && mostrar != 'ap')
			$.fn.mostrar(mostrar, true);
	});
	
	$('.cargar_municipio').live('click', function(){
		$('#id_municipio').attr('value', $(this).parent().parent().attr('id'));
		$.fn.municipio('buscar');		 
	});
	
	//Formulario Barrio	
	$('#nuevo_barrio').live('click', function(){
		$.fn.limpiar_barrio();
		$.fn.barrio('todos');
	});
	
	$('#nombre_barrio').live('change', function(){
		if($('#id_barrio').attr('value') == '' && $('#form_barrio').is (':visible'))
			$.fn.barrio('buscar');
	});	
	
	$('#nombre_barrio').live('keyup', function (e) {
		if($('#id_barrio').attr('value') == '' && $('#form_barrio').is (':visible')){
			if($('#nombre_barrio').obligatorio('barrio'))
				$.fn.barrio('todos');
			else
				$('#tabla').empty();		
		}
	});	
	
	$('#adicionar_municipio_barrio').live('click', function(){
		$.fn.mostrar('municipio', true);
		$('#atras_municipio').attr('value', 'barrio');
		$.fn.limpiar_municipio();
	});
	
	$('#guardar_barrio').live('click', function(){
		$.fn.barrio('guardar');
	});
	
	$('#eliminar_barrio').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar el Barrio?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$.fn.barrio('eliminar');	
			}
		});			
	});
	
	$('#cancelar_barrio').live('click', function(){
		$.fn.ocultar('barrio', false);
		var mostrar = $('#atras_barrio').attr('value');
		if(mostrar != '')
			$.fn.mostrar(mostrar, true);
	});
	
	$('.cargar_barrio').live('click', function(){
		$('#id_barrio').attr('value', $(this).parent().parent().attr('id'));
		$.fn.barrio('buscar');		 
	});
	
	//Formulario Persona
	$('#nuevo_persona').live('click', function(){
		$.fn.limpiar_persona();
	});
	
	$('#nombre_persona').live('change', function(){
		if($('#id_persona').attr('value') == '' && $('#form_persona').is (':visible'))
			$.fn.persona('buscar');
	});	
	
	$('#nombre_persona').live('keyup', function (e) {
		if($('#id_persona').attr('value') == '' && $('#form_persona').is (':visible')){
			if($('#nombre_persona').obligatorio('persona'))
				$.fn.persona('todos');
		}
	});
	
	$('#identificacion_persona').live('change', function(){
		if($('#id_persona').attr('value') == '' && $('#form_persona').is (':visible'))
			$.fn.persona('buscar');
	});	
	
	$('#identificacion_persona').live('keyup', function (e) {
		if($('#id_persona').attr('value') == '' && $('#form_persona').is (':visible')){
			if($('#identificacion_persona').obligatorio('persona'))
				$.fn.persona('todos');
		}
	});	
	
	$('#adicionar_barrio_persona').live('click', function(){
		$.fn.mostrar('barrio', true);		
		$('#atras_barrio').attr('value', 'persona');
		$.fn.limpiar_barrio();
	});	
	
	$('#guardar_persona').live('click', function(){
		$.fn.persona('guardar');
	});
	
	$('#eliminar_persona').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar la Persona?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$.fn.persona('eliminar');	
			}
		});			
	});
	
	$('#cancelar_persona').live('click', function(){		
		$.fn.ocultar('persona', false);
		var mostrar = $('#atras_persona').attr('value');
		if(mostrar != ''){
			if(mostrar != 'ap')
				$.fn.mostrar(mostrar, true);								
			switch(mostrar){
				case 'ap':	if($('#id_persona').attr('value') != ''){
								$('#id_cliente_ap').attr('value', $('#id_persona').attr('value'));
								$.fn.ap('buscar_cliente');
							}
							break;
				case 'responsable':	if($('#id_persona').attr('value') != ''){
										$('#id_responsable').attr('value', $('#id_persona').attr('value'));
										$.fn.responsable('buscar');
									}
									break;
				case 'usuario':	if($('#id_persona').attr('value') != ''){	
									$('#id_usuario').attr('value', $('#id_persona').attr('value'));
									$.fn.usuario('buscar');
								}
								break;
			}
		}
	});	
	
	$('.cargar_persona').live('click', function(){
		$('#id_persona').attr('value', $(this).parent().parent().attr('id'));
		$.fn.persona('buscar');		 
	});
	
	//Formulario Usuario
	$('#nuevo_usuario').live('click', function(){
		$.fn.limpiar_usuario();
		$.fn.usuario('todos');
	});
	
	$('#nombre_usuario').live('change', function(){
		if($('#id_usuario').attr('value') == '' && $('#form_usuario').is (':visible'))
			$.fn.usuario('buscar');
	});	
	
	$('#nombre_usuario').live('keyup', function (e) {
		if($('#id_usuario').attr('value') == '' && $('#form_usuario').is (':visible')){
			if($('#nombre_usuario').obligatorio('usuario'))
				$.fn.usuario('todos');
			else
				$('#tabla').empty();		
		}
	});		
	
	$('#modificar_persona_usuario').live('click', function(){
		$.fn.mostrar('persona', true);
		$('#atras_persona').attr('value', 'usuario');
		if($('#id_usuario').attr('value')){
			$('#id_persona').attr('value', $('#id_usuario').attr('value'));
			$.fn.persona('buscar');
		}
		else{
			$.fn.limpiar_persona();	
			$('#nombre_persona').attr('value', $('#nombre_usuario').attr('value'));
			$.fn.persona('buscar');	
		}
	});
	
	$('#adicionar_municipio_usuario').live('click', function(){
		$.fn.mostrar('municipio', true);		
		$('#atras_municipio').attr('value', 'usuario');
		$.fn.limpiar_municipio();
	});
	
	$('#adicionar_programa_usuario').live('click', function(){
		if($('#id_usuario').obligatorio('usuario') && $('#programa_usuario').obligatorio('usuario'))
			$.fn.usuario('guardar_prog');
	});
	
	$('#eliminar_programa_usuario').live('click', function(){
		if($('#id_usuario').obligatorio('usuario') && $('#programa_registrado_usuario').obligatorio('usuario'))
			$.fn.usuario('eliminar_prog');
	});
	
	$('#guardar_usuario').live('click', function(){
		$.fn.usuario('guardar');
	});
	
	$('#eliminar_usuario').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar el Usuario?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$.fn.usuario('eliminar');	
			}
		});			
	});
	
	$('#cancelar_usuario').live('click', function(){
		$.fn.ocultar('usuario', false);
	});	
	
	$('.cargar_usuario').live('click', function(){
		$('#id_usuario').attr('value', $(this).parent().parent().attr('id'));
		$.fn.usuario('buscar');		 
	});
	
	//Formulario Passwd	
	$('#guardar_passwd').live('click', function(){
		$.fn.passwd('cambiar_passwd');
	});	
	
	$('#cancelar_passwd').live('click', function(){
		$.fn.ocultar('passwd', false);	
	});
	
	//Formulario Responsable
	$('#nuevo_responsable').live('click', function(){
		$.fn.limpiar_responsable();
		$.fn.responsable('todos');
	});
	
	$('#nombre_responsable').live('change', function(){
		if($('#id_responsable').attr('value') == '' && $('#form_responsable').is (':visible'))
			$.fn.responsable('buscar');
	});	
	
	$('#nombre_responsable').live('keyup', function (e) {
		if($('#id_responsable').attr('value') == '' && $('#form_responsable').is (':visible')){
			if($('#nombre_responsable').obligatorio('responsable'))
				$.fn.responsable('todos');
			else
				$('#tabla').empty();		
		}
	});		
	
	$('#modificar_persona_responsable').live('click', function(){
		$.fn.mostrar('persona', true);
		$('#atras_persona').attr('value', 'responsable');
		if($('#id_responsable').attr('value')){
			$('#id_persona').attr('value', $('#id_responsable').attr('value'));
			$.fn.persona('buscar');
		}
		else{
			$.fn.limpiar_persona();
			$('#nombre_persona').attr('value', $('#nombre_responsable').attr('value'));
			$.fn.persona('buscar');	
		}
	});
		
	$('#adicionar_programa_responsable').live('click', function(){
		$.fn.mostrar('programa', true);		
		$('#atras_programa').attr('value', 'programa');
		$.fn.limpiar_programa();
	});
	
	$('#guardar_responsable').live('click', function(){
		$.fn.responsable('guardar');
	});
	
	$('#eliminar_responsable').live('click', function(){
		if($('#programa_registrado_responsable').obligatorio('responsable')){
			$('.appriseOverlay').remove();
			$('.appriseOuter').remove();			
			apprise('Esta seguro de Eliminar el Responsable?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
				if(r){		
					$.fn.responsable('eliminar');	
				}
			});	
		}
	});
	
	$('#cancelar_responsable').live('click', function(){
		$.fn.ocultar('responsable', false);
	});	
	
	$('.cargar_responsable').live('click', function(){
		$('#id_responsable').attr('value', $(this).parent().parent().attr('id'));
		$.fn.responsable('buscar');		 
	});
	
	//Formulario Buscar
	$('#buscar_todo').live('click', function(){	
		$('#error_buscar').html('');			
		$('#opcion_menu').html('LISTADO DE AUTORIZACIONES DE PAGO');
		$.fn.mostrar('lista_ap', false);	
		$.fn.buscar('ap');	
	});	
	
	$('#buscar').live('change', function(){		
		$('#error_buscar').html('');			
		$('#opcion_menu').html('LISTADO DE AUTORIZACIONES DE PAGO');
		$.fn.mostrar('lista_ap', false);
		$.fn.buscar('ap');
	});	
	
	$('#programa_buscar').live('change', function(){		
		$('#error_buscar').html('');			
		$('#opcion_menu').html('LISTADO DE AUTORIZACIONES DE PAGO');
		$.fn.mostrar('lista_ap', false);
		$.fn.buscar('ap');
	});		
	
	//Formulario AP
	$('#editar_cliente_ap').live('click', function(){
		$.fn.mostrar('persona', true);
		$('#atras_persona').attr('value', 'ap');
		if($('#id_cliente_ap').attr('value')){
			$('#id_persona').attr('value', $('#id_cliente_ap').attr('value'));
			$.fn.persona('buscar');
		}
		else
			$.fn.limpiar_persona();	
	});	
	
	$('#cambiar_cliente_ap').live('click', function(){
		$.fn.mostrar('persona', true);
		$('#atras_persona').attr('value', 'ap');
		$('#id_cliente_ap').attr('value', '');
		$('#nombre_cliente_ap').attr('value', '');
		$('#identificacion_cliente_ap').attr('value', '');
		$.fn.limpiar_persona();	
	});
	
	$('#adicionar_programa_ap').live('click', function(){
		$.fn.mostrar('programa', true);
		$.fn.limpiar_programa();
	});	
		
	$('#adicionar_responsable_ap').live('click', function(){
		$.fn.mostrar('responsable', true);
		$.fn.limpiar_responsable();
	});	
	
	$('#adicionar_municipio_ap').live('click', function(){
		$.fn.mostrar('municipio', true);
		$('#atras_municipio').attr('value', 'ap');
		$.fn.limpiar_municipio();
	});
	
	$('#guardar_ap').live('click', function(){
		$.fn.ap('guardar');
	});
	
	$('#cambiar_consecutivo_ap').live('click', function(){
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();
		var id = $(this).parent().attr("id");					
		apprise('Digite el consecutivo de la Autorizacion', {'input':true, 'verify':true, 'textOk':'Cambiar', 'textCancel':'Cancelar'}, function(r) {	
			if(r){ 
				if(!isNaN(r) && parseInt(r)>0){
					$('#consecutivo_nuevo_ap').attr('value', r);
					$.fn.ap('cambiar_consecutivo');
				}
				else{
					$('#error_ap').html('Error digite un numero valido');	
					$('#error_ap').css('color', '#d14836');
				}
			}
		});
	});		
		
	$('.eliminar_ap').live('click', function(){
		var id = $(this).parent().parent().attr('id');
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar la Autorizacion?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){	
				$('#id_ap').attr('value', id);
				$.fn.ap('eliminar');	
			}
		});			
	});
		
	$('#cancelar_ap').live('click', function(){
		$.fn.ocultar('ap', false);
		$.fn.ocultar('item_ap', false);
		$('#lista_ap').slideDown('slow');
	});
	
	$('.cargar_ap').live('click', function(){
		$('#id_ap').attr('value', $(this).parent().parent().attr('id'));
		$.fn.ap('buscar_ap');		 
	});
	
	$('#desbloquear_ap').live('click', function(){
		$.fn.ap('desbloquear');
	});	
		
	$('#ver_todas_ap').live('click', function(){
		var href = 'pdf/ap_pdf.php?id_ap=';
		$('input[name=ap_pdf]').each( function(){			
			if(this.checked){
				if(href != 'pdf/ap_pdf.php?id_ap=')
					href = href + ',';
				href = href + this.value;
			}
		});
		
		if(href != 'pdf/ap_pdf.php?id_ap=')
			window.open(href);
	});	
	
	$('#todos_ap_pdf').live('change', function(){
		$('input[name=ap_pdf]').each( function(){			
			if($("input[name=todos_ap_pdf]:checked").length == 1)
				this.checked = true;
			else
				this.checked = false;
		});
	});
			
	//Formulario Item AP
	$('#guardar_item_ap').live('click', function(){
		$.fn.item_ap('guardar');
	});
	
	$('#sumar_iva').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap'))			
			$.fn.item_ap('retenciones');
	});
		
	$('#iva_ap').live('change', function(){	
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){	
			$('#valor_iva_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
	
	$('#valor_iva_ap').live('change', function(){	
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){	
			$('#iva_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
	
	$('#retencion_iva_ap').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){
			$('#valor_retencion_iva_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
	
	$('#valor_retencion_iva_ap').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){
			$('#retencion_iva_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
	
	$('#retencion_fuente_ap').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){
			$('#valor_retencion_fuente_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});	
	
	$('#valor_retencion_fuente_ap').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){
			$('#retencion_fuente_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
	
	$('#retencion_ica_ap').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){
			$('#valor_retencion_ica_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
	
	$('#valor_retencion_ica_ap').live('change', function(){
		if($('#iva_ap').porcentaje('item_ap') && $('#retencion_iva_ap').porcentaje('item_ap') && $('#retencion_ica_ap').reteica('item_ap')){
			$('#retencion_ica_ap').attr('value', '');
			$.fn.item_ap('retenciones');
		}
	});
		
	$('.eliminar_item_ap').live('click', function(){
		var id = $(this).parent().parent().attr('id');
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Eliminar el Pago?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){	
				id = id.split('_');
				$('#id_item_ap').attr('value', id[1]);
				$.fn.item_ap('eliminar');	
			}
		});			
	});
	
	$('.cargar_item_ap').live('click', function(){
		var id = $(this).attr('id');
		id = id.split('_');
		$('#id_item_ap').attr('value', id[1]);
		$.fn.item_ap('buscar');		 
	});
				
	//Cambiar - Adicionar
	$('#cambiar_municipio').live('click', function(){
		$.fn.mostrar('cambiar', true);
		$('#departamento_cambiar').cargar_select(0);
		$('#municipio_cambiar').cargar_select(0);
	});		
	
	$('#cancelar_cambiar').live('click', function(){
		$.fn.ocultar('cambiar', false);
	});				
	
	//Class Active	
	$('.topnav > li > ul > li > a').live('click', function(){
		$('.topnav').find('.active').removeClass('active');		
		$(this).addClass('active');
	})
	
	//Esc.
	$(document).keydown(function (event) {
		if(event.keyCode==27){				
			if($('#form_cambiar').is (':visible'))
				$('#cancelar_cambiar').click();
			else{	
				if($('#form_departamento').is (':visible'))				
					$('#cancelar_departamento').click();
				else{
					if($('#form_municipio').is (':visible'))
						$('#cancelar_municipio').click();
					else{	
						if($('#form_programa').is (':visible') && $('#form_ap').is (':visible'))
							$('#cancelar_programa').click();
						else{	
							if($('#form_barrio').is (':visible') && $('#form_ap').is (':visible'))
								$('#cancelar_barrio').click();	
							else{
								if($('#form_persona').is (':visible') && ($('#form_ap').is (':visible') || $('#atras_persona').attr('value') == 'usuario' || $('#atras_persona').attr('value') == 'responsable')){									
									$('#cancelar_persona').click();
								}
								else{
									if($('#form_usuario').is (':visible') && $('#form_ap').is (':visible'))									
										$('#cancelar_usuario').click();
									else{											
										if($('#form_responsable').is (':visible') && $('#form_ap').is (':visible'))
											$('#cancelar_responsable').click();
									}
								}
							}
						}
					}
				}
			}
		}
		
		if(event.keyCode==113){	
			if($('#form_usuario').is (':visible'))	
				$('#modificar_persona_usuario').click();
			else{
				if($('#form_responsable').is (':visible'))
					$('#modificar_persona_responsable').click();
				else{	
					if($('#form_ap').is (':visible'))
						$('#editar_cliente_ap').click();
				}
			}
		}
		
		if(event.keyCode==8){			
			if(!$('input').is (':focus') && !$('textarea').is (':focus'))
				event.preventDefault();			
		}
	});	
	
	$("#cargando").delay(400).slideUp(1);
});