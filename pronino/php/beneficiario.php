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
		$nombreBeneficiario = utf8_decode($_GET['nombres']);
		$apellidoBeneficiario = utf8_decode($_GET['apellidos']);
		$td = $_GET['td'];	
		$documentoBeneficiario = $_GET['documento_beneficiario'];
		$fechaNacimiento = explota($_GET['fecha_nacimiento']);
		$genero = $_GET['genero'];
		$telefono = $_GET['telefono'];
		$direccion = utf8_decode($_GET['direccion']);
		$idMunicipio = $_GET['id_municipio'];
		$idBarrio = $_GET['id_barrio'];
				
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){				
			case 'cargar':	$result = Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario);								
							break;			
			case 'guardar':	$consulta = Pronino::getInstance()->update_beneficiario($idBeneficiario, $nombreBeneficiario, $apellidoBeneficiario, $td, $documentoBeneficiario, $fechaNacimiento, $genero, $telefono, $direccion, $idMunicipio, $idBarrio,$idUser, $fechaActual);
							$result = Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario);								
							break;										
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$beneficiario = mysqli_fetch_array($result);					
				$respuesta['idBeneficiario'] = $beneficiario['idBeneficiario'];				
				$respuesta['nombreBeneficiario'] = utf8_encode($beneficiario['nombreBeneficiario']);
				$respuesta['apellidoBeneficiario'] = utf8_encode($beneficiario['apellidoBeneficiario']);
				$respuesta['td'] = $beneficiario['tipoDocumento'];
				$respuesta['documentoBeneficiario'] = $beneficiario['documentoBeneficiario'];
				$respuesta['fechaNacimiento'] = implota($beneficiario['fechaNacimiento']);
				$edad = edad($beneficiario['fechaNacimiento']);
				if($edad != '')
					$edad = $edad.' Año(s)';
				$respuesta['edad'] = $edad;
				$respuesta['genero'] = $beneficiario['genero'];
				$respuesta['telefono'] = $beneficiario['telefono'];
				$respuesta['direccion'] = utf8_encode($beneficiario['direccion']);
				$respuesta['idMunicipio'] = $beneficiario['idMunicipio'];
				$respuesta['idBarrio'] = $beneficiario['idBarrio'];
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