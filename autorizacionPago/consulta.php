<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Consulta de Pagos</title>  
  	<link rel="shortcut icon" href="img/application_view_gallery.png" type="image/ico" />
    <link rel="stylesheet" type="text/css" href="css/tablesorter.min.css" />
  	<link rel="stylesheet" type="text/css" href="css/consulta.css" />
  	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script> 
    <script type="text/javascript" src="js/tablesorter.min.js"></script> 
    <script type="text/javascript" src="js/consulta.js"></script> 
</head>
<body>	
	<div id="cargando">
    	<span>Cargando <img src="img/ajax-loader.gif" /></span>
    </div>
        
	<div id="info">
     	<div>
            <div class="formulario">
                <div class="header_info">
                    CONSULTA DE PAGOS                
                </div>
                <div class="espacio"></div>
                <form id="form_consulta" action="#" method="post" enctype="multipart/form-data">	
                    <div style="width:180px">
                        <label>Numero de Documento:</label>
                    </div> 
                    <div style="width:200px">                 	
                        <input type="text" id="documento" name="documento" class="input_l" value="" />
                    </div> 
                    <div style="width:100px">          	
                        <input type="button" id="consulta" class="boton_gris" value="Consulta" title="Consulta de Pagos">
                    </div>                    
                </form> 
                <div class="espacio"></div>
                <div class="header_nombre" id="nombre">            
                </div> 
                <table cellspacing="1" id="tabla" class="tablesorter">                             
             	</table>     
            </div>
            
    	</div>        
    </div>
    <div id="error" style="display:none"></div> 
    <div class="espacio"></div>   
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
     	</div>       
    </div>
</body>
</html>