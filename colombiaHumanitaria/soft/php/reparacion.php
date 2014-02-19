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
		$idDamnificado = $_GET['id_damnificado'];
		$opc = $_GET['opc'];
		$consulta = true;	
		$fase = $_GET['fase'];	
		$comprobante = $_GET['comprobante'];		
		$fechaReparacion = explota($_GET['fecha_reparacion']);
		$observaciones = $_GET['observaciones'];
		$estado = $_GET['bloquear'];
		$idUser = $_SESSION['id_hu'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){		
			case 'cargar':	$result = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);								
							break;
			case 'eliminar':$consulta = Humanitaria::getInstance()->delete_reparacion($idDamnificado, $fase);								
							break;										
			case 'guardar':	$consulta = Humanitaria::getInstance()->update_reparacion($idDamnificado, $fase, $comprobante, $fechaReparacion, $estado, $observaciones, $fechaActual, $idUser);							
							$result = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);								
							break;								
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$reparacion = mysqli_fetch_array($result);									
				$respuesta['fechaReparacion'] = implota($reparacion['fecha_reparacion']);
				$respuesta['estado'] = $reparacion['id_estado'];
				$respuesta['fecha'] = $reparacion['fecha'];
				$respuesta['observaciones'] = utf8_encode($reparacion['observaciones']);
				if($reparacion['comprobante'] == NULL)
					$respuesta['comprobante'] = '';
				else
					$respuesta['comprobante'] = $reparacion['comprobante'];
				
				$idUser = $reparacion['id_usuario'];				
				$usuario = mysqli_fetch_array(Humanitaria::getInstance()->get_user_by_id($idUser));					
				$respuesta['user'] = $usuario['user'];
			}
			mysqli_free_result($result);
		}
										
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		$respuesta['perfil'] = $_SESSION['perfil_hu'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 