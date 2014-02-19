(function($){
    $.fn.fixedMenu=function(){
        return this.each(function(){
            var menu = $(this);									
            menu.find('a.submenu').bind('click',function(){
				if ($(this).parent().hasClass('active')){
					$(this).parent().removeClass('active');
				}
				else{
					$(this).parent().parent().find('.active').removeClass('active');
					$(this).parent().addClass('active');
				}
            })								
			$('a.item').click(function(){	
                menu.find('.active').removeClass('active');
            })
        });
    }
})(jQuery);

//Factura
(function($){
    $.fn.factura=function(opc){
		$('#cargando').show();					
		$('#formato').slideDown('slow');								
		$.fn.limpiar();			
		$.getJSON('x09/fecha.php', function(respuesta) {			
			var primera = parseInt(respuesta.primeraFactura);
			var ultima = parseInt(respuesta.ultimaFactura);
			var siguiente = primera+1;
			var anterior = ultima-1;
			$('#ultima_factura').html('<div id="primera" class="control">&nbsp;</div><div id="anterior" class="control">&nbsp;</div><div id="actual" class="control">&nbsp;</div><div id="siguiente" class="control">&nbsp;</div><div id="ultima" class="control"></div>');
			if(ultima > primera){				
				$('#primera').html('<a href="#" class="cargar_factura">'+respuesta.primeraFactura+'</a>');				
				if(siguiente < ultima)
					$('#anterior').html('<a href="#" class="cargar_factura">'+siguiente+'</a>');
				if(anterior > siguiente)	
					$('#siguiente').html('<a href="#" class="cargar_factura">'+anterior+'</a>');
			}
			
			if(ultima >= primera)				
				$('#ultima').html('<a href="#" class="cargar_factura" title="Fecha: '+respuesta.fechaFactura+'">'+respuesta.ultimaFactura+'</a>');
					
			$('#ciudad').attr('value', 'CÚCUTA');		
			$('#fecha').attr('value', respuesta.fecha);
			$.fn.fecha();	
			$('#nit_persona').focus();	
			$('#cargando').delay(400).slideUp(1);				
		})
		.error(function() { 
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});							 					
    }
})(jQuery);	

(function($){
    $.fn.limpiar=function(){
		$('#info_factura input,#info_factura textarea').removeAttr('readonly');
		$('.calendario').css('display', 'block');
		$('#numero_factura').attr('value', '');
		$('#fecha').attr('value', '');
		$.fn.fecha();
		$('#ciudad').attr('value', '');
		$('#id_persona').attr('value', '');
		$('#nit_persona').attr('value', '');
		$('#persona_natural').attr('value', '');		
		$('#direccion_persona').attr('value', '');												
		$('#telefono').attr('value', '');	
		$('#descripcion').attr('value', '');		
		$('#observaciones').attr('value', '');	
		$('#tarifa_iva').attr('value', '16');	
		$('#total_factura').attr('value', '');		
		//Original
		$('#original_numero_factura').attr('value', '');
		$('#original_ciudad').attr('value', '');	
		$('#original_nit_persona').attr('value', '');		
		$('#original_persona_natural').attr('value', '');		
		$('#original_direccion_persona').attr('value', '');														
		$('#original_telefono').attr('value', '');		
		$('#original_descripcion').html('');	
		$('#original_observaciones').attr('value', '');		
		//Copia
		$('#copia_numero_factura').attr('value', '');
		$('#copia_ciudad').attr('value', '');	
		$('#copia_nit_persona').attr('value', '');		
		$('#copia_persona_natural').attr('value', '');		
		$('#copia_direccion_persona').attr('value', '');														
		$('#copia_telefono').attr('value', '');		
		$('#copia_descripcion').html('');	
		$('#copia_observaciones').attr('value', '');
		//Copia
		$('#copia2_numero_factura').attr('value', '');
		$('#copia2_ciudad').attr('value', '');	
		$('#copia2_nit_persona').attr('value', '');		
		$('#copia2_persona_natural').attr('value', '');		
		$('#copia2_direccion_persona').attr('value', '');														
		$('#copia2_telefono').attr('value', '');		
		$('#copia2_descripcion').html('');	
		$('#copia2_observaciones').attr('value', '');
		
		//$.fn.subtotal();		
		$('#estado_factura').removeAttr('checked');
		$('#modificar_factura').removeAttr('checked');
		$('.anulada').hide();
		$('#nombre_user').html('');
    }
})(jQuery);

(function($){
    $.fn.cargar=function(respuesta){
		var primera = parseInt(respuesta.primeraFactura);
		var ultima = parseInt(respuesta.ultimaFactura);
		var actual = parseInt(respuesta.numeroFactura);
		var siguiente = actual+1;
		var anterior = actual-1;
		
		$('#actual').html('<a href="#" class="cargar_factura">'+actual+'</a>');	
		
		if(primera != actual)
			$('#primera').html('<a href="#" class="cargar_factura">'+primera+'</a>');				
		else
			$('#primera').html('&nbsp;');
			
		if(ultima != actual)		
			$('#ultima').html('<a href="#" class="cargar_factura">'+ultima+'</a>');
		else
			$('#ultima').html('&nbsp;');	
									
		if(anterior > primera && anterior < actual)
			$('#anterior').html('<a href="#" class="cargar_factura">'+anterior+'</a>');
		else	
			$('#anterior').html('&nbsp;');
		
		if(siguiente > actual && siguiente < ultima)				
			$('#siguiente').html('<a href="#" class="cargar_factura">'+siguiente+'</a>');
		else	
			$('#siguiente').html('&nbsp;');		
			
		$('#info_factura input,#info_factura textarea').attr('readonly', true);
		$('.calendario').css('display', 'none');			
		document.title = 'Factura '+respuesta.numeroFactura;		
		$('#fecha').attr('value', respuesta.fecha);
		$.fn.fecha();
		//Original		
		$('#numero_factura').attr('value', respuesta.numeroFactura);		
		$('#ciudad').attr('value', respuesta.ciudad);						
		$('#id_persona').attr('value', respuesta.idCliente);
		$('#nit_persona').attr('value', respuesta.nitCliente);
		$('#persona_natural').attr('value', respuesta.nombreCliente);		
		$('#direccion_persona').attr('value', respuesta.direccionCliente);										
		$('#telefono').attr('value', respuesta.telefonoCliente);		
		$('#descripcion').attr('value', respuesta.descripcion);			
		$('#observaciones').attr('value', respuesta.observaciones);			
		$('#tarifa_iva').attr('value', respuesta.tarifaIva);
		$('#total_factura').attr('value', respuesta.valor);		
		//Original
		$('#original_numero_factura').attr('value', respuesta.numeroFactura);				
		$('#original_ciudad').attr('value', respuesta.ciudad);
		$('#original_nit_persona').attr('value', respuesta.nitCliente);		
		$('#original_persona_natural').attr('value', respuesta.nombreCliente);		
		$('#original_direccion_persona').attr('value', respuesta.direccionCliente);										
		$('#original_telefono').attr('value', respuesta.telefonoCliente);
		$('#original_descripcion').html($('#descripcion').attr('value'));		
		$('#original_observaciones').attr('value', respuesta.observaciones);	
		//Copia
		$('#copia_numero_factura').attr('value', respuesta.numeroFactura);				
		$('#copia_ciudad').attr('value', respuesta.ciudad);
		$('#copia_nit_persona').attr('value', respuesta.nitCliente);		
		$('#copia_persona_natural').attr('value', respuesta.nombreCliente);		
		$('#copia_direccion_persona').attr('value', respuesta.direccionCliente);										
		$('#copia_telefono').attr('value', respuesta.telefonoCliente);
		$('#copia_descripcion').html($('#descripcion').attr('value'));		
		$('#copia_observaciones').attr('value', respuesta.observaciones);
		//Copia2
		$('#copia2_numero_factura').attr('value', respuesta.numeroFactura);				
		$('#copia2_ciudad').attr('value', respuesta.ciudad);
		$('#copia2_nit_persona').attr('value', respuesta.nitCliente);		
		$('#copia2_persona_natural').attr('value', respuesta.nombreCliente);		
		$('#copia2_direccion_persona').attr('value', respuesta.direccionCliente);										
		$('#copia2_telefono').attr('value', respuesta.telefonoCliente);
		$('#copia2_descripcion').html($('#descripcion').attr('value'));		
		$('#copia2_observaciones').attr('value', respuesta.observaciones);			
		
		$.fn.subtotal();
		if(respuesta.estadoFactura == '2'){						
			$('#estado_factura').attr('checked', true);
			$('.anulada').show();
		}
		else{
			$('#estado_factura').removeAttr('checked');
			$('.anulada').hide();
		}
		$('#modificar_factura').removeAttr('checked');
		$('#modificar_factura').focus();
		$('#nombre_user').html('Actualizado por: '+respuesta.nombreUser+', Fecha: '+respuesta.fechaActualizacion);		
    }
})(jQuery);

(function($){	
    $.fn.fecha=function(){
		var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];									
		var fecha = $('#fecha').attr('value');
		if(fecha != ''){
			var array = fecha.split('-');		
			var mes = array[1];
			if(mes > 0){
				$('#mostrar_fecha').html(meses[mes-1]+' '+array[2]+' DE '+array[0]);
				$('#original_mostrar_fecha').html(meses[mes-1]+' '+array[2]+' DE '+array[0]);
				$('#copia_mostrar_fecha').html(meses[mes-1]+' '+array[2]+' DE '+array[0]);
				$('#copia2_mostrar_fecha').html(meses[mes-1]+' '+array[2]+' DE '+array[0]);
			}
		}
		else{
			$('#mostrar_fecha').html('');
			$('#original_mostrar_fecha').html('');
			$('#copia_mostrar_fecha').html('');
			$('#copia2_mostrar_fecha').html('');
		}
    }
})(jQuery);

(function($){
	$.fn.actualizar_cliente=function(){							
		var id = $('#id_persona').attr('value');
		var nit = $('#nit_persona').attr('value');
		var nombre = $('#persona_natural').attr('value');
		var tel = $('#telefono').attr('value');
		var direccion = $('#direccion_persona').attr('value');		
		if(id != '' && id != 0){				
			$('#cargando').show();						
			$.getJSON('x09/cliente.php', {opc:'update', id_persona:id, nit_persona:nit, persona_natural:nombre, telefono:tel, direccion_persona:direccion}, function(respuesta) {				
				if(respuesta.login){																			
					$('#persona_natural').attr('value', respuesta.nombreCliente[0]);
					$('#telefono').attr('value', respuesta.telefonoCliente[0]);
					$('#direccion_cliente').attr('value', respuesta.direccionCliente[0]);
				}
				else
					$('#xsoft').load('login.html');
				$('#cargando').delay(400).slideUp(1);	
			})
			.error(function() { 
				$('#cargando').delay(400).slideUp(1);
				alert('Error: Compruebe la conexion de red de su equipo'); 
			});			
		}
		else{
			$(this).attr('value', '');			
			alert('Por favor digite primero el Nit de la persona');			
		}        
	}
})(jQuery);	

(function($){
    $.fn.subtotal=function(){
		var subtotal, iva, valor_iva, longitud, total;
		$('#total_factura').priceFormat();
		total = $('#total_factura').attr('value')
       	total = total.replace(/[$ ,]/gi,'');
		total = parseFloat(total);		
		$('#calcular_subtotal').attr('value', total.toFixed(2));
		$('#calcular_subtotal').priceFormat();		
		$('#original_total_factura').html($('#calcular_subtotal').attr('value'));	
		$('#copia_total_factura').html($('#calcular_subtotal').attr('value'));	
		$('#copia2_total_factura').html($('#calcular_subtotal').attr('value'));				
		
		var iva = $('#tarifa_iva').attr('value');
		if(iva == '')
			iva = '0';			
		if (/^([0-9])*[.]?[0-9]*$/.test(iva)){	
			iva = (parseInt(iva)+100) / 100;						
			subtotal = parseFloat(total / iva);			
			$('#calcular_subtotal').attr('value', subtotal.toFixed(2));
			$('#calcular_subtotal').priceFormat();	
			$('#valor').html($('#calcular_subtotal').attr('value'));			
			$('#original_valor').html($('#calcular_subtotal').attr('value'));		
			$('#copia_valor').html($('#calcular_subtotal').attr('value'));		
			$('#copia2_valor').html($('#calcular_subtotal').attr('value'));			
			$('#subtotal_factura').html($('#calcular_subtotal').attr('value'));			
			$('#original_subtotal_factura').html($('#calcular_subtotal').attr('value'));
			$('#copia_subtotal_factura').html($('#calcular_subtotal').attr('value'));
			$('#copia2_subtotal_factura').html($('#calcular_subtotal').attr('value'));
		}
		else{
			longitud = iva.length-1;
			iva = iva.substring(0,longitud);	
			$('#tarifa_iva').attr('value', iva);
		}		
				
		valor_iva = parseFloat(total - subtotal);
		$('#calcular_subtotal').attr('value', valor_iva.toFixed(2));
		$('#calcular_subtotal').priceFormat();
		$('#iva_factura').html($('#calcular_subtotal').attr('value'));			
		$('#original_iva_factura').html($('#calcular_subtotal').attr('value'));
		$('#copia_iva_factura').html($('#calcular_subtotal').attr('value'));
		$('#copia2_iva_factura').html($('#calcular_subtotal').attr('value'));			
    }
})(jQuery);

//Opciones Menu
(function($){
    $.fn.ocultar=function(){									
			$('#mostrar').empty();	
			$('#tabla').empty();
			$('#admin_u').hide();			
			$('#admin_c').hide();						
			$('#cambiar_c').hide();
			$('#buscar').hide();								
    }
})(jQuery);

(function($){
    $.fn.buscar=function(){								
			$.fn.ocultar();
			$('#buscar').show();			
			$('#administracion').show('slow');			
    }
})(jQuery);

(function($){
	$.fn.usuario=function(){	
		$('#cargando').show();					
		$.getJSON('x09/usuario.php', {id_usuario:'', opc:'all'}, function(respuesta) {					
			if(respuesta.login){		
				$.fn.ocultar();	
				$('#admin_u').show();				
				$('#administracion').slideDown('slow');	
				$('#tabla').append('<thead><tr id="cabecera"><th width="6%">No.</th><th width="20%">Usuario</th><th width="20%">Perfil</th><th width="20%">Nombre</th><th width="20%">Email</th></tr></thead>');
				if(respuesta.administrador)						
						$('#cabecera').append('<th width="7%"></th><th width="7%"></th>');
				$('#tabla').append('<tbody id="body_tabla"></tbody>');				
				if(respuesta.consulta){			
					for(var i=0; i<respuesta.idUser.length; i++){				
						$('#body_tabla').append('<tr id="'+respuesta.idUser[i]+'"><td>'+(i+1)+'</td><td class="user">'+respuesta.user[i]+'</td><td class="perfil_user">'+respuesta.perfil[i]+'</td><td class="nombre_user">'+respuesta.nombre[i]+'</td><td class="email_user">'+respuesta.email[i]+'</td></tr>');
						if(respuesta.administrador){						
							$('#'+respuesta.idUser[i]).append('<td class="modificar_u"><img src="icons/page_edit.png" alt="" title="Modificar" /></td>'); 
							$('#'+respuesta.idUser[i]).append('<td class="eliminar_u"><img src="icons/page_delete.png" alt="" title="Eliminar" /></td>');					
						}	
					}
				}
				$('#tabla').append('<tfoot><tr id="nuevo"><th class="nuevo_u" colspan="5"><img src="icons/page_add.png" alt="" title="Adicionar Registro" /> Nuevo</th></tr></tfoot>');
				if(respuesta.administrador)						
					$('#nuevo').append('<th></th><th></th>');											
				$('#tabla').tablesorter({widgets: ['zebra']});	
			}									
			else				
				$('#xsoft').load('login.html');
			$('#cargando').delay(400).slideUp(1);	
		})
		.error(function() { 
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});					
	}
})(jQuery);	

(function($){
	$.fn.clientes=function(){	
		$('#cargando').show();					
		$.getJSON('x09/cliente.php', {opc:'buscar', nit_persona:'all'}, function(respuesta) {					
			if(respuesta.login){		
				$.fn.ocultar();	
				$('#admin_c').show();				
				$('#administracion').slideDown('slow');	
				$('#tabla').append('<thead><tr id="cabecera"><th width="5%">No.</th><th width="13%">Nit</th><th width="30%">Nombres</th><th width="12%">Telefono</th><th width="30%">Direccion</th></tr></thead>');
				if(respuesta.administrador)						
						$('#cabecera').append('<th width="5%"></th><th width="5%"></th>');	
				$('#tabla').append('<tbody id="body_tabla"></tbody>');		
				if(respuesta.consulta){	
					for(var i=0; i<respuesta.idCliente.length; i++){				
						$('#body_tabla').append('<tr id="'+respuesta.idCliente[i]+'"><td>'+(i+1)+'</td><td class="nit_cli">'+respuesta.nitCliente[i]+'</td><td class="nombre_cli">'+respuesta.nombreCliente[i]+'</td><td class="actividad_cli">'+respuesta.telefonoCliente[i]+'</td><td class="direccion_cli">'+respuesta.direccionCliente[i]+'</td></tr>');
						if(respuesta.administrador){						
							$('#'+respuesta.idCliente[i]).append('<td class="modificar_c"><img src="icons/page_edit.png" alt="" title="Modificar" /></td>'); 
							$('#'+respuesta.idCliente[i]).append('<td class="eliminar_c"><img src="icons/page_delete.png" alt="" title="Eliminar" /></td>');					
						}	
					}
				}
				$('#tabla').append('<tfoot><tr id="nuevo"><th class="nuevo_c" colspan="5"><img src="icons/page_add.png" alt="" title="Adicionar Registro" /> Nuevo</th></tr></tfoot>');
				if(respuesta.administrador)						
					$('#nuevo').append('<th></th><th></th>');											
				$('#tabla').tablesorter({widgets: ['zebra']});	
			}									
			else				
				$('#xsoft').load('login.html');
			$('#cargando').delay(400).slideUp(1);	
		})
		.error(function() { 
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});					
	}
})(jQuery);

//Administrar
(function($){
    $.fn.admin_usuario=function(){	
		$('#cargando').show();				
		$('.formlyAlert').remove();					
		$('#guardar_u').attr('disabled', 'disabled');		
		var datos = $('#administrar_u').serialize();			
		$.getJSON('x09/usuario.php', datos, function(respuesta) {												
			if(respuesta.consulta){	
				if(respuesta.opc == 'update'){
					$('#'+respuesta.idUser[0]+' > td.user').html(respuesta.user[0]);
					$('#'+respuesta.idUser[0]+' > td.perfil_user').html(respuesta.perfil[0]);
					$('#'+respuesta.idUser[0]+' > td.nombre_user').html(respuesta.nombre[0]);
					$('#'+respuesta.idUser[0]+' > td.email_user').html(respuesta.email[0]);					
					$('#'+respuesta.idUser[0]+' > .modificar_u').html('<img src="icons/page_refresh.png" alt="" title="Modificar" />');			
					if($('#reset_passwd').is(':checked'))
						alert('Se restablecio la Contraseña');
				}
				else{
					$('#body_tabla').append('<tr id="'+respuesta.idUser[0]+'"><td>'+($('#body_tabla tr').length+1)+'</td><td class="user">'+respuesta.user[0]+'</td><td class="perfil_user">'+respuesta.perfil[0]+'</td><td class="nombre_user">'+respuesta.nombre[0]+'</td><td class="email_user">'+respuesta.email[0]+'</td></tr>');
					if(respuesta.administrador){						
						$('#'+respuesta.idUser[0]).append('<td class="modificar_u"><img src="icons/page_edit.png" alt="" title="Modificar" /></td>'); 
						$('#'+respuesta.idUser[0]).append('<td class="eliminar_u"><img src="icons/page_delete.png" alt="" title="Eliminar" /></td>');					
					}											
					$('#tabla').tablesorter({widgets: ['zebra']});					
					$('#opc_u').attr('value', 'update');	
					$('#admin_id_usuario').attr('value', respuesta.idUser[0]);	
					$('#reset_passwd').removeAttr("checked");
					$('#opc_usuario').html(' - Modificar:<br>'+respuesta.user[0]);	
				}								
				$('#'+respuesta.idUser[0]+' > .modificar_u').css('background-color', '#0054A5');		
			}	
			else{
				$('#administrar_u').find('.formlyAlerts').append('<div class="formlyInvalid formlyAlert" id="error_u">Error: El Nombre de Usuario ya esta Registrado.</div>');
				$('#error_u').fadeIn();																		
			}	
			$('#guardar_u').removeAttr('disabled');				
			$('#cargando').delay(400).slideUp(1);					
		})
		.error(function() { 
			$('#guardar_u').removeAttr('disabled');				
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});		
	}
})(jQuery);	

(function($){
    $.fn.admin_cliente=function(){	
		$('#cargando').show();				
		$('.formlyAlert').remove();					
		$('#guardar_t').attr('disabled', 'disabled');		
		var datos = $('#administrar_c').serialize();			
		$.getJSON('x09/cliente.php', datos, function(respuesta) {												
			if(respuesta.consulta){	
				if(respuesta.opc == 'update'){
					$('#'+respuesta.idCliente[0]+' > td.nit_cli').html(respuesta.nitCliente[0]);
					$('#'+respuesta.idCliente[0]+' > td.nombre_cli').html(respuesta.nombreCliente[0]);
					$('#'+respuesta.idCliente[0]+' > td.direccion_cli').html(respuesta.direccionCliente[0]);
					$('#'+respuesta.idCliente[0]+' > td.actividad_cli').html(respuesta.telefonoCliente[0]);
					$('#'+respuesta.idCliente[0]+' > .modificar_c').html('<img src="icons/page_refresh.png" alt="" title="Modificar" />');			
				}
				else{
					$('#body_tabla').append('<tr id="'+respuesta.idCliente[0]+'"><td>'+($('#body_tabla tr').length+1)+'</td><td class="nit_cli">'+respuesta.nitCliente[0]+'</td><td class="nombre_cli">'+respuesta.nombreCliente[0]+'</td><td class="actividad_cli">'+respuesta.telefonoCliente[0]+'</td><td class="direccion_cli">'+respuesta.direccionCliente[0]+'</td></tr>');
					if(respuesta.administrador){						
						$('#'+respuesta.idCliente[0]).append('<td class="modificar_c"><img src="icons/page_edit.png" alt="" title="Modificar" /></td>'); 
						$('#'+respuesta.idCliente[0]).append('<td class="eliminar_c"><img src="icons/page_delete.png" alt="" title="Eliminar" /></td>');					
					}										
					$('#tabla').tablesorter({widgets: ['zebra']});					
					$('#opc_t').attr('value', 'update');	
					$('#admin_id_persona').attr('value', respuesta.idCliente[0]);														
					$('#opc_tercero').html(' - Modificar:<br>'+respuesta.nombreCliente[0]);
				}				
				$('#'+respuesta.idCliente[0]+' > .modificar_c').css('background-color', '#0054A5');		
			}	
			else{
				$('#administrar_c').find('.formlyAlerts').append('<div class="formlyInvalid formlyAlert" id="error_t">Error: El Nit ya esta Registrado.</div>');
				$('#error_t').fadeIn();																		
			}			
			$('#guardar_t').removeAttr('disabled');			  		
			$('#cargando').delay(400).slideUp(1);				
		})
		.error(function() {
			$('#guardar_t').removeAttr('disabled');			  		
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});		
	}
})(jQuery);	

(function($){
    $.fn.password=function(){									
			$.fn.ocultar();
			$('#cambiar_c').show();			
			$('#administracion').show('slow');			
    }
})(jQuery);	

//Eliminar
(function($){
	$.fn.borrar_u=function(){		
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();	
		var id = $(this).parent().attr("id");		
		apprise('<strong>Eliminar Usuario: </strong>'+$('#'+id+' .user').text()+'<br><br>Esta seguro de Eliminar el Usuario?', {'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){
				$('#cargando').show();											
				$.getJSON('x09/usuario.php', {id_usuario:id, opc:'delete'}, function(respuesta) {	
					if(respuesta.login){
						if(respuesta.consulta){
							$("#"+respuesta.idUser).remove();
							$('#tabla').tablesorter({widgets: ['zebra']});
							alert('Usuario eliminado Correctamente');
						}
						else
							alert('Error: No se puede Eliminar el Usuario '+respuesta.mensaje);						
					}	
					$('#cargando').delay(400).slideUp(1);					
				})
				.error(function() { 
					$('#cargando').delay(400).slideUp(1);						
					alert('Error: Compruebe la conexion de red de su equipo'); 
				});		
			}
		});
	}
})(jQuery);	

(function($){
	$.fn.borrar_c=function(){		
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();
		var id = $(this).parent().attr("id");			
		apprise('<strong>Eliminar Tercero: </strong>'+$('#'+id+' .nombre_cli').text()+'<br><br>Esta seguro de Eliminar el Tercero?', {'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {			
			if(r){
				$('#cargando').show();															
				$.getJSON('x09/cliente.php', {nit_persona:'', opc:'delete', id_persona:id}, function(respuesta) {	
					if(respuesta.login){
						if(respuesta.consulta){
							$("#"+respuesta.idCliente).remove();
							$('#tabla').tablesorter({widgets: ['zebra']});
							alert('Tercero eliminado Correctamente');
						}
						else
							alert('Error: No se puede eliminar el Tercero '+respuesta.mensaje);
					}	
					$('#cargando').delay(400).slideUp(1);					
				})
				.error(function() {
					$('#cargando').delay(400).slideUp(1);	 					
					alert('Error: Compruebe la conexion de red de su equipo'); 
				});		
			}
		});
	}
})(jQuery);

$(document).ready(function(){	
	$.getJSON('x09/sesion.php', function(respuesta){	
		$("#xsoft").load(respuesta.url);
	})
	.error(function() { 		
		alert('Error: Compruebe la conexion de red de su equipo'); 
	});	
	
	//Click	Menu						
	$('#sal').live('click', function(){		
		$('.appriseOverlay').remove();
		$('.appriseOuter').remove();			
		apprise('Esta seguro de Salir?', {'animate':true, 'verify':true, 'textYes':'Si', 'textNo':'No'}, function(r) {
			if(r){		
				$('#cargando').show();				
				$.getJSON('x09/cerrar_sesion.php', function(respuesta){																
					$('#xsoft').load(respuesta.url);
					$('#cargando').delay(400).slideUp(1);	
				})
				.error(function() { 
					$('#cargando').delay(400).slideUp(1);					
					alert('Error: Compruebe la conexion de red de su equipo'); 
				});
			}
		});	
	});	
	
	$('#fn').live('click', function(){		
		$('#formato').hide();
		$('#administracion').hide();	
		$.fn.factura();			
	});
	
	$('#bf').live('click', function(){		
		$('#formato').hide();
		$('#administracion').hide();	
		$.fn.buscar();			
	});
			
	$('#usu').live('click', function(){		
		$('#formato').hide();
		$('#administracion').hide();	
		$.fn.usuario();			
	});
	
	$('#ter').live('click', function(){		
		$('#formato').hide();
		$('#administracion').hide();	
		$.fn.clientes();			
	});
	
	$('#cc').live('click', function(){		
		$('#formato').hide();
		$('#administracion').hide();	
		$.fn.password();			
	});
	
	//Botones Cancelar	
	$('#cancelar').live('click', function(){
		$('#formato').hide();
		$('#administracion').hide();
	});
	
	$('#cancelar_b').live('click', function(){		
		$('#programas').find('option[value="0"]').attr('selected', 'selected');
	});
	
	$('#cancelar_t,#cancelar_c,#cancelar_u').live('click', function(){		
		$('#administracion').hide();
	});
			
	$('#mostrar_r').live('click', function(){		
		$('#admin_u').hide();			
		$('#admin_c').hide();						
		$('#cambiar_c').hide();
		$('#formato').hide();
		$('#buscar').show();	
		$('#administracion').slideDown('slow');											
		$('#buscar_factura').submit();	
	});
	
	//Administracion (Nuevo)
	$('.nuevo_u').live('click', function(){	
		$('#opc_u').attr('value', 'insert');	
		$('#admin_id_usuario').attr('value', '');									
		$('#admin_usuario').attr('value', '');									
		$('#admin_nombre_usuario').attr('value', '');
		$('#admin_email').attr('value', '');
		$('#tipo_usuario').find('option[value="1"]').attr('selected', 'selected');
		$('#admin_usuario').focus();
		$('#opc_usuario').html(' - Nuevo');	
	});		
	
	$('.nuevo_c').live('click', function(){	
		$('#opc_t').attr('value', 'insert');	
		$('#admin_id_persona').attr('value', '');									
		$('#admin_nit_persona').attr('value', '');									
		$('#admin_persona_natural').attr('value', '');
		$('#admin_telefono').attr('value', '');
		$('#admin_direccion_persona').attr('value', '');					
		$('#admin_nit_persona').focus();
		$('#opc_tercero').html(' - Nuevo');	
	});				
	
	//Administracion (Modificar)
	$('.modificar_u').live('click', function(){	
		$('#cargando').show();
		var id = $(this).parent().attr('id');		
		$('#'+id+' .modificar_u').addClass('actual');	
		$('#'+id+' .actual').removeClass('modificar_u');			
		$.getJSON('x09/usuario.php', {id_usuario:id, opc:''}, function(respuesta) {				
			if(respuesta.login){				
				if(respuesta.consulta){				
					$('#opc_u').attr('value', 'update');	
					$('#admin_id_usuario').attr('value', respuesta.idUser[0]);									
					$('#admin_usuario').attr('value', respuesta.user[0]);									
					$('#admin_nombre_usuario').attr('value', respuesta.nombre[0]);
					$('#admin_email').attr('value', respuesta.email[0]);
					$('#tipo_usuario').find('option[value="'+respuesta.idPerfil[0]+'"]').attr('selected', 'selected');				
					$('#reset_passwd').removeAttr("checked");
					$('#admin_usuario').focus();
					$('#opc_usuario').html(' - Modificar:<br>'+respuesta.user[0]);
				}
			}
			else
				$('#xsoft').load('login.html');			
			$('#'+id+' .actual').addClass('modificar_u');	
			$('#'+id+' .modificar_u').removeClass('actual');
			$('#cargando').delay(400).slideUp(1);					
		})
		.error(function() { 
			$('#'+id+' .actual').addClass('modificar_u');	
			$('#'+id+' .modificar_u').removeClass('actual');
			$('#cargando').delay(400).slideUp(1);			
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});		
	});
	
	$('.modificar_c').live('click', function(){	
		$('#cargando').show();
		var id = $(this).parent().attr('id');		
		$('#'+id+' .modificar_c').addClass('actual');	
		$('#'+id+' .actual').removeClass('modificar_c');	
		$.getJSON('x09/cliente.php', {nit_persona:'', opc:'', id_persona:id}, function(respuesta) {				
			if(respuesta.login){				
				if(respuesta.consulta){				
					$('#opc_t').attr('value', 'update');	
					$('#admin_id_persona').attr('value', respuesta.idCliente[0]);									
					$('#admin_nit_persona').attr('value', respuesta.nitCliente[0]);									
					$('#admin_persona_natural').attr('value', respuesta.nombreCliente[0]);
					$('#admin_telefono').attr('value', respuesta.telefonoCliente[0]);
					$('#admin_direccion_persona').attr('value', respuesta.direccionCliente[0]);					
					$('#admin_nit_persona').focus();
					$('#opc_tercero').html(' - Modificar:<br>'+respuesta.nombreCliente[0]);					
				}
			}
			else
				$('#xsoft').load('login.html');				
			$('#'+id+' .actual').addClass('modificar_c');	
			$('#'+id+' .modificar_c').removeClass('actual');	
			$('#cargando').delay(400).slideUp(1);		
		})
		.error(function() { 
			$('#'+id+' .actual').addClass('modificar_c');	
			$('#'+id+' .modificar_c').removeClass('actual');
			$('#cargando').delay(400).slideUp(1);			
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});		
	});	
	
	//Cargar Cliente / Factura
	$('.cargar_cliente').live('click', function(){	
		$('#id_persona').attr('value', $(this).attr('id'));
		$('#persona_natural').attr('value', $(this).text());
		$('#nit_persona').attr('value', $(this).attr('title'));
		$('#direccion_persona').attr('value', $(this).attr('alt'));
		$('#telefono').attr('value', $(this).attr('label'));	
		$('#buscar_nombre_cliente').attr('value', '');	
		$('#mostrar_n').empty();
	});	
	
	
	$('.cargar_factura').live('click', function(){	
		$('#cargando').show();
		var num = $(this).text();
		var id = $(this).parent().attr('id');				
		$('#'+id+' .cargar_factura').addClass('actual');	
		$('#'+id+' .actual').removeClass('cargar_factura');	
		$.getJSON('x09/buscar_factura.php', {numero_factura:num}, function(respuesta) {				
			if(respuesta.login){				
				if(respuesta.consulta){					
					$('#administracion').hide();					
					$('#formato').slideDown('slow');					
					$.fn.cargar(respuesta);	
				}
			}
			else
				$('#xsoft').load('login.html');				
			$('#'+id+' .actual').addClass('cargar_factura');	
			$('#'+id+' .cargar_factura').removeClass('actual');	
			$('#cargando').delay(400).slideUp(1);		
		})
		.error(function() { 
			$('#'+id+' .actual').addClass('cargar_factura');	
			$('#'+id+' .cargar_factura').removeClass('actual');	
			$('#cargando').delay(400).slideUp(1);			
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});	
	});	
	
	//Administracion (Eliminar)	
	$('.eliminar_u').live('click', function(){
		$(this).borrar_u();
	});
		
	$('.eliminar_c').live('click', function(){
		$(this).borrar_c();
	});	
	
	//Checkbox
	$('#modificar_factura').live('click', function(event){
		if($('#modificar_factura').is(':checked')){
			$('#info_factura input,#info_factura textarea').removeAttr('readonly');
			$('.calendario').css('display', 'block');
			$('#numero_factura').attr('readonly', true);	
		}
		else{
			$('#info_factura input,#info_factura textarea').attr('readonly', true);	
			$('.calendario').css('display', 'none');
		}
	});	
	
});