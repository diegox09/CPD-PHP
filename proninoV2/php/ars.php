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
		$idArs = $_GET['id'];
		$nombreArs = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_ars_by_id($idArs);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_ars_like_nombre($nombreArs);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_beneficiario_by_ars($idArs);	
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_ars($idArs); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idArs != ''){
								$consulta = Pronino::getInstance()->update_ars($idArs, $nombreArs, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_ars_by_id($idArs);
							}
							else{	
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_ars_by_nombre($nombreArs);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_ars_like_nombre($nombreArs);	
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_ars($nombreArs, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_ars_by_nombre($nombreArs);			 
							break;												
			case 'lista': 	$result = Pronino::getInstance()->get_arss(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($ars = mysqli_fetch_array($result)){
					$respuesta['id'][] = $ars['idArs'];					
					$respuesta['nombre'][] = utf8_encode($ars['nombreArs']);
					
					$respuesta['fechaActualizacion'][] = $ars['fechaActualizacion'];					
					$idUser = $ars['idUser'];
					
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