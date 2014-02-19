<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
	
	date_default_timezone_set('America/Bogota');
	$year = date('Y');
	$consulta = "";
			
	$query_select = "SELECT * FROM categoria WHERE year = '".$year."' ORDER BY id_categoria";
	$rs_select = mysql_query($query_select);
	$contador = 0;
	while (mysql_num_rows($rs_select) > $contador){
		$consulta .= "<categoria>";		
		$consulta .= "<descripcion>".mysql_result($rs_select,$contador,"descripcion")."</descripcion>";
		$consulta .= "<id>".mysql_result($rs_select,$contador,"id_categoria")."</id>";		
		$consulta .= "</categoria>";
		$contador ++;
	}
		
	if($consulta == "")
		$consulta .= "<error>Error al Cargar las categorias</error>";
					
	$consulta = "<mensaje>".$consulta."</mensaje>";
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	