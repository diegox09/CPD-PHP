<?php
	session_start();
	
	require_once('classes/Humanitaria.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$idDamnificado = $_GET['id_damnificado'];
		$opc = $_GET['opc'];
		$consulta = true;
		$mensaje = '';
		$fase = $_GET['fase'];		
		$primerNombre = utf8_decode($_GET['primer_nombre']);
		$segundoNombre = utf8_decode($_GET['segundo_nombre']);
		$primerApellido = utf8_decode($_GET['primer_apellido']);
		$segundoApellido = utf8_decode($_GET['segundo_apellido']);
		$td = $_GET['td'];	
		$documentoDamnificado = $_GET['documento'];
		$genero = $_GET['genero'];								
		$direccion = utf8_decode($_GET['direccion']);
		$barrio = utf8_decode($_GET['barrio']);
		$telefono = $_GET['telefono'];
		$observaciones = utf8_decode($_GET['observaciones']);
		$idUser = $_SESSION['id_hu'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){	
			case 'arriendo':$resultBuscar = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);							
							if(mysqli_num_rows($resultBuscar) == 0){
								$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);
								if(mysqli_num_rows($resultBuscar) == 0){
									$resultBuscar = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);							
									if(mysqli_num_rows($resultBuscar) == 0){
										$consulta = Humanitaria::getInstance()->insert_arriendo($idDamnificado, $fase, $fechaActual, $idUser);							
										if($consulta)
											$respuesta['mensaje'] = 'Se adiciono el arriendo al damnificado';
										else
											$respuesta['mensaje'] = 'Error al adicionar el arriendo';
									}
									else
										$respuesta['mensaje'] = 'El damnificado tiene reparacion de vivienda en esta fase';
								}
								else
									$respuesta['mensaje'] = 'El damnificado aparece como arrendador en esta fase';
							}
							else
								$respuesta['mensaje'] = 'El damnificado ya tiene arriendo en esta fase';	
							
							mysqli_free_result($resultBuscar);	
							$result = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);		
							break;
			case 'cargar':	$result = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);								
							break;
			case 'entregas':$resultBuscar = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);							
							if(mysqli_num_rows($resultBuscar) == 0){
								$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);
								if(mysqli_num_rows($resultBuscar) == 0){
									$consulta = Humanitaria::getInstance()->insert_entregas($idDamnificado, $fase, $fechaActual, $idUser);							
									if($consulta)
										$respuesta['mensaje'] = 'Se adiciono las entregas al damnificado';
									else
										$respuesta['mensaje'] = 'Error al adicionar las entregas al damnificado';
								}
								else
									$respuesta['mensaje'] = 'El damnificado aparece como arrendador en esta fase';
							}
							else
								$respuesta['mensaje'] = 'El damnificado ya tiene entregas en esta fase';	
							
							mysqli_free_result($resultBuscar);	
							$result = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);		
							break;				
			case 'guardar':	$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);			
							if(mysqli_num_rows($resultBuscar) == 0){
								$consulta = Humanitaria::getInstance()->update_damnificado($idDamnificado, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $genero, $td, $documentoDamnificado, $direccion, $barrio, $telefono, $observaciones, $fechaActual, $idUser);	
								$respuesta['mensaje'] = 'Error al modificar el damnificado';
							}
							else{
								$consulta = false;	
								$respuesta['mensaje'] = 'El numero de documento pertenece a un arrendador de esta fase';
							}
							
							mysqli_free_result($resultBuscar);
							$result = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);								
							break;							
			case 'nuevo':	$resultBuscar = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);							
							if(mysqli_num_rows($resultBuscar) == 0){
								$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);
								if(mysqli_num_rows($resultBuscar) == 0){
									$consulta = Humanitaria::getInstance()->insert_damnificado($documentoDamnificado, $fechaActual, $idUser);							
									if($consulta)
										$respuesta['mensaje'] = 'Damnificado creado correctamente';
									else
										$respuesta['mensaje'] = 'Error al crear el damnificado';
								}
								else
									$respuesta['mensaje'] = 'El damnificado aparece como arrendador en esta fase';
							}
							else
								$respuesta['mensaje'] = 'El damnificado ya existe';	
							
							mysqli_free_result($resultBuscar);	
							$result = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);		
							break;	
			case 'reparacion':$resultBuscar = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);							
							if(mysqli_num_rows($resultBuscar) == 0){
								$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);
								if(mysqli_num_rows($resultBuscar) == 0){
									$resultBuscar = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);							
									if(mysqli_num_rows($resultBuscar) == 0){
										$consulta = Humanitaria::getInstance()->insert_reparacion($idDamnificado, $fase, $fechaActual, $idUser);							
										if($consulta)
											$respuesta['mensaje'] = 'Se adiciono la reparacion de vivienda al damnificado';
										else
											$respuesta['mensaje'] = 'Error al adicionar la reparacion de vivienda al damnificado';
									}
									else
										$respuesta['mensaje'] = 'El damnificado tiene arriendo en esta fase';
								}
								else
									$respuesta['mensaje'] = 'El damnificado aparece como arrendador en esta fase';
							}
							else
								$respuesta['mensaje'] = 'El damnificado ya tiene reparacion de vivienda en esta fase';	
							
							mysqli_free_result($resultBuscar);	
							$result = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);		
							break;										
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$damnificado = mysqli_fetch_array($result);					
				$respuesta['idDamnificado'] = $damnificado['id_damnificado'];
				$respuesta['primerNombre'] = utf8_encode($damnificado['primer_nombre']);
				$respuesta['segundoNombre'] = utf8_encode($damnificado['segundo_nombre']);
				$respuesta['primerApellido'] = utf8_encode($damnificado['primer_apellido']);
				$respuesta['segundoApellido'] = utf8_encode($damnificado['segundo_apellido']);
				$respuesta['td'] = $damnificado['td'];
				$respuesta['documento'] = $damnificado['documento_damnificado'];
				$respuesta['genero'] = $damnificado['genero'];
				$respuesta['telefono'] = $damnificado['telefono'];
				$respuesta['direccion'] = utf8_encode($damnificado['direccion']);
				$respuesta['barrio'] = utf8_encode($damnificado['barrio']);
				$respuesta['observaciones'] = utf8_encode($damnificado['observaciones']);				
				$respuesta['fecha'] = $damnificado['fecha'];					
				$idUser = $damnificado['id_usuario'];
				
				$usuario = mysqli_fetch_array(Humanitaria::getInstance()->get_user_by_id($idUser));					
				$respuesta['user'] = $usuario['user'];											
			}
			mysqli_free_result($result);
		}
										
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		$respuesta['perfil'] = $_SESSION['perfil_hu'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 