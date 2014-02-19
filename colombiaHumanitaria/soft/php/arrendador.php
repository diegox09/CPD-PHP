<?php
	session_start();
	
	require_once('classes/Humanitaria.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$idArrendador = $_GET['id_arrendador'];
		$opc = $_GET['opc'];
		$consulta = true;
		$fase = $_GET['fase'];
		$mensaje = '';
		$documentoArrendador = $_GET['documento'];
		$nombre = utf8_decode($_GET['nombre']);
		$direccion = utf8_decode($_GET['direccion']);							
		$telefono = $_GET['telefono'];		
		$idUser = $_SESSION['id_hu'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){	
			case 'buscar':	$result = Humanitaria::getInstance()->get_arrendador_by_documento($documentoArrendador);
							break;
			case 'cargar':	$result = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);								
							break;
			case 'guardar':	$resultEntregas = Humanitaria::getInstance()->get_entregas_damnificado_by_documento_arrendador($documentoArrendador, $fase);
							$resultArriendo = Humanitaria::getInstance()->get_arriendo_damnificado_by_documento_arrendador($documentoArrendador, $fase);
							if(mysqli_num_rows($resultEntregas) == 0 && mysqli_num_rows($resultArriendo) == 0)
								$consulta = Humanitaria::getInstance()->update_arrendador($idArrendador, $nombre, $documentoArrendador, $direccion, $telefono, $fechaActual, $idUser);
							else
								$consulta = false;
							
							mysqli_free_result($resultEntregas);
							mysqli_free_result($resultArriendo);																
							$result = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);								
							break;							
			case 'nuevo':	$resultEntregas = Humanitaria::getInstance()->get_entregas_damnificado_by_documento_arrendador($documentoArrendador, $fase);
							$resultArriendo = Humanitaria::getInstance()->get_arriendo_damnificado_by_documento_arrendador($documentoArrendador, $fase);
							if(mysqli_num_rows($resultEntregas) == 0 && mysqli_num_rows($resultArriendo) == 0){
								$consulta = Humanitaria::getInstance()->insert_arrendador($documentoArrendador, $fechaActual, $idUser);					
								$result = Humanitaria::getInstance()->get_arrendador_by_documento($documentoArrendador);
								$respuesta['mensaje'] = 'Error al crear el arrendador, el numero de documento ya existe';
							}
							else{
								$result = false;
								$respuesta['mensaje'] = 'El arrendador aparece como damnificado en la fase '.$fase;	
							}							
							mysqli_free_result($resultEntregas);
							mysqli_free_result($resultArriendo);
							break;							
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$arrendador = mysqli_fetch_array($result);					
				$respuesta['idArrendador'] = $arrendador['id_arrendador'];
				$respuesta['documento'] = $arrendador['documento_arrendador'];
				$respuesta['nombre'] = utf8_encode($arrendador['nombre_arrendador']);
				$respuesta['telefono'] = $arrendador['telefono_arrendador'];
				$respuesta['direccion'] = utf8_encode($arrendador['direccion_arrendador']);
				
				$respuesta['fecha'] = $arrendador['fecha'];				
				$idUser = $arrendador['id_usuario'];				
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