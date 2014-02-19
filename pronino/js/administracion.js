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
    $.fn.numero=function(){
		if($(this).attr('value') != '' && !isNaN($(this).attr('value'))){
			$(this).removeClass('input_error');
			return true;
		}
		else{
			$('#error').html('Digite un numero valido');			
			$(this).addClass('input_error');	
			$(this).focus();
			return false;
		}
    }
})(jQuery);

(function($){
	$.fn.correo=function(form){	
		if(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/.test($(this).val())){
			$(this).removeClass('input_error');	
			return true;
		}
		else{
			$('#error').html('* Valor invalido: '+$(this).attr('label'));
			$(this).addClass('input_error');	
			$(this).focus();
			return false;
		}
	}
})(jQuery);

(function($){	
    $.fn.diferente=function(id){
		if($(this).attr('value') != '' && ($(this).attr('value') == $('#'+id).attr('value'))){
			$(this).removeClass('input_error');
			$('#'+id).removeClass('input_error');
			return true;
		}
		else{	
			$('#error').html('Los campos deben ser iguales: '+$(this).attr('label'));		
			$(this).addClass('input_error');	
			$('#'+id).addClass('input_error');	
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
    $.fn.cargarInput=function(valor){		
		$(this).attr('value', valor);	
    }
})(jQuery);

(function($){	
    $.fn.cargarCheckbox=function(valor){
		if(valor == '0' || valor == '')
			$(this).removeAttr('checked');
		else
			$(this).attr('checked', true);
    }
})(jQuery);

(function($){	
    $.fn.cargarTextarea=function(valor){		
		$(this).attr('value', valor);
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

(function($){
    $.fn.listaYear=function(){						
		var fecha = new Date() 
		var year = fecha.getFullYear();
		var mes = parseInt(fecha.getMonth()) + 1;
		
		$('#year_exportar').empty();
		$('#year_importar').empty();
		$('#year_listado').empty();
		for(var i=2011; i<=year; i++){
			$('#year_exportar').append('<option value="'+i+'" >'+i+'</option>');
			$('#year_importar').append('<option value="'+i+'" >'+i+'</option>');
			$('#year_listado').append('<option value="'+i+'" >'+i+'</option>');
		}
		
		$('#year_exportar').cargarSelect(year);
		$('#year_importar').cargarSelect(year);
		$('#year_listado').cargarSelect(year);		
    }
})(jQuery);

(function($){	
    $.fn.limpiarActividad=function(){	
		$('#form_actividad').find('.input_error').removeClass('input_error');
		$('#id_actividad').cargarInput('');
		$('#nombre_actividad').cargarInput('');
		$('#nombre_actividad').focus();
		
		$('#span_actividad').text('');
		$('#guardar_actividad').attr('value', 'Buscar');
		$('#nueva_actividad').hide();		
		$('#eliminar_actividad').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarActividad=function(respuesta){
		$('#tabla_actividad').empty();
		$('#form_actividad').find('.input_error').removeClass('input_error');
		$('#id_actividad').cargarInput(respuesta.id[0]);		
		$('#nombre_actividad').cargarInput(respuesta.nombre[0]);		
		
		$('#span_actividad').html(respuesta.nombre[0]);
		$('#guardar_actividad').attr('value', 'Guardar');
		$('#nueva_actividad').hide();		
		$('#eliminar_actividad').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaActividad=function(respuesta){		
		$('#tabla_actividad').empty();
		$('#tabla_actividad').append('<thead><tr><th width="10%"></th><th width="90%">Actividad Laboral</th><tbody id="tbody_actividad"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_actividad').append('<tr id="'+respuesta.id[i]+'" class="cargar_actividad" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}
		$('#tabla_actividad').tablesorter({widgets: ['zebra']});				
	}
})(jQuery);
(function($){	
    $.fn.actividad=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_actividad').obligatorio()) || $('#nombre_actividad').obligatorio()){			
			$("#guardar_actividad").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_actividad').cargarInput(opc);													
			var datos = $('#form_actividad').serialize();			
			$.getJSON('php/actividad.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarActividad(respuesta);
											$('#error').html('Actividad Laboral cargada correctamente');
											break;
							case 'eliminar':$.fn.limpiarActividad();
											$('#error').html('Actividad Laboral eliminada correctamente');
											break;				
							case 'guardar':	$.fn.limpiarActividad();
											$.fn.tablaActividad(respuesta);
											$('#error').html('Actividad Laboral guardada correctamente');
											break;
							case 'nuevo':	$.fn.limpiarActividad();
											$.fn.tablaActividad(respuesta);
											$('#error').html('Actividad Laboral creada correctamente');
											break;
							case 'tabla':	$.fn.tablaActividad(respuesta);
											if(respuesta.nuevo)
												$('#nueva_actividad').show();
											else	
												$('#nueva_actividad').hide();
											$('#error').html('Actividades Laborales Encontradas');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_actividad').empty();
											$('#nueva_actividad').show();
											$('#error').html('No se encontro ninguna Actividad Laboral con ese nombre, desea crear una nueva');
											break;
							case 'eliminar':$('#error').html('Error al eliminar la Actividad Laboral');
											break;				
							case 'guardar':	$.fn.cargarActividad(respuesta);
											$('#error').html('Error al guardar la Actividad Laboral');
											break;
							case 'nuevo':	$('#error').html('Error al crear la Actividad Laboral');
											break;
							case 'tabla':	$('#tabla_actividad').empty();
											$('#nueva_actividad').show();
											$('#error').html('No se encontro ninguna Actividad Laboral con ese nombre, desea crear una nueva');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_actividad").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_actividad").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - actividad"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarArs=function(){	
		$('#form_ars').find('.input_error').removeClass('input_error');
		$('#id_ars').cargarInput('');
		$('#nombre_ars').cargarInput('');
		$('#nombre_ars').focus();
		
		$('#span_ars').text('');
		$('#guardar_ars').attr('value', 'Buscar');
		$('#nueva_ars').hide();		
		$('#eliminar_ars').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarArs=function(respuesta){
		$('#tabla_ars').empty();
		$('#form_ars').find('.input_error').removeClass('input_error');
		$('#id_ars').cargarInput(respuesta.id[0]);		
		$('#nombre_ars').cargarInput(respuesta.nombre[0]);		
		
		$('#span_ars').html(respuesta.nombre[0]);
		$('#guardar_ars').attr('value', 'Guardar');
		$('#nueva_ars').hide();		
		$('#eliminar_ars').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaArs=function(respuesta){
		$('#tabla_ars').empty();
		$('#tabla_ars').append('<thead><tr><th width="10%"></th><th width="90%">Nombre ARS</th><tbody id="tbody_ars"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_ars').append('<tr id="'+respuesta.id[i]+'" class="cargar_ars" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}	
		$('#tabla_ars').tablesorter({widgets: ['zebra']});			
	}
})(jQuery);
(function($){	
    $.fn.ars=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_ars').obligatorio()) || $('#nombre_ars').obligatorio()){			
			$("#guardar_ars").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_ars').cargarInput(opc);													
			var datos = $('#form_ars').serialize();			
			$.getJSON('php/ars.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarArs(respuesta);
											$('#error').html('ARS cargada correctamente');
											break;
							case 'eliminar':$.fn.limpiarArs();
											$('#error').html('ARS eliminada correctamente');
											break;				
							case 'guardar':	$.fn.limpiarArs();
											$.fn.tablaArs(respuesta);
											$('#error').html('ARS guardada correctamente');
											break;
							case 'nuevo':	$.fn.limpiarArs();
											$.fn.tablaArs(respuesta);
											$('#error').html('ARS creada correctamente');
											break;
							case 'tabla':	$.fn.tablaArs(respuesta);
											if(respuesta.nuevo)
												$('#nueva_ars').show();
											else	
												$('#nueva_ars').hide();
											$('#error').html('ARS Encontradas');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_ars').empty();
											$('#nueva_ars').show();
											$('#error').html('No se encontro ninguna ARS con ese nombre, desea crear una nueva');
											break;
							case 'eliminar':$('#error').html('Error al eliminar la ARS');
											break;				
							case 'guardar':	$.fn.cargarArs(respuesta);
											$('#error').html('Error al guardar la ARS');
											break;
							case 'nuevo':	$('#error').html('Error al crear la ARS');
											break;
							case 'tabla':	$('#tabla_ars').empty();
											$('#nueva_ars').show();
											$('#error').html('No se encontro ninguna ARS con ese nombre, desea crear una nueva');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_ars").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_ars").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - ars"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarDepartamento=function(){	
		$('#form_departamento').find('.input_error').removeClass('input_error');
		$('#id_departamento').cargarInput('');
		$('#nombre_departamento').cargarInput('');
		$('#nombre_departamento').focus();
		
		$('#span_departamento').text('');
		$('#guardar_departamento').attr('value', 'Buscar');
		$('#nuevo_departamento').hide();		
		$('#eliminar_departamento').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarDepartamento=function(respuesta){
		$('#tabla_departamento').empty();
		$('#form_departamento').find('.input_error').removeClass('input_error');
		$('#id_departamento').cargarInput(respuesta.id[0]);		
		$('#nombre_departamento').cargarInput(respuesta.nombre[0]);		
		
		$('#span_departamento').html(respuesta.nombre[0]);
		$('#guardar_departamento').attr('value', 'Guardar');
		$('#nuevo_departamento').hide();		
		$('#eliminar_departamento').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaDepartamento=function(respuesta){
		$('#tabla_departamento').empty();
		$('#tabla_departamento').append('<thead><tr><th width="10%"></th><th width="90%">Nombre Departamento</th><tbody id="tbody_departamento"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_departamento').append('<tr id="'+respuesta.id[i]+'" class="cargar_departamento" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}
		$('#tabla_departamento').tablesorter({widgets: ['zebra']});			
	}
})(jQuery);
(function($){	
    $.fn.departamento=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_departamento').obligatorio()) || $('#nombre_departamento').obligatorio()){			
			$("#guardar_departamento").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_departamento').cargarInput(opc);													
			var datos = $('#form_departamento').serialize();			
			$.getJSON('php/departamento.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarDepartamento(respuesta);
											$('#error').html('Departamento cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarDepartamento();	
											$.fn.lista('id_departamento_municipio','php/departamento.php','');
											$.fn.lista('id_departamento_exportar','php/departamento.php','');		
											$('#error').html('Departamento eliminado correctamente');
											break;				
							case 'guardar':	$.fn.limpiarDepartamento();
											$.fn.tablaDepartamento(respuesta);
											$.fn.lista('id_departamento_municipio','php/departamento.php','');	
											$.fn.lista('id_departamento_exportar','php/departamento.php','');
											$('#error').html('Departamento guardado correctamente');
											break;
							case 'nuevo':	$.fn.limpiarDepartamento();
											$.fn.tablaDepartamento(respuesta);	
											$.fn.lista('id_departamento_municipio','php/departamento.php','');
											$.fn.lista('id_departamento_exportar','php/departamento.php','');
											$('#error').html('Departamento creado correctamente');
											break;
							case 'tabla':	$.fn.tablaDepartamento(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_departamento').show();
											else	
												$('#nuevo_departamento').hide();
											$('#error').html('Departamentos Encontrados');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':  $('#tabla_departamento').empty();
											$('#nuevo_departamento').show();
											$('#error').html('No se encontro ningun Departamento con ese nombre, desea crear uno nuevo');
											break;
							case 'eliminar':$('#error').html('Error al eliminar el Departamento');
											break;				
							case 'guardar':	$.fn.cargarDepartamento(respuesta);
											$('#error').html('Error al guardar el Departamento');
											break;
							case 'nuevo':	$('#error').html('Error al crear el Departamento');
											break;
							case 'tabla':	$('#tabla_departamento').empty();
											$('#nuevo_departamento').show();
											$('#error').html('No se encontro ningun Departamento con ese nombre, desea crear uno nuevo');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_departamento").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_departamento").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - departamento"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarMunicipio=function(){	
		$('#form_municipio').find('.input_error').removeClass('input_error');
		$('#id_municipio').cargarInput('');
		$('#id_departamento_municipio').cargarSelect(0);
		$('#nombre_municipio').cargarInput('');
		$('#nombre_municipio').focus();
		
		$('#span_municipio').text('');
		$('#guardar_municipio').attr('value', 'Buscar');
		$('#nuevo_municipio').hide();		
		$('#eliminar_municipio').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarMunicipio=function(respuesta){
		$('#tabla_municipio').empty();
		$('#form_municipio').find('.input_error').removeClass('input_error');
		$('#id_municipio').cargarInput(respuesta.id[0]);
		$('#id_departamento_municipio').cargarSelect(respuesta.idDepartamento[0]);		
		$('#nombre_municipio').cargarInput(respuesta.nombre[0]);		
		
		$('#span_municipio').html(respuesta.nombre[0]);
		$('#guardar_municipio').attr('value', 'Guardar');
		$('#nuevo_municipio').hide();		
		$('#eliminar_municipio').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaMunicipio=function(respuesta){
		$('#tabla_municipio').empty();
		$('#tabla_municipio').append('<thead><tr><th width="10%"></th><th width="90%">Nombre Municipio</th><tbody id="tbody_municipio"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_municipio').append('<tr id="'+respuesta.id[i]+'" class="cargar_municipio" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}
		$('#tabla_municipio').tablesorter({widgets: ['zebra']});			
	}
})(jQuery);
(function($){	
    $.fn.municipio=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_municipio').obligatorio()) || ($('#id_departamento_municipio').obligatorio() && $('#nombre_municipio').obligatorio())){						
			$("#guardar_municipio").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_municipio').cargarInput(opc);													
			var datos = $('#form_municipio').serialize();			
			$.getJSON('php/municipio.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarMunicipio(respuesta);
											$('#error').html('Municipio cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarMunicipio();
											$.fn.lista('id_municipio_barrio','php/municipio.php','');											
											$.fn.lista('id_municipio_listado','php/municipio.php','');
											$.fn.lista('id_municipio_colegio','php/municipio.php','');
											$.fn.lista('id_municipio_sede','php/municipio.php','');											
											$('#error').html('Municipio eliminado correctamente');
											break;				
							case 'guardar':	$.fn.limpiarMunicipio();
											$.fn.tablaMunicipio(respuesta);
											$.fn.lista('id_municipio_barrio','php/municipio.php','');											
											$.fn.lista('id_municipio_listado','php/municipio.php','');
											$.fn.lista('id_municipio_colegio','php/municipio.php','');
											$.fn.lista('id_municipio_sede','php/municipio.php','');											
											$('#error').html('Municipio guardado correctamente');
											break;
							case 'nuevo':	$.fn.limpiarMunicipio();
											$.fn.tablaMunicipio(respuesta);
											$.fn.lista('id_municipio_barrio','php/municipio.php','');											
											$.fn.lista('id_municipio_listado','php/municipio.php','');
											$.fn.lista('id_municipio_colegio','php/municipio.php','');
											$.fn.lista('id_municipio_sede','php/municipio.php','');											
											$('#error').html('Municipio creado correctamente');
											break;
							case 'tabla':	$.fn.tablaMunicipio(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_municipio').show();
											else	
												$('#nuevo_municipio').hide();
											$('#error').html('Municipios Encontrados');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':  $('#tabla_municipio').empty();
											$('#nuevo_municipio').show();
											$('#error').html('No se encontro ningun Municipio con ese nombre, desea crear uno nuevo');
											break;
							case 'eliminar':$('#error').html('Error al eliminar el Municipio');
											break;				
							case 'guardar':	$.fn.cargarMunicipio(respuesta);
											$('#error').html('Error al guardar el Municipio');
											break;
							case 'nuevo':	$('#error').html('Error al crear el Municipio');
											break;
							case 'tabla':	$('#tabla_municipio').empty();
											$('#nuevo_municipio').show();
											$('#error').html('No se encontro ningun Municipio con ese nombre, desea crear uno nuevo');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_municipio").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_municipio").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - municipio"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarBarrio=function(){	
		$('#form_barrio').find('.input_error').removeClass('input_error');
		$('#id_barrio').cargarInput('');
		$('#id_municipio_barrio').cargarSelect(0);
		$('#nombre_barrio').cargarInput('');
		$('#id_municipio_barrio').focus();
		
		$('#span_barrio').text('');
		$('#guardar_barrio').attr('value', 'Buscar');
		$('#nuevo_barrio').hide();		
		$('#eliminar_barrio').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarBarrio=function(respuesta){
		$('#tabla_barrio').empty();
		$('#form_barrio').find('.input_error').removeClass('input_error');
		$('#id_barrio').cargarInput(respuesta.id[0]);	
		$('#id_municipio_barrio').cargarSelect(respuesta.idMunicipio[0]);	
		$('#nombre_barrio').cargarInput(respuesta.nombre[0]);
				
		$('#span_barrio').html(respuesta.nombre[0]);
		$('#guardar_barrio').attr('value', 'Guardar');
		$('#nuevo_barrio').hide();		
		$('#eliminar_barrio').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaBarrio=function(respuesta){
		$('#tabla_barrio').empty();
		$('#tabla_barrio').append('<thead><tr><th width="10%"></th><th width="90%">Nombre Barrio</th><tbody id="tbody_barrio"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_barrio').append('<tr id="'+respuesta.id[i]+'" class="cargar_barrio" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}	
		$('#tabla_barrio').tablesorter({widgets: ['zebra']});		
	}
})(jQuery);
(function($){	
    $.fn.barrio=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_barrio').obligatorio()) || ($('#id_municipio_barrio').obligatorio() && $('#nombre_barrio').obligatorio())){			
			$("#guardar_barrio").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_barrio').cargarInput(opc);													
			var datos = $('#form_barrio').serialize();			
			$.getJSON('php/barrio.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarBarrio(respuesta);
											$('#error').html('Barrio cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarBarrio();
											$('#error').html('Barrio eliminado correctamente');
											break;				
							case 'guardar':	$.fn.limpiarBarrio();
											$.fn.tablaBarrio(respuesta);
											$('#error').html('Barrio guardado correctamente');
											break;
							case 'nuevo':	$.fn.limpiarBarrio();
											$.fn.tablaBarrio(respuesta);
											$('#error').html('Barrio creado correctamente');
											break;
							case 'tabla':	$.fn.tablaBarrio(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_barrio').show();
											else	
												$('#nuevo_barrio').hide();
											$('#error').html('Barrios Encontrados');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_barrio').empty();
											$('#nuevo_barrio').show();
											$('#error').html('No se encontro ningun Barrio con ese nombre, desea crear uno nuevo');
											break;
							case 'eliminar':$('#error').html('Error al eliminar el Barrio');
											break;				
							case 'guardar':	$.fn.cargarBarrio(respuesta);
											$('#error').html('Error al guardar el Barrio');
											break;
							case 'nuevo':	$('#error').html('Error al crear el Barrio');
											break;
							case 'tabla':	$('#tabla_barrio').empty();
											$('#nuevo_barrio').show();
											$('#error').html('No se encontro ningun Barrio con ese nombre, desea crear uno nuevo');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_barrio").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_barrio").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - barrio"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarColegio=function(){	
		$('#form_colegio').find('.input_error').removeClass('input_error');
		$('#id_colegio').cargarInput('');
		$('#id_municipio_colegio').cargarSelect(0);
		$('#nombre_colegio').cargarInput('');
		$('#id_municipio_colegio').focus();
		
		$('#span_colegio').text('');
		$('#guardar_colegio').attr('value', 'Buscar');
		$('#nuevo_colegio').hide();		
		$('#eliminar_colegio').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarColegio=function(respuesta){
		$('#tabla_colegio').empty();
		$('#form_colegio').find('.input_error').removeClass('input_error');
		$('#id_colegio').cargarInput(respuesta.id[0]);	
		$('#id_municipio_colegio').cargarSelect(respuesta.idMunicipio[0]);	
		$('#nombre_colegio').cargarInput(respuesta.nombre[0]);		
		
		$('#span_colegio').html(respuesta.nombre[0]);
		$('#guardar_colegio').attr('value', 'Guardar');
		$('#nuevo_colegio').hide();		
		$('#eliminar_colegio').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaColegio=function(respuesta){
		$('#tabla_colegio').empty();
		$('#tabla_colegio').append('<thead><tr><th width="10%"></th><th width="90%">Nombre Colegio</th><tbody id="tbody_colegio"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_colegio').append('<tr id="'+respuesta.id[i]+'" class="cargar_colegio" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}	
		$('#tabla_colegio').tablesorter({widgets: ['zebra']});		
	}
})(jQuery);
(function($){	
    $.fn.colegio=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_colegio').obligatorio()) || ($('#id_municipio_colegio').obligatorio() && $('#nombre_colegio').obligatorio())){			
			$("#guardar_colegio").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_colegio').cargarInput(opc);													
			var datos = $('#form_colegio').serialize();			
			$.getJSON('php/colegio.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarColegio(respuesta);
											$('#error').html('Colegio cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarColegio();
											$('#error').html('Colegio eliminado correctamente');
											break;				
							case 'guardar':	$.fn.limpiarColegio();
											$.fn.tablaColegio(respuesta);
											$('#error').html('Colegio guardado correctamente');
											break;
							case 'nuevo':	$.fn.limpiarColegio();
											$.fn.tablaColegio(respuesta);
											$('#error').html('Colegio creado correctamente');
											break;
							case 'tabla':	$.fn.tablaColegio(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_colegio').show();
											else	
												$('#nuevo_colegio').hide();
											$('#error').html('Colegios Encontrados');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_colegio').empty();
											$('#nuevo_colegio').show();
											$('#error').html('No se encontro ningun Colegio con ese nombre, desea crear uno nuevo');
											break;
							case 'eliminar':$('#error').html('Error al eliminar el Colegio');
											break;				
							case 'guardar':	$.fn.cargarColegio(respuesta);
											$('#error').html('Error al guardar el Colegio');
											break;
							case 'nuevo':	$('#error').html('Error al crear el Colegio');
											break;
							case 'tabla':	$('#tabla_colegio').empty();
											$('#nuevo_colegio').show();
											$('#error').html('No se encontro ningun Colegio con ese nombre, desea crear uno nuevo');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_colegio").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_colegio").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - colegio"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarSede=function(){	
		$('#form_sede').find('.input_error').removeClass('input_error');
		$('#id_sede').cargarInput('');
		$('#id_municipio_sede').cargarSelect(0);
		$('#id_colegio_sede').empty();
		$('#nombre_sede').cargarInput('');
		$('#coordinador').cargarInput('');
		$('#id_municipio_sede').focus();
		
		$('#span_sede').text('');
		$('#guardar_sede').attr('value', 'Buscar');
		$('#nueva_sede').hide();		
		$('#eliminar_sede').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarSede=function(respuesta){
		$('#tabla_sede').empty();
		$('#form_sede').find('.input_error').removeClass('input_error');
		$('#id_sede').cargarInput(respuesta.id[0]);	
		$('#id_municipio_sede').cargarSelect(respuesta.idMunicipio[0]);
		$('#id_colegio_sede').cargarSelect(respuesta.idColegio[0]);	
		$('#nombre_sede').cargarInput(respuesta.nombre[0]);
		$('#coordinador').cargarInput(respuesta.coordinador[0]);
				
		$('#span_sede').html(respuesta.nombre[0]);
		$('#guardar_sede').attr('value', 'Guardar');
		$('#nueva_sede').hide();		
		$('#eliminar_sede').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaSede=function(respuesta){
		$('#tabla_sede').empty();
		$('#tabla_sede').append('<thead><tr><th width="10%"></th><th width="90%">Nombre Sede Colegio</th><tbody id="tbody_sede"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_sede').append('<tr id="'+respuesta.id[i]+'" class="cargar_sede" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}	
		$('#tabla_sede').tablesorter({widgets: ['zebra']});		
	}
})(jQuery);
(function($){	
    $.fn.sede=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_sede').obligatorio()) || ($('#id_municipio_sede').obligatorio() && $('#id_colegio_sede').obligatorio() && $('#nombre_sede').obligatorio())){			
			$("#guardar_sede").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_sede').cargarInput(opc);													
			var datos = $('#form_sede').serialize();			
			$.getJSON('php/sede.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar':  $.fn.cargarSede(respuesta);
											$('#error').html('Sede del Colegio cargada correctamente');
											break;
							case 'eliminar':$.fn.limpiarSede();
											$('#error').html('Sede del Colegio eliminada correctamente');
											break;				
							case 'guardar':	$.fn.limpiarSede();
											$.fn.tablaSede(respuesta);
											$('#error').html('Sede del Colegio guardada correctamente');
											break;
							case 'nuevo':	$.fn.limpiarSede();
											$.fn.tablaSede(respuesta);
											$('#error').html('Sede del Colegio creada correctamente');
											break;	
							case 'tabla':	$.fn.tablaSede(respuesta);
											if(respuesta.nuevo)
												$('#nueva_sede').show();
											else	
												$('#nueva_sede').hide();
											$('#error').html('Sedes del Colegio Encontradas');														
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_sede').empty();
											$('#nueva_sede').show();
											$('#error').html('No se encontro ninguna Sede con ese nombre, desea crear una nueva');
											break;
							case 'eliminar':$('#error').html('Error al eliminar la Sede del Colegio');
											break;				
							case 'guardar':	$.fn.cargarSede(respuesta);
											$('#error').html('Error al guardar la Sede del Colegio');
											break;
							case 'nuevo':	$('#error').html('Error al crear la Sede del Colegio');
											break;	
							case 'tabla':	$('#tabla_sede').empty();
											$('#nueva_sede').show();
											$('#error').html('No se encontro ninguna Sede del Colegio con ese nombre, desea crear uno nuevo');
											break;													
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_sede").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_sede").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - sede"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarEscuela=function(){	
		$('#form_escuela').find('.input_error').removeClass('input_error');
		$('#id_escuela').cargarInput('');
		$('#nombre_escuela').cargarInput('');
		$('#nombre_escuela').focus();
		
		$('#span_escuela').text('');
		$('#guardar_escuela').attr('value', 'Buscar');
		$('#nueva_escuela').hide();		
		$('#eliminar_escuela').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarEscuela=function(respuesta){
		$('#tabla_escuela').empty();
		$('#form_escuela').find('.input_error').removeClass('input_error');
		$('#id_escuela').cargarInput(respuesta.id[0]);		
		$('#nombre_escuela').cargarInput(respuesta.nombre[0]);		
		
		$('#span_escuela').html(respuesta.nombre[0]);
		$('#guardar_escuela').attr('value', 'Guardar');
		$('#nueva_escuela').hide();		
		$('#eliminar_escuela').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaEscuela=function(respuesta){
		$('#tabla_escuela').empty();
		$('#tabla_escuela').append('<thead><tr><th width="10%"></th><th width="90%">Escuela de Formacion</th><tbody id="tbody_escuela"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_escuela').append('<tr id="'+respuesta.id[i]+'" class="cargar_escuela" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}
		$('#tabla_escuela').tablesorter({widgets: ['zebra']});			
	}
})(jQuery);
(function($){	
    $.fn.escuela=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_escuela').obligatorio()) || $('#nombre_escuela').obligatorio()){			
			$("#guardar_escuela").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_escuela').cargarInput(opc);													
			var datos = $('#form_escuela').serialize();			
			$.getJSON('php/escuela.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarEscuela(respuesta);
											$('#error').html('Escuela de Formacion cargada correctamente');
											break;
							case 'eliminar':$.fn.limpiarEscuela();
											$('#error').html('Escuela de Formacion eliminada correctamente');
											break;				
							case 'guardar':	$.fn.limpiarEscuela();
											$.fn.tablaEscuela(respuesta);
											$('#error').html('Escuela de Formacion guardada correctamente');
											break;
							case 'nuevo':	$.fn.limpiarEscuela();	
											$.fn.tablaEscuela(respuesta);									
											$('#error').html('Escuela de Formacion creada correctamente');
											break;	
							case 'tabla':	$.fn.tablaEscuela(respuesta);
											if(respuesta.nuevo)
												$('#nueva_escuela').show();
											else	
												$('#nueva_escuela').hide();
											$('#error').html('Escuelas de Formacion Encontradas');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_escuela').empty();
											$('#nueva_escuela').show();
											$('#error').html('No se encontro ninguna Escuela de Formacion con ese nombre, desea crear una nueva');
											break;
							case 'eliminar':$('#error').html('Error al eliminar la Escuela de Formacion');
											break;				
							case 'guardar':	$.fn.cargarEscuela(respuesta);
											$('#error').html('Error al guardar la Escuela de Formacion');
											break;
							case 'nuevo':	$('#error').html('Error al crear la Escuela de Formacion');
											break;	
							case 'tabla':	$('#tabla_escuela').empty();
											$('#nueva_escuela').show();
											$('#error').html('No se encontro ninguna Escuela de Formacion con ese nombre, desea crear una nueva');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_escuela").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_escuela").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - escuela"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarSitio=function(){	
		$('#form_sitio').find('.input_error').removeClass('input_error');
		$('#id_sitio').cargarInput('');
		$('#nombre_sitio').cargarInput('');
		$('#nombre_sitio').focus();
		
		$('#span_sitio').text('');
		$('#guardar_sitio').attr('value', 'Buscar');
		$('#nuevo_sitio').hide();		
		$('#eliminar_sitio').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarSitio=function(respuesta){
		$('#tabla_sitio').empty();
		$('#form_sitio').find('.input_error').removeClass('input_error');
		$('#id_sitio').cargarInput(respuesta.id[0]);		
		$('#nombre_sitio').cargarInput(respuesta.nombre[0]);		
		
		$('#span_sitio').html(respuesta.nombre[0]);
		$('#guardar_sitio').attr('value', 'Guardar');
		$('#nuevo_sitio').hide();		
		$('#eliminar_sitio').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaSitio=function(respuesta){
		$('#tabla_sitio').empty();
		$('#tabla_sitio').append('<thead><tr><th width="10%"></th><th width="90%">Sitio de Trabajo</th><tbody id="tbody_sitio"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_sitio').append('<tr id="'+respuesta.id[i]+'" class="cargar_sitio" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}	
		$('#tabla_sitio').tablesorter({widgets: ['zebra']});		
	}
})(jQuery);
(function($){	
    $.fn.sitio=function(opc){		
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_sitio').obligatorio()) || $('#nombre_sitio').obligatorio()){			
			$("#guardar_sitio").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_sitio').cargarInput(opc);													
			var datos = $('#form_sitio').serialize();			
			$.getJSON('php/sitio.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarSitio(respuesta);
											$('#error').html('Sitio de Trabajo cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarSitio();
											$('#error').html('Sitio de Trabajo eliminado correctamente');
											break;				
							case 'guardar':	$.fn.limpiarSitio();
											$.fn.tablaSitio(respuesta);
											$('#error').html('Sitio de Trabajo guardado correctamente');
											break;
							case 'nuevo':	$.fn.limpiarSitio();
											$.fn.tablaSitio(respuesta);
											$('#error').html('Sitio de Trabajo creado correctamente');
											break;
							case 'tabla':	$.fn.tablaSitio(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_sitio').show();
											else	
												$('#nuevo_sitio').hide();
											$('#error').html('Sitios de Trabajo Encontrados');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_sitio').empty();
											$('#nuevo_sitio').show();
											$('#error').html('No se encontro ningun Sitio de Trabajo con ese nombre, desea crear uno nuevo');
											break;
							case 'eliminar':$('#error').html('Error al eliminar el Sitio de Trabajo');
											break;				
							case 'guardar':	$.fn.cargarSitio(respuesta);
											$('#error').html('Error al guardar el Sitio de Trabajo');
											break;
							case 'nuevo':	$('#error').html('Error al crear el Sitio de Trabajo');
											break;
							case 'tabla':	$('#tabla_sitio').empty();
											$('#nuevo_sitio').show();
											$('#error').html('No se encontro ningun Sitio de Trabajo con ese nombre, desea crear uno nuevo');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_sitio").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_sitio").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - sitio"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarUsuario=function(){	
		$('#form_usuario').find('.input_error').removeClass('input_error');
		$('#id_usuario').cargarInput('');		
		$('#usuario').cargarInput('');
		$('#tipo_usuario').cargarSelect(0);
		$('#nombre_usuario').cargarInput('');		
		$('#usuario').focus();
		
		$('#span_usuario').text('');
		$('#guardar_usuario').attr('value', 'Buscar');
		$('#nuevo_usuario').hide();		
		$('#eliminar_usuario').hide();
	}
})(jQuery);
(function($){	
    $.fn.cargarUsuario=function(respuesta){
		$('#tabla_usuario').empty();
		$('#form_usuario').find('.input_error').removeClass('input_error');
		$('#id_usuario').cargarInput(respuesta.id[0]);				
		$('#usuario').cargarInput(respuesta.nombreUser[0]);
		$('#tipo_usuario').cargarSelect(respuesta.tipoUser[0]);
		$('#nombre_usuario').cargarInput(respuesta.nombre[0]);		
		
		$('#span_usuario').html(respuesta.nombre[0]);
		$('#guardar_usuario').attr('value', 'Guardar');
		$('#nuevo_usuario').hide();		
		$('#eliminar_usuario').show();
	}
})(jQuery);
(function($){	
    $.fn.tablaUsuario=function(respuesta){
		$('#tabla_usuario').empty();
		$('#tabla_usuario').append('<thead><tr><th width="10%"></th><th width="90%">Nombre Usuario</th><tbody id="tbody_usuario"></tbody>');
		for(i=0; i<respuesta.id.length; i++){
			$('#tbody_usuario').append('<tr id="'+respuesta.id[i]+'" class="cargar_usuario" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+(i+1)+'</td><td>'+respuesta.nombre[i]+'</td></tr>');	
		}	
		$('#tabla_usuario').tablesorter({widgets: ['zebra']});		
	}
})(jQuery);
(function($){	
    $.fn.usuario=function(opc){	
		if(((opc == 'eliminar' || opc == 'cargar') && $('#id_usuario').obligatorio()) || $('#usuario').obligatorio()){			
			$("#guardar_usuario").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_usuario').cargarInput(opc);													
			var datos = $('#form_usuario').serialize();			
			$.getJSON('php/usuario.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarUsuario(respuesta);
											$('#error').html('Usuario cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarUsuario();
											$('#error').html('Usuario eliminado correctamente');
											break;				
							case 'guardar':	$.fn.limpiarUsuario();
											$.fn.tablaUsuario(respuesta);
											$('#error').html('Usuario guardado correctamente');
											break;
							case 'nuevo':	$.fn.limpiarUsuario();
											$.fn.tablaUsuario(respuesta);
											$('#error').html('Usuario creado correctamente');
											break;	
							case 'tabla':	$.fn.tablaUsuario(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_usuario').show();
											else	
												$('#nuevo_usuario').hide();
											$('#error').html('Usuarios Encontrados');
											break;														
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_usuario').empty();
											$('#nuevo_usuario').show();
											$('#error').html('No se encontro ningun Usuario con ese nombre, desea crear uno nuevo');
											break;
							case 'eliminar':$('#error').html('Error al eliminar el Usuario');
											break;				
							case 'guardar':	$.fn.cargarUsuario(respuesta);
											$('#error').html('Error al guardar el Usuario');
											break;
							case 'nuevo':	$('#error').html('Error al crear el Usuario');
											break;
							case 'tabla':	$('#tabla_usuario').empty();
											$('#nuevo_usuario').show();
											$('#error').html('No se encontro ningun Usuario con ese nombre, desea crear uno nuevo');
											break;													
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_usuario").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_usuario").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - usuario"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarPasswd=function(){	
		$('#form_passwd').find('.input_error').removeClass('input_error');
		$('#passwd').cargarInput('');		
		$('#passwd_new').cargarInput('');		
		$('#passwd_new2').cargarInput('');
		$('#email').cargarInput('');
		$('#div_passwd').hide();
	}
})(jQuery);
(function($){	
    $.fn.passwd=function(opc){	
		if((opc == 'cargar' && $('#id_usuario_passwd').obligatorio()) || (opc == 'passwd' && $('#passwd').obligatorio() && $('#passwd_new').diferente('passwd_new2') && $('#email').correo())){			
			$("#guardar_passwd").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_passwd').cargarInput(opc);													
			var datos = $('#form_passwd').serialize();			
			$.getJSON('php/usuario.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar':	$('#email').cargarInput(respuesta.email[0]);
											break;							
							case 'passwd':	$.fn.limpiarPasswd();
											$('#error').html('Contraseña cambiada correctamente');
											break;											
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#email').cargarInput('');
											break;						
							case 'passwd':	$('#error').html('Error al cambiar la contraseña');
											break;										
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}	
				$("#guardar_passwd").removeAttr("disabled");			
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_passwd").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - passwd"); 
			});	
		}
    }
})(jQuery);

$(document).ready(function(){
	/*
	$(window).bind('beforeunload', function(){
		return 'Estas seguro de continuar';
	});
	*/	
	$.getJSON('php/perfil.php', function(respuesta){
		if(respuesta.login){
			if(respuesta.perfil == 0){
				$('li').hide();
				$('#consulta').show();
				$('input, select').attr('disabled', 'disabled');
			}
			else
				$('#menu').show();	
			if(respuesta.perfil == 3){
				//$('#li_importar').show();				
				$('#li_usuario').show();
			}
			$('#li_exportar').show();
			
			if(respuesta.perfil > 1)
				$('#li_asignar').show();
				
			$('#nombre_user').html(respuesta.user); 
			$('#id_usuario_passwd').attr('value', respuesta.id); 
			$.fn.listaYear();	
			$.fn.lista('id_departamento_municipio','php/departamento.php','');		
			$.fn.lista('id_municipio_barrio','php/municipio.php','');
			$.fn.lista('id_departamento_exportar','php/departamento.php','');
			$.fn.lista('id_municipio_listado','php/municipio.php','');
			$.fn.lista('id_municipio_colegio','php/municipio.php','');
			$.fn.lista('id_municipio_sede','php/municipio.php','');						
		}
		else{
			$(window).off('beforeunload');
			$(location).attr('href', 'index.php');
		}	
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});
	
	$("#importar").click(function(event){	
		//alert("Opcion Deshabilitada");
			
		if($("#file_importar").obligatorio()){
			if(confirm('Desea importar la Informacion para el año: '+$("#year_importar").attr('value'))){
				$("#cargando").show();
				$("#form_importar").submit();
			}
		}		
	});
		
	$("#asignar").click(function(event){
		if($("#file_asignar").obligatorio()){
			if(confirm('Desea asignar los usuarios')){	
				$("#cargando").show();
				$("#form_asignar").submit();
			}
		}
	});	
	
	$("#exportar").click(function(event){
		var year = $('#year_exportar').attr('value');
		var departamento = $('#id_departamento_exportar').attr('value');
		if($("#id_departamento_exportar").obligatorio())		
			window.location = 'xls/exportar.php?year='+year+'&id_departamento='+departamento;
	});
	
	$("#exportar_act").click(function(event){
		var year = $('#year_exportar').attr('value');
		var departamento = $('#id_departamento_exportar').attr('value');
		var periodo = $('#id_periodo_exportar').attr('value');
		if($("#id_departamento_exportar").obligatorio() && $("#id_periodo_exportar").obligatorio())		
			window.location = 'xls/exportar_act.php?year='+year+'&id_departamento='+departamento+'&id_periodo='+periodo;
	});
	
	$("#exportar_ti").click(function(event){
		var year = $('#year_exportar').attr('value');
		var departamento = $('#id_departamento_exportar').attr('value');
		var actividad = $('#id_actividad_exportar').attr('value');		
		if($("#id_departamento_exportar").obligatorio() && $("#id_actividad_exportar").obligatorio())
			window.location = 'xls/exportar_ti.php?year='+year+'&id_departamento='+departamento+'&id_actividad='+actividad;
	});
		
	$("#listado_pdf").click(function(event){
		if($("#id_municipio_listado").obligatorio() && $("#id_colegio_listado").obligatorio()){
			var year = $('#year_listado').attr('value');
			var municipio = $('#id_municipio_listado').attr('value');
			var colegio = $('#id_colegio_listado').attr('value');		
			window.open('pdf/listado.php?year='+year+'&id_municipio='+municipio+'&id_colegio='+colegio,'Listado');
		}
	});
	
	$("#id_municipio_listado").live('change', function(event){
		$.fn.lista('id_colegio_listado','php/colegio.php',$(this).attr('value')); 		
	});
	
	$("#form_actividad").submit(function(event){
		event.preventDefault();
		$.fn.actividad('guardar');
	});	
	$("#nueva_actividad").click(function(event){
		$.fn.actividad('nuevo');
	});	
	$("#cancelar_actividad").click(function(event){
		$.fn.limpiarActividad();
	});	
	$("#eliminar_actividad").click(function(event){
		if(confirm('Desea eliminar la Actividad Laboral!'))
			$.fn.actividad('eliminar');
	});
	$("#actualizar_actividad").click(function(event){
		$.fn.actividad('cargar');
	});
	$(".cargar_actividad").live('click', function(event){
		$('#id_actividad').attr('value', $(this).attr('id'));
		$.fn.actividad('cargar');
	});
	
	$("#form_ars").submit(function(event){
		event.preventDefault();
		$.fn.ars('guardar');
	});	
	$("#nueva_ars").click(function(event){
		$.fn.ars('nuevo');
	});	
	$("#cancelar_ars").click(function(event){
		$.fn.limpiarArs();
	});	
	$("#eliminar_ars").click(function(event){
		if(confirm('Desea eliminar la ARS!'))
			$.fn.ars('eliminar');
	});
	$("#actualizar_ars").click(function(event){
		$.fn.ars('cargar');
	});
	$(".cargar_ars").live('click', function(event){
		$('#id_ars').attr('value', $(this).attr('id'));
		$.fn.ars('cargar');
	});
	
	$("#form_departamento").submit(function(event){
		event.preventDefault();
		$.fn.departamento('guardar');
	});	
	$("#nuevo_departamento").click(function(event){
		$.fn.departamento('nuevo');
	});	
	$("#cancelar_departamento").click(function(event){
		$.fn.limpiarDepartamento();
	});	
	$("#eliminar_departamento").click(function(event){
		if(confirm('Desea eliminar el Departamento!'))
			$.fn.departamento('eliminar');
	});
	$("#actualizar_departamento").click(function(event){
		$.fn.departamento('cargar');
	});
	$(".cargar_departamento").live('click', function(event){
		$('#id_departamento').attr('value', $(this).attr('id'));
		$.fn.departamento('cargar');
	});
	
	$("#form_municipio").submit(function(event){
		event.preventDefault();
		$.fn.municipio('guardar');
	});	
	$("#nuevo_municipio").click(function(event){
		$.fn.municipio('nuevo');
	});	
	$("#cancelar_municipio").click(function(event){
		$.fn.limpiarMunicipio();
	});	
	$("#eliminar_municipio").click(function(event){
		if(confirm('Desea eliminar el Municipio!'))
			$.fn.municipio('eliminar');
	});
	$("#actualizar_municipio").click(function(event){
		$.fn.municipio('cargar');
	});
	$(".cargar_municipio").live('click', function(event){
		$('#id_municipio').attr('value', $(this).attr('id'));
		$.fn.municipio('cargar');
	});
	
	$("#form_barrio").submit(function(event){
		event.preventDefault();
		$.fn.barrio('guardar');
	});	
	$("#nuevo_barrio").click(function(event){
		$.fn.barrio('nuevo');
	});	
	$("#cancelar_barrio").click(function(event){
		$.fn.limpiarBarrio();
	});	
	$("#eliminar_barrio").click(function(event){
		if(confirm('Desea eliminar el Barrio!'))
			$.fn.barrio('eliminar');
	});
	$("#actualizar_barrio").click(function(event){
		$.fn.barrio('cargar');
	});
	$(".cargar_barrio").live('click', function(event){
		$('#id_barrio').attr('value', $(this).attr('id'));
		$.fn.barrio('cargar');
	});
	
	$("#form_colegio").submit(function(event){
		event.preventDefault();
		$.fn.colegio('guardar');
	});	
	$("#nuevo_colegio").click(function(event){
		$.fn.colegio('nuevo');
	});	
	$("#cancelar_colegio").click(function(event){
		$.fn.limpiarColegio();
	});	
	$("#eliminar_colegio").click(function(event){
		if(confirm('Desea eliminar el Colegio!'))
			$.fn.colegio('eliminar');
	});
	$("#actualizar_colegio").click(function(event){
		$.fn.colegio('cargar');
	});
	$(".cargar_colegio").live('click', function(event){
		$('#id_colegio').attr('value', $(this).attr('id'));
		$.fn.colegio('cargar');
	});
	
	$("#form_sede").submit(function(event){
		event.preventDefault();
		$.fn.sede('guardar');
	});	
	$("#nueva_sede").click(function(event){
		$.fn.sede('nuevo');
	});	
	$("#cancelar_sede").click(function(event){
		$.fn.limpiarSede();
	});	
	$("#eliminar_sede").click(function(event){
		if(confirm('Desea eliminar la Sede!'))
			$.fn.sede('eliminar');
	});
	$("#actualizar_sede").click(function(event){
		$.fn.sede('cargar');
	});
	$(".cargar_sede").live('click', function(event){
		$('#id_sede').attr('value', $(this).attr('id'));
		$.fn.sede('cargar');
	});
	
	$("#form_escuela").submit(function(event){
		event.preventDefault();
		$.fn.escuela('guardar');
	});	
	$("#nueva_escuela").click(function(event){
		$.fn.escuela('nuevo');
	});	
	$("#cancelar_escuela").click(function(event){
		$.fn.limpiarEscuela();
	});	
	$("#eliminar_escuela").click(function(event){
		if(confirm('Desea eliminar la Escuela!'))
			$.fn.escuela('eliminar');
	});
	$("#actualizar_escuela").click(function(event){
		$.fn.escuela('cargar');
	});
	$(".cargar_escuela").live('click', function(event){
		$('#id_escuela').attr('value', $(this).attr('id'));
		$.fn.escuela('cargar');
	});
	
	$("#form_sitio").submit(function(event){
		event.preventDefault();
		$.fn.sitio('guardar');
	});	
	$("#nuevo_sitio").click(function(event){
		$.fn.sitio('nuevo');
	});	
	$("#cancelar_sitio").click(function(event){
		$.fn.limpiarSitio();
	});	
	$("#eliminar_sitio").click(function(event){
		if(confirm('Desea eliminar el Sitio de Trabajo!'))
			$.fn.sitio('eliminar');
	});
	$("#actualizar_sitio").click(function(event){
		$.fn.sitio('cargar');
	});
	$(".cargar_sitio").live('click', function(event){
		$('#id_sitio').attr('value', $(this).attr('id'));
		$.fn.sitio('cargar');
	});
	
	$("#form_usuario").submit(function(event){
		event.preventDefault();
		$.fn.usuario('guardar');
	});	
	$("#nuevo_usuario").click(function(event){
		$.fn.usuario('nuevo');
	});	
	$("#cancelar_usuario").click(function(event){
		$.fn.limpiarUsuario();
	});	
	$("#eliminar_usuario").click(function(event){
		if(confirm('Desea eliminar el Usuario!'))
			$.fn.usuario('eliminar');
	});
	$("#actualizar_usuario").click(function(event){
		$.fn.usuario('cargar');
	});
	$(".cargar_usuario").live('click', function(event){
		$('#id_usuario').attr('value', $(this).attr('id'));
		$.fn.usuario('cargar');
	});
	
	$("#form_passwd").submit(function(event){
		event.preventDefault();
		$.fn.passwd('passwd');
	});		
	$("#cancelar_passwd").click(function(event){
		$.fn.limpiarPasswd();		
	});
	
	$("#id_municipio_sede").live('change', function(event){
		$.fn.lista('id_colegio_sede','php/colegio.php',$(this).attr('value')); 		
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
		
		if(event.keyCode==27){
			$('#cancelar_actividad').click();
			$('#cancelar_ars').click();
			$('#cancelar_passwd').click();
			$('#cancelar_escuela').click();
			$('#cancelar_municipio').click();
			$('#cancelar_barrio').click();
			$('#cancelar_colegio').click();
			$('#cancelar_sede').click();
			$('#cancelar_sitio').click();
			$('#cancelar_usuario').click();
		}
	});
			
	$("#cargando").delay(400).slideUp(0);
});