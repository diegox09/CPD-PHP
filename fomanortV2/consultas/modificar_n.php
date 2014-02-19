<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
	
	$numero = $_POST["numero_m"];
	$id_d = $_POST["id_m"];
	date_default_timezone_set('America/Bogota'); 
	$year = date('Y');
	
	$query_select = "SELECT * FROM tiempo_deportista WHERE numero = '".$numero."' AND year = '".$year."'";
	$rs_select = mysql_query($query_select);
	if (mysql_num_rows($rs_select) > 0)
		$consulta = "<error>Error el Numero de Camiseta ya esta Registrado.</error>";		
	
	else{
		$query_update = "UPDATE tiempo_deportista SET numero = '".$numero."' WHERE id_deportista = '".$id_d."' AND year = '".$year."'";
		$rs_update = mysql_query($query_update);
		if (!$rs_update)	
			$consulta = "<error>Error al Actualizar la informacion.</error>";
		else
			$consulta = "<numero>".$numero."</numero>";	
	}		
	$consulta = "<mensaje>".$consulta."</mensaje>";
	echo"$consulta";		
?> 
			 
	