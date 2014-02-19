<?php
	session_start();
	
	require_once('classes/Pronino.php');
	require_once('funciones/funciones.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = true;
		$opc = $_GET['opc'];
		$idBeneficiario = $_GET['id_beneficiario'];
		$idAcudiente = $_GET['id_acudiente'];
		$documentoAcudiente = $_GET['documento_acudiente'];
		$nombreAcudiente = utf8_decode($_GET['nombre_acudiente']);
		$telefonoAcudiente = $_GET['telefono_acudiente'];		
		$direccionAcudiente = utf8_decode($_GET['direccion_acudiente']);		
		$idBarrio = $_GET['id_barrio'];
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
		
		if($opc == 'guardar' && $idAcudiente == '')
			$opc = 'buscar';
						
		switch($opc){				
			case 'buscar':	$result = Pronino::getInstance()->get_acudiente_by_documento($documentoAcudiente);
							if(mysqli_num_rows($result) == 0){
								$consulta = Pronino::getInstance()->insert_acudiente($documentoAcudiente, $idUser, $fechaActual);								
								$result = Pronino::getInstance()->get_acudiente_by_documento($documentoAcudiente);
							}																				
							if(mysqli_num_rows($result) != 0){
								$acudiente = mysqli_fetch_array($result);					
								$idAcudiente = $acudiente['idAcudiente'];
								$consulta = Pronino::getInstance()->update_acudiente_beneficiario($idBeneficiario, $idAcudiente, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_acudiente_by_id($idAcudiente);			
							}
							break;
			case 'cambiar':	$consulta = Pronino::getInstance()->update_acudiente_beneficiario($idBeneficiario, '0', $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_acudiente_by_beneficiario($idAcudiente);
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->delete_acudiente($idAcudiente);
							mysqli_free_result($result);	
							break;				
			case 'cargar':	$result = Pronino::getInstance()->get_acudiente_by_id($idAcudiente);								
							break;						
			case 'guardar':	$consulta = Pronino::getInstance()->update_acudiente($idAcudiente, $documentoAcudiente, $nombreAcudiente, $telefonoAcudiente, $direccionAcudiente, $idBarrio, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_acudiente_by_id($idAcudiente);								
							break;										
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar' && $opc != 'cambiar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$acudiente = mysqli_fetch_array($result);					
				$respuesta['idAcudiente'] = $acudiente['idAcudiente'];
				$respuesta['documentoAcudiente'] = $acudiente['documentoAcudiente'];
				$respuesta['nombreAcudiente'] = utf8_encode($acudiente['nombreAcudiente']);	
				$respuesta['direccionAcudiente'] = utf8_encode($acudiente['direccionAcudiente']);
				$respuesta['telefonoAcudiente'] = $acudiente['telefonoAcudiente'];						
				$respuesta['fechaActualizacion'] = $acudiente['fechaActualizacion'];
				$idBarrio = $acudiente['idBarrio'];					
				$respuesta['idBarrio'] = $idBarrio;						
				$idUser = $acudiente['idUser'];
				
				$barrio = mysqli_fetch_array(Pronino::getInstance()->get_barrio_by_id($idBarrio));	
				$respuesta['idMunicipio'] = $barrio['idMunicipio'];
				
				$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
				$respuesta['nombreUser'] = $usuario['user'];											
			}			
			mysqli_free_result($result);
		}
				
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']));
		$respuesta['perfil'] = $usuario['tipoUser'];			
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 