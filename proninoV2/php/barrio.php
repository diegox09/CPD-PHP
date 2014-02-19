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
		$idBarrio = $_GET['id'];	
		$idMunicipio = $_GET['id_municipio'];
		$nombreBarrio = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');					
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_barrio_by_id($idBarrio);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_barrio_like_nombre($idMunicipio, $nombreBarrio);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_beneficiario_by_barrio($idBarrio);	
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_barrio($idBarrio); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idBarrio != ''){
								$consulta = Pronino::getInstance()->update_barrio($idBarrio, $idMunicipio, $nombreBarrio, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_barrio_by_id($idBarrio);
							}
							else{	
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_barrio_by_nombre($idMunicipio, $nombreBarrio);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_barrio_like_nombre($idMunicipio, $nombreBarrio);	
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_barrio($idMunicipio, $nombreBarrio, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_barrio_by_nombre($idMunicipio, $nombreBarrio);
							break;
			case 'lista': 	$idMunicipio = $_GET['id_lista'];
							$result = Pronino::getInstance()->get_barrio_by_municipio($idMunicipio); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($barrio = mysqli_fetch_array($result)){
					$respuesta['id'][] = $barrio['idBarrio'];					
					$respuesta['nombre'][] = utf8_encode($barrio['nombreBarrio']);
					$respuesta['idMunicipio'][] = $barrio['idMunicipio'];
					
					$respuesta['fechaActualizacion'][] = $barrio['fechaActualizacion'];					
					$idUser = $barrio['idUser'];
					
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