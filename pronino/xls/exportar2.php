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
					->setCellValue('G2', 'TIPO DOCUMENTO')
					->setCellValue('H2', 'NUMERO DOCUMENTO')					
					->setCellValue('I2', 'TALLA UNIFORME')
					->setCellValue('J2', 'TALLA ZAPATO')
					->setCellValue('K2', 'SISBEN')
					->setCellValue('L2', 'ARS')
					
					->setCellValue('M1', 'INFORMACION DEL ACUDIENTE')
					->setCellValue('M2', 'DOCUMENTO ACUDIENTE')					
					->setCellValue('N2', 'NOMBRES ACUDIENTE')
					->setCellValue('O2', 'APELLIDOS ACUDIENTE')
					->setCellValue('P2', 'DEPARTAMENTO')
					->setCellValue('Q2', 'MUNICIPIO')
					->setCellValue('R2', 'DIRECCION')
					->setCellValue('S2', 'BARRIO')
					->setCellValue('T2', 'TELEFONO')
					
					->setCellValue('U1', 'INFORMACION PROGRAMA PRONIÑO')
					->setCellValue('U2', 'FECHA INGRESO')
					->setCellValue('V2', 'ESTADO')
					->setCellValue('W2', 'FECHA RETIRO')
					->setCellValue('X2', 'RAZON RETIRO')
					->setCellValue('Y2', 'SITIO TRABAJO')
					->setCellValue('Z2', 'ACTIVIDAD LABORAL')
					->setCellValue('AA2', 'ACTIVIDAD ESPECIFICA')
					->setCellValue('AB2', 'INTERES ESCUELA DE FORMACION 1')
					->setCellValue('AC2', 'INTERES ESCUELA DE FORMACION 2')
					->setCellValue('AD2', 'PROFESIONAL')
					->setCellValue('AE2', 'COORDINADOR')
					->setCellValue('AF2', 'OBSERVACIONES')
					
					->setCellValue('AG1', 'INFORMACION DE LA INSTITUCION')
					->setCellValue('AG2', 'MUNICIPIO')
					->setCellValue('AH2', 'COLEGIO')
					->setCellValue('AI2', 'SEDE')
					->setCellValue('AJ2', 'GRADO')
					->setCellValue('AK2', 'JORNADA')	
					->setCellValue('AL2', 'COORDINADOR COLEGIO')
					->setCellValue('AM2', 'NOTAS 1 PERIODO ESPAÑOL')
					->setCellValue('AN2', 'NOTAS 1 PERIODO MATEMAT.')
					->setCellValue('AO2', 'NOTAS 2 PERIODO ESPAÑOL')
					->setCellValue('AP2', 'NOTAS 2 PERIODO MATEMAT.')
					->setCellValue('AQ2', 'NOTAS 3 PERIODO ESPAÑOL')
					->setCellValue('AR2', 'NOTAS 3 PERIODO MATEMAT.')
					->setCellValue('AS2', 'NOTAS 4 PERIODO ESPAÑOL')
					->setCellValue('AT2', 'NOTAS 4 PERIODO MATEMAT.')
					
					->setCellValue('AU1', 'INFORMACION ADICIONAL')
					->setCellValue('AU2', 'DESPLAZADOS')
					->setCellValue('AV2', 'RED UNIDOS')
					->setCellValue('AW2', 'FAMILIAS EN ACCION')
					->setCellValue('AX2', 'COMEDOR INFANTIL')
					->setCellValue('AY2', 'ENTREGA DE KIT ESCOLAR')
					->setCellValue('AZ2', 'ENTREGA DE UNIFORME')
					->setCellValue('BA2', 'ENTREGA DE ZAPATOS')
					->setCellValue('BB2', 'VISITA DOMICILIARIA')
					->setCellValue('BC2', 'VISITA ACADEMICA')
					->setCellValue('BD2', 'VISITA PSICOSOCIAL')					
					->setCellValue('BE2', 'INTERVENCION PSICOLOGICA')
					->setCellValue('BF2', 'VALORACION MEDICA')
					->setCellValue('BG2', 'VALORACION ODONTOLOGICA')
					->setCellValue('BH2', 'USUARIO ACTUALIZO')
					->setCellValue('BI2', 'FECHA ACTUALIZACION');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);		
		$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(15);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(25);	
		$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(10);				
		$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setWidth(16);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
		
		//combinar
		$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
		$objPHPExcel->getActiveSheet()->mergeCells('M1:T1');
		$objPHPExcel->getActiveSheet()->mergeCells('U1:AF1');
		$objPHPExcel->getActiveSheet()->mergeCells('AG1:AT1');
		$objPHPExcel->getActiveSheet()->mergeCells('AU1:BI1');	
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:BI2')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:BI2')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:BI2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA07A');
		$objPHPExcel->getActiveSheet()->getStyle('M1:T2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA07A');
		$objPHPExcel->getActiveSheet()->getStyle('U1:AF2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB0C4DE');
		$objPHPExcel->getActiveSheet()->getStyle('AG1:AT2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF3CB371');
		$objPHPExcel->getActiveSheet()->getStyle('AU1:BI2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFC0C0C0');
		
		$objPHPExcel->getActiveSheet()->freezePane('A3');		
		
		$fila = 2;
		
		$tipoDocumento = array('', 'Cedula de Ciudadania', 'Nuip', 'Registro Civil', 'Tarjeta de Identidad');
		$genero = array('', 'Femenino', 'Masculino');
		$tallaUniformes = array(0 => '', 6 => 6, 8 => 8, 10 => 10, 12 => 12, 13 => 13, 14 => 14, 16 => 16, 18 => 18, 28 => 28, 32 => 32, 35 => 35, 36 => 36, 38 => 'S (38-40)', 40 => 'M (40-42)', 42 => 'L (42-44)');		
		$sisben = array('', 'I', 'II', 'III');	
		$estado = array('', 'Activo', 'Inactivo');
		$razonRetiro = array('', 'Desertor', 'Expulsado', 'Retirado');
		$jornada = array('', 'Mañana', 'Tarde', 'Sabados', 'Noche');
		$notas = array('-', 'Bajo', 'Basico', 'Alto', 'Sup.');
		$confirmar = array('', 'X');
		
		if($idDepartamento != 0)			
			$result = Pronino::getInstance()->get_exportar_by_departamento($year, $idDepartamento);
		else
			$result = Pronino::getInstance()->get_exportar_by_year($year);
			
		while ($beneficiario = mysqli_fetch_array($result)){	
			$fila ++;
			
			$idBeneficiario = $beneficiario['idBeneficiario'];			
			$idItem = $beneficiario['item'];
			$nombreBeneficiario = utf8_encode($beneficiario['nombreBeneficiario']);
			$apellidoBeneficiario = utf8_encode($beneficiario['apellidoBeneficiario']);
			$td = $beneficiario['tipoDocumento'];
			$documentoBeneficiario = $beneficiario['documentoBeneficiario'];
			$fechaNacimiento = implota($beneficiario['fechaNacimiento']);
			$edad = edad($beneficiario['fechaNacimiento']);
			$idGenero = $beneficiario['genero'];
			$tallaUniforme = $beneficiario['tallaUniforme'];
			$tallaZapato = $beneficiario['tallaZapato'];
			if($tallaZapato == 0)
				$tallaZapato = '';
				
			$idSisben = $beneficiario['sisben'];
			$idArs = $beneficiario['idArs'];
			$nombreArs = '';
			if($idArs != 0){
				$ars = mysqli_fetch_array(Pronino::getInstance()->get_ars_by_id($idArs));	
				$nombreArs = utf8_encode($ars['nombreArs']);				
			}							
					
			$fechaIngreso = implota($beneficiario['fechaIngreso']);
			$idEstado = $beneficiario['estado'];
			$fechaRetiro = implota($beneficiario['fechaRetiro']);
			$idRazonRetiro = $beneficiario['razonRetiro'];
			$observaciones = utf8_encode($beneficiario['observaciones']);
			
			$idUsuario1 = $beneficiario['idUsuario1']; 
			$usuario1 = '';
			if($idUsuario1 != 0){
				$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUsuario1));					
				$usuario1 = utf8_encode($usuario['user']);						
			}
			$idUsuario2 = $beneficiario['idUsuario2'];
			$usuario2 = '';
			if($idUsuario2 != 0){
				$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUsuario2));			
				$usuario2 = utf8_encode($usuario['user']);
			}
			
			$idAcudiente = $beneficiario['idAcudiente'];
			$acudiente = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($idAcudiente));
			$documentoAcudiente = $acudiente['documentoBeneficiario'];
			$nombreAcudiente = utf8_encode($acudiente['nombreBeneficiario']);
			$apellidoAcudiente = utf8_encode($acudiente['apellidoBeneficiario']);
					
			$telefono = $beneficiario['telefono'];
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
						
			$idSitioTrabajo = $beneficiario['sitioTrabajo'];
			$sitioTrabajo = '';
			if($idSitioTrabajo != 0){
				$sitio = mysqli_fetch_array(Pronino::getInstance()->get_sitio_by_id($idSitioTrabajo));	
				$sitioTrabajo = utf8_encode($sitio['nombreSitio']);
			}
			
			$idActividadLaboral = $beneficiario['actividadLaboral'];
			$actividadLaboral = '';					
			if($idActividadLaboral != 0){
				$actividad = mysqli_fetch_array(Pronino::getInstance()->get_actividad_by_id($idActividadLaboral));	
				$actividadLaboral = utf8_encode($actividad['nombreActividad']);
			}
			
			$actividadEspecifica = utf8_encode($beneficiario['actividadEspecifica']);
			$observacionesYear = utf8_encode($beneficiario['observaciones']);
			
			$idEscuelaFormacion1 = $beneficiario['escuelaFormacion1']; 
			$escuelaFormacion1 = '';
			if($idEscuelaFormacion1 != 0){
				$escuela = mysqli_fetch_array(Pronino::getInstance()->get_escuela_by_id($idEscuelaFormacion1));
				$escuelaFormacion1 = utf8_encode($escuela['nombreEscuela']);
			}
			$idEscuelaFormacion2 = $beneficiario['escuelaFormacion2'];
			$escuelaFormacion2 = '';
			if($idEscuelaFormacion2 != 0){
				$escuela = mysqli_fetch_array(Pronino::getInstance()->get_escuela_by_id($idEscuelaFormacion2));
				$escuelaFormacion2 = utf8_encode($escuela['nombreEscuela']);
			}					
				
			$kitEscolar = implota($beneficiario['kitEscolar']);
			$uniforme = implota($beneficiario['uniforme']);
			$zapatos = implota($beneficiario['zapatos']);
			$visitaDomiciliaria = implota($beneficiario['visitaDomiciliaria']);
			$visitaAcademica = implota($beneficiario['visitaAcademica']);
			$visitaPsicosocial = implota($beneficiario['visitaPsicosocial']);					
			$intervencionPsicologica = implota($beneficiario['intervencionPsicologica']);
			$valoracionMedica = implota($beneficiario['valoracionMedica']);
			$valoracionOdontologica = implota($beneficiario['valoracionOdontologica']);	
							
			$desplazados = $beneficiario['desplazados'];
			$juntos = $beneficiario['juntos'];				
			$familiasAccion = $beneficiario['familiasAccion'];				
			$comedorInfantil = $beneficiario['comedorInfantil'];
			
			$idMunicipioColegio = $beneficiario['idMunicipioColegio'];
			$nombreMunicipioColegio = '';
			if($idMunicipioColegio != 0){
				$municipioColegio = mysqli_fetch_array(Pronino::getInstance()->get_municipio_by_id($idMunicipioColegio));	
				$nombreMunicipioColegio = utf8_encode($municipioColegio['nombreMunicipio']);
			}					
				
			$idColegio = $beneficiario['idColegio'];
			$nombreColegio = '';
			if($idColegio != 0){
				$colegio = mysqli_fetch_array(Pronino::getInstance()->get_colegio_by_id($idColegio));
				$nombreColegio = utf8_encode($colegio['nombreColegio']);	
			}
			$idSedeColegio = $beneficiario['idSedeColegio'];
			$nombreSedeColegio = '';
			$nombreCoordinador = '';
			if($idSedeColegio != 0){								
				$sede = mysqli_fetch_array(Pronino::getInstance()->get_sede_by_id($idSedeColegio));	
				$nombreSedeColegio = utf8_encode($sede['nombreSede']);
				$nombreCoordinador = utf8_encode($sede['nombreCoordinador']);
			}	
			$grado = $beneficiario['grado'];
			if($grado == 0)
				$grado = '';
			$idJornada = $beneficiario['jornada'];
			
			$fa = mysqli_fetch_array(Pronino::getInstance()->get_fecha_actualizacion_year($idBeneficiario, $year));
			$fechaActualizacion = $fa['fechaActualizacion'];
			$idUser = $fa['idUser'];
			
			$max = mysqli_fetch_array(Pronino::getInstance()->get_ultima_fecha_actualizacion($idBeneficiario));
			if($max[0] != NULL){
				if($max[0] > $fechaActualizacion){
					$fechaActualizacion = $max[0];
					$idUser = $max[1];				
				}
			}			
			
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
			$usuarioActualizo = utf8_encode($usuario['user']);
			
			$periodo1 = array(0,'-',0,'-');
			$periodo2 = array(0,'-',0,'-');
			$periodo3 = array(0,'-',0,'-');
			$periodo4 = array(0,'-',0,'-');
			$resultNotas = Pronino::getInstance()->get_beneficiario_notas_by_year($idBeneficiario, $year);
			while ($nota = mysqli_fetch_array($resultNotas)){
				$tipo = $nota['tipoNota'];
				switch($nota['idPeriodo']){
					case '1':	if($nota['idMateria'] == 1){							
									$periodo1[0] = $nota['nota'];									
									$periodo1[1] = $notas[$tipo];
								}
								else{
									$periodo1[2] = $nota['nota'];
									$periodo1[3] = $notas[$tipo];
								}
								break;
					case '2':	if($nota['idMateria'] == 1)	{						
									$periodo2[0] = $nota['nota'];
									$periodo2[1] = $notas[$tipo];
								}
								else{
									$periodo2[2] = $nota['nota'];
									$periodo2[3] = $notas[$tipo];
								}
								break;			
					case '3':	if($nota['idMateria'] == 1){							
									$periodo3[0] = $nota['nota'];
									$periodo3[1] = $notas[$tipo];
								}
								else{
									$periodo3[2] = $nota['nota'];
									$periodo3[3] = $notas[$tipo];
								}
								break;			
					case '4':	if($nota['idMateria'] == 1){								
									$periodo4[0] = $nota['nota'];
									$periodo4[1] = $notas[$tipo];
								}
								else{
									$periodo4[2] = $nota['nota'];
									$periodo4[3] = $notas[$tipo];
								}
								break;			
				}															
			}
			mysqli_free_result($resultNotas);				
			
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("A".$fila, $idItem)	
						->setCellValue("B".$fila, $nombreBeneficiario)
						->setCellValue("C".$fila, $apellidoBeneficiario)
						->setCellValue("D".$fila, $genero[$idGenero])
						->setCellValue("E".$fila, $fechaNacimiento)
						->setCellValue("F".$fila, $edad)
						->setCellValue("G".$fila, $tipoDocumento[$td])
						->setCellValue("H".$fila, $documentoBeneficiario)						
						->setCellValue("I".$fila, $tallaUniformes[$tallaUniforme])
						->setCellValue("J".$fila, $tallaZapato)
						->setCellValue("K".$fila, $sisben[$idSisben])
						->setCellValue("L".$fila, $nombreArs)
						
						->setCellValue("M".$fila, $documentoAcudiente)
						->setCellValue("N".$fila, $nombreAcudiente)
						->setCellValue("O".$fila, $apellidoAcudiente)
						->setCellValue("P".$fila, $nombreDepartamento)
						->setCellValue("Q".$fila, $nombreMunicipio)
						->setCellValue("R".$fila, $direccion)
						->setCellValue("S".$fila, $nombreBarrio)
						->setCellValue("T".$fila, $telefono)							
						
						->setCellValue("U".$fila, $fechaIngreso)
						->setCellValue("V".$fila, $estado[$idEstado])
						->setCellValue("W".$fila, $fechaRetiro)
						->setCellValue("X".$fila, $razonRetiro[$idRazonRetiro])						
						->setCellValue('Y'.$fila, $sitioTrabajo)
						->setCellValue('Z'.$fila, $actividadLaboral)
						->setCellValue('AA'.$fila, $actividadEspecifica)
						->setCellValue('AB'.$fila, $escuelaFormacion1)
						->setCellValue('AC'.$fila, $escuelaFormacion2)
						->setCellValue('AD'.$fila, $usuario1)
						->setCellValue('AE'.$fila, $usuario2)
						->setCellValue('AF'.$fila, $observacionesYear)
						
						->setCellValue('AG'.$fila, $nombreMunicipioColegio)
						->setCellValue('AH'.$fila, $nombreColegio)
						->setCellValue('AI'.$fila, $nombreSedeColegio)
						->setCellValue('AJ'.$fila, $grado)
						->setCellValue('AK'.$fila, $jornada[$idJornada])	
						->setCellValue('AL'.$fila, $nombreCoordinador)
						
						->setCellValue('AM'.$fila, $periodo1[0].' - '.$periodo1[1])
						->setCellValue('AN'.$fila, $periodo1[2].' - '.$periodo1[3])
						->setCellValue('AO'.$fila, $periodo2[0].' - '.$periodo2[1])
						->setCellValue('AP'.$fila, $periodo2[2].' - '.$periodo2[3])
						->setCellValue('AQ'.$fila, $periodo3[0].' - '.$periodo3[1])
						->setCellValue('AR'.$fila, $periodo3[2].' - '.$periodo3[3])
						->setCellValue('AS'.$fila, $periodo4[0].' - '.$periodo4[1])
						->setCellValue('AT'.$fila, $periodo4[2].' - '.$periodo4[3])
						
						->setCellValue('AU'.$fila, $confirmar[$desplazados])
						->setCellValue('AV'.$fila, $confirmar[$juntos])
						->setCellValue('AW'.$fila, $confirmar[$familiasAccion])
						->setCellValue('AX'.$fila, $confirmar[$comedorInfantil])
						
						->setCellValue('AY'.$fila, $kitEscolar)
						->setCellValue('AZ'.$fila, $uniforme)
						->setCellValue('BA'.$fila, $zapatos)						
						->setCellValue('BB'.$fila, $visitaDomiciliaria)
						->setCellValue('BC'.$fila, $visitaAcademica)
						->setCellValue('BD'.$fila, $visitaPsicosocial)						
						->setCellValue('BE'.$fila, $intervencionPsicologica)
						->setCellValue('BF'.$fila, $valoracionMedica)
						->setCellValue('BG'.$fila, $valoracionOdontologica)
						->setCellValue('BH'.$fila, $usuarioActualizo)
						->setCellValue('BI'.$fila, $fechaActualizacion);
		}
		mysqli_free_result($result);				
												
		$objPHPExcel->getActiveSheet()->getStyle('A1:BI'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);			
		$objPHPExcel->getActiveSheet()->getStyle('D2:F'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('I2:K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('U2:X'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('AM2:BC'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
													
		// Rename sheet
		$nombre = 'PRONIÑO '.$year;
		$objPHPExcel->getActiveSheet()->setTitle($nombre);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = "PRONIÑO ".date("d.m.Y").".xls";
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