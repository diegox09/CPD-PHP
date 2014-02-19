<?php
	session_start();
	
	require_once('../classes/AutorizacionPago.php');
	
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
		$item = $_GET['item_ap'];
		$opc = $_GET['opc'];
		$consulta = true;
		$quitar = array('$' => '', ' ' => '', '.' => '');
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
		
		$bloqueo = true;
		$id = mysqli_fetch_array(AutorizacionPago::getInstance()->get_id_user_ap($idAutorizacionPago));
		if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap() || $_SESSION['id_ap'] == $id[0])								
			$bloqueo = false;
		
		switch($opc){
			case 'buscar':	$result = AutorizacionPago::getInstance()->get_item_ap_by_id($idAutorizacionPago, $item);
							break;
			case 'eliminar':if(!$bloqueo)
								$consulta = AutorizacionPago::getInstance()->delete_item_ap($idAutorizacionPago, $item);
							else
								$consulta = false;	
							break;							
			case 'guardar':	$numeroPago = $_GET['numero_pago'];
							$comprobanteEgreso = $_GET['comprobante_egreso'];
							$descripcion = utf8_decode($_GET['descripcion_pago']);
							$centroCosto = $_GET['centro_costo'];
							$valor = $_GET['valor_pago'];
							$valor = strtr($valor, $quitar);
								
							if($item == ''){				
								$item_ap = mysqli_fetch_array(AutorizacionPago::getInstance()->get_numero_item_ap($idAutorizacionPago));			
								if($item_ap[0] == NULL)
									$item = 1;	
								else			
									$item = ++$item_ap[0];									
								
								if(!$bloqueo)
									$consulta = AutorizacionPago::getInstance()->insert_item_ap($idAutorizacionPago, $item, $numeroPago, $comprobanteEgreso, $descripcion, $centroCosto, $valor);
								else
									$consulta = false;	
							}
							else{
								if(!$bloqueo)
									$consulta = AutorizacionPago::getInstance()->update_item_ap($idAutorizacionPago, $item, $numeroPago, $comprobanteEgreso, $descripcion, $centroCosto, $valor);
								else
									$consulta = false;	
							}
							
							$result = AutorizacionPago::getInstance()->get_item_ap_by_id($idAutorizacionPago, $item);
							break;
			case 'retenciones':	$iva = $_GET['iva'];	
								$valorIva = strtr($_GET['valor_iva'], $quitar);
								$retencionIva = $_GET['retencion_iva'];
								$valorRetencionIva = strtr($_GET['valor_retencion_iva'], $quitar);
								$retencionFuente = $_GET['retencion_fuente'];
								$valorRetencionFuente = strtr($_GET['valor_retencion_fuente'], $quitar);								
								$retencionIca = $_GET['retencion_ica'];
								$valorRetencionIca = strtr($_GET['valor_retencion_ica'], $quitar);
								$sumarIva = $_GET['sumar_iva'];
								$idUser = $_SESSION['id_ap'];
								
								if(!$bloqueo)							
									$consulta = AutorizacionPago::getInstance()->update_retenciones_ap($idAutorizacionPago, $iva, $valorIva, $retencionIva, $valorRetencionIva, $retencionFuente, $valorRetencionFuente, $retencionIca, $valorRetencionIca, $sumarIva, $idUser, $fechaActualizacion);
								else
									$consulta = false;	
								$result = AutorizacionPago::getInstance()->get_ap_by_id($idAutorizacionPago); 
								break;				
			case 'todos': 	$result = AutorizacionPago::getInstance()->get_item_ap($idAutorizacionPago); 
							break;											
			default:		$result = false;				
		}	
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
					
			else{				
				while ($info = mysqli_fetch_array($result)){
					switch($opc){
						case 'retenciones':	$respuesta['iva'] = $info['iva'].'%';
											$respuesta['retencionIva'] = $info['retencionIva'].'%';
											$respuesta['retencionFuente'] = $info['retencionFuente'].'%';
											$respuesta['valorRetencionFuente'] = '$ '.number_format($info['valorRetencionFuente'],0,',','.');
											$respuesta['retencionIca'] = $info['retencionIca'];
											break;
						default:	$respuesta['id'][] = $info['item'];
									$respuesta['numeroPago'][] = $info['numeroPago'];
									$respuesta['comprobanteEgreso'][] = $info['comprobanteEgreso'];
									$respuesta['descripcion'][] = utf8_encode($info['descripcion']);
									$respuesta['centroCosto'][] = $info['centroCosto'];
									$respuesta['valor'][] = '$ '.number_format($info['valor'],0,',','.');
									break;
					}
				}
				mysqli_free_result($result);
			}
		}
		else
			$respuesta['id'] = $item;
		
		$respuesta['opc'] = $opc;		
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 