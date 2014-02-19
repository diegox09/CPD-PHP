<?php	
	session_start();
	
	$logonSuccess = false;
	$url = 'login.html';
	  		
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
	}
	
	if($logonSuccess)
		$url = 'menu.html';
			
	$respuesta['url'] = $url;
 	print_r(json_encode($respuesta));
?>