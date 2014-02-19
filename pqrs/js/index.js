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
					window.location = 'inbox.php';
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
	
	$(document).keydown(function (event) {
		if(event.keyCode==8){			
			if(!$('input').is (':focus'))
				event.preventDefault();
		}
	});	
	
	$("#cargando").delay(400).slideUp(0);
	$("#usuario").focus();
});