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
		$pdf->SetTitle('DIAGNOSTICO INICIAL');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetMargins(15,14,15);		
		
		$icbf = '';
		$redUnidos = '';
		$institucionEducativa = '';
		$LideresComunitarios = '';
		$busquedaActiva = '';	
		$otros = '';
		
		$nombreBeneficiario = '';
		$codigo = '';
		$direccion = '';
		$nombreBarrio = '';
		$edad = '';
		$nombreAcudiente = '';
		$telefono = '';
		
		$situacionLaboral = '';
		$descripcion = '';
		$observaciones = '';
		
		if($idBeneficiario != ''){
			$pronino = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario));
			$codigo = $pronino['item'];	
			$idAcudiente = $pronino['idAcudiente'];
			$acudiente = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($idAcudiente));
			$nombreAcudiente = $acudiente['nombreBeneficiario'].' '.$acudiente['apellidoBeneficiario'];
			
			$info = mysqli_fetch_array(Pronino::getInstance()->get_beneficiario_by_id($idBeneficiario));
			$nombreBeneficiario = $info['nombreBeneficiario'].' '.$info['apellidoBeneficiario'];			
			$edad = edad($info['fechaNacimiento']);
			if($edad != '')
				$edad = $edad.' Año(s)';
			$telefono = $info['telefono'];		
			$direccion = $info['direccion'];
			$idBarrio = $info['idBarrio'];	
			$barrio = mysqli_fetch_array(Pronino::getInstance()->get_barrio_by_id($idBarrio));					
			$nombreBarrio = $barrio['nombreBarrio'];
		}
				
		$result = Pronino::getInstance()->get_diagnostico_by_beneficiario($idBeneficiario);		
		if(mysqli_num_rows($result) != 0){
			$beneficiario = mysqli_fetch_array($result);
			$remitido = $beneficiario['remitido'];		
			switch($remitido){
				case 1: $icbf = 'X';
						break;
				case 2: $redUnidos = 'X';
						break;
				case 3: $institucionEducativa = 'X';
						break;
				case 4: $LideresComunitarios = 'X';
						break;
				case 5: $busquedaActiva = 'X';
						break;		
				case 6: $otros = 'X';
						break;															
			}
						
			$situacionLaboral = $beneficiario['situacionLaboral'];	
			$descripcion = $beneficiario['descripcionEscenarios'];	
			$observaciones = $beneficiario['observacionesDiagnostico'];	
		}		
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(43,20,'',1,0,'C');
		$pdf->Image('../img/telefonica.png',22,15,31);	
		$pdf->Cell(100,10,'DIAGNOSTICO INICIAL',1,2,'C');
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(33,10,'CODIGO: PRON-01',1,0,'C');
		$pdf->Cell(34,10,'FECHA: 16/02/2013',1,0,'C');
		$pdf->Cell(33,10,utf8_decode('VERSIÓN: 02'),1,0,'C');
				
		$pdf->SetXY(158, 14);
		$pdf->Cell(43,20,'',1,1,'C');
		$pdf->Image('../img/logo.png',159,17,41);
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(186,7,'Caso remitido por:','TLR',1,'L');
		
		$pdf->Cell(40,7,'ICBF:','L',0,'L');
		$pdf->Cell(8,5,$icbf,1,0,'C');
		$pdf->Cell(45);
		$pdf->Cell(40,7,'Lideres Comunitarios:','',0,'L');
		$pdf->Cell(8,5,$LideresComunitarios,1,0,'C');
		$pdf->Cell(45,7,'','R',1);
		
		$pdf->Cell(40,7,'Red Unidos:','L',0,'L');
		$pdf->Cell(8,5,$LideresComunitarios,1,0,'C');
		$pdf->Cell(45);
		$pdf->Cell(40,7,'Busquedad Activa:','',0,'L');
		$pdf->Cell(8,5,$busquedaActiva,1,0,'C');
		$pdf->Cell(45,7,'','R',1);
		
		$pdf->Cell(40,7,utf8_decode('Institución Educativa:'),'L',0,'L');
		$pdf->Cell(8,5,$institucionEducativa,1,0,'C');
		$pdf->Cell(45);
		$pdf->Cell(40,7,'Otros:','',0,'L');
		$pdf->Cell(8,5,$otros,1,0,'C');
		$pdf->Cell(45,7,'','R',1);
		
		$pdf->Cell(186,5,'','T',1);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(230,235,245);
		$pdf->Cell(186,7,'DATOS PERSONALES:',1,1,'C',1);
		
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(20,7,'Nombre:','L',0,'L');
		$pdf->Cell(85,7,$nombreBeneficiario,'B',0,'L');		
		$pdf->Cell(10);
		$pdf->Cell(20,7,'Codigo:','',0,'L');
		$pdf->Cell(41,7,$codigo,'B',0,'L');
		$pdf->Cell(10,7,'','R',1);
		
		$pdf->Cell(20,7,utf8_decode('Direccion:'),'L',0,'L');
		$pdf->Cell(85,7,$direccion,'B',0,'L');		
		$pdf->Cell(10);
		$pdf->Cell(20,7,'Edad:','',0,'L');
		$pdf->Cell(41,7,utf8_decode($edad),'B',0,'');
		$pdf->Cell(10,7,'','R',1);
				
		$pdf->Cell(20,7,'Acudiente:','L',0,'L');
		$pdf->Cell(85,7,$nombreAcudiente,'B',0,'L');		
		$pdf->Cell(10);
		$pdf->Cell(20,7,utf8_decode('Teléfono:'),'',0,'L');
		$pdf->Cell(41,7,$telefono,'B',0,'L');
		$pdf->Cell(10,7,'','R',1);

		$pdf->Cell(20,7,'Barrio:','L',0,'L');
		$pdf->Cell(85,7,$nombreBarrio,'B',0,'L');
		$pdf->Cell(81,7,'','R',1);
		
		$pdf->Cell(186,2,'','RL',1);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(186,5,'SITUACION LABORAL','TLR',1,'C',1);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(186,4,'(Describa sitio, hora, persona que lo emplea, si recibe remuneracion)','LRB',1,'C',1);
		
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(1,30,'','L',0);
		$pdf->MultiCell(184,6,$situacionLaboral);
		$pdf->SetXY(200, 119);
		$pdf->Cell(1,30,'','R',1);
				
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(186,5,utf8_decode('DESCRIPCION DE LOS ESCENARIOS DE PARTICIPACIÓN DEL BENEFICIARIO'),'TLR',1,'C',1);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(186,4,utf8_decode('(A nivel familiar, social, escolar, comportamental y académico)'),'LRB',1,'C',1);
		
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(1,30,'','L',0);
		$pdf->MultiCell(184,6,$descripcion);
		$pdf->SetXY(200, 158);
		$pdf->Cell(1,30,'','R',1);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(186,7,'OBSERVACIONES, RECOMENDACIONES Y/O SUGERENCIAS',1,1,'C',1);
				
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(1,30,'','L',0);
		$pdf->MultiCell(184,6,$observaciones);
		$pdf->SetXY(200, 195);
		$pdf->Cell(1,30,'','R',1);
		
		$pdf->Cell(186,25,'','T',1);		
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(125);
		$pdf->Cell(60,5,'Nombre y Firma del Profesional','T',1,'C');
		
		$pdf->Output('DIAGNOSTICO INICIAL NNA.pdf', 'I');
		
		mysqli_free_result($result);	
	}
	else
		header("Location: ../");
?>	