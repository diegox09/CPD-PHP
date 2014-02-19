<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');
		
	require_once('../classes/User.php');	
	require_once('../classes/Factura.php');
	require_once('../classes/Cliente.php');
	require_once('../classes/Programa.php');	
		
	$idPrograma = 41;
	
	error_reporting(E_ALL);
	require_once '../../../php/phpexcel/PHPExcel.php';
	require_once '../../../php/phpexcel/PHPExcel/IOFactory.php';
	require_once('funciones.php');
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();		
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Diego Rodriguez")
								 ->setLastModifiedBy("Diego Rodriguez")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");	
	
	$fila = 0;	
	
	$result = Factura::getInstance()->get_factura_by_programa($idPrograma);			
	while ($factura = mysqli_fetch_array($result)){	
		$fila++;
					
		$idFactura = $factura['idFactura'];			
		$idPrograma = $factura['idPrograma'];
		$numeroFactura = $factura['numeroFactura'];
		$ciudad = utf8_encode($factura['ciudad']);
		$fecha = implota($factura['fecha']);
		$idCliente = $factura['idCliente'];
		$idUser = $factura['idUser'];			
		$tarifaIva = $factura['tarifaIva'];
		$tarifaRetencionIva = $factura['tarifaRetencionIva'];
		$retencionFuente = $factura['retencionFuente'];
		$impuestoRenta = $factura['impuestoRenta'];
		$retencionIca = $factura['retencionIca'];
		$estadoFactura = $factura['idEstadoFactura'];
		$fechaActualizacion = $factura['fechaActualizacion'];
		
		$result_c = Cliente::getInstance()->get_cliente_by_id($idCliente);				
		$cliente = mysqli_fetch_array($result_c);
		$nitCliente = $cliente['nit'];
		$nombreCliente = utf8_encode($cliente['nombres']);	
		$actividadEconomica = $cliente['actividadEconomica'];
		$direccionCliente = utf8_encode($cliente['direccion']);
		
		$result_u = User::getInstance()->get_user_by_id($idUser);				
		$user = mysqli_fetch_array($result_u);
		$nombreUser = utf8_encode($user['nombre']);			
		
		$result_p = Programa::getInstance()->get_programa_by_id($idPrograma);
		$programa = mysqli_fetch_array($result_p);	
		$nombrePrograma = utf8_encode($programa['nombre']);
		$contrato = utf8_encode($programa['contrato']);
		$direccion = utf8_encode($programa['direccion']);											
		$inicFactura = $programa['iniciales'];											
		$tipoFactura = utf8_encode($programa['descripcion']);	
		
		$subtotal = 0;					
		$total = '';
		$result_f = Factura::getInstance()->get_item($idFactura);		
		while ($row = mysqli_fetch_array($result_f)){
			$referencia = $row['referencia'];
			$descripcion = utf8_encode($row['descripcion']);
			$cantidad = $row['cantidad'];
			if($cantidad != ""){
				if($cantidad == "GL")
					$cantidad = 1;
			}
			else
				$cantidad = 0;
				
			$valor = $row['valor'];
			$subtotal = $subtotal + ($valor * $cantidad);
		}
		/*
		if($iva != '0.0')
			$valorIva = $subtotal * ($iva / 100);
			
		if($retencionIva != '0.0')
			$valorRetencionIva = $valorIva * ($retencionIva / 100);
		
		if($retencionFuente != '0.0')
			$valorRetencionFuente = $subtotal * ($retencionFuente / 100);
		
		if($retencionIca != ''){
			$reteica = explode('*', $retencionIca);
			if(count($reteica) == 2){	
				$valor1 = $reteica[0];
				$valor2 = $reteica[1];							
				$valorRetencionIca = ($reteica[0] / $reteica[1]) * $subtotal;
			}
			else
				$valor_reteica = 0;
		}
		
		if($sumarIva == 1)
			$total = ($subtotal + ($valorIva - $valorRetencionIva) - ($valorRetencionFuente + $valorRetencionIca));
		else
			$total = ($subtotal - ($valorRetencionFuente + $valorRetencionIca));
		
		if($subtotal != 0)			
			$subtotal = '$ '.number_format($subtotal,0,',','.');	
		else
			$subtotal = '';				
			
		if($iva != 0)
			$iva = number_format($iva,1,',','.').'%';
		else
			$iva = '';	
			
		if($valorIva != 0)		
			$valorIva = '$ '.number_format($valorIva,0,',','.');				
		else
			$valorIva = '';	
			
		if($retencionIva != 0)	
			$retencionIva = number_format($retencionIva,1,',','.').'%';
		else
			$retencionIva = '';
			
		if($valorRetencionIva != 0)		
			$valorRetencionIva = '$ '.number_format($valorRetencionIva,0,',','.');			
		else	
			$valorRetencionIva = '';
			
		if($retencionFuente != 0)	
			$retencionFuente = number_format($retencionFuente,1,',','.').'%';
		else	
			$retencionFuente = '';
			
		if($valorRetencionFuente != 0)	
			$valorRetencionFuente = '$ '.number_format($valorRetencionFuente,0,',','.');			
		else
			$valorRetencionFuente = '';
			
		if($valorRetencionIca != '' && $valorRetencionIca != 0)	
			$valorRetencionIca = '$ '.number_format($valorRetencionIca,0,',','.');
		else
			$valorRetencionIca = '';
			
		if($total != 0)	 				
			$total = '$ '.number_format($total,0,',','.');
		else 
			$total = '';
		*/							
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A".$fila, $numeroFactura)
					->setCellValue("B".$fila, $fecha)	
					->setCellValue("C".$fila, $nitCliente)
					->setCellValue("D".$fila, $nombreCliente)
					->setCellValue("E".$fila, $subtotal);	
	}
	mysqli_free_result($result);				
	
	// Rename sheet
	$nombre = 'FACTURAS EQUIVALENTES';
	$objPHPExcel->getActiveSheet()->setTitle($nombre);
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	date_default_timezone_set('America/Bogota'); 
	$nombre = "FACTURAS EQUIVALENTES.xlsx";
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$nombre.'"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output'); 
	exit;	
?>	