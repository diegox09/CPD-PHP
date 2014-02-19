<?php
	session_start();
	
	require_once('classes/Pronino.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = true;
		$opc = $_GET['opc'];
		$completo = true;
		
		$buscar = utf8_decode(trim($_GET['buscar']));
		$year = $_GET['year'];
		$idMunicipio = $_GET['id_municipio'];
		$idColegio = $_GET['id_colegio'];
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));
		$perfilUser = $usuario['tipoUser'];
		
		if($perfilUser == 0)
			$perfilUser = 3;
		
		switch($opc){
			case 'buscar':	if($idColegio > 0){	
								if($perfilUser == 3)
									$result = Pronino::getInstance()->get_buscar_beneficiario_year_by_colegio($buscar, $year, $idColegio);
								else	
									$result = Pronino::getInstance()->get_buscar_beneficiario_year_by_user_colegio($buscar, $idUser, $year, $idColegio);
							}
							else{
								if($idMunicipio > 0){
									if($perfilUser == 3)
									$result = Pronino::getInstance()->get_buscar_beneficiario_by_municipio($buscar, $idMunicipio);
								else	
									$result = Pronino::getInstance()->get_buscar_beneficiario_by_user_municipio($buscar, $idUser, $idMunicipio);
								}
								else{
									$completo = false;
									if($perfilUser == 3)
										$result = Pronino::getInstance()->get_buscar_beneficiario($buscar);
									else	
										$result = Pronino::getInstance()->get_buscar_beneficiario_by_user($buscar, $idUser);
								}
							}
							break;
		}
		
		if(mysqli_num_rows($result) == 0)	
			$consulta = false;
						
		while ($row = mysqli_fetch_array($result)){	
			$respuesta['idBeneficiario'][] = $row['idBeneficiario'];
			if($row['item'] == NULL)
				$respuesta['idItem'][] = '';					
			else	
				$respuesta['idItem'][] = $row['item'];					
			$respuesta['documentoBeneficiario'][] = $row['documentoBeneficiario'];
			$respuesta['nombreBeneficiario'][] = utf8_encode($row['nombreBeneficiario'].' '.$row['apellidoBeneficiario']);
			$respuesta['estado'][] = $row['estado'];
			
			$nombreColegio = '-';
			$nombreMunicipio = '-';
			
			if($completo){
				$idColegio = $row['idColegio'];
				if($idColegio != 0){
					$colegio = mysqli_fetch_array(Pronino::getInstance()->get_colegio_by_id($idColegio));
					$nombreColegio = utf8_encode($colegio['nombreColegio']);
				}
				
				$idMunicipio = $row['idMunicipio'];			
				if($idMunicipio != 0){
					$municipio = mysqli_fetch_array(Pronino::getInstance()->get_municipio_by_id($idMunicipio));	
					$nombreMunicipio = utf8_encode($municipio['nombreMunicipio']);
				}
			}
			
			$respuesta['nombreColegio'][] = $nombreColegio;
			$respuesta['nombreMunicipio'][] = $nombreMunicipio;	
		}			
		mysqli_free_result($result);		
		
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
		
		$respuesta['perfil'] = $perfilUser;
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 