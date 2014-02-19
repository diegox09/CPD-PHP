<?php
	session_start();
	
	require_once('classes/Humanitaria.php');
	require_once('funciones/funciones.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = false;
		$fase = $_GET['fase'];
		
		$damnificados = array();
		$result = Humanitaria::getInstance()->get_entregas_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_arriendos_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		foreach ($damnificados as $id){
			$idDamnificado = $id;
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
			if(mysqli_num_rows($resultDamnificado) != 0){				
				$damnificado = mysqli_fetch_array($resultDamnificado);			
				$primerNombre = $damnificado['primer_nombre'];
				$segundoNombre = $damnificado['segundo_nombre'];
				$primerApellido = $damnificado['primer_apellido'];
				$segundoApellido = $damnificado['segundo_apellido'];
				$documentoDamnificado = $damnificado['documento_damnificado'];
				
				$resultDamnificado2 = Humanitaria::getInstance()->get_damnificados_repetidos($documentoDamnificado, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido);
				while ($row = mysqli_fetch_array($resultDamnificado2)){				
					$primerNombre2 = $row['primer_nombre'];
					$segundoNombre2 = $row['segundo_nombre'];
					$primerApellido2 = $row['primer_apellido'];
					$segundoApellido2 = $row['segundo_apellido'];
					similar_text($primerNombre.$segundoNombre.$primerApellido.$segundoApellido, $primerNombre2.$segundoNombre2.$primerApellido2.$segundoApellido2, $porcentaje);
					if($porcentaje > 90){
						$consulta = true;						
						$nombreDamnificado = utf8_encode($damnificado['primer_nombre']);
						if($damnificado['segundo_nombre'] != '')
							$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_nombre']);
						if($damnificado['primer_apellido'] != '')
							$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['primer_apellido']);
						if($damnificado['segundo_apellido'] != '')
							$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_apellido']);
						
						$respuesta['nombreDamnificado'][] = $nombreDamnificado;
						$respuesta['documentoDamnificado'][] = $documentoDamnificado;
						$respuesta['porcentaje'][] = number_format($porcentaje,0);
					}
				}
				mysqli_free_result($resultDamnificado2);
			}
			mysqli_free_result($resultDamnificado);
		}
	
		$respuesta['consulta'] = $consulta;	
		$respuesta['perfil'] = $_SESSION['perfil_hu'];
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 			 
	