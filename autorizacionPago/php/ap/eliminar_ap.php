<?php
	session_start();
	
	require_once('../classes/AutorizacionPago.php');	
	require_once('../funciones/funciones.php');	
	
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
		$idAutorizacionPago = $_GET['id_ap'];
		$array = explode(',',$idAutorizacionPago);
		$consulta = false;
						
		if($administrador){
			foreach ($array as $id) {				
				if($id != ''){
					$consulta = true;	
					$info = mysqli_fetch_array(AutorizacionPago::getInstance()->get_ap_by_id($id));
					
					$idPrograma = $info['idPrograma'];					
					$idMunicipio = $info['idMunicipio'];
					$respuesta['consecutivo'][] = $info['consecutivo'];	
						
					//Programa
					$programa = mysqli_fetch_array(AutorizacionPago::getInstance()->get_programa_by_id($idPrograma));						
					$respuesta['nombrePrograma'][] = utf8_encode($programa['nombre']);	
					
					//Municipio
					$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio));
					$respuesta['nombreMunicipio'][] = utf8_encode($municipio['nombre']);
					
					$consulta2 = AutorizacionPago::getInstance()->delete_all_item_ap($id);
					if($consulta2)	
						$consulta2 = AutorizacionPago::getInstance()->delete_ap($id);
					
					if($consulta)						
						$respuesta['eliminada'][] = 'X';
					else						
						$respuesta['eliminada'][] = '';
				}
			}
		}
		
		$respuesta['consulta'] = $consulta;
	}
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 