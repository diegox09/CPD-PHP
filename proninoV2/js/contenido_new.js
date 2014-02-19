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
    $.fn.lista=function(nombre, ruta, lista, seleccionar, remover){
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
						
					if(remover != '')	
						$('#'+nombre).find('option[value="'+remover+'"]').remove();
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
		
		$('#year').empty();		
		for(var i=2011; i<=year; i++)
			$('#year').append('<option value="'+i+'" >'+i+'</option>');		
		
		$('#year_buscar').cargarInput(year);
		$('#year').cargarSelect(year);
		$('#id_mes').cargarSelect(mes);
		$.fn.cambiarMes();	
    }
})(jQuery);

(function($){	
    $.fn.buscar=function(opc){		
		if($('#input_buscar').obligatorio() || $('#id_municipio_buscar').obligatorio()){
			$("#buscar").attr("disabled","disabled");			
			$('#cargando').show();	
			$('#busqueda').empty();
			$('#opc_buscar').cargarInput(opc);													
			var datos = $('#form_buscar').serialize();			
			$.getJSON('php/buscar.php', datos, function(respuesta) {
				var estado = ['', 'ACTIVO', 'INACTIVO'];
				if(respuesta.login){
					$('#busqueda').append('<thead><tr><th width="5%">Item</th><th width="10%">Documento</th><th width="30%">Nombre Beneficiario</th><th width="10%">Municipio</th><th width="37%">Colegio</th><th width="8%">Estado</th></tr></thead><tbody id="beneficiarios"></tbody>');
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'buscar': 	for(i=0; i<respuesta.idBeneficiario.length; i++){
												$('#beneficiarios').append('<tr id="'+respuesta.idBeneficiario[i]+'" class="ver_beneficiario"><td>'+respuesta.idItem[i]+'</td><td>'+respuesta.documentoBeneficiario[i]+'</td><td>'+respuesta.nombreBeneficiario[i]+'</td><td>'+respuesta.nombreMunicipio[i]+'</td><td>'+respuesta.nombreColegio[i]+'</td><td>'+estado[respuesta.estado[i]]+'</td></tr>');	
											}	
											$('#error').html('Resultado de la consulta: '+i+' beneficiario(s)');
											break;			
						}
						
						$('#busqueda').tablesorter({widgets: ['zebra']});								
					}
					else{
						switch(respuesta.opc){
							case 'buscar':	$('#beneficiarios').append('<tr><td colspan="6" class="center">No se existe ningun beneficiario registrado en el programa proniño con ese numero de documento o ese nombre</td></tr>');
											$('#error').html('No se existe ningun beneficiario con ese numero de documento o ese nombre');	 
											break;			
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
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
    }
})(jQuery);

(function($){	
    $.fn.verBeneficiario=function(id){	
		$('#id_beneficiario').cargarInput(id);
		$.fn.beneficiario('cargar');		
		$('#busqueda_beneficiario').hide();
		$('#info_beneficiario').show();
	}
})(jQuery);

(function($){	
    $.fn.limpiarGenerico=function(){	
		$('#form_generico').find('.input_error').removeClass('input_error');	
		$('#id_generico').cargarInput('');
		$('#opc_generico').cargarInput('');
		$('#nombres_generico').cargarInput('');
		$('#apellidos_generico').cargarInput('');		
		$('#td_generico').cargarSelect(0);
		$('#documento_beneficiario_generico').cargarInput('');
		$('#fecha_nacimiento').cargarInput('');
		$('#edad_generico').cargarInput('');
		$('#genero_generico').cargarSelect(0);
		$('#telefono_generico').cargarInput('');
		$('#direccion_generico').cargarInput('');
		$('#id_municipio_generico').cargarSelect(0);
		$('#id_barrio_generico').empty();	
		$('#fecha_actualizacion_generico').html('-');
		$('#usuario_actualizo_generico').html('-');
		
		$('#guardar_generico').attr('value', 'Buscar');		
		$('#nuevo_generico').hide();		
		$('#eliminar_generico').hide();
	}
})(jQuery);

(function($){	
    $.fn.cargarGenerico=function(respuesta){
		$('#form_generico').find('.input_error').removeClass('input_error');		
		$('#id_generico').cargarInput(respuesta.idBeneficiario);	
				
		$('#nombres_generico').cargarInput(respuesta.nombreBeneficiario);
		$('#apellidos_generico').cargarInput(respuesta.apellidoBeneficiario);		
		$('#td_generico').cargarSelect(respuesta.td);
		$('#documento_beneficiario_generico').cargarInput(respuesta.documentoBeneficiario);
		$('#fecha_nacimiento_generico').cargarInput(respuesta.fechaNacimiento);
		$('#edad_generico').cargarInput(respuesta.edad);
		$('#genero_generico').cargarSelect(respuesta.genero);
		$('#telefono_generico').cargarInput(respuesta.telefono);
		$('#direccion_generico').cargarInput(respuesta.direccion);
		$('#id_municipio_generico').cargarSelect(respuesta.idMunicipio);
		if(respuesta.idBarrio == 0)
			$.fn.lista('id_barrio_generico','php/barrio.php',respuesta.idMunicipio); 
		else	
			$.fn.lista('id_barrio_generico','php/barrio.php',respuesta.idMunicipio,respuesta.idBarrio); 
		
		$('#fecha_actualizacion_generico').html(respuesta.fechaActualizacion[0]);
		$('#usuario_actualizo_generico').html(respuesta.nombreUser[0]);
		
		if(respuesta.perfil > 0){					
			if(respuesta.pronino){		
				$('#nuevo_generico').hide();
				$('#eliminar_generico').show();
			}
			else{			
				$('#eliminar_generico').hide();
				$('#nuevo_generico').show();
			}
		}
						
		$('#guardar_generico').attr('value', 'Guardar');
	}
})(jQuery);

(function($){	
    $.fn.tablaGenerico=function(respuesta){	
		$('#tabla_generico').empty();
		
		if(respuesta.opc == 'nuevo'){
			$('#input_buscar').cargarInput($('#documento_beneficiario_generico').attr('value'));
			$.fn.buscar('buscar');
			$('#overlay').hide();
			$('#generico').hide();
			$('#input_buscar').focus();	
		}
		else{
			$('#tabla_generico').append('<thead><tr><th width="10%"></th><th width="30%">Documento</th><th width="30%">Nombres</th><th width="30%">Apellidos</th></tr></thead><tbody id="desc_generico"></tbody>');
			for(i=0; i<respuesta.idBeneficiario.length; i++){
				$('#desc_generico').append('<tr id="'+respuesta.idBeneficiario[i]+'" class="cargar_generico"><td>'+(i+1)+'</td><td>'+respuesta.documentoBeneficiario[i]+'</td><td>'+respuesta.nombreBeneficiario[i]+'</td><td>'+respuesta.apellidoBeneficiario[i]+'</td></tr>');	
			}
			$('#tabla_generico').tablesorter({widgets: ['zebra']});	
		}
	}
})(jQuery);

(function($){	
    $.fn.nuevoGenerico=function(respuesta){	
		if(respuesta.tipo == 'beneficiario'){
			$('#overlay').hide();
			$('#generico').hide();
			if($('#info_beneficiario').is (':visible') && respuesta.opc != 'eliminar')
				$.fn.beneficiario('cargar');
			else{
				$('#input_buscar').cargarInput($('#documento_beneficiario_generico').attr('value'));
				$.fn.buscar('buscar');
				$('#info_beneficiario').hide();
				$('#busqueda_beneficiario').show();
				$('#input_buscar').focus();	
			}
		}
		if(respuesta.tipo == 'acudiente'){
			$.fn.beneficiario('cargar');			
			$('#overlay').hide();
			$('#generico').hide();
		}
		$('#tabla_generico').empty();
		$.fn.limpiarGenerico();			
	}
})(jQuery);

(function($){	
    $.fn.generico=function(opc){		
		if(((opc == 'cargar' || opc == 'eliminar') && $('#id_generico').obligatorio()) || (opc == 'nuevo' && $('#documento_beneficiario_generico').numero()) || (!$('#id_generico').obligatorio() && ($('#documento_beneficiario_generico').numero() || $('#nombres_generico').obligatorio() || $('#apellidos_generico').obligatorio())) || ($('#documento_beneficiario_generico').numero() && $('#nombres_generico').obligatorio() && $('#apellidos_generico').obligatorio())){
			$("#guardar_generico").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_generico').cargarInput(opc);													
			var datos = $('#form_generico').serialize();			
			$.getJSON('php/generico.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarGenerico(respuesta);
											$('#error').html('Informacion cargada correctamente');
											break;
							case 'eliminar':$.fn.nuevoGenerico(respuesta);
											$('#error').html('Persona eliminada correctamente');
											break;				
							case 'guardar':	$.fn.nuevoGenerico(respuesta);
											$('#error').html('Informacion guardada correctamente');
											break;
							case 'nuevo':	$.fn.nuevoGenerico(respuesta);
											$('#error').html('Persona creada correctamente');
											break;
							case 'tabla':	$.fn.tablaGenerico(respuesta);
											if(respuesta.nuevo)
												$('#nuevo_generico').show();
											else	
												$('#nuevo_generico').hide();
											$('#error').html('Personas Encontradas');
											break;															
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$('#tabla_generico').empty();
											$('#nuevo_generico').show();
											$('#error').html('No se encontro ninguna persona con esa informacion, desea crear una nueva');
											break;
							case 'eliminar':$('#error').html('Error al eliminar la Persona');
											break;				
							case 'guardar':	$.fn.cargarGenerico(respuesta);
											$('#error').html('Error al guardar la Informacion');
											break;
							case 'nuevo':	$('#error').html('Error al crear la Persona');
											break;
							case 'tabla':	$('#tabla_generico').empty();
											$('#nuevo_generico').show();
											$('#error').html('No se encontro ninguna persona con esa informacion, desea crear una nueva');
											break;														
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}
				$("#guardar_generico").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_generico").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - generico"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarBeneficiario=function(){	
		$('#form_beneficiario').find('.input_error').removeClass('input_error');	
		$('#id_beneficiario').cargarInput('');
		
		$('#id_beneficiario_pronino').cargarInput('');		
		$('#id_beneficiario_year').cargarInput('');
		$('#id_beneficiario_nota').cargarInput('');
		$('#id_beneficiario_mes').cargarInput('');
		$('#id_beneficiario_diagnostico').cargarInput('');
		$('#id_beneficiario_seguimiento').cargarInput('');
		$('#id_beneficiario_psicosocial').cargarInput('');
				
		$('#nombres').cargarInput('');
		$('#apellidos').cargarInput('');		
		$('#td').cargarSelect(0);
		$('#documento_beneficiario').cargarInput('');
		$('#fecha_nacimiento').cargarInput('');
		$('#edad').cargarInput('');
		$('#genero').cargarSelect(0);
		$('#telefono').cargarInput('');
		$('#direccion').cargarInput('');
		$('#id_municipio').cargarSelect(0);
		$('#id_barrio').empty();	
		$('#fecha_actualizacion').html('-');
		$('#usuario_actualizo').html('-');
		
		$.fn.limpiarPronino();
	}
})(jQuery);

(function($){	
    $.fn.cargarBeneficiario=function(respuesta){
		$('#form_beneficiario').find('.input_error').removeClass('input_error');		
		$('#id_beneficiario').cargarInput(respuesta.idBeneficiario);		
		
		$('#id_beneficiario_pronino').cargarInput(respuesta.idBeneficiario);
		$('#id_beneficiario_year').cargarInput(respuesta.idBeneficiario);
		$('#id_beneficiario_nota').cargarInput(respuesta.idBeneficiario);
		$('#id_beneficiario_mes').cargarInput(respuesta.idBeneficiario);
		$('#id_beneficiario_diagnostico').cargarInput(respuesta.idBeneficiario);
		$('#id_beneficiario_seguimiento').cargarInput(respuesta.idBeneficiario);
		$('#id_beneficiario_psicosocial').cargarInput(respuesta.idBeneficiario);
				
		$('#nombres').cargarInput(respuesta.nombreBeneficiario);
		$('#apellidos').cargarInput(respuesta.apellidoBeneficiario);		
		$('#td').cargarSelect(respuesta.td);
		$('#documento_beneficiario').cargarInput(respuesta.documentoBeneficiario);
		$('#fecha_nacimiento').cargarInput(respuesta.fechaNacimiento);
		$('#edad').cargarInput(respuesta.edad);
		$('#genero').cargarSelect(respuesta.genero);
		$('#telefono').cargarInput(respuesta.telefono);
		$('#direccion').cargarInput(respuesta.direccion);
		$('#id_municipio').cargarSelect(respuesta.idMunicipio);
		if(respuesta.idBarrio == 0)
			$.fn.lista('id_barrio','php/barrio.php',respuesta.idMunicipio); 
		else	
			$.fn.lista('id_barrio','php/barrio.php',respuesta.idMunicipio,respuesta.idBarrio); 
		
		$('#fecha_actualizacion').html(respuesta.fechaActualizacion);
		$('#usuario_actualizo').html(respuesta.nombreUser);		
		
		if(respuesta.opc == 'cargar')
			$.fn.pronino('cargar');
		else
			$('#actualizar').focus();	
	}
})(jQuery);

(function($){	
    $.fn.beneficiario=function(opc){		
		if((opc == 'cargar' && $('#id_beneficiario').obligatorio()) || (opc == 'guardar' && $('#id_beneficiario').obligatorio() && $('#documento_beneficiario').numero())){
			$("#guardar_beneficiario").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_beneficiario').cargarInput(opc);													
			var datos = $('#form_beneficiario').serialize();			
			$.getJSON('php/beneficiario.php', datos, function(respuesta){
				if(respuesta.login){
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarBeneficiario(respuesta);
											$('#error').html('Beneficiario cargado correctamente');
											break;		
							case 'guardar':	$.fn.cargarBeneficiario(respuesta);
											$('#error').html('Beneficiario guardado correctamente');
											break;				
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarBeneficiario();
											$('#error').html('Error al cargar el beneficiario');
											break;					
							case 'guardar':	$.fn.cargarBeneficiario(respuesta);
											$('#error').html('Error al guardar el beneficiario');
											break;				
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}
				$("#guardar_beneficiario").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_beneficiario").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - beneficiario"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarPronino=function(){	
		$('#form_beneficiario_pronino').find('.input_error').removeClass('input_error');
		
		$('#item').cargarInput('');
		$('#talla_uniforme').cargarSelect(0);
		$('#talla_zapato').cargarSelect(0);
		$('#sisben').cargarSelect(0);
		$('#id_ars').cargarSelect(0);
		$('#id_usuario1').cargarSelect(0);
		$('#id_usuario2').cargarSelect(0);
		
		$('#id_acudiente').cargarInput('');
		$('#documento_acudiente').cargarInput('');
		$('#nombre_acudiente').cargarInput('');
		
		$('#fecha_actualizacion_pronino').html('-');
		$('#usuario_actualizo_pronino').html('-');
		$('#fecha_ingreso').cargarInput('-');
		$('#id_estado').cargarSelect(0);
		$('#fecha_retiro').cargarInput('');
		$('#razon_retiro').cargarSelect(0);
		
		$.fn.limpiarYear();
	}
})(jQuery);

(function($){	
    $.fn.cargarPronino=function(respuesta){
		$('#form_beneficiario').find('.input_error').removeClass('input_error');
		
		$('#item').cargarInput(respuesta.idItem);
		$('#talla_uniforme').cargarSelect(respuesta.tallaUniforme);
		$('#talla_zapato').cargarSelect(respuesta.tallaZapato);
		$('#sisben').cargarSelect(respuesta.sisben);
		$('#id_ars').cargarSelect(respuesta.idArs);
		$('#id_usuario1').cargarSelect(respuesta.idUsuario1);
		$('#id_usuario2').cargarSelect(respuesta.idUsuario2);
		
		$('#id_acudiente').cargarInput(respuesta.idAcudiente);
		$('#documento_acudiente').cargarInput(respuesta.documentoAcudiente);
		$('#nombre_acudiente').cargarInput(respuesta.nombreAcudiente);
		
		$('#fecha_actualizacion_pronino').html(respuesta.fechaActualizacion);
		$('#usuario_actualizo_pronino').html(respuesta.nombreUser);
		$('#fecha_ingreso').cargarInput(respuesta.fechaIngreso);
		$('#id_estado').cargarSelect(respuesta.estado);
		$('#fecha_retiro').cargarInput(respuesta.fechaRetiro);
		$('#razon_retiro').cargarSelect(respuesta.razonRetiro);
		if(respuesta.estado == 2)
			$('.retirado').css('visibility', 'visible');
		else
			$('.retirado').css('visibility', 'hidden');
		
		$.fn.year('cargar');
			
		$('#actualizar').focus();
	}
})(jQuery);

(function($){	
    $.fn.pronino=function(opc){		
		if((opc == 'cargar' && $('#id_beneficiario_pronino').obligatorio()) || (opc == 'guardar' && $('#id_beneficiario_pronino').obligatorio() && $('#item').obligatorio())){
			$("#guardar_pronino").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_pronino').cargarInput(opc);													
			var datos = $('#form_pronino').serialize();			
			$.getJSON('php/beneficiario_pronino.php', datos, function(respuesta){
				if(respuesta.login){
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarPronino(respuesta);
											$('#error').html('Beneficiario cargado correctamente');
											break;		
							case 'guardar':	$.fn.cargarPronino(respuesta);
											$('#error').html('Informacion guardada correctamente');
											break;				
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarPronino();
											$('#error').html('Error al cargar la informacion');
											break;					
							case 'guardar':	$.fn.cargarPronino(respuesta);
											$('#error').html('Error al guardar la informacion');
											break;				
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}
				$("#guardar_pronino").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_pronino").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - pronino"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarYear=function(){	
		$('#form_year').find('.input_error').removeClass('input_error');
		$('#sitio_trabajo').cargarSelect(0);
		$('#actividad_laboral').cargarSelect(0);
		$('#actividad_especifica').cargarInput('');	
		$('#observaciones_year').cargarTextarea('');
		$('#fecha_actualizacion_year').html('-');
		$('#usuario_actualizo_year').html('-');	
		
		$('#escuela_formacion1').cargarSelect(0);
		$('#escuela_formacion2').empty();
		
		$('#kit_escolar').cargarInput('');
		$('#uniforme').cargarInput('');
		$('#zapatos').cargarInput('');	
		$('#visita_domiciliaria').cargarInput('');	
		$('#visita_academica').cargarInput('');	
		$('#visita_psicosocial').cargarInput('');		
		$('#intervencion_psicologica').cargarInput('');	
		$('#valoracion_medica').cargarInput('');	
		$('#valoracion_odontologica').cargarInput('');	
				
		$('#desplazados').cargarCheckbox(0);
		$('#juntos').cargarCheckbox(0);
		$('#familias_accion').cargarCheckbox(0);
		$('#comedor_infantil').cargarCheckbox(0);
		
		$('#id_municipio_colegio').cargarSelect(0);
		$('#id_colegio').empty();
		$('#id_sede').empty();
		$('#coordinador').cargarInput('');
		$('#grado').cargarSelect(0);
		$('#jornada').cargarSelect(0);		
			
		if($('#id_estado').attr('value') == 2){
			$('#form_year input[type="text"], #form_year select, #form_year textarea').attr('readonly', true);
			$("#guardar_year").attr("disabled","disabled");
		}	
		else{
			$('#form_year input[type="text"], #form_year select, #form_year textarea').not('#coordinador').removeAttr('readonly');
			$("#guardar_year").removeAttr("disabled");
		}
		
		$('#eliminar_year').hide();				
		$('#ver_mes').hide();				
		$('#year_mes').cargarInput('');
		$.fn.limpiarMes();	
		
		$('#notas').hide();
		$('#year_nota').cargarInput('');
		$.fn.limpiarNota();	
		$('#desc_notas').empty();
	}
})(jQuery);

(function($){	
    $.fn.cargarYear=function(respuesta){
		$('#form_year').find('.input_error').removeClass('input_error');
		$('#sitio_trabajo').cargarSelect(respuesta.sitioTrabajo);
		$('#actividad_laboral').cargarSelect(respuesta.actividadLaboral);
		$('#actividad_especifica').cargarInput(respuesta.actividadEspecifica);
		$('#observaciones_year').cargarTextarea(respuesta.observaciones);
		$('#fecha_actualizacion_year').html(respuesta.fechaActualizacion);
		$('#usuario_actualizo_year').html(respuesta.nombreUser);
		
		$('#escuela_formacion1').cargarSelect(respuesta.escuelaFormacion1);
		if(respuesta.escuelaFormacion1 != 0){
			if(respuesta.escuelaFormacion2 != 0)
				$.fn.lista('escuela_formacion2','php/escuela.php','',respuesta.escuelaFormacion2,$('#escuela_formacion1').attr('value'));
			else	
				$.fn.lista('escuela_formacion2','php/escuela.php','');
		}
		else
			$('#escuela_formacion2').empty();
		
		$('#kit_escolar').cargarInput(respuesta.kitEscolar);
		$('#uniforme').cargarInput(respuesta.uniforme);
		$('#zapatos').cargarInput(respuesta.zapatos);
		$('#visita_domiciliaria').cargarInput(respuesta.visitaDomiciliaria);
		$('#visita_academica').cargarInput(respuesta.visitaAcademica);
		$('#visita_psicosocial').cargarInput(respuesta.visitaPsicosocial);
		$('#intervencion_psicologica').cargarInput(respuesta.intervencionPsicologica);
		$('#valoracion_medica').cargarInput(respuesta.valoracionMedica);
		$('#valoracion_odontologica').cargarInput(respuesta.valoracionOdontologica);
		
		$('#desplazados').cargarCheckbox(respuesta.desplazados);
		$('#juntos').cargarCheckbox(respuesta.juntos);
		$('#familias_accion').cargarCheckbox(respuesta.familiasAccion);
		$('#comedor_infantil').cargarCheckbox(respuesta.comedorInfantil);
		
		$('#id_municipio_colegio').cargarSelect(respuesta.idMunicipio);
		if(respuesta.idColegio == 0)		
			$.fn.lista('id_colegio','php/colegio.php',respuesta.idMunicipio);			
		else	
			$.fn.lista('id_colegio','php/colegio.php',respuesta.idMunicipio,respuesta.idColegio);		
		
		if(respuesta.idSedeColegio == 0)		
			$.fn.lista('id_sede','php/sede.php',respuesta.idColegio);			
		else	
			$.fn.lista('id_sede','php/sede.php',respuesta.idColegio,respuesta.idSedeColegio);
			
		$('#coordinador').cargarInput(respuesta.coordinador);
		$('#grado').cargarSelect(respuesta.grado);
		$('#jornada').cargarSelect(respuesta.jornada);
		
		if($('#id_estado').attr('value') == 2){
			$('#form_year input[type="text"], #form_year select, #form_year textarea').attr('readonly', true);
			$("#guardar_year").attr("disabled","disabled");
		}
		else{			
			$('#form_year input[type="text"], #form_year select, #form_year textarea').not('#coordinador').removeAttr('readonly');
			$("#guardar_year").removeAttr("disabled");
		}
		
		if(respuesta.perfil > 1)
			$('#eliminar_year').show();	
		else		
			$('#eliminar_year').hide();		
				
		$('#ver_mes').show();		
		$('#year_mes').cargarInput($('#year').attr('value'));
		$.fn.limpiarMes();
		
		$('#notas').show();
		$('#year_nota').cargarInput($('#year').attr('value'));
		$.fn.nota('cargar_lista');
	}
})(jQuery);

(function($){	
    $.fn.year=function(opc){		
		if($('#id_beneficiario_year').obligatorio()){
			$("#guardar_year").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_year').cargarInput(opc);													
			var datos = $('#form_year').serialize();			
			$.getJSON('php/beneficiario_year.php', datos, function(respuesta) {
				if(respuesta.login){
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarYear(respuesta);
											$('#error').html('Informacion del año cargada correctamente');
											break;
							case 'eliminar':$.fn.limpiarYear();
											$('#error').html('Informacion eliminada correctamente');
											break;				
							case 'guardar':	$.fn.cargarYear(respuesta);
											$('#error').html('Informacion guardada correctamente');
											break;				
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarYear();
											$('#error').html('El beneficiario no tiene registrada informacion para el año seleccionado');
											break;
							case 'eliminar':$('#error').html('Error al eliminar la informacion');
											break;				
							case 'guardar':	$.fn.cargarYear(respuesta);
											$('#error').html('Error al guardar la informacion');
											break;				
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}				
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_year").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - informacion programa"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.limpiarNota=function(){	
		$('#form_nota').find('.input_error').removeClass('input_error');
		$('#periodo').cargarSelect(0);
		$('#materia').cargarSelect(0);
		$('#tipo_nota').cargarSelect(0);
		$('#nota_periodo').cargarInput('');
		$('#observaciones_nota').cargarInput('');
					
		if($('#id_estado').attr('value') == 2){
			$('#form_nota input[type="text"], #form_nota select').attr('readonly', true);
			$("#guardar_nota").attr("disabled","disabled");
		}
		else{
			$('#form_nota input[type="text"], #form_nota select').removeAttr('readonly');
			$("#guardar_nota").removeAttr("disabled");	
		}
		
		$("#eliminar_nota").hide();
	}
})(jQuery);

(function($){	
    $.fn.cargarNota=function(respuesta){	
		$('#form_nota').find('.input_error').removeClass('input_error');
		$('#periodo').cargarSelect(respuesta.periodo);
		$('#materia').cargarSelect(respuesta.materia);
		$('#tipo_nota').cargarSelect(respuesta.tipoNota);
		$('#nota_periodo').cargarInput(respuesta.nota);
		$('#observaciones_nota').cargarInput(respuesta.observaciones);
					
		if($('#id_estado').attr('value') == 2){
			$('#form_nota input[type="text"], #form_nota select').attr('readonly', true);
			$("#guardar_nota").attr("disabled","disabled");
		}
		else{
			$('#form_nota input[type="text"], #form_nota select').removeAttr('readonly');
			$("#guardar_nota").removeAttr("disabled");	
		}
		
		if(respuesta.perfil > 0)
			$("#eliminar_nota").show();
		else
			$("#eliminar_nota").hide();
		
		$('#nota_periodo').focus();
	}
})(jQuery);

(function($){	
    $.fn.cargarListaNotas=function(respuesta){
		var materia = ['', 'ESPAÑOL', 'MATEMATICAS'];
		var tipoNota = ['', 'B', 'BS', 'AL', 'SP'];
		
		$.fn.limpiarNota();
		$('#desc_notas').empty();
		
		if(respuesta.lista){
			for(i=0; i<respuesta.periodo.length; i++){
				$('#desc_notas').append('<tr class="ver_nota"><td id="'+respuesta.periodo[i]+'">'+respuesta.periodo[i]+' PERIODO</td><td id="'+respuesta.materia[i]+'">'+materia[respuesta.materia[i]]+'</td><td id="'+respuesta.tipoNota[i]+'">'+tipoNota[respuesta.tipoNota[i]]+'</td><td>'+respuesta.nota[i]+'</td><td>'+respuesta.observaciones[i]+'</td><td>'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'</td></tr>');	
			}
		}
		$('#desc_notas').tablesorter({widgets: ['zebra']});	
	}
})(jQuery);

(function($){	
    $.fn.nota=function(opc){		
		if((opc == 'cargar_lista' && $('#id_beneficiario_nota').obligatorio() && $('#year_nota').obligatorio()) || ((opc == 'cargar' || opc == 'eliminar') && $('#id_beneficiario_nota').obligatorio() && $('#year_nota').obligatorio() && $('#periodo').obligatorio() && $('#materia').obligatorio()) || ($('#id_beneficiario_nota').obligatorio() && $('#year_nota').obligatorio() && $('#periodo').obligatorio() && $('#materia').obligatorio() && $('#nota_periodo').obligatorio())){			
			$("#guardar_nota").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_nota').cargarInput(opc);													
			var datos = $('#form_nota').serialize();			
			$.getJSON('php/beneficiario_nota.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarNota(respuesta);
											$('#error').html('Nota cargada correctamente');
											break;
							case 'cargar_lista':$.fn.cargarListaNotas(respuesta);
												break;
							case 'eliminar':$.fn.cargarListaNotas(respuesta);
											$('#error').html('Nota eliminada correctamente');				
							case 'guardar':	$.fn.cargarListaNotas(respuesta);
											$('#error').html('Nota guardada correctamente');
											break;							
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarNota();
											$('#error').html('Error al cargar la Nota');
											break;
							case 'cargar_lista':$.fn.cargarListaNotas(respuesta);
												break;
							case 'eliminar':$.fn.cargarListaNotas(respuesta);
											$('#error').html('Error al eliminar la nota');				
							case 'guardar':	$.fn.cargarListaNotas();
											$('#error').html('Error al guardar la nota');
											break;						
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}				
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_nota").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - informacion nota"); 
			});	
		}
    }
})(jQuery);

(function($){	
    $.fn.contarActividades=function(){	
		var id, dia, hora, actividad, promedio, actividadesMes = '', actividades = [0, 0, 0, 0, 0, 0, 0];
		$("#desc_actividades tr").each(function (index) {						
			$(this).children("td").each(function (index2) { 
				if($(this).text() != ''){
					id = $(this).attr('id').split('_');					
					dia = id[0];
					hora = id[1];
					switch($(this).text()){
						case 'Act. Escuela' : 	actividad = 1;
												break;
						case 'Act. Casa' :	actividad = 2;
											break;
						case 'Act. Proniño' : 	actividad = 3; 
												break;					
						case 'Trabajando' :	actividad = 4;
											break;						
						case 'Jugando' : 	actividad = 5;
											break;					
						case 'Otras Act.' : actividad = 6;
											break;					
					}					
					actividades[actividad] = actividades[actividad] + 1;
					
					if(actividadesMes == '')
						actividadesMes = dia +'_'+ hora +'_'+ actividad;
					else
						actividadesMes = actividadesMes +':'+ dia +'_'+ hora +'_'+ actividad;	
				}	
			});			
		});
		for(var i=1; i<7; i++){						
			if(actividades[i] != 0)	
				actividades[i] = actividades[i]+' Horas';
			else
				actividades[i] = '';				
			$('#p_actividad_'+i).html(actividades[i]);
		}
		$('#actividades_mes').attr('value', actividadesMes);
    }
})(jQuery);

(function($){	
    $.fn.limpiarMes=function(){	
		$("#nombre_nna").html($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));
		
		var meses1 = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
		var meses2 = ['Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		
		$('#seleccionado').cargarInput('');
		$('#seleccion_multiple').css('background', $('#actividad_seleccionada').attr('value'));
		$('#seleccion_multiple').css('font-weight', '100');
		
		$('#fecha_actualizacion_mes').html('-');
		$('#usuario_actualizo_mes').html('-');
		
		$("#desc_actividades tr td").css('background', '#FFFFFF');
		$("#desc_actividades tr td").html('');
		
		for(var i=1; i<7; i++)
			$('#p_actividad_'+i).html('');
		
		for(var i=0; i<6; i++){
			$('#pl_actividad_'+i).html('');
			$('#pv_actividad_'+i).html('');
		}
		
		for(var i=0; i<6; i++){
			$('#mes_'+i).html('');
			if($('#id_mes').attr('value') <= 6)
				$('#desc_mes_'+i).html(meses1[i]);
			else
				$('#desc_mes_'+i).html(meses2[i]);	
		}
		$('#meses_actualizados').html('');
			
		for(var i=0; i<4; i++)
			$('#hora_'+i).html('');		
		
		for(var i=0; i<3; i++)
			$('#dia_'+i).html('');
		
		if($('#id_estado').attr('value') == 2)
			$("#guardar_mes").attr("disabled","disabled");
		else
			$("#guardar_mes").removeAttr("disabled");
	}
})(jQuery);

(function($){	
    $.fn.cargarMes=function(respuesta){		
		var actividades = ['#FFFFFF', '#3CB371', '#6495ED', '#EEE8AA', '#FA8072', '#D8BFD8', '#FFDEAD'];
		var descActividades = ['', 'Act. Escuela', 'Act. Casa', 'Act. Proniño', 'Trabajando', 'Jugando', 'Otras Act.'];
		
		var meses1 = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
		var meses2 = ['Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		
		var meses = '';
		
		$('#seleccionado').cargarInput('');	
		$('#seleccion_multiple').css('background', $('#actividad_seleccionada').attr('value'));
		$('#seleccion_multiple').css('font-weight', '100');
		
		$('#fecha_actualizacion_mes').html(respuesta.fechaActualizacion);
		$('#usuario_actualizo_mes').html(respuesta.nombreUser);
		
		$("#desc_actividades tr td").css('background', '#FFFFFF');
		$("#desc_actividades tr td").html('');
		
		for(i=1; i<respuesta.diaHora.length; i++){
			$("#"+respuesta.diaHora[i]).css('background', actividades[respuesta.actividad[i]]);
			$("#"+respuesta.diaHora[i]).html(descActividades[respuesta.actividad[i]]);
		}
		
		for(var i=0; i<6; i++){
			if(respuesta.periodoLectivo[i] != 0)	
				respuesta.periodoLectivo[i] = respuesta.periodoLectivo[i]+' Horas';
			else
				respuesta.periodoLectivo[i] = '';
			$('#pl_actividad_'+i).html(respuesta.periodoLectivo[i]);
			if(respuesta.periodoVacaciones[i] != 0)
				respuesta.periodoVacaciones[i] = respuesta.periodoVacaciones[i]+' Horas';
			else
				respuesta.periodoVacaciones[i] = '';		
			$('#pv_actividad_'+i).html(respuesta.periodoVacaciones[i]);
		}		
		
		for(var i=0; i<6; i++){
			if(respuesta.meses[i] != 0)
				respuesta.meses[i] = respuesta.meses[i]+' Horas';
			else
				respuesta.meses[i] = '';	
			$('#mes_'+i).html(respuesta.meses[i]);
			if(respuesta.periodo == 1){
				$('#desc_mes_'+i).html(meses1[i]);
				if(respuesta.mesesPeriodo[i] != ''){
					if(meses == '')
						meses = meses1[i];
					else
						meses = meses+' - '+meses1[i];
				}
			}	
			else{
				$('#desc_mes_'+i).html(meses2[i]);
				if(respuesta.mesesPeriodo[i] != ''){
					if(meses == '')
						meses = meses2[i];
					else
						meses = meses+' - '+meses2[i];
				}	
			}
		}
		$('#meses_actualizados').html(meses);
			
		for(var i=0; i<4; i++){
			if(respuesta.horas[i] != 0)
				respuesta.horas[i] = respuesta.horas[i]+' Horas';
			else
				respuesta.horas[i] = '';
			$('#hora_'+i).html(respuesta.horas[i]);	
		}
		
		for(var i=0; i<3; i++){
			if(respuesta.dias[i] != 0)
				respuesta.dias[i] = respuesta.dias[i]+' Horas';
			else
				respuesta.dias[i] = '';
			$('#dia_'+i).html(respuesta.dias[i]);
		}
		
		$.fn.contarActividades();
		
		if($('#id_estado').attr('value') == 2)
			$("#guardar_mes").attr("disabled","disabled");
		else
			$("#guardar_mes").removeAttr("disabled");
	}
})(jQuery);

(function($){
    $.fn.cambiarMes=function(){
		var periodo = ['Enero - Junio', 'Julio - Diciembre'];
		var tipoPeriodo = ['Periodo Lectivo', 'Periodo de Vacaciones']; 
		
		$('.desc_year').html($('#year').attr('value'));
		if($('#id_mes').attr('value') <= 6){				
			$('.desc_periodo').html(periodo[0]);
			if($('#id_mes').attr('value') == 1 || $('#id_mes').attr('value') == 6)
				$('#tipo_periodo').html(tipoPeriodo[1]);
			else	
				$('#tipo_periodo').html(tipoPeriodo[0]);
		}
		else{
			$('.desc_periodo').html(periodo[1]);
			if($('#id_mes').attr('value') == 7 || $('#id_mes').attr('value') == 12)
				$('#tipo_periodo').html(tipoPeriodo[1]);
			else	
				$('#tipo_periodo').html(tipoPeriodo[0]);
		}
				
		$.fn.mes('cargar');	
   }
})(jQuery);	

(function($){	
    $.fn.mes=function(opc){		
		if($('#id_beneficiario_mes').obligatorio() && $('#year_mes').obligatorio() && $('#id_mes').obligatorio()){			
			$("#guardar_mes").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_mes').cargarInput(opc);													
			var datos = $('#form_mes').serialize();			
			$.getJSON('php/beneficiario_mes.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarMes(respuesta);
											$('#error').html('Informacion del mes cargada correctamente');											
											break;
							case 'guardar':	$.fn.cargarMes(respuesta);
											$('#error').html('Actividades del mes guardadas correctamente');
											break;							
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarMes(respuesta);
											$('#error').html('El beneficiario no tiene registrada informacion para el mes seleccionado');				
											break;
							case 'eliminar':$('#error').html('Error al eliminar la informacion');
											break;	
							case 'guardar':	$.fn.limpiarMes(respuesta);
											$('#error').html('El beneficiario no tiene registrada informacion para el mes seleccionado');								
											break;						
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}				
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_mes").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - informacion actividades"); 
			});	
		}
    }
})(jQuery);	

(function($){	
    $.fn.limpiarDiagnostico=function(){	
		$('#form_diagnostico').find('.input_error').removeClass('input_error');
		$('#usuario_actualizo_diagnostico').html('-');
		$('#fecha_actualizacion_diagnostico').html('-');
		$('#remitido').cargarSelect(0);
		$('#nombre_beneficiario_diagnostico').cargarInput($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));		
		$('#profesional_diagnostico').cargarSelect($('#id_usuario1').attr('value'));		
		$('#situacion_laboral').cargarTextarea('');
		$('#descripcion_escenarios').cargarTextarea('');
		$('#observaciones_diagnostico').cargarTextarea('');
					
		if($('#id_estado').attr('value') == 2){
			$('#form_diagnostico textarea, #form_diagnostico select').attr('readonly', true);
			$("#guardar_diagnostico").attr("disabled","disabled");
		}
		else{
			$('#form_diagnostico textarea, #form_diagnostico select').not('#nombre_beneficiario_diagnostico').removeAttr('readonly');
			$("#guardar_diagnostico").removeAttr("disabled");
		}
		
		$('#actualizar_diagnostico').focus();
		$("#eliminar_diagnostico").hide();
	}
})(jQuery);

(function($){	
    $.fn.cargarDiagnostico=function(respuesta){
		$('#form_diagnostico').find('.input_error').removeClass('input_error');
		$('#usuario_actualizo_diagnostico').html(respuesta.nombreUser);
		$('#fecha_actualizacion_diagnostico').html(respuesta.fechaActualizacion);
		$('#remitido').cargarSelect(respuesta.remitido);
		$('#nombre_beneficiario_seguimiento').cargarInput($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));			
		$('#profesional_diagnostico').cargarSelect(respuesta.profesional);		
		$('#situacion_laboral').cargarTextarea(respuesta.situacionLaboral);
		$('#descripcion_escenarios').cargarTextarea(respuesta.descripcion);
		$('#observaciones_diagnostico').cargarTextarea(respuesta.observaciones);
					
		if($('#id_estado').attr('value') == 2){
			$('#form_diagnostico textarea, #form_diagnostico select').attr('readonly', true);
			$("#guardar_diagnostico").attr("disabled","disabled");
		}
		else{
			$('#form_diagnostico textarea, #form_diagnostico select').not('#nombre_beneficiario_diagnostico').removeAttr('readonly');
			$("#guardar_diagnostico").removeAttr("disabled");	
		}
		
		$("#eliminar_diagnostico").show();
		$('#actualizar_diagnostico').focus();
	}
})(jQuery);

(function($){	
    $.fn.diagnostico=function(opc){		
		if($('#id_beneficiario_diagnostico').obligatorio()){			
			$("#guardar_diagnostico").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_diagnostico').cargarInput(opc);													
			var datos = $('#form_diagnostico').serialize();			
			$.getJSON('php/beneficiario_diagnostico.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarDiagnostico(respuesta);
											$('#error').html('Diagnostico Inicial cargado correctamente');
											break;
							case 'eliminar':$.fn.limpiarDiagnostico();
											$('#error').html('Diagnostico Inicial eliminado correctamente');
											break;				
							case 'guardar':	$.fn.cargarDiagnostico(respuesta);
											$('#error').html('Diagnostico Inicial guardado correctamente');
											break;							
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarDiagnostico();
											$('#error').html('El beneficiario no tiene registrado el Diagnostico Inicial');
											break;
							case 'guardar':	$.fn.cargarDiagnostico(respuesta);
											$('#error').html('Error al guardar el Diagnostico Inicial');
											break;						
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}				
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_diagnostico").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - diagnostico"); 
			});	
		}
    }
})(jQuery);		

(function($){	
    $.fn.limpiarSeguimiento=function(){	
		$('#form_seguimiento').find('.input_error').removeClass('input_error');
		$('#usuario_actualizo_seguimiento').html('-');
		$('#fecha_actualizacion_seguimiento').html('-');	
		$('#id_seguimiento').cargarInput('');		
		$('#nombre_beneficiario_seguimiento').cargarInput($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));	
		$('#fecha_seguimiento').cargarInput('');	
		$('#profesional_seguimiento').cargarSelect($('#id_usuario1').attr('value'));				
		$('#motivo_seguimiento').cargarTextarea('');
		$('#descripcion_seguimiento').cargarTextarea('');
					
		if($('#id_estado').attr('value') == 2){
			$('#form_seguimiento input[type="text"], #form_seguimiento textarea, #form_seguimiento select').attr('readonly', true);
			$("#guardar_seguimiento").attr("disabled","disabled");
		}
		else{
			$('#form_seguimiento input[type="text"], #form_seguimiento textarea, #form_seguimiento select').not('#nombre_beneficiario_seguimiento').removeAttr('readonly');
			$("#guardar_seguimiento").removeAttr("disabled");
		}
		
		$("#eliminar_seguimiento").hide();
	}
})(jQuery);

(function($){	
    $.fn.cargarSeguimiento=function(respuesta){
		$('#form_seguimiento').find('.input_error').removeClass('input_error');
		$('#usuario_actualizo_seguimiento').html(respuesta.nombreUser[0]);
		$('#fecha_actualizacion_seguimiento').html(respuesta.fechaActualizacion[0]);	
		$('#id_seguimiento').cargarInput(respuesta.idSeguimiento);		
		$('#nombre_beneficiario_seguimiento').cargarInput($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));	
		$('#fecha_seguimiento').cargarInput(respuesta.fechaSeguimiento);	
		$('#profesional_seguimiento').cargarSelect(respuesta.profesional);				
		$('#motivo_seguimiento').cargarTextarea(respuesta.motivo);
		$('#descripcion_seguimiento').cargarTextarea(respuesta.descripcion);
					
		if($('#id_estado').attr('value') == 2){
			$('#form_seguimiento input[type="text"], #form_seguimiento textarea, #form_seguimiento select').attr('readonly', true);
			$("#guardar_seguimiento").attr("disabled","disabled");
		}
		else{
			$('#form_seguimiento input[type="text"], #form_seguimiento textarea, #form_seguimiento select').not('#nombre_beneficiario_seguimiento').removeAttr('readonly');
			$("#guardar_seguimiento").removeAttr("disabled");
		}
		
		if(respuesta.perfil > 0)
			$("#eliminar_seguimiento").show();
		else
			$("#eliminar_seguimiento").hide();
				
		$('#actualizar_seguimiento').focus();
	}
})(jQuery);

(function($){	
    $.fn.cargarListaSeguimientos=function(respuesta){
		$.fn.limpiarSeguimiento();		
		$('#tabla_seguimientos').empty();		
		$('#tabla_seguimientos').append('<thead><tr><th width="10%">Fecha</th><th width="35%">Motivo</th><th width="40%">Descripcion</th><th width="15%">Profesional</th></tr></thead><tbody id="desc_seguimientos"></tbody>');
							
		if(respuesta.lista){
			for(i=0; i<respuesta.idSeguimiento.length; i++){
				$('#desc_seguimientos').append('<tr class="ver_seguimiento" id="'+respuesta.idSeguimiento[i]+'" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+respuesta.fechaSeguimiento[i]+'</td><td>'+respuesta.motivo[i]+'</td><td>'+respuesta.descripcion[i]+'</td><td>'+respuesta.nombreProfesional[i]+'</td></tr>');	
			}			
		}
		$('#tabla_seguimientos').tablesorter({widgets: ['zebra']});
		$('#actualizar_seguimiento').focus();
	}
})(jQuery);

(function($){	
    $.fn.seguimiento=function(opc){		
		if((opc == 'cargar' && $('#id_seguimiento').obligatorio()) || (opc == 'cargar_lista' && $('#id_beneficiario_seguimiento').obligatorio()) || (opc == 'eliminar' && $('#id_seguimiento').obligatorio()) || ($('#id_beneficiario_seguimiento').obligatorio() && $('#fecha_seguimiento').obligatorio() && $('#profesional_seguimiento').obligatorio() && $('#motivo_seguimiento').obligatorio())){			
			$("#guardar_seguimiento").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_seguimiento').cargarInput(opc);													
			var datos = $('#form_seguimiento').serialize();			
			$.getJSON('php/beneficiario_seguimiento.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarSeguimiento(respuesta);
											$('#error').html('Visita Domiciliaria cargada correctamente');
											break;
							case 'cargar_lista':$.fn.cargarListaSeguimientos(respuesta);
												$('#error').html('Registro de Visitas Domiciliarias');
												break;				
							case 'eliminar':$.fn.cargarListaSeguimientos(respuesta);
											$('#error').html('Visita Domiciliaria eliminada correctamente');
											break;				
							case 'guardar':	$.fn.cargarListaSeguimientos(respuesta);
											$('#error').html('Visita Domiciliaria guardada correctamente');
											break;							
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarSeguimiento();
											$('#error').html('Error al cargar la Visita Domiciliaria');
											break;
							case 'cargar_lista':$.fn.cargarListaSeguimientos(respuesta);
												$('#error').html('Error al cargar las Visitas Domiciliarias');
												break;				
							case 'eliminar':$.fn.cargarListaSeguimientos(respuesta);
											$('#error').html('Error al eliminar la Visita Domiciliaria');																					
											break;				
							case 'guardar':	$.fn.cargarListaSeguimientos(respuesta);
											$('#error').html('Error al guardar la Visita Domiciliaria');
											break;						
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}				
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_seguimiento").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - seguimiento"); 
			});	
		}
    }
})(jQuery);	

(function($){	
    $.fn.limpiarPsicosocial=function(){	
		$('#form_psicosocial').find('.input_error').removeClass('input_error');
		$('#usuario_actualizo_psicosocial').html('-');
		$('#fecha_actualizacion_psicosocial').html('-');	
		$('#id_psicosocial').cargarInput('');		
		$('#nombre_beneficiario_psicosocial').cargarInput($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));	
		$('#fecha_remision').cargarInput('');
		$('#remitido_psicosocial').cargarSelect($('#id_usuario1').attr('value'));
		$('#aspecto_academico').cargarCheckbox(0);
		$('#aspecto_comportamiento').cargarCheckbox(0);
		$('#aspecto_comunicativo').cargarCheckbox(0);
		$('#aspecto_familiar').cargarCheckbox(0);
		$('#motivo_aspecto_academico').cargarTextarea('');
		$('#motivo_aspecto_comportamiento').cargarTextarea('');
		$('#motivo_aspecto_comunicativo').cargarTextarea('');
		$('#motivo_aspecto_familiar').cargarTextarea('');
		$('#acciones_realizadas').cargarTextarea('');
		$('#remitido_uai').cargarCheckbox(0);
		$('#remitido_psicologia').cargarCheckbox(0);
		$('#remitido_terapia_ocupacional').cargarCheckbox(0);
		$('#remitido_refuerzo_escolar').cargarCheckbox(0);
		$('#remitido_otras_instituciones').cargarTextarea('');
					
		if($('#id_estado').attr('value') == 2){
			$('#form_psicosocial input[type="text"], #form_psicosocial textarea, #form_psicosocial select').attr('readonly', true);
			$("#guardar_psicosocial").attr("disabled","disabled");
		}
		else{
			$('#form_psicosocial input[type="text"], #form_psicosocial textarea, #form_psicosocial select').not('#nombre_beneficiario_psicosocial').removeAttr('readonly');
			$("#guardar_psicosocial").removeAttr("disabled");
		}
		
		$("#eliminar_psicosocial").hide();
	}
})(jQuery);

(function($){	
    $.fn.cargarPsicosocial=function(respuesta){
		$('#form_psicosocial').find('.input_error').removeClass('input_error');
		$('#usuario_actualizo_psicosocial').html(respuesta.nombreUser[0]);
		$('#fecha_actualizacion_psicosocial').html(respuesta.fechaActualizacion[0]);	
		$('#id_psicosocial').cargarInput(respuesta.idSeguimiento);		
		$('#nombre_beneficiario_psicosocial').cargarInput($('#nombres').attr('value')+' '+$('#apellidos').attr('value'));	
		$('#fecha_remision').cargarInput(respuesta.fechaRemision);	
		$('#remitido_psicosocial').cargarSelect(respuesta.remitido);
		$('#aspecto_academico').cargarCheckbox(respuesta.aspectoAcademico);
		$('#aspecto_comportamiento').cargarCheckbox(respuesta.aspectoComportamiento);
		$('#aspecto_comunicativo').cargarCheckbox(respuesta.aspectoComunicativo);
		$('#aspecto_familiar').cargarCheckbox(respuesta.aspectoFamiliar);
		$('#motivo_aspecto_academico').cargarTextarea(respuesta.motivoAspectoAcademico);
		$('#motivo_aspecto_comportamiento').cargarTextarea(respuesta.motivoAspectoComportamiento);
		$('#motivo_aspecto_comunicativo').cargarTextarea(respuesta.motivoAspectoComunicativo);
		$('#motivo_aspecto_familiar').cargarTextarea(respuesta.motivoaspectoFamiliar);
		$('#acciones_realizadas').cargarTextarea(respuesta.accionesRealizadas);
		$('#remitido_uai').cargarCheckbox(respuesta.remitidoUAI);
		$('#remitido_psicologia').cargarCheckbox(respuesta.remitidoPsicologia);
		$('#remitido_terapia_ocupacional').cargarCheckbox(respuesta.remitidoTerapiaOcupacional);
		$('#remitido_refuerzo_escolar').cargarCheckbox(respuesta.remitidoRefuerzoEscolar);
		$('#remitido_otras_instituciones').cargarTextarea(respuesta.remitidoOtrasInstituciones);
					
		if($('#id_estado').attr('value') == 2){
			$('#form_psicosocial input[type="text"], #form_psicosocial textarea, #form_psicosocial select').attr('readonly', true);
			$("#guardar_psicosocial").attr("disabled","disabled");
		}
		else{
			$('#form_psicosocial input[type="text"], #form_psicosocial textarea, #form_psicosocial select').not('#nombre_beneficiario_psicosocial').removeAttr('readonly');
			$("#guardar_psicosocial").removeAttr("disabled");
		}
		
		if(respuesta.perfil > 0)	
			$("#eliminar_psicosocial").show();
		else
			$("#eliminar_psicosocial").hide();	
			
		$('#actualizar_psicosocial').focus();
	}
})(jQuery);

(function($){	
    $.fn.cargarListaPsicosocial=function(respuesta){
		$.fn.limpiarPsicosocial();		
		$('#tabla_psicosocial').empty();
		$('#tabla_psicosocial').append('<thead><tr><th width="10%">Fecha</th><th width="35%">Motivo</th><th width="40%">Descripcion</th><th width="15%">Profesional</th></tr></thead><tbody id="desc_psicosocial"></tbody>');
                
		if(respuesta.lista){
			for(i=0; i<respuesta.idPsicosocial.length; i++){
				$('#desc_psicosocial').append('<tr class="ver_psicosocial" id="'+respuesta.idPsicosocial[i]+'" title="'+respuesta.nombreUser[i]+' &raquo; '+respuesta.fechaActualizacion[i]+'"><td>'+respuesta.fechaRemision[i]+'</td><td></td><td></td><td></td></tr>');	
			}			
		}
		$('#tabla_psicosocial').tablesorter({widgets: ['zebra']});
		$('#actualizar_psicosocial').focus();
	}
})(jQuery);

(function($){	
    $.fn.psicosocial=function(opc){		
		if((opc == 'cargar' && $('#id_psicosocial').obligatorio()) || (opc == 'cargar_lista' && $('#id_beneficiario_psicosocial').obligatorio()) || (opc == 'eliminar' && $('#id_psicosocial').obligatorio()) || ($('#id_beneficiario_psicosocial').obligatorio() && $('#fecha_remision').obligatorio())){			
			$("#guardar_psicosocial").attr("disabled","disabled");			
			$('#cargando').show();
			$('#opc_psicosocial').cargarInput(opc);													
			var datos = $('#form_psicosocial').serialize();			
			$.getJSON('php/beneficiario_psicosocial.php', datos, function(respuesta) {
				if(respuesta.login){					
					if(respuesta.consulta){	
						switch(respuesta.opc){
							case 'cargar': 	$.fn.cargarPsicosocial(respuesta);
											$('#error').html('Seguimiento de Atencion Psicosocial cargado correctamente');
											break;
							case 'cargar_lista':$.fn.cargarListaPsicosocial(respuesta);
												$('#error').html('Registro de Seguimientos de Atencion Psicosocial');
												break;				
							case 'eliminar':$.fn.cargarListaPsicosocial(respuesta);
											$('#error').html('Seguimiento de Atencion Psicosocial eliminado correctamente');
											break;				
							case 'guardar':	$.fn.cargarListaPsicosocial(respuesta);
											$('#error').html('Seguimiento de Atencion Psicosocial guardado correctamente');
											break;							
						}								
					}
					else{
						switch(respuesta.opc){
							case 'cargar':	$.fn.limpiarPsicosocial();
											$('#error').html('Error al cargar el Seguimiento de Atencion Psicosocial');
											break;
							case 'cargar_lista':$.fn.cargarListaPsicosocial(respuesta);
												$('#error').html('Error al cargar los Seguimientos de Atencion Psicosocial');
												break;				
							case 'eliminar':$.fn.cargarListaPsicosocial(respuesta);
											$('#error').html('Error al eliminar el Seguimiento de Atencion Psicosocial');																					
											break;				
							case 'guardar':	$.fn.cargarListaPsicosocial(respuesta);
											$('#error').html('Error al guardar el Seguimiento de Atencion Psicosocial');
											break;						
						}
					}					
				}
				else{
					$(window).off('beforeunload');
					$(location).attr('href', 'index.php');
				}				
				$("#cargando").delay(400).slideUp(0);
			})
			.error(function() { 
				$("#guardar_psicosocial").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - psicosocial"); 
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
	$('#busqueda').tablesorter();
	
	$("#fecha_nacimiento_generico").datepicker();
	
	$("#fecha_nacimiento").datepicker();
	$("#fecha_ingreso").datepicker();
	$("#fecha_retiro").datepicker();
	
	$("#kit_escolar").datepicker();
	$("#uniforme").datepicker();
	$("#zapatos").datepicker();	
	$("#visita_domiciliaria").datepicker();
	$("#visita_academica").datepicker();
	$("#visita_psicosocial").datepicker();
	$("#intervencion_psicologica").datepicker();
	$("#valoracion_odontologica").datepicker();
	$("#valoracion_medica").datepicker();
	
	$("#fecha_seguimiento").datepicker();
	$("#fecha_remision").datepicker();
	
	$("#multiple").cargarCheckbox(1);
		
	$.getJSON('php/perfil.php', function(respuesta){
		if(respuesta.login){
			if(respuesta.perfil == 0){
				$('input[type=text], input[type=checkbox], select, textarea').not('#input_buscar, #id_municipio_buscar, #id_colegio_buscar, #year, #id_mes').attr('disabled', 'disabled');
				$('input[id*="guardar"], .generico').hide();
			}
			
			$('#usuario1').show();
			$('#usuario2').show();
			$('#estado').show();
			$('#beneficiario_nuevo').show();
						
			$('#nombre_user').html(respuesta.user);	
			$.fn.listaYear();		
			$.fn.lista('id_ars','php/ars.php',''); 
			$.fn.lista('id_municipio_buscar','php/municipio.php','');
			$.fn.lista('id_municipio_generico','php/municipio.php','');
			$.fn.lista('id_municipio','php/municipio.php','');
			$.fn.lista('id_municipio_colegio','php/municipio.php','');
			$.fn.lista('id_usuario1','php/usuario.php','1');
			$.fn.lista('id_usuario2','php/usuario.php','2');
			$.fn.lista('sitio_trabajo','php/sitio.php','');
			$.fn.lista('actividad_laboral','php/actividad.php','');			
			$.fn.lista('escuela_formacion1','php/escuela.php','');
			$.fn.lista('profesional_diagnostico','php/usuario.php','');
			$.fn.lista('profesional_seguimiento','php/usuario.php','');
			$.fn.lista('remitido_psicosocial','php/usuario.php','');
		}
		else{
			$(window).off('beforeunload');
			$(location).attr('href', 'index.php');
		}
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});
	
	$('#salir').click(function(event){	
		$(window).off('beforeunload');
		$(location).attr('href', 'php/salir.php'); 
	});	
	
	//Buscar
	$("#form_buscar").submit(function(event){
		event.preventDefault();
		$.fn.buscar('buscar');
	});
	
	$(".ver_beneficiario").live('click', function(event){
		$.fn.verBeneficiario($(this).attr('id'));
	});
	
	$("#id_municipio_buscar").live('change', function(event){
		$.fn.lista('id_colegio_buscar','php/colegio.php',$(this).attr('value')); 
		$.fn.buscar('buscar');
	});
	
	$("#id_colegio_buscar").live('change', function(event){
		$.fn.buscar('buscar');
	});
	
	//Generico
	$("#beneficiario_nuevo").click(function(event){
		$('#span_generico').html('BENEFICIARIO');					
		$('#tipo_generico').cargarInput('beneficiario');
		if(isNaN($('#input_buscar').attr('value')))
			$('#nombres_generico').cargarInput($('#input_buscar').attr('value'));
		else
			$('#documento_beneficiario_generico').cargarInput($('#input_buscar').attr('value'));
		$.fn.generico('guardar');		
		$('#overlay').show();		
		$('#generico').show();		
	});		
	
	$("#form_generico").submit(function(event){
		event.preventDefault();
		$.fn.generico('guardar');
	});
	
	$("#actualizar_generico").click(function(event){
		$.fn.generico('cargar');
	});
	
	$("#nuevo_generico").click(function(event){
		$.fn.generico('nuevo');
	});
	
	$(".cargar_generico").live('click', function(event){
		$('#id_generico').attr('value', $(this).attr('id'));
		$.fn.generico('cargar');
	});
	
	$("#eliminar_generico").click(function(event){
		if(confirm('Desea eliminar el registro'))	
			$.fn.generico('eliminar');
	});
		
	$("#cancelar_generico").click(function(event){
		$.fn.limpiarGenerico();		
		$('#overlay').hide();
		$('#generico').hide();		
	});	
	
	$("#id_municipio_generico").live('change', function(event){
		$.fn.lista('id_barrio_generico','php/barrio.php',$(this).attr('value')); 
	});
	
	//Beneficiario
	$("#form_beneficiario").submit(function(event){
		event.preventDefault();
		$.fn.beneficiario('guardar');
	});
	
	$("#actualizar").click(function(event){		
		$.fn.beneficiario('cargar');
	});	
	
	$("#beneficiario").click(function(event){
		$('#span_generico').html('BENEFICIARIO');
		$('#tipo_generico').cargarInput('beneficiario');
		$('#id_generico').cargarInput($('#id_beneficiario').attr('value'));
		$.fn.generico('cargar');		
		$('#overlay').show();		
		$('#generico').show();		
	});	
	
	$("#id_municipio").live('change', function(event){
		$.fn.lista('id_barrio','php/barrio.php',$(this).attr('value')); 
	});	
	
	//Beneficiario Proniño
	$("#form_pronino").submit(function(event){
		event.preventDefault();
		$.fn.pronino('guardar');
	});
	
	$("#id_estado").live('change', function(event){		
		if($(this).attr('value') == 2)
			$('.retirado').css('visibility', 'visible');
		else{
			$('#fecha_retiro').cargarInput('');
			$('#razon_retiro').cargarSelect(0);	
		}
		$.fn.pronino('guardar');
	});
	
	$("#acudiente").click(function(event){
		$('#span_generico').html('ACUDIENTE');
		$('#tipo_generico').cargarInput('acudiente');
		$('#id_beneficiario_generico').cargarInput($('#id_beneficiario').attr('value'));
		if($('#id_acudiente').attr('value') != 0)
			$('#id_generico').cargarInput($('#id_acudiente').attr('value'));
		else	
			$('#id_generico').cargarInput('');
		$.fn.generico('cargar');
		$('#overlay').show();		
		$('#generico').show();		
	});	
	
	//Info Beneficiario x Año
	$("#year").live('change', function(event){
		$('#year_mes').cargarInput($(this).attr('value'));
		$('#year_nota').cargarInput($(this).attr('value'));
		$.fn.year('cargar');
	});	
	
	$("#form_year").submit(function(event){
		event.preventDefault();
		$.fn.year('guardar');
	});
	
	$("#escuela_formacion1").live('change', function(event){		
		$.fn.lista('escuela_formacion2','php/escuela.php','','',$('#escuela_formacion1').attr('value')); 
	});	
	
	$("#id_municipio_colegio").live('change', function(event){ 
		$.fn.lista('id_colegio','php/colegio.php',$(this).attr('value')); 
	});
	
	$("#id_colegio").live('change', function(event){
		$('#coordinador').cargarInput('');
		$.fn.lista('id_sede','php/sede.php',$(this).attr('value')); 
	});	
	
	$("#id_sede").live('change', function(event){
		$('#cargando').show();			
		$.getJSON('php/sede.php', {opc:'cargar', id:$(this).attr('value')}, function(respuesta) {						
			if(respuesta.login){
				if(respuesta.consulta)	
					$('#coordinador').cargarInput(respuesta.coordinador[0]);	
				else
					$('#coordinador').cargarInput('');
			}									
			else{
				$(window).off('beforeunload');
				$(location).attr('href', 'index.php');
			}			
			$("#cargando").delay(400).slideUp(0);
		})
		.error(function() { 			
			$("#cargando").delay(400).slideUp(0);
			$('#error').html("Error: Compruebe la conexion de red de su equipo! - sede colegio"); 
		});
	});	
	
	$("#eliminar_year").click(function(event){
		if(confirm('Desea eliminar el informacion del año '+$('#year').attr('value')+' del beneficiario: '+$('#nombres').attr('value')+' '+$('#apellidos').attr('value')))	
			$.fn.year('eliminar');
	});
	
	$("#cancelar_year").click(function(event){
		$.fn.year('cargar');		
	});
	
	$("#lista_beneficiario").click(function(event){
		$.fn.buscar('buscar');
		$('#info_beneficiario').hide();
		$('#busqueda_beneficiario').show();
		$('#input_buscar').focus();		
	});
	
	//Actividades
	$("#ver_mes").click(function(event){
		$.fn.mes('cargar');	
		$('#overlay').show();		
		$('#actividades').show();
		$('#id_mes').focus();	
	});
	
	$("#actualizar_mes").click(function(event){
		$.fn.mes('cargar');		
	});	
	
	$("input[name=trabaja]").click(function(event){
		if($(this).attr('value') == '0')
			$("#ver_encuesta").slideUp();
		else
			$("#ver_encuesta").slideDown();		
	});	
	
	$("input[name=genera_ingresos]").click(function(event){
		if($(this).attr('value') == '0')
			$("#ver_gastos").slideUp();
		else
			$("#ver_gastos").slideDown();		
	});	
	
	$("#id_mes").live('change', function(event){
		$.fn.cambiarMes();	
	});	
	
	$("#desc_actividades td").click(function(event){
		if($('#id_mes').obligatorio()){
			if($('#actividad_seleccionada').obligatorio()){							
				$(this).css('background', $('#actividad_seleccionada').attr('value'));
				$(this).text($('#actividad_seleccionada').attr('label'));
				
				if($('#multiple').is(':checked')){
					if(!$('#seleccionado').obligatorio()){
						$('#seleccionado').cargarInput($(this).attr('id'));
						$('#seleccion_multiple').css('background', '#585858');
						$('#seleccion_multiple').css('font-weight', 'bold');
					}
					else{
						var anterior = $('#seleccionado').attr('value').split('_');
						var actual = $(this).attr('id').split('_');
						var inicio = new Array(0,0), fin = new Array(0,0);
						
						if(parseInt(anterior[0]) > parseInt(actual[0])){
							inicio[0] = actual[0];
							fin[0] = anterior[0];
						}
						else{	
							inicio[0] = anterior[0];
							fin[0] = actual[0];
						}						
						
						if(parseInt(anterior[1]) > parseInt(actual[1])){
							inicio[1] = actual[1];
							fin[1] = anterior[1];
						}
						else{	
							inicio[1] = anterior[1];
							fin[1] = actual[1];
						}	
						
						for(var i=parseInt(inicio[0]); i<=parseInt(fin[0]); i++){
							for(var j=parseInt(inicio[1]); j<=parseInt(fin[1]); j++){
								$('#'+i+'_'+j).css('background', $('#actividad_seleccionada').attr('value'));
								$('#'+i+'_'+j).text($('#actividad_seleccionada').attr('label'));
							}
						}
						
						$('#seleccionado').cargarInput('');	
						$('#seleccion_multiple').css('background', $('#actividad_seleccionada').attr('value'));
						$('#seleccion_multiple').css('font-weight', '100');
					}
				}
				
				$.fn.contarActividades();
			}
			else
				alert('Seleccione una actividad.');
		}
		else
			alert('Seleccione un mes.');
	});	
	
	$("#multiple").click(function(event){
		$('#seleccionado').cargarInput('');	
		$('#seleccion_multiple').css('background', $('#actividad_seleccionada').attr('value'));
		$('#seleccion_multiple').css('font-weight', '100');
	});	
	
	$("#actividad_escuela, #actividad_casa, #actividad_pronino, #actividad_trabajando, #actividad_jugando, #actividad_otras, #actividad_quitar").live('click', function(event){
		event.preventDefault();		
		$('#actividad_seleccionada').cargarInput($(this).attr('label'));
		$('#actividad_seleccionada').attr('label', $(this).attr('title'));
		$('.actividad_seleccionada').css('background', $('#actividad_seleccionada').attr('value'));
		
		$('#seleccionado').cargarInput('');	
		$('#seleccion_multiple').css('background', $('#actividad_seleccionada').attr('value'));
		$('#seleccion_multiple').css('font-weight', '100');
	});
	
	$("#form_mes").submit(function(event){
		event.preventDefault();
		$.fn.mes('guardar');
	});
	
	$("#cancelar_mes").click(function(event){
		$.fn.limpiarMes();		
		$('#overlay').hide();
		$('#actividades').hide();		
	});
	
	//Diagnostico
	$("#ver_diagnostico").click(function(event){
		$.fn.diagnostico('cargar');			
		$('#overlay').show();		
		$('#diagnostico').show();		
	});	
	
	$("#actualizar_diagnostico").click(function(event){
		$.fn.diagnostico('cargar');		
	});		
	
	$("#form_diagnostico").submit(function(event){
		event.preventDefault();
		$.fn.diagnostico('guardar');
	});
	
	$("#imprimir_diagnostico").click(function(event){
		window.open('pdf/diagnostico.php?id_beneficiario='+$('#id_beneficiario_diagnostico').attr('value'));
	});
	
	$("#eliminar_diagnostico").click(function(event){
		if(confirm('Desea eliminar el diagnostico inicial del beneficiario: '+$('#nombres').attr('value')+' '+$('#apellidos').attr('value')))		
			$.fn.diagnostico('eliminar');
	});
	
	$("#cancelar_diagnostico").click(function(event){
		$.fn.limpiarDiagnostico();		
		$('#overlay').hide();
		$('#diagnostico').hide();		
	});	
	
	//Seguimiento
	$("#ver_seguimiento").click(function(event){
		$.fn.seguimiento('cargar_lista');			
		$('#overlay').show();		
		$('#seguimiento').show();		
	});	
	
	$("#actualizar_seguimiento").click(function(event){
		$.fn.seguimiento('cargar_lista');		
	});		
	
	$("#form_seguimiento").submit(function(event){
		event.preventDefault();
		$.fn.seguimiento('guardar');
	});
	
	$("#imprimir_seguimiento").click(function(event){
		window.open('pdf/seguimiento.php?id_beneficiario='+$('#id_beneficiario_seguimiento').attr('value'));
	});
	
	$(".ver_seguimiento").live('click', function(event){
		$('#id_seguimiento').cargarInput($(this).attr('id'));
		$.fn.seguimiento('cargar');			
	});
	
	$("#eliminar_seguimiento").click(function(event){
		if(confirm('Desea eliminar la visita del '+$('#fecha_seguimiento').attr('value')))	
			$.fn.seguimiento('eliminar');
	});
	
	$("#cancelar_seguimiento").click(function(event){
		$.fn.limpiarSeguimiento();		
		$('#overlay').hide();
		$('#seguimiento').hide();		
	});	
	
	//Atencion Psicosocial
	$("#ver_psicosocial").click(function(event){
		$.fn.psicosocial('cargar_lista');					
		$('#overlay').show();
		$('#psicosocial').show();		
	});	
	
	$("#actualizar_psicosocial").click(function(event){
		$.fn.psicosocial('cargar_lista');		
	});		
	
	$("#form_psicosocial").submit(function(event){
		event.preventDefault();
		$.fn.psicosocial('guardar');
	});
	
	$("#imprimir_psicosocial").click(function(event){
		window.open('pdf/atencion_psicosocial.php?id_beneficiario='+$('#id_beneficiario_psicosocial').attr('value'));
	});
	
	$(".ver_psicosocial").live('click', function(event){
		$('#id_psicosocial').cargarInput($(this).attr('id'));
		$.fn.psicosocial('cargar');			
	});
	
	$("#eliminar_psicosocial").click(function(event){
		if(confirm('Desea eliminar la atencion psicosocial del '+$('#fecha_remision').attr('value')))	
			$.fn.psicosocial('eliminar');
	});
	
	$("#cancelar_psicosocial").click(function(event){
		$.fn.limpiarPsicosocial();	
		$('#overlay').hide();			
		$('#psicosocial').hide();	
	});
	
	//Notas
	$("#form_nota").submit(function(event){
		event.preventDefault();
		$.fn.nota('guardar');
	});
	
	$(".ver_nota").live('click', function(event){
		$('#form_nota').find('.input_error').removeClass('input_error');
		$(this).children("td").each(function (index){
			switch (index) {
				case 0: $('#periodo').cargarSelect($(this).attr('id'));
						break;
				case 1: $('#materia').cargarSelect($(this).attr('id'));
						break;
			}
		});	
		$.fn.nota('cargar');	
	});
	
	$("#eliminar_nota").click(function(event){
		if(confirm('Desea eliminar la nota de '+$('#materia option:selected').text()+' del '+$('#materia').attr('value')+' periodo'))	
			$.fn.nota('eliminar');
	});
	
	$("#cancelar_nota").click(function(event){
		$.fn.limpiarNota('');
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
	
	$("#input_buscar").focus();
	$("#cargando").delay(400).slideUp(0);
});