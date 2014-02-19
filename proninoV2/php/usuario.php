<?php
	session_start();
	
	require_once('classes/Pronino.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = true;			
		$opc = $_GET['opc'];		
		$idUsuario = $_GET['id'];
		$usuario = utf8_decode(trim($_GET['usuario']));	
		$tipoUser = $_GET['tipo_usuario'];
		$nombreUsuario = utf8_decode($_GET['nombre']);		
		
		$passwd = utf8_decode($_GET['passwd']);
		$passwdNew = utf8_decode($_GET['passwd_new']);
		$email = utf8_decode($_GET['email']);
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_user_by_id($idUsuario);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_user_like_nombre($usuario);
							}
							break;
			case 'eliminar':$consulta = false;
							$result = Pronino::getInstance()->get_actividad_by_user($idUsuario);
							$result2 = Pronino::getInstance()->get_ars_by_user($idUsuario);
							$result3 = Pronino::getInstance()->get_barrio_by_user($idUsuario);
							$result4 = Pronino::getInstance()->get_colegio_by_user($idUsuario);
							$result5 = Pronino::getInstance()->get_departamento_by_user($idUsuario);
							$result6 = Pronino::getInstance()->get_escuela_by_user($idUsuario);
							$result7 = Pronino::getInstance()->get_municipio_by_user($idUsuario);
							$result8 = Pronino::getInstance()->get_sede_by_user($idUsuario);
							$result9 = Pronino::getInstance()->get_sitio_by_user($idUsuario);
							if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0 && mysqli_num_rows($result5) == 0 && mysqli_num_rows($result6) == 0 && mysqli_num_rows($result7) == 0 && mysqli_num_rows($result8) == 0 && mysqli_num_rows($result9) == 0){
								$result = Pronino::getInstance()->get_beneficiario_by_user($idUsuario);	
								$result2 = Pronino::getInstance()->get_beneficiario_pronino_by_user($idUsuario);
								$result3 = Pronino::getInstance()->get_diagnostico_by_user($idUsuario);
								$result4 = Pronino::getInstance()->get_actividades_mes_by_user($idUsuario);
								$result5 = Pronino::getInstance()->get_notas_by_user($idUsuario);
								$result6 = Pronino::getInstance()->get_psicosocial_by_user($idUsuario);
								$result7 = Pronino::getInstance()->get_seguimiento_by_user($idUsuario);
								$result8 = Pronino::getInstance()->get_year_by_user($idUsuario);
								if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0 && mysqli_num_rows($result5) == 0 && mysqli_num_rows($result6) == 0 && mysqli_num_rows($result7) == 0 && mysqli_num_rows($result8) == 0)
									$consulta = Pronino::getInstance()->delete_user($idUsuario); 
							}
							break;
			case 'guardar':	if($idUsuario != ''){
								$consulta = Pronino::getInstance()->update_user($idUsuario, $usuario, $tipoUser, $nombreUsuario, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_user_by_id($idUsuario);
							}
							else{	
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_user_by_nombre($usuario);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_user_like_nombre($usuario);	
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_user($usuario, $tipoUser, $nombreUsuario, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_user_by_nombre($usuario);			 
							break;
			case 'passwd': 	$result = Pronino::getInstance()->get_passwd($idUsuario, $passwd); 
							if(mysqli_num_rows($result) != 0)
								$consulta = Pronino::getInstance()->update_passwd($idUsuario, $passwdNew, $email, $idUser, $fechaActual);	
							else
								$consulta = false;	 
							break;				
			case 'lista': 	$tipoUser = $_GET['id_lista'];
							if($tipoUser != '')
								$result = Pronino::getInstance()->get_user_by_tipo($tipoUser);
							else	
								$result = Pronino::getInstance()->get_all_user(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar' && $opc != 'passwd'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($user = mysqli_fetch_array($result)){
					$respuesta['id'][] = $user['idUser'];									
					$respuesta['nombre'][] = utf8_encode($user['nombreUser']);					
					$respuesta['tipoUser'][] = $user['tipoUser'];
					$respuesta['nombreUser'][] = utf8_encode($user['user']);
					$respuesta['email'][] = $user['email'];	
					
					$respuesta['fechaActualizacion'][] = $user['fechaActualizacion'];					
					$idUser = $user['idUser'];
					
					$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
					$respuesta['nombreUser'][] = htmlentities($usuario['user']);
				}	
				mysqli_free_result($result);		
			}		
		}
				
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']));
		$respuesta['perfil'] = $usuario['tipoUser'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 