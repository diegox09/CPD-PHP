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
		
	$("#cargando").delay(400).slideUp(0);
});