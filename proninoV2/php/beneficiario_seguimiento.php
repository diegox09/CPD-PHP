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
		$idSeguimiento = $_GET['id_seguimiento'];
		$idBeneficiario = $_GET['id_beneficiario'];
		$fechaSeguimiento = explota($_GET['fecha_seguimiento']);	
		$profesional = $_GET['profesional'];		
		$motivo = utf8_decode($_GET['motivo_seguimiento']);		
		$descripcion = utf8_decode($_GET['descripcion_seguimiento']);
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_seguimiento_by_id($idSeguimiento);
							break;
			case 'cargar_lista':$result = Pronino::getInstance()->get_seguimiento_by_beneficiario($idBeneficiario);	
								break;				
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_seguimiento($idSeguimiento);
							$result = Pronino::getInstance()->get_seguimiento_by_beneficiario($idBeneficiario);
							break;				
			case 'guardar':	if($idSeguimiento == '')
								$consulta = Pronino::getInstance()->insert_beneficiario_seguimiento($idBeneficiario, $fechaSeguimiento, $profesional, $motivo, $descripcion, $idUser, $fechaActual);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_seguimiento($idSeguimiento, $idBeneficiario, $fechaSeguimiento, $profesional, $motivo, $descripcion, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_seguimiento_by_beneficiario($idBeneficiario);							
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
			$respuesta['idSeguimiento'][] = $beneficiario['idSeguimiento'];
			$respuesta['fechaSeguimiento'][] = implota($beneficiario['fechaSeguimiento']);	
			
			$idProfesional = $beneficiario['idProfesional'];
			$respuesta['profesional'][] = $idProfesional;
			$profesional = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idProfesional));					
			$respuesta['nombreProfesional'][] = $profesional['nombreUser'];	
						
			$respuesta['descripcion'][] = utf8_encode($beneficiario['descripcion']);	
			$respuesta['motivo'][] = utf8_encode($beneficiario['motivo']);													
			
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