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
		$idResponsable= $_GET['id_responsable'];
		$opc = $_GET['opc'];
		$consulta = true;
						
		switch($opc){
			case 'buscar':	$nombre = utf8_decode($_GET['nombre']);									
							if($idResponsable == '')
								$result = AutorizacionPago::getInstance()->get_responsable_by_nombre($nombre);	
							else
								$result = AutorizacionPago::getInstance()->get_persona_by_id($idResponsable);
							break;
			case 'eliminar':$idPrograma = $_GET['id_programa_registrado'];	
							$consulta = AutorizacionPago::getInstance()->delete_responsable($idResponsable, $idPrograma);
							$result = AutorizacionPago::getInstance()->get_persona_by_id($idResponsable);
							break;							
			case 'guardar':	$idPrograma = $_GET['id_programa'];							
							$result_buscar = AutorizacionPago::getInstance()->get_verificar_responsable_by_programa($idUser, $idPrograma);
							if(mysqli_num_rows($result_buscar) == 0)
								$consulta = AutorizacionPago::getInstance()->insert_responsable($idResponsable, $idPrograma);
																					
							$result = AutorizacionPago::getInstance()->get_responsable_by_id($idResponsable);							
							break;				
			case 'lista': 	$idPrograma = $_GET['id_lista'];
							$result = AutorizacionPago::getInstance()->get_responsable_by_programa($idPrograma); 
							break;	
			case 'todos': 	$nombre = utf8_decode($_GET['nombre']);
							if($nombre == '')
								$result = AutorizacionPago::getInstance()->get_responsable();
							else
								$result = AutorizacionPago::getInstance()->get_buscar_responsable_nombre($nombre);
							break;						
			default:		$result = false;				
		}		
		
		
		if(mysqli_num_rows($result) == 0)	
			$consulta = false;
			
		else{				
			while ($responsable = mysqli_fetch_array($result)){
				$idResponsable = $responsable['idPersona'];	
				$respuesta['id'][] = $idResponsable;
					
				$result_responsable = AutorizacionPago::getInstance()->get_responsable_by_id($idResponsable);
				$programa = false;
				$programas = array();
				
				$respuesta['nombre'][] = utf8_encode($responsable['nombre']);
				$identificacion = number_format($responsable['identificacion'],0,',','.');	
				$dv = $responsable['dv'];
				if($dv == 0)
					$dv = '';
				else
					$dv = '-'.$dv;							
				$respuesta['identificacion'][] = $identificacion.$dv; 
				
				
				if(mysqli_num_rows($result_responsable) != 0){	
					$info_responsable = mysqli_fetch_array($result_responsable);					
					$result_programa = AutorizacionPago::getInstance()->get_programa_by_responsable($idResponsable);
											
					if(mysqli_num_rows($result_programa) != 0){
						$programa = true;						
						while ($info_programa = mysqli_fetch_array($result_programa)){
							$programas['id'][] =  $info_programa['idPrograma'];
							$programas['nombre'][] =  utf8_encode($info_programa['nombre']);
						}						
					}
				}	
				$respuesta['programa'][] = $programa;	
				$respuesta['programas'][] = $programas;								
			}			
			mysqli_free_result($result);
		}
		
							
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 