<?php
	require_once('classes/User.php');	
	require_once('classes/Factura.php');
	require_once('classes/Programa.php');	
	
	$logonSuccess = false;
	$respuesta = array();	
	
	session_start();
	if (array_key_exists('id_fe', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_fe'] == User::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){		
		$idUser = $_GET['id_usuario'];
		$opc = $_GET['opc'];
		$consulta = true;				
		switch($opc){
			case 'all':		$result = User::getInstance()->get_user();
							break;
			case 'delete':	$result = Factura::getInstance()->get_factura_by_user($idUser);
							if(mysqli_num_rows($result) == 0){								
								$result = Programa::getInstance()->get_programa_by_user($idUser);
								if(mysqli_num_rows($result) == 0){									
									$consulta = User::getInstance()->delete_user($idUser);
									if($consulta)
										$respuesta['idUser'] = $idUser;								
								}
								else{
									$consulta = false;
									$respuesta['mensaje'] = ', Esta Relacionado con algun Programa';
								}
							}
							else{
								$consulta = false;							
								$respuesta['mensaje'] = ', Esta Relacionado con alguna Factura';
							}
							break;							
			case 'insert':	$user = utf8_decode($_GET['usuario']);
							$nombre = utf8_decode($_GET['nombre_usuario']);
							$email = utf8_decode($_GET['email']);
							$idPerfil = $_GET['tipo_usuario'];
							$consulta = User::getInstance()->insert_user($user, $nombre, $user, $email, $idPerfil);
							$result = User::getInstance()->get_user_by_name($user);
							break;			
			case 'pas': 	$idUser = $_SESSION['id_fe'];
							$passwdAct = utf8_decode($_GET['passwd_act']); 
							$passwdNew = utf8_decode($_GET['passwd_new']);
							$consulta = User::getInstance()->verify_passwd($idUser, $passwdAct);
							if($consulta)
								$consulta = User::getInstance()->change_passwd($idUser, $passwdNew);						
							break;		
			case 'update':	$user = utf8_decode($_GET['usuario']);
							$nombre = utf8_decode($_GET['nombre_usuario']);
							$email = utf8_decode($_GET['email']);
							$idPerfil = $_GET['tipo_usuario'];
							$consulta = User::getInstance()->update_user($idUser, $user, $nombre, $email, $idPerfil);							
							if($_GET['reset_passwd'] != '')
								$consulta = User::getInstance()->change_passwd($idUser, $user);					
								
							$result = User::getInstance()->get_user_by_id($idUser);		
							break;																		
			default:		$result = User::getInstance()->get_user_by_id($idUser);
							break;				
		}		
		
		if($opc != 'pas' && $opc != 'delete'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				while ($row = mysqli_fetch_array($result)){
					$respuesta['idUser'][] = $row['idUser'];
					$respuesta['nombre'][] = utf8_encode($row['nombre']);
					$respuesta['email'][] = utf8_encode($row['email']);
					$respuesta['user'][] = utf8_encode($row['user']);
					$respuesta['idPerfil'][] = $row['idPerfil'];
					$respuesta['perfil'][] = utf8_encode($row['descripcion']);
				}			
				mysqli_free_result($result);
			}
		}		
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 