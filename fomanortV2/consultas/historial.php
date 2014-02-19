<?php
	header("Content-Type: text/txt; charset=utf-8");
   	include ("../conectar.php");
		
	//$id = $_GET["id"];
	$id = $_POST["id"];			
	$consulta = "";

	date_default_timezone_set('America/Bogota'); 
	$year_actual = date('Y');
		
	$year = 2012;
	$consulta .= "<Table border='0'><tr style='height:30px; background:url(../imagenes/n6.png)'><th width='10%'>A&#241o</th><th width='35%'>Categoria</th><th width='10%'>Numero Camiseta</th><th width='20%'>Tiempo</th><th width='10%'>Puesto</th><th width='10%'></th></tr>"; 
	
	while($year <= $year_actual){
		$query_select = "SELECT * FROM deportista, tiempo_deportista, categoria WHERE tiempo_deportista.year = '".$year."' AND deportista.id_deportista = '".$id."' AND deportista.id_deportista = tiempo_deportista.id_deportista AND tiempo_deportista.id_categoria = categoria.id_categoria AND tiempo_deportista.tiempo > 0";	
		$rs_select = mysql_query($query_select);
		$contador = 0;		
		if (mysql_num_rows($rs_select) > $contador){
			$consulta .= "<tr style='height:30px'>";
			$consulta .= "<td align='center'>".$year."</td>";	
			$id_categoria = mysql_result($rs_select,$contador,"tiempo_deportista.id_categoria");
			$consulta .= "<td align='center'>".mysql_result($rs_select,$contador,"categoria.descripcion")."</td>";		
			$consulta .= "<td align='center'>".mysql_result($rs_select,$contador,"tiempo_deportista.numero")."</td>";	
			$consulta .= "<td align='center'>".mysql_result($rs_select,$contador,"tiempo_deportista.tiempo")."</td>";
						
			
			$puesto = "";				
			$query_select_2 = "SELECT * FROM tiempo_deportista WHERE id_categoria = '".$id_categoria."' AND year = ".$year." AND tiempo_deportista.tiempo > 0 ORDER BY tiempo, hora";
			$rs_select_2 = mysql_query($query_select_2);
			$contador_2 = 0;
			while (mysql_num_rows($rs_select_2) > $contador_2){
				if($id == mysql_result($rs_select_2,$contador_2,"id_deportista")){
					$puesto = $contador_2+1;
					$consulta .= "<td align='center'>".$puesto."</td>";
					break;
				}
				$contador_2++;
			}		
			$consulta .= "<td align='center'><a class='boton1' target='_blank' href='../pdf/constancia_e.php?id=".$id."&year=".$year."'><img src='../icons/printer_empty.png'/></a></td>";			
			$consulta .= "</tr>";
		}
		$year++;
	}
	
	if($consulta == "")
		$consulta .= "0";
					
	$consulta = "<mensaje>".$consulta."</mensaje>";
	$consulta = utf8_encode ( $consulta );
	
	echo"$consulta";	
?> 
			 
	