<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
		
	$id = $_POST["id"];
	date_default_timezone_set('America/Bogota'); 
	$year = date('Y');
	$consulta = "";
	
	
	$query_delete = "UPDATE tiempo_deportista SET tiempo = '00:00:00' WHERE id_deportista = '".$id."' AND year = '".$year."'";
	$rs_delete = mysql_query($query_delete);
	if (!$rs_delete)	
		$consulta = "<error>Error al Eliminar el Registro.</error>";				
				
	$consulta = "<mensaje>".$consulta."</mensaje>";
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	