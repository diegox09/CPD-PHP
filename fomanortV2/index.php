<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="author" content="Diego Fernando Rodriguez Rincon">
	
<title>FOMANORT</title>    
<link rel="shortcut icon" href="icons/application_home.png" type="image/ico" />	

	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
	<style>	
		.mensaje {margin: 0% auto; padding:5px; width:1024px;}
		.boton {background:url(imagenes/n3.png); border-radius:5px; border:1px solid #000; padding:7px; color:#000; font-weight:bold; box-shadow: 3px 3px 8px #999;}
		.error {background:url(imagenes/n4.gif); border-radius:5px; border:1px solid #000; padding:7px; color:#000; font-weight:bold; box-shadow: 3px 3px 8px #999;}
		.boton:focus {background:url(imagenes/n2.gif);}
		.boton:hover {background:url(imagenes/n2.gif);}
		.error:focus {background:url(imagenes/n2.gif);}
		.error:hover {background:url(imagenes/n2.gif);}
		#maraton {border-radius:10px; box-shadow: 3px 3px 8px #999;}
	</style>   
    
</head>
<body>	
    <div style="text-align:center" id="header"> 
    	<div id="header_inner" class="fixed">
            <div style="height:5px"></div>
            <img src="imagenes/logo_2.png"/> &nbsp;&nbsp; <img src="imagenes/titulo.png"/> &nbsp; <img src="imagenes/logo.png" />
        </div>    
    </div> 
    
    <div id="main">
		<div id="main_inner" class="fixed">
            <div class="espacio_pie" ></div>  
        
            <div class="mensaje"> 
                <div class="espacio_pie"></div> 
                <div style="float:left; width:20%; text-align:center;">
                    <a class="boton" title="Registrar Deportista" href="consultas/registro.php" style="text-decoration:none" ><img src="icons/user_orange.png" border="0" align="texttop"/> Registro Personas</a> 
                </div>
                
                <div style="float:left; width:20%; text-align:center;">
                    <a class="boton" title="Registrar Llegada" href="consultas/tiempos.php" style="text-decoration:none" ><img src="icons/time_add.png" border="0" align="texttop"/> Registro Tiempos</a> 
                </div> 

				<div style="float:left; width:20%; text-align:center;">
                    <a class="boton" title="Clasificacion" href="consultas/clasificacion.php" style="text-decoration:none" ><img src="icons/medal_gold_2.png" border="0" align="texttop"/> Clasificacion</a> 
                </div> 
                             
                <div style="float:left; width:20%; text-align:center;">
                    <a class="boton" title="Generar Reporte" href="excel/reporte.php" style="text-decoration:none" ><img src="icons/page_white_excel.png" border="0" align="texttop"/> Reporte</a>             
                </div> 
                
                <div style="float:left; width:20%; text-align:center;">
                    <a class="boton" title="Base de Datos" href="excel/base_datos.php" style="text-decoration:none" ><img src="icons/page_white_excel.png" border="0" align="texttop"/> Base de Datos</a>             
                </div> 
                <div class="espacio_pie"></div>                         
            </div>
            <div class="espacio_pie"></div> 
            
            <div style="text-align:center">
                <img id="maraton" src="imagenes/1.jpg" width="400"/>      
            </div>  
            
            <div class="pie">
                <br />
                &copy; Carrera Atletica Fomanort
            </div>
    	</div>
   	</div>             
</body>
</html>
