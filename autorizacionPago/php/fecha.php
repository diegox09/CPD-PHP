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
		date_default_timezone_set('America/Bogota'); 
		$fecha = date('d/m/Y');				
		$respuesta['fecha'] = $fecha;		
	}
	
	$respuesta['login'] = $logonSuccess;
 	print_r(json_encode($respuesta));
?>