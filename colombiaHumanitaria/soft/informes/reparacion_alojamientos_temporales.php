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
		date_default_timezone_set('America/Bogota'); 
		$fecha = date('d/m/Y');
		
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

		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)			
					->setCellValue('K1', 'Código: F-COLHUM-002')
					->setCellValue('K2', 'Fecha: 2011-02-21')
					->setCellValue('K3', 'Versión: 01')
					->setCellValue('A4', 'FORMATO DE SEGUIMIENTO A ENTREGAS DE AYUDAS')
					->setCellValue('B6', 'DEPARTAMENTO/CIUDAD CAPITAL')
					->setCellValue('B8', 'NOMBRE ENTIDAD OPERADORA')
					->setCellValue('B11', 'INTERVENTORIA')
					->setCellValue('C11', 'SI ( X )   /   No  (   ) ')			
					->setCellValue('F6', 'NORTE DE SANTANDER / CÚCUTA')			
					->setCellValue('F8', 'CORPRODINCO')
					->setCellValue('F11', 'Entidad Interventora:  ')
					->setCellValue('J6', 'SOLICITUD No.')
					->setCellValue('J8', 'Contrato No.')
					->setCellValue('J11', 'Entrega No.')
					->setCellValue('J13', 'Fecha de Entrega')
					->setCellValue('L13', $fecha)
					->setCellValue('E13', 'P:  Programado')
					->setCellValue('E14', 'A:  Atendido');
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
		$objPHPExcel->getActiveSheet()->mergeCells('F6:H6');
		$objPHPExcel->getActiveSheet()->mergeCells('F8:H9');
		$objPHPExcel->getActiveSheet()->mergeCells('F11:H11');			
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(51);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);			
		
		$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(21);
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('17')->setRowHeight(51);
		
		//negrita
		$objPHPExcel->getActiveSheet()->getStyle('A1:L17')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->getStyle('R13')->getFont()->setBold(false);
		
		//alinear			
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('L13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//borde negro
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('F6:H6')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F8:H9')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F11:H11')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('E13:F14')->applyFromArray($styleThinBlackBorderOutline);
					
		$objPHPExcel->getActiveSheet()->getStyle('A1:L15')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		
		$objPHPExcel->getActiveSheet()->getStyle('L6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
			
		//borde gris
		$styleThickGrisBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('rgb' => 'C0C0C0'),
				),
			),
		);			
		$objPHPExcel->getActiveSheet()->getStyle('L6')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('L8')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('L11')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('L13')->applyFromArray($styleThickGrisBorderOutline);
											
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A16', 'Municipios')
					->setCellValue('A17', 'No.')
					->setCellValue('B17', 'Nombre')
					->setCellValue('C16', 'No. Total de Familias Beneficiadas')
					->setCellValue('D16', 'No. Total Personas Beneficiadas')
					->setCellValue('F16', 'NUMERO DE FAMILIAS BENEFICIADAS')
					->setCellValue('F17', 'No. Familias que requieren Albergues')			
					->setCellValue('G17', 'No. Familias que requieren arriendo')
					->setCellValue('H17', 'No. Familias que requieren Reparación')
					->setCellValue('I17', 'No. Reparaciones entregadas')
					->setCellValue('J16', 'Valor de las Reparaciones Entregados')
					->setCellValue('J17', 'Valor Albergues Entregados')
					->setCellValue('K17', 'Valor Arriendos Entregados')
					->setCellValue('L17', 'Valor Reparaciones Entregadas');	
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A16:B16');
		$objPHPExcel->getActiveSheet()->mergeCells('C16:C17');
		$objPHPExcel->getActiveSheet()->mergeCells('D16:D17');
		$objPHPExcel->getActiveSheet()->mergeCells('E16:E17');
		$objPHPExcel->getActiveSheet()->mergeCells('F16:I16');
		$objPHPExcel->getActiveSheet()->mergeCells('J16:L16');
		
		//alinear
		$objPHPExcel->getActiveSheet()->getStyle('A16:L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A16:L17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);		
		$objPHPExcel->getActiveSheet()->getStyle('E16')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
				
		$numeracion = 0; 		
		$fila = 16;
		$fila_2 = 17;
		
		$result = Humanitaria::getInstance()->get_reparaciones_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$idDamnificado = $info['id_damnificado'];	
			
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);			
			if(mysqli_num_rows($resultDamnificado) != 0){					
				$damnificado = mysqli_fetch_array($resultDamnificado);			
				$nombreDamnificado = utf8_encode($damnificado['primer_nombre']);
				if($damnificado['segundo_nombre'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_nombre']);
				if($damnificado['primer_apellido'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['primer_apellido']);
				if($damnificado['segundo_apellido'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_apellido']);	
			}
			mysqli_free_result($resultDamnificado);	
				
			$numeracion ++;			
			$fila = $fila + 2;	
			$fila_2 = $fila_2 + 2;		
			
			$contReparacion = 0;
			$resultReparacion = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);				
			if(mysqli_num_rows($resultReparacion) != 0){
				$reparacion = mysqli_fetch_array($resultReparacion);			
				if($reparacion['fecha_reparacion'] != '0000-00-00')				
					$contReparacion = 1;	
			}
			mysqli_free_result($resultReparacion);	
				
			$valor = $contReparacion * 2100000;	
						
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("A".$fila, $numeracion)
						->setCellValue("B".$fila, $nombreDamnificado)
						->setCellValue("C".$fila_2, "1")
						->setCellValue("E".$fila, "P")
						->setCellValue("E".$fila_2, "A")
						->setCellValue("H".$fila_2, "1")			
						->setCellValue("I".$fila_2, $contReparacion)	
						->setCellValue("L".$fila_2, $valor);			
			
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':A'.$fila_2);
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$fila.':B'.$fila_2);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
					
			$objPHPExcel->getActiveSheet()->getStyle('E'.$fila.':L'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');			
		}
		mysqli_free_result($result);
				
		$objPHPExcel->getActiveSheet()->getStyle('A16:L'.$fila_2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$contador = $fila_2+1;
		if($fila_2 >= 18){
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$contador, '=SUM(C18:C'.$fila_2.')');		
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$contador, '=SUM(I18:I'.$fila_2.')');
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$contador, '=SUM(L18:L'.$fila_2.')');
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
		$objPHPExcel->getActiveSheet()->getStyle('I'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);		
		$objPHPExcel->getActiveSheet()->getStyle('I'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		
		$objPHPExcel->getActiveSheet()->getStyle('L18:L'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
			
		$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$contador)->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(16);
		
		$objPHPExcel->getActiveSheet()->getStyle('E18:E'.$contador)->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->getStyle('A16:L17')->getAlignment()->setWrapText(true);
			
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle("Alojamientos_Temporales");
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="CF-CH-002-Alojamientos_Temporales_RV.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>				
