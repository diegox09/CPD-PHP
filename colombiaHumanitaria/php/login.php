<?php	
	session_start();	

   	require_once('../soft/php/classes/Humanitaria.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$result = Humanitaria::getInstance()->get_user($_GET['user'], $_GET['passwd']);
		if(mysqli_num_rows($result) != 0){				
			$usuario = mysqli_fetch_array($result);				
			$_SESSION['user_hu'] = $usuario['user'];
			$_SESSION['id_hu'] = $usuario['id_user'];
			$_SESSION['perfil_hu'] = $usuario['tipo_user'];
			
			$logonSuccess = true;
		}
		mysqli_free_result($result);
	}
	
	$respuesta['login'] = $logonSuccess;	
 	print_r(json_encode($respuesta));
?>