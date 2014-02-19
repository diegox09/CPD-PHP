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
		$idEscuela = $_GET['id'];
		$nombreEscuela = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_escuela_by_id($idEscuela);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_escuela_like_nombre($nombreEscuela);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_beneficiario_by_escuela($idEscuela);	
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_escuela($idEscuela); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idEscuela != ''){
								$consulta = Pronino::getInstance()->update_escuela($idEscuela, $nombreEscuela, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_escuela_by_id($idEscuela);
							}
							else{
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_escuela_by_nombre($nombreEscuela);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_escuela_like_nombre($nombreEscuela);
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_escuela($nombreEscuela, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_escuela_by_nombre($nombreEscuela);			 
							break;												
			case 'lista': 	$result = Pronino::getInstance()->get_escuelas(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($escuela = mysqli_fetch_array($result)){
					$respuesta['id'][] = $escuela['idEscuela'];					
					$respuesta['nombre'][] = utf8_encode($escuela['nombreEscuela']);
					
					$respuesta['fechaActualizacion'][] = $escuela['fechaActualizacion'];					
					$idUser = $escuela['idUser'];
					
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