$(document).ready(function(){
	$.getJSON('php/perfil.php', function(respuesta){
		$('#nombre_user').html(respuesta.user);	
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - perfil'); 
	});	
		
	$("#cargando").delay(400).slideUp(0);
});