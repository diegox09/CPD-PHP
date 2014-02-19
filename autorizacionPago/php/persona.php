<?php
	session_start();

	require_once('classes/AutorizacionPago.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){		
		$idPersona = $_GET['id_persona'];
		$opc = $_GET['opc'];
		$consulta = true;
		$quitar = array('.' => '');
						
		switch($opc){
			case 'buscar':	$nombre = utf8_decode($_GET['nombre']);		
							$identificacion = utf8_decode($_GET['identificacion']);	
							$documento = explode('-', $identificacion);	
							$identificacion = strtr($documento[0],$quitar);						
							if($idPersona == ''){
								if($nombre != '')
									$result = AutorizacionPago::getInstance()->get_persona_by_nombre($nombre);	
								else
									$result = AutorizacionPago::getInstance()->get_persona_by_identificacion($identificacion);
							}
							else
								$result = AutorizacionPago::getInstance()->get_persona_by_id($idPersona);
							break;
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_verificar_persona($idPersona);
							if(mysqli_num_rows($result) == 0)
								$consulta = AutorizacionPago::getInstance()->delete_persona($idPersona);
							else
								$consulta = false;
							break;							
			case 'guardar':	$nombre = utf8_decode($_GET['nombre']);
							$identificacion = utf8_decode($_GET['identificacion']);	
							$documento = explode('-', $identificacion);	
							$identificacion = strtr($documento[0],$quitar);
							$dv = $documento[1];
												
							$telefono = utf8_decode($_GET['telefono']);
							$celular = utf8_decode($_GET['celular']);
							$email = utf8_decode($_GET['email']);
							$direccion = utf8_decode($_GET['direccion']);
							$idBarrio = $_GET['id_barrio'];							
							if($idPersona == ''){
								$consulta = AutorizacionPago::getInstance()->insert_persona($identificacion, $dv, $nombre, $telefono, $celular, $direccion, $idBarrio, $email);
								$result = AutorizacionPago::getInstance()->get_persona_by_identificacion($identificacion);
							}
							else{
								$consulta = AutorizacionPago::getInstance()->update_persona($idPersona, $identificacion, $dv, $nombre, $telefono, $celular, $direccion, $idBarrio, $email);
								$result = AutorizacionPago::getInstance()->get_persona_by_id($idPersona);	
							}
							break;				
			case 'lista': 	$result = AutorizacionPago::getInstance()->get_persona(); 
							break;	
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							$identificacion = utf8_decode($_GET['identificacion']);
							$documento = explode('-', $identificacion);	
							$identificacion = strtr($documento[0],$quitar);			
							$result = AutorizacionPago::getInstance()->get_buscar_persona($nombre, $identificacion);							
							break;					
			default:		$result = false;				
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				while ($persona = mysqli_fetch_array($result)){
					$respuesta['id'][] = $persona['idPersona'];																			
					$respuesta['nombre'][] = utf8_encode($persona['nombre']);
					$identificacion = number_format($persona['identificacion'],0,',','.');	
					$dv = $persona['dv'];
					if($dv == 0)
						$dv = '';
					else
						$dv = '-'.$dv;							
					$respuesta['identificacion'][] = $identificacion.$dv; 
					
					$respuesta['telefono'][] = utf8_encode($persona['telefono']);
					$respuesta['celular'][] = utf8_encode($persona['celular']);
					$respuesta['direccion'][] = utf8_encode($persona['direccion']);					
					$respuesta['email'][] = utf8_encode($persona['email']);						
					$idBarrio = $persona['idBarrio'];
					$respuesta['idBarrio'][] = $idBarrio;						
					
					$barrio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_barrio_by_id($idBarrio));
					$respuesta['idMunicipio'][] = $barrio['idMunicipio'];
				}			
				mysqli_free_result($result);
			}
		}
		else
			$respuesta['id'] = $idPersona;
							
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 