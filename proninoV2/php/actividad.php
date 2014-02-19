<?php
	session_start();
	
	require_once('classes/Pronino.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = true;			
		$opc = $_GET['opc'];		
		$idActividad = $_GET['id'];
		$nombreActividad = utf8_decode(trim($_GET['nombre']));		
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_actividad_by_id($idActividad);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_actividad_like_nombre($nombreActividad);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_beneficiario_by_actividad($idActividad);	
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_actividad($idActividad); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idActividad != ''){
								$consulta = Pronino::getInstance()->update_actividad($idActividad, $nombreActividad, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_actividad_by_id($idActividad);
							}
							else{
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_actividad_by_nombre($nombreActividad);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_actividad_like_nombre($nombreActividad);
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_actividad($nombreActividad, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_actividad_by_nombre($nombreActividad);			 
							break;												
			case 'lista': 	$result = Pronino::getInstance()->get_actividades(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($escuela = mysqli_fetch_array($result)){
					$respuesta['id'][] = $escuela['idActividad'];					
					$respuesta['nombre'][] = utf8_encode($escuela['nombreActividad']);
					
					$respuesta['fechaActualizacion'][] = $escuela['fechaActualizacion'];					
					$idUser = $escuela['idUser'];
					
					$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
					$respuesta['nombreUser'][] = htmlentities($usuario['user']);
				}	
				mysqli_free_result($result);		
			}		
		}
		
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']));
		$respuesta['perfil'] = $usuario['tipoUser'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 