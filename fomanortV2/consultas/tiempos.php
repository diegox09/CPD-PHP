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
		#cargando {width:180%;}	
		input {width:88%;}		
		table {border-spacing:3px; border-collapse:collapse;}
		table {vertical-align:middle; border-radius:6px; box-shadow: 0 0 1px #999;}
		table tr:hover {background:url(../imagenes/n3.png);}
		table th{border: 1px solid #dcdcdc;}
		table td{border: 1px solid #dcdcdc;}						
		.centrado {text-align:center;}
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
			limpiarTodo();
			var mensaje = response.getElementsByTagName("mensaje")[0];
			var error = mensaje.getElementsByTagName("error");												
			if(error.length == 0){	
				var deportista = mensaje.getElementsByTagName("deportista");				
				var id = "";					
				var nombres = "";
				var apellidos = "";
				var categoria = "";
				var numero = "";
				var pais = "";
				var entidad = "";
				var puesto = "";
				var tiempo = "";
				if(deportista.length != 0){					
					for(i=0; i<deportista.length; i++){
						id = "";					
						nombres = "";
						apellidos = "";
						categoria = "";
						numero = "";
						pais = "";
						entidad = "";
						puesto = "";
						
						if(deportista[i].getElementsByTagName("id")[0].firstChild != null)
							id = deportista[i].getElementsByTagName("id")[0].firstChild.nodeValue;					
						
						if(deportista[i].getElementsByTagName("nombres")[0].firstChild != null)					
							nombres = deportista[i].getElementsByTagName("nombres")[0].firstChild.nodeValue;
							
						if(deportista[i].getElementsByTagName("apellidos")[0].firstChild != null)	
							apellidos = deportista[i].getElementsByTagName("apellidos")[0].firstChild.nodeValue;
							
						if(deportista[i].getElementsByTagName("categoria")[0].firstChild != null){	
							categoria = deportista[i].getElementsByTagName("categoria")[0].firstChild.nodeValue;
						}
						
						if(deportista[i].getElementsByTagName("numero")[0].firstChild != null)	
							numero = deportista[i].getElementsByTagName("numero")[0].firstChild.nodeValue;
						
						if(deportista[i].getElementsByTagName("pais")[0].firstChild != null)	
							pais = deportista[i].getElementsByTagName("pais")[0].firstChild.nodeValue;
							
						if(deportista[i].getElementsByTagName("entidad")[0].firstChild != null)	
							entidad = deportista[i].getElementsByTagName("entidad")[0].firstChild.nodeValue;
							
						if(deportista[i].getElementsByTagName("tiempo")[0].firstChild != null)	
							tiempo = deportista[i].getElementsByTagName("tiempo")[0].firstChild.nodeValue;		
						
						if(deportista[i].getElementsByTagName("puesto")[0].firstChild != null)	
							puesto = deportista[i].getElementsByTagName("puesto")[0].firstChild.nodeValue;
						
						if(id != ""){
							//nombres = nombres + " " + apellidos;
							fila = [id, numero, categoria, puesto, tiempo, nombres, pais, entidad];
							agregar(fila, "tiempo_competencia");
						}
					}	
				}
				document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> <strong>Numero:</strong> "+numero+" <strong>Categoria:</strong> "+categoria+" <strong>Puesto:</strong> "+puesto+" <strong>Nombres:</strong> "+nombres+" <strong>Pais:</strong> "+pais+" <strong>Patrocinador:</strong> "+entidad;	}
			else{
				mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
				if(mensaje != "0"){
					document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
					alert(mensaje);
				}
				else
					document.getElementById("cargando").innerHTML = "<img src='../icons/server.png'/> Respuesta del servidor.";					
			}
		};
		
		var handleSuccessEliminar = function(o) {																				
			var response = o.responseXML;
			//alert(o.responseText);	
			var mensaje = response.getElementsByTagName("mensaje")[0];
			var error = mensaje.getElementsByTagName("error");
			if(error.length == 0)
				makeRequestActualizar("*");	
			else{				
				mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
				document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
				//alert(mensaje);	
			}
		};
		
		var handleFailure = function(o) {
            alert("Submission failed: " + o.status);
        };
		
		var callbackActualizar = {
            success:handleSuccessActualizar,
            failure:handleFailure,				
        };		
		
		var callbackEliminar = {
            success:handleSuccessEliminar,
            failure:handleFailure,				
        };
				
		function makeRequestActualizar(numero){	
			var error = true;
			var tiempo = "";		
			if(numero == "*"){	
				tabla = document.getElementById("tiempo_competencia");
				if(tabla.rows.length > 1){
					for(i=tabla.rows.length; i>1; i--){
						tabla.deleteRow(i-1);
					}
				}
			}
			else{
				numero = document.getElementById("numero").value;
				tiempo = document.getElementById("tiempo").value;
				if(isNaN(numero) || numero == ""){
					error = false;	
					alert("Digite un numero Valido");
					document.getElementById("numero").focus();	
					document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> Digite un numero Valido";	
				}
			}
			
			if(error){	
				document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando...";
				var sUrl = "consulta_t.php";
				var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackActualizar, 'numero='+numero+'&tiempo='+tiempo);
			}
        };
		
		function makeRequestEliminar(){
			document.getElementById("cargando").innerHTML = "<img src='../imagenes/ajax-loader.gif'/>  Cargando..."; 			
			id = document.getElementById("id_temp").value;
			var sUrl = "eliminar_t.php";
			var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackEliminar, 'id='+id);
        };
		
		YAHOO.namespace("example.container");
		function init() {			
			// Define various event handlers for Dialog
			var handleSi = function() {
				makeRequestEliminar();
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
											   text: "Desea Eliminar el Registro.<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Camiseta Numero: " + document.getElementById("num_temp").value,
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
				limpiarTodo();
				var mensaje = response.getElementsByTagName("mensaje")[0];
				var error = mensaje.getElementsByTagName("error");				
				id = "";
				tiempo = "";				
				if(error.length == 0){
					makeRequestActualizar("*");
					/*
					if(mensaje.getElementsByTagName("id")[0].firstChild != null)	
						id = mensaje.getElementsByTagName("id")[0].firstChild.nodeValue;
						
					if(mensaje.getElementsByTagName("tiempo")[0].firstChild != null)	
						tiempo = mensaje.getElementsByTagName("tiempo")[0].firstChild.nodeValue;						
					
					document.getElementById("e_"+id).innerHTML = tiempo;
						
					document.getElementById("cargando").innerHTML = "<img src='../icons/accept.png'/> Tiempo Modificado Correctamente";*/
				}
				else{				
					mensaje = mensaje.getElementsByTagName("error")[0].firstChild.nodeValue;
					if(mensaje != "Error"){
						/*if(mensaje.getElementsByTagName("id")[0].firstChild != null)	
						id = mensaje.getElementsByTagName("tiempo")[0].firstChild.nodeValue;
						
						if(mensaje.getElementsByTagName("tiempo")[0].firstChild != null)	
							tiempo = mensaje.getElementsByTagName("tiempo")[0].firstChild.nodeValue;		
						
						document.getElementById("e_"+id).innerHTML = tiempo;*/
						
						document.getElementById("cargando").innerHTML = "<img src='../icons/error.png'/> "+mensaje;				
						alert(mensaje);	
					}
					else
						makeRequestActualizar("*");
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
				if (data.tiempo_m == "") {
					alert("Digite el Tiempo.");
					document.getElementById("mod").tiempo_m.focus();	
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
				
		function agregar(palabras, id){
			tabla = document.getElementById(id);
			fila = document.createElement('tr');
			fila.setAttribute("id", palabras[0]);	
			
			columna = document.createElement('td');
			texto = document.createTextNode(tabla.rows.length);
			columna.appendChild(texto);
			columna.setAttribute("class", "centrado");
			fila.appendChild(columna);
			
			if((tabla.rows.length%2) == 0)
				fila.setAttribute("bgcolor", "#F0F8FF");
			else		
				fila.setAttribute("bgcolor", "#FFFFFF");
				
			for(f=1;f<8;f++){
				columna = document.createElement('td');
				switch(f){
					case 1:	columna.setAttribute("class", "centrado");
							break;
					case 3:	columna.setAttribute("class", "centrado");
							break;
					case 4:	columna.setAttribute("class", "centrado");
							break;								
				}
				
				texto = document.createTextNode(palabras[f]);
				if(f != 4)										
					columna.appendChild(texto);				
				else{
					enlace = document.createElement('a');
					enlace.setAttribute("id", "e_"+palabras[0]);
					enlace.setAttribute("href", "#");
					enlace.setAttribute("title", "Eliminar Registro");
					enlace.setAttribute("onclick", "modificar('"+palabras[0]+"', '"+palabras[1]+"', '"+palabras[4]+"')"); 
					enlace.appendChild(texto);
					columna.appendChild(enlace);
				}
				fila.appendChild(columna);
			}	
			
			columna = document.createElement('td');
			columna.setAttribute("class", "centrado");
			enlace = document.createElement('a');
			enlace.setAttribute("href", "#");
			enlace.setAttribute("title", "Eliminar Registro");
			enlace.setAttribute("onclick", "eliminar('"+palabras[0]+"', '"+palabras[1]+"')"); 
			imagen = document.createElement('img');
			imagen.setAttribute("src", "../icons/delete.png");
			imagen.setAttribute("border", "0");
			enlace.appendChild(imagen);
			columna.appendChild(enlace);				
			fila.appendChild(columna);
						
			tabla.appendChild(fila);
		}	
		
		function eliminar(id, numero){			
			if(id != ""){				
				document.getElementById("id_temp").value = id;
				document.getElementById("num_temp").value = numero;
				init();
				document.getElementById("show").click();
			}
		}
		
		function limpiarTodo(){
			document.getElementById("tiempo").value = "";
			document.getElementById("tiempo").focus();
			document.getElementById("numero").value = "";
						
			document.getElementById("mod").id_m.value="";
			document.getElementById("mod").numero_m.value="";
			document.getElementById("mod").tiempo_m.value="";
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
		
		function modificar(id, numero, tiempo){			
			if(id != ""){
				document.getElementById("mod").id_m.value = id;
				document.getElementById("mod").numero_m.value = numero+" / "+tiempo;
				document.getElementById("show_m").click();
			}
			else
				alert("No hay ningun Deportista Seleccionado");	
		}
				
		function enviar(e, opc){			
			if((e.keyCode == 13) || (e.keyCode == 9)){
				opc = parseInt(opc);				
				switch(opc){
					case 1:	var numero = document.getElementById("numero").value;
							if(numero != "")
								makeRequestActualizar(0);
							else
								if(e.keyCode == 13)
									document.getElementById("tiempo").focus();
							break;										
					case 2:	if(e.keyCode == 13)
								document.getElementById("numero").focus();							
							break;
				}
			}
		}
					
		window.onload = function(){			
			makeRequestActualizar("*");		            	
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
            <div class="campos_2">
                <div id="respuesta" style="width:100%">
                    <fieldset>
                        <legend>Mensajes</legend> 
                            <div id="cargando" style="width:100%">                                 
                                <img src='../icons/server.png'/> Respuesta del servidor.
                            </div> 
                    </fieldset>
                </div> 
                
                <div id="tiempos" style="width:100%">
                    <fieldset>
                        <legend>Clasificacion</legend> 
                        <div class="espacio"></div>
                        <div>
                        	 <label for="tiempo">Tiempo (MM:SS)</label>
                                <input name="tiempo" id="tiempo" class="inormal" maxlength="8" value="" onkeyup="mascara(this,':',patron,true)" onkeypress="enviar(event, 2);"></input>
                   		</div>
                        <div>             
                            <label for="numero">Numero Camiseta</label>
                                <input name="numero" id="numero" class="inormal" value="" onkeypress="enviar(event, 1);" ></input>
                        </div>
                        
                        <div class="espacio_pie"></div>	                
                        <div class="espacio"></div>	
                        <div align="center" style="width:50%">                	
                            
                            <div class="espacio"></div>
                            <table id="tiempo_competencia" width="200%"> 
                                <thead style="text-align:center">
                                    <tr style="height:30px; background:url(../imagenes/n6.png)">
                                    	<th width="4%">Item</th>
                                        <th width="5%">Numero Camiseta</th>
                                        <th width="22%">Categoria</th>
                                        <th width="5%">Puesto</th>
                                        <th width="5%">Tiempo (MM:SS)</th>
                                        <th width="22%">Nombres</th>
                                        <th width="17%">Ciudad o Pais</th>
                                        <th width="18%">Entidad o Patrocinador</th>
                                        <th width="2%"></th>
                                    </tr>     
                                </thead>
                            </table>    
                        </div>       
                    </fieldset>
                </div>
            </div>
            
            <div id="container">
                <button id="show" style="display:none">Show</button> 
                <button id="show_m" style="display:none">Show_m</button>
                <input type="hidden" id="id_temp" value="" />
                <input type="hidden" id="num_temp" value="" />  
            </div>
            
            <div id="dialog1">
                <div class="hd">Digite el nuevo Tiempo</div>
                <div class="bd">
                <form method="POST" id="mod" action="cambiar_t.php">
                    <input type="hidden" name="id_m" /> 
                    <label for="numero_m">Numero Camiseta / Tiempo:</label><input type="textbox" name="numero_m" disabled="disabled" />
                    <label for="tiempo_m">Tiempo:</label><input type="textbox" maxlength="8" onkeyup="mascara(this,':',patron,true)" name="tiempo_m" />
                </form>
                </div>
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