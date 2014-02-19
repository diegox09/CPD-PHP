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
		$idMunicipio = $_GET['id_municipio'];		
		$opc = $_GET['opc'];
		$consulta = true;			
			
		switch($opc){
			case 'buscar':	$nombre = utf8_decode($_GET['nombre']);	
							if($idMunicipio == '')
								$result = AutorizacionPago::getInstance()->get_municipio_by_nombre($nombre);									
							else	
								$result = AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio); 													
							break;	
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_verificar_municipio($idMunicipio);	
							if(mysqli_num_rows($result) == 0)
								$consulta = AutorizacionPago::getInstance()->delete_municipio($idMunicipio);
							else
								$consulta = false;							
							break;			
			case 'guardar': $idDepartamento = $_GET['id_departamento'];
							$nombre = utf8_decode($_GET['nombre']);	
							if($idMunicipio == ''){						
								$consulta = AutorizacionPago::getInstance()->insert_municipio($idDepartamento, $nombre); 
								$result = AutorizacionPago::getInstance()->get_municipio_by_nombre($nombre);
							}
							else{
								$consulta = AutorizacionPago::getInstance()->update_municipio($idMunicipio, $idDepartamento, $nombre);
								$result = AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio);
							}
							break;	
			case 'lista': 	$idDepartamento = $_GET['id_lista'];
							if($idDepartamento != '')
								$result = AutorizacionPago::getInstance()->get_municipio_by_departamento($idDepartamento); 
							else	
								$result = AutorizacionPago::getInstance()->get_municipio(); 
							break;	
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							if($nombre == '')
								$result = AutorizacionPago::getInstance()->get_municipio();
							else	
								$result = AutorizacionPago::getInstance()->get_buscar_municipio($nombre); 	
							break;												
			default:		$result = false; 
							break;						
		}
		
		if($opc != 'eliminar'){			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;			
			else{
				while ($municipio = mysqli_fetch_array($result)){
					$respuesta['id'][] = $municipio['idMunicipio'];
					$respuesta['nombre'][] = utf8_encode($municipio['nombre']);
					$idDepartamento = $municipio['idDepartamento'];				
					$respuesta['idDepartamento'][] = $idDepartamento;
					
					if($opc != 'lista'){
						$departamento = mysqli_fetch_array(AutorizacionPago::getInstance()->get_departamento_by_id($idDepartamento)); 
						$respuesta['departamento'][] = utf8_encode($departamento['nombre']);						
					}
				}	
				mysqli_free_result($result);		
			}		
		}
		else
			$respuesta['id'] = $idMunicipio;	
				
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 