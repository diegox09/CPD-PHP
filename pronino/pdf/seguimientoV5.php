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
			$pdf->Cell(40,8,'CODIGO: PRON-12',1,0,'C');
			$pdf->Cell(40,8,'FECHA: 11/02/2013',1,0,'C');
			$pdf->Cell(40,8,utf8_decode('VERSIÓN: 01'),1,0,'C');
					
			$pdf->SetXY(200, 10);
			$pdf->Cell(65,20,'',1,1,'C');
			$pdf->Image('../img/logo.png',208,12,46);		
			
			$pdf->Ln(2);		
			$pdf->SetFont('Arial','B',10);
			$pdf->SetFillColor(230,235,245);
			$pdf->Cell(25,5,'FECHA',1,1,'C',1);
			$pdf->Cell(25,5,'DD/MM/AA',1,0,'C',1);
			$pdf->SetXY(41, 32);
			$pdf->Cell(45,10,'MOTIVO',1,0,'C',1);
			$pdf->Cell(115,10,utf8_decode('DESCRIPCIÓN'),1,0,'C',1);
			$pdf->Cell(34,5,'FIRMA DE QUIEN','TLR',2,'C',1);
			$pdf->Cell(34,5,'RECIBE LA VISITA','LRB',0,'C',1);
			$pdf->SetXY(235, 32);
			$pdf->Cell(33,5,'FIRMA DEL','TLR',2,'C',1);
			$pdf->Cell(33,5,'PROFESIONAL','LRB',1,'C',1);
					
			$pdf->SetFont('Arial','',8);
			
			for($j=0; $j<2; $j++){
				$y = ($j*60)+42;				
				$pdf->Cell(1,60,'','L',0);
				$pdf->MultiCell(25,4.2,$fechaSeguimiento,'','C');
				$pdf->SetXY(42, $y);
				$pdf->Cell(1,60,'','R',0);
				$pdf->MultiCell(45,4.2,$motivo);
				$pdf->SetXY(107, $y);
				$pdf->Cell(1,60,'','R',0);
				$pdf->MultiCell(123,4.2,$descripcion);
				$pdf->SetXY(230, $y);
				$pdf->Cell(1,60,'','R',0);
				$pdf->MultiCell(34,4.2,$nombreProfesional,'','C');
				$pdf->SetXY(235, $y);
				$pdf->Cell(1,60,'','R',1);			
					
				$pdf->Cell(250,0,'',1,1);
			}
			
			$pdf->Ln(1);					
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(31,5,'OBSERVACIONES:','',0,'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(200,5,'Cuando el NNA es dado de baja del programa el profesional debe realizar el registro de cierre, informando al padre de familia y al beneficiario.','',1,'L');
					
			$pdf->Ln(25);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(8);
			$pdf->Cell(60,5,'Firma del Beneficiario','T',0,'C');
			$pdf->Cell(28);
			$pdf->Cell(60,5,'Firma del Padre/Madre','T',0,'C');
			$pdf->Cell(28);
			$pdf->Cell(60,5,'Firma del Profesional','T',1,'C');
			
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
			
			if(($i % 2) == 0){	
				$j = 0;	
				$firmas = true;					
				$pdf->AddPage();
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(65,20,'',1,0,'C');
				$pdf->Image('../img/telefonica.png',32,11,31);	
				$pdf->Cell(120,6,utf8_decode('SEGUIMIENTO VISITAS DOMICILIARIAS'),'TLR',2,'C');
				$pdf->Cell(120,6,utf8_decode('Y ATENCIÓN PSICOSOCIAL'),'LR',2,'C');
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(40,8,'CODIGO: PRON-12',1,0,'C');
				$pdf->Cell(40,8,'FECHA: 11/02/2013',1,0,'C');
				$pdf->Cell(40,8,utf8_decode('VERSIÓN: 01'),1,0,'C');
						
				$pdf->SetXY(200, 10);
				$pdf->Cell(65,20,'',1,1,'C');
				$pdf->Image('../img/logo.png',208,12,46);		
				
				$pdf->Ln(2);		
				$pdf->SetFont('Arial','B',10);
				$pdf->SetFillColor(230,235,245);
				$pdf->Cell(25,5,'FECHA',1,1,'C',1);
				$pdf->Cell(25,5,'DD/MM/AA',1,0,'C',1);
				$pdf->SetXY(41, 32);
				$pdf->Cell(45,10,'MOTIVO',1,0,'C',1);
				$pdf->Cell(115,10,utf8_decode('DESCRIPCIÓN'),1,0,'C',1);
				$pdf->Cell(34,5,'FIRMA DE QUIEN','TLR',2,'C',1);
				$pdf->Cell(34,5,'RECIBE LA VISITA','LRB',0,'C',1);
				$pdf->SetXY(235, 32);
				$pdf->Cell(33,5,'FIRMA DEL','TLR',2,'C',1);
				$pdf->Cell(33,5,'PROFESIONAL','LRB',1,'C',1);
					
				$pdf->SetFont('Arial','',8);
			}
						
			$y = ($j*60)+42;
			$j ++;			
			
			$pdf->Cell(1,60,'','L',0);
			$pdf->MultiCell(25,4.2,$fechaSeguimiento,'','C');
			$pdf->SetXY(39, $y);
			$pdf->Cell(1,60,'','R',0);
			$pdf->MultiCell(45,4.2,$motivo);
			$pdf->SetXY(107, $y);
			$pdf->Cell(1,60,'','R',0);
			$pdf->MultiCell(123,4.2,$descripcion);
			$pdf->SetXY(230, $y);
			$pdf->Cell(1,60,'','R',0);
			$pdf->MultiCell(34,4.2,$nombreProfesional,'','C');
			$pdf->SetXY(235, $y);
			$pdf->Cell(1,60,'','R',1);			
				
			$pdf->Cell(250,0,'',1,1);
			
			$i ++;			
			if(($i % 2) == 0){
				$pdf->Ln(1);
				$firmas = false;	
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(31,5,'OBSERVACIONES:','',0,'L');
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(200,5,'Cuando el NNA es dado de baja del programa el profesional debe realizar el registro de cierre, informando al padre de familia y al beneficiario.','',1,'L');
						
				$pdf->Ln(25);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(8);
				$pdf->Cell(60,5,'Firma del Beneficiario','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Padre/Madre','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Profesional','T',1,'C');
				
			}
		}
		
		while ($firmas){
			$y = ($j*57)+42;
			$j ++;			
			
			$pdf->Cell(1,60,'','L',0);
			$pdf->MultiCell(28,5,'','','C');
			$pdf->SetXY(42, $y);
			$pdf->Cell(1,60,'','R',0);
			$pdf->MultiCell(60,5,'');
			$pdf->SetXY(107, $y);
			$pdf->Cell(1,60,'','R',0);
			$pdf->MultiCell(110,5,'');
			$pdf->SetXY(230, $y);
			$pdf->Cell(1,60,'','R',0);
			$pdf->MultiCell(39,5,'','','C');
			$pdf->SetXY(264, $y);
			$pdf->Cell(1,60,'','R',1);			
				
			$pdf->Cell(250,0,'',1,1);
			
			$i ++;			
			if(($i % 2) == 0){
				$pdf->Ln(1);
				$firmas = false;	
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(31,5,'OBSERVACIONES:','',0,'L');
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(200,5,'Cuando el NNA es dado de baja del programa el profesional debe realizar el registro de cierre, informando al padre de familia y al beneficiario.','',1,'L');
						
				$pdf->Ln(25);
				$pdf->SetFont('Arial','B',10);
				$pdf->Cell(8);
				$pdf->Cell(60,5,'Firma del Beneficiario','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Padre/Madre','T',0,'C');
				$pdf->Cell(28);
				$pdf->Cell(60,5,'Firma del Profesional','T',1,'C');
				
			}
		}
		
		$pdf->Output('SEGUIMIENTO VISITAS DOMICILIARIAS Y ATENCIÓN PSICOSOCIAL NNA.pdf', 'I');
		
		mysqli_free_result($result);	
	}
	else
		header("Location: ../");
?>	