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
		date_default_timezone_set('America/Bogota'); 
		$fecha = date('Y-m-d');	
		$numero = mysqli_fetch_array(Factura::getInstance()->set_numero());	
		if($numero[0] != NULL)
			$numeroFactura = $numero[0];
		else	
			$numeroFactura = 0;		
		
		if($numeroFactura >= Factura::getInstance()->get_min_factura()){
			$factura = mysqli_fetch_array(Factura::getInstance()->get_factura($numeroFactura));
			$idFactura = $factura['idFactura'];		
			$fechaFactura = $factura['fecha'];						
			$respuesta['idFactura'] = $idFactura;
			$respuesta['fechaFactura'] = $fechaFactura;
		}
		
		$respuesta['fecha'] = $fecha;		
		$respuesta['primeraFactura'] = Factura::getInstance()->get_min_factura();
		$respuesta['ultimaFactura'] = $numeroFactura;	
	}
 	print_r(json_encode($respuesta));
?>