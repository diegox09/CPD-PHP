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
	$("#pqrs_nuevo").click(function(event){
		$("#resultado_pqrs").slideUp();
		$("#info_pqrs").slideDown();
	});
	
	$("#form_buscar").submit(function(event){
		event.preventDefault();		
		if($("#input_buscar").obligatorio()){									
			$("#pqrs_buscar").attr("disabled","disabled");
			$("#cargando").show();	
			
			$("#info_pqrs").slideUp();
			$("#resultado_pqrs").slideDown();
			/*		
			var datos=$(this).serialize();
			$.getJSON("php/buscar.php",datos,function(respuesta){
				if(respuesta.login){
				}	
				$("#pqrs_buscar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);	
			}).error(function(){
				$("#pqrs_buscar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - buscar");
			})
			*/
			$("#pqrs_buscar").removeAttr("disabled");
			$("#cargando").delay(400).slideUp(0);
		}
	});
	
	$("#form_pqrs").submit(function(event){
		event.preventDefault();		
		if($("#documento").obligatorio()){									
			$("#pqrs_guardar").attr("disabled","disabled");
			$("#cargando").show();	
			
			$("#info_pqrs").slideUp();
			$("#buscar_pqrs").slideDown();
			/*		
			var datos=$(this).serialize();
			$.getJSON("php/buscar.php",datos,function(respuesta){
				if(respuesta.login){
				}	
				$("#pqrs_guardar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);	
			}).error(function(){
				$("#pqrs_guardar").removeAttr("disabled");
				$("#cargando").delay(400).slideUp(0);
				$('#error').html("Error: Compruebe la conexion de red de su equipo! - pqrs");
			})
			*/
			$("#pqrs_guardar").removeAttr("disabled");
			$("#cargando").delay(400).slideUp(0);	
		}
	});
	
	$('#ver_pqrs').click(function(){
		var href = 'pdf/pqrs_pdf.php?id='+$('#id_pqrs').attr('value');		
		window.open(href);
	});
	
	$('.ver_pqrs').live('click', function(){
		var href = 'pdf/pqrs_pdf.php?id=1';		
		window.open(href);
	});
	
	$(".editar_pqrs").click(function(event){
		$("#resultado_pqrs").slideUp();
		$("#info_pqrs").slideDown();
	});
	
	$("#cancelar_pqrs").click(function(event){		
		$("#info_pqrs").slideUp();
		$("#resultado_pqrs").slideDown();
	});
						
	$("#cargando").delay(400).slideUp(0);
	$("#usuario").focus();	
});