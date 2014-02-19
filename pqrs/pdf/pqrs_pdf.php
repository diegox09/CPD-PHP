<?php
	session_start();
	
	require_once('../php/classes/Pqrs.php');	
	require_once('../php/funciones/funciones.php');
	require_once('../php/fpdf/fpdf.php');
	
	if (array_key_exists('id_pqr', $_SESSION)) {
		$id = $_GET['id'];
		$array = explode(',',$id);
			
		$pdf = new FPDF('L','mm','Letter');
		$pdf->SetTitle('MPO-01-F-03-1 Recepción Y Tratamiento De Quejas Y Reclamos V2');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetSubject('Recepción Y Tratamiento De Quejas Y Reclamos');
		$pdf->SetMargins(15,14,15);
		
		foreach ($array as $id) {
			$result = Pqrs::getInstance()->get_pqrs_by_id($id);
			
			$numRadicacion = '';
			$FechaSolicitud = '';
			$nombrePrograma = '';
			$nombreSolicitante = '';
			$documento = '';
			$direccion = '';
			$telefono = '';
			$celular = '';
			$peticion = '';
			$queja = '';
			$reclamo = '';
			$sugerencia = '';
			$descripcion = '';
			$nombreResponsable = '';
			$fechaDireccionamiento = '';
			$solucion = '';
			$nombreFuncionario = '';
			$FechaSolucion = '';
			
			if(mysqli_num_rows($result) != 0){
				$info = mysqli_fetch_array($result);
				$numRadicacion = $info['numRadicacion'];
				$FechaSolicitud = implota($info['fechaSolicitud']);
				
				$nombrePrograma = '';
				
				$cliente = mysqli_fetch_array(Pqrs::getInstance()->get_cliente_by_id($info['idCliente']));
				$nombreSolicitante = $cliente['nombreCliente'].' '.$cliente['apellidoCliente'];
				$documento = $cliente['documentoCliente'];
				$direccion = $cliente['direccionCliente'];
				$telefono = $cliente['telefonoCliente'];
				$celular = $cliente['celularCliente'];
				
				switch($info['tipoPqrs']){
					case 1:	$peticion = 'X';
							break;
					case 2:	$queja = 'X';
							break;
					case 3:	$queja = 'X';
							break;	
					case 4:	$sugerencia = 'X';
							break;					
				}				
				
				$descripcion = utf8_encode($info['descripcionPqrs']);
				
				$nombreResponsable = '';
				
				$fechaDireccionamiento = implota($info['fechaDireccionamiento']);
				$solucion = utf8_encode($info['solucionPqrs']);
				
				$nombreFuncionario = '';
				
				$FechaSolucion = $info['fechaSolucion'];			
			}
			
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(45,21,'',1,0,'C');
			$pdf->Image('../img/logo.png',21,15,33);	
			$pdf->Cell(137,7,'MANUAL DE PROCESOS OPERATIVOS',1,0,'C');
			$pdf->Cell(64,7,'MPO-01-P-03',1,1,'C');
			
			$pdf->Cell(45);
			$pdf->Cell(137,7,'GESTION DE COMUNICACIONES',1,0,'C');
			$pdf->Cell(32,7,'FECHA: 28/03/11',1,0,'C');
			$pdf->Cell(32,7,'VERSION: 2',1,1,'C');
			
			$pdf->Cell(45);
			$pdf->Cell(137,7,utf8_decode('RECEPCIÓN Y TRATAMIENTO DE QUEJAS Y RECLAMOS'),1,0,'C');
			$pdf->Cell(64,7,'Pagina 1 de 1',1,1,'C');
						
			$pdf->Ln(3);
			$pdf->SetFont('Arial','B',10);					
			$pdf->Cell(246,7,utf8_decode('RECEPCIÓN Y TRATAMIENTO DE QUEJAS Y RECLAMOS'),1,1,'C');
						
			//info
			$pdf->Ln(3);			
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(35,7,utf8_decode('No. DE RADICACIÓN: '),'LTB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(74,7,$numRadicacion,'TBR',0,'L');
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(15,7,'FECHA:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(35,7,$FechaSolicitud,'TBR',0,'L');
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(22,7,'PROGRAMA:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(65,7,$nombrePrograma,'TBR',1,'L');
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(46,7,'NOMBRE DEL SOLICITANTE:','LTB',0,'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(113,7,$nombreSolicitante,'TBR',0,'L');	
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(47,7,'DOCUMENTO DE IDENTIDAD:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(40,7,$documento,'TBR',1,'L');
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(21,7,utf8_decode('DIRECCIÓN:'),'LTB',0,'L');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(103,7,$direccion,'TBR',0,'L');	
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(21,7,'TELEFONO:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(40,7,$telefono,'TBR',0,'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(21,7,'CELULAR:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(40,7,$celular,'TBR',1,'L');			
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(70,7,utf8_decode('Marque con una "X" solo una opción:'),'LTBR',0,'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(22,7,utf8_decode('Petición'),'TBR',0,'C');
			$pdf->Cell(22,7,$peticion,'TBR',0,'C');
			$pdf->Cell(22,7,'Queja','TBR',0,'C');
			$pdf->Cell(22,7,$queja,'TBR',0,'C');
			$pdf->Cell(22,7,'Reclamo','TBR',0,'C');
			$pdf->Cell(22,7,$reclamo,'TBR',0,'C');
			$pdf->Cell(22,7,'Sugerencia','TBR',0,'C');
			$pdf->Cell(22,7,$sugerencia,'TBR',1,'C');
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(246,7,utf8_decode('PETICICION: Manifestación de solicitud que formula una persona en relación e información o servicios suministrados.'),1,1,'L');
			$pdf->Cell(246,7,utf8_decode('QUEJA: Expresión de insatisfacción referida a la prestación de un servicio o a la deficiente o inoportuna atención de una solicitud.'),1,1,'L');
			$pdf->Cell(246,7,utf8_decode('RECLAMO: Expresión de insatisfacción en relación con la conducta o la acción de los servidores o de los particulares que llevan a cabo una función.'),1,1,'L');
			$pdf->Cell(246,7,utf8_decode('SUGERENCIA: Proposición o idea que ofrece un usuario para mejorar un proceso relacionado con la prestación del servicio o el desempeño.'),1,1,'L');
			
			$pdf->SetFont('Arial','B',9);
			$pdf->SetFillColor(200);
			$pdf->Cell(246,7,'DESCRIPCION BREVE Y CLARA DE LA SOLICITUD',1,1,'C',true);
			$pdf->Cell(246,7,$descripcion,'LR',1,'L');
			$pdf->Cell(246,7,'','LR',1,'L');
			$pdf->Cell(246,7,'','LR',1,'L');
			$pdf->Cell(246,7,'','LR',1,'L');
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(246,7,'PARA USO EXCLUSIVO DE CORPRODINCO',1,1,'C',true);
			
			$pdf->Cell(47,7,'DIRECCIONAMIENTO, PARA:','LTB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(72,7,$nombreResponsable,'TBR',0,'L');
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(15,7,'FECHA:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(35,7,$fechaDireccionamiento,'TBR',0,'L');
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(15,7,'FIRMA:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(62,7,'','TBR',1,'L');
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(246,7,utf8_decode('COMUNICACIÓN DE LA SOLUCION O TRATAMIENTO:'),'LR',1,'L');
			
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(246,7,$solucion,'LR',1,'L');
			$pdf->Cell(246,7,'','LR',1,'L');
			$pdf->Cell(246,7,'','LR',1,'L');
			$pdf->Cell(246,7,'','LR',1,'L');		
			
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(17,7,'NOMBRE:','LTB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(72,7,$nombreFuncionario,'TBR',0,'L');
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(15,7,'FIRMA:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(65,7,'','TBR',0,'L');
			$pdf->SetFont('Arial','B',9);	
			$pdf->Cell(28,7,'FECHA Y HORA:','TB',0,'L');
			$pdf->SetFont('Arial','',9);	
			$pdf->Cell(49,7,$FechaSolucion,'TBR',1,'L');
		}
		mysqli_free_result($result);
		
		$pdf->Output('MPO-01-F-03-1 Recepción Y Tratamiento De Quejas Y Reclamos V2.pdf', 'I');	
	}
	else
		header("Location: ../");
?>	