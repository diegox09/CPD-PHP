<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
		
	$id = $_POST["id"];
	$consulta = "";
		
	$query_select = "SELECT * FROM tiempo_deportista WHERE id_deportista = '".$id."' AND numero > 0";
	$rs_select = mysql_query($query_select);
	if (mysql_num_rows($rs_select) == 0){					
		$query_delete = "DELETE FROM tiempo_deportista WHERE id_deportista = '".$id."' AND numero = 0";	
		$rs_delete = mysql_query($query_delete);
		if (!$rs_delete)	
			$consulta .= "<error>Error al Eliminar el Deportista.</error>";	
	}
	else
		$consulta .= "<error>No se Puede Eliminar el Deportista, tiene un numero asignado</error>";	
			
	$consulta = "<mensaje>".$consulta."</mensaje>";
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	