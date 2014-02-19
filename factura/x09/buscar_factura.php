<?php
	require_once('classes/User.php');	
	require_once('classes/Factura.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	session_start();
	if (array_key_exists('id_f', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_f'] == User::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){	
		$numeroFactura = $_GET['numero_factura'];	
		$consulta = true;			
		switch($numeroFactura){
			case '@buscador':	$fecha = $_GET['buscar_fecha'];
								$texto = utf8_decode($_GET['buscar_texto']);											
								if($texto != ''){
									$result = Factura::getInstance()->get_factura_by_nit($texto);			
								}
								else{											
									if($fecha != '')		
										$result = Factura::getInstance()->get_factura_by_fecha($fecha);
									else			
										$result = Factura::getInstance()->get_all_factura();
								}
								break;					
			default:			$result = Factura::getInstance()->get_factura($numeroFactura);						
								break;
		}
				
		if(mysqli_num_rows($result) == 0)	
			$consulta = false;
		else{			
			while ($factura = mysqli_fetch_array($result)){				
				$idFactura = $factura['idFactura'];
				$respuesta['idFactura'][] = $idFactura;				
				$respuesta['numeroFactura'][] = $factura['numeroFactura'];
				$respuesta['ciudad'][] = utf8_encode($factura['ciudad']);
				$respuesta['fecha'][] = $factura['fecha'];
				$idCliente = $factura['idCliente'];
				$respuesta['idCliente'][] = $idCliente;
				$respuesta['nitCliente'][] = $factura['nit'];
				$respuesta['nombreCliente'][] = utf8_encode($factura['nombres']);
				$respuesta['telefonoCliente'][] = $factura['telefono'];
				$respuesta['direccionCliente'][] = utf8_encode($factura['direccion']);
				$respuesta['descripcion'][] = utf8_encode($factura['descripcion']);
				$respuesta['valor'][] = $factura['valor'];
				$respuesta['tarifaIva'] = $factura['tarifaIva'];
				$respuesta['observaciones'] = utf8_encode($factura['observaciones']);
				$idUser = $factura['idUser'];			
				$respuesta['idUser'][] = $idUser;				
				$respuesta['estadoFactura'][] = $factura['idEstadoFactura'];
				$respuesta['fechaActualizacion'][] = $factura['fechaActualizacion'];
				
				$result_u = User::getInstance()->get_user_by_id($idUser);				
				$user = mysqli_fetch_array($result_u);
				$respuesta['nombreUser'][] = utf8_encode($user['nombre']);	
								
			}
						
			$respuesta['primeraFactura'] = Factura::getInstance()->get_min_factura();
			$numero = mysqli_fetch_array(Factura::getInstance()->set_numero());	
			$respuesta['ultimaFactura'] = $numero[0];
				
			mysqli_free_result($result);
		}		
		$respuesta['consulta'] = $consulta;		
	}	
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 