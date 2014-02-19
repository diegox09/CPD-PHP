<?php	
	session_start();
	
	require_once('../php/fpdf/fpdf.php');
	require_once('../php/classes/Humanitaria.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$idDamnificado = $_GET['id'];
		$fase = $_GET['fase'];
		
		$array = explode(',',$idDamnificado);
			
		$pdf = new FPDF('L','mm','Letter');
		$pdf->SetTitle('FORMATO REGISTRO DE APOYOS');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetSubject('Formato Registro de Apoyos');
		$pdf->SetMargins(10,15,10);
		
		foreach ($array as $id) {
			$nombreDamnificado = '';
			$documentoDamnificado = '';
			$telefonoDamnificado = '';
			$direccionDamnificado = '';
			$barrioDamnificado = '';
			
			$result = Humanitaria::getInstance()->get_entregas_by_damnificado($id, $fase);			
			if(mysqli_num_rows($result) != 0){				
				$result = Humanitaria::getInstance()->get_damnificado_by_id($id);
				if(mysqli_num_rows($result) != 0){
					$damnificado = mysqli_fetch_array($result);									
					$nombreDamnificado = $damnificado['primer_nombre'];
					$segundoNombre = $damnificado['segundo_nombre'];
					$primerApellido = $damnificado['primer_apellido'];
					$segundoApellido = $damnificado['segundo_apellido'];
					if($segundoNombre != '')
						$nombreDamnificado = $nombreDamnificado.' '.$segundoNombre; 
					if($primerApellido != '')
						$nombreDamnificado = $nombreDamnificado.' '.$primerApellido;
					if($segundoApellido != '')	 	
						$nombreDamnificado = $nombreDamnificado.' '.$segundoApellido;
						
					$documentoDamnificado = number_format($damnificado['documento_damnificado'],0,',','.');
					$telefonoDamnificado = $damnificado['telefono'];
					$direccionDamnificado = $damnificado['direccion'];
					$barrioDamnificado = $damnificado['barrio'];
				}
			}
			mysqli_free_result($result);
						
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',12);
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(65,7,'','TLR',0,'C');
			$pdf->Image('../img/colombia_humanitaria.jpg',18,16,50);	
			$pdf->Cell(130,7,utf8_decode('FASE DE ATENCIÓN HUMANITARIA Y REHABILITACIÓN'),'TLR',0,'C');	
			$pdf->Cell(65,7,'','TLR',1,'C');	
			$pdf->Image('../img/logo_corprodinco.jpg',221,16,32);
			
			$pdf->Cell(65,7,'','LR',0,'C');
			$pdf->Cell(130,7,utf8_decode('FENÓMENO DE LA NIÑA 2010 - 2011'),'LR',0,'C');
			$pdf->Cell(65,7,'','LR',1,'C');
			
			$pdf->Cell(65,7,'','BLR',0,'C');
			$pdf->Cell(130,7,utf8_decode('FORMATO REGISTRO DE APOYOS'),'BLR',0,'C');
			$pdf->Cell(65,7,'','BLR',1,'C');
					
			$pdf->SetFont('Arial','B',11);		
			$pdf->SetFillColor(230,235,245);			
			$pdf->Cell(260,2,'','LR',1);							
			$pdf->Cell(50,7,' Nombre del Beneficiario:','L',0,'L');
			$pdf->Cell(150,7,' '.mb_strtoupper($nombreDamnificado),0,0,'L',true);			
			$pdf->Cell(10,7,' No.',0,0,'L');
			$pdf->Cell(48,7,'',0,0,'L',true);
			$pdf->Cell(2,7,'','R',1);
			
			$pdf->Cell(260,2,'','LR',1);	
			$pdf->Cell(53,7,utf8_decode(' Identificación Beneficiario:'),'L',0,'L');
			$pdf->Cell(97,7,' '.$documentoDamnificado,0,0,'L',true);
			$pdf->Cell(21,7,utf8_decode(' Teléfono:'),0,0,'L');
			$pdf->Cell(87,7,' '.$telefonoDamnificado,0,0,'L',true);
			$pdf->Cell(2,7,'','R',1);
						
			$pdf->Cell(260,2,'','LR',1);	
			$pdf->Cell(50,7,utf8_decode(' Dirección Actual / Barrio:'),'L',0,'L');
			$pdf->Cell(208,7,' '.mb_strtoupper($direccionDamnificado.' '.$barrioDamnificado),0,0,'L',true);
			$pdf->Cell(2,7,'','R',1);				
			$pdf->Cell(260,3,'','LR',1);	
					
			$pdf->SetFillColor(12,55,134);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(40,14,'Entregas',1,0,'C',true);				
			$pdf->Cell(25,7,'Kit de','TLR',2,'C',true);
			$pdf->Cell(25,7,'Alimentos','BLR',0,'C',true);
			$pdf->SetXY(75, 66);				
			$pdf->Cell(25,7,'Kit de','TLR',2,'C',true);
			$pdf->Cell(25,7,'Aseo','BLR',0,'C',true);
			$pdf->SetXY(100, 66);
			$pdf->Cell(25,14,'Arriendo',1,0,'C',true);
			$pdf->Cell(25,7,'Reparacion','TLR',2,'C',true);
			$pdf->Cell(25,7,'de Vivienda','BLR',0,'C',true);
			$pdf->SetXY(150, 66);			
			$pdf->Cell(80,14,'Firma',1,0,'C',true);				
			$pdf->Cell(40,14,'Huella',1,1,'C',true);
			
			$pdf->SetFont('Arial','',12);
			$pdf->SetTextColor(215,220,230);
			for($i=0; $i<5; $i++){
				$pdf->Cell(40,8,'','TLR',0,'C');	
				$pdf->Cell(25,8,'','TLR',0,'C');
				$pdf->Cell(25,8,'','TLR',0,'C');
				$pdf->Cell(25,8,'','TLR',0,'C');
				$pdf->Cell(25,8,'','TLR',0,'C');				
				$pdf->Cell(80,8,'','TLR',0,'C');				
				$pdf->Cell(40,8,'','TLR',1,'C');
				
				$pdf->Cell(40,7,' DD / MM / AAAA ','LR',0,'C');	
				$pdf->Cell(25,7,'','LR',0,'C');
				$pdf->Cell(25,7,'','LR',0,'C');
				$pdf->Cell(25,8,'','LR',0,'C');
				$pdf->Cell(25,7,'','LR',0,'C');				
				$pdf->Cell(80,7,'','LR',0,'C');				
				$pdf->Cell(40,7,'','LR',1,'C');
				
				$pdf->Cell(40,8,'','BLR',0,'C');	
				$pdf->Cell(25,8,'','BLR',0,'C');
				$pdf->Cell(25,8,'','BLR',0,'C');
				$pdf->Cell(25,8,'','BLR',0,'C');
				$pdf->Cell(25,8,'','BLR',0,'C');				
				$pdf->Cell(80,8,'','BLR',0,'C');				
				$pdf->Cell(40,8,'','BLR',1,'C');
			}			
							
		}	
		$pdf->Output('FORMATO REGISTRO DE APOYOS.pdf', 'I');
	}
	else
		header("Location: ../");
?>	