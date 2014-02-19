<?php		
	$logonSuccess = false;
	$url = 'login.html';
	  	
	session_start();
	if (array_key_exists('id_fe', $_SESSION)) {
		$logonSuccess = true;
	}
	
	if($logonSuccess)
		$url = 'menu.html';
			
	$respuesta['url'] = $url;
 	print_r(json_encode($respuesta));
?>