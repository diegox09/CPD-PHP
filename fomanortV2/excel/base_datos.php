<?php
header("Content-Type: text/html; charset=UTF-8");

include ("../conectar.php");

/**
 * PHPExcel
 * Copyright (C) 2006 - 2010 PHPExcel
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.2, 2010-01-11
 */

/** Error reporting */
error_reporting(E_ALL);

/** PHPExcel */
require_once 'Classes/PHPExcel.php';

/** PHPExcel_IOFactory */
require_once 'Classes/PHPExcel/IOFactory.php';

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
date_default_timezone_set('America/Bogota'); 
$year = date('Y');
$query_select_c = "SELECT * FROM categoria WHERE year = '".$year."' ORDER BY id_categoria";
$rs_select_c = mysql_query($query_select_c);
$contador_c = 0;
while (mysql_num_rows($rs_select_c) > $contador_c){

	$objPHPExcel->setActiveSheetIndex($contador_c);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DOCUMENTO');          
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'TIPO DOCUMENTO');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'NOMBRES');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'APELLIDOS');
	$objPHPExcel->getActiveSheet()->setCellValue('E1', 'CATEGORIA');
	$objPHPExcel->getActiveSheet()->setCellValue('F1', 'NUMERO CAMISETA');		
	$objPHPExcel->getActiveSheet()->setCellValue('G1', 'PUESTO');
	$objPHPExcel->getActiveSheet()->setCellValue('H1', 'TIEMPO (HH:MM:SS)');			
	$objPHPExcel->getActiveSheet()->setCellValue('I1', 'ENTIDAD ó PATROCINADOR');
	$objPHPExcel->getActiveSheet()->setCellValue('J1', 'CIUDAD ó PAIS');
	$objPHPExcel->getActiveSheet()->setCellValue('K1', 'TELEFONO');
	$objPHPExcel->getActiveSheet()->setCellValue('L1', 'DIRECCION');
	$objPHPExcel->getActiveSheet()->setCellValue('M1', 'EPS');	
	$objPHPExcel->getActiveSheet()->setCellValue('N1', 'RH');	
				
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);		
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setWrapText(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
	$fila = 1;		
	$tds = array("", "C.C.", "T.I.", "Otro");
	$id_categoria = mysql_result($rs_select_c,$contador_c,"id_categoria");
	$descripcion_categoria = substr(mysql_result($rs_select_c,$contador_c,"descripcion"),0,20);
	
	$query_select = "SELECT * FROM deportista, tiempo_deportista WHERE tiempo_deportista.id_deportista = deportista.id_deportista AND tiempo_deportista.year = ".$year." AND tiempo_deportista.id_categoria = ".$id_categoria." ORDER BY deportista.nombres, deportista.apellidos";
	$rs_select = mysql_query($query_select);	
	$contador = 0;
					
	while ($contador < mysql_num_rows($rs_select)){	
		$id = mysql_result($rs_select,$contador,"deportista.id_deportista");
		$documento = mysql_result($rs_select,$contador,"deportista.documento");
		$td = mysql_result($rs_select,$contador,"deportista.tipo_documento");
		$nombres = utf8_encode (mysql_result($rs_select,$contador,"deportista.nombres"));
		$apellidos = utf8_encode (mysql_result($rs_select,$contador,"deportista.apellidos"));			
		$entidad = utf8_encode (mysql_result($rs_select,$contador,"deportista.entidad"));
		$pais = utf8_encode (mysql_result($rs_select,$contador,"deportista.pais"));
		$telefono = utf8_encode (mysql_result($rs_select,$contador,"deportista.telefono"));
		$direccion = utf8_encode (mysql_result($rs_select,$contador,"deportista.direccion"));
		$eps = utf8_encode (mysql_result($rs_select,$contador,"deportista.eps"));
		$rh = utf8_encode (mysql_result($rs_select,$contador,"deportista.rh"));
				
		$numero = mysql_result($rs_select,$contador,"tiempo_deportista.numero");		
		$tiempo = mysql_result($rs_select,$contador,"tiempo_deportista.tiempo");
		if($tiempo == "00:00:00")
			$tiempo = "";
		$fila = $contador + 2;	
		
		$objPHPExcel->getActiveSheet()
					->setCellValue("A".$fila, $documento)	
					->setCellValue("B".$fila, $tds[$td])
					->setCellValue("C".$fila, $nombres)
					->setCellValue("D".$fila, $apellidos)
					->setCellValue("E".$fila, $descripcion_categoria)
					->setCellValue("F".$fila, $numero)					
					->setCellValue("H".$fila, $tiempo)
					->setCellValue("I".$fila, $entidad)
					->setCellValue("J".$fila, $pais)
					->setCellValue("K".$fila, $telefono)
					->setCellValue("L".$fila, $direccion)
					->setCellValue("M".$fila, $eps)
					->setCellValue("N".$fila, $rh);
		
					
		$puesto = "";				
		$query_select_2 = "SELECT * FROM tiempo_deportista WHERE id_categoria = '".$id_categoria."' AND year = ".$year." AND tiempo > 0 ORDER BY tiempo";
		$rs_select_2 = mysql_query($query_select_2);
		$contador_2 = 0;
		while (mysql_num_rows($rs_select_2) > $contador_2){
			if($id == mysql_result($rs_select_2,$contador_2,"id_deportista")){
				$puesto = $contador_2+1;
				break;
			}
			$contador_2++;
		}	
						
		$objPHPExcel->getActiveSheet()	
				->setCellValue("G".$fila, $puesto);
				
		$contador ++;		
	}
			
	$objPHPExcel->getActiveSheet()->getStyle('B2:B'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F2:H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->setAutoFilter('A1:N'.$fila);
						
	// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle("$descripcion_categoria");
		
	$contador_c ++;
	if(mysql_num_rows($rs_select_c) > $contador_c)
		$objPHPExcel->createSheet();
	}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//$nombre = "FOMANORT ".date("d/m/Y").".xlsx";
$nombre = "BD. CARRERA ATLETICA ".$year.".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nombre.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output'); 
exit;