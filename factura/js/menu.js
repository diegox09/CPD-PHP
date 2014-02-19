$(document).ready(function(){		
	$('#submenu').empty();
	$('#guardar_factura').formly();	
	$('#buscar_nombre').formly();
	$('#buscar_factura').formly();
	$('#administrar_u').formly();	
	$('#administrar_c').formly();
	$('#cambiar_password').formly();
			
	//Menu	
	$.getJSON('x09/menu.php', function(respuesta) {
		if(respuesta.login){				
			var submenu = '';	
			for(var i=0; i<respuesta.menu.length; i++){
				submenu = respuesta.menu[i].submenu;
				$('#submenu').append('<li><a class="submenu" href="#">'+submenu+'<span class="arrow"></span></a><ul id="'+submenu+'"></ul></li>');
				for(var j=0; j<respuesta.menu[i].items.length; j++){
					items = respuesta.menu[i].items[j];					
					iniciales = respuesta.menu[i].iniciales[j];					
					$('#'+submenu).append('<li><a class="item" href="#" id="'+iniciales+'">'+items+'</a></li>');					
				}
			}
			$('.menu').fixedMenu();				
			if(respuesta.user != ''){			
				document.title = respuesta.perfil+': '+respuesta.user;									
				$('#id_user').attr('value', respuesta.idUser);
			}
			$('#submenu').show();
		}								
		else				
			$('#xsoft').load('login.html');
		$('#cargando').delay(400).slideUp(1);	
	})
	.error(function() { 	
		$('#cargando').delay(400).slideUp(1); 	
		alert('Error: Compruebe la conexion de red de su equipo');		
	});		
		
	//Formularios
	$('#guardar_factura').submit(function(event){
		event.preventDefault();		
		if($('#nit_persona').attr('value') != ''){	
			$('#cargando').show();						
			$('#guardar').attr('disabled', 'disabled');						
			var datos = $('#info_factura').serialize();			
			$.getJSON('x09/factura.php', datos, function(respuesta) {												
				if(respuesta.consulta){
					$.fn.cargar(respuesta);	
					$('#cargando').hide(); 
					var imp = false;	
					if($('#imprimir_factura_c2').is(':checked')){						
						$('#copia2_factura').css('display', 'block');						
						imp = true;
					}
					else
						$('#copia2_factura').css('display', 'none');
						
					if($('#imprimir_factura_c1').is(':checked')){						
						$('#copia_factura').css('display', 'block');						
						imp = true;
					 }
					 else
						$('#copia_factura').css('display', 'none');	
						
					if($('#imprimir_factura_o').is(':checked')){						
						$('#original_factura').css('display', 'block');						
						imp = true;
					 }
					 else
						$('#original_factura').css('display', 'none');
					
					if(imp)	
						window.print();
					else
						alert('Factura Guardada Correctamente');								
				}	
				else{					
					if(respuesta.error)
						alert('Error: No se pueden crear mas Facturas');
					else	
						alert('Error al Actualizar la Informacion');					
				}
				$('#guardar').removeAttr('disabled');				 		
				$('#cargando').delay(400).slideUp(1);								
			})
			.error(function() { 
				$('#guardar').removeAttr('disabled');				 		
				$('#cargando').delay(400).slideUp(1);				
				alert('Error: Compruebe la conexion de red de su equipo'); 
			});				
		}
		else{
			$('#nit_persona').focus();
			alert('Por Favor digite el Nit de la persona');
		}
 	});	
	
	$('#buscar_factura').submit(function(event){
		event.preventDefault();	
		$('#cargando').show();
		$('#buscar_b').attr('disabled', 'disabled');			
		$('#opc_buscar').attr('value', '@buscador');							
		var datos = $(this).serialize();			
		$.getJSON('x09/buscar_factura.php', datos, function(respuesta) {
			$('#tabla').empty();													
			if(respuesta.consulta){								
				$('#tabla').append('<thead><tr id="cabecera"><th width="10%">Numero</th><th width="10%">Fecha</th><th width="20%">Nit</th><th width="60%">Nombre</th></tr></thead>');				
				$('#tabla').append('<tbody id="body_tabla"></tbody>');					
				var clase, idUser=$('#id_user').attr('value');
				for(var i=0; i<respuesta.idFactura.length; i++){
					if(respuesta.administrador)
						clase = 'cargar_factura';
					else{
						if(respuesta.idUser[i] == idUser)
							clase = 'cargar_factura';
						else	
							clase = 'center';										
					}
					$('#body_tabla').append('<tr id="'+respuesta.idFactura[i]+'"><td class="'+clase+'">'+respuesta.numeroFactura[i]+'</td><td>'+respuesta.fecha[i]+'</td><td class="nit_cli">'+respuesta.nitCliente[i]+'</td><td class="nombre_cli">'+respuesta.nombreCliente[i]+'</td></tr>');
					if(respuesta.estadoFactura[i] == '2')
						$('#'+respuesta.idFactura[i]+' > .cargar_factura,  #'+respuesta.idFactura[i]+' > .center').css('background-color', '#ff0000');										
				}											
				$('#tabla').tablesorter({widgets: ['zebra']});		
			}	
			else					
				alert('No se encontro ningun Resultado');
			$('#buscar_b').removeAttr('disabled');			
			$('#cargando').delay(400).slideUp(1);							
		})
		.error(function() { 
			$('#buscar_b').removeAttr('disabled');			
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});	
 	});
	
	$('#buscar_nombre').submit(function(event){
		event.preventDefault();			
 	});	
	
	//Formularios Administracion
	$('#administrar_u').submit(function(event){
		event.preventDefault();	
		if(($('#admin_id_usuario').attr('value') != '' || $('#opc_u').attr('value') == 'insert') && $('#admin_usuario').attr('value') != '')	
			$.fn.admin_usuario();
		else
			alert('Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada');
 	});
	
	$('#administrar_c').submit(function(event){
		event.preventDefault();	
		if(($('#admin_id_persona').attr('value') != '' || $('#opc_t').attr('value') == 'insert') && $('#admin_nit_persona').attr('value') != '')	
			$.fn.admin_cliente();
		else
			alert('Seleccione una opcion: (Modificar - Nuevo) y digite la informacion solicitada');
 	});
		
	$('#cambiar_password').submit(function(event){
		event.preventDefault();
		$('.formlyAlert').remove();		
		$('#opc_c').attr('value', 'pas');
		if($('#passwd_act').attr('value') != '' && $('#passwd_new').attr('value') != '' && $('#passwd_repeat').attr('value') != ''){	
			if($('#passwd_new').attr('value') == $('#passwd_repeat').attr('value')){	
				$('#cargando').show();
				$('#guardar_c').attr('disabled', 'disabled');										
				var datos = $(this).serialize();			
				$.getJSON('x09/usuario.php', datos, function(respuesta) {													
					if(respuesta.consulta){						
						$('#passwd_act').attr('value', '');
						$('#passwd_new').attr('value', '');
						$('#passwd_repeat').attr('value', '');
						$('#administracion').hide('slow');						
						alert('Contraseña Cambiada Correctamente');							
					}
					else{					
						$('#cambiar_password').find('.formlyAlerts').append('<div class="formlyInvalid formlyAlert" id="error_c">La contraseña actual es Incorrecta.</div>');
						$('#error_c').fadeIn();									
					}
					$('#guardar_c').removeAttr('disabled');	
					$('#cargando').delay(400).slideUp(1);
				})
				.error(function() { 
					$('#guardar_c').removeAttr('disabled');	
					$('#cargando').delay(400).slideUp(1);
					alert('Error: Compruebe la conexion de red de su equipo'); 
				});		
			}
			else
				alert('La contraseña nueva debe ser igual en los dos campos');			
		}
 	});
		
	//Change	
	$('#numero_factura').change(function(event){			
		$('#cargando').show();						
		var numero = $(this).attr('value');	
		$.getJSON('x09/buscar_factura.php', {numero_factura:numero}, function(respuesta) {				
			if(respuesta.login){
				if(respuesta.consulta)	
					$.fn.cargar(respuesta);
				else{
					alert('El Numero de Factura no Existe');
					$.fn.limpiar();	
				}
			}
			else
				$('#xsoft').load('login.html');	
			$('#cargando').delay(400).slideUp(1);							
		})
		.error(function() {
			$('#cargando').delay(400).slideUp(1);
			alert('Error: Compruebe la conexion de red de su equipo'); 
		});		
 	});	
	
	$('#nit_persona').change(function(event){	
		var nit = $(this).attr('value');
		if(nit != ''){
			$('#cargando').show();	
			$.getJSON('x09/cliente.php', {opc:'buscar', nit_persona:nit}, function(respuesta) {				
				if(respuesta.login){
					if(respuesta.consulta){														
						$('#id_persona').attr('value', respuesta.idCliente[0]);									
						$('#persona_natural').attr('value', respuesta.nombreCliente[0]);
						$('#telefono').attr('value', respuesta.telefonoCliente[0]);
						$('#direccion_persona').attr('value', respuesta.direccionCliente[0]);					
					}
					else{
						$('#id_persona').attr('value', '');									
						$('#persona_natural').attr('value', '');
						$('#telefono').attr('value', '');
						$('#direccion_persona').attr('value', '');	
					}
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
			$('#id_persona').attr('value', '');	
			$('#persona_natural').attr('value', '');
			$('#actividad_economica').attr('value', '');
			$('#direccion_persona').attr('value', '');
		}
 	});
		
	//Key
	$('#buscar_nombre_cliente').keyup(function (e) {
		var nombres	= $(this).attr('value');
		if(nombres.length > 2){	
			$('#cargando').show();	
			$.getJSON('x09/cliente.php', {nit_persona:'', opc:'buscar_n', persona_natural:nombres}, function(respuesta) {				
				if(respuesta.login){	
					$('#mostrar_n').empty();			
					if(respuesta.consulta){							
						for(var i=0; i<respuesta.idCliente.length; i++){						
							$('#mostrar_n').append('<ul><li class="lista"><a href="#" class="cargar_cliente" id="'+respuesta.idCliente[i]+'" title="'+respuesta.nitCliente[i]+'" alt="'+respuesta.direccionCliente[i]+'" label="'+respuesta.telefonoCliente[i]+'">'+respuesta.nombreCliente[i]+'</a></li></ul>');
						}
					}
					else{
						$('#mostrar_n').html('<ul><li class="lista">No se encontro ningun Resultado</li></ul>');	
					}
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
		else
			$('#mostrar_n').empty();
	});	
	
	$('.input_s, .input_iva').keyup(function (e) {
		$.fn.subtotal();
	});
		
	$('.input_d').change(function (e) {		
		$('#mostrar_descripcion').html($('#descripcion').attr('value'));
	});
		
	$(document).keydown(function (e) {
		if(e.keyCode==27)
			$('.active').removeClass('active');
	});	
});