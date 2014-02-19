$(document).ready(function(){	
	document.title="Colombia Humanitaria - Login";
	$("#login").show();		
		
 	$("#form_login").submit(function(event){
		event.preventDefault();
		if($("#usuario").obligatorio() && $("#passwd").obligatorio()){			
			$("#acceder").attr("disabled","disabled");
			$("#cargando").show();			
			var datos=$(this).serialize();
			$.getJSON("php/login.php",datos,function(respuesta){
				if(respuesta.login)
					window.location = 'soft';
				else{					
					$('#mensaje_passwd').html('Nombre de usuario o Contraseña Incorrectos.');
					$('#mensaje_passwd').css('color', '#d14836');
					$("#passwd").attr("value", "");
					$("#passwd").focus();
					$("#acceder").removeAttr("disabled");
					$("#cargando").delay(400).slideUp(0);						
				}							
			}).error(function(){
				$("#acceder").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - login");
			})
		}
	});	
						
	$("#cargando").delay(400).slideUp(0);
	$("#usuario").focus();	
});