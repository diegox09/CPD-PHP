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
		$fecha = explota($_GET["fecha"]);
		
		$meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
		$fechas = array();
		$fechas = split("-", $fecha);
		$mes = $fechas[1];
		--$mes;
		$fecha_m = $fechas[2]." ".$meses[$mes]." ".$fechas[0];				
		
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
					->setCellValue('B7', 'LUGAR')
					->setCellValue('C7', 'Coliseo Colegio Municipal')            
					->setCellValue('B8', 'FECHA')
					->setCellValue('C8', $fecha_m)
					->setCellValue('B9', 'ITEM')
					->setCellValue('C9', 'Nombres y Apellidos')
					->setCellValue('D9', 'Tipo Doc')
					->setCellValue('E9', 'No. Documento')
					->setCellValue('F9', 'Cantidad Mercados')
					->setCellValue('G9', 'Cantidad Kits')
					->setCellValue('H9', 'Cantidad Arrendamientos')
					->setCellValue('I9', 'Valor');
							
		$objPHPExcel->getActiveSheet()->getStyle('B9:I9')->getAlignment()->setWrapText(true);			
		$objPHPExcel->getActiveSheet()->getStyle('B4:B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B9:I9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B9:I9')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		
		$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);	
		
		$objPHPExcel->getActiveSheet()->mergeCells('B4:I4');
		$objPHPExcel->getActiveSheet()->mergeCells('B5:I5');
		$objPHPExcel->getActiveSheet()->mergeCells('C7:I7');
		$objPHPExcel->getActiveSheet()->mergeCells('C8:I8');		
		
		$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B7:I9')->getFont()->setBold(true);
				
		$numeracion = 0;
		$fila = 9;			
		$contMercados = 0;
		$contKitAseo = 0;		
		$contArriendo = 0;
		$total = 0;	
		
		$damnificados = array();
		$result = Humanitaria::getInstance()->get_entregas_by_fase_fecha($fase, $fecha);		
		while ($info = mysqli_fetch_array($result)){
			$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_arriendos_by_fase_fecha($fase, $fecha);		
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
				$fila ++;
				
				$damnificado = mysqli_fetch_array($resultDamnificado);
				$nombreDamnificado = utf8_encode($damnificado['primer_nombre']);
				if($damnificado['segundo_nombre'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_nombre']);
				if($damnificado['primer_apellido'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['primer_apellido']);
				if($damnificado['segundo_apellido'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_apellido']);		
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
				
				$contArriendo = 0;								
				$resultArriendo = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultArriendo) != 0){
					$arriendo = mysqli_fetch_array($resultArriendo);					
					if($arriendo['fecha_arriendo'] == $fecha)
						$contArriendo = 1;					
				}
				mysqli_free_result($resultArriendo);				
						
				$contKitAseo = 0;	
				$contMercados = 0;		
				$resultEntregas = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
				if(mysqli_num_rows($resultEntregas) != 0){				
					$entregas = mysqli_fetch_array($resultEntregas);
					
					if($entregas['fecha_kit_aseo'] == $fecha)
						$contKitAseo = 1;					
					
					if($entregas['fecha_mercado1'] == $fecha)
						$contMercados ++;	
					if($entregas['fecha_mercado2'] == $fecha)
						$contMercados ++;
					if($entregas['fecha_mercado3'] == $fecha)
						$contMercados ++;	
					if($entregas['fecha_mercado4'] == $fecha)
						$contMercados ++;
				}
				mysqli_free_result($resultEntregas);
				
				$valor = ($contMercados * 75000) + ($contKitAseo * 50000) + ($contArriendo * 700000);	
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("B".$fila, $numeracion)
							->setCellValue("C".$fila, $nombreDamnificado)
							->setCellValue("D".$fila, $td)
							->setCellValue("E".$fila, $documentoDamnificado)
							->setCellValue("F".$fila, $contMercados)
							->setCellValue("G".$fila, $contKitAseo)
							->setCellValue("H".$fila, $contArriendo)
							->setCellValue("I".$fila, $valor);				
			}
			mysqli_free_result($resultDamnificado);
		}	
				
		$contador = $fila+20;	
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('B7:I'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('B10:B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$contador = $fila+1;
		if($fila >= 10){
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$contador, '=SUM(F10:F'.$fila.')');	
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$contador, '=SUM(G10:G'.$fila.')');	
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$contador, '=SUM(H10:H'.$fila.')');	
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$contador, '=SUM(I10:I'.$fila.')');
		}
			
		$objPHPExcel->getActiveSheet()->getStyle('F'.$contador.':I'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
		
		$objPHPExcel->getActiveSheet()->getStyle('F2:H'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
		$objPHPExcel->getActiveSheet()->getStyle('I5:I'.$contador)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD);
		
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
		$objDrawing->setCoordinates('E2');
		$objDrawing->setOffsetX(60);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
		
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo Alcaldia de Cucuta');
		$objDrawing->setDescription('Logo Alcaldia de Cucuta');
		$objDrawing->setPath('../img/alcaldia_cucuta_nuevo.jpg');
		$objDrawing->setHeight(70);
		$objDrawing->setCoordinates('H2');
		$objDrawing->setOffsetX(90);
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());	
		
		$fecha_m = $fechas[2]." ".$meses[$mes];
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle($fecha_m);
	
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		$fecha_m = $fechas[2]." ".$meses[$mes]." ".$fechas[0];
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="EJECUCION_'.$fecha_m.'.xls"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>		
