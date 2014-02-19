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
		$idColegio = $_GET['id'];
		$idMunicipio = $_GET['id_municipio'];
		$nombreColegio = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_colegio_by_id($idColegio);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_colegio_like_nombre($idMunicipio, $nombreColegio);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_sede_by_colegio($idColegio);
							$result2 = Pronino::getInstance()->get_beneficiario_by_colegio($idColegio);	
							if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0)
								$consulta = Pronino::getInstance()->delete_colegio($idColegio); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idColegio != ''){
								$consulta = Pronino::getInstance()->update_colegio($idColegio, $idMunicipio, $nombreColegio, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_colegio_by_id($idColegio);
							}
							else{	
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_colegio_by_nombre($idMunicipio, $nombreColegio);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_colegio_like_nombre($idMunicipio, $nombreColegio);	
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_colegio($idMunicipio, $nombreColegio, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_colegio_by_nombre($idMunicipio, $nombreColegio);			 
							break;
			case 'lista': 	$idMunicipio = $_GET['id_lista'];
							$result = Pronino::getInstance()->get_colegio_by_municipio($idMunicipio); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($colegio = mysqli_fetch_array($result)){
					$respuesta['id'][] = $colegio['idColegio'];					
					$respuesta['nombre'][] = utf8_encode($colegio['nombreColegio']);
					$respuesta['idMunicipio'][] = $colegio['idMunicipio'];
					
					$respuesta['fechaActualizacion'][] = $colegio['fechaActualizacion'];					
					$idUser = $colegio['idUser'];
					
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