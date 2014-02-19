<?php	
	session_start();
	 
	require_once('classes/AutorizacionPago.php');
	
	$logonSuccess = false;
	$respuesta = array();
	  		
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
	}
		
	if($logonSuccess){		
		$temp = '';
		$cont = false;		
		$id = $_SESSION['id_ap'];
				
		$usuario = mysqli_fetch_array(AutorizacionPago::getInstance()->get_user_by_id($id));	
		$respuesta['idUser'] = $id;		
		$idPerfil = $usuario['idPerfil'];					
		$idMunicipio = $usuario['idMunicipio'];	
		$respuesta['idMunicipio'] = $idMunicipio;	
		$respuesta['nombre'] = utf8_encode($usuario['nombre']);
		$respuesta['email'] = utf8_encode($usuario['emailUser']);
		
		$administrador = false;
		if($idPerfil == AutorizacionPago::getInstance()->get_administrador() || $idPerfil == AutorizacionPago::getInstance()->get_administrador_ap())
			$administrador = true;
		$respuesta['administrador'] = $administrador;	
		
		$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio));
		$respuesta['nombreMunicipio'] = utf8_encode($municipio['nombre']);
		$idDepartamento = $municipio['idDepartamento'];
		$respuesta['idDepartamento'] = $idDepartamento;
		
		$departamento = mysqli_fetch_array(AutorizacionPago::getInstance()->get_departamento_by_id($idDepartamento));
		$respuesta['nombreDepartamento'] = utf8_encode($departamento['nombre']);
		
		$_SESSION['perfil_ap'] = $idPerfil;		
		$result = AutorizacionPago::getInstance()->get_menu_user_by_perfil($idPerfil);	
		if(mysqli_num_rows($result) == 0)	
			$submenu = false;
		else{	
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
		}
		$respuesta ['menu'][] = $submenu;		
	}
	
	$respuesta['login'] = $logonSuccess;		
 	print_r(json_encode($respuesta));
?>