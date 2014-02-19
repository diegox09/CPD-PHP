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
		$idMunicipio = $_GET['id'];
		$idDepartamento = $_GET['id_departamento'];
		$nombreMunicipio = utf8_decode(trim($_GET['nombre']));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
			
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_municipio_by_id($idMunicipio);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_municipio_like_nombre($idDepartamento, $nombreMunicipio);
							}
							break;
			case 'eliminar':$result = Pronino::getInstance()->get_barrio_by_municipio($idMunicipio);
							$result2 = Pronino::getInstance()->get_colegio_by_municipio($idMunicipio);	
							$result3 = Pronino::getInstance()->get_beneficiario_by_municipio($idMunicipio);	
							$result4 = Pronino::getInstance()->get_beneficiario_year_by_municipio($idMunicipio);	
							if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0)
								$consulta = Pronino::getInstance()->delete_municipio($idMunicipio); 
							else
								$consulta = false;	
							break;
			case 'guardar':	if($idMunicipio != ''){
								$consulta = Pronino::getInstance()->update_municipio($idMunicipio, $idDepartamento, $nombreMunicipio, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_municipio_by_id($idMunicipio);
							}
							else{
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_municipio_by_nombre($idDepartamento, $nombreMunicipio);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_municipio_like_nombre($idDepartamento, $nombreMunicipio);
							}
							break;
			case 'nuevo': 	$consulta = Pronino::getInstance()->insert_municipio($idDepartamento, $nombreMunicipio, $idUser, $fechaActual); 
							$result = Pronino::getInstance()->get_municipio_by_nombre($idDepartamento, $nombreMunicipio);			 
							break;												
			case 'lista': 	$result = Pronino::getInstance()->get_municipios(); 
							break;				
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;	
						
			else{
				while ($municipio = mysqli_fetch_array($result)){
					$respuesta['id'][] = $municipio['idMunicipio'];										
					$respuesta['nombre'][] = utf8_encode($municipio['nombreMunicipio']);
					$respuesta['idDepartamento'][] = $municipio['idDepartamento'];
					
					$respuesta['fechaActualizacion'][] = $municipio['fechaActualizacion'];					
					$idUser = $municipio['idUser'];
					
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