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
		$idDepartamento = $_GET['id_departamento'];		
		$opc = $_GET['opc'];
		$consulta = true;			
			
		switch($opc){										
			case 'buscar':	$nombre = utf8_decode($_GET['nombre']); 	
							if($idDepartamento == '')
								$result = AutorizacionPago::getInstance()->get_departamento_by_nombre($nombre);
							else	
								$result = AutorizacionPago::getInstance()->get_departamento_by_id($idDepartamento); 														
							break;	
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_verificar_departamento($idDepartamento);
							if(mysqli_num_rows($result) == 0)		
								$consulta = AutorizacionPago::getInstance()->delete_departamento($idDepartamento);
							else
								$consulta = false;								
							break;				
			case 'guardar': $nombre = utf8_decode($_GET['nombre']);	
							if($idDepartamento == ''){						
								$consulta = AutorizacionPago::getInstance()->insert_departamento($nombre); 
								$result = AutorizacionPago::getInstance()->get_departamento_by_nombre($nombre);
							}
							else{
								$consulta = AutorizacionPago::getInstance()->update_departamento($idDepartamento, $nombre);
								$result = AutorizacionPago::getInstance()->get_departamento_by_id($idDepartamento);
							}
							break;	
			case 'lista': 	$result = AutorizacionPago::getInstance()->get_departamento(); 
							break;	
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							if($nombre == '')
								$result = AutorizacionPago::getInstance()->get_departamento(); 
							else	
								$result = AutorizacionPago::getInstance()->get_buscar_departamento($nombre); 
							break;					
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;			
			else{
				while ($departamento = mysqli_fetch_array($result)){
					$respuesta['id'][] = $departamento['idDepartamento'];
					$respuesta['nombre'][] = utf8_encode($departamento['nombre']);					
				}	
				mysqli_free_result($result);		
			}		
		}
		else
			$respuesta['id'] = $idDepartamento;	
				
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 