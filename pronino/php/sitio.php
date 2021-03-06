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
		$idSitio = $_GET['id'];
		$nombreSitio = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_sitio_by_id($idSitio);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_sitio_like_nombre($nombreSitio);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_beneficiario_by_sitio($idSitio);	
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_sitio($idSitio); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idSitio != ''){
								$consulta = Pronino::getInstance()->update_sitio($idSitio, $nombreSitio, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_sitio_by_id($idSitio);
							}
							else{
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_sitio_by_nombre($nombreSitio);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_sitio_like_nombre($nombreSitio);
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_sitio($nombreSitio, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_sitio_by_nombre($nombreSitio);			 
							break;												
			case 'lista': 	$result = Pronino::getInstance()->get_sitios(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($sitio = mysqli_fetch_array($result)){
					$respuesta['id'][] = $sitio['idSitio'];					
					$respuesta['nombre'][] = utf8_encode($sitio['nombreSitio']);
					
					$respuesta['fechaActualizacion'][] = $sitio['fechaActualizacion'];					
					$idUser = $sitio['idUser'];
					
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