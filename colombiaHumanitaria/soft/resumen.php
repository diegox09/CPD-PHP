<?php
	session_start();	
	if(!array_key_exists('id_hu', $_SESSION)) {
		header('Location: ../');
	}		
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Colombia Humanitaria</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
  	<link rel="stylesheet" type="text/css" href="css/ui/jquery.ui.all.css" />  
  	<link rel="stylesheet" type="text/css" href="css/index.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
  	<script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
  	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.min.js"></script>
  	<script type="text/javascript" src="js/resumen.js"></script>
</head>
<body>
	<div id="overlay" style="display:none"></div>
	<div id="cargando"><span>Cargando <img src="img/ajax-loader.gif" /></span></div>
    <div id="error"></div>
      
	<div id="header">    	
    	<a href="#" id="nombre_user" title=""></a>
        <input type="hidden" id="perfil" name="perfil" value="" />  
    	<a id="salir" href="php/salir.php" title="Salir de la aplicación">Salir</a>
        <img src="img/corprodinco.jpg" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   		<img src="img/logo_colombia_humanitaria.jpg" />
  	</div>  
          
	<div id="contenido">
    	<div class="info">
        	<div class="formulario">     
                <div class="header_info">
                    LEER
                </div> 
                <div class="informes" style="text-align:center">
                	<form id="form_importar" action="" method="post" enctype="multipart/form-data">	
                        <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
                        <input type="hidden" id="fase_importar" name="fase" value="" />
                        <div style="width:450px">
                            <label for="userfile">Seleccionar Archivo</label>
                            <input class="input_n" id="userfile" name="userfile" type="file">
                        </div>
                    </form>  
                    <div class="clear"></div>                 
                    <input type="button" id="leer" class="boton_naranja" value="Leer" title="Leer" style="display:none"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" id="leer_todo" class="boton_naranja" value="Leer Todo" title="Leer Todo" style="display:none"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" id="leer_comprobantes" class="boton_gris" value="Comprobantes" title="Leer Comprobantes" style="display:none"/>
               	</div>  
            </div>
            
        	<div class="formulario">
            	<div class="header_info">
                    <a href="#" id="limpiar" title="Limpiar Formulario">RESUMEN</a>&nbsp;&nbsp;
                    <a href="#" id="actualizar" title="Actualizar">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                </div>
                <form id="form_resumen" action="#" method="get"> 
                	<div> 
                        <label for="fase">Fase</label>
                        <select id="fase" name="fase" >
                            <option value="1" > Fase 1 </option>
                            <option value="2" > Fase 2 </option>
                            <option value="3" > Fase 3 </option>
                        </select>
                   </div>
                   <div> 
                        <label for="fecha">Fecha</label>
                        <input type="text" name="fecha" id="fecha" value="" label="Por favor digite la fecha" /> 
                	</div>
                    <div>
                    	<input type="submit" id="" class="boton_gris" value="Actualizar" title="Actualizar"  style="display:none"/> 	
                    </div>
               </form>
               <div class="clear"></div>
               
               <div id="resumen"></div>        
               
               <div class="clear"></div>     
         	</div>       
    	</div>     
        
        <div class="info">
        	<div class="formulario">
            	<div class="header_info">
                    BASE DE DATOS
                </div> 
                <div class="informes">
                	<input type="button" id="base_datos" class="boton_gris" value="Base de Datos" title="Base de Datos" style="display:none"/>       
                    <input type="button" id="repetidos" class="boton_gris" value="Repetidos" title="Repetidos" style="display:none"/>
                    <input type="button" id="fraudes" class="boton_gris" value="Fraudes" title="Fraudes" style="display:none"/>
               	</div>
           	</div>
            
            <div class="formulario">
                 <div class="header_info">
                    ENTREGAS BENEFICARIO
                </div> 
                <div class="informes">
                    <input type="button" id="entrega_beneficiario" class="boton_gris" value="Ent. Beneficiario" title="Entrega Beneficiario" style="display:none"/>
                    <input type="button" id="entrega_beneficiario_arriendo" class="boton_gris" value="Ent. Arriendo" title="Entrega Beneficiario Arriendo" style="display:none"/>
                    <input type="button" id="entrega_beneficiario_reparacion" class="boton_gris" value="Ent. Reparacion" title="Entrega Beneficiario Reparacion de Vivienda" style="display:none"/>	                                       
                </div>
            </div>
            
            <div class="formulario">
                 <div class="header_info">
                    ALOJAMIENTOS TEMPORALES
                </div> 
                <div class="informes">	
                    <input type="button" id="entrega_operador" class="boton_gris" value="Ent. Operador" title="Entrega Operador" style="display:none"/>
                    <input type="button" id="alojamientos_temporales" class="boton_gris" value="A.T. - Arriendo" title="Alojamientos Temporales - Arriendos" style="display:none"/>
                    <input type="button" id="reparacion_alojamientos_temporales" class="boton_gris" value="A.T. - Reparacion" title="Alojamientos Temporales - Reparacion de Vivienda" style="display:none"/>
                </div>
            </div>
            
            <div class="formulario">  
                <div class="header_info">
                    EJECUCION
                </div>
                <div class="informes">                	
                    <input type="button" id="ejecucion_total" class="boton_gris" value="Ejecucion" title="Ejecucion Completo" style="display:none"/>	
                    <input type="button" id="ejecucion_resumen" class="boton_gris" value="Resumen Ejecucion" title="Resumen Ejecucion" style="display:none"/>	
                    <input type="button" id="ejecucion_fecha" class="boton_gris" value="Ejecucion x Fecha" title="Ejecucion x Fecha" style="display:none"/>	
                </div>
           	</div> 
            
            <div class="formulario">  
                <div class="header_info">
                    EJECUCION REPARACION VIVIENDA
                </div>
                <div class="informes">                	
                    <input type="button" id="reparacion_ejecucion_total" class="boton_gris" value="Ejecucion R." title="Ejecucion Completo - Reparacion de Vivienda" style="display:none"/>	
                    <input type="button" id="reparacion_ejecucion_resumen" class="boton_gris" value="Resumen Ejecucion R." title="Resumen Ejecucion - Reparacion de Vivienda" style="display:none"/>	
                    <input type="button" id="reparacion_ejecucion_fecha" class="boton_gris" value="Ejecucion x Fecha R." title="Ejecucion x Fecha - Reparacion de Vivienda" style="display:none"/>	
                </div>
           	</div> 
            <div class="clear"></div>            
        </div> 
        
        <div class="clear"></div>
        <div id="resultados" style="display:none">
            <table id="tabla" width="95%">
            </table>
        </div> 
  	</div>
    
    <div id="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2011 - Corprodinco</a>
        	&nbsp;|&nbsp;
        	<a href="http://diegox09.co.cc" target="_blank">Diegox09</a>
            &nbsp;|&nbsp;
        	<a href="index.php" >Inicio</a>
     	</div>       
    </div> 
</body>
</html>
