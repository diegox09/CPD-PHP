<?php
	require_once('classes/User.php');
	require_once('classes/Porcentaje.php');	
	
	$logonSuccess = false;
	$respuesta = array();	
	
	session_start();
	if (array_key_exists('id_fe', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_fe'] == User::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){			
		$idPorcentaje = $_GET['id_porcentaje'];
		$opc = $_GET['opc'];
		$consulta = true;	
		if($idPorcentaje != ''){
			switch($opc){
				case 'update' :	$tipoConcepto = $_GET['tipo_concepto'];
								$concepto = utf8_decode($_GET['concepto']);
								$tarifaIva = $_GET['tarifa_iva'];
								$retencionIva = $_GET['tarifa_reteiva'];
								$retencionFuente = $_GET['tarifa_retefuente'];
								$consulta = Porcentaje::getInstance()->update_porcentaje($idPorcentaje, $tipoConcepto, $concepto, $tarifaIva, $retencionIva, $retencionFuente);
								break;
				case 'delete' :	$consulta = Porcentaje::getInstance()->delete_porcentaje($idPorcentaje);
								if($consulta)
									$respuesta['idPorcentaje'] = $idPorcentaje;
								break;					
			}	
			if($opc != 'delete')
				$result = Porcentaje::getInstance()->get_porcentaje_by_id($idPorcentaje);
		}
		
						
		else{
			switch($opc){
				case 'all':		$result = Porcentaje::getInstance()->get_porcentaje();
								break;
				case 'insert':  $tipoConcepto = $_GET['tipo_concepto'];
								$concepto = utf8_decode($_GET['concepto']);
								$tarifaIva = $_GET['tarifa_iva'];
								$retencionIva = $_GET['tarifa_reteiva'];
								$retencionFuente = $_GET['tarifa_retefuente'];								
								$consulta = Porcentaje::getInstance()->insert_porcentaje($tipoConcepto, $concepto, $tarifaIva, $retencionIva, $retencionFuente); 
								$result = Porcentaje::getInstance()->get_porcentaje_by_concepto($concepto);
								break;						
			}
		}	
				
		if($opc != 'delete'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{						
				while ($row = mysqli_fetch_array($result)){
					$respuesta['idPorcentaje'][] = $row['idPorcentajeRetencion'];
					$respuesta['tipoConcepto'][] =  $row['tipoConcepto'];
					$respuesta['concepto'][] =  utf8_encode($row['concepto']);
					$respuesta['tarifaIva'][] = $row['tarifaIva'];
					$respuesta['retencionIva'][] = $row['retencionIva'];
					$respuesta['retencionFuente'][] = $row['retencionFuente'];
				}	
				mysqli_free_result($result);		
			}
		}
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 