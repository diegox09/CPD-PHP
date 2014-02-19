<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
	
	$documento = $_POST["documento"];
	date_default_timezone_set('America/Bogota'); 
	$year = date('Y');

	$query_insert = "INSERT INTO deportista (documento, year) VALUES ('".$documento."', '".$year."')";
	$rs_insert = mysql_query($query_insert);
	if (!$rs_insert)
		$consulta = "<error>Error al Actualizar la informacion.</error>";
	else{		
		$query_select = "SELECT id_deportista FROM deportista WHERE documento = '".$documento."'";
		$rs_select = mysql_query($query_select);
		if (mysql_num_rows($rs_select) > 0)
			$consulta = "<id>".mysql_result($rs_select,0,"id_deportista")."</id>";
		else
			$consulta = "<error>Error al Cargar la informacion.</error>";	
	}
		
	$consulta = "<mensaje>".$consulta."</mensaje>";
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	