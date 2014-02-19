<?php
	header("Content-Type: text/xml; charset=utf-8");
   	include ("../conectar.php");
	
	date_default_timezone_set('America/Bogota'); 
	$hora = date('Y-m-d H:i:s');
	$year = date('Y');
	
	$id = $_POST["id"];
	$opc = $_POST["opc"];	
	$campo = $_POST["campo"];	
	$consulta = "<codigo>".$opc."</codigo>";
	$nuevo = "<nuevo>no</nuevo>";
	$error = "";	
	
	$campo = utf8_decode($campo);
	$campo = strtoupper($campo);
		
	if($opc == "11"){	
		$inicio = 0;
		$fin = 1500;
		$numero = "";
		$temp = 0;	
		
		if($campo > 0){
			$numero = 0;		
			$query_select = "SELECT * FROM categoria WHERE id_categoria = '".$campo."'";
			$rs_select = mysql_query($query_select);
			if (mysql_num_rows($rs_select) > 0){
				$inicio = mysql_result($rs_select,0,"num_inicio");		
				$fin = mysql_result($rs_select,0,"num_fin");	
			}
					
			$query_select = "SELECT * FROM tiempo_deportista WHERE year = ".$year." AND numero > ".$inicio." AND numero < ".$fin." ORDER BY numero";		
			$rs_select = mysql_query($query_select);
			$contador = 0;		
			while (mysql_num_rows($rs_select) > $contador){			
				$temp = $inicio + $contador + 1;
				$num = (int)mysql_result($rs_select,$contador,"numero");
				if($temp == $num)
					$contador++;	
				else{
					$numero = $temp;
					break;
				}						
			}
			if($numero == 0)
				$numero = $inicio + $contador + 1;
		}
	}
		
	/*
	1. Documento
	2. TD
	3. Nombres
	4. Apellidos
	5. Entidad
	6. Pais
	7. Telefono
	8. Direccion	
	9. EPS
	10. RH
	
	11. Categoria  (Modificar)
	12. Numero     (Modificar)			
	13. Buscar por Numero (Modificar)
	
	11. Tiempo    (Modificar)	
	*/
	
	switch($opc){
		case 1:	$query_select = "SELECT id_deportista FROM deportista WHERE documento = '".$campo."'";
				$rs_select = mysql_query($query_select);
				if (mysql_num_rows($rs_select) > 0)
					$id = mysql_result($rs_select,0,"id_deportista");	
				else
					$nuevo = "<nuevo>si</nuevo>";
				break;
		case 2:	$query_update = "UPDATE deportista SET tipo_documento = '".$campo."' WHERE id_deportista = '".$id."'";
				break;
		case 3:	$query_update = "UPDATE deportista SET nombres = '".$campo."' WHERE id_deportista = '".$id."'";
				break;
		case 4:	$query_update = "UPDATE deportista SET apellidos = '".$campo."' WHERE id_deportista = '".$id."'";
				break;		
		case 5:	$query_update = "UPDATE deportista SET entidad = '".$campo."' WHERE id_deportista = '".$id."'";
				break;
		case 6:	$query_update = "UPDATE deportista SET pais = '".$campo."' WHERE id_deportista = '".$id."'";
				break;		
		case 7:	$query_update = "UPDATE deportista SET telefono = '".$campo."' WHERE id_deportista = '".$id."'";
				break;
		case 8:$query_update = "UPDATE deportista SET direccion = '".$campo."' WHERE id_deportista = '".$id."'";
				break;
		case 9:$query_update = "UPDATE deportista SET eps = '".$campo."' WHERE id_deportista = '".$id."'";
				break;	
		case 10:$query_update = "UPDATE deportista SET rh = '".$campo."' WHERE id_deportista = '".$id."'";
				break;
		case 11:$query_select = "SELECT * FROM tiempo_deportista WHERE id_deportista = '".$id."' AND year = '".$year."'";
				$rs_select = mysql_query($query_select);
				if (mysql_num_rows($rs_select) > 0){
					if(mysql_result($rs_select,0,"tiempo") == '00:00:00')					
						$query_update= "UPDATE tiempo_deportista SET numero = '".$numero."', id_categoria = '".$campo."' WHERE id_deportista = '".$id."' AND year = '".$year."'";
					else
						$query_update= "UPDATE tiempo_deportista SET id_categoria = '".$campo."' WHERE id_deportista = '".$id."' AND year = '".$year."'";	
					$rs_update = mysql_query($query_update);					
					if (!$rs_update)	
						$consulta .= "<error>Error al Actualizar la informacion. El Numero ya fue Registrado a Otra Persona:  $numero</error>";	
				}
				else{
					$query_insert= "INSERT tiempo_deportista (id_deportista, id_categoria, numero, year) VALUES ('".$id."', '".$campo."', '".$numero."', '".$year."')";
					$rs_insert = mysql_query($query_insert);					
					if (!$rs_insert)	
						$consulta .= "<error>Error al Actualizar la informacion. El Numero ya fue Registrado a Otra Persona:  $numero</error>";	
				}
				
				break;			
		case 12:$query_select = "SELECT id_deportista FROM tiempo_deportista WHERE numero = '".$campo."' AND year = '".$year."'";
				$rs_select = mysql_query($query_select);
				if (mysql_num_rows($rs_select) > 0)
					$id = mysql_result($rs_select,0,"id_deportista");	
				else
					$nuevo = "<nuevo>si</nuevo>";
				break;				
	}
			
	if(($opc > 1 && $opc < 11)){	
		$rs_update = mysql_query($query_update);
		if (!$rs_update)	
			$consulta .= "<error>Error al Actualizar la informacion.".$error."</error>";			
	}
	
	$query_select = "SELECT * FROM deportista WHERE id_deportista = '".$id."'";	
	$rs_select = mysql_query($query_select);
	if (mysql_num_rows($rs_select) > 0){
		$consulta .= "<id>".$id."</id>";
		$consulta .= "<documento>".mysql_result($rs_select,0,"documento")."</documento>";
		$consulta .= "<td>".mysql_result($rs_select,0,"tipo_documento")."</td>";
		$consulta .= "<nombres>".mysql_result($rs_select,0,"nombres")."</nombres>";
		$consulta .= "<apellidos>".mysql_result($rs_select,0,"apellidos")."</apellidos>";	
		$consulta .= "<entidad>".mysql_result($rs_select,0,"entidad")."</entidad>";
		$consulta .= "<pais>".mysql_result($rs_select,0,"pais")."</pais>";
		$consulta .= "<telefono>".mysql_result($rs_select,0,"telefono")."</telefono>";
		$consulta .= "<direccion>".mysql_result($rs_select,0,"direccion")."</direccion>";
		$consulta .= "<eps>".mysql_result($rs_select,0,"eps")."</eps>";
		$consulta .= "<rh>".mysql_result($rs_select,0,"rh")."</rh>";
		
		$query_select_2 = "SELECT * FROM tiempo_deportista WHERE year = '".$year."' AND id_deportista = '".$id."'";
		$rs_select_2 = mysql_query($query_select_2);
		if (mysql_num_rows($rs_select_2) > 0){
			$consulta .= "<categoria>".mysql_result($rs_select_2,0,"id_categoria")."</categoria>";
			$consulta .= "<numero>".mysql_result($rs_select_2,0,"numero")."</numero>";
		}
		else{
			$consulta .= "<categoria>0</categoria>";
			$consulta .= "<numero></numero>";
		}
		
	}
			
	$consulta = "<mensaje>".$nuevo.$consulta."<actualizar>".$opc."</actualizar></mensaje>";
	$consulta = utf8_encode ( $consulta );
	echo"$consulta";	
?> 
			 
	