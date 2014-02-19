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
		$idBarrio = $_GET['id_barrio'];		
		$opc = $_GET['opc'];
		$consulta = true;			
			
		switch($opc){
			case 'buscar': 	$nombre = utf8_decode($_GET['nombre']);	
							if($idBarrio == '')
								$result = AutorizacionPago::getInstance()->get_barrio_by_nombre($nombre);  
							else	
								$result = AutorizacionPago::getInstance()->get_barrio_by_id($idBarrio);
							break;								
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_verificar_barrio($idBarrio);	
							if(mysqli_num_rows($result) == 0)
								$consulta = AutorizacionPago::getInstance()->delete_barrio($idBarrio);
							else
								$consulta = false;
							break;				
			case 'guardar': $idMunicipio = $_GET['id_municipio'];
							$nombre = utf8_decode($_GET['nombre']);	
							if($idBarrio == ''){						
								$consulta = AutorizacionPago::getInstance()->insert_barrio($idMunicipio, $nombre); 
								$result = AutorizacionPago::getInstance()->get_barrio_by_municipio_nombre($idMunicipio, $nombre);
							}
							else{
								$consulta = AutorizacionPago::getInstance()->update_barrio($idBarrio, $idMunicipio, $nombre);
								$result = AutorizacionPago::getInstance()->get_barrio_by_id($idBarrio);
							}
							break;
			case 'lista': 	$idMunicipio = $_GET['id_lista'];
							$result = AutorizacionPago::getInstance()->get_barrio_by_municipio($idMunicipio); 
							break;	
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							if($nombre == '')
								$result = AutorizacionPago::getInstance()->get_barrio(); 
							else	
								$result = AutorizacionPago::getInstance()->get_buscar_barrio($nombre); 
							break;					
			default:		$result = false; 						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;			
			else{
				while ($barrio = mysqli_fetch_array($result)){
					$respuesta['id'][] = $barrio['idBarrio'];					
					$respuesta['nombre'][] = utf8_encode($barrio['nombre']);
					$idMunicipio = $barrio['idMunicipio'];
					$respuesta['idMunicipio'][] = $idMunicipio;
					
					if($opc != 'lista'){
						$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio)); 
						$respuesta['municipio'][] = utf8_encode($municipio['nombre']);
						$idDepartamento = $municipio['idDepartamento'];					
						$respuesta['idDepartamento'][] = $idDepartamento;	
						
						$departamento = mysqli_fetch_array(AutorizacionPago::getInstance()->get_departamento_by_id($idDepartamento)); 
						$respuesta['departamento'][] = utf8_encode($departamento['nombre']);
					}
				}	
				mysqli_free_result($result);		
			}		
		}
		else
			$respuesta['id'] = $idBarrio;	
				
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 