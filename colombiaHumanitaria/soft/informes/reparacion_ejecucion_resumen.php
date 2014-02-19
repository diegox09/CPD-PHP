<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');	
	
	session_start();
		
	require_once('../php/classes/Humanitaria.php');
	require_once('../php/funciones/funciones.php');
	
	$logonSuccess = false;
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
	
	if($logonSuccess){
		$fase = $_GET['fase'];
		$meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
				
		error_reporting(E_ALL);
		require_once '../php/phpexcel/PHPExcel.php';
		require_once '../php/phpexcel/PHPExcel/IOFactory.php';
		
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
							 
		$objPHPExcel->setActiveSheetIndex(0)		
					->setCellValue('B4', 'CORPORACION DE PROFESIONALES PARA EL DESARROLLO INTEGRAL COMUNITARIO - CORPRODINCO')	
					->setCellValue('B5', 'CONTRATO DE MANDATO PARA LA FASE DE ATENCION HUMANITARIA Y REHABILITACION FENOMENO DE LA NIÑA 2010 - 2011.')
					->setCellValue('C7', 'Fecha')	
					->setCellValue('D7', 'Cantidad Reparaciones')
					->setCellValue('E7', 'Valor');	
						
		$objPHPExcel->getActiveSheet()->getStyle('C7:E7')->getAlignment()->setWrapText(true);				
		$objPHPExcel->getActiveSheet()->getStyle('B4:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('C7:E7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');
		
		$objPHPExcel->getActiveSheet()->mergeCells('B4:F4');
		$objPHPExcel->getActiveSheet()->mergeCells('B5:F5');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(31);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(31);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(31);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(30);			
		
		$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);			
		$objPHPExcel->getActiveSheet()->getStyle('C7:E7')->getFont()->setBold(true);	
							 
		$fechas = array();
		$fila = 7;
		$contReparaciones = 0;
		$valor = 0;
		
		$result = Humanitaria::getInstance()->get_fechas_reparaciones_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$fechas[] = $info['fecha_reparacion'];
		}
		mysqli_free_result($result);		
		
		sort($fechas);
		foreach ($fechas as $fecha){
			$fila++;
			
			$resultReparaciones = Humanitaria::getInstance()->get_reparaciones_by_fase_fecha($fase, $fecha);
			$contReparaciones = mysqli_num_rows($resultReparaciones);
			mysqli_free_result($resultReparaciones);
					
			$valor = ($contReparaciones * 2100000);
			
			$fecha_e = array();
			$fecha_e = split("-", $fecha);
			$mes = $fecha_e[1];
			--$mes;
			$fecha_m = $fecha_e[2]." ".$meses[$mes]." ".$fecha_e[0];
			
			$objPHPExcel->getActiveSheet()->setCellValue("C".$fila, $fecha_m);
			$objPHPExcel->getActiveSheet()->setCellValue("D".$fila, $contReparaciones);
			$objPHPExcel->getActiveSheet()->setCellValue("E".$fila, $valor);							
		}
				
		$contador = $fila+20;	
		$objPHPExcel->getActiveSheet()->getStyle('A1:I'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);		
		$objPHPExcel->getActiveSheet()->getStyle('C7:E'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		$objPHPExcel->getActiveSheet()->getStyle('C8:C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
		$contador = $fila+1;	
		if($fila >= 8){
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$contador, '=SUM(D8:D'.$fila.')');	
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$contador, '=SUM(E8:E'.$fila.')');	
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('D'.$contador.':E'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		
		$objPHPExcel->getActiveSheet()->getStyle('D8:D'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$objPHPExcel->getActiveSheet()->getStyle('E8:E'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);	
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo Colombia Humanitaria');
		$objDrawing->setDescription('Logo Colombia Humanitaria');
		$objDrawing->setPath('../img/colombia_humanitaria.jpg');
		$objDrawing->setHeight(70);
		$objDrawing->setCoordinates('B2');
		$objDrawing->setOffsetX(10);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo Corprodinco');
		$objDrawing->setDescription('Logo Corprodinco');
		$objDrawing->setPath('../img/logo_corprodinco.jpg');
		$objDrawing->setHeight(70);
		$objDrawing->setCoordinates('D2');
		$objDrawing->setOffsetX(45);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo Alcaldia de Cucuta');
		$objDrawing->setDescription('Logo Alcaldia de Cucuta');
		$objDrawing->setPath('../img/alcaldia_cucuta_nuevo.jpg');
		$objDrawing->setHeight(70);
		$objDrawing->setCoordinates('E2');
		$objDrawing->setOffsetX(145);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
		$objPHPExcel->getActiveSheet()->setTitle("RESUMEN EJECUCION");
			
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="RESUMEN EJECUCION_RV.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>	