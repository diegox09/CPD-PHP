<?php	
   	require_once('classes/User.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$logonSuccess = (User::getInstance()->verify_credentials($_GET['user'], $_GET['passwd']));
		if ($logonSuccess == true) {
			session_start();			
			$_SESSION['id_fe'] = User::getInstance()->get_id_user($_GET['user']);
		}
	}	
	
	$respuesta['login'] = $logonSuccess;
 	print_r(json_encode($respuesta));
?>