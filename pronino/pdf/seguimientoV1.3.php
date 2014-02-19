<?php
	session_start();
	
	require_once('../../php/fpdf/fpdf.php');
	require_once('../php/classes/Pronino.php');
	require_once('../php/funciones/funciones.php');
	
	class PDF extends FPDF{
		// Pie de página
		function Footer(){
			// Posición: a 1,5 cm del final
			$this->SetY(-15);			
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,utf8_decode('Página '.$this->PageNo().' / {nb}'),0,0,'C');
		}
	}
	
	$logonSuccess = false;
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){	
		$idBeneficiario = $_GET['id_beneficiario'];		
			
		$pdf = new PDF();	
		$pdf->FPDF('L','mm','Letter');
		$pdf->SetTitle('SEGUIMIENTO VISITAS DOMICILIARIAS Y ATENCIÓN PSICOSOCIAL');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetMargins(15,10,15);
		$pdf->AliasNbPages();		
		
				
		$result = Pronino::getInstance()->get_seguimiento_by_beneficiario($idBeneficiario);	
		
		if(mysqli_num_rows($result) == 0){
			$pdf->AddPage();
				
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(65,20,'',1,0,'C');
			$pdf->Image('../img/telefonica.png',32,11,31);	
			$pdf->Cell(120,6,utf8_decode('SEGUIMIENTO VISITAS DOMICILIARIAS'),'TLR',2,'C');
			$pdf->Cell(120,6,utf8_decode('Y ATENCIÓN PSICOSOCIAL'),'LR',2,'C');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(60,8,'FECHA: 19 de Diciembre de 2011',1,0,'C');
			$pdf->Cell(60,8,utf8_decode('VERSIÓN: 01'),1,0,'C');
					
			$pdf->SetXY(200, 10);
			$pdf->Cell(65,20,'',1,1,'C');
			$pdf->Image('../img/logo.png',208,12,46);		
			
			$pdf->Ln(2);		
			$pdf->SetFont('Arial','B',10);
			$pdf->SetFillColor(230,235,245);
			$pdf->Cell(30,5,'FECHA',1,1,'C',1);
			$pdf->Cell(30,5,'DD/MM/AA',1,0,'C',1);
			$pdf->SetXY(45, 32);
			$pdf->Cell(70,10,'MOTIVO',1,0,'C',1);
			$pdf->Cell(110,10,utf8_decode('DESCRIPCIÓN'),1,0,'C',1);
			$pdf->Cell(40,5,'FIRMA DEL','TLR',2,'C',1);
			$pdf->Cell(40,5,'PROFESIONAL','LRB',1,'C',1);
					
			$pdf->SetFont('Arial','',8);
			
			for($j=0; $j<3; $j++){
				$y = ($j*49)+42;				
				$pdf->Cell(1,49,'','L',0);
				$pdf->MultiCell(28,4.2,$fechaSeguimiento,'','C');
				$pdf->SetXY(44, $y);
				$pdf->Cell(1,49,'','R',0);
				$pdf->MultiCell(70,4.2,$motivo);
				$pdf->SetXY(114, $y);
				$pdf->Cell(1,49,'','R',0);
				$pdf->MultiCell(110,4.2,$descripcion);
				$pdf->SetXY(224, $y);
				$pdf->Cell(1,49,'','R',0);
				$pdf->MultiCell(39,4.2,$nombreProfesional,'','C');
				$pdf->SetXY(264, $y);
				$pdf->Cell(1,49,'','R',1);			
					
				$pdf->Cell(250,0,'',1,1);
			}
			
			$pdf->Ln(1);					
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(31,5,'OBSERVACIONES:','',0,'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(200,5,'Cuando el NNA es dado de baja del programa el profesional debe realizar el registro de cierre, informando al padre de familia y al beneficiario.','',1,'L');
			/*		
			$pdf->Ln(30);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(8);
			$pdf->Cell(60,5,'Firma del Beneficiario','T',0,'C');
			$pdf->Cell(28);
			$pdf->Cell(60,5,'Firma del Padre/Madre','T',0,'C');
			$pdf->Cell(28);
			$pdf->Cell(60,5,'Firma del Profesional','T',1,'C');
			*/
		}
		
		$i = 0;
		$j = 0;
		$firmas = false;		
		while ($beneficiario = mysqli_fetch_array($result)){
			$fechaSeguimiento = implota($beneficiario['fechaSeguimiento']);	
			
			$idProfesional = $beneficiario['idProfesional'];
			$profesional = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idProfesional));					
			$nombreProfesional = $profesional['nombreUser'];	
						
			$descripcion = $beneficiario['descripcion'];	
			$motivo = $beneficiario['motivo'];
			
			if(($i % 3) == 0){	
				$j = 0;	
				$firmas = true;					
				$pdf->AddPage();
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(65,20,'',1,0,'C');
				$pdf->Image('../img/telefonica.png',32,11,31);	
				$pdf->Cell(120,6,utf8_decode('SEGUIMIENTO VISITAS DOMICILIARIAS'),'TLR',2,'C');
				$pdf->Cell(120,6,utf8_decode('Y ATENCIÓN PSICOSOCIAL'),'LR',2,'C');
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(60,8,'FECHA: 19 de Diciembre de 2011',1,0,'C');
				$pdf->Cell(60,8,utf8_decode('VERSIÓN: 01'),1,0,'C');
						
				$pdf->SetXY(200, 10);
				$pdf->Cell(65,20,'',1,1,'C');
				$pdf->Image('../img/logo.png',208,12,46);		
				
				$pdf->Ln(2);		
				$pdf->SetFont('Arial','B',10);
				$pdf->SetFillColor(230,235,245);
				$pdf->Cell(30,5,'FECHA',1,1,'C',1);
				$pdf->Cell(30,5,'DD/MM/AA',1,0,'C',1);
				$pdf->SetXY(45, 32);
				$pdf->Cell(70,10,'MOTIVO',1,0,'C',1);
				$pdf->Cell(110,10,utf8_decode('DESCRIPCIÓN'),1,0,'C',1);
				$pdf->Cell(40,5,'FIRMA DEL','TLR',2,'C',1);
				$pdf->Cell(40,5,'PROFESIONAL','LRB',1,'C',1);
					
				$pdf->SetFont('Arial','',8);
			}
						
			$y = ($j*49)+42;
			$j ++;			
			
			$pdf->Cell(1,49,'','L',0);
			$pdf->MultiCell(28,4.2,$fechaSeguimiento,'','C');
			$pdf->SetXY(44, $y);
			$pdf->Cell(1,49,'','R',0);
			$pdf->MultiCell(70,4.2,$motivo);
			$pdf->SetXY(114, $y);
			$pdf->Cell(1,49,'','R',0);
			$pdf->MultiCell(110,4.2,$descripcion);
			$pdf->SetXY(224, $y);
			$pdf->Cell(1,49,'','R',0);
			$pdf->MultiCell(39,4.2,$nombreProfesional,'','C');
			$pdf->SetXY(264, $y);
			$pdf->Cell(1,49,'','R',1);			
				
			$pdf->Cell(250,0,'',1,1);
			
			$i ++;			
			if(($i % 3) == 0){
				$pdf->Ln(1);
				$firmas = false;	
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(31,5,'OBSERVACIONES:','',0,'L');
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(200,5,'Cuando el NNA es dado de baja del programa el profesional debe realizar el registro de cierre, informando al padre de familia y al beneficiario.','',1,'L');
				/*		
				$pdf->Ln(30);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(8);
				$pdf->Cell(60,5,'Firma del Beneficiario','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Padre/Madre','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Profesional','T',1,'C');
				*/
			}
		}
		
		while ($firmas){
			$y = ($j*49)+42;
			$j ++;			
			
			$pdf->Cell(1,49,'','L',0);
			$pdf->MultiCell(28,5,'','','C');
			$pdf->SetXY(44, $y);
			$pdf->Cell(1,49,'','R',0);
			$pdf->MultiCell(70,5,'');
			$pdf->SetXY(114, $y);
			$pdf->Cell(1,49,'','R',0);
			$pdf->MultiCell(110,5,'');
			$pdf->SetXY(224, $y);
			$pdf->Cell(1,49,'','R',0);
			$pdf->MultiCell(39,5,'','','C');
			$pdf->SetXY(264, $y);
			$pdf->Cell(1,49,'','R',1);			
				
			$pdf->Cell(250,0,'',1,1);
			
			$i ++;			
			if(($i % 3) == 0){
				$pdf->Ln(1);
				$firmas = false;	
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(31,5,'OBSERVACIONES:','',0,'L');
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(200,5,'Cuando el NNA es dado de baja del programa el profesional debe realizar el registro de cierre, informando al padre de familia y al beneficiario.','',1,'L');
				/*		
				$pdf->Ln(30);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(8);
				$pdf->Cell(60,5,'Firma del Beneficiario','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Padre/Madre','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Profesional','T',1,'C');
				*/
			}
		}
		
		$pdf->Output('SEGUIMIENTO VISITAS DOMICILIARIAS Y ATENCIÓN PSICOSOCIAL NNA.pdf', 'I');
		
		mysqli_free_result($result);	
	}
	else
		header("Location: ../");
?>	