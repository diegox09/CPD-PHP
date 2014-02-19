<?php
	session_start();
	
	require_once('classes/AutorizacionPago.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){		
		$idUser = $_GET['id_usuario'];
		$opc = $_GET['opc'];
		$consulta = true;
		$nuevo = false;
						
		switch($opc){
			case 'buscar':	$nombre = utf8_decode($_GET['nombre']);									
							if($idUser == '')
								$result = AutorizacionPago::getInstance()->get_user_by_nombre($nombre);	
							else
								$result = AutorizacionPago::getInstance()->get_persona_by_id($idUser);
							break;
			case 'cambiar_passwd':	$idUser = $_SESSION['id_ap'];
									$email = utf8_decode($_GET['email']); 
									$passwdActual = utf8_decode($_GET['passwd_actual']); 
									$passwdNuevo = utf8_decode($_GET['passwd_nuevo']);								
									$consulta = AutorizacionPago::getInstance()->verify_passwd($idUser, $passwdActual);
									if($consulta)
										$consulta = AutorizacionPago::getInstance()->change_passwd($idUser, $email, $passwdNuevo);
									break;				
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_verificar_user($idUser);
							if(mysqli_num_rows($result) == 0)		
								$consulta = AutorizacionPago::getInstance()->delete_user($idUser);
							else
								$consulta = false;	
							break;	
			case 'eliminar_prog':	$idPrograma = $_GET['id_programa_registrado'];	
									$consulta = AutorizacionPago::getInstance()->delete_user_programa($idUser, $idPrograma);
									
									$result = AutorizacionPago::getInstance()->get_user_by_id($idUser);
									break;										
			case 'guardar':	$user = utf8_decode($_GET['user']);
							$idPerfil = $_GET['id_perfil'];
							$idMunicipio = $_GET['id_municipio'];
							
							$result_buscar = AutorizacionPago::getInstance()->get_user_by_id($idUser);
							if(mysqli_num_rows($result_buscar) == 0){
								$consulta = AutorizacionPago::getInstance()->insert_user($idUser, $user, $user, $idPerfil, $idMunicipio);														
								$nuevo = true;
							}
							else									
								$consulta = AutorizacionPago::getInstance()->update_user($idUser, $user, $idPerfil, $idMunicipio);
								
							$result = AutorizacionPago::getInstance()->get_user_by_id($idUser);								
							break;	
			case 'guardar_prog':$idPrograma = $_GET['id_programa'];	
								
								$result_user = AutorizacionPago::getInstance()->get_user_by_id($idUser);
								if(mysqli_num_rows($result_user) != 0){							
									$result_buscar = AutorizacionPago::getInstance()->get_verificar_user_by_programa($idUser, $idPrograma);
									if(mysqli_num_rows($result_buscar) == 0)
										$consulta = AutorizacionPago::getInstance()->insert_user_programa($idUser, $idPrograma);
								}
								else
									$consulta = false;
								$result = AutorizacionPago::getInstance()->get_user_by_id($idUser);							
								break;								
			case 'lista': 	$result = AutorizacionPago::getInstance()->get_user(); 
							break;	
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							if($nombre == '')
								$result = AutorizacionPago::getInstance()->get_user();
							else
								$result = AutorizacionPago::getInstance()->get_buscar_user_nombre($nombre);
							break;					
			default:		$result = false;				
		}		
		
		if($opc != 'eliminar' && $opc != 'cambiar_p'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				while ($usuario = mysqli_fetch_array($result)){	
					$idUser = $usuario['idPersona'];
									
					$respuesta['id'][] = $idUser;						
					$result_user = AutorizacionPago::getInstance()->get_user_by_id($idUser);
					
					$respuesta['nombre'][] = utf8_encode($usuario['nombre']);
					$identificacion = number_format($usuario['identificacion'],0,',','.');	
					$dv = $usuario['dv'];
					if($dv == 0)
						$dv = '';
					else
						$dv = '-'.$dv;							
					$respuesta['identificacion'][] = $identificacion.$dv; 
					
					$programa = false;
					$programas = array();
					
					if(mysqli_num_rows($result_user) == 0){	
						$respuesta['user'][] = '';
						$respuesta['passwd'][] = '';
						$idPerfil = '0';
						$idMunicipio = '0';												
					}
					else{						
						$info_user = mysqli_fetch_array($result_user);
						
						$respuesta['user'][] = utf8_encode($info_user['user']);
						$respuesta['passwd'][] = utf8_encode($info_user['passwd']);
						$idPerfil = $info_user['idPerfil'];	
						$idMunicipio = $info_user['idMunicipio'];								
						
						$result_programa = AutorizacionPago::getInstance()->get_programa_by_user($idUser);											
						if(mysqli_num_rows($result_programa) != 0){
							$programa = true;						
							while ($info_programa = mysqli_fetch_array($result_programa)){
								$programas['id'][] =  $info_programa['idPrograma'];
								$programas['nombre'][] =  utf8_encode($info_programa['nombre']);
							}						
						}	
					}	
					
					$bloquear = false;					
					if($idPerfil == AutorizacionPago::getInstance()->get_administrador() && $idUser != $_SESSION['id_ap'])
						$bloquear = true;
					
					$respuesta['idPerfil'][] = $idPerfil;
					$respuesta['idMunicipio'][] = $idMunicipio;	
					$respuesta['bloquear'][] = $bloquear;	
					$respuesta['programa'][] = $programa;	
					$respuesta['programas'][] = $programas;
				}			
				mysqli_free_result($result);
			}
		}
		else
			$respuesta['id'] = $idUser;
							
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		$respuesta['nuevo'] = $nuevo;			
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 