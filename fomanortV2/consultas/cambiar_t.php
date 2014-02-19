<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
		
	date_default_timezone_set('America/Bogota'); 
	$hora = date('Y-m-d H:i:s');
	$year = date('Y');
		
	$id = $_POST["id_m"];
	$tiempo = $_POST["tiempo_m"];	
	
	$consulta = "<id>".$id."</id>";	
	
	$longitud = strlen($tiempo);
	switch($longitud){
		case 1:	$tiempo = "00:00:0".$tiempo;
				break;
		case 2:	$tiempo = "00:00:".$tiempo;
				break;
		case 3:	$tiempo = "00:00".$tiempo;
				break;
		case 4:	$tiempo = "00:0".$tiempo;
				break;
		case 5:	$tiempo = "00:".$tiempo;
				break;
		case 6:	$tiempo = "00".$tiempo;
				break;
		case 7:	$tiempo = "0".$tiempo;
				break;		
	}		
		
	$tiempo = $tiempo;
	$query_select = "SELECT * FROM tiempo_deportista WHERE id_deportista = '".$id."' AND year = ".$year." AND tiempo_deportista.tiempo > 0";
	$rs_select = mysql_query($query_select);
	if (mysql_num_rows($rs_select) > 0){
		$query_update = "UPDATE tiempo_deportista SET tiempo = '".$tiempo."' WHERE id_deportista = '".$id."' AND year = ".$year;
		$rs_update = mysql_query($query_update);
		if (!$rs_update)	
			$consulta .= "<error>Error al Actualizar la informacion.</error>";
		
		$query_select = "SELECT * FROM tiempo_deportista WHERE id_deportista = '".$id."' AND year = ".$year;
		$rs_select = mysql_query($query_select);
		if (mysql_num_rows($rs_select) > 0)
			$consulta .= "<tiempo>".mysql_result($rs_select,0,"tiempo")."</tiempo>";
	}	
	else
		$consulta .= "<error>Error</error>";
	
	$consulta = "<mensaje>".$consulta."</mensaje>";	
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	