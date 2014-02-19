<?php
	session_start();	
	$_SESSION = array();	
	session_destroy();
		
	$respuesta['url'] = 'login.html';
 	print_r(json_encode($respuesta));
?>