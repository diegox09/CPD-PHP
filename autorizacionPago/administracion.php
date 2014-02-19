<?php
	session_start();	
	if(!array_key_exists('id_ap', $_SESSION)) {
		header('Location: index.php');
	}
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Autorización de Pago</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
  	<link rel="stylesheet" type="text/css" href="css/ui/jquery.ui.all.css" /> 
  	<link rel="stylesheet" type="text/css" href="css/administracion.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
  	<script type="text/javascript" src="js/ui/jquery.ui.core.min.js"></script>
  	<script type="text/javascript" src="js/ui/jquery.ui.datepicker.min.js"></script>
    <script type="text/javascript" src="js/administracion.js"></script> 
</head>
<body>	
	<div id="cargando">
    	<span>Cargando <img src="img/ajax-loader.gif" /></span>
    </div>
              
	<div id="header">    	
    	<span id="nombre_user" ></span>
    	<a id="salir" href="php/salir.php" title="Salir de la aplicación">Salir</a>        
  	</div>
    
    <div id="corprodinco">
        <div style="width:20%">
            <img src="img/logo.png" height="70" />
        </div>
        <div style="width:80%">
            Corporación de Profesionales<br>
            para el Desarrollo Integral Comunitario<br> 
        </div>
    </div>
    
    <div id="consulta" style="display:none">Usuario no Autorizado</div>    
        
	<div id="info"> 
    	<div id="menu" style="display:none">
        	<ul id="lista">
            	<li id="li_importar_ap" style="display:none"><a href="#" class="lista" label="importar_ap">Autorizacion de Pago</a></li>
                <li id="li_importar_fe" style="display:none"><a href="#" class="lista" label="importar_fe">Factura Equivalente</a></li>
                <li><a href="#" class="lista" label="confirmar_ap">Confirmacion de Pago</a></li>
            	<li><a href="#" class="lista" label="exportar_ap">Exportar Excel</a></li>	                
                <li><a href="#" class="lista" label="listado_ap">Imprimir PDF</a></li>                
            </ul>
        </div>
     
     	<div>
            <div class="formulario" id="div_importar_ap" style="display:none">
                <div class="header_info">
                    AUTORIZACION DE PAGO                
                </div>
                <form id="form_importar_ap" action="xls/importar_ap.php" method="post" enctype="multipart/form-data">	
                    <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
                    <div style="width:150px" class="clear">
                        <label>Seleccionar Archivo:</label>
                    </div> 
                    <div style="width:295px">                 	
                        <input class="input_l" id="file_importar_ap" name="userfile" type="file" label="Seleccione un Archivo">
                    </div> 
                    <div style="width:460px"></div> 
                    <div class="clear" style="width:460px;text-align:right">                 	
                        <input type="button" id="importar_ap" class="boton_naranja" value="Autorizacion de Pago" title="Importar Autorizacion de Pago">
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_importar_fe" style="display:none">
                <div class="header_info">
                    FACTURA EQUIVALENTE                
                </div>
                <form id="form_importar_fe" action="xls/importar_fe.php" method="post" enctype="multipart/form-data">	
                    <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
                    <div style="width:150px" class="clear">
                        <label>Seleccionar Archivo:</label>
                    </div> 
                    <div style="width:295px">                 	
                        <input class="input_l" id="file_importar_fe" name="userfile" type="file" label="Seleccione un Archivo">
                    </div> 
                    <div style="width:460px"></div> 
                    <div class="clear" style="width:460px;text-align:right">                 	
                        <input type="button" id="importar_fe" class="boton_naranja" value="Factura Equivalente" title="Importar Factura Equivalente">
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_confirmar_ap" style="display:none">
                <div class="header_info">
                    CONFIRMACION DE PAGO                
                </div>
                <form id="form_confirmar_ap" action="xls/confirmar_ap.php" method="post" enctype="multipart/form-data">	
                    <input type="hidden" name="MAX_FILE_SIZE" value="9000000" />
                    <div style="width:150px" class="clear">
                        <label>Seleccionar Archivo:</label>
                    </div> 
                    <div style="width:295px">                 	
                        <input class="input_l" id="file_confirmar_ap" name="userfile" type="file" label="Seleccione un Archivo">
                    </div> 
                    <div style="width:460px"></div> 
                    <div class="clear" style="width:460px;text-align:right">                 	
                        <input type="button" id="confirmar_ap" class="boton_azul" value="Confirmar" title="Confirmar Pago">
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_exportar_ap" style="display:none">
                <div class="header_info">
                    EXPORTAR EXCEL                 
                </div>
                <form id="form_exportar_ap" action="#" method="get" >
                	<div style="width:100px">
                        <label>Programa:</label>
                    </div> 
                	<div style="width:345px">                 	
                        <select id="programa_ap" class="select_l" name="programa" label="Seleccione un Programa">
                        </select>
                    </div>
                	<div style="width:460px"></div>
                    <div style="width:100px">
                        <label>Fecha Inicial:</label>
                    </div> 
                    <div style="width:100px">                 	
                        <input type="text" id="fecha_inicial_ap" class="input_l" name="fecha_inicial" value="" label="Seleccione la Fecha Inicial"/>
                    </div>   
                    <div style="width:100px">
                        <label>Fecha Final:</label>
                    </div>
                    <div style="width:100px">                 	
                        <input type="text" id="fecha_final_ap" class="input_l" name="fecha_final" value="" label="Seleccione la Fecha Final"/>
                    </div>                    
                    <div style="width:460px"></div>  
                    <div class="clear" style="width:460px;text-align:right">  
                        <input type="button" id="exportar_ap" class="boton_azul" value="Exportar" title="Exportar Autorizaciones de Pago"/>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            
            <div class="formulario" id="div_listado_ap" style="display:none">
                <div class="header_info">
                    IMPIMIR PDF                 
                </div>
                <form id="form_listado_ap" action="#" method="get" >
                	 <div style="width:100px">
                        <label>Programa:</label>
                    </div> 
                    <div style="width:345px">                 	
                        <select id="programa_ap_pdf" class="select_l" name="programa" label="Seleccione un Programa">
                        </select>
                    </div> 
                    <div style="width:460px"></div>
                    <div style="width:100px">
                        <label>Fecha Inicial:</label>
                    </div> 
                    <div style="width:100px">                 	
                        <input type="text" id="fecha_inicial_ap_pdf" class="input_l" name="fecha_inicial" value="" label="Seleccione la Fecha Inicial"/>
                    </div>   
                    <div style="width:100px">
                        <label>Fecha Final:</label>
                    </div>
                    <div style="width:100px">                 	
                        <input type="text" id="fecha_final_ap_pdf" class="input_l" name="fecha_final" value="" label="Seleccione la Fecha Final"/>
                    </div>
                    <div style="width:460px"></div>                            
                    <div class="clear" style="width:460px;text-align:right"> 
                        <input type="button" id="listado_ap_pdf" class="boton_azul" value="Listado" title="Listado PDF"/>
                    </div>
                </form>
                <div class="clear"></div>
            </div> 
    	</div>        
    </div>
                
    <div id="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
            &nbsp;|&nbsp;       	
        	<a href="../">SGC</a>
            &nbsp;|&nbsp;            
        	<a href="contenido.php">Inicio</a>
     	</div>       
    </div>
    
    <div id="error"></div> 
</body>
</html>