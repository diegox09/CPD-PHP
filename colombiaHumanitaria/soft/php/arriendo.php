<?php
	session_start();
	
	require_once('classes/Humanitaria.php');
	require_once('funciones/funciones.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$idDamnificado = $_GET['id_damnificado'];
		$idArrendador = $_GET['id_arrendador'];
		$opc = $_GET['opc'];
		$consulta = true;	
		$fase = $_GET['fase'];		
		$comprobante = $_GET['comprobante'];
		$cheque = $_GET['cheque'];		
		$fechaArriendo = explota($_GET['fecha_arriendo']);		
		$observaciones = utf8_decode($_GET['observaciones']);
		$estado = $_GET['bloquear'];
		$idUser = $_SESSION['id_hu'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){		
			case 'cargar':	$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);								
							break;	
			case 'eliminar':$consulta = Humanitaria::getInstance()->delete_arriendo($idDamnificado, $fase);
							break;									
			case 'guardar':	if($idArrendador != '0'){
								$arrendador = mysqli_fetch_array(Humanitaria::getInstance()->get_arrendador_by_id($idArrendador));
								$documentoArrendador = $arrendador['documento_arrendador'];
								$resultEntregas = Humanitaria::getInstance()->get_entregas_damnificado_by_documento_arrendador($documentoArrendador, $fase);
								$resultArriendo = Humanitaria::getInstance()->get_arriendo_damnificado_by_documento_arrendador($documentoArrendador, $fase);
								if(mysqli_num_rows($resultEntregas) == 0 && mysqli_num_rows($resultArriendo) == 0)
									$consulta = Humanitaria::getInstance()->update_arriendo2($idDamnificado, $fase, $idArrendador, $comprobante, $cheque, $fechaArriendo, $estado, $observaciones, $fechaActual, $idUser);
								else
									$consulta = false;
									
								mysqli_free_result($resultEntregas);
								mysqli_free_result($resultArriendo);		
							}
							else
								$consulta = Humanitaria::getInstance()->update_arriendo2($idDamnificado, $fase, $idArrendador, $comprobante, $cheque, $fechaArriendo, $estado, $observaciones, $fechaActual, $idUser);							
								
							$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);								
							break;				
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$arriendo = mysqli_fetch_array($result);					
				$respuesta['idDamnificado'] = $arriendo['id_damnificado'];				
				$respuesta['fechaArriendo'] = implota($arriendo['fecha_arriendo']);
				$respuesta['estado'] = $arriendo['id_estado'];
				$respuesta['fecha'] = $arriendo['fecha'];
				$respuesta['observaciones'] = utf8_encode($arriendo['observaciones']);
				if($arriendo['comprobante'] == NULL)
					$respuesta['comprobante'] = '';
				else
					$respuesta['comprobante'] = $arriendo['comprobante'];
				$respuesta['cheque'] = $arriendo['cheque'];	
				
				$respuesta['idArrendador'] = $arriendo['id_arrendador'];	
				$idUser = $arriendo['id_usuario'];				
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