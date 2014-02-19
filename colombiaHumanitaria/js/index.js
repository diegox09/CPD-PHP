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
	$.getJSON('php/sesion.php', function(respuesta){
		if(respuesta.url == 'soft')
			window.location = 'soft';	
		else
			$("#contenido").load(respuesta.url); 	
	})
	.error(function() { 		
		$('#error').html('Error: Compruebe la conexion de red de su equipo! - index'); 
	});
	
	//key
	$(document).keydown(function (event) {
		if(event.keyCode==8){			
			if(!$('input').is (':focus'))
				event.preventDefault();
		}
	});	
});