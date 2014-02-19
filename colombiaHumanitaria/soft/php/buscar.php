<?php
	session_start();
	
	require_once('classes/Humanitaria.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = false;
		$damnificado = true;
		$buscar = utf8_decode(trim($_GET['buscar']));
		$arrendador = $_GET['arrendador'];
		if($buscar != ''){	
			if($arrendador != '1'){						
				if(is_numeric($buscar))						
					$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_documento($buscar);
				else
					$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_nombre($buscar);
								
				while ($row = mysqli_fetch_array($resultDamnificado)){					
					$consulta = true;
					$respuesta['idDamnificado'][] = $row['id_damnificado'];					
					$respuesta['documentoDamnificado'][] = $row['documento_damnificado'];
					$nombreDamnificado = utf8_encode($row['primer_nombre']);
					if($row['segundo_nombre'] != '')
						$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($row['segundo_nombre']);
					if($row['primer_apellido'] != '')
						$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($row['primer_apellido']);
					if($row['segundo_apellido'] != '')
						$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($row['segundo_apellido']);	
					$respuesta['nombreDamnificado'][] = $nombreDamnificado;
					$respuesta['documentoArrendador'][] = '';
					$respuesta['nombreArrendador'][] = '';
				}			
				mysqli_free_result($resultDamnificado);
			}
			
			if($consulta == false){
				$damnificado = false;
				if(is_numeric($buscar))						
					$resultArrendador = Humanitaria::getInstance()->get_damnificado_by_documento_arrendador($buscar);
				else
					$resultArrendador = Humanitaria::getInstance()->get_damnificado_by_nombre_arrendador($buscar);
				
				while ($row = mysqli_fetch_array($resultArrendador)){	
					$consulta = true;
					$respuesta['idDamnificado'][] = $row['id_damnificado'];
					$respuesta['documentoDamnificado'][] = $row['documento_damnificado'];
					$nombreDamnificado = utf8_encode($row['primer_nombre']);
					if($row['segundo_nombre'] != '')
						$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($row['segundo_nombre']);
					if($row['primer_apellido'] != '')
						$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($row['primer_apellido']);
					if($row['segundo_apellido'] != '')
						$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($row['segundo_apellido']);
					$respuesta['nombreDamnificado'][] = $nombreDamnificado;
					$respuesta['documentoArrendador'][] = $row['documento_arrendador'];
					$respuesta['nombreArrendador'][] = utf8_encode($row['nombre_arrendador']);
				}
				mysqli_free_result($resultArrendador);
			}
		}
		
		$respuesta['consulta'] = $consulta;	
		$respuesta['damnificado'] = $damnificado;			
		$respuesta['perfil'] = $_SESSION['perfil_hu'];
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 