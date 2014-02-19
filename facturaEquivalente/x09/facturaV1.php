<?php
	require_once('classes/User.php');	
	require_once('classes/Factura.php');
	require_once('classes/Cliente.php');
	
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
		$quitar = array('$ ' => '', '.' => '');
		
		$numeroFactura = $_GET['numero_factura'];		
		$idPrograma = $_GET['id_programa'];
		$ciudad = strtoupper(utf8_decode($_GET['ciudad']));
		$fecha = $_GET['fecha'];
		$idCliente = $_GET['id_persona'];
		$idUser = $_SESSION['id_fe'];
		$idEstadoFactura = $_GET['estado_factura'];
		if($idEstadoFactura != '2')
			$idEstadoFactura = '1';				
		$tarifaIva = $_GET['tarifa_iva'];
		$tarifaRetencionIva = $_GET['tarifa_reteiva'];
		$retencionFuente = $_GET['retefuente'];

                if($retencionFuente == "0.0%" || $retencionFuente == ""){
		   $impuestoRenta = $_GET['impuesto_renta'];
		   $impuestoRenta = strtr($impuestoRenta, $quitar);
                }

		$retencionIca = $_GET['reteica'];		
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');			
			
		if($numeroFactura == ''){	
			$numero = mysqli_fetch_array(Factura::getInstance()->set_numero($idPrograma));			
			if($numero[0] == NULL)
				$numeroFactura = 1;	
			else			
				$numeroFactura = ++$numero[0];
			
			$consulta = Factura::getInstance()->insert_factura($idPrograma, $numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $idUser, $idEstadoFactura, $tarifaIva, $tarifaRetencionIva, $retencionFuente, $impuestoRenta, $retencionIca);
			
			$result = Factura::getInstance()->get_id_factura($idPrograma, $numeroFactura);			
			if(mysqli_num_rows($result) > 0){	
				$factura = mysqli_fetch_array($result);	
				$idFactura = $factura['idFactura'];				
				
				for($i=1; $i<10; $i++){
					$referencia = $_GET['referencia_'.$i];
					$descripcion = strtoupper(utf8_decode($_GET['descripcion_'.$i]));
					$cantidad = $_GET['cantidad_'.$i];	
					$valor = $_GET['valor_'.$i];					
					$cantidad = strtr($cantidad, $quitar);
					$valor = strtr($valor, $quitar);					
					if($cantidad == 'GL')
						$cantidad = -1;
					$consulta = Factura::getInstance()->insert_item($idFactura, $i, $referencia, $descripcion, $cantidad, $valor);
				}
			}				
		}	
		else{
			$consulta = Factura::getInstance()->update_factura($idPrograma, $numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $idUser, $idEstadoFactura, $tarifaIva, $tarifaRetencionIva, $retencionFuente, $impuestoRenta, $retencionIca);
			
			$result = Factura::getInstance()->get_id_factura($idPrograma, $numeroFactura);			
			if(mysqli_num_rows($result) > 0){	
				$factura = mysqli_fetch_array($result);	
				$idFactura = $factura['idFactura'];					
				for($i=1; $i<10; $i++){
					$referencia = $_GET['referencia_'.$i];
					$descripcion = strtoupper(utf8_decode($_GET['descripcion_'.$i]));
					$cantidad = $_GET['cantidad_'.$i];
					$valor = $_GET['valor_'.$i];                                         					
					$cantidad = strtr($cantidad, $quitar);
					$valor = strtr($valor, $quitar);
					if($cantidad == 'GL')
						$cantidad = -1;
					$consulta = Factura::getInstance()->update_item($idFactura, $i, $referencia, $descripcion, $cantidad, $valor);
				}
			}
		}
		
		if($consulta){
			$result = Factura::getInstance()->get_factura($idPrograma, $numeroFactura);			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
			else{	
				$factura = mysqli_fetch_array($result);
				$idFactura = $factura['idFactura'];	
				$respuesta['numeroFactura'] = $factura['numeroFactura'];
				$respuesta['ciudad'] = utf8_encode($factura['ciudad']);
				$respuesta['fecha'] = $factura['fecha'];
				$idCliente = $factura['idCliente'];
				$respuesta['idCliente'] = $idCliente;
				$idUser = $factura['idUser'];								
				$respuesta['tarifaIva'] = $factura['tarifaIva'];
				$respuesta['tarifaRetencionIva'] = $factura['tarifaRetencionIva'];
				$respuesta['retencionFuente'] = $factura['retencionFuente'];
				$respuesta['impuestoRenta'] = $factura['impuestoRenta'];
				$respuesta['retencionIca'] = $factura['retencionIca'];
				$respuesta['estadoFactura'] = $factura['idEstadoFactura'];
				$respuesta['fechaActualizacion'][] = $factura['fechaActualizacion'];
				
				$result = Cliente::getInstance()->get_cliente_by_id($idCliente);				
				$cliente = mysqli_fetch_array($result);
				$respuesta['nitCliente'] = $cliente['nit'];
				$respuesta['nombreCliente'] = utf8_encode($cliente['nombres']);
				$respuesta['actividadEconomica'] = $cliente['actividadEconomica'];
				$respuesta['direccionCliente'] = utf8_encode($cliente['direccion']);	
				
				$result = Factura::getInstance()->get_item($idFactura);	
				while ($row = mysqli_fetch_array($result)){
					$respuesta['referencia'][] = $row['referencia'];
					$respuesta['descripcion'][] = utf8_encode($row['descripcion']);
					$respuesta['cantidad'][] = $row['cantidad'];
					$respuesta['valor'][] = $row['valor'];
				}
				
				$result = User::getInstance()->get_user_by_id($idUser);				
				$user = mysqli_fetch_array($result);
				$respuesta['nombreUser'] = utf8_encode($user['nombre']);
			}
		}		
		mysqli_free_result($result);
		$respuesta['consulta'] = $consulta;	
	}			
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 