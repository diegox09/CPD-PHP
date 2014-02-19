<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />	
<meta name="author" content="Diego Fernando Rodriguez Rincon" >
<title>FOMANORT</title>    
<link rel="shortcut icon" href="../icons/application_home.png" type="image/ico" />		
    	
    <link rel="stylesheet" type="text/css" href="../css/estilo.css" />  
    
    <link rel="stylesheet" type="text/css" href="../build/fonts/fonts-min.css" />
	<link rel="stylesheet" type="text/css" href="../build/button/assets/skins/sam/button.css" />
	<link rel="stylesheet" type="text/css" href="../build/container/assets/skins/sam/container.css" />
            
   	<style>				
		label { font-weight:bold;}
		#cargando {width:180%; height:22px;}
        .boton {background:url(../imagenes/n3.png); border-radius:5px; border:1px solid #000; padding:7px; color:#000; font-weight:bold; box-shadow: 3px 3px 8px #999;}	
		.boton:focus {background:url(../imagenes/n2.gif);}
		.boton:hover {background:url(../imagenes/n2.gif);}
		input {width:88%;}
		input.mod {width:78%;}
		input.mod_2 {width:58%;}
		select {width:90%;}			
		table thead{ background:#F0F8FF;}
		table tr:hover {background:#F0F8FF;}
		table {border-spacing:5px;}	
		.centrado {text-align:center;}
		#maraton {-moz-border-radius:10px; box-shadow: 3px 3px 8px #999;}
	</style> 
     
    <script type="text/javascript" src="../build/yahoo/yahoo-min.js"></script>
    <script type="text/javascript" src="../build/event/event-min.js"></script>
    <script type="text/javascript" src="../build/connection/connection-min.js"></script>

	<script type="text/javascript" src="../build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="../build/element/element-beta-min.js"></script>
    <script type="text/javascript" src="../build/button/button-min.js"></script>
    <script type="text/javascript" src="../build/container/container-min.js"></script>
    
    <script type="text/javascript" src="../build/utilities/utilities.js"></script>
    
    <script> 		
		var handleSuccessActualizar = function(o) {																				
			var response = o.responseXML;
			//alert(o.responseText);	
			var mensaje = response.getElementsByTagName("mensaje")[0];
			var error = mensaje.getElementsByTagName("error");
			var codigo = mensaje.getElementsByTagName("codigo")[0].firstChild.nodeValue;													
			if(error.length == 0){				
				campos = ["", "siguiente", "nombres", "apellidos", "entidad", "pais", "telefono", "direccion",  "eps", "rh", "siguiente", "siguiente", "siguiente"];			
				document.getElementById(campos[codigo]).focus();
				if(mensaje.getElementsByTagName("nuevo")[0].firstChild.nodeValue == "no"){						
					if(mensaje.getElementsByTagName("actualizar")[0].firstChild.nodeValue == "1" || mensaje.getElementsByTagName("actualizar")[0].firstChild.nodeValue == "11"|| mensaje.getElementsByTagName("actualizar")[0].firstChild.nodeValue == "12"){	
						limpiarTodo();
						if(mensaje.getElementsByTagName("id")[0].firstChild != null)						
							document.getElementById("id_deportista").value = mensaje.getElementsByTagName("id")[0].firstChild.nodeValue;
						
						if(mensaje.getElementsByTagName("documento")[0].firstChild != null)
							document.getElementById("documento").value = mensaje.getElementsByTagName("documento")[0].firstChild.nodeValue;	
							
						if(mensaje.getElementsByTagName("td")[0].firstChild != null){	
							var td = parseInt(mensaje.getElementsByTagName("td")[0].firstChild.nodeValue);
							document.getElementById("td").options[td].selected = true;	
						}
							
						if(mensaje.getElementsByTagName("nombres")[0].firstChild != null)
							document.getElementById("nombres").value = mensaje.getElementsByTagName("nombres")[0].firstChild.nodeValue;
							
						if(mensaje.getElementsByTagName("apellidos")[0].firstChild != null)
							document.getElementById("apellidos").value = mensaje.getElementsByTagName("apellidos")[0].firstChild.nodeValue;
																		
						if(mensaje.getElementsByTagName("entidad")[0].firstChild != null)
							document.getElementById("entidad").value = mensaje.getElementsByTagName("entidad")[0].firstChild.nodeValue;
							
						if(mensaje.getElementsByTagName("pais")[0].firstChild != null)
							document.getElementById("pais").value = mensaje.getElementsByTagName("pais")[0].firstChild.nodeValue;	
																	
						if(mensaje.getElementsByTagName("telefono")[0].firstChild != null)
							document.getElementById("telefono").value = mensaje.getElementsByTagName("telefono")[0].firstChild.nodeValue;
						
						if(mensaje.getElementsByTagName("direccion")[0].firstChild != null)
							document.getElementById("direccion").value = mensaje.getElementsByTagName("direccion")[0].firstChild.nodeValue;	
						
						if(mensaje.getElementsByTagName("eps")[0].firstChild != null)
							document.getElementById("eps").value = mensaje.getElementsByTagName("eps")[0].firstChild.nodeValue;	
						
						if(mensaje.getElementsByTagName("rh")[0].firstChild != null)
							document.getElementById("rh").value = mensaje.getElementsByTagName("rh")[0].firstChild.nodeValue;

						if(mensaje.getElementsByTagName("categoria")[0].firstChild != null)
							document.getElementById("categoria").value = mensaje.getElementsByTagName("categoria")[0].firstChild.nodeValue;
						
						if(mensaje.getElementsByTagName("numero")[0].firstChild != null)
							document.getElementById("numero").value = mensaje.getElementsByTagName("numero")[0].firstChild.nodeValue;							
																
						document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Deportista Cargado Correctamente";
					}
					else{
						document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Deportista Modificado Correctamente";
					}
				}
				else{
					limpiarTodo();
					if(codigo == "1"){
						init_n();
						document.getElementById("show_n").click();	
						document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Desea Crear un Nuevo Deportista";
					}
					else{
						document.getElementById("documento").value = "";
						document.getElementById("documento").focus();	
						document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> Numero de Camiseta no Registrado";
					}
				}
			}	
			else{
				codigo = parseInt(codigo);		
				switch(codigo){
					case 11:if(mensaje.getElementsByTagName("categoria")[0].firstChild != null){	
								var categoria = parseInt(mensaje.getElementsByTagName("categoria")[0].firstChild.nodeValue);
								document.getElementById("categoria").options[categoria].selected = true;	
							}	
							break;
					case 12:document.getElementById("numero").value = "";
							document.getElementById("numero").focus();	
							break;						
				}						
				mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
				document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
				alert(mensaje);	
			}
		};	
		
		var handleSuccessNuevo = function(o) {																				
			var response = o.responseXML;
			//alert(o.responseText);	
			var mensaje = response.getElementsByTagName("mensaje")[0];
			var error = mensaje.getElementsByTagName("error");
			
			if(error.length == 0){				
				document.getElementById("td").focus();
				if(mensaje.getElementsByTagName("id")[0].firstChild != null)						
					document.getElementById("id_deportista").value = mensaje.getElementsByTagName("id")[0].firstChild.nodeValue;
				document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Deportista Creado Correctamente";	
			}
			else{				
				mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
				document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
				alert(mensaje);	
			}
		};
		
		var handleSuccessEliminar = function(o) {																				
			var response = o.responseXML;
			//alert(o.responseText);	
			var mensaje = response.getElementsByTagName("mensaje")[0];
			var error = mensaje.getElementsByTagName("error");
			if(error.length == 0){
				limpiarTodo();
				document.getElementById("documento").value="";
				document.getElementById("documento").focus();
				document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Deportista Eliminado Correctamente";
			}	
			else{				
				mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
				document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
				alert(mensaje);	
			}
		};

		var handleSuccessCategorias = function(o) {																				
			var response = o.responseXML;
			//alert(o.responseText);	
			var mensaje = response.getElementsByTagName("mensaje")[0];
			var error = mensaje.getElementsByTagName("error");
						
			if(error.length == 0){
				categoria = mensaje.getElementsByTagName("categoria");
				if(categoria.length != 0){					
					for(i=0; i<categoria.length; i++){
						id = "";
						descripcion = "";
						if(categoria[i].getElementsByTagName("id")[0].firstChild != null)
							id = categoria[i].getElementsByTagName("id")[0].firstChild.nodeValue;					
						
						if(categoria[i].getElementsByTagName("descripcion")[0].firstChild != null)					
							descripcion = categoria[i].getElementsByTagName("descripcion")[0].firstChild.nodeValue;
							
						option = document.createElement('option');
						option.setAttribute("value",id)
						option.innerHTML = descripcion;
						document.getElementById('categoria').appendChild(option);	
					}
				}				
				document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Categorias cargadas Correctamente";
			}	
			else{				
				mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
				document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
				alert(mensaje);	
			}
		};		
		
		var handleFailure = function(o) {
			document.getElementById("documento").value="";
            alert("Submission failed: " + o.status);
        };
		
		var callbackActualizar = {
            success:handleSuccessActualizar,
            failure:handleFailure,				
        };
		
		var callbackNuevo = {
            success:handleSuccessNuevo,
            failure:handleFailure,				
        };
		
		var callbackEliminar = {
            success:handleSuccessEliminar,
            failure:handleFailure,				
        };
		
		var callbackCategorias = {
            success:handleSuccessCategorias,
            failure:handleFailure,				
        };
		
		function makeRequestActualizar(id, opc, campo){
			document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando..."; 			
			var sUrl = "actualizar.php";
			var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackActualizar, 'id='+id+'&opc='+opc+'&campo='+campo);
        };
		
		function makeRequestNuevo(){
			document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando..."; 			
			var sUrl = "nuevo.php";
			var documento = document.getElementById("documento").value;
			var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackNuevo, 'documento='+documento);
        };
		
		function makeRequestEliminar(id){
			document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando..."; 			
			var sUrl = "eliminar.php";
			var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackEliminar, 'id='+id);
        };
		
		function makeRequestCategorias(){
			document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando..."; 			
			var sUrl = "categorias.php";
			var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackCategorias, '');
        };
				
		YAHOO.namespace("example.container");
		function init() {			
			// Define various event handlers for Dialog
			var handleSi = function() {
				eliminar();
				this.hide();
			};
			var handleNo = function() {
				this.hide();
			};		
			// Instantiate the Dialog
			YAHOO.example.container.simpledialog1 = new YAHOO.widget.SimpleDialog("simpledialog1", 
											 { width: "300px",
											   fixedcenter: true,
											   visible: false,
											   draggable: false,
											   close: true,
											   text: "Desea Eliminar el Deportista.<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No. Doc.: " + document.getElementById("documento").value + "<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nombre: "+document.getElementById("nombres").value + " " + document.getElementById("apellidos").value,
											   icon: YAHOO.widget.SimpleDialog.ICON_HELP,
											   constraintoviewport: true,
											   buttons: [ { text:"Si", handler:handleSi, isDefault:true },
														  { text:"No",  handler:handleNo } ]
											 } );
			YAHOO.example.container.simpledialog1.setHeader("Estas Seguro de Continuar?");
			
			// Render the Dialog
			YAHOO.example.container.simpledialog1.render("container");
		
			YAHOO.util.Event.addListener("show", "click", YAHOO.example.container.simpledialog1.show, YAHOO.example.container.simpledialog1, true);				
		}		
		YAHOO.util.Event.addListener(window, "load", init);
		
		function init_n() {			
			// Define various event handlers for Dialog
			var handleSi = function() {
				makeRequestNuevo();
				this.hide();
			};
			var handleNo = function() {				
				limpiarTodo();	
				document.getElementById("documento").value="";
				document.getElementById("documento").focus();
				this.hide();
			};		
			// Instantiate the Dialog
			YAHOO.example.container.simpledialog2 = new YAHOO.widget.SimpleDialog("simpledialog2", 
											 { width: "300px",
											   fixedcenter: true,
											   visible: false,
											   draggable: false,
											   close: true,
											   text: "Desea Crear un Nuevo Deportista.<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No. Doc.: " + document.getElementById("documento").value,
											   icon: YAHOO.widget.SimpleDialog.ICON_HELP,
											   constraintoviewport: true,
											   buttons: [ { text:"Si", handler:handleSi, isDefault:true },
														  { text:"No",  handler:handleNo } ]
											 } );
			YAHOO.example.container.simpledialog2.setHeader("Estas Seguro de Continuar?");
			
			// Render the Dialog
			YAHOO.example.container.simpledialog2.render("container");
		
			YAHOO.util.Event.addListener("show_n", "click", YAHOO.example.container.simpledialog2.show, YAHOO.example.container.simpledialog2, true);				
		}		
		YAHOO.util.Event.addListener(window, "load", init_n);
		
		function init_m() {	
			// Define various event handlers for Dialog
			var handleSubmit = function() {
				document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando...";
				this.submit();
			};
			var handleCancel = function() {
				this.cancel();
			};
			var handleSuccess = function(o) {
				var response = o.responseXML;
				//alert(o.responseText);	
				var mensaje = response.getElementsByTagName("mensaje")[0];
				var error = mensaje.getElementsByTagName("error");							
				if(error.length == 0){	
					if(mensaje.getElementsByTagName("documento")[0].firstChild != null)
						document.getElementById("documento").value = mensaje.getElementsByTagName("documento")[0].firstChild.nodeValue;
					document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Documento Modificado Correctamente";
				}
				else{				
					mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
					document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
					alert(mensaje);	
				}
			};
			var handleFailure = function(o) {
				alert("Submission failed: " + o.status);				
			};
		
			// Instantiate the Dialog
			YAHOO.example.container.dialog1 = new YAHOO.widget.Dialog("dialog1", 
									{ width : "300px",
									  fixedcenter : true,
									  visible : false, 
									  constraintoviewport : true,
									  buttons : [ { text:"Modificar", handler:handleSubmit, isDefault:true },
											  { text:"Cancelar", handler:handleCancel } ]
									});
		
			// Validate the entries in the form to require that both first and last name are entered
			YAHOO.example.container.dialog1.validate = function() {
				var data = this.getData();
				if (isNaN(data.documento_m) || data.documento_m == "") {
					alert("Digite un numero de Documento Valido.");
					document.getElementById("mod").documento_m.focus();	
					return false;
				} else {
					return true;
				}
			};
		
			// Wire up the success and failure handlers
			YAHOO.example.container.dialog1.callback = { success: handleSuccess,
									 failure: handleFailure };
			
			// Render the Dialog
			YAHOO.example.container.dialog1.render();
		
			YAHOO.util.Event.addListener("show_m", "click", YAHOO.example.container.dialog1.show, YAHOO.example.container.dialog1, true);
		}		
		YAHOO.util.Event.onDOMReady(init_m);
		
		function init_m_2() {	
			// Define various event handlers for Dialog
			var handleSubmit = function() {
				document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando...";
				this.submit();
			};
			var handleCancel = function() {
				this.cancel();
			};
			var handleSuccess = function(o) {
				var response = o.responseXML;
				//alert(o.responseText);	
				var mensaje = response.getElementsByTagName("mensaje")[0];
				var error = mensaje.getElementsByTagName("error");							
				if(error.length == 0){	
					if(mensaje.getElementsByTagName("numero")[0].firstChild != null)
						document.getElementById("numero").value = mensaje.getElementsByTagName("numero")[0].firstChild.nodeValue;
					document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Numero Modificado Correctamente";
				}
				else{				
					mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
					document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
					alert(mensaje);	
				}
			};
			var handleFailure = function(o) {
				alert("Submission failed: " + o.status);
			};
		
			// Instantiate the Dialog
			YAHOO.example.container.dialog2 = new YAHOO.widget.Dialog("dialog2", 
									{ width : "300px",
									  fixedcenter : true,
									  visible : false, 
									  constraintoviewport : true,
									  buttons : [ { text:"Modificar", handler:handleSubmit, isDefault:true },
											  { text:"Cancelar", handler:handleCancel } ]
									});
		
			// Validate the entries in the form to require that both first and last name are entered
			YAHOO.example.container.dialog2.validate = function() {
				var data = this.getData();
				if (isNaN(data.numero_m) || data.numero_m == "") {
					alert("Digite un numero de Camiseta Valido.");	
					document.getElementById("mod_2").numero_m.focus();						
					return false;
				} else {
					return true;
				}
			};
		
			// Wire up the success and failure handlers
			YAHOO.example.container.dialog2.callback = { success: handleSuccess,
									 failure: handleFailure };
			
			// Render the Dialog
			YAHOO.example.container.dialog2.render();
		
			YAHOO.util.Event.addListener("show_m_2", "click", YAHOO.example.container.dialog2.show, YAHOO.example.container.dialog2, true);
		}		
		YAHOO.util.Event.onDOMReady(init_m_2);				
		
		function actualizar(opc){
			var campo = "0";			
			var error = true;
			var id = document.getElementById("id_deportista").value;
			if( id != "" || opc == 1 || opc == 12){		
				switch(opc){
					case 1:	var documento = document.getElementById("documento").value;
							if(!isNaN(documento) && documento != "")
								campo = document.getElementById("documento").value;
							else{
								error = false;	
								alert("Digite un numero de Documento Valido");
								document.getElementById("documento").focus();	
								document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> Digite un numero de Documento Valido";	
							}
							break;
					case 2:	campo = document.getElementById("td").value;
							break;
					case 3:	campo = document.getElementById("nombres").value;
							break;
					case 4:	campo = document.getElementById("apellidos").value;
							break;							
					case 5:	campo = document.getElementById("entidad").value;
							break;		
					case 6:	campo = document.getElementById("pais").value;
							break;					
					case 7:	campo = document.getElementById("telefono").value;
							break;
					case 8:campo = document.getElementById("direccion").value;
							break;
					case 9:campo = document.getElementById("eps").value;
							break;	
					case 10:campo = String(document.getElementById("rh").value);
							campo = campo.replace('+', '%2B');
							break;	
					case 11:campo = document.getElementById("categoria").value;
							break;	
					case 12:campo = document.getElementById("numero").value;
							if(isNaN(campo) || campo == ""){
								error = false;	
								alert("Digite un numero Valido");
								document.getElementById("numero").focus();	
								document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> Digite un numero Valido";	
							}
							break;				
				}
			}
			else{
				error = false;
				limpiarTodo();
				alert("No hay ningun Deportista Seleccionado");
				document.getElementById("documento").focus();	
				document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> No hay ningun Deportista Seleccionado";	
			}
			
			if(error)
				makeRequestActualizar(id, opc, campo);	
		}
		
		function limpiarTodo(){
			//document.getElementById("documento").focus();
			document.getElementById("id_deportista").value="";
			document.getElementById("td").options[0].selected = true;
			document.getElementById("nombres").value="";
			document.getElementById("apellidos").value="";			
			document.getElementById("entidad").value="";
			document.getElementById("pais").value="";
			document.getElementById("telefono").value="";
			document.getElementById("direccion").value="";
			document.getElementById("eps").value="";
			document.getElementById("rh").value="";
			
			document.getElementById("categoria").options[0].selected = true;
			document.getElementById("numero").value="";
			
			document.getElementById("mod").id_m.value="";
			document.getElementById("mod").documento_m.value="";
			document.getElementById("mod").nombres_m.value="";
			document.getElementById("mod_2").id_m.value="";
			document.getElementById("mod_2").numero_m.value="";			
			document.getElementById("mod_2").nombres_m.value="";
		}
		
		function confirmar(){
			var id = document.getElementById("id_deportista").value;
			if(id != ""){
				init();	
				document.getElementById("show").click();
			}
			else{
				alert("No hay ningun Deportista Seleccionado");
				document.getElementById("documento").focus();
			}
		}	
		
		function ayuda(){
			var ventana = window.open("../documentos/ayuda.pdf", "");			
		}
		
		function eliminar(){
			var id = document.getElementById("id_deportista").value;
			makeRequestEliminar(id);	
		}
		
		function modificar(){
			var id = document.getElementById("id_deportista").value;
			var nombres = document.getElementById("documento").value + " / " + document.getElementById("nombres").value + " " + document.getElementById("apellidos").value;
			if(id != ""){
				document.getElementById("mod").id_m.value = id;
				document.getElementById("mod").nombres_m.value = nombres;
				document.getElementById("show_m").click();
			}
			else{
				alert("No hay ningun Deportista Seleccionado");
				document.getElementById("documento").focus();
			}
		}
		
		function modificar_2(){
			var id = document.getElementById("id_deportista").value;
			var nombres = document.getElementById("numero").value + " / " + document.getElementById("nombres").value + " " + document.getElementById("apellidos").value;
			if(id != ""){
				document.getElementById("mod_2").id_m.value = id;
				document.getElementById("mod_2").nombres_m.value = nombres;
				document.getElementById("show_m_2").click();
			}
			else{
				alert("No hay ningun Deportista Seleccionado");
				document.getElementById("numero").focus();
			}
		}	
		
		function siguiente(){
			limpiarTodo();	
			document.getElementById("documento").value="";
			document.getElementById("documento").focus();			
		}
		
		var patron = new Array(2,2,2)
		function mascara(d,sep,pat,nums){
		if(d.valant != d.value){
			val = d.value
			largo = val.length
			val = val.split(sep)
			val2 = ''
			for(r=0;r<val.length;r++){
				val2 += val[r]	
			}
			if(nums){
				for(z=0;z<val2.length;z++){
					if(isNaN(val2.charAt(z))){
						letra = new RegExp(val2.charAt(z),"g")
						val2 = val2.replace(letra,"")
					}
				}
			}
			val = ''
			val3 = new Array()
			for(s=0; s<pat.length; s++){
				val3[s] = val2.substring(0,pat[s])
				val2 = val2.substr(pat[s])
			}
			for(q=0;q<val3.length; q++){
				if(q ==0){
					val = val3[q]
				}
				else{
					if(val3[q] != ""){
						val += sep + val3[q]
						}
				}
			}
			
			if(val.length > 1){					
				horas = val.substring(0,2);
				minutos = 0;
				segundos = 0;
				if(val.length == 5){
					minutos = val.substring(3,5);
				}
				if(val.length == 8){
					segundos = val.substring(6,8);
				}
				if(horas > 59 || minutos > 59 || segundos > 59)
					alert("Por favor digite un tiempo valido, los minutos o segundos no pueden ser mayor a 60");	
			}
			
			d.value = val
			d.valant = val
			}
		}
		
		window.onload = function(){		
			limpiarTodo();				
			document.getElementById("documento").value="";
			document.getElementById("documento").focus();
			
			makeRequestCategorias();		
        }
		
		</script>
</head>
<body class="yui-skin-sam" > 
    <div style="text-align:center" id="header"> 
    	<div id="header_inner" class="fixed">
            <div style="height:5px"></div>
            <a href="../index.php"><img src="../imagenes/logo_2.png"/> &nbsp;&nbsp; <img src="../imagenes/titulo.png"/> &nbsp; <img src="../imagenes/logo.png" /></a>
        </div>    
    </div> 
  
	<div id="main">
		<div id="main_inner" class="fixed">    
            <div class="campos">
                <div id="respuesta" style="width:100%">
                    <fieldset>
                        <legend>Mensajes</legend> 
                            <div id="cargando" style="width:100%">                                 
                                <img src='../icons/server.png'/> Respuesta del servidor.
                            </div> 
                    </fieldset>
                </div> 
                    
                <div id="deportista"> 
                    <fieldset>
                        <legend>Informacion del Deportista</legend>
                        <input type="text" id="id_deportista" style="display:none" value="" /> 
                                             
                        <div class="espacio"></div>	
                        <div>
                            <label for="documento">Numero de Documento</label>
                                <input type="text" name="documento" id="documento" class="mod" value="" onchange="actualizar(1);" />
                           <button id="actualizar" onclick="modificar();" title="Modificar Documento" ><img src="../icons/vcard_edit.png" alt="M"/></button>
                        </div>
                        <div> 
                            <label for="td">Tipo Documento</label>
                                <select id="td" class="inormal" name="td" onchange="actualizar(2);">
                                    <option value="0"> - Seleccionar - </option>
                                    <option value="1" selected="selected"> Cedula de Ciudadania </option>
                                    <option value="2" > Tarjeta de Identidad </option>
                                    <option value="3" > Otro Documento </option>
                                </select> 
                        </div>
                    
                        <div class="espacio"></div>
                        <div>
                            <label for="nombres">Nombres</label>
                                <input type="text" name="nombres" id="nombres" class="inormal" value="" onchange="actualizar(3);" /> 
                        </div>   
                        <div>
                            <label for="apellidos">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" class="inormal" value="" onchange="actualizar(4);" /> 
                        </div>  
                        
                        <div class="espacio"></div>               
                        <div>
                            <label for="entidad">Entidad o Patrocinador</label>
                                <input type="text" name="entidad" id="entidad" class="inormal" value="" onchange="actualizar(5);" /> 
                        </div> 
                        <div>
                            <label for="pais">Ciudad o Pais</label>
                                <input type="text" name="pais" id="pais" class="inormal" value="" onchange="actualizar(6);" /> 
                        </div>      
                              
                        <div class="espacio"></div>
                        <div>
                            <label for="telefono">Telefono</label>
                                <input type="text" name="telefono" id="telefono" class="inormal" value="" onchange="actualizar(7);" /> 
                        </div>        
                        <div>
                                <label for="direccion">Direccion</label>
                                    <input type="text" name="direccion" id="direccion" class="inormal" value="" onchange="actualizar(8);" /> 
                        </div>
                        
                        <div class="espacio"></div>
                        <div>
                            <label for="eps">Seguridad Social&nbsp;&nbsp;&nbsp;</label>
                                <input type="text" name="eps" id="eps" class="inormal" value="" onchange="actualizar(9);" /> 
                        </div>
                        <div>
                            <label for="rh">Tipo de Sangre&nbsp;&nbsp;&nbsp;</label>
                                <input type="text" name="rh" id="rh" class="inormal" value="" onchange="actualizar(10);" /> 
                        </div>

                                                
                        <div class="espacio_pie"></div>                
                        <div class="espacio"></div>	                                
                        <div> 
                            <button class="boton" onclick="siguiente();" id="siguiente" title="Limpiar Campos"><img src="../icons/control_repeat.png" alt="S" /> <strong>Limpiar</strong></button>
                            
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="boton" onclick="ayuda();" id="ayuda" title="Limpiar Campos"><img src="../icons/information.png" alt="?"/> <strong>Ayuda</strong></button>
                        </div>
                        <div style="text-align:right; width:45%"> 
                            <button class="error" onclick="confirmar();" id="eliminar" title="Eliminar Deportista"><img src="../icons/user_delete.png" alt="E" /> <strong>Eliminar</strong></button>
                        </div> 
                    </fieldset>
                 
                </div>    
            
                <div id="tiempos">
                    <fieldset>
                        <legend>Informacion de la Carrera</legend> 
						<div class="espacio"></div>               
                        <div>
                            <label for="categoria">Categoria</label>
                                <select id="categoria" class="inormal" name="categoria" onchange="actualizar(11);">
                                    <option value="0" selected="selected"> - Seleccionar - </option>                                    
                                </select> 
                        </div> 
                        <div>
                            <label for="numero">Numero Camiseta</label>
                                <input name="numero" id="numero" class="mod" value="" onchange="actualizar(12);" ></input>
                            <button id="actualizar_2" onclick="modificar_2();" title="Modificar Numero" ><img src="../icons/user_edit.png" alt="M"/></button>    
                        </div>  
                    </fieldset>
                </div>
            </div>      
           
            <div id="container">
                <button id="show" style="display:none">Show</button> 
                <button id="show_n" style="display:none">Show_n</button> 
                <button id="show_m" style="display:none">Show_m</button> 
                <button id="show_m_2" style="display:none">Show_m_2</button> 
            </div> 
            
            <div id="dialog1">
                <div class="hd">Digite el nuevo Numero de Documento</div>
                <div class="bd">
                <form method="POST" id="mod" action="modificar_d.php">
                    <input type="hidden" name="id_m" /> 
                    <label for="nombres_m">Numero Documento / Nombres:</label><input type="textbox" name="nombres_m" disabled="disabled" />
                    <label for="documento_m">Documento:</label><input type="textbox" name="documento_m" />
                </form>
                </div>
            </div> 
            
             <div id="dialog2">
                <div class="hd">Digite el nuevo Numero de Camiseta</div>
                <div class="bd">
                <form method="POST" id="mod_2" action="modificar_n.php">
                    <input type="hidden" name="id_m" /> 
                    <label for="nombres_m">Numero Camiseta / Nombres:</label><input type="textbox" name="nombres_m" disabled="disabled" />
                    <label for="numero_m">Numero:</label><input type="textbox" name="numero_m" />
                </form>
                </div>
            </div> 
            
            <div style="height:50px; width:275px"></div> 
            
            <div style="text-align:center;">
            	<img src="../imagenes/logo_2.png" width="160"/> &nbsp;
                <img id="maraton" src="../imagenes/2.jpg" width="270" />
            </div>
			
			<div class="espacio"></div>
			<div id="historial">
				<fieldset>
					<legend>Historial</legend>
						<div id="historial_deportista">
						</div>
				</fieldset>
			</div>
            
            <div class="espacio_pie"></div>             
            <div class="pie">
                <br />
                &copy; Carrera Atletica Fomanort
            </div>
      	</div>
  	</div>            
</body>
</html>