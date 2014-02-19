<?php
	session_start();
	
	require_once('../../php/fpdf/fpdf.php');
	require_once('../php/classes/Pronino.php');
	require_once('../php/funciones/funciones.php');
	
	$logonSuccess = false;
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){	
		$idBeneficiario = $_GET['id_beneficiario'];		
			
		$pdf = new FPDF('P','mm','Letter');
		$pdf->SetTitle('ATENCION PSICOSOCIAL');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetMargins(15,14,15);		
		
		$confirmar = array('', 'X');
		$jornada = array('', 'Mañana', 'Tarde');
		
		$result = Pronino::getInstance()->get_psicosocial_by_beneficiario($idBeneficiario);	
		
		if(mysqli_num_rows($result) == 0){
			$info = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario));
			$nombreBeneficiario = $info['nombreBeneficiario'].' '.$info['apellidoBeneficiario'];
			$fechaNacimiento = implota($info['fechaNacimiento']);
			$edad = edad($info['fechaNacimiento']);
			if($edad != '')
				$edad = utf8_decode($edad.' Año(s)');
					
			$pronino = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario));
			$item = $pronino['item'];	
			
			$pdf->AddPage();
		
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(43,20,'',1,0,'C');
			$pdf->Image('../img/telefonica.png',22,15,31);	
			$pdf->Cell(100,10,'ATENCION PSICOSOCIAL',1,2,'C');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(50,10,'FECHA: 19 de Diciembre de 2011',1,0,'C');
			$pdf->Cell(50,10,utf8_decode('VERSIÓN: 01'),1,0,'C');
					
			$pdf->SetXY(158, 14);
			$pdf->Cell(43,20,'',1,1,'C');
			$pdf->Image('../img/logo.png',159,17,41);
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',8.5);
			$pdf->Cell(43,7,'NOMBRE DEL ESTUDIANTE:','',0,'L');
			$pdf->Cell(102,7,$nombreBeneficiario,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(11,7,'ITEM:','',0,'L');
			$pdf->Cell(25,7,$item,'B',1,'L');
			
			$pdf->Cell(17,7,'COLEGIO:','',0,'L');
			$pdf->Cell(88,7,'','B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(14,7,'GRADO:','',0,'L');
			$pdf->Cell(14,7,'','B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(18,7,'JORNADA:','',0,'L');
			$pdf->Cell(25,7,'','B',1,'L');
			
			$pdf->Cell(52,7,'LUGAR Y FECHA DE NACIMIENTO:','',0,'L');
			$pdf->Cell(92,7,$fechaNacimiento,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(12,7,'EDAD:','',0,'L');
			$pdf->Cell(25,7,$edad,'B',1,'L');
			
			$pdf->Cell(25,7,'REMITIDO POR:','',0,'L');
			$pdf->Cell(90,7,'','B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(34,7,utf8_decode('FECHA DE REMISIÓN:'),'',0,'L');
			$pdf->Cell(32,7,'','B',1,'L');
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,'1.   ASPECTO EN DONDE PRESENTA DIFICULTAD:','',1,'L');
				
			$pdf->SetFont('Arial','',8.5);	
			$pdf->Cell(6);		
			$pdf->Cell(32,6,utf8_decode('*  Aspecto académico:'),'',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Cell(6);
			$pdf->Cell(43,6,utf8_decode('*  Aspecto de comportamiento:'),'',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Cell(6);
			$pdf->Cell(34,6,utf8_decode('*  Aspecto comunicativo:'),'',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Cell(6);
			$pdf->Cell(27,6,utf8_decode('*  Aspecto familiar:'),'',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');	
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,'2.   MOTIVO DE REMISION:','',1,'L');
			
			$pdf->SetFont('Arial','',8.5);
			$pdf->Cell(6);
			$pdf->Cell(180,6,utf8_decode('*  ASPECTO ACADÉMICO: (Describa brevemente el área y la dificultad que presenta)'),'',1,'L');	
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 119);
			$pdf->Cell(6);	
			$pdf->MultiCell(180,5,'');
			
			$pdf->SetXY(15, 156);
			$pdf->Cell(6);
			$pdf->MultiCell(180,6,utf8_decode('*  ASPECTO DE COMPORTAMIENTO: (Describa brevemente la dificultad que presenta el NNA si es en las relaciones con compañeros, docentes, coordinador o personal administrativo, o si es dificultad a nivel emocional timidez, agresividad, aislamiento entre otras)'),'','J');
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 174);
			$pdf->Cell(6);	
			$pdf->MultiCell(180,5,'');
			
			$pdf->SetXY(15, 211);
			$pdf->Cell(6);
			$pdf->Cell(180,6,utf8_decode('*  ASPECTO COMUNICATIVO: (Describa la dificultad en el área del lenguaje)'),'',1,'L');			
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}	
			$pdf->SetXY(15, 216);	
			$pdf->Cell(6);	
			$pdf->MultiCell(180,6,'');
			
			/*Pagina Nueva*/
			$pdf->AddPage();			
			$pdf->Cell(6);
			$pdf->MultiCell(180,6,utf8_decode('*  ASPECTO FAMILIAR: (Describa brevemente la dificultad en las relaciones del NNA con el padre, madre, hermanos, otros)'),'','J');
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 20);
			$pdf->Cell(6);	
			$pdf->MultiCell(180,5,'');
			
			
			$pdf->SetXY(15, 60);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,utf8_decode('ACCIONES REALIZADAS CON EL NNA ANTES DE REMITIRLO A ATENCION PSICOSOCIAL:'),'',1,'L');			
			$pdf->SetFont('Arial','',8.5);
			for($i=0; $i<7; $i++){
				$pdf->Cell(186,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 66);
			$pdf->MultiCell(186,5,'');
			
			$pdf->SetXY(15, 125);
			$pdf->Cell(68,6,'FIRMA DEL RESPONSABLE DE LA REMISION:','',0,'L');
			$pdf->Cell(118,6,'','B',1,'L');
			
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,utf8_decode('REMISIONES POR PARTE DEL PROGRAMA PRONIÑO:'),'',1,'L');
			
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(43,6,'CASO REMITIDO A LA UAI:','',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(71,6,'CASO REMITIDO A ATENCION PSICOSOCIAL:','',0,'L');
			$pdf->Cell(43,6,utf8_decode('ATENCION PSICOLÓGICA:'),'',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(71,6,'','',0,'L');
			$pdf->Cell(58,6,utf8_decode('ATENCION TERAPIA OCUPACIONAL:'),'',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(66,6,'CASO REMITIDO A REFUERZO ESCOLAR:','',0,'L');
			$pdf->Cell(10,6,'','B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(101,6,'CASO REMITIDO A OTROS ESPECIALISTAS Y/O INSTITUCIONES:','',0,'L');
			$pdf->Cell(85,6,'','B',1,'L');
			
			$pdf->Ln(25);
			$pdf->Cell(40,6,'CASO DIRECCIONADO A:','',0,'L');
			$pdf->Cell(90,6,'','B',1,'C');
		}
			
		while ($beneficiario = mysqli_fetch_array($result)){			
			$fechaRemision = implota($beneficiario['fechaRemision']);
			
			$year = substr($fechaRemision,6,4);	
			
			$info = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario));
			$nombreBeneficiario = $info['nombreBeneficiario'].' '.$info['apellidoBeneficiario'];
			$fechaNacimiento = implota($info['fechaNacimiento']);
			$edad = edad($info['fechaNacimiento']);
				if($edad != '')
					$edad = utf8_decode($edad.' Año(s)');
					
			$pronino = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario));
			$item = $pronino['item'];		
			
			$programa = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year));
			$idColegio = $programa['idColegio'];
			$nombreColegio = '';
			if($idColegio != 0){								
				$sede = mysqli_fetch_array(Pronino::getInstance()->get_colegio_by_id($idColegio));	
				$nombreColegio = $sede['nombreColegio'];	
			}
			$grado = $programa['grado'];
			$idJornada = $programa['jornada'];		
			
			$idProfesional = $beneficiario['remitido'];
			$profesional = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idProfesional));					
			$remitido = $profesional['nombreUser'];
			
			$aspectoAcademico = $beneficiario['aspectoAcademico'];
			$aspectoComportamiento = $beneficiario['aspectoComportamiento'];
			$aspectoComunicativo = $beneficiario['aspectoComunicativo'];
			$aspectoFamiliar = $beneficiario['aspectoFamiliar'];
			$motivoAspectoAcademico = $beneficiario['motivoAspectoAcademico'];
			$motivoAspectoComportamiento = $beneficiario['motivoAspectoComportamiento'];
			$motivoAspectoComunicativo = $beneficiario['motivoAspectoComunicativo'];
			$motivoAspectoFamiliar = $beneficiario['motivoAspectoFamiliar'];	
			$accionesRealizadas = $beneficiario['accionesRealizadas'];
			$remitidoUAI = $beneficiario['remitidoUAI'];
			$remitidoPsicologia = $beneficiario['remitidoPsicologia'];
			$remitidoTerapiaOcupacional = $beneficiario['remitidoTerapiaOcupacional'];
			$remitidoRefuerzoEscolar = $beneficiario['remitidoRefuerzoEscolar'];
			$remitidoOtrasInstituciones = $beneficiario['remitidoOtrasInstituciones'];
			
			$pdf->AddPage();
		
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(43,20,'',1,0,'C');
			$pdf->Image('../img/telefonica.png',22,15,31);	
			$pdf->Cell(100,10,'ATENCION PSICOSOCIAL',1,2,'C');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(50,10,'FECHA: 19 de Diciembre de 2011',1,0,'C');
			$pdf->Cell(50,10,utf8_decode('VERSIÓN: 01'),1,0,'C');
					
			$pdf->SetXY(158, 14);
			$pdf->Cell(43,20,'',1,1,'C');
			$pdf->Image('../img/logo.png',163,15,31);
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','',8.5);
			$pdf->Cell(43,7,'NOMBRE DEL ESTUDIANTE:','',0,'L');
			$pdf->Cell(102,7,$nombreBeneficiario,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(11,7,'ITEM:','',0,'L');
			$pdf->Cell(25,7,$item,'B',1,'L');
			
			$pdf->Cell(17,7,'COLEGIO:','',0,'L');
			$pdf->Cell(88,7,$nombreColegio,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(14,7,'GRADO:','',0,'L');
			$pdf->Cell(14,7,$grado,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(18,7,'JORNADA:','',0,'L');
			$pdf->Cell(25,7,utf8_decode($jornada[$idJornada]),'B',1,'L');
			
			$pdf->Cell(52,7,'LUGAR Y FECHA DE NACIMIENTO:','',0,'L');
			$pdf->Cell(92,7,$fechaNacimiento,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(12,7,'EDAD:','',0,'L');
			$pdf->Cell(25,7,$edad,'B',1,'L');
			
			$pdf->Cell(25,7,'REMITIDO POR:','',0,'L');
			$pdf->Cell(90,7,$remitido,'B',0,'L');
			$pdf->Cell(5,7,'','',0,'L');
			$pdf->Cell(34,7,utf8_decode('FECHA DE REMISIÓN:'),'',0,'L');
			$pdf->Cell(32,7,$fechaRemision,'B',1,'L');
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,'1.   ASPECTO EN DONDE PRESENTA DIFICULTAD:','',1,'L');
				
			$pdf->SetFont('Arial','',8.5);	
			$pdf->Cell(6);		
			$pdf->Cell(32,6,utf8_decode('*  Aspecto académico:'),'',0,'L');
			$pdf->Cell(10,6,$confirmar[$aspectoAcademico],'B',1,'C');
			
			$pdf->Cell(6);
			$pdf->Cell(43,6,utf8_decode('*  Aspecto de comportamiento:'),'',0,'L');
			$pdf->Cell(10,6,$confirmar[$aspectoComportamiento],'B',1,'C');
			
			$pdf->Cell(6);
			$pdf->Cell(34,6,utf8_decode('*  Aspecto comunicativo:'),'',0,'L');
			$pdf->Cell(10,6,$confirmar[$aspectoComunicativo],'B',1,'C');
			
			$pdf->Cell(6);
			$pdf->Cell(27,6,utf8_decode('*  Aspecto familiar:'),'',0,'L');
			$pdf->Cell(10,6,$confirmar[$aspectoFamiliar],'B',1,'C');	
			
			$pdf->Ln(5);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,'2.   MOTIVO DE REMISION:','',1,'L');
			
			$pdf->SetFont('Arial','',8.5);
			$pdf->Cell(6);
			$pdf->Cell(180,6,utf8_decode('*  ASPECTO ACADÉMICO: (Describa brevemente el área y la dificultad que presenta)'),'',1,'L');	
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 119);
			$pdf->Cell(6);	
			$pdf->MultiCell(180,5,$motivoAspectoAcademico);
			
			$pdf->SetXY(15, 156);
			$pdf->Cell(6);
			$pdf->MultiCell(180,6,utf8_decode('*  ASPECTO DE COMPORTAMIENTO: (Describa brevemente la dificultad que presenta el NNA si es en las relaciones con compañeros, docentes, coordinador o personal administrativo, o si es dificultad a nivel emocional timidez, agresividad, aislamiento entre otras)'),'','J');
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 174);
			$pdf->Cell(6);	
			$pdf->MultiCell(180,5,$motivoAspectoComportamiento);
			
			$pdf->SetXY(15, 211);
			$pdf->Cell(6);
			$pdf->Cell(180,6,utf8_decode('*  ASPECTO COMUNICATIVO: (Describa la dificultad en el área del lenguaje)'),'',1,'L');			
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}	
			$pdf->SetXY(15, 216);	
			$pdf->Cell(6);	
			$pdf->MultiCell(180,6,$motivoAspectoComunicativo);
			
			/*Pagina Nueva*/
			$pdf->AddPage();			
			$pdf->Cell(6);
			$pdf->MultiCell(180,6,utf8_decode('*  ASPECTO FAMILIAR: (Describa brevemente la dificultad en las relaciones del NNA con el padre, madre, hermanos, otros)'),'','J');
			for($i=0; $i<7; $i++){
				$pdf->Cell(6);
				$pdf->Cell(180,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 20);
			$pdf->Cell(6);	
			$pdf->MultiCell(180,5,$motivoAspectoFamiliar);
			
			
			$pdf->SetXY(15, 60);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,utf8_decode('ACCIONES REALIZADAS CON EL NNA ANTES DE REMITIRLO A ATENCION PSICOSOCIAL:'),'',1,'L');			
			$pdf->SetFont('Arial','',8.5);
			for($i=0; $i<7; $i++){
				$pdf->Cell(186,5,'','B',1,'L');
			}
			$pdf->SetXY(15, 66);
			$pdf->MultiCell(186,5,$accionesRealizadas);
			
			$pdf->SetXY(15, 125);
			$pdf->Cell(68,6,'FIRMA DEL RESPONSABLE DE LA REMISION:','',0,'L');
			$pdf->Cell(118,6,'','B',1,'L');
			
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',8.5);
			$pdf->Cell(186,6,utf8_decode('REMISIONES POR PARTE DEL PROGRAMA PRONIÑO:'),'',1,'L');
			
			$pdf->Ln(5);	
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(43,6,'CASO REMITIDO A LA UAI:','',0,'L');
			$pdf->Cell(10,6,$confirmar[$remitidoUAI],'B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(71,6,'CASO REMITIDO A ATENCION PSICOSOCIAL:','',0,'L');
			$pdf->Cell(43,6,utf8_decode('ATENCION PSICOLÓGICA:'),'',0,'L');
			$pdf->Cell(10,6,$confirmar[$remitidoPsicologia],'B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(71,6,'','',0,'L');
			$pdf->Cell(58,6,utf8_decode('ATENCION TERAPIA OCUPACIONAL:'),'',0,'L');
			$pdf->Cell(10,6,$confirmar[$remitidoTerapiaOcupacional],'B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(66,6,'CASO REMITIDO A REFUERZO ESCOLAR:','',0,'L');
			$pdf->Cell(10,6,$confirmar[$remitidoRefuerzoEscolar],'B',1,'C');
			
			$pdf->Ln(2);
			$pdf->Cell(101,6,'CASO REMITIDO A OTROS ESPECIALISTAS Y/O INSTITUCIONES:','',0,'L');
			$pdf->Cell(85,6,$remitidoOtrasInstituciones,'B',1,'L');
			
			$pdf->Ln(25);
			$pdf->Cell(40,6,'CASO DIRECCIONADO A:','',0,'L');
			$pdf->Cell(90,6,'','B',1,'C');
		}	
			
		$pdf->Output('ATENCION PSICOSOCIAL.pdf', 'I');
		
		mysqli_free_result($result);	
	}
	else
		header("Location: ../");
?>	