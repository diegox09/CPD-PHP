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
		$lista = true;
		$opc = $_GET['opc'];
		$idPsicologia = $_GET['id_psicologia'];
		$idBeneficiario = $_GET['id_beneficiario'];	
		$fechaAtencionPsicologia = explota($_GET['fecha_atencion_psicologia']);	
		$observacionesPsicologia = utf8_decode($_GET['observaciones_psicologia']);	
		$impresionDiagnostica = utf8_decode($_GET['impresion_diagnostica']);
		$planIntervencion = utf8_decode($_GET['plan_intervencion']);
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_psicologia_by_id($idPsicologia);
							break;
			case 'cargar_lista':$result = Pronino::getInstance()->get_psicologia_by_beneficiario($idBeneficiario);	
								break;				
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_psicologia($idPsicologia);
							$result = Pronino::getInstance()->get_psicologia_by_beneficiario($idBeneficiario);
							break;				
			case 'guardar':	if($idPsicologia == '')
								$consulta = Pronino::getInstance()->insert_beneficiario_psicologia($idBeneficiario, $fechaAtencionPsicologia, $observacionesPsicologia, $impresionDiagnostica, $planIntervencion, $idUser, $fechaActual);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_psicologia($idPsicologia, $idBeneficiario, $fechaAtencionPsicologia, $observacionesPsicologia, $impresionDiagnostica, $planIntervencion, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_psicologia_by_beneficiario($idBeneficiario);							
							break;										
			default:		$result = false;
							break;			
		}		
						
		if(mysqli_num_rows($result) == 0){	
			if($opc == 'cargar')
				$consulta = false;
			else
				$lista = false;		
		}
				
		while ($beneficiario = mysqli_fetch_array($result)){			
			$respuesta['idPsicologia'][] = $beneficiario['idAtencionPsicologia'];	
			$respuesta['fechaAtencionPsicologia'][] = implota($beneficiario['fechaAtencionPsicologia']);	
			$respuesta['observacionesPsicologia'] = utf8_encode($beneficiario['observacionesPsicologia']);
			$respuesta['impresionDiagnostica'] = utf8_encode($beneficiario['impresionDiagnostica']);
			$respuesta['planIntervencion'] = utf8_encode($beneficiario['planIntervencion']);	
							
			$profesional = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($remitido));					
			$respuesta['nombreProfesional'][] = $profesional['nombreUser'];
					
			$respuesta['fechaActualizacion'][] = $beneficiario['fechaActualizacion'];								
			$idUser = $beneficiario['idUser'];
			
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
			$respuesta['nombreUser'][] = htmlentities($usuario['user']);											
		}
		mysqli_free_result($result);
	
		$respuesta['lista'] = $lista;								
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']));
		$respuesta['perfil'] = $usuario['tipoUser'];		
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 