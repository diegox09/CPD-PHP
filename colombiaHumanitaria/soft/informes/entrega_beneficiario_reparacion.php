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
					->setCellValue('K1', 'Código: F-COLHUM-005')
					->setCellValue('K2', 'Fecha: 2011-02-21')
					->setCellValue('K3', 'Versión: 01')
					->setCellValue('E5', 'NORTE DE SANTANDER / CÚCUTA')			
					->setCellValue('E7', 'CORPRODINCO')
					->setCellValue('E10', 'NORTE DE SANTANDER')
					->setCellValue('J5', 'SOLICITUD No.')
					->setCellValue('J7', 'Contrato No.')
					->setCellValue('J10', 'Entrega No.')
					->setCellValue('J12', 'Fecha de Entrega')
					->setCellValue('K12', '('.$fecha.')');	
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('E5:G5');
		$objPHPExcel->getActiveSheet()->mergeCells('E7:G8');
		$objPHPExcel->getActiveSheet()->mergeCells('E10:G10');
		$objPHPExcel->getActiveSheet()->mergeCells('K5:L5');
		$objPHPExcel->getActiveSheet()->mergeCells('K7:L7');
		$objPHPExcel->getActiveSheet()->mergeCells('K10:L10');
		$objPHPExcel->getActiveSheet()->mergeCells('K12:L12');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('11')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('14')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(28);
		$objPHPExcel->getActiveSheet()->getRowDimension('16')->setRowHeight(18);
		
		//negrita
		$objPHPExcel->getActiveSheet()->getStyle('A1:L16')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('K12')->getFont()->setBold(false);
		
		//alinear
		$objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('K12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//borde negro
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('E5:G5')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('E7:G8')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('E10:G10')->applyFromArray($styleThinBlackBorderOutline);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:L14')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);		
			
		//borde gris
		$styleThickGrisBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('rgb' => 'C0C0C0'),
				),
			),
		);			
		$objPHPExcel->getActiveSheet()->getStyle('K5:L5')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('K7:L7')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('K10:L10')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('K12:L12')->applyFromArray($styleThickGrisBorderOutline);
											
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A15', 'Consecutivo')
					->setCellValue('B15', 'Tipo de Identificación')
					->setCellValue('C15', 'Número de Identificación')
					->setCellValue('D15', 'Primer Apellido')
					->setCellValue('E15', 'Segundo Apellido')
					->setCellValue('F15', 'Primer Nombre')
					->setCellValue('G15', 'Segundo Nombre')
					->setCellValue('H15', 'Departamento de residencia')
					->setCellValue('I15', 'Municipio de residencia')
					->setCellValue('J15', 'Dirección / Nombre de la Finca')
					->setCellValue('K15', 'Teléfono')
					->setCellValue('L15', 'Correo Electrónico');	
					
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
		
		//alinear
		$objPHPExcel->getActiveSheet()->getStyle('A15:L16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A15:L16')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A15:L16')->getAlignment()->setWrapText(true);
				
		$numeracion = 0; 
		$fila = 16;
					
		$damnificados = array();
		$result = Humanitaria::getInstance()->get_reparaciones_atendidas_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
				
		foreach ($damnificados as $id){
			$idDamnificado = $id;
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
							->setCellValue("C".$fila, $documentoDamnificado)
							->setCellValue("D".$fila, $primerApellido)
							->setCellValue("E".$fila, $segundoApellido)
							->setCellValue("F".$fila, $primerNombre)
							->setCellValue("G".$fila, $segundoNombre)
							->setCellValue("H".$fila, 'Norte de Santander')
							->setCellValue("I".$fila, 'Cúcuta')
							->setCellValue("J".$fila, $direccionDamnificado)
							->setCellValue("K".$fila, $telefonoDamnificado);					
				
				$objPHPExcel->getActiveSheet()->getStyle('A'.$fila.':B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('I'.$fila.':I'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyle('K'.$fila.':K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
			mysqli_free_result($resultDamnificado);
		}
			
		$objPHPExcel->getActiveSheet()->getStyle('A15:L'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle('A15:L'.$fila)->getFont()->setSize(10);
				
		//$objPHPExcel->getActiveSheet()->setAutoFilter('A15:L'.$fila);
			
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle("F-CD-005-ENTREGA_A_BENEFICIARIO");
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client's web browser (Excel2007)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="F-CD-005-ENTREGA_A_BENEFICIARIO_REPARACION.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>	