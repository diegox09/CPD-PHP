(function($){	
    $.fn.obligatorio=function(){		
		var id = $(this).attr('id');
		if($(this).attr('value') != ''){
			$('#mensaje_'+id).html('');	
			$(this).removeClass('input_error');		
			return true;
		}
		else{
			$('#mensaje_'+id).html($(this).attr('label'));
			$('#mensaje_'+id).css('color', '#d14836');	
			$(this).addClass('input_error');	
			$(this).focus();
			return false;
		}
    }
})(jQuery);

$(document).ready(function(){		
	$("#form_login").submit(function(event){
		event.preventDefault();
		if($("#usuario").obligatorio() && $("#passwd").obligatorio()){			
			$("#acceder").attr("disabled","disabled");
			$("#cargando").show();			
			var datos=$(this).serialize();
			$.getJSON("php/login.php",datos,function(respuesta){
				if(respuesta.login)
					window.location = 'contenido.php';
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
	
	$("#enlace_login").click(function(event){
		$("#div_login").hide();
		$("#div_passwd").show();		
	});
	
	$("#form_passwd").submit(function(event){
		event.preventDefault();
		if($("#usuario_passwd").obligatorio()){			
			$("#recordar").attr("disabled","disabled");
			$("#cargando").show();			
			var datos=$(this).serialize();
			$.getJSON("php/passwd.php",datos,function(respuesta){
				if(respuesta.consulta){	
					if(respuesta.error)
						$("#error").html('Error al enviar el correo electrónico');
					else
						$("#error").html('Se enviaron sus datos de ingreso a la dirección de correo electrónico: '+respuesta.email);
				}
				else
					$("#error").html('El nombre de usuario: '+respuesta.usuario+' no esta registrado');
					
				$("#usuario_passwd").attr("value", "");
				$("#usuario_passwd").focus();
				$("#recordar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);							
			}).error(function(){
				$("#recordar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - passwd");
			})
		}
	});
	
	$("#enlace_passwd").click(function(event){
		$("#div_passwd").hide();
		$("#div_login").show();		
	});
	
	$(document).keydown(function (event) {
		if(event.keyCode==8){			
			if(!$('input').is (':focus'))
				event.preventDefault();
		}
	});	
	
	$("#cargando").delay(400).slideUp(0);
	$("#usuario").focus();
});