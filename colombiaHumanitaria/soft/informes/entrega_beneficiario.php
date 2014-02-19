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
					->setCellValue('B2', 'REGISTRO DE ENTREGA A BENEFICIARIOS')
					->setCellValue('B5', 'DEPARTAMENTO/CIUDAD CAPITAL')
					->setCellValue('B7', 'NOMBRE ENTIDAD OPERADORA')
					->setCellValue('B10', 'MUNICIPIO ATENDIDO')
					->setCellValue('P1', 'Código: F-COLHUM-003')
					->setCellValue('P2', 'Fecha: 2011-02-21')
					->setCellValue('P3', 'Versión: 01')
					->setCellValue('F5', 'NORTE DE SANTANDER / CÚCUTA')			
					->setCellValue('F7', 'CORPRODINCO')
					->setCellValue('F10', 'NORTE DE SANTANDER')
					->setCellValue('N5', 'SOLICITUD No.')
					->setCellValue('N7', 'Contrato No.')
					->setCellValue('N10', 'Entrega No.')
					->setCellValue('N12', 'Fecha de Entrega')
					->setCellValue('Q12', '('.$fecha.')');	
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('F5:H5');
		$objPHPExcel->getActiveSheet()->mergeCells('F7:H8');
		$objPHPExcel->getActiveSheet()->mergeCells('F10:H10');
		$objPHPExcel->getActiveSheet()->mergeCells('Q5:R5');
		$objPHPExcel->getActiveSheet()->mergeCells('Q7:R7');
		$objPHPExcel->getActiveSheet()->mergeCells('Q10:R10');
		$objPHPExcel->getActiveSheet()->mergeCells('Q12:R12');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(23);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(9);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(11);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('14')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(28);
		$objPHPExcel->getActiveSheet()->getRowDimension('16')->setRowHeight(18);
		
		//negrita
		$objPHPExcel->getActiveSheet()->getStyle('A1:R16')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('Q12')->getFont()->setBold(false);
		
		//alinear
		$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('Q12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//borde negro
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('F5:H5')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F7:H8')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F10:H10')->applyFromArray($styleThinBlackBorderOutline);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:R14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);		
			
		//borde gris
		$styleThickGrisBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('rgb' => 'C0C0C0'),
				),
			),
		);			
		$objPHPExcel->getActiveSheet()->getStyle('Q5:R5')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('Q7:R7')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('Q10:R10')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('Q12:R12')->applyFromArray($styleThickGrisBorderOutline);
											
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A15', 'Consecutivo')
					->setCellValue('B15', 'Tipo de Identificación')
					->setCellValue('D15', 'Número de Identificación')
					->setCellValue('E15', 'Primer Apellido')
					->setCellValue('F15', 'Segundo Apellido')
					->setCellValue('G15', 'Primer Nombre')
					->setCellValue('H15', 'Segundo Nombre')
					->setCellValue('I15', 'Departamento de residencia')
					->setCellValue('J15', 'Municipio de residencia')
					->setCellValue('K15', 'Dirección / Nombre de la Finca')
					->setCellValue('L15', 'Teléfono')
					->setCellValue('M15', 'Correo Electrónico')
					->setCellValue('N15', 'Ayudas Entregadas')
					->setCellValue('N16', 'Mercados')
					->setCellValue('O16', 'Aseo')
					->setCellValue('P16', 'Albergue')
					->setCellValue('Q16', 'Arriendo')
					->setCellValue('R16', 'Reparación');	
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A15:A16');
		$objPHPExcel->getActiveSheet()->mergeCells('B15:B16');
		$objPHPExcel->getActiveSheet()->mergeCells('C15:C16');
		$objPHPExcel->getActiveSheet()->mergeCells('D15:D16');
		$objPHPExcel->getActiveSheet()->mergeCells('E15:E16');
		$objPHPExcel->getActiveSheet()->mergeCells('F15:F16');
		$objPHPExcel->getActiveSheet()->mergeCells('G15:G16');
		$objPHPExcel->getActiveSheet()->mergeCells('H15:H16');
		$objPHPExcel->getActiveSheet()->mergeCells('I15:I16');
		$objPHPExcel->getActiveSheet()->mergeCells('J15:J16');
		$objPHPExcel->getActiveSheet()->mergeCells('K15:K16');			
		$objPHPExcel->getActiveSheet()->mergeCells('L15:L16');
		$objPHPExcel->getActiveSheet()->mergeCells('M15:M16');
		$objPHPExcel->getActiveSheet()->mergeCells('N15:R15');
		
		//alinear
		$objPHPExcel->getActiveSheet()->getStyle('A15:R16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A15:R16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A15:R16')->getAlignment()->setWrapText(true);
				
		$numeracion = 0; 
		$fila = 16;
					
		$result = Humanitaria::getInstance()->get_entregas_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$idDamnificado = $info['id_damnificado'];
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
			
			if(mysqli_num_rows($resultDamnificado) != 0){				
				$numeracion ++;
				$fila = $numeracion + 16;	
				
				$damnificado = mysqli_fetch_array($resultDamnificado);	
				$primerNombre = utf8_encode($damnificado['primer_nombre']);
				$segundoNombre = utf8_encode($damnificado['segundo_nombre']);
				$primerApellido = utf8_encode($damnificado['primer_apellido']);
				$segundoApellido = utf8_encode($damnificado['segundo_apellido']);	
				$td = $damnificado['td'];
				switch($td){
					case 1:	$td = "CC";
							break;
					case 2: $td = "TI";
							break;
					default:$td = "";
							break;		
				}
				$documentoDamnificado = $damnificado['documento_damnificado'];				
				$telefonoDamnificado = $damnificado['telefono'];
				$direccionDamnificado = utf8_encode($damnificado['direccion']);
				$barrioDamnificado = utf8_encode($damnificado['barrio']);	
				
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A".$fila, $numeracion)
							->setCellValue("B".$fila, $td)					
							->setCellValue("D".$fila, $documentoDamnificado)
							->setCellValue("E".$fila, $primerApellido)
							->setCellValue("F".$fila, $segundoApellido)
							->setCellValue("G".$fila, $primerNombre)
							->setCellValue("H".$fila, $segundoNombre)
							->setCellValue("I".$fila, 'Norte de Santander')
							->setCellValue("J".$fila, 'Cúcuta')
							->setCellValue("K".$fila, $direccionDamnificado)
							->setCellValue("L".$fila, $telefonoDamnificado);	
							
							
				$resultArriendo = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultArriendo) != 0){
					$arriendo = mysqli_fetch_array($resultArriendo);
					$contArriendo = 0;
					if($arriendo['fecha_arriendo'] != '0000-00-00')
						$contArriendo = 1;					
					
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("Q".$fila, $contArriendo);
				}				
							
				$resultEntregas = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
				if(mysqli_num_rows($resultEntregas) != 0){				
					$entregas = mysqli_fetch_array($resultEntregas);
					$contKitAseo = 0;
					if($entregas['fecha_kit_aseo'] != '0000-00-00')
						$contKitAseo = 1;
					
					$contMercados = 0;
					if($entregas['fecha_mercado1'] != '0000-00-00')
						$contMercados ++;		
					if($entregas['fecha_mercado2'] != '0000-00-00')
						$contMercados ++;			
					if($entregas['fecha_mercado3'] != '0000-00-00')
						$contMercados ++;			
					if($entregas['fecha_mercado4'] != '0000-00-00')
						$contMercados ++;
						
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("N".$fila, $contMercados)
								->setCellValue("O".$fila, $contKitAseo);												
				}
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
				$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				$objPHPExcel->getActiveSheet()->getStyle('N'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('O'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('Q'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
			}
		}
			
		$objPHPExcel->getActiveSheet()->getStyle('A15:R'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$contador = $fila+1;
		if($fila >= 17){
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$contador, '=SUM(N17:N'.$fila.')');
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$contador, '=SUM(O17:O'.$fila.')');
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$contador, '=SUM(Q17:Q'.$fila.')');
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('N'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle('N'.$contador)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$contador)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('Q'.$contador)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('N'.$contador.':Q'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		
		$objPHPExcel->getActiveSheet()->getStyle('A15:R'.$contador)->getFont()->setSize(10);
				
		//$objPHPExcel->getActiveSheet()->setAutoFilter('A15:R'.$fila);
			
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle("F-CD-003-ENTREGA_A_BENEFICIARIO");
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client's web browser (Excel2007)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="F-CD-003-ENTREGA_A_BENEFICIARIO.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>	