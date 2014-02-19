<?php
	session_start();
	
	require_once('../classes/AutorizacionPago.php');	
	require_once('../funciones/funciones.php');	
	
	$respuesta = array();		
		
	$documento = $_GET['documento'];
	$consulta = false;
		
	$result = AutorizacionPago::getInstance()->get_ap_by_cliente($documento);
	
	if(mysqli_num_rows($result) != 0){
		$consulta = true;			
		while ($info = mysqli_fetch_array($result)){
			$id_ap = $info['idAutorizacionPago'];			
			$idPrograma = $info['idPrograma'];			
			$idMunicipio = $info['idMunicipio'];			
			$respuesta['consecutivo'][] = $info['consecutivo'];
			$respuesta['fecha'][] = implota($info['fecha']);
						
			$idPersona = $info['idCliente'];		
			
			$fechaActualizacion = $info['fechaActualizacion'];
			$fecha = implota(substr($fechaActualizacion,0,10));
			$hora = substr($fechaActualizacion,11,8);
			$respuesta['fechaActualizacion'][] = $fecha.' '.$hora;
			
			$concepto = utf8_encode($info['concepto']);						
			$respuesta['concepto'][] = $concepto;	
			$respuesta['conceptoLista'][] = cortar($concepto,70,' ');	
										
			//Programa
			$programa = mysqli_fetch_array(AutorizacionPago::getInstance()->get_programa_by_id($idPrograma));						
			$respuesta['nombrePrograma'][] = utf8_encode($programa['nombre']);	
			
			//Municipio
			$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio));
			$respuesta['nombreMunicipio'][] = utf8_encode($municipio['nombre']);
						
			//Cliente
			$cliente = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idPersona));
			$respuesta['nombreCliente'][] = utf8_encode($cliente['nombre']);
			
			//Total
			$iva_ap = $info['iva'];
			$valorIva_ap = $info['valorIva'];
			$retencionIva_ap = $info['retencionIva'];	
			$valorRetencionIva_ap = $info['valorRetencionIva'];
			$retencionFuente_ap = $info['retencionFuente'];	
			$valorRetencionFuente_ap = $info['valorRetencionFuente'];
			$retencionIca_ap = $info['retencionIca'];
			$valorRetencionIca_ap = $info['valorRetencionIca'];	
			
			$sumarIva_ap = $info['sumarIva'];
					
			$items = AutorizacionPago::getInstance()->get_item_ap($id_ap);
			$subtotal = 0;			
			$i = 0;
			if(mysqli_num_rows($items) != 0){					
				while ($info_item = mysqli_fetch_array($items)){
					$subtotal = $subtotal + $info_item['valor'];
				}
			}
			
			if($iva_ap == '0.0')
				$valor_iva = $valorIva_ap;
			else
				$valor_iva = $subtotal * ($iva_ap / 100);
				
			if($retencionIva_ap == '0.0')
				$valor_reteiva = $valorRetencionIva_ap;
			else
				$valor_reteiva = $valor_iva * ($retencionIva_ap / 100);
			
			if($retencionFuente_ap == '0.0')
				$valor_retefuente = $valorRetencionFuente_ap;
			else
				$valor_retefuente = $subtotal * ($retencionFuente_ap / 100);
			
			if($retencionIca_ap == '')
				$valor_reteica = $valorRetencionIca_ap; 
			else{	
				$reteica = explode('*', $retencionIca_ap);
				if(count($reteica) == 2){	
					$valor1 = $reteica[0];
					$valor2 = $reteica[1];							
					$valor_reteica = ($reteica[0] / $reteica[1]) * $subtotal;
				}
				else
					$valor_reteica = 0;
			}
			
			if($sumarIva_ap == 1)
				$total = ($subtotal + ($valor_iva - $valor_reteiva) - ($valor_retefuente + $valor_reteica));
			else
				$total = ($subtotal - ($valor_retefuente + $valor_reteica));
				
			if($total != 0)	 				
				$total = '$ '.number_format($total,0,',','.');
			else 
				$total = '';	
				
			$respuesta['valorTotal'][] = $total;	
	
		}			
		mysqli_free_result($result);
	}
	
	$respuesta['consulta'] = $consulta;	
	$respuesta['consulta'] = $consulta;		
	print_r(json_encode($respuesta));	
?> 