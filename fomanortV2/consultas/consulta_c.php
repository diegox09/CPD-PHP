<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
	
	date_default_timezone_set('America/Bogota'); 
	$hora = date('Y-m-d H:i:s');
	$year = date('Y');
	
	$numero = $_POST["numero"];	
	$tiempo = $_POST["tiempo"];		
	$consulta = "";
	$sql = "";
	
	if($numero != "*"){
		$query_select = "SELECT * FROM deportista, tiempo_deportista WHERE tiempo_deportista.year = '".$year."' AND deportista.id_deportista = tiempo_deportista.id_deportista AND tiempo_deportista.numero = '".$numero."'";
		$rs_select = mysql_query($query_select);
		if (mysql_num_rows($rs_select) != 0){
			if(mysql_result($rs_select,0,"tiempo_deportista.tiempo") == '00:00:00'){
				$query_update = "UPDATE tiempo_deportista SET tiempo = '".$tiempo."', hora = '".$hora."' WHERE numero = ".$numero." AND year = ".$year;				
				$rs_update = mysql_query($query_update);
				if (!$rs_update)	
					$consulta .= "<error>$query_update Error al Guardar la Llegada.</error>";				
			}
			else
				$consulta .= "<error>Ya se Registro la Llegada</error>";
		}
		else
			$consulta .= "<error>No Hay Ningun Participante Con ese Numero.</error>";
		
			
		$sql = "AND tiempo_deportista.numero = '".$numero."'";	
	}	
	
	$query_select = "SELECT * FROM deportista, tiempo_deportista, categoria WHERE tiempo_deportista.year = '".$year."' AND deportista.id_deportista = tiempo_deportista.id_deportista ".$sql." AND tiempo_deportista.id_categoria = categoria.id_categoria AND tiempo_deportista.tiempo > 0 ORDER BY tiempo_deportista.id_categoria, tiempo_deportista.tiempo";	
	$rs_select = mysql_query($query_select);
	$contador = 0;
	while (mysql_num_rows($rs_select) > $contador){
		$consulta .= "<deportista>";
		$id = mysql_result($rs_select,$contador,"deportista.id_deportista");	
		$consulta .= "<id>".$id."</id>";		
		$consulta .= "<nombres>".mysql_result($rs_select,$contador,"deportista.nombres")."</nombres>";
		$consulta .= "<apellidos>".mysql_result($rs_select,$contador,"deportista.apellidos")."</apellidos>";
		$consulta .= "<pais>".mysql_result($rs_select,$contador,"deportista.pais")."</pais>";
		$consulta .= "<entidad>".mysql_result($rs_select,$contador,"deportista.entidad")."</entidad>";	
		
		$consulta .= "<numero>".mysql_result($rs_select,$contador,"tiempo_deportista.numero")."</numero>";	
		$consulta .= "<tiempo>".mysql_result($rs_select,$contador,"tiempo_deportista.tiempo")."</tiempo>";
		
		$id_categoria = mysql_result($rs_select,$contador,"tiempo_deportista.id_categoria");
		$consulta .= "<categoria>".mysql_result($rs_select,$contador,"categoria.descripcion")."</categoria>";		
		
		
		$puesto = "";				
		$query_select_2 = "SELECT * FROM tiempo_deportista WHERE id_categoria = '".$id_categoria."' AND year = ".$year." AND tiempo_deportista.tiempo > 0 ORDER BY tiempo, hora";
		$rs_select_2 = mysql_query($query_select_2);
		$contador_2 = 0;
		while (mysql_num_rows($rs_select_2) > $contador_2){
			if($id == mysql_result($rs_select_2,$contador_2,"id_deportista")){
				$puesto = $contador_2+1;
				$consulta .= "<puesto>".$puesto."</puesto>";
				break;
			}
			$contador_2++;
		}
		
		$consulta .= "</deportista>";
		$contador ++;
	}
		
	if($consulta == "")
		$consulta .= "<error>0</error>";
					
	$consulta = "<mensaje>".$consulta."</mensaje>";
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	