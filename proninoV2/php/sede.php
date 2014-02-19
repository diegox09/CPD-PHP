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
		$idSede = $_GET['id'];	
		$idColegio = $_GET['id_colegio'];
		$nombreSede = utf8_decode(trim($_GET['nombre']));
		$coordinador = utf8_decode($_GET['coordinador']);
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');					
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_sede_by_id($idSede);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_sede_like_nombre($idColegio, $nombreSede);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_beneficiario_by_sede($idSede);	
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_sede($idSede); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idSede != ''){
								$consulta = Pronino::getInstance()->update_sede($idSede, $idColegio, $nombreSede, $coordinador, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_sede_by_id($idSede);
							}
							else{	
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_sede_by_nombre($idColegio, $nombreSede);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_sede_like_nombre($idColegio, $nombreSede);	
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_sede($idColegio, $nombreSede, $coordinador, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_sede_by_nombre($idColegio, $nombreSede);			 
							break;
			case 'lista': 	$idColegio = $_GET['id_lista'];
							$result = Pronino::getInstance()->get_sede_by_colegio($idColegio); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($sede = mysqli_fetch_array($result)){
					$respuesta['id'][] = $sede['idSedeColegio'];					
					$respuesta['nombre'][] = utf8_encode($sede['nombreSede']);
					$respuesta['coordinador'][] = utf8_encode($sede['nombreCoordinador']);
					$idColegio = $sede['idColegio'];
					$respuesta['idColegio'][] = $idColegio;
					
					$colegio = mysqli_fetch_array(Pronino::getInstance()->get_colegio_by_id($idColegio));	
					$respuesta['idMunicipio'][] = $colegio['idMunicipio'];
					
					$respuesta['fechaActualizacion'][] = $sede['fechaActualizacion'];					
					$idUser = $sede['idUser'];
					
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