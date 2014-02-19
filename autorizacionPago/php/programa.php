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
		$idPrograma = $_GET['id_programa'];		
		$opc = $_GET['opc'];
		$consulta = true;		
				
		switch($opc){	
			case 'ap': 		$result = AutorizacionPago::getInstance()->get_programa_by_id($idPrograma); 
							break;										
			case 'buscar': 	$nombre = utf8_decode($_GET['nombre']);
							if($idPrograma == '')
								$result = AutorizacionPago::getInstance()->get_programa_by_nombre($nombre); 								
							else	
								$result = AutorizacionPago::getInstance()->get_programa_by_id($idPrograma); 
							break;
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_verificar_programa($idPrograma);
							if(mysqli_num_rows($result) == 0)
								$consulta = AutorizacionPago::getInstance()->delete_programa($idPrograma);
							else
								$consulta = false;
							break;				
			case 'guardar': $nombre = utf8_decode($_GET['nombre']);
							$descripcion = utf8_decode($_GET['descripcion']);
							$idMunicipio = $_GET['id_municipio'];
							if($idPrograma == ''){								
								$consulta = AutorizacionPago::getInstance()->insert_programa($nombre, $descripcion, $idMunicipio); 
								$result = AutorizacionPago::getInstance()->get_programa_by_nombre($nombre);
							}
							else{
								$consulta = AutorizacionPago::getInstance()->update_programa($idPrograma, $nombre, $descripcion, $idMunicipio);
								$result = AutorizacionPago::getInstance()->get_programa_by_id($idPrograma);
							}
							break;					
			case 'lista': 	if($_GET['id_lista'] != '')
								$result = AutorizacionPago::getInstance()->get_programa_by_user($_SESSION['id_ap']);
							else	
								$result = AutorizacionPago::getInstance()->get_programa();	 
							break;
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							if($nombre == '')
								$result = AutorizacionPago::getInstance()->get_programa(); 
							else	
								$result = AutorizacionPago::getInstance()->get_buscar_programa($nombre); 
							break;
			default:		$result = false;
							break;																												
		}
		
		if($opc != 'eliminar'){
			if(mysqli_num_rows($result) == 0){
				$consulta = false;			
			}
			else{
				while ($programa = mysqli_fetch_array($result)){
					$respuesta['id'][] = $programa['idPrograma'];
					$respuesta['nombre'][] = utf8_encode($programa['nombre']);
					$respuesta['descripcion'][] = utf8_encode($programa['descripcion']);
					$idMunicipio = $programa['idMunicipio'];
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
			$respuesta['id'] = $idPrograma;										
			
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 