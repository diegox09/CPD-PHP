<?php
	require_once('classes/User.php');
	require_once('classes/ReteIca.php');	
	
	$logonSuccess = false;
	$respuesta = array();	
	
	session_start();
	if (array_key_exists('id_fe', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_fe'] == User::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){			
		$idReteica = $_GET['id_reteica'];
		$opc = $_GET['opc'];
		$consulta = true;				
		if($idReteica != ''){
			switch($opc){
				case 'update' :	$ciiu = $_GET['ciiu'];
								$tipoActividad = $_GET['tipo_actividad'];
								$actividad = utf8_decode($_GET['actividad']);
								$tarifa = $_GET['tarifa_ica'];
								$consulta = ReteIca::getInstance()->update_reteica($idReteica, $ciiu, $tipoActividad, $actividad, $tarifa);
								break;
				case 'delete' :	$consulta = ReteIca::getInstance()->delete_reteica($idReteica);
								if($consulta)
									$respuesta['idReteica'] = $idReteica;
								break;				
			}			
			if($opc != 'delete')
				$result = ReteIca::getInstance()->get_reteica_by_id($idReteica);			
		}
		else{
			switch($opc){
				case 'all':		$result = ReteIca::getInstance()->get_reteica();
								break;
				case 'insert':  $ciiu = $_GET['ciiu'];
								$tipoActividad = $_GET['tipo_actividad'];
								$actividad = utf8_decode($_GET['actividad']);
								$tarifa = $_GET['tarifa_ica'];								
								$consulta = ReteIca::getInstance()->insert_reteica($ciiu, $tipoActividad, $actividad, $tarifa); 
								$result = ReteIca::getInstance()->get_reteica_by_actividad($actividad);
								break;						
			}			
		}
		
		if($opc != 'delete'){		
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{
				while ($row = mysqli_fetch_array($result)){
					$respuesta['idReteica'][] = $row['idTarifaIca'];
					$respuesta['ciiu'][] = $row['ciiu'];
					$respuesta['tipoActividad'][] = $row['tipoActividad'];
					$respuesta['actividad'][] = utf8_encode($row['actividad']);
					$respuesta['tarifa'][] = $row['tarifa'];				
				}	
				mysqli_free_result($result);		
			}			
		}
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 