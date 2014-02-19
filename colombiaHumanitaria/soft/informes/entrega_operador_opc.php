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
					->setCellValue('Q1', 'Código: F-COLHUM-001')
					->setCellValue('Q2', 'Fecha: 2011-02-21')
					->setCellValue('Q3', 'Versión: 01')
					->setCellValue('A4', 'FORMATO DE SEGUIMIENTO A ENTREGAS DE AYUDAS')
					->setCellValue('B6', 'DEPARTAMENTO/CIUDAD CAPITAL')
					->setCellValue('B8', 'NOMBRE ENTIDAD OPERADORA')
					->setCellValue('B11', 'INTERVENTORIA')
					->setCellValue('C11', 'SI (   )   /   No  ( X ) ')			
					->setCellValue('F6', 'NORTE DE SANTANDER / CÚCUTA')			
					->setCellValue('F8', 'CORPRODINCO')
					->setCellValue('F11', 'Entidad Interventora:  ')
					->setCellValue('P6', 'SOLICITUD No.')
					->setCellValue('P8', 'Contrato No.')
					->setCellValue('P11', 'Entrega No.')
					->setCellValue('P13', 'Fecha de Entrega')
					->setCellValue('R13', $fecha)
					->setCellValue('E13', 'P:  Programado')
					->setCellValue('E14', 'A:  Atendido');
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A4:S4');
		$objPHPExcel->getActiveSheet()->mergeCells('F6:J6');
		$objPHPExcel->getActiveSheet()->mergeCells('F8:J9');
		$objPHPExcel->getActiveSheet()->mergeCells('F11:J11');
		$objPHPExcel->getActiveSheet()->mergeCells('R6:S6');
		$objPHPExcel->getActiveSheet()->mergeCells('R8:S8');
		$objPHPExcel->getActiveSheet()->mergeCells('R11:S11');
		$objPHPExcel->getActiveSheet()->mergeCells('R13:S13');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(22);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(21);
		$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('10')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('12')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('15')->setRowHeight(8);
		$objPHPExcel->getActiveSheet()->getRowDimension('17')->setRowHeight(51);
		
		//negrita
		$objPHPExcel->getActiveSheet()->getStyle('A1:V17')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getFont()->setBold(false);
		$objPHPExcel->getActiveSheet()->getStyle('R13')->getFont()->setBold(false);
		
		//alinear			
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('R13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		//borde negro
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000'),
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle('F6:J6')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F8:J9')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('F11:J11')->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('E13:F14')->applyFromArray($styleThinBlackBorderOutline);
					
		$objPHPExcel->getActiveSheet()->getStyle('A1:V15')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		
		$objPHPExcel->getActiveSheet()->getStyle('R6:S6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
			
		//borde gris
		$styleThickGrisBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('rgb' => 'C0C0C0'),
				),
			),
		);			
		$objPHPExcel->getActiveSheet()->getStyle('R6:S6')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('R8:S8')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('R11:S11')->applyFromArray($styleThickGrisBorderOutline);
		$objPHPExcel->getActiveSheet()->getStyle('R13:S13')->applyFromArray($styleThickGrisBorderOutline);
											
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A16', 'Municipios')
					->setCellValue('A17', 'No.')
					->setCellValue('B17', 'Nombre')
					->setCellValue('C16', 'No. Total de Familias Beneficiadas')
					->setCellValue('D16', 'No. Total Personas Beneficiadas')
					->setCellValue('F16', 'NUMERO DE FAMILIAS BENEFICIADAS')
					->setCellValue('F17', 'Tipo A De 0 a 3 integrantes')			
					->setCellValue('G17', 'Tipo B De 3 a 6 Integrantes')
					->setCellValue('H17', 'Tipo C Mas de 6 Integrantes')
					->setCellValue('I17', 'No. Familias que requieren arriendo')
					->setCellValue('J17', 'No. Familias que requieren reparacion de vivienda')
					->setCellValue('K16', 'KIT DE MERCADOS ENTREGADOS')
					->setCellValue('K17', 'Tipo A De 0 a 3 integrantes')
					->setCellValue('L17', 'Tipo B De 3 a 6 Integrantes')
					->setCellValue('M17', 'Tipo C Mas de 6 Integrantes')
					->setCellValue('N17', 'Valor de las Ayudas Entregadas')
					->setCellValue('O16', 'KIT DE ASEO ENTREGADOS')
					->setCellValue('O17', 'Tipo A De 0 a 3 integrantes')
					->setCellValue('P17', 'Tipo B De 3 a 6 Integrantes')
					->setCellValue('Q17', 'Tipo C Mas de 6 Integrantes')
					->setCellValue('R17', 'Valor de las Ayudas Entregadas')
					->setCellValue('S16', 'Arriendos Entregados')	
					->setCellValue('T16', 'Valor de los Arriendos Entregados')
					->setCellValue('T17', 'Valor de las Ayudas Entregadas')
					->setCellValue('U16', 'Reparaciones de vivienda Entregadas')	
					->setCellValue('V16', 'Valor de las Reparaciones de vivienda Entregadas')
					->setCellValue('V17', 'Valor de las Ayudas Entregadas');	
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A16:B16');
		$objPHPExcel->getActiveSheet()->mergeCells('C16:C17');
		$objPHPExcel->getActiveSheet()->mergeCells('D16:D17');
		$objPHPExcel->getActiveSheet()->mergeCells('E16:E17');
		$objPHPExcel->getActiveSheet()->mergeCells('F16:J16');
		$objPHPExcel->getActiveSheet()->mergeCells('K16:N16');
		$objPHPExcel->getActiveSheet()->mergeCells('O16:R16');
		$objPHPExcel->getActiveSheet()->mergeCells('S16:S17');
		$objPHPExcel->getActiveSheet()->mergeCells('U16:U17');
		
		//alinear
		$objPHPExcel->getActiveSheet()->getStyle('A16:V17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A16:V17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('E16')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
		
		$fila = 18;
		$fila_2 = 19;
		$contAtendidos = 0;		
		$contMercados = 0;
		$contKitsAseo = 0;		
		$contArriendos = 0;
		$contReparaciones = 0;	
		$valorMercados = 0;
		$valorKitsAseo = 0;
		$valorArriendos = 0;
		$valorReparaciones = 0;
		
		$damnificados = array();
		$result = Humanitaria::getInstance()->get_entregas_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_arriendos_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_reparaciones_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
				
		foreach ($damnificados as $id){
			$idDamnificado = $id;
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
			
			if(mysqli_num_rows($resultDamnificado) != 0){				
				$atendido = false;
				$resultArriendo = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultArriendo) != 0){
					$arriendo = mysqli_fetch_array($resultArriendo);
					if($arriendo['fecha_arriendo'] != '0000-00-00'){
						$atendido = true;
						$contArriendos ++;					
					}					
				}
				mysqli_free_result($resultArriendo);
				
				$resultReparacion = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultReparacion) != 0){
					$reparacion = mysqli_fetch_array($resultReparacion);
					if($reparacion['fecha_reparacion'] != '0000-00-00'){
						$atendido = true;
						$contReparaciones ++;					
					}					
				}
				mysqli_free_result($resultReparacion);				
							
				$resultEntregas = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
				if(mysqli_num_rows($resultEntregas) != 0){				
					$entregas = mysqli_fetch_array($resultEntregas);
					if($entregas['fecha_kit_aseo'] != '0000-00-00'){
						$atendido = true;
						$contKitsAseo ++;
					}
					
					if($entregas['fecha_mercado1'] != '0000-00-00'){
						$atendido = true;
						$contMercados ++;		
					}
					if($entregas['fecha_mercado2'] != '0000-00-00'){
						$atendido = true;
						$contMercados ++;			
					}
					if($entregas['fecha_mercado3'] != '0000-00-00'){
						$atendido = true;
						$contMercados ++;			
					}
					if($entregas['fecha_mercado4'] != '0000-00-00'){
						$atendido = true;
						$contMercados ++;				
					}
				}
				mysqli_free_result($resultEntregas);
				
				if($atendido)
					$contAtendidos ++;
			}
			mysqli_free_result($resultDamnificado);
		}	
												
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$fila.':A'.$fila_2);
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$fila.':B'.$fila_2);
	
		$objPHPExcel->getActiveSheet()->getStyle('A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);										
			
		$objPHPExcel->getActiveSheet()->getStyle('E'.$fila.':V'.$fila)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');					
				
			
		$valorMercados = $contMercados * 75000;
		$valorKitsAseo = $contKitsAseo * 50000;
		$valorArriendos = $contArriendos * 700000;
		$valorReparaciones = $contReparaciones * 2100000;
		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A".$fila, "1")
					->setCellValue("B".$fila, "Cúcuta")
					->setCellValue("C".$fila_2, $contAtendidos)
					->setCellValue("E".$fila, "P")
					->setCellValue("E".$fila_2, "A")					
					->setCellValue("G".$fila_2, $contAtendidos)
					->setCellValue("I".$fila_2, $contArriendos)
					->setCellValue("J".$fila_2, $contReparaciones)
					->setCellValue("L".$fila_2, $contMercados)
					->setCellValue("N".$fila_2, $valorMercados)
					->setCellValue("P".$fila_2, $contKitsAseo)				
					->setCellValue("R".$fila_2, $valorKitsAseo)
					->setCellValue("S".$fila_2, $contArriendos)
					->setCellValue("T".$fila_2, $valorArriendos)
					->setCellValue("U".$fila_2, $contReparaciones)
					->setCellValue("V".$fila_2, $valorReparaciones);
			
		$objPHPExcel->getActiveSheet()->getStyle('A16:V'.$fila_2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);			
		$objPHPExcel->getActiveSheet()->getStyle('L'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$objPHPExcel->getActiveSheet()->getStyle('S'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$objPHPExcel->getActiveSheet()->getStyle('U'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		
		$objPHPExcel->getActiveSheet()->getStyle('N'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
		$objPHPExcel->getActiveSheet()->getStyle('R'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
		$objPHPExcel->getActiveSheet()->getStyle('T'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
		$objPHPExcel->getActiveSheet()->getStyle('V'.$fila_2)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
			
		$objPHPExcel->getActiveSheet()->getStyle('A1:V'.$fila_2)->getFont()->setSize(10);
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(16);
		
		$objPHPExcel->getActiveSheet()->getStyle('E18:E'.$fila_2)->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->getStyle('A16:V17')->getAlignment()->setWrapText(true);
			
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle("F-CH-001-Entregas por Operador");
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="F-CH-001-Entregas por Operador.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>		
