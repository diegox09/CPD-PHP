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
		$idPsicosocial = $_GET['id_psicosocial'];
		$idBeneficiario = $_GET['id_beneficiario'];
		$fechaRemision = explota($_GET['fecha_remision']);
		$remitido = $_GET['remitido'];	
		$aspectoAcademico = $_GET['aspecto_academico'];	
		$aspectoComportamiento = $_GET['aspecto_comportamiento'];
		$aspectoComunicativo = $_GET['aspecto_comunicativo'];
		$aspectoFamiliar = $_GET['aspecto_familiar'];
		$motivoAspectoAcademico = utf8_decode($_GET['motivo_aspecto_academico']);	
		$motivoAspectoComportamiento = utf8_decode($_GET['motivo_aspecto_comportamiento']);
		$motivoAspectoComunicativo = utf8_decode($_GET['motivo_aspecto_comunicativo']);
		$motivoAspectoFamiliar = utf8_decode($_GET['motivo_aspecto_familiar']);
		$accionesRealizadas = utf8_decode($_GET['acciones_realizadas']);
		$remitidoUAI = $_GET['remitido_uai'];	
		$remitidoPsicologia = $_GET['remitido_psicologia'];
		$remitidoTerapiaOcupacional = $_GET['remitido_terapia_ocupacional'];
		$remitidoRefuerzoEscolar = $_GET['remitido_refuerzo_escolar'];
		$remitidoOtrasInstituciones = utf8_decode($_GET['remitido_otras_instituciones']);	
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_psicosocial_by_id($idPsicosocial);
							break;
			case 'cargar_lista':$result = Pronino::getInstance()->get_psicosocial_by_beneficiario($idBeneficiario);	
								break;				
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_psicosocial($idPsicosocial);
							$result = Pronino::getInstance()->get_psicosocial_by_beneficiario($idBeneficiario);
							break;				
			case 'guardar':	if($idPsicosocial == '')
								$consulta = Pronino::getInstance()->insert_beneficiario_psicosocial($idBeneficiario, $fechaRemision, $remitido, $aspectoAcademico, $aspectoComportamiento, $aspectoComunicativo, $aspectoFamiliar, $motivoAspectoAcademico, $motivoAspectoComportamiento, $motivoAspectoComunicativo, $motivoAspectoFamiliar, $accionesRealizadas, $remitidoUAI, $remitidoPsicologia, $remitidoTerapiaOcupacional, $remitidoRefuerzoEscolar, $remitidoOtrasInstituciones, $idUser, $fechaActual);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_psicosocial($idPsicosocial, $idBeneficiario, $fechaRemision, $remitido, $aspectoAcademico, $aspectoComportamiento, $aspectoComunicativo, $aspectoFamiliar, $motivoAspectoAcademico, $motivoAspectoComportamiento, $motivoAspectoComunicativo, $motivoAspectoFamiliar, $accionesRealizadas, $remitidoUAI, $remitidoPsicologia, $remitidoTerapiaOcupacional, $remitidoRefuerzoEscolar, $remitidoOtrasInstituciones, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_psicosocial_by_beneficiario($idBeneficiario);							
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
			$respuesta['idPsicosocial'][] = $beneficiario['idAtencionPsicosocial'];			
			$respuesta['fechaRemision'][] = implota($beneficiario['fechaRemision']);
			$remitido = $beneficiario['remitido'];
			$respuesta['remitido'][] = $remitido;
			$respuesta['aspectoAcademico'][] = $beneficiario['aspectoAcademico'];
			$respuesta['aspectoComportamiento'][] = $beneficiario['aspectoComportamiento'];
			$respuesta['aspectoComunicativo'][] = $beneficiario['aspectoComunicativo'];
			$respuesta['aspectoFamiliar'][] = $beneficiario['aspectoFamiliar'];
			$respuesta['motivoAspectoAcademico'] = utf8_encode($beneficiario['motivoAspectoAcademico']);
			$respuesta['motivoAspectoComportamiento'] = utf8_encode($beneficiario['motivoAspectoComportamiento']);
			$respuesta['motivoAspectoComunicativo'] = utf8_encode($beneficiario['motivoAspectoComunicativo']);
			$respuesta['motivoAspectoFamiliar'] = utf8_encode($beneficiario['motivoAspectoFamiliar']);	
			$respuesta['accionesRealizadas'] = utf8_encode($beneficiario['accionesRealizadas']);
			$respuesta['remitidoUAI'][] = $beneficiario['remitidoUAI'];
			$respuesta['remitidoPsicologia'][] = $beneficiario['remitidoPsicologia'];
			$respuesta['remitidoTerapiaOcupacional'][] = $beneficiario['remitidoTerapiaOcupacional'];
			$respuesta['remitidoRefuerzoEscolar'][] = $beneficiario['remitidoRefuerzoEscolar'];
			$respuesta['remitidoOtrasInstituciones'] = utf8_encode($beneficiario['remitidoOtrasInstituciones']);
						
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