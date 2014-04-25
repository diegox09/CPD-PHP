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
		$item = $_GET['item'];	
		$tallaUniforme = $_GET['talla_uniforme'];
		$tallaZapato = $_GET['talla_zapato'];
		$sisben = $_GET['sisben'];
		$idArs = $_GET['id_ars'];		
		$idUsuario1 = $_GET['id_usuario1'];
		$idUsuario2 = $_GET['id_usuario2'];
		$fechaIngreso = explota($_GET['fecha_ingreso']);
		$estado = $_GET['estado'];
		$fechaRetiro = explota($_GET['fecha_retiro']);
		$razonRetiro = $_GET['razon_retiro'];
		$razonEgresado = $_GET['razon_egresado'];
		$razonBaja = $_GET['razon_baja'];
		//Modificacion
		$grupoEtnico = $_GET['grupo_etnico'];
		$tipologiaFamiliar = $_GET['tipologia_familiar'];
		$parentescoAcudiente = $_GET['parentesco_acudiente'];
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){				
			case 'cargar':	$result = Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario);								
							break;			
			case 'guardar':	$consulta = Pronino::getInstance()->update_beneficiario_pronino($idBeneficiario, $item, $tallaUniforme, $tallaZapato, $sisben, $idArs, $idUsuario1, $idUsuario2, $fechaIngreso, $estado, $fechaRetiro, $razonRetiro, $idUser, $fechaActual, $razonEgresado, $razonBaja, $grupoEtnico, $tipologiaFamiliar, $parentescoAcudiente);
							$result = Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario);								
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
				
				$idAcudiente = $beneficiario['idAcudiente'];
				$respuesta['idAcudiente'] = $idAcudiente;
				$acudiente = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($idAcudiente));
				$respuesta['documentoAcudiente'] = $acudiente['documentoBeneficiario'];
				$respuesta['nombreAcudiente'] = utf8_encode($acudiente['nombreBeneficiario'].' '.$acudiente['apellidoBeneficiario']);
				
				$respuesta['idItem'] = $beneficiario['item'];
				$respuesta['tallaUniforme'] = $beneficiario['tallaUniforme'];
				$respuesta['tallaZapato'] = $beneficiario['tallaZapato'];
				$respuesta['sisben'] = $beneficiario['sisben'];
				$respuesta['idArs'] = $beneficiario['idArs'];
				$respuesta['idUsuario1'] = $beneficiario['idUsuario1'];
				$respuesta['idUsuario2'] = $beneficiario['idUsuario2'];
				$respuesta['fechaIngreso'] = implota($beneficiario['fechaIngreso']);
				$respuesta['estado'] = $beneficiario['estado'];
				$respuesta['fechaRetiro'] = implota($beneficiario['fechaRetiro']);
				$respuesta['razonRetiro'] = $beneficiario['razonRetiro'];
				$respuesta['razonEgresado'] = $beneficiario['razonEgresado'];
				$respuesta['razonBaja'] = $beneficiario['razonBaja'];
				$respuesta['fechaActualizacion'] = $beneficiario['fechaActualizacion'];	
				$idUser = $beneficiario['idUser'];
				//Modificacion
				$respuesta['grupoEtnico'] = $beneficiario['grupoEtnico'];
				$respuesta['tipologiaFamiliar'] = $beneficiario['tipologiaFamiliar'];
				$respuesta['parentescoAcudiente'] = $beneficiario['parentescoAcudiente'];
				
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