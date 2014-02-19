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
						
		var handleFailure = function(o) {
            alert("Submission failed: " + o.status);
        };
		
		var callbackActualizar = {
            success:handleSuccessActualizar,
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
				var sUrl = "consulta_c.php";
				var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, callbackActualizar, 'numero='+numero+'&tiempo='+tiempo);
			}
        };				
				
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
				columna.appendChild(texto);					
				
				fila.appendChild(columna);
			}	
									
			tabla.appendChild(fila);
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
            <div class="campos_2" >
                <div id="respuesta" style="width:100%;display:none">
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
                       <div class="espacio_pie"></div>	                
                        <div class="espacio"></div>	
                        <div align="center" style="width:50%">                	
                            
                            <div class="espacio"></div>
                            <table id="tiempo_competencia" width="200%"> 
                                <thead style="text-align:center">
                                    <tr style="height:30px; background:url(../imagenes/n6.png)">
                                    	<th width="4%">Item</th>
                                        <th width="5%">Numero Camiseta</th>
                                        <th width="18%">Categoria</th>
                                        <th width="5%">Puesto</th>
                                        <th width="9%">Tiempo (HH:MM:SS)</th>
                                        <th width="22%">Nombres</th>
                                        <th width="17%">Ciudad o Pais</th>
                                        <th width="20%">Entidad o Patrocinador</th>
                                    </tr>     
                                </thead>
                            </table>    
                        </div>       
                    </fieldset>
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