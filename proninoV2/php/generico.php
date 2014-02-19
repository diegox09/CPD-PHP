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
		$tipo = $_GET['tipo'];
		$idPronino = $_GET['id_pronino'];
		$idBeneficiario = $_GET['id_beneficiario'];
		$nombreBeneficiario = utf8_decode(trim($_GET['nombres']));
		$apellidoBeneficiario = utf8_decode(trim($_GET['apellidos']));
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
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));
		$perfilUser = $usuario['tipoUser'];
						
		switch($opc){		
			case 'cargar':	$result = Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario);
							if(mysqli_num_rows($result) == 0){
								$opc = 'tabla';
								$result = Pronino::getInstance()->get_beneficiario_like_nombre($documentoBeneficiario, $nombreBeneficiario, $apellidoBeneficiario);
							}
							break;
			case 'eliminar':$consulta = false;
							$result = Pronino::getInstance()->get_diagnostico_by_beneficiario($idBeneficiario);
							$result2 = Pronino::getInstance()->get_mes_by_beneficiario($idBeneficiario);
							$result3 = Pronino::getInstance()->get_nota_by_beneficiario($idBeneficiario);
							$result4 = Pronino::getInstance()->get_psicosocial_by_beneficiario($idBeneficiario);
							$result5 = Pronino::getInstance()->get_seguimiento_by_beneficiario($idBeneficiario);
							$result6 = Pronino::getInstance()->get_year_by_beneficiario($idBeneficiario);
							$result7 = Pronino::getInstance()->get_acudiente_pronino_by_id($idBeneficiario);
							if($tipo == 'beneficiario'){		
								if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0 && mysqli_num_rows($result5) == 0 && mysqli_num_rows($result6) == 0){
									$consulta = Pronino::getInstance()->delete_beneficiario_pronino($idBeneficiario);
									if(mysqli_num_rows($result7) == 0)
										$consulta = Pronino::getInstance()->delete_beneficiario($idBeneficiario);
								}
							}
							
							if($tipo == 'acudiente'){
								$consulta = Pronino::getInstance()->update_acudiente_pronino($idPronino, 0, $idUser, $fechaActual);			
								if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0 && mysqli_num_rows($result5) == 0 && mysqli_num_rows($result6) == 0 && mysqli_num_rows($result7) == 0)
									$consulta = Pronino::getInstance()->delete_beneficiario($idBeneficiario);
							}
							break;
			case 'guardar':	if($idBeneficiario != ''){
								$consulta = Pronino::getInstance()->update_beneficiario($idBeneficiario, $nombreBeneficiario, $apellidoBeneficiario, $td, $documentoBeneficiario, $fechaNacimiento, $genero, $telefono, $direccion, $idMunicipio, $idBarrio, $idUser, $fechaActual);
								$result = Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario);
							}
							else{	
								$opc = 'tabla';
								$nuevo = Pronino::getInstance()->get_beneficiario_by_documento($documentoBeneficiario);
								if(mysqli_num_rows($nuevo) != 0)
									$respuesta['nuevo'] = false;
								else	
									$respuesta['nuevo'] = true;								
								$result = Pronino::getInstance()->get_beneficiario_like_nombre($documentoBeneficiario, $nombreBeneficiario, $apellidoBeneficiario);	
							}
							break;
			case 'nuevo': 	$nuevo = Pronino::getInstance()->get_beneficiario_by_documento($documentoBeneficiario);
							if(mysqli_num_rows($nuevo) == 0)
								$consulta = Pronino::getInstance()->insert_beneficiario($nombreBeneficiario, $apellidoBeneficiario, $td, $documentoBeneficiario, $fechaNacimiento, $genero, $telefono, $direccion, $idMunicipio, $idBarrio,$idUser, $fechaActual);
							$result = Pronino::getInstance()->get_beneficiario_by_documento($documentoBeneficiario);
							break;														
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{
				while ($beneficiario = mysqli_fetch_array($result)){			
					$idBeneficiario = $beneficiario['idBeneficiario'];	
					$respuesta['idBeneficiario'][] = $idBeneficiario;
					
					if($tipo == 'beneficiario'){
						if($opc == 'nuevo')
							$consulta = Pronino::getInstance()->insert_beneficiario_pronino($idBeneficiario, $idUser, $fechaActual, $perfilUser);					
						if($opc == 'cargar'){	
							$pronino = Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario);
							if(mysqli_num_rows($pronino) == 0)
								$respuesta['pronino'] = false;
							else	
								$respuesta['pronino'] = true;
						}
					}
					
					if($tipo == 'acudiente'){
						if($opc == 'nuevo')
							$consulta = Pronino::getInstance()->update_acudiente_pronino($idPronino, $idBeneficiario, $idUser, $fechaActual);					
						if($opc == 'cargar'){	
							$pronino = Pronino::getInstance()->get_acudiente_pronino_by_beneficiario($idPronino, $idBeneficiario);
							if(mysqli_num_rows($pronino) == 0)
								$respuesta['pronino'] = false;
							else	
								$respuesta['pronino'] = true;
						}
					}
								
					$respuesta['nombreBeneficiario'][] = utf8_encode($beneficiario['nombreBeneficiario']);
					$respuesta['apellidoBeneficiario'][] = utf8_encode($beneficiario['apellidoBeneficiario']);
					$respuesta['td'][] = $beneficiario['tipoDocumento'];
					$respuesta['documentoBeneficiario'][] = $beneficiario['documentoBeneficiario'];
					$respuesta['fechaNacimiento'][] = implota($beneficiario['fechaNacimiento']);
					$edad = edad($beneficiario['fechaNacimiento']);
					if($edad != '')
						$edad = $edad.' Año(s)';
					$respuesta['edad'][] = $edad;
					$respuesta['genero'][] = $beneficiario['genero'];
					$respuesta['telefono'][] = $beneficiario['telefono'];
					$respuesta['direccion'][] = utf8_encode($beneficiario['direccion']);
					$respuesta['idMunicipio'][] = $beneficiario['idMunicipio'];
					$respuesta['idBarrio'][] = $beneficiario['idBarrio'];
					$respuesta['fechaActualizacion'][] = $beneficiario['fechaActualizacion'];					
					$idUser = $beneficiario['idUser'];
					
					$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
					$respuesta['nombreUser'][] = htmlentities($usuario['user']);
				}
			}
			mysqli_free_result($result);
		}
		
		$respuesta['tipo'] = $tipo;								
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$respuesta['perfil'] = $perfilUser;				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 