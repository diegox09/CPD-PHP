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
					->setCellValue('A1', 'CONCEPTO') 
					->setCellValue('B1', 'TIPO DOCUMENTO')
					->setCellValue('C1', 'NUMERO INDENTIFICACION DEL INFORMADO	')
					->setCellValue('D1', 'DV')
					->setCellValue('E1', 'PRIMER APELLIDO DE LA PERSONA A QUIEN SE LE HIZO EL PAGO')
					->setCellValue('F1', 'SEGUNDO APELLIDO DE LA PERSONA A QUIEN SE LE HIZO EL PAGO')           
					->setCellValue('G1', 'PRIMER NOMBRE DE LA PERSONA A QUIEN SE LE HIZO EL PAGO')
					->setCellValue('H1', 'SEGUNDO NOMBRE DE LA PERSONA A QUIEN SE LE HIZO EL PAGO')
					->setCellValue('I1', 'RAZON SOCIAL DE LA PERSONA A QUIEN SE LE HIZO EL PAGO')
					->setCellValue('J1', 'DIRECCION')
					->setCellValue('K1', '')
					->setCellValue('L1', 'CODIGO DPTO')
					->setCellValue('M1', 'CODIGO MCP')
					->setCellValue('N1', 'PAIS DE RESIDENCIA O DOMICILIO')
					->setCellValue('O1', 'PAGO O ABONO EN CUENTA DEDUCIBLE DECLARACION RENTA')
					->setCellValue('P1', 'PAGOS O ABONO EN CUENTA QUE NO CONSTITUYAN COSTO O DEDUCCION')
					->setCellValue('Q1', 'IVA QUE ESTABA INCLUIDO COMO MAYOR VALOR DEL GASTOS DEDUCIBLE')
					->setCellValue('R1', 'IVA QUE ESTABA INCLUIDO COMO MAYOR VALOR DEL GASTOS NO DEDUCIBLE')
					->setCellValue('S1', 'VALOR BASE RETENCION A TITULO DE RENTA')
					->setCellValue('T1', 'VALOR RETENCIONES PRACTICADAS A TITULO DE RENTA')
					->setCellValue('U1', 'VALOR RETENCIONES PRACTICADAS A TITULO DE IVA')
					->setCellValue('V1', 'TIPO DE DOCUMENTO DEL MANDANTE O CONTRATANTE')
					->setCellValue('W1', 'IDENTIFICACION DEL MANDANTE O CONTRATANTE')
					->setCellValue('X1', 'DV')
					->setCellValue('Y1', 'PRIMER APELLIDO DEL MANDANTE O CONTRATANTE')
					->setCellValue('Z1', 'SEGUNDO APELLIDO DEL MANDANTE O CONTRATANTE')
					->setCellValue('AA1', 'PRIMER NOMBRE DEL MANDANTE O CONTRATANTE')
					->setCellValue('AB1', 'OTROS NOMBRES DEL MANDANTE O CONTRATANTE')
					->setCellValue('AC1', 'RAZON SOCIAL DEL MANDANTE O CONTRATANTE');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(40);

		$objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getFont()->setBold(true);				
					
		$objPHPExcel->getActiveSheet()->freezePane('A2');
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getAlignment()->setWrapText(true);			
		$objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$fila = 1;	
		
		$damnificados = array();
		
		$result = Humanitaria::getInstance()->get_entregas();		
		while ($info = mysqli_fetch_array($result)){
			$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
								
		foreach ($damnificados as $id){	
			$idDamnificado = $id;
			
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
			if(mysqli_num_rows($resultDamnificado) != 0){				
				$damnificado = mysqli_fetch_array($resultDamnificado);	
				
				$concepto = '';
				$td = 31;
				
				$documentoDamnificado = $damnificado['documento_damnificado'];
				$primerApellido = utf8_encode(strtoupper($damnificado['primer_apellido']));
				$segundoApellido = utf8_encode(strtoupper($damnificado['segundo_apellido']));
				$primerNombre = utf8_encode(strtoupper($damnificado['primer_nombre']));
				$segundoNombre = utf8_encode(strtoupper($damnificado['segundo_nombre']));								
								
				$direccionDamnificado = utf8_encode(strtoupper($damnificado['direccion']));
				$barrioDamnificado = utf8_encode(strtoupper($damnificado['barrio']));
				
				$dpto = 54;
				$mcp = 001;
				$pais = 169;
				$pagoDeducible = 0;
				$pagoNoDeducible = 0;
				
				$valorMercado = 0;
				$valorKitAseo = 0;
				
				$originalA = array("BARRIO", "CL", "LLL", "CALLE", "AVENIDA", "MANZANA", "LOTE", "TRANSVERSAL", "TRANVERSAL", "CARRERA", "VEREDA", "NO.", "N.", "N°", ".", ",", '#', "-", "  ");
				$actualA   = array("", "CLL", "LL", "CLL", "AV", "MZ", "LT", "TRANSV", "TRANSV", "CRA", "VDA", "", "", "", "", "", "", " ", " ");
				
				$originalB = array("BARRIO", '#', "-", ".", ",");
				$actualB   = array("", "", "", "", "");
				
				$original = array("  ");
				$actual   = array(" ");
				
				$resultEntregas = Humanitaria::getInstance()->get_entregas_damnificado($idDamnificado);
				while ($entregas = mysqli_fetch_array($resultEntregas)){
					switch($entregas['id_periodo']){
						case 1: $valorMercado = 59889;
								$valorKitAseo = 39900;
								break;
						case 2: $valorMercado = 75000;
								$valorKitAseo = 50000;
								break;		
						case 3: $valorMercado = 75000;
								$valorKitAseo = 50000;
								break;		
					}
					$fechaKitAseo = $entregas['fecha_kit_aseo'];				
					$fechaMercado1 = $entregas['fecha_mercado1'];				
					$fechaMercado2 = $entregas['fecha_mercado2'];
					$fechaMercado3 = $entregas['fecha_mercado3'];
					$fechaMercado4 = $entregas['fecha_mercado4'];
					
					$contKitAseo = 0;
					if($fechaKitAseo != '0000-00-00' AND $fechaKitAseo < '2012-01-01')
						$contKitAseo = 1;
										
					$contMercados = 0;
					if($fechaMercado1 != '0000-00-00' AND $fechaMercado1 < '2012-01-01')
						$contMercados ++;		
					if($fechaMercado2 != '0000-00-00' AND $fechaMercado2 < '2012-01-01')
						$contMercados ++;			
					if($fechaMercado3 != '0000-00-00' AND $fechaMercado3 < '2012-01-01')
						$contMercados ++;			
					if($fechaMercado4 != '0000-00-00' AND $fechaMercado4 < '2012-01-01')
						$contMercados ++;	
						
					$subtotal = ($contMercados * $valorMercado) + ($contKitAseo * $valorKitAseo);
					$pagoNoDeducible = $pagoNoDeducible + $subtotal;		
				}	
				mysqli_free_result($resultEntregas);
								
				$resultArriendo = Humanitaria::getInstance()->get_arriendos_damnificado($idDamnificado);
				while ($arriendo = mysqli_fetch_array($resultArriendo)){
					$direccionArrendador = utf8_encode(strtoupper($arriendo['direccion_arrendador']));
											
					$arr = str_split($direccionArrendador, 1);
					$k = 0;
					for($i=0;$i<count($arr);$i++){
						if(is_numeric($arr[$i]))
							$k = $i;
					}
					
					if($k != 0){
						$k ++;
						$longitud = strlen($direccionArrendador);
						$direccionDamnificado = substr($direccionArrendador,0,$k);
						$barrioDamnificado = trim(substr($direccionArrendador,$k,$longitud));
					}
					else{
						$direccionDamnificado = $direccionArrendador;
						$barrioDamnificado = "";
					}	
	
					$direccionDamnificado = str_replace($originalA, $actualA, $direccionDamnificado);
					$barrioDamnnificado = str_replace($originalB, $actualB, $barrioDamnificado);
					
					$direccionDamnificado = str_replace($original, $actual, $direccionDamnificado);
					$barrioDamnificado = str_replace($original, $actual, $barrioDamnificado);	
				}
				mysqli_free_result($resultArriendo);

				$direccionDamnificado = str_replace($originalA, $actualA, $direccionDamnificado);	
				$barrioDamnificado = str_replace($originalB, $actualB, $barrioDamnificado);		
				
				if($pagoNoDeducible > 0){	
					$fila ++;						
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("A".$fila, $concepto)	
								->setCellValue("B".$fila, $td)
								->setCellValue("C".$fila, $documentoDamnificado)
								->setCellValue("D".$fila, '')
								->setCellValue("E".$fila, $primerApellido)
								->setCellValue("F".$fila, $segundoApellido)
								->setCellValue("G".$fila, $primerNombre)
								->setCellValue("H".$fila, $segundoNombre)
								->setCellValue("I".$fila, '')
								->setCellValue("J".$fila, $direccionDamnificado)
								->setCellValue("K".$fila, $barrioDamnificado)
								->setCellValue("L".$fila, $dpto)
								->setCellValue("M".$fila, $mcp)
								->setCellValue("N".$fila, $pais)
								->setCellValue("O".$fila, $pagoDeducible)
								->setCellValue("P".$fila, $pagoNoDeducible)
								->setCellValue("Q".$fila, '0')
								->setCellValue("R".$fila, '0')
								->setCellValue("S".$fila, '0')
								->setCellValue("T".$fila, '0')
								->setCellValue("U".$fila, '0')
								->setCellValue("V".$fila, '31')
								->setCellValue("W".$fila, '')
								->setCellValue("X".$fila, '')
								->setCellValue("Y".$fila, '')
								->setCellValue("Z".$fila, '')
								->setCellValue("AA".$fila, '')
								->setCellValue("AB".$fila, '')
								->setCellValue("AC".$fila, 'ALCALDIA DE SAN JOSE DE CUCUTA');	
				}				
			}
			mysqli_free_result($resultDamnificado);	
		}		
				
		$objPHPExcel->getActiveSheet()->getStyle('A1:AC'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
					
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('1016');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = "FORMATO_1016_DAMNIFICADOS.xls";
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