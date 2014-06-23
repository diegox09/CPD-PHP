<?php
	require_once('classes/User.php');	
	require_once('classes/Cliente.php');
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
		$quitar = array('$' => '', ' ' => '', ',' => '');
		
		$numeroFactura = $_GET['numero_factura'];
		$ciudad = strtoupper(utf8_decode($_GET['ciudad']));	
		$fecha = $_GET['fecha'];		
		$idCliente = $_GET['id_persona'];
		$nit = $_GET['nit_persona'];
		$nombres = strtoupper(utf8_decode($_GET['persona_natural']));
		$telefono = $_GET['telefono'];
		$direccion = strtoupper(utf8_decode($_GET['direccion_persona']));		
		$descripcion = strtoupper(nl2br(utf8_decode(str_replace("<BR />", "", $_GET['descripcion']))));
		$valor = strtr($_GET['total'], $quitar);
		$tarifaIva = $_GET['tarifa_iva'];
		$observaciones = strtoupper(utf8_decode($_GET['observaciones']));
		//Actualizacion
		$descripcionValor = strtoupper(nl2br(utf8_decode(str_replace("<BR />", "", $_GET['descripcion_valor']))));
		$subtotal = strtr($_GET['subtotal_factura'], $quitar);
		$valorIva = strtr($_GET['iva_factura'], $quitar);
		$facturaManual = $_GET['factura_manual'];
				
		$idUser = $_SESSION['id_f'];
		$idEstadoFactura = $_GET['estado_factura'];
		if($idEstadoFactura != '2')
			$idEstadoFactura = '1';				
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');	
		
		if($idCliente != '')
			$consulta = Cliente::getInstance()->update_cliente($idCliente, $nit, $nombres, $telefono, $direccion);
		else{
			if($nit != '')
				$consulta = Cliente::getInstance()->insert_nit_cliente($nit);										
		}
		
		$cliente = mysqli_fetch_array(Cliente::getInstance()->get_cliente_by_nit($nit));
		$idCliente = $cliente['idCliente'];
		
		$error = false;	
		if($numeroFactura == ''){	
			$fecha = date('Y-m-d');	
			$numero = mysqli_fetch_array(Factura::getInstance()->set_numero());			
			if($numero[0] == NULL)
				$numeroFactura = Factura::getInstance()->get_min_factura();	
			else{			
				$numeroFactura = ++$numero[0];
				if($numeroFactura > Factura::getInstance()->get_max_factura())
					$error = true;	
			}
			
			if(!$error)			
				$consulta = Factura::getInstance()->insert_factura($numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $nit, $nombres, $telefono, $direccion, $idUser, $idEstadoFactura, $descripcion, $valor, $tarifaIva, $observaciones, $descripcionValor, $subtotal, $valorIva, $facturaManual);
			else
				$consulta = false;	
		}	
		else{
			$consulta = Factura::getInstance()->update_factura($numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $nit, $nombres, $telefono, $direccion, $idUser, $idEstadoFactura, $descripcion, $valor, $tarifaIva, $observaciones, $descripcionValor, $subtotal, $valorIva, $facturaManual);
		}
		
		if($consulta){
			$result = Factura::getInstance()->get_factura($numeroFactura);			
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
			else{	
				$factura = mysqli_fetch_array($result);
				$idFactura = $factura['idFactura'];	
				$numeroFactura = $factura['numeroFactura'];
				$ciudad = utf8_encode($factura['ciudad']);
				$fecha = $factura['fecha'];
				$idCliente = $factura['idCliente'];
				$nitCliente = $factura['nit'];
				$nombreCliente = utf8_encode($factura['nombres']);
				$telefonoCliente = $factura['telefono'];
				$direccionCliente = utf8_encode($factura['direccion']);				
				$descripcion = utf8_encode($factura['descripcion']);
				$valor = $factura['valor'];
				$tarifaIva = $factura['tarifaIva'];
				$observaciones = utf8_encode($factura['observaciones']);
				$estadoFactura = $factura['idEstadoFactura'];						
				$fechaActualizacion = $factura['fechaActualizacion'];
				$idUser = $factura['idUser'];	

				$descripcionValor = utf8_encode($factura['descripcionValor']);
				$subtotal = $factura['subtotal'];
				$valorIva = $factura['valorIva'];
				$facturaManual = $factura['facturaManual'];
				
				$respuesta['numeroFactura'] = $numeroFactura;
				$respuesta['ciudad'] = $ciudad;
				$respuesta['fecha'] = $fecha;
				$respuesta['idCliente'] = $idCliente;
				$respuesta['nitCliente'] = $nitCliente;
				$respuesta['nombreCliente'] = $nombreCliente; 
				$respuesta['telefonoCliente'] = $telefonoCliente;
				$respuesta['direccionCliente'] = $direccionCliente;
				$respuesta['descripcion'] = $descripcion;
				$respuesta['valor'] = $valor;
				$respuesta['tarifaIva'] = $tarifaIva;
				$respuesta['observaciones'] = $observaciones;
				$respuesta['estadoFactura'] = $estadoFactura;
				$respuesta['fechaActualizacion'] = $fechaActualizacion;

				$respuesta['descripcionValor'] = $descripcionValor;
				$respuesta['subtotal'] = $subtotal;
				$respuesta['valorIva'] = $valorIva;
				$respuesta['facturaManual'] = $facturaManual;
				
				/*
				//Factura txt
				#Abrimos el fichero en modo de escritura 
				$fechaFichero = date('_d.m.Y');
				$fichero = fopen('../backup/txt/Factura_'.$numeroFactura.$fechaFichero.'.txt','w');
				#Escribimos en el fichero
				fputs($fichero,'Id Factura: '.$idFactura.chr(13).chr(10));
				fputs($fichero,'Numero Factura: '.$numeroFactura.chr(13).chr(10));
				fputs($fichero,'Ciudad: '.$ciudad.chr(13).chr(10));	
				fputs($fichero,'Fecha: '.$fecha.chr(13).chr(10));				
				fputs($fichero,'Id Cliente: '.$idCliente.chr(13).chr(10));
				fputs($fichero,'Nit Cliente: '.$nitCliente.chr(13).chr(10));
				fputs($fichero,'Nombre Cliente: '.$nombreCliente.chr(13).chr(10));
				fputs($fichero,'Telefono Cliente: '.$telefonoCliente.chr(13).chr(10));
				fputs($fichero,'Direccion Cliente: '.$direccionCliente.chr(13).chr(10));
				fputs($fichero,'Descripcion: '.$descripcion.chr(13).chr(10));
				fputs($fichero,'Valor: '.$valor.chr(13).chr(10));
				fputs($fichero,'Iva: '.$tarifaIva.chr(13).chr(10));
				fputs($fichero,'Observaciones: '.$observaciones.chr(13).chr(10));
				fputs($fichero,'Estado Factura: '.$estadoFactura.chr(13).chr(10));
				fputs($fichero,'Fecha Actualizacion: '.$fechaActualizacion.chr(13).chr(10));
				#Cerramos el fichero 
				fclose($fichero);				
				*/

				$result = User::getInstance()->get_user_by_id($idUser);				
				$user = mysqli_fetch_array($result);
				$respuesta['nombreUser'] = utf8_encode($user['nombre']);
				
				$respuesta['primeraFactura'] = Factura::getInstance()->get_min_factura();
				$numero = mysqli_fetch_array(Factura::getInstance()->set_numero());	
				$respuesta['ultimaFactura'] = $numero[0];
			}
		}		
		mysqli_free_result($result);
		$respuesta['error'] = $error;	
		$respuesta['consulta'] = $consulta;	
	}			
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 