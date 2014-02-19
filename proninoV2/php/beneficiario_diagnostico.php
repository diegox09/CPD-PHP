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
		$remitido = $_GET['remitido'];		
		$profesional = $_GET['profesional'];
		$situacionLaboral = utf8_decode($_GET['situacion_laboral']);
		$descripcion = utf8_decode($_GET['descripcion_escenarios']);
		$observaciones = utf8_decode($_GET['observaciones_diagnostico']);			
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_diagnostico_by_beneficiario($idBeneficiario);					
							break;
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_diagnostico($idBeneficiario);
							break;				
			case 'guardar':	$result = Pronino::getInstance()->get_diagnostico_by_beneficiario($idBeneficiario);
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->insert_beneficiario_diagnostico($idBeneficiario, $remitido, $profesional, $situacionLaboral, $descripcion, $observaciones, $idUser, $fechaActual);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_diagnostico($idBeneficiario, $remitido, $profesional, $situacionLaboral, $descripcion, $observaciones, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_diagnostico_by_beneficiario($idBeneficiario);							
							break;													
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			while ($beneficiario = mysqli_fetch_array($result)){					
				$respuesta['remitido'] = $beneficiario['remitido'];
				$respuesta['profesional'] = $beneficiario['idProfesional'];
				$respuesta['situacionLaboral'] = utf8_encode($beneficiario['situacionLaboral']);	
				$respuesta['descripcion'] = utf8_encode($beneficiario['descripcionEscenarios']);	
				$respuesta['observaciones'] = utf8_encode($beneficiario['observacionesDiagnostico']);													
				
				$respuesta['fechaActualizacion'] = $beneficiario['fechaActualizacion'];					
				$idUser = $beneficiario['idUser'];
				
				$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
				$respuesta['nombreUser'] = htmlentities($usuario['user']);											
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