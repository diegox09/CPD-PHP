<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />	
<meta name="author" content="Diego Fernando Rodriguez Rincon">
<title>FOMANORT</title>    
<link rel="shortcut icon" href="../icons/application_home.png" type="image/ico" />		
    	
    <link rel="stylesheet" type="text/css" href="../css/constancia.css" />
    <link rel="stylesheet" type="text/css" href="../css/imprimir.css" media="print"/>  
    
    <link rel="stylesheet" type="text/css" href="../build/fonts/fonts-min.css" />
	
    <script type="text/javascript" src="../build/yahoo/yahoo-min.js"></script>
    <script type="text/javascript" src="../build/event/event-min.js"></script>
    <script type="text/javascript" src="../build/connection/connection-min.js"></script>
    
</head>
<body class="yui-skin-sam" > 
    <div style="text-align:center" id="header"> 
    	<div id="header_inner" class="fixed">
            <div style="height:5px"></div>
            <a href="../index.php"><img src="../imagenes/logo_2.png"/> &nbsp;&nbsp; <img src="../imagenes/titulo.png"/> &nbsp; <img src="../imagenes/logo.png" /></a>
        </div>    
    </div> 
            
    <div id="hoja">
        <div id="cuerpo" contentEditable="true">
            <div class="espacio1"></div>
            <div id="encabezado">
                LA DIRECTORA EJECUTIVA DE LA FUNDACION DE INVESTIGACIONES EDUCATIVAS Y SERVICIOS SOCIALES FOMANORT - FINEF -
                <div class="espacio2"></div>
                CERTIFICA:            
            </div>
            
            <div class="espacio2"></div>
            <?php			
				include ("../conectar.php");
				
				$id = $_GET["id"];
				$year = $_GET["year"];
				
				date_default_timezone_set('America/Bogota');				
				
				$fecha = date("j-n-Y");
				$fecha = split("-", $fecha);
				
				$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
				$dias = array("", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve", "diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisite", "dieciocho", "diecinueve", "veinte", "veintiún", "veintidós", "veintitrés", "veinticuatro", "veinticinco", "veintiséis", "veintisiete", "veintiocho", "veintinueve", "treinta", "treinta y un");
				$documentos = array("cédula de ciudadanía", "cédula de ciudadanía", "tarjeta de identidad", "cédula de ciudadanía");
												
				$dia = $dias[$fecha[0]];
				$mes = $meses[$fecha[1]];
				$anio = $fecha[2];
				
				$nombre = "";
				$documento = "";
				$ciudad = "";
				$tipo_documento = 0;
				$categoria = "";
				$tiempo = "";
				$puesto = "";
				
				$hora = 0;
				$minutos = 0;
				$segundos = 0;
				
				$query_select = "SELECT * FROM constancia WHERE year = ".$year;
				$rs_select = mysql_query($query_select);
				if (mysql_num_rows($rs_select) > 0)
					$texto = utf8_encode(mysql_result($rs_select,0,"texto"));	
				else
					$texto = "";
					
				$query_select = "SELECT * FROM deportista, tiempo_deportista, categoria WHERE deportista.id_deportista = '".$id."' AND tiempo_deportista.year = '".$year."' AND deportista.id_deportista = tiempo_deportista.id_deportista AND tiempo_deportista.id_categoria = categoria.id_categoria";	
				$rs_select = mysql_query($query_select);
				if (mysql_num_rows($rs_select) > 0){	
					$nombre = utf8_encode(mysql_result($rs_select,0,"deportista.nombres"))." ".utf8_encode(mysql_result($rs_select,0,"deportista.apellidos"));
					$ciudad = utf8_encode(mysql_result($rs_select,0,"deportista.pais"));
					$documento = number_format(mysql_result($rs_select,0,"documento"),0,"",".");
					$tipo_documento = mysql_result($rs_select,0,"tipo_documento");
					$tipo_documento = $documentos[$tipo_documento];
									
					$tiempo = mysql_result($rs_select,0,"tiempo_deportista.tiempo");
					
					$id_categoria = mysql_result($rs_select,0,"tiempo_deportista.id_categoria");
					$categoria = mysql_result($rs_select,0,"categoria.descripcion");		
														
					$query_select_2 = "SELECT * FROM tiempo_deportista WHERE id_categoria = '".$id_categoria."' AND year = ".$year." AND tiempo_deportista.tiempo > 0 ORDER BY tiempo, hora";
					$rs_select_2 = mysql_query($query_select_2);
					$contador_2 = 0;
					while (mysql_num_rows($rs_select_2) > $contador_2){
						if($id == mysql_result($rs_select_2,$contador_2,"id_deportista")){
							$puesto = $contador_2+1;
							break;
						}
						$contador_2++;
					}
				}						
				
				$hora = number_format(substr($tiempo,1,2));
				$minutos = number_format(substr($tiempo,3,2));
				$segundos = number_format(substr($tiempo,6,2));			
									
				
				echo '<div id="texto"><p>Que el atleta <strong>'.$nombre.'</strong>
						identificado(a) con '.$tipo_documento.' Nº <strong>'.$documento.'</strong>
						expedida en '.$ciudad.', participó en la '.$texto.'.';
				if($puesto != 0){		 
					echo ' Obteniendo el '.$puesto.' puesto en la Categoría  '.$categoria.',
							 con un tiempo de ';	
					if($hora > 0)
						echo '1 hora ';
						
					if($minutos == 1)
						echo $minutos.' minuto';
					else
					if($minutos > 1)
						echo $minutos.' minutos';
					
					if($segundos > 1)
						echo ' y '.$segundos.' segundos';
					else
						if($segundos > 0)
							echo ' y '.$segundos.' segundo';
					echo '.';									 
				}
				echo '<br /><br />
						Se expide el siguiente certificado en San José de Cúcuta
						a los '.$dia.' ('.$fecha[0].') días del mes de '.$mes.' de '.$anio.'.
					 </div>';
            ?> 
            <div class="espacio3"></div>
            <div id="firma">
                GISELL ORIANA PINTO MORENO
                <br />        
                Directora Ejecutiva FINEF
            </div>
        </div> 
    </div>
    
    <div id="imprimir">    	
    	<div style="width:6.4cm; text-align:center;">
        	<a class="boton" title="Imprimir" onClick="window.print();" href="#" style="text-decoration:none" ><img src="../icons/printer_empty.png" border="0" align="texttop"/> Imprimir</a>             
        </div>        
    </div>
    
    <div class="espacio_pie"></div>     
    <div class="pie" >
        <br />
        &copy; Carrera Atletica Fomanort
    </div>        
</body>
</html>