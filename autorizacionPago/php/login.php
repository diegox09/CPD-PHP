<?php	
	session_start();	

   	require_once('classes/AutorizacionPago.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$logonSuccess = (AutorizacionPago::getInstance()->verify_credentials($_GET['user'], $_GET['passwd']));
		if ($logonSuccess == true)				
			$_SESSION['id_ap'] = AutorizacionPago::getInstance()->get_id_user($_GET['user']);
	}
	
	$respuesta['login'] = $logonSuccess;	
 	print_r(json_encode($respuesta));
?>