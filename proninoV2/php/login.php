<?php	
	session_start();	

   	require_once('classes/Pronino.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$result = Pronino::getInstance()->get_user(utf8_decode($_GET['user']), utf8_decode($_GET['passwd']));
		if(mysqli_num_rows($result) != 0){				
			$usuario = mysqli_fetch_array($result);	
			$_SESSION['id_pn'] = $usuario['idUser'];
			$logonSuccess = true;
		}
	}
	
	$respuesta['login'] = $logonSuccess;	
 	print_r(json_encode($respuesta));
?>