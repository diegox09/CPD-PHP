<?php
	session_start();
		
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$respuesta['user'] = $_SESSION['user_hu'];
		$respuesta['perfil'] = $_SESSION['perfil_hu'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 