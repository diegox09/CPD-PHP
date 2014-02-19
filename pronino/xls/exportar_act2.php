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
		$idPeriodo = $_GET['id_periodo'];
		
		if($idPeriodo == 1)
			$mes = array('ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO');
		else
			$mes = array('JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
			
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
					
					->setCellValue('N1', 'EN QUE MESES HA TRABAJADO EL NIÑO')
					->setCellValue('N2', 'TRABAJO INFANTIL')
					->setCellValue('O2', $mes[0])
					->setCellValue('P2', $mes[1])
					->setCellValue('Q2', $mes[2])
					->setCellValue('R2', $mes[3])					
					->setCellValue('S2', $mes[4])
					->setCellValue('T2', $mes[5])					
					
					->setCellValue('U1', 'PERIODO DEL DIA QUE SE OCUPA DE ESE TRABAJO')
					->setCellValue('U2', 'MAÑANA')
					->setCellValue('V2', 'TARDE')
					->setCellValue('W2', 'NOCHE')
					->setCellValue('X2', 'MADRUGADA')
					
					->setCellValue('Y1', 'EL NIÑO TRABAJA')
					->setCellValue('Y2', 'DIAS UTILES')
					->setCellValue('Z2', 'FINES DE SEMANA')
					->setCellValue('AA2', 'AMBOS')			
					
					->setCellValue('AB1', 'PROMEDIO DE HORAS SEMANALES PERIODO LECTIVO')
					->setCellValue('AB2', 'ESCUELA')
					->setCellValue('AC2', 'CASA')
					->setCellValue('AD2', 'PRONIÑO')
					->setCellValue('AE2', 'TRABAJANDO')
					->setCellValue('AF2', 'JUGANDO')					
					->setCellValue('AG2', 'OTRAS')
					
					->setCellValue('AH1', 'PROMEDIO DE HORAS SEMANALES PERIODO VACACIONES')
					->setCellValue('AH2', 'ESCUELA')
					->setCellValue('AI2', 'CASA')
					->setCellValue('AJ2', 'PRONIÑO')
					->setCellValue('AK2', 'TRABAJANDO')
					->setCellValue('AL2', 'JUGANDO')					
					->setCellValue('AM2', 'OTRAS');
		
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
		$objPHPExcel->getActiveSheet()->mergeCells('N1:T1');
		$objPHPExcel->getActiveSheet()->mergeCells('U1:X1');
		$objPHPExcel->getActiveSheet()->mergeCells('Y1:AA1');
		$objPHPExcel->getActiveSheet()->mergeCells('AB1:AG1');	
		$objPHPExcel->getActiveSheet()->mergeCells('AH1:AM1');
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:AM2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AM2')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AM2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA07A');
		$objPHPExcel->getActiveSheet()->getStyle('I1:M2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');	
		$objPHPExcel->getActiveSheet()->getStyle('N1:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');	
		$objPHPExcel->getActiveSheet()->getStyle('U1:X2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');
		$objPHPExcel->getActiveSheet()->getStyle('Y1:AA2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
		$objPHPExcel->getActiveSheet()->getStyle('AB1:AG2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');
		$objPHPExcel->getActiveSheet()->getStyle('AH1:AM2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
		
		$objPHPExcel->getActiveSheet()->freezePane('A3');		
		
		$fila = 2;
				
		$genero = array('', 'Femenino', 'Masculino');			
	
		$result = Pronino::getInstance()->get_exportar_resumen_actividades($year, $idDepartamento, $idPeriodo);
							
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
						
			
			$resultActividades = Pronino::getInstance()->get_actividades_by_periodo($idBeneficiario, $year, $idPeriodo);
									
			$periodoLectivo = array(0,0,0,0,0,0);
			$periodoVacaciones = array(0,0,0,0,0,0);
			
			$meses = array(0,0,0,0,0,0);				
			$dias = array(0,0,0);
			$horas = array(0,0,0,0);
			
			$diaHora = array('');
			$actividadMes = array('');	
			
			$periodo = 0;
			
			$mesesPeriodo = array('','','','','','');
			$mesesPeriodoL = 0;
			$mesesPeriodoV = 0;					
							
			while ($semana = mysqli_fetch_array($resultActividades)){									
				if($semana['mes'] == 1 || $semana['mes'] == 6 || $semana['mes'] == 7 || $semana['mes'] == 12){
					switch($semana['idActividad']){
						case 1:	$periodoVacaciones[0]++;
								break;
						case 2:	$periodoVacaciones[1]++;
								break;
						case 3:	$periodoVacaciones[2]++;
								break;
						case 4:	$periodoVacaciones[3]++;
								break;
						case 5:	$periodoVacaciones[4]++;
								break;
						case 6:	$periodoVacaciones[5]++;
								break;								
					}
				}
				else{
					switch($semana['idActividad']){
						case 1:	$periodoLectivo[0]++;
								break;
						case 2:	$periodoLectivo[1]++;
								break;
						case 3:	$periodoLectivo[2]++;
								break;
						case 4:	$periodoLectivo[3]++;
								break;
						case 5:	$periodoLectivo[4]++;
								break;
						case 6:	$periodoLectivo[5]++;
								break;								
					}
				}
				
				
				if($mes <= 6){
					$periodo = 1;
					
					switch($semana['mes']){
						case 1:	$mesesPeriodo[0] = 'X';							
								break;
						case 2:	$mesesPeriodo[1] = 'X';
								break;
						case 3:	$mesesPeriodo[2] = 'X';
								break;
						case 4:	$mesesPeriodo[3] = 'X';
								break;
						case 5:	$mesesPeriodo[4] = 'X';
								break;
						case 6:	$mesesPeriodo[5] = 'X';
								break;									
					}
					
					if($semana['idActividad'] == 4){				
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
						}
						
						switch($semana['dia']){
							case 1:	$dias[0]++;
									break;
							case 2:	$dias[0]++;
									break;
							case 3:	$dias[0]++;
									break;
							case 4:	$dias[0]++;
									break;
							case 5:	$dias[0]++;
									break;
							case 6:	$dias[1]++;
									break;
							case 7:	$dias[1]++;
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
				}
				
				else{
					$periodo = 2;
					
					switch($semana['mes']){
						case 7:	$mesesPeriodo[0] = 'X';
								break;
						case 8:	$mesesPeriodo[1] = 'X';
								break;
						case 9:	$mesesPeriodo[2] = 'X';
								break;
						case 10:$mesesPeriodo[3] = 'X';
								break;
						case 11:$mesesPeriodo[4] = 'X';
								break;
						case 12:$mesesPeriodo[5] = 'X';
								break;										
					}
					
					if($semana['idActividad'] == 4){
						switch($semana['mes']){
							case 7:	$meses[0]++;
									break;
							case 8:	$meses[1]++;
									break;
							case 9:	$meses[2]++;
									break;
							case 10:$meses[3]++;
									break;
							case 11:$meses[4]++;
									break;
							case 12:$meses[5]++;
									break;										
						}
						
						switch($semana['dia']){
							case 1:	$dias[0]++;
									break;
							case 2:	$dias[0]++;
									break;
							case 3:	$dias[0]++;
									break;
							case 4:	$dias[0]++;
									break;
							case 5:	$dias[0]++;
									break;
							case 6:	$dias[1]++;
									break;
							case 7:	$dias[1]++;
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
				}			
			}
			mysqli_free_result($resultActividades);
			
			for($i=0; $i<6; $i++){
				if($i == 0 || $i == 5){
					if($mesesPeriodo[$i] != '')
						$mesesPeriodoV ++;
				}
				else{	
					if($mesesPeriodo[$i] != '')
						$mesesPeriodoL ++;	
				}
			}
			
			if($mesesPeriodoL != 0){
				for($i=0; $i<6; $i++)
					$periodoLectivo[$i] = number_format(($periodoLectivo[$i] / $mesesPeriodoL),0);
			}
			
			if($mesesPeriodoV != 0){
				for($i=0; $i<6; $i++)
					$periodoVacaciones[$i] = number_format(($periodoVacaciones[$i] / $mesesPeriodoV),0);
			}	
			
			if($dias[0] != '' && $dias[1] != ''){
				$dias[2] = $dias[0] + $dias[1];
				$dias[0] = 0;
				$dias[1] = 0;
			}
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("A".$fila, $idItem)	
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
						
						->setCellValue('N'.$fila, '')
						->setCellValue('O'.$fila, $meses[0])
						->setCellValue('P'.$fila, $meses[1])
						->setCellValue('Q'.$fila, $meses[2])
						->setCellValue('R'.$fila, $meses[3])
						->setCellValue('S'.$fila, $meses[4])
						->setCellValue('T'.$fila, $meses[5])
						
						->setCellValue('U'.$fila, $horas[1])
						->setCellValue('V'.$fila, $horas[2])
						->setCellValue('W'.$fila, $horas[3])
						->setCellValue('X'.$fila, $horas[0])
						
						->setCellValue('Y'.$fila, $dias[0])						
						->setCellValue('Z'.$fila, $dias[1])
						->setCellValue('AA'.$fila, $dias[2])
						
						->setCellValue('AB'.$fila, $periodoLectivo[0])
						->setCellValue('AC'.$fila, $periodoLectivo[1])						
						->setCellValue('AD'.$fila, $periodoLectivo[2])
						->setCellValue('AE'.$fila, $periodoLectivo[3])
						->setCellValue('AF'.$fila, $periodoLectivo[4])
						->setCellValue('AG'.$fila, $periodoLectivo[5])
						
						->setCellValue('AH'.$fila, $periodoVacaciones[0])						
						->setCellValue('AI'.$fila, $periodoVacaciones[1])
						->setCellValue('AJ'.$fila, $periodoVacaciones[2])
						->setCellValue('AK'.$fila, $periodoVacaciones[3])
						->setCellValue('AL'.$fila, $periodoVacaciones[4])
						->setCellValue('AM'.$fila, $periodoVacaciones[5]);
		}
		mysqli_free_result($result);				
												
		$objPHPExcel->getActiveSheet()->getStyle('A1:AM'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);			
		$objPHPExcel->getActiveSheet()->getStyle('D3:F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('N3:AM'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);						
													
		// Rename sheet
		if($idPeriodo == 1)
			$mes = 'ENE - JUN';
		else			
			$mes = 'JUL - DIC';
			
		$nombre = 'RESUMEN ACT. '.$mes.' - '.$year;
		$objPHPExcel->getActiveSheet()->setTitle($nombre);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = 'RESUMEN ACT. '.$mes.' - '.date("d.m.Y").".xls";
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