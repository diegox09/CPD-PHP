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
		$pdf->SetTitle('ACOMPAÑAMIENTO PSICOSOCIAL');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetMargins(15,14,15);		
		
		$nombreBeneficiario = '';
		$codigo = '';
		$direccion = '';
		$nombreBarrio = '';
		$edad = '';
		$nombreAcudiente = '';
		$telefono = '';
		
		$tipoResumen = 0;
		$tiposResumen = array('', 'RESUMEN DE INTERVENCIÓN PROGRAMA PRONIÑO', 'DIAGNÓSTICO Y PLAN DE INTERVENCIÓN', 'SEGUIMIENTO PSICOSOCIAL');
		$descripcionResumen = '';
		
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

		$result = Pronino::getInstance()->get_resumen_by_beneficiario($idBeneficiario);	
				
		while ($beneficiario = mysqli_fetch_array($result)){
			$fechaResumen = implota($beneficiario['fechaResumen']);			
			$tipoResumen = $beneficiario['tipoResumen'];				
			$descripcionResumen = br2nl(str_replace("<br />
<br />", "<br />", $beneficiario['descripcionResumen']));
			$idUser = $beneficiario['idUser'];
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
			$nombreUser = htmlentities($usuario['nombreUser']);	
			
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(43,20,'',1,0,'C');
			$pdf->Image('../img/telefonica.png',22,17,31);	
			$pdf->Cell(100,20,utf8_decode('ACOMPAÑAMIENTO PSICOSOCIAL'),1,2,'C');
					
			$pdf->SetXY(158, 14);
			$pdf->Cell(43,20,'',1,1,'C');
			$pdf->Image('../img/logo.png',159,17,41);
			
			$pdf->Ln(2);	

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
			
			$pdf->Cell(20,7,'Barrio:','L',0,'L');
			$pdf->Cell(85,7,$nombreBarrio,'B',0,'L');					
			$pdf->Cell(10);
			$pdf->Cell(20,7,utf8_decode('Teléfono:'),'',0,'L');
			$pdf->Cell(41,7,$telefono,'B',0,'L');
			$pdf->Cell(10,7,'','R',1);

			$pdf->Cell(20,7,'Acudiente:','L',0,'L');
			$pdf->Cell(85,7,$nombreAcudiente,'B',0,'L');	
			$pdf->Cell(10);
			$pdf->Cell(20,7,'Fecha:','',0,'L');
			$pdf->Cell(41,7,$fechaResumen,'B',0,'L');
			$pdf->Cell(10,7,'','R',1);
			
			$pdf->Cell(186,2,'','T',1);
			
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(186,7,utf8_decode($tiposResumen[$tipoResumen]),'TLRB',1,'C',1);

			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',9);	
			//$pdf->Cell(186,150,'','TLRB',1);
			$pdf->SetXY(16, 81);
			$pdf->MultiCell(184,5,$descripcionResumen);
			
			$pdf->SetXY(25, 252);					
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(90,5,'Nombre del Profesional: '.$nombreUser,'T',1,'L');
		}	

		$pdf->Output('ACOMPAÑAMIENTO PSICOSOCIAL.pdf', 'I');
			
		mysqli_free_result($result);	
	}
	
	header("Location: ../");
?>	