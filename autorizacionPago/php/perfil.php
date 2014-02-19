<?php
	session_start();
			
	require_once('classes/AutorizacionPago.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){			
		$opc = $_GET['opc'];
		$consulta = true;		
				
		switch($opc){	
			case 'lista': 	$result = AutorizacionPago::getInstance()->get_perfil(); 
							break;
			case 'perfil':  $result = AutorizacionPago::getInstance()->get_user_by_id($_SESSION['id_ap']);
							break;				
			default:		$result = false;
							break;																												
		}		
		
		if(mysqli_num_rows($result) == 0){
			$consulta = false;			
		}
		else{
			if($opc == 'lista'){
				while ($perfil = mysqli_fetch_array($result)){
					$respuesta['id'][] = $perfil['idPerfil'];
					$respuesta['nombre'][] = utf8_encode($perfil['descripcion']);
				}	
			}
			else{
				$usuario = mysqli_fetch_array($result);
				$respuesta['id'] = $usuario['idUser'];	
				$respuesta['perfil'] = $usuario['idPerfil'];
				$respuesta['user'] = utf8_encode($usuario['nombre']);
			}			
			mysqli_free_result($result);		
		}		
		
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 