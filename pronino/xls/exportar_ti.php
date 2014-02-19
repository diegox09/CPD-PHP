<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');
	
	session_start();
		
	require_once('../php/classes/Pronino.php');
	require_once('../php/funciones/funciones.php');
	
	$logonSuccess = false;
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
	
	if($logonSuccess){
		$year = $_GET['year'];		
		$idDepartamento = $_GET['id_departamento'];
		$idActividad = $_GET['id_actividad'];
		
		error_reporting(E_ALL);
		require_once '../../php/phpexcel/PHPExcel.php';
		require_once '../../php/phpexcel/PHPExcel/IOFactory.php';
		
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
					->setCellValue('A1', 'INFORMACION DEL BENEFICIARIO')
					->setCellValue('A2', 'ITEM')            
					->setCellValue('B2', 'NOMBRES')
					->setCellValue('C2', 'APELLIDOS')
					->setCellValue('D2', 'GENERO')
					->setCellValue('E2', 'FECHA NACIMIENTO')
					->setCellValue('F2', 'EDAD')	
					->setCellValue('G2', 'DEPARTAMENTO')
					->setCellValue('H2', 'MUNICIPIO')
					
					->setCellValue('I1', 'INFORMACION PROGRAMA PRONIÑO')					
					->setCellValue('I2', 'SITIO TRABAJO')
					->setCellValue('J2', 'ACTIVIDAD LABORAL')
					->setCellValue('K2', 'ACTIVIDAD ESPECIFICA')
					->setCellValue('L2', 'PROFESIONAL')
					->setCellValue('M2', 'COORDINADOR')	
					
					->setCellValue('N1', 'MESES')
					->setCellValue('N2', 'ENERO')
					->setCellValue('O2', 'FEBRERO')
					->setCellValue('P2', 'MARZO')
					->setCellValue('Q2', 'ABRIL')
					->setCellValue('R2', 'MAYO')
					->setCellValue('S2', 'JUNIO')
					->setCellValue('T2', 'JULIO')
					->setCellValue('U2', 'AGOSTO')
					->setCellValue('V2', 'SEPTIEMBRE')
					->setCellValue('W2', 'OCTUBRE')
					->setCellValue('X2', 'NOVIEMBRE')
					->setCellValue('Y2', 'DICIEMBRE')			
					
					->setCellValue('Z1', 'PERIODO DEL DIA')
					->setCellValue('Z2', 'MADRUGADA')
					->setCellValue('AA2', 'MAÑANA')
					->setCellValue('AB2', 'TARDE')
					->setCellValue('AC2', 'NOCHE')
					
					->setCellValue('AD1', 'DIAS')
					->setCellValue('AD2', 'LUNES')
					->setCellValue('AE2', 'MARTES')
					->setCellValue('AF2', 'MIERCOLES')
					->setCellValue('AG2', 'JUEVES')
					->setCellValue('AH2', 'VIERNES')
					->setCellValue('AI2', 'SABADO')
					->setCellValue('AJ2', 'DOMINGO');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
					
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->mergeCells('I1:M1');
		$objPHPExcel->getActiveSheet()->mergeCells('N1:Y1');
		$objPHPExcel->getActiveSheet()->mergeCells('Z1:AC1');
		$objPHPExcel->getActiveSheet()->mergeCells('AD1:AJ1');	
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:AJ2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AJ2')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AJ2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA07A');
		$objPHPExcel->getActiveSheet()->getStyle('I1:M2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');	
		$objPHPExcel->getActiveSheet()->getStyle('N1:Y2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');	
		$objPHPExcel->getActiveSheet()->getStyle('Z1:AC2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');
		$objPHPExcel->getActiveSheet()->getStyle('AD1:AJ2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
		
		$objPHPExcel->getActiveSheet()->freezePane('A3');		
		
		$fila = 2;
				
		$genero = array('', 'Femenino', 'Masculino');			
	
		if($idDepartamento != 0)			
			$result = Pronino::getInstance()->get_exportar_detalle_actividades_by_departamento($year, $idDepartamento, $idActividad);
		else
			$result = Pronino::getInstance()->get_exportar_detalle_actividades($year, $idActividad);
							
		while ($id = mysqli_fetch_array($result)){
			$beneficiario = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($id['idBeneficiario']));		
			$fila ++;
			
			$idBeneficiario = $beneficiario['idBeneficiario'];	
			$nombreBeneficiario = utf8_encode($beneficiario['nombreBeneficiario']);
			$apellidoBeneficiario = utf8_encode($beneficiario['apellidoBeneficiario']);
			$td = $beneficiario['tipoDocumento'];
			$documentoBeneficiario = $beneficiario['documentoBeneficiario'];
			$fechaNacimiento = implota($beneficiario['fechaNacimiento']);
			$edad = edad($beneficiario['fechaNacimiento']);
			$idGenero = $beneficiario['genero'];	
			
			$direccion = utf8_encode($beneficiario['direccion']);
			$idBarrio = $beneficiario['idBarrio'];	
			$nombreBarrio = '';
			if($idBarrio != 0){
				$barrio = mysqli_fetch_array(Pronino::getInstance()->get_barrio_by_id($idBarrio));	
				$nombreBarrio = utf8_encode($barrio['nombreBarrio']);
			}
			$idMunicipio = $beneficiario['idMunicipio'];
			$idDepartamento = 0;
			$nombreMunicipio = '';
			if($idMunicipio != 0){
				$municipio = mysqli_fetch_array(Pronino::getInstance()->get_municipio_by_id($idMunicipio));	
				$nombreMunicipio = utf8_encode($municipio['nombreMunicipio']);
				$idDepartamento = $municipio['idDepartamento'];
			}	
			
			$nombreDepartamento = '';
			if($idDepartamento != 0){
				$departamento = mysqli_fetch_array(Pronino::getInstance()->get_departamento_by_id($idDepartamento));	
				$nombreDepartamento = utf8_encode($departamento['nombreDepartamento']);
			}
			
			
			$beneficiario_pronino = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario));			
			$idItem = $beneficiario_pronino['item'];
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($beneficiario_pronino['idUsuario1']));					
			$usuario1 = utf8_encode($usuario['user']);	
			
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($beneficiario_pronino['idUsuario2']));					
			$usuario2 = utf8_encode($usuario['user']);
			
			$beneficiario_year = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year));									
			$idSitioTrabajo = $beneficiario_year['sitioTrabajo'];
			$sitioTrabajo = '';
			if($idSitioTrabajo != 0){
				$sitio = mysqli_fetch_array(Pronino::getInstance()->get_sitio_by_id($idSitioTrabajo));	
				$sitioTrabajo = utf8_encode($sitio['nombreSitio']);
			}
			
			$idActividadLaboral = $beneficiario_year['actividadLaboral'];
			$actividadLaboral = '';					
			if($idActividadLaboral != 0){
				$actividad = mysqli_fetch_array(Pronino::getInstance()->get_actividad_by_id($idActividadLaboral));	
				$actividadLaboral = utf8_encode($actividad['nombreActividad']);
			}			
			$actividadEspecifica = utf8_encode($beneficiario_year['actividadEspecifica']);			
						
			
			$resultTrabajo = Pronino::getInstance()->get_trabajo_infantil_by_year($idBeneficiario, $year, $idActividad);
						
			$meses = array(0,0,0,0,0,0,0,0,0,0,0,0);				
			$dias = array(0,0,0,0,0,0,0);
			$horas = array(0,0,0,0);					
							
			while ($semana = mysqli_fetch_array($resultTrabajo)){
				switch($semana['mes']){
					case 1:	$meses[0]++;										
							break;
					case 2:	$meses[1]++;
							break;
					case 3:	$meses[2]++;
							break;
					case 4:	$meses[3]++;
							break;
					case 5:	$meses[4]++;
							break;
					case 6:	$meses[5]++;	
							break;	
					case 7:	$meses[6]++;										
							break;
					case 8:	$meses[7]++;
							break;
					case 9:	$meses[8]++;
							break;
					case 10:	$meses[9]++;
							break;
					case 11:	$meses[10]++;
							break;
					case 12:	$meses[11]++;	
							break;										
				}
						
				switch($semana['dia']){
					case 1:	$dias[0]++;
							break;
					case 2:	$dias[1]++;
							break;
					case 3:	$dias[2]++;
							break;
					case 4:	$dias[3]++;
							break;
					case 5:	$dias[4]++;
							break;
					case 6:	$dias[5]++;
							break;
					case 7:	$dias[6]++;
							break;					
				}
						
				switch($semana['hora']){
					case 0:	$horas[0]++;
							break;
					case 1:	$horas[0]++;
							break;
					case 2:	$horas[0]++;
							break;
					case 3:	$horas[0]++;
							break;
					case 4:	$horas[0]++;
							break;
					case 5:	$horas[1]++;
							break;
					case 6:	$horas[1]++;
							break;
					case 7:	$horas[1]++;
							break;
					case 8:	$horas[1]++;
							break;
					case 9:	$horas[1]++;
							break;
					case 10:$horas[1]++;
							break;
					case 11:$horas[1]++;
							break;
					case 12:$horas[2]++;
							break;
					case 13:$horas[2]++;
							break;
					case 14:$horas[2]++;
							break;
					case 15:$horas[2]++;
							break;
					case 16:$horas[2]++;
							break;																		
					case 17:$horas[2]++;
							break;
					case 18:$horas[3]++;
							break;	
					case 19:$horas[3]++;
							break;	
					case 20:$horas[3]++;
							break;	
					case 21:$horas[3]++;
							break;	
					case 22:$horas[3]++;
							break;	
					case 23:$horas[3]++;
							break;															
				}	
			}
			mysqli_free_result($resultTrabajo);
			
			$objPHPExcel->getActiveSheet()->getCell('A'.$fila)->setValueExplicit($idItem,PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)
						//->setCellValue("A".$fila, $idItem)	
						->setCellValue("B".$fila, $nombreBeneficiario)
						->setCellValue("C".$fila, $apellidoBeneficiario)
						->setCellValue("D".$fila, $genero[$idGenero])
						->setCellValue("E".$fila, $fechaNacimiento)
						->setCellValue("F".$fila, $edad)						
						->setCellValue("G".$fila, $nombreDepartamento)
						->setCellValue("H".$fila, $nombreMunicipio)	
									
						->setCellValue('I'.$fila, $sitioTrabajo)
						->setCellValue('J'.$fila, $actividadLaboral)
						->setCellValue('K'.$fila, $actividadEspecifica)
						->setCellValue('L'.$fila, $usuario1)
						->setCellValue('M'.$fila, $usuario2)
						
						->setCellValue('N'.$fila, $meses[0])
						->setCellValue('O'.$fila, $meses[1])
						->setCellValue('P'.$fila, $meses[2])
						->setCellValue('Q'.$fila, $meses[3])
						->setCellValue('R'.$fila, $meses[4])
						->setCellValue('S'.$fila, $meses[5])
						->setCellValue('T'.$fila, $meses[6])
						->setCellValue('U'.$fila, $meses[7])
						->setCellValue('V'.$fila, $meses[8])
						->setCellValue('W'.$fila, $meses[9])
						->setCellValue('X'.$fila, $meses[10])
						->setCellValue('Y'.$fila, $meses[11])
						
						->setCellValue('Z'.$fila, $horas[0])
						->setCellValue('AA'.$fila, $horas[1])
						->setCellValue('AB'.$fila, $horas[2])
						->setCellValue('AC'.$fila, $horas[3])
						
						->setCellValue('AD'.$fila, $dias[0])
						->setCellValue('AE'.$fila, $dias[1])
						->setCellValue('AF'.$fila, $dias[2])
						->setCellValue('AG'.$fila, $dias[3])
						->setCellValue('AH'.$fila, $dias[4])
						->setCellValue('AI'.$fila, $dias[5])
						->setCellValue('AJ'.$fila, $dias[6]);
		}
		mysqli_free_result($result);				
												
		$objPHPExcel->getActiveSheet()->getStyle('A1:AJ'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);			
		$objPHPExcel->getActiveSheet()->getStyle('D3:F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('N3:AJ'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		
		
		$actividades = array('', 'ACTIVIDADES EN LA ESCUELA', 'ACTIVIDADES EN LA CASA', 'ACTIVIDADES PRONIÑO', 'TRABAJANDO', 'JUGANDO', 'OTRAS ACTIVIDADES');												
		// Rename sheet
		$nombre = $actividades[$idActividad].' '.$year;
		$objPHPExcel->getActiveSheet()->setTitle($nombre);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = $actividades[$idActividad].' '.date("d.m.Y").".xls";
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