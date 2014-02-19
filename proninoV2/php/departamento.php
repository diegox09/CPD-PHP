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
		$idDepartamento = $_GET['id'];
		$nombreDepartamento = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_departamento_by_id($idDepartamento);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_departamento_like_nombre($nombreDepartamento);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_municipio_by_departamento($idDepartamento);
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_departamento($idDepartamento); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idDepartamento != ''){
								$consulta = Pronino::getInstance()->update_departamento($idDepartamento, $nombreDepartamento, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_departamento_by_id($idDepartamento);
							}
							else{
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_departamento_by_nombre($nombreDepartamento);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_departamento_like_nombre($nombreDepartamento);
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_departamento($nombreDepartamento, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_departamento_by_nombre($nombreDepartamento);			 
							break;												
			case 'lista': 	$result = Pronino::getInstance()->get_departamentos(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($departamento = mysqli_fetch_array($result)){
					$respuesta['id'][] = $departamento['idDepartamento'];					
					$respuesta['nombre'][] = utf8_encode($departamento['nombreDepartamento']);
					
					$respuesta['fechaActualizacion'][] = $departamento['fechaActualizacion'];					
					$idUser = $departamento['idUser'];
					
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