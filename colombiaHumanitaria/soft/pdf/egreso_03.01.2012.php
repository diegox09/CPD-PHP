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
			
		$pdf = new FPDF('P','mm','Letter');
		$pdf->SetTitle('FORMATO EGRESO');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetSubject('Formato Egreso');
		$pdf->SetMargins(15,15,15);
						
		foreach ($array as $id) {	
			
			/*
			$documentoDamnificado = '60332085';
			$nitDamnificado = '60332085-9';		
			$nombreDamnificado = 'ALBA LUCIA BELTRAN';
			$nombreArrendador = 'Jose Aurelio Leal Rodriguez';			
						
			$numeroEgreso = '099-00000005455';			
			$numeroCheque = '00029524443';					
			*/
			
			$fechaEgreso = '03     01     2012';
			$fechaEgreso2 = '2012/01/03';
			$valorArriendo = '700,000.00';
			$valorLetras = 'SETECIENTOS MIL PESOS M/CTE';
			
			$nombreDamnificado = '';
			$documentoDamnificado = '';
			$nitDamnificado = '';
			$nombreArrendador = '';
			
			$numeroEgreso = '';
			$numeroCheque = '';
			
			$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($id, $fase);
			if(mysqli_num_rows($result) != 0){
				$arriendo = mysqli_fetch_array($result);					
				$idDamnificado = $arriendo['id_damnificado'];
				$idArrendador = $arriendo['id_arrendador'];	
				if($arriendo['comprobante'] != NULL)
					$numeroEgreso = '099-0000000'.$arriendo['comprobante'];
				$numeroCheque = $arriendo['cheque'];
				
				$result = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
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
										
					$documentoDamnificado = number_format($damnificado['documento_damnificado']);
					$nitDamnificado = $damnificado['documento_damnificado'];	
				}
								
				$result = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);
				if(mysqli_num_rows($result) != 0){	
					$arrendador = mysqli_fetch_array($result);									
					$nombreArrendador = $arrendador['nombre_arrendador'];
				}
				
				
			}
			mysqli_free_result($result);
			
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(20);		
			$pdf->Cell(100,5,$fechaEgreso,0,0,'R');
			$pdf->Cell(33,5,'******* 700,000.00',0,1,'R');	
			$pdf->Cell(32);	
			
			$pdf->Ln(4);
			$pdf->Cell(20);			
			$pdf->Cell(165,5,'*** '.mb_strtoupper($nombreArrendador),0,1,'L');
			
			$pdf->Ln(4);
			$pdf->Cell(20);	
			$pdf->Cell(165,5,'*** '.$valorLetras,0,1,'L');

			$pdf->Ln(15);
			$pdf->Cell(65,5,'CORPRODINCO CONTRATO DE MANDATO',0,0,'L');
			$pdf->Cell(55,5,'NIT : 804.003.003-2',0,0,'C');
			$pdf->Cell(43,5,'EGRESOS CONTRATO MANDATO A',0,0,'R');
			$pdf->Cell(22,5,$numeroEgreso,0,1,'R');
			
			$pdf->Ln(2);
			$pdf->Cell(12,4,'Girado a','LT',0,'L');
			$pdf->Cell(141,4,':   '.mb_strtoupper($nombreArrendador),'T',0,'L');
			$pdf->Cell(15,4,'FECHA      :','T',0,'L');
			$pdf->Cell(17,4,$fechaEgreso2,'TR',1,'L');
			
			$pdf->Cell(12,4,'NIT','L',0,'L');
			$pdf->Cell(141,4,':   '.$documentoDamnificado,0,0,'L');
			$pdf->Cell(32,4,'','R',1,'L');
			
			$pdf->Cell(12,4,'Banco','LB',0,'L');
			$pdf->Cell(115,4,':   CTA CTE 260760442 ALCALDIA DE CUCUTA','B',0,'L');
			$pdf->Cell(26,4,'C. Costo : 0099 000','B',0,'L');
			$pdf->Cell(15,4,'Cheque No.','B',0,'L');
			$pdf->Cell(17,4,$numeroCheque,'RB',1,'L');
			
			$pdf->Cell(17,2,'','L',0,'L');
			$pdf->Cell(136,2,'','R',0,'L');
			$pdf->Cell(32,2,'','R',1,'R');
			$pdf->Cell(17,4,'LA SUMA DE','L',0,'L');
			$pdf->Cell(136,4,':   '.$valorLetras,'R',0,'L');
			$pdf->Cell(32,4,$valorArriendo,'R',1,'R');
			$pdf->Cell(17,2,'','LB',0,'L');
			$pdf->Cell(136,2,'','BR',0,'L');
			$pdf->Cell(32,2,'','BR',1,'R');
						
			$pdf->Cell(153,6,'Por Concepto de :','LBR',0,'C');
			$pdf->Cell(32,6,'Valor','BR',1,'C');

			$pdf->Cell(123,5,'2815900201-0099 000 ARRIENDO POR TRES MESES Y MEDIO :','L',0,'L');
			$pdf->Cell(25,5,$nitDamnificado,0,0,'R');
			$pdf->Cell(5,5,'','R',0,'R');
			$pdf->Cell(32,5,$valorArriendo,'BR',1,'R');
			
			$pdf->Cell(148,5,'Girado :','L',0,'R');
			$pdf->Cell(5,5,'','R',0,'R');
			$pdf->Cell(32,5,$valorArriendo,'BR',1,'R');
			
			$pdf->Cell(153,4,'','LR',0,'R');
			$pdf->Cell(32,4,'','R',1,'R');
			
			$pdf->Cell(20,4,'','L',0,'R');
			$pdf->Cell(133,4,'CONTRATO MANDATO SUSCRITO CON LA ALCALDIA DE CUCUTA FASE 3','R',0,'L');
			$pdf->Cell(32,4,'','R',1,'R');
			
			$pdf->Cell(20,4,'','L',0,'R');
			$pdf->Cell(133,4,'BENEFICIARIO '.mb_strtoupper($nombreDamnificado),'R',0,'L');
			$pdf->Cell(32,4,'','R',1,'R');
			
			$pdf->Cell(153,141,'','LR',0,'R');
			$pdf->Cell(32,141,'','R',1,'R');
						
			$pdf->Cell(33,4,'','TLR',0,'C');
			$pdf->Cell(33,4,'','TR',0,'C');
			$pdf->Cell(33,4,'','TR',0,'C');
			$pdf->Cell(86,4,'','TR',1,'L');
			$pdf->Cell(33,6,utf8_decode('Elaboró'),'LRB',0,'C');
			$pdf->Cell(33,6,utf8_decode('Revisó'),'RB',0,'C');
			$pdf->Cell(33,6,utf8_decode('Aprobó'),'RB',0,'C');
			$pdf->Cell(86,6,'Firma y Sello del Beneficiario ID:','RB',1,'L');
			
		}	
		$pdf->Output('EGRESO.pdf', 'I');
	}
	else
		header("Location: ../");	
?>	