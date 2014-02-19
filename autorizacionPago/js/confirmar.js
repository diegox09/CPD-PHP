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
	
	$("#imprimir").click(function(event){		
		var imprimir = $('#lista').attr('value');	
		window.open('../pdf/ap_pdf.php?id_ap='+imprimir);
	});
		
	$("#cargando").delay(400).slideUp(0);
});