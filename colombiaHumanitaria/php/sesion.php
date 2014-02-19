<?php	
	session_start();
	
	$logonSuccess = false;
	$url = 'login.html';
	  		
	if (array_key_exists('user_hu', $_SESSION)) {
		$logonSuccess = true;
	}
	
	if($logonSuccess)
		$url = 'soft';
			
	$respuesta['url'] = $url;
 	print_r(json_encode($respuesta));
?>