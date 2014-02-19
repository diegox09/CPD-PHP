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
					->setCellValue('A1', 'ID')            
					->setCellValue('B1', 'PRIMER NOMBRE')
					->setCellValue('C1', 'SEGUNDO NOMBRE')
					->setCellValue('D1', 'PRIMER APELLIDO')
					->setCellValue('E1', 'SEGUNDO APELLIDO')
					->setCellValue('F1', 'GENERO')
					->setCellValue('G1', 'TD')
					->setCellValue('H1', 'DOCUMENTO')
					->setCellValue('I1', 'DIRECCION DE LA VIVIENDA AFECTADA')
					->setCellValue('J1', 'ALBERGUE O BARRIO')
					->setCellValue('K1', 'TELEFONO')
					->setCellValue('L1', 'NOMBRE DEL ARRENDADOR')
					->setCellValue('M1', 'No. DOC. DEL ARRENDADOR')
					->setCellValue('N1', 'DIRECCION DEL ARRENDADOR')
					->setCellValue('O1', 'TELEFONO DEL ARRENDADOR')
					->setCellValue('P1', 'FECHA 1er APOYO ENTREGA DE ARRIENDO')
					->setCellValue('Q1', 'NUMERO DE COMPROBANTE')
					->setCellValue('R1', 'ESTADO')
					->setCellValue('S1', 'OBSERVACIONES ARRIENDO')
					->setCellValue('T1', 'FECHA 1ra ENTREGA DE MERCADO')
					->setCellValue('U1', 'FECHA 2da ENTREGA DE MERCADO')
					->setCellValue('V1', 'FECHA 3ra ENTREGA DE MERCADO')
					->setCellValue('W1', 'FECHA 4ta ENTREGA DE MERCADO')
					->setCellValue('X1', 'FECHA 1ra ENTREGA DE KIT DE ASEO')
					->setCellValue('Y1', 'FICHO')					
					->setCellValue('Z1', 'ESTADO')
					->setCellValue('AA1', 'OBSERVACIONES ENTREGAS')
					->setCellValue('AB1', 'FECHA ENTREGA DE REPARACION')
					->setCellValue('AC1', 'NUMERO DE COMPROBANTE')
					->setCellValue('AD1', 'ESTADO')
					->setCellValue('AE1', 'OBSERVACIONES REPARACION')	
					->setCellValue('AF1', 'CONFIRMACION')
					->setCellValue("AI1", "ARRIENDOS")
					->setCellValue("AL1", "MERCADOS")
					->setCellValue("AO1", "KITS")
					->setCellValue("AR1", "REPARACIONES")
					->setCellValue("AU1", "ARRIENDOS C/U")
					->setCellValue("AV1", "MERCADOS C/U")
					->setCellValue("AW1", "KITS C/U")
					->setCellValue("AX1", "REPARACIONES C/U");
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(15);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(5);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(25);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(15);

		$objPHPExcel->getActiveSheet()->getStyle('A1:AX1')->getFont()->setBold(true);				
					
		$objPHPExcel->getActiveSheet()->freezePane('A2');
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:AX1')->getAlignment()->setWrapText(true);			
		$objPHPExcel->getActiveSheet()->getStyle('A1:AX1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$fila = 1;
		
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
				
		foreach ($damnificados as $id){		
			$fila ++;
			$idDamnificado = $id;
			
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
			if(mysqli_num_rows($resultDamnificado) != 0){				
				$damnificado = mysqli_fetch_array($resultDamnificado);	
				$primerNombre = utf8_encode($damnificado['primer_nombre']);
				$segundoNombre = utf8_encode($damnificado['segundo_nombre']);
				$primerApellido = utf8_encode($damnificado['primer_apellido']);
				$segundoApellido = utf8_encode($damnificado['segundo_apellido']);
				$genero = $damnificado['genero'];
				switch($genero){
					case 1:	$genero = "M";
							break;
					case 2: $genero = "F";
							break;
					default:$genero = "";
							break;		
				}
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
				$confirmacion = utf8_encode($damnificado['observaciones']);
				
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("A".$fila, $idDamnificado)	
							->setCellValue("B".$fila, $primerNombre)
							->setCellValue("C".$fila, $segundoNombre)
							->setCellValue("D".$fila, $primerApellido)
							->setCellValue("E".$fila, $segundoApellido)
							->setCellValue("F".$fila, $genero)
							->setCellValue("G".$fila, $td)
							->setCellValue("H".$fila, $documentoDamnificado)
							->setCellValue("I".$fila, $direccionDamnificado)
							->setCellValue("J".$fila, $barrioDamnificado)
							->setCellValue("K".$fila, $telefonoDamnificado)
							->setCellValue("AF".$fila, $confirmacion);	
			}
			mysqli_free_result($resultDamnificado);			
			
			$resultArriendo = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);
			if(mysqli_num_rows($resultArriendo) != 0){
				$arriendo = mysqli_fetch_array($resultArriendo);
				$fechaArriendo = implota($arriendo['fecha_arriendo']);
				if($arriendo['comprobante'] == NULL)
					$comprobante = '';
				else
					$comprobante = $arriendo['comprobante'];
				$observaciones = utf8_encode($arriendo['observaciones']);
				$estado = $arriendo['id_estado'];		
					
				$idArrendador = $arriendo['id_arrendador'];	
				$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);
				if(mysqli_num_rows($resultArrendador) != 0){				
					$arrendador = mysqli_fetch_array($resultArrendador);
					$documentoArrendador = $arrendador['documento_arrendador'];
					$nombreArrendador = utf8_encode($arrendador['nombre_arrendador']);
					$telefonoArrendador = $arrendador['telefono_arrendador'];
					$direccionArrendador = utf8_encode($arrendador['direccion_arrendador']);	
					
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("L".$fila, $nombreArrendador)	
								->setCellValue("M".$fila, $documentoArrendador)
								->setCellValue("N".$fila, $direccionArrendador)
								->setCellValue("O".$fila, $telefonoArrendador);
				}
				mysqli_free_result($resultArrendador);
				
				$contArriendo = 0;
				if($fechaArriendo != '')
					$contArriendo = 1;					
				
				$objPHPExcel->setActiveSheetIndex(0)							
							->setCellValue("P".$fila, $fechaArriendo)
							->setCellValue("Q".$fila, $comprobante)
							->setCellValue("R".$fila, $estado)
							->setCellValue("S".$fila, $observaciones)
							->setCellValue("AU".$fila, $contArriendo);
			}
			mysqli_free_result($resultArriendo);
			
			$resultEntregas = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
			if(mysqli_num_rows($resultEntregas) != 0){				
				$entregas = mysqli_fetch_array($resultEntregas);
				$fechaKitAseo = implota($entregas['fecha_kit_aseo']);				
				$fechaMercado1 = implota($entregas['fecha_mercado1']);				
				$fechaMercado2 = implota($entregas['fecha_mercado2']);
				$fechaMercado3 = implota($entregas['fecha_mercado3']);
				$fechaMercado4 = implota($entregas['fecha_mercado4']);	
				if($entregas['ficho'] == NULL)
					$ficho = '';
				else
					$ficho = $entregas['ficho'];			
				$observaciones = utf8_encode($entregas['observaciones']);				
				$estado = $entregas['id_estado'];	
				
				$contKitAseo = 0;
				if($fechaKitAseo != '')
					$contKitAseo = 1;
				
				$contMercados = 0;
				if($fechaMercado1 != '')
					$contMercados ++;		
				if($fechaMercado2 != '')
					$contMercados ++;			
				if($fechaMercado3 != '')
					$contMercados ++;			
				if($fechaMercado4 != '')
					$contMercados ++;					
					
				$objPHPExcel->setActiveSheetIndex(0)												
						->setCellValue("T".$fila, $fechaMercado1)
						->setCellValue("U".$fila, $fechaMercado2)
						->setCellValue("V".$fila, $fechaMercado3)
						->setCellValue("W".$fila, $fechaMercado4)
						->setCellValue("X".$fila, $fechaKitAseo)
						->setCellValue("Y".$fila, $ficho)
						->setCellValue("Z".$fila, $estado)
						->setCellValue("AA".$fila, $observaciones)						
						->setCellValue("AV".$fila, $contMercados)
						->setCellValue("AW".$fila, $contKitAseo);	
			}
			mysqli_free_result($resultEntregas);
			
			$resultReparacion = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);
			if(mysqli_num_rows($resultReparacion) != 0){				
				$reparacion = mysqli_fetch_array($resultReparacion);
				$fechaReparacion = implota($reparacion['fecha_reparacion']);
				if($reparacion['comprobante'] == NULL)
					$comprobanteR = '';
				else
					$comprobanteR = $reparacion['comprobante'];			
				$observaciones = utf8_encode($reparacion['observaciones']);				
				$estado = $reparacion['id_estado'];	
				
				$contReparacion = 0;
				if($fechaReparacion != '')
					$contReparacion = 1;									
					
				$objPHPExcel->setActiveSheetIndex(0)												
						->setCellValue("AB".$fila, $fechaReparacion)
						->setCellValue("AC".$fila, $comprobanteR)
						->setCellValue("AD".$fila, $estado)
						->setCellValue("AE".$fila, $observaciones)						
						->setCellValue("AX".$fila, $contReparacion);	
			}
			//mysqli_free_result($resultEntregas);
		}		
				
		$objPHPExcel->getActiveSheet()->getStyle('A1:AF'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
		
		$objPHPExcel->getActiveSheet()->getStyle('AU1:AX'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				
		
		$contador = $fila+1;
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AU'.$contador, '=SUM(AU2:AU'.$fila.')');		
			
		$objPHPExcel->getActiveSheet()->getStyle('AU'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AU'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
		
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AV'.$contador, '=SUM(AV2:AV'.$fila.')');		
		
		$objPHPExcel->getActiveSheet()->getStyle('AV'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AV'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
		
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AW'.$contador, '=SUM(AW2:AW'.$fila.')');	
				
		$objPHPExcel->getActiveSheet()->getStyle('AW'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AW'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');	
		
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AX'.$contador, '=SUM(AX2:AX'.$fila.')');	
				
		$objPHPExcel->getActiveSheet()->getStyle('AX'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AX'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');				
		
		//Arriendos
		$fila = 1;	
		$result = Humanitaria::getInstance()->get_fechas_arriendos_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$fila ++;
			$fecha = $info['fecha_arriendo'];			
			$resultArriendos = Humanitaria::getInstance()->get_arriendos_by_fase_fecha($fase, $fecha);
			$contArriendos = mysqli_num_rows($resultArriendos);
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("AI".$fila, implota($fecha))
						->setCellValue("AJ".$fila, $contArriendos);
			
			mysqli_free_result($resultArriendos);			
		}
		mysqli_free_result($result);
		
		$objPHPExcel->getActiveSheet()->getStyle('AI1:AJ'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$contador = $fila+1;
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$contador, '=SUM(AJ2:AJ'.$fila.')');	
				
		$objPHPExcel->getActiveSheet()->getStyle('AJ'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AJ'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');
		
		//Mercados
		$fila = 1;	
		$fechas = array();
		$result = Humanitaria::getInstance()->get_fechas_mercados_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['fecha_mercado1'], $fechas))
				$fechas[] = $info['fecha_mercado1'];
			if(!in_array($info['fecha_mercado2'], $fechas))
				$fechas[] = $info['fecha_mercado2'];
			if(!in_array($info['fecha_mercado3'], $fechas))
				$fechas[] = $info['fecha_mercado3'];
			if(!in_array($info['fecha_mercado4'], $fechas))
				$fechas[] = $info['fecha_mercado4'];		
		}
		mysqli_free_result($result);
		
		sort($fechas);
		foreach ($fechas as $fecha){
			if($fecha != '0000-00-00'){
				$fila ++;			
				$contMercados = 0;
				$resultMercados = Humanitaria::getInstance()->get_mercados_by_fase_fecha($fase, $fecha);
				while ($infoMercado = mysqli_fetch_array($resultMercados)){
					if($infoMercado['fecha_mercado1'] == $fecha)
						$contMercados ++;
					if($infoMercado['fecha_mercado2'] == $fecha)
						$contMercados ++;
					if($infoMercado['fecha_mercado3'] == $fecha)
						$contMercados ++;
					if($infoMercado['fecha_mercado4'] == $fecha)
						$contMercados ++;	
				}
				mysqli_free_result($resultMercados);
				
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue("AL".$fila, implota($fecha))
							->setCellValue("AM".$fila, $contMercados);	
			}
		}
		
		$objPHPExcel->getActiveSheet()->getStyle('AL1:AM'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$contador = $fila+1;
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AM'.$contador, '=SUM(AM2:AM'.$fila.')');	
				
		$objPHPExcel->getActiveSheet()->getStyle('AM'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AM'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');	
		
		//Kits Aseo
		$fila = 1;	
		$result = Humanitaria::getInstance()->get_fechas_kits_aseo_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$fila ++;
			$fecha = $info['fecha_kit_aseo'];			
			$resultKitsAseo = Humanitaria::getInstance()->get_kits_aseo_by_fase_fecha($fase, $fecha);
			$contKitsAseo = mysqli_num_rows($resultKitsAseo);
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("AO".$fila, implota($fecha))
						->setCellValue("AP".$fila, $contKitsAseo);
						
			mysqli_free_result($resultKitsAseo);			
		}
		mysqli_free_result($result);
		
		$objPHPExcel->getActiveSheet()->getStyle('AO1:AP'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$contador = $fila+1;
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AP'.$contador, '=SUM(AP2:AP'.$fila.')');		
			
		$objPHPExcel->getActiveSheet()->getStyle('AP'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AP'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');	
		
		//Reparacion
		$fila = 1;	
		$result = Humanitaria::getInstance()->get_fechas_reparaciones_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$fila ++;
			$fecha = $info['fecha_reparacion'];			
			$resultReparaciones = Humanitaria::getInstance()->get_reparaciones_by_fase_fecha($fase, $fecha);
			$contReparaciones = mysqli_num_rows($resultReparaciones);
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("AR".$fila, implota($fecha))
						->setCellValue("AS".$fila, $contReparaciones);
			
			mysqli_free_result($resultReparaciones);			
		}
		mysqli_free_result($result);
		
		$objPHPExcel->getActiveSheet()->getStyle('AR1:AS'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$contador = $fila+1;
		if($fila >= 2)
			$objPHPExcel->getActiveSheet()->setCellValue('AS'.$contador, '=SUM(AS2:AS'.$fila.')');	
				
		$objPHPExcel->getActiveSheet()->getStyle('AS'.$contador)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('AS'.$contador)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');	
					
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('COLOMBIA HUMANITARIA');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = "COLOMBIA HUMANITARIA ".date("d/m/Y").".xls";
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nombre.'"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output'); 
		exit;
	}
	else
		header("Location: ../");
?>	