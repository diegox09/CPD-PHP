<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');
	
	session_start();
		
	require_once('../../facturaEquivalente/x09/classes/User.php');
	require_once('../../facturaEquivalente/x09/classes/Factura.php');	
	require_once('../../facturaEquivalente/x09/classes/Cliente.php');	
	require_once('../../facturaEquivalente/x09/classes/Programa.php');
	require_once('../php/funciones/funciones.php');
	
	$logonSuccess = false;
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;		
	}
	
	if($logonSuccess){		
		$fecha_inicial = explota($_GET['fecha_inicial']);
		$fecha_final = explota($_GET['fecha_final']);
		//$programa = ($_GET['programa']);
		$programa = 59;
		
		error_reporting(E_ALL);
		require_once '../../php/phpexcel/PHPExcel.php';
		require_once '../../php/phpexcel/PHPExcel/IOFactory.php';
		
		//56	MCR 23 CONT 123/11	
		//59	CONTRATO 153 UNIDOS
		
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
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'ID')
					->setCellValue('B1', 'PROGRAMA')
					->setCellValue('C1', 'TIPO FACTURA')            
					->setCellValue('D1', 'MUNICIPIO')
					->setCellValue('E1', 'CONSECUTIVO')
					->setCellValue('F1', 'FECHA')
					->setCellValue('G1', 'NIT/C.C.')
					->setCellValue('H1', 'A FAVOR DE')					
					->setCellValue('I1', 'SUBTOTAL')
					->setCellValue('J1', 'IVA')
					->setCellValue('K1', 'VALOR IVA')
					->setCellValue('L1', 'RETENCION IVA')
					->setCellValue('M1', 'VALOR RETENCION IVA')
					->setCellValue('N1', 'RETENCION FUENTE')
					->setCellValue('O1', 'VALOR RETENCION FUENTE')
					->setCellValue('P1', 'RETENCION ICA')
					->setCellValue('Q1', 'VALOR RETENCION ICA')
					->setCellValue('R1', 'ESTADO')
					->setCellValue('S1', 'TOTAL')
					->setCellValue('T1', 'REF')
					->setCellValue('U1', 'DESCRIPCION')
					->setCellValue('V1', 'CANTIDAD')
					->setCellValue('W1', 'VALOR UNITARIO')
					->setCellValue('X1', 'VALOR PARCIAL')
					->setCellValue('Y1', 'REF')
					->setCellValue('Z1', 'DESCRIPCION')
					->setCellValue('AA1', 'CANTIDAD')
					->setCellValue('AB1', 'VALOR UNITARIO')
					->setCellValue('AC1', 'VALOR PARCIAL')
					->setCellValue('AD1', 'REF')
					->setCellValue('AE1', 'DESCRIPCION')
					->setCellValue('AF1', 'CANTIDAD')
					->setCellValue('AG1', 'VALOR UNITARIO')
					->setCellValue('AH1', 'VALOR PARCIAL')
					->setCellValue('AI1', 'REF')
					->setCellValue('AJ1', 'DESCRIPCION')
					->setCellValue('AK1', 'CANTIDAD')
					->setCellValue('AL1', 'VALOR UNITARIO')
					->setCellValue('AM1', 'VALOR PARCIAL')
					->setCellValue('AN1', 'REF')
					->setCellValue('AO1', 'DESCRIPCION')
					->setCellValue('AP1', 'CANTIDAD')
					->setCellValue('AQ1', 'VALOR UNITARIO')
					->setCellValue('AR1', 'VALOR PARCIAL')
					->setCellValue('AS1', 'REF')
					->setCellValue('AT1', 'DESCRIPCION')
					->setCellValue('AU1', 'CANTIDAD')
					->setCellValue('AV1', 'VALOR UNITARIO')
					->setCellValue('AW1', 'VALOR PARCIAL')
					->setCellValue('AX1', 'REF')
					->setCellValue('AY1', 'DESCRIPCION')
					->setCellValue('AZ1', 'CANTIDAD')
					->setCellValue('BA1', 'VALOR UNITARIO')
					->setCellValue('BB1', 'VALOR PARCIAL')
					->setCellValue('BC1', 'REF')
					->setCellValue('BD1', 'DESCRIPCION')
					->setCellValue('BE1', 'CANTIDAD')
					->setCellValue('BF1', 'VALOR UNITARIO')
					->setCellValue('BG1', 'VALOR PARCIAL')
					->setCellValue('BH1', 'REF')
					->setCellValue('BI1', 'DESCRIPCION')
					->setCellValue('BJ1', 'CANTIDAD')
					->setCellValue('BK1', 'VALOR UNITARIO')
					->setCellValue('BL1', 'VALOR PARCIAL');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:BL1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:BL1')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:BL1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:BL1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA07A');
		$objPHPExcel->getActiveSheet()->getStyle('T1:BL1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFD2DA5C');
				
		$objPHPExcel->getActiveSheet()->freezePane('A2');		
		
		$fila = 1;
		$iniciales = array('FE' => 'No.','CM' => 'CM');
		$tipoFactura = array('', 'Factura Equivalente', 'Caja Menor');
		
		$result = Factura::getInstance()->get_factura_by_programa($programa);			
		while ($factura = mysqli_fetch_array($result)){	
			$fila ++;
						
			$idFactura = $factura['idFactura'];
			$consecutivo = $factura['numeroFactura'];
					
			$idPrograma = $factura['idPrograma'];
			$programa = mysqli_fetch_array(Programa::getInstance()->get_programa_by_id($idPrograma));
			$descripcionPrograma = $programa['contrato'];
			$inic = $programa['iniciales'];
			$tipo = explode(' ', $programa['descripcion']);
							
			$ciudad = mb_strtoupper($factura['ciudad']);
			$fecha_fe = implota($factura['fecha']);
			
			$idCliente = $factura['idCliente'];				
			$cliente = mysqli_fetch_array(Cliente::getInstance()->get_cliente_by_id($idCliente));
			$nit = $cliente['nit'];
			$nombreTercero = mb_strtoupper($cliente['nombres']);	
			$actividadEconomica = $cliente['actividadEconomica'];
			$direccionTercero = mb_strtoupper($cliente['direccion']);
				
			$tarifaIva = $factura['tarifaIva'];
			$tarifaRetencionIva = $factura['tarifaRetencionIva'];
			$retencionFuente = $factura['retencionFuente'];
			$impuestoRenta = $factura['impuestoRenta'];
			$retencionIca = $factura['retencionIca'];
			$estadoFactura = $factura['idEstadoFactura'];				
			
			$referencia = array();
			$descripcion = array();
			$cantidad = array();
			$valor = array();
			$valor_p = array();
			$cantidad_fe = array();
			$valor_fe = array();		
			$result_f = Factura::getInstance()->get_item($idFactura);	
			$i = 0;
			while ($row = mysqli_fetch_array($result_f)){
				$referencia[$i] = $row['referencia'];
				$descripcion[$i] = mb_strtoupper($row['descripcion']);
				
				$cantidad_fe[$i] = $row['cantidad'];
				switch($row['cantidad']){
					case -1:	$row['cantidad'] = 'GL';
								$cantidad_fe[$i] = 1;
								break;
					case 0:		$row['cantidad'] = '';
								break;
				}
				
				$valor_fe[$i] = $row['valor'];
				switch($row['valor']){
					case 0:		$row['valor'] = '';
								break;
					default: 	//$row['valor'] = '$ '.number_format($row['valor'],0,',','.');
								break;			
				}	
					
				$cantidad[$i] = $row['cantidad'];
				$valor[$i] = $row['valor'];
				$i++;
			}
									
			$valor_parcial = '';		
			$subtotal = 0;
			$valor_iva = '';
			$valor_reteiva = '';
			$valor_retefuente = '';
			$valor_reteica = '';
			$total = '';
						
			for($i=0; $i<9; $i++){
				/*$pdf->Cell(20,5,$referencia[$i],1,0,'C');
				$pdf->Cell(88,5,$descripcion[$i],1,0,'L');
				$pdf->Cell(20,5,$cantidad[$i],1,0,'C');		
				$pdf->Cell(24,5,$valor[$i],1,0,'R');*/
				$valor_parcial = '';
				if($cantidad_fe[$i] != '0' && $cantidad_fe[$i] != '0'){
					$valor_parcial = $valor_fe[$i] * $cantidad_fe[$i];					
					$subtotal = $subtotal + $valor_parcial;
					/*
					if($valor_parcial != 0)
						$valor_parcial = '$ '.number_format($valor_parcial,0,',','.');
					else	
						$valor_parcial = '';	
					*/	
					//$valor[$i] = '$ '.number_format($valor[$i],0,',','.');					
				}
				$valor_p[$i] = $valor_parcial;
				//$pdf->Cell(24,5,$valor_parcial,1,1,'R');
			}
					
			if($tarifaIva == '0.0')
				$valor_iva = 0;
			else
				$valor_iva = $subtotal * ($tarifaIva / 100);
				
			if($tarifaRetencionIva == '0.0')
				$valor_reteiva = 0;
			else
				$valor_reteiva = $valor_iva * ($tarifaRetencionIva / 100);
			
			if($retencionFuente == '0.0')
				$valor_retefuente = $impuestoRenta;
			else
				$valor_retefuente = $subtotal * ($retencionFuente / 100);
			
			if($retencionIca == '')
				$valor_reteica = 0; 
			else{	
				$reteica = explode('*', $retencionIca);
				if(count($reteica) == 2){	
					$valor1 = $reteica[0];
					$valor2 = $reteica[1];							
					$valor_reteica = ($reteica[0] / $reteica[1]) * $subtotal;
				}
				else
					$valor_reteica = 0;
			}	
			
			$total = ($subtotal - ($valor_retefuente + $valor_reteica));
			/*
			$subtotal = '$ '.number_format($subtotal,0,',','.');	
			$tarifaIva = number_format($tarifaIva,1,',','.').'%';
			$valor_iva = '$ '.number_format($valor_iva,0,',','.');				
			$tarifaRetencionIva = number_format($tarifaRetencionIva,1,',','.').'%';
			$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');			
			$retencionFuente = number_format($retencionFuente,1,',','.').'%';
			$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');			
			$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
			$total = '$ '.number_format($total,0,',','.');	
			
			if($subtotal != '0'){			
				$subtotal = '$ '.number_format($subtotal,0,',','.');
				$tarifaIva = number_format($tarifaIva,1,',','.').'%';
				$valor_iva = '$ '.number_format($valor_iva,0,',','.');	
				$tarifaRetencionIva = number_format($tarifaRetencionIva,1,',','.').'%';
				$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');	
				$retencionFuente = number_format($retencionFuente,1,',','.').'%';
				$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');
				$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
				$total = '$ '.number_format($total,0,',','.');
			}
			else{
				$subtotal = '';	
				$tarifaIva = '';
				$valor_iva = '';	
				$tarifaRetencionIva = '';	
				$valor_reteiva = '';	
				$retencionFuente = '';
				$valor_retefuente = '';	
				$valor_reteica = '';
				$total = '';
			}	
			*/			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("A".$fila, $idFactura)
						->setCellValue("B".$fila, $descripcionPrograma)	
						->setCellValue("C".$fila, $inic)
						->setCellValue("D".$fila, $ciudad)
						->setCellValue("E".$fila, $consecutivo)
						->setCellValue("F".$fila, $fecha_fe)
						->setCellValue("G".$fila, $nit)
						->setCellValue("H".$fila, $nombreTercero)											
						->setCellValue("I".$fila, $subtotal)
						->setCellValue("J".$fila, $tarifaIva)
						->setCellValue("K".$fila, $valor_iva)
						->setCellValue("L".$fila, $tarifaRetencionIva)
						->setCellValue("M".$fila, $valor_reteiva)
						->setCellValue("N".$fila, $retencionFuente)
						->setCellValue("O".$fila, $valor_retefuente)
						->setCellValue("P".$fila, $retencionIca)
						->setCellValue("Q".$fila, $valor_reteica)
						->setCellValue("R".$fila, $estadoFactura)												
						->setCellValue("S".$fila, $total);
						
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("T".$fila, $referencia[0])
						->setCellValue("U".$fila, $descripcion[0])	
						->setCellValue("V".$fila, $cantidad[0])
						->setCellValue("W".$fila, $valor[0])
						->setCellValue("X".$fila, $valor_p[0])
						->setCellValue("Y".$fila, $referencia[1])
						->setCellValue("Z".$fila, $descripcion[1])	
						->setCellValue("AA".$fila, $cantidad[1])
						->setCellValue("AB".$fila, $valor[1])
						->setCellValue("AC".$fila, $valor_p[1])
						->setCellValue("AD".$fila, $referencia[2])
						->setCellValue("AE".$fila, $descripcion[2])	
						->setCellValue("AF".$fila, $cantidad[2])
						->setCellValue("AG".$fila, $valor[2])
						->setCellValue("AH".$fila, $valor_p[2])
						->setCellValue("AI".$fila, $referencia[3])
						->setCellValue("AJ".$fila, $descripcion[3])	
						->setCellValue("AK".$fila, $cantidad[3])
						->setCellValue("AL".$fila, $valor[3])
						->setCellValue("AM".$fila, $valor_p[3])
						->setCellValue("AN".$fila, $referencia[4])
						->setCellValue("AO".$fila, $descripcion[4])	
						->setCellValue("AP".$fila, $cantidad[4])
						->setCellValue("AQ".$fila, $valor[4])
						->setCellValue("AR".$fila, $valor_p[4])
						->setCellValue("AS".$fila, $referencia[5])
						->setCellValue("AT".$fila, $descripcion[5])	
						->setCellValue("AU".$fila, $cantidad[5])
						->setCellValue("AV".$fila, $valor[5])
						->setCellValue("AW".$fila, $valor_p[5])
						->setCellValue("AX".$fila, $referencia[6])
						->setCellValue("AY".$fila, $descripcion[6])	
						->setCellValue("AZ".$fila, $cantidad[6])
						->setCellValue("BA".$fila, $valor[6])
						->setCellValue("BB".$fila, $valor_p[6])
						->setCellValue("BC".$fila, $referencia[7])
						->setCellValue("BD".$fila, $descripcion[7])	
						->setCellValue("BE".$fila, $cantidad[7])
						->setCellValue("BF".$fila, $valor[7])
						->setCellValue("BG".$fila, $valor_p[7])
						->setCellValue("BH".$fila, $referencia[8])
						->setCellValue("BI".$fila, $descripcion[8])	
						->setCellValue("BJ".$fila, $cantidad[8])
						->setCellValue("BK".$fila, $valor[8])
						->setCellValue("BL".$fila, $valor_p[8]);			
		}
		mysqli_free_result($result);				
												
		$objPHPExcel->getActiveSheet()->getStyle('A1:BL'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('E2:F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('G2:G'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('M2:S'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
													
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
	}
	else
		header("Location: ../");
?>	