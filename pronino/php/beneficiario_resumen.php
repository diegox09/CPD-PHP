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
		$idResumen = $_GET['id_resumen'];
		$idBeneficiario = $_GET['id_beneficiario'];		
		$fechaResumen = explota($_GET['fecha_resumen']);		
		$tipoResumen = $_GET['tipo_resumen'];
		//$descripcionResumen = utf8_decode($_GET['descripcion_resumen']);
		$descripcionResumen = nl2br(utf8_decode(str_replace("<br />", "", $_GET['descripcion_resumen'])));
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_resumen_by_id($idResumen);
							break;
			case 'cargar_lista':$result = Pronino::getInstance()->get_resumen_by_beneficiario($idBeneficiario);	
								break;				
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_resumen($idResumen);
							$result = Pronino::getInstance()->get_resumen_by_beneficiario($idBeneficiario);
							break;				
			case 'guardar':	if($idResumen == '')
								$consulta = Pronino::getInstance()->insert_beneficiario_resumen($idBeneficiario, $fechaResumen, $tipoResumen, $descripcionResumen, $idUser, $fechaActual);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_resumen($idResumen, $idBeneficiario, $fechaResumen, $tipoResumen, $descripcionResumen, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_resumen_by_beneficiario($idBeneficiario);							
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
			$respuesta['idResumen'][] = $beneficiario['idResumen'];
			$respuesta['fechaResumen'][] = implota($beneficiario['fechaResumen']);				
			$respuesta['tipoResumen'][] = $beneficiario['tipoResumen'];
			if($opc == 'cargar')											
				$respuesta['descripcionResumen'][] = utf8_encode(str_replace("<br />","", $beneficiario['descripcionResumen']));			
			else
				$respuesta['descripcionResumen'][] = utf8_encode($beneficiario['descripcionResumen']);				
			$respuesta['fechaActualizacion'][] = $beneficiario['fechaActualizacion'];								
			$idUser = $beneficiario['idUser'];
			
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
			$respuesta['nombreUser'][] = htmlentities($usuario['nombreUser']);											
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