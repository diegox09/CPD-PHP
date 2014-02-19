<?php	 
	require_once('classes/User.php');
	
	$logonSuccess = false;
	$respuesta = array();
	  	
	session_start();
	if (array_key_exists('id_f', $_SESSION)) {
		$logonSuccess = true;
	}
		
	if($logonSuccess){		
		$temp = '';
		$cont = false;
		$id = $_SESSION['id_f'];
				
		$user = mysqli_fetch_array(User::getInstance()->get_user_by_id($id));	
		$respuesta['idUser'] = $id;
		$respuesta['user'] = utf8_encode($user['nombre']);
		$respuesta['perfil'] = utf8_encode($user['descripcion']);				
		$_SESSION['perfil_f'] = $user['idPerfil'];
		
		$result = User::getInstance()->get_menu_user_by_perfil($user['idPerfil']);	
		while ($row = mysqli_fetch_array($result)){					
			$descSubmenu = utf8_encode($row[0]);		
			if($descSubmenu != $temp){
				if($cont)
					$respuesta ['menu'][] = $submenu;
				else	
					$cont = true;		
					
				$submenu = array();				
				$temp = $descSubmenu;
				$submenu ['submenu'][] = $temp;
				$descItem = utf8_encode($row[1]);
				$inicItem = utf8_encode($row[2]);
				$submenu ['items'][] = $descItem;
				$submenu ['iniciales'][] = $inicItem;
			}
			else{
				$descItem = utf8_encode($row[1]);
				$inicItem = utf8_encode($row[2]);
				$submenu ['items'][] = $descItem;	
				$submenu ['iniciales'][] = $inicItem;			
			}				
		}
		mysqli_free_result($result);
		$respuesta ['menu'][] = $submenu;		
	}
	
	$respuesta['login'] = $logonSuccess;		
 	print_r(json_encode($respuesta));
?>