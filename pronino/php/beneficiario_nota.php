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
		$idBeneficiario = $_GET['id_beneficiario'];
		$year = $_GET['year'];
		
		$periodo = $_GET['periodo'];
		$materia = $_GET['materia'];
		$tipoNota = $_GET['tipo_nota'];
		$nota = $_GET['nota'];	
		$observaciones = utf8_decode($_GET['observaciones']);		
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){
			case 'cargar':	$result = Pronino::getInstance()->get_beneficiario_nota_by_materia($idBeneficiario, $year, $periodo, $materia);					
							break;
			case 'cargar_lista':$result = Pronino::getInstance()->get_beneficiario_notas_by_year($idBeneficiario, $year);					
								break;				
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_nota_by_materia($idBeneficiario, $year, $periodo, $materia);
							$result = Pronino::getInstance()->get_beneficiario_notas_by_year($idBeneficiario, $year);
							break;				
			case 'guardar':	$result = Pronino::getInstance()->get_beneficiario_nota_by_materia($idBeneficiario, $year, $periodo, $materia);
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->insert_beneficiario_nota($idBeneficiario, $year, $periodo, $materia, $tipoNota, $nota, $observaciones, $idUser, $fechaActual);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_nota($idBeneficiario, $year, $periodo, $materia, $tipoNota, $nota, $observaciones, $idUser, $fechaActual);
							$result = Pronino::getInstance()->get_beneficiario_notas_by_year($idBeneficiario, $year);								
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
			
		while ($nota = mysqli_fetch_array($result)){
			$respuesta['periodo'][] = $nota['idPeriodo'];	
			$respuesta['materia'][] = $nota['idMateria'];	
			$respuesta['tipoNota'][] = $nota['tipoNota'];	
			$respuesta['nota'][] = $nota['nota'];	
			$respuesta['observaciones'][] = $nota['observaciones'];												
			
			$respuesta['fechaActualizacion'][] = $nota['fechaActualizacion'];					
			$idUser = $nota['idUser'];
			
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