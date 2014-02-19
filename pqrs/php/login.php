<?php	
	session_start();	

   	require_once('classes/Pqrs.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$result = Pqrs::getInstance()->get_user($_GET['user'], $_GET['passwd']);
		if(mysqli_num_rows($result) != 0){				
			$usuario = mysqli_fetch_array($result);				
			$_SESSION['user_pqr'] = $usuario['user'];
			$_SESSION['id_pqr'] = $usuario['idUser'];
			$_SESSION['perfil_pqr'] = $usuario['tipoUser'];
			
			$logonSuccess = true;
		}
	}
	
	$respuesta['login'] = $logonSuccess;	
 	print_r(json_encode($respuesta));
?>