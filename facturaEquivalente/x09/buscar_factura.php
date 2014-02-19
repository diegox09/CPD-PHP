<?php
	require_once('classes/User.php');	
	require_once('classes/Factura.php');
	require_once('classes/Cliente.php');
	require_once('classes/Programa.php');
	
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
		$numeroFactura = $_GET['numero_factura'];	
		$idPrograma = $_GET['id_programa'];			
		$consulta = true;			
		switch($numeroFactura){
			case '@buscador':	$fecha = $_GET['buscar_fecha'];
								$texto = utf8_decode($_GET['buscar_texto']);											
								if($texto != ''){										
									$cliente = mysqli_fetch_array(Cliente::getInstance()->get_cliente_by_nit($texto));
									$idCliente = $cliente['idCliente'];
									$result = Factura::getInstance()->get_factura_by_nit($idCliente);			
								}
								else{			
									if($idPrograma != 0 && $fecha == '')	
										$result = Factura::getInstance()->get_factura_by_programa($idPrograma);
									else{
										if($idPrograma != 0 && $fecha != '')		
											$result = Factura::getInstance()->get_factura_by_programa_fecha($idPrograma, $fecha);
										else{
											if($idPrograma == 0 && $fecha != '')		
												$result = Factura::getInstance()->get_factura_by_fecha($fecha);		
										}
									}
								}
								break;
			case '@cambiar':	$idFactura =  $_GET['id_factura'];
								$numeroNuevo =  $_GET['numero_nuevo'];
								$consulta = Factura::getInstance()->update_numero_factura($idFactura, $numeroNuevo);
								$result = Factura::getInstance()->get_factura_by_id($idFactura);												
								break;					
			case '@cargar':		$idFactura =  $_GET['id_factura'];
								$result = Factura::getInstance()->get_factura_by_id($idFactura);												
								break;
			case '@eliminar':	$idFactura =  $_GET['id_factura'];																											
								$consulta = Factura::getInstance()->delete_item_factura($idFactura);
								if($consulta){
									$consulta = Factura::getInstance()->delete_factura($idFactura);	
									if($consulta)
										$respuesta['idFactura'] = $idFactura;													
								}
								break;					
			default:			$result = Factura::getInstance()->get_factura($idPrograma, $numeroFactura);						
								break;
		}
				
		if(mysqli_num_rows($result) == 0 && $numeroFactura != '@eliminar')	
			$consulta = false;
		else{			
			while ($factura = mysqli_fetch_array($result)){				
				$idFactura = $factura['idFactura'];
				$respuesta['idFactura'][] = $idFactura;				
				$idPrograma = $factura['idPrograma'];
				$respuesta['numeroFactura'][] = $factura['numeroFactura'];
				$respuesta['ciudad'][] = utf8_encode($factura['ciudad']);
				$respuesta['fecha'][] = $factura['fecha'];
				$idCliente = $factura['idCliente'];
				$respuesta['idCliente'][] = $idCliente;
				$idUser = $factura['idUser'];			
				$respuesta['idUser'][] = $idUser;				
				$respuesta['tarifaIva'][] = $factura['tarifaIva'];
				$respuesta['tarifaRetencionIva'][] = $factura['tarifaRetencionIva'];
				$respuesta['retencionFuente'][] = $factura['retencionFuente'];
				$respuesta['impuestoRenta'][] = $factura['impuestoRenta'];
				$respuesta['retencionIca'][] = $factura['retencionIca'];
				$respuesta['estadoFactura'][] = $factura['idEstadoFactura'];
				$respuesta['fechaActualizacion'][] = $factura['fechaActualizacion'];
				
				$result_c = Cliente::getInstance()->get_cliente_by_id($idCliente);				
				$cliente = mysqli_fetch_array($result_c);
				$respuesta['nitCliente'][] = $cliente['nit'];
				$respuesta['nombreCliente'][] = utf8_encode($cliente['nombres']);	
				$respuesta['actividadEconomica'][] = $cliente['actividadEconomica'];
				$respuesta['direccionCliente'][] = utf8_encode($cliente['direccion']);
				
				$result_u = User::getInstance()->get_user_by_id($idUser);				
				$user = mysqli_fetch_array($result_u);
				$respuesta['nombreUser'][] = utf8_encode($user['nombre']);	
				
				switch($numeroFactura){
					case '@buscador':	$result_p = Programa::getInstance()->get_programa_by_id($idPrograma);
										$programa = mysqli_fetch_array($result_p);
										$respuesta['nombrePrograma'][] = utf8_encode($programa['nombre']);
										$respuesta['inicFactura'][] = $programa['iniciales']; 
										break;	
					case '@cambiar':	break;									
					case '@cargar':		$result_p = Programa::getInstance()->get_programa_by_id($idPrograma);
										$programa = mysqli_fetch_array($result_p);					
										$respuesta['idPrograma'][] = $programa['idPrograma'];
										$respuesta['nombrePrograma'][] = utf8_encode($programa['nombre']);
										$respuesta['contrato'][] = utf8_encode($programa['contrato']);
										$respuesta['direccion'][] = utf8_encode($programa['direccion']);											
										$respuesta['inicFactura'][] = $programa['iniciales'];											
										$respuesta['tipoFactura'][] = utf8_encode($programa['descripcion']);	
										$result_f = Factura::getInstance()->get_item($idFactura);	
										while ($row = mysqli_fetch_array($result_f)){
											$respuesta['referencia'][] = $row['referencia'];
											$respuesta['descripcion'][] = utf8_encode($row['descripcion']);
											$respuesta['cantidad'][] = $row['cantidad'];
											$respuesta['valor'][] = $row['valor'];
										}		
										break;				
					case '@eliminar':	break;														
					default:			$result_f = Factura::getInstance()->get_item($idFactura);	
										while ($row = mysqli_fetch_array($result_f)){
											$respuesta['referencia'][] = $row['referencia'];
											$respuesta['descripcion'][] = utf8_encode($row['descripcion']);
											$respuesta['cantidad'][] = $row['cantidad'];
											$respuesta['valor'][] = $row['valor'];
										}							
										break;
				}
			}
			mysqli_free_result($result);
		}		
		$respuesta['consulta'] = $consulta;		
	}	
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 