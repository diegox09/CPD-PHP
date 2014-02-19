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
		
		$arrendadores = array();
				
		$result = Humanitaria::getInstance()->get_arriendos();		
		while ($info = mysqli_fetch_array($result)){
			$arrendadores[] = $info['id_arrendador'];		
		}
		mysqli_free_result($result);	
						
		foreach ($arrendadores as $id){	
			$idArrendador = $id;
			
			$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);
			if(mysqli_num_rows($resultArrendador) != 0){				
				$arrendador = mysqli_fetch_array($resultArrendador);	
				
				$concepto = '';
				$td = 31;
				
				$documentoArrendador = $arrendador['documento_arrendador'];
				
				$primerNombre = '';
				$segundoNombre = '';
				$primerApellido = '';
				$segundoApellido = '';
				
				$nombreArrendador = utf8_encode(strtoupper($arrendador['nombre_arrendador']));				
				//de, del, la, los, de la, de los, vda.
				
				$array = explode(" ",$nombreArrendador);
				$longitud = count($array);
				
				$j=0;
				for($i=0;$i<$longitud;$i++){
					if($array[$i] == 'DE' || $array[$i] == 'DEL' || $array[$i] == 'LA' || $array[$i] == 'LOS' || $array[$i] == 'DE LA' || $array[$i] == 'DE LOS'  || $array[$i] == 'VDA'){
						$array[($i+1)] = $array[$i].' '.$array[($i+1)];
						unset($array[$i]);
					}
					else{
						if($array[$i] != ''){
							switch($j){
								case 0: $primerNombre = $array[$i];
										break;
								case 1: $segundoNombre = $array[$i];
										break;
								case 2: $primerApellido = $array[$i];
										break;
								default: if($segundoApellido == '') 
											$segundoApellido = $array[$i];
										 else	
											$segundoApellido = $segundoApellido.' '.$array[$i];
										 break;							
							}
							$j++;	
						}	
					}
				}	
				
				$longitud = count($array);
				if($longitud == 2){
					$primerApellido = $segundoNombre;
					$segundoNombre = '';
				}							
								
				$direccionArrendador = utf8_encode(strtoupper($arrendador['direccion_arrendador']));				
										
				$arr = str_split($direccionArrendador, 1);
				$k = 0;
				for($i=0;$i<count($arr);$i++){
					if(is_numeric($arr[$i]))
						$k = $i;
				}
				
				if($k != 0){
					$k ++;
					$longitud = strlen($direccionArrendador);
					$direccionA = substr($direccionArrendador,0,$k);
					$direccionB = trim(substr($direccionArrendador,$k,$longitud));
				}
				else{
					$direccionA = $direccionArrendador;
					$direccionB = "";
				}
				
				$originalA = array("BARRIO", "CL", "LLL", "CALLE", "AVENIDA", "MANZANA", "LOTE", "TRANSVERSAL", "TRANVERSAL", "CARRERA", "VEREDA", "NO.", "N.", "N°", ".", ",", '#', "-", "  ");
				$actualA   = array("", "CLL", "LL", "CLL", "AV", "MZ", "LT", "TRANSV", "TRANSV", "CRA", "VDA", "", "", "", "", "", "", " ", " ");
				
				$originalB = array("BARRIO", '#', "-", ".", ",");
				$actualB   = array("", "", "", "", "");

				$direccionA = str_replace($originalA, $actualA, $direccionA);
				$direccionB = str_replace($originalB, $actualB, $direccionB);
				
				$original = array("  ");
				$actual   = array(" ");
				$direccionA = str_replace($original, $actual, $direccionA);
				$direccionB = str_replace($original, $actual, $direccionB);						
								
				$dpto = 54;
				$mcp = 001;
				$pais = 169;
				$pagoDeducible = 0;
				$pagoNoDeducible = 0;
				
				$valorArriendo = 700000;
				$contArriendo = 0;
				
				$resultArriendo = Humanitaria::getInstance()->get_arriendos_arrendador($idArrendador);
				while ($arriendo = mysqli_fetch_array($resultArriendo)){
					$fechaArriendo = $arriendo['fecha_arriendo'];					
					
					if($fechaArriendo != '0000-00-00' AND $fechaArriendo < '2012-01-01')
						$contArriendo ++;
				}
				mysqli_free_result($resultArriendo);	
				
				$pagoNoDeducible = ($contArriendo * $valorArriendo);					
				
				if($pagoNoDeducible > 0){
					$fila ++;							
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue("A".$fila, $concepto)	
								->setCellValue("B".$fila, $td)
								->setCellValue("C".$fila, $documentoArrendador)
								->setCellValue("D".$fila, '')
								->setCellValue("E".$fila, $primerApellido)
								->setCellValue("F".$fila, $segundoApellido)
								->setCellValue("G".$fila, $primerNombre)
								->setCellValue("H".$fila, $segundoNombre)
								->setCellValue("I".$fila, '')
								->setCellValue("J".$fila, $direccionA)
								->setCellValue("K".$fila, $direccionB)
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
			mysqli_free_result($resultArrendador);	
		}		
				
		$objPHPExcel->getActiveSheet()->getStyle('A1:AC'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);	
					
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('1016');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = "FORMATO_1016_ARRENDADORES.xls";
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