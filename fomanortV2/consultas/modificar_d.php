<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
	
	$documento = $_POST["documento_m"];
	$id_d = $_POST["id_m"];
	
	$query_select = "SELECT * FROM deportista WHERE documento = '".$documento."'";
	$rs_select = mysql_query($query_select);
	if (mysql_num_rows($rs_select) > 0)
		$consulta = "<error>Error el Numero de Documento ya esta Registrado.</error>";		
	
	else{
		$query_update = "UPDATE deportista SET documento = '".$documento."' WHERE id_deportista = '".$id_d."'";
		$rs_update = mysql_query($query_update);
		if (!$rs_update)	
			$consulta = "<error>Error al Actualizar la informacion.</error>";
		else
			$consulta = "<documento>".$documento."</documento>";	
	}		
	$consulta = "<mensaje>".$consulta."</mensaje>";
	echo"$consulta";	
?> 
			 
	