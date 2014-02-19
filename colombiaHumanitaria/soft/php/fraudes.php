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
				$documentoDamnificado = $damnificado['documento_damnificado'];				
				$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);				
				if(mysqli_num_rows($resultArrendador) != 0){
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
				}
				mysqli_free_result($resultArrendador);
			}
			mysqli_free_result($resultDamnificado);
		}
			
		$respuesta['consulta'] = $consulta;	
		$respuesta['perfil'] = $_SESSION['perfil_hu'];
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 			 
	