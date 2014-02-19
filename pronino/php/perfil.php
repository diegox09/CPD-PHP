<?php
	session_start();
	
	require_once('classes/Pronino.php');
		
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$result = Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']);
		if(mysqli_num_rows($result) != 0){
			$usuario = mysqli_fetch_array($result);
			$respuesta['id'] = $usuario['idUser'];	
			$respuesta['perfil'] = $usuario['tipoUser'];
			$respuesta['user'] = utf8_encode($usuario['nombreUser']);
		}
		else{
			session_destroy();
			$logonSuccess = false;
		}
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 