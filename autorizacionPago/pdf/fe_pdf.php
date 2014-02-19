<?php
	session_start();
	
	require_once('../../facturaEquivalente/x09/classes/User.php');
	require_once('../../facturaEquivalente/x09/classes/Factura.php');	
	require_once('../../facturaEquivalente/x09/classes/Cliente.php');	
	require_once('../../facturaEquivalente/x09/classes/Programa.php');		
	require_once('../php/funciones/funciones.php');
	require_once('../../php/fpdf/fpdf.php');
	
	$logonSuccess = true;
	
	session_start();
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		//if($_SESSION['perfil_fe'] == FacturaEquivalente::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
			
	if($logonSuccess){		
		$idFacturaEquivalente = $_GET['id_fe'];
		$array = explode(',',$idFacturaEquivalente);
		
		$iniciales = array('FE' => 'No.','CM' => 'CM');
		$tipoFactura = array('', 'Factura Equivalente', 'Caja Menor');
		$quitar = array('<br>' => ' ');
		$meses = array("01" => "ENERO", "02" => "FEBRERO", "03" => "MARZO", "04" => "ABRIL", "05" => "MAYO", "06" => "JUNIO", "07" => "JULIO", "08" => "AGOSTO", "09" => "SEPTIEMBRE", "10" => "OCTUBRE", "11" => "NOVIEMBRE", "12" => "DICIEMBRE");
					
		$pdf = new FPDF('P','mm','Letter');
		$pdf->SetTitle('FACTURA EQUIVALENTE');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetSubject('Factura Equivalente');
		$pdf->SetMargins(15,20,15);
		
		foreach ($array as $id) {			
			$result = Factura::getInstance()->get_factura_by_id($id);
			if(mysqli_num_rows($result) == 0){
				$idFactura = '';
				$inic = '';
				$tipo = array();
				/*
				$inic = $iniciales[2];
				$tipo = explode(' ', $tipoFactura[1]);
				*/
				$consecutivo = '';	
				$descripcionPrograma = '';
				$direccionPrograma = '';
				$municipioPrograma = '';
				
				$ciudad = '';
				$fecha = '';
				$nit = '';
				$nombreTercero = '';
				$actividadEconomica = '';
				$direccionTercero = '';
								
				$tarifaIva = '';
				$tarifaRetencionIva = '';
				$retencionFuente = '';
				$impuestoRenta = '';
				$retencionIca = '';
				$estadoFactura = 0;
				
				$referencia = array();
				$descripcion = array();
				$cantidad = array();
				$valor = array();
				$cantidad_fe = array();
				$valor_fe = array();
			}
			else{
				$factura = mysqli_fetch_array($result);				
				$idFactura = $factura['idFactura'];
				$consecutivo = $factura['numeroFactura'];
						
				$idPrograma = $factura['idPrograma'];
				$programa = mysqli_fetch_array(Programa::getInstance()->get_programa_by_id($idPrograma));
				$descripcionPrograma = $programa['contrato'];				
				$direccionPrograma = strtr($programa['direccion'],$quitar);
				$municipioPrograma = $programa['ciudad'];
				$inic = strtr($programa['iniciales'],$iniciales);
				$tipo = explode(' ', $programa['descripcion']);
								
				$ciudad = mb_strtoupper($factura['ciudad']);
				$fecha_fe = explode('-', $factura['fecha']);
				$fecha = $meses[$fecha_fe[1]]." ".$fecha_fe[2]." DE ".$fecha_fe[0];				
				
				$idCliente = $factura['idCliente'];				
				$cliente = mysqli_fetch_array(Cliente::getInstance()->get_cliente_by_id($idCliente));
				$nit = $cliente['nit'];
				$nombreTercero = mb_strtoupper($cliente['nombres']);	
				$actividadEconomica = $cliente['actividadEconomica'];
				$direccionTercero = mb_strtoupper($cliente['direccion']);
					
				$tarifaIva = $factura['tarifaIva'];
				$tarifaRetencionIva = $factura['tarifaRetencionIva'];
				$retencionFuente = $factura['retencionFuente'];
				$impuestoRenta = $factura['impuestoRenta'];
				$retencionIca = $factura['retencionIca'];
				$estadoFactura = $factura['idEstadoFactura'];					
				
				$referencia = array();
				$descripcion = array();
				$cantidad = array();
				$valor = array();
				$cantidad_fe = array();
				$valor_fe = array();		
				$result_f = Factura::getInstance()->get_item($idFactura);	
				$i = 0;
				while ($row = mysqli_fetch_array($result_f)){
					$referencia[$i] = $row['referencia'];
					$descripcion[$i] = mb_strtoupper($row['descripcion']);
					
					$cantidad_fe[$i] = $row['cantidad'];
					switch($row['cantidad']){
						case -1:	$row['cantidad'] = 'GL';
									$cantidad_fe[$i] = 1;
									break;
						case 0:		$row['cantidad'] = '';
									break;
					}
					
					$valor_fe[$i] = $row['valor'];
					switch($row['valor']){
						case 0:		$row['valor'] = '';
									break;
						default: 	$row['valor'] = '$ '.number_format($row['valor'],0,',','.');
									break;			
					}	
						
					$cantidad[$i] = $row['cantidad'];
					$valor[$i] = $row['valor'];
					$i++;
				}
			}		
						
			$pdf->AddPage();
			
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(186,233,'',1,1,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(186,6,'ORIGINAL','',0,'C');
			
			$pdf->SetXY(60, 20);
			$pdf->SetFont('Arial','B',25);			
			$pdf->Image('../img/logo.png',21,23,33);
				
			$pdf->Cell(96,2,'','',2,'C');	
			$pdf->Cell(96,9,'CORPRODINCO','',2,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(96,3,utf8_decode('Corporación de Profesionales para el Desarrollo Integral Comunitario'),'',2,'C');			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(96,3,$descripcionPrograma,'',2,'C');			
			$pdf->Cell(96,3,'NIT. 804.003.003-2','',2,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(96,3,utf8_decode('Somos Grandes Contribuyentes Según Resolución No. 014047'),'',2,'C');
			$pdf->Cell(96,3,'de Diciembre 23 de 2009','',1,'C');
			
			$pdf->SetXY(156, 20);
			$pdf->Cell(45,5,'','',2,'C');			
			$pdf->Cell(5);
			$pdf->Cell(35,5,$tipo[0],'LTR',0,'C');
			$pdf->SetXY(156, 29);
			$pdf->Cell(5);
			$pdf->Cell(35,4,$tipo[1],'LR',0,'C');
			$pdf->SetXY(156, 33);
			$pdf->Cell(5);
			$pdf->Cell(18,8,$inic,'LB',0,'C');
			$pdf->Cell(17,8,$consecutivo,'RB',0,'C');
			$pdf->Cell(5,14,'','R',1,'C');
						
			$pdf->Cell(5);		
			$pdf->SetFont('Arial','B',9);			
			$pdf->Cell(110,6,utf8_decode('CIUDAD Y FECHA DE LA OPERACIÓN'),'TLR',0,'C');
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(61,6,'RESPONSABLE DE IVA REGIMEN COMUN','TLR',1,'C');
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','',9);				
			$pdf->Cell(55,6,$ciudad,'LB',0,'C');
			$pdf->Cell(55,6,$fecha,'RB',0,'C');			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(61,6,'AGENTE DE RETENCION EN LA FUENTE','LRB',1,'C');
			
			$pdf->Ln(2);			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);								
			$pdf->Cell(61,6,'NIT','TL',0,'C');
			$pdf->Cell(5,6,'','T',0,'');
			$pdf->Cell(110,6,'NOMBRE PERSONA NATURAL','TR',1,'C');
						
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','',9);					
			$pdf->Cell(61,6,$nit,'L',0,'C');
			$pdf->Cell(5,6,'','',0,'');
			$pdf->Cell(110,6,$nombreTercero,'R',1,'C');
			
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','B',9);						
			$pdf->Cell(61,6,'ACTIVIDAD ECONOMICA','L',0,'C');
			$pdf->Cell(5,6,'','',0,'');
			$pdf->Cell(110,6,'DIRECCION','R',1,'C');
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(61,6,$actividadEconomica,'LB',0,'C');
			$pdf->Cell(5,6,'','B',0,'');
			$pdf->Cell(110,6,$direccionTercero,'RB',1,'C');		
						
			//info
			$pdf->Ln(2);	
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,6,'REF.',1,0,'C');
			$pdf->Cell(88,6,'DESCRIPCION DE LOS ARTICULOS',1,0,'C');			
			$pdf->Cell(20,6,'CANTIDAD',1,0,'C');
			$pdf->Cell(24,6,'VR. UNIT.',1,0,'C');
			$pdf->Cell(24,6,'VR. PARCIAL',1,1,'C');
								
			//Valores	
			$valor_parcial = '';		
			$subtotal = 0;
			$valor_iva = '';
			$valor_reteiva = '';
			$valor_retefuente = '';
			$valor_reteica = '';
			$total = '';
						
			for($i=0; $i<9; $i++){
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(5);
				$pdf->Cell(20,5,$referencia[$i],1,0,'C');
				$pdf->Cell(88,5,$descripcion[$i],1,0,'L');
				$pdf->Cell(20,5,$cantidad[$i],1,0,'C');		
				$pdf->Cell(24,5,$valor[$i],1,0,'R');
				$valor_parcial = '';
				if($cantidad_fe[$i] != '0' && $cantidad_fe[$i] != '0'){
					$valor_parcial = $valor_fe[$i] * $cantidad_fe[$i];
					$subtotal = $subtotal + $valor_parcial;
					if($valor_parcial != 0)
						$valor_parcial = '$ '.number_format($valor_parcial,0,',','.');
					else	
						$valor_parcial = '';	
					//$valor[$i] = '$ '.number_format($valor[$i],0,',','.');					
				}
				$pdf->Cell(24,5,$valor_parcial,1,1,'R');
			}
					
			if($tarifaIva == '0.0')
				$valor_iva = 0;
			else
				$valor_iva = $subtotal * ($tarifaIva / 100);
				
			if($tarifaRetencionIva == '0.0')
				$valor_reteiva = 0;
			else
				$valor_reteiva = $valor_iva * ($tarifaRetencionIva / 100);
			
			if($retencionFuente == '0.0')
				$valor_retefuente = $impuestoRenta;
			else
				$valor_retefuente = $subtotal * ($retencionFuente / 100);
			
			if($retencionIca == '')
				$valor_reteica = 0; 
			else{	
				$reteica = explode('*', $retencionIca);
				if(count($reteica) == 2){	
					$valor1 = $reteica[0];
					$valor2 = $reteica[1];							
					$valor_reteica = ($reteica[0] / $reteica[1]) * $subtotal;
				}
				else
					$valor_reteica = 0;
			}	
			
			$total = ($subtotal - ($valor_retefuente + $valor_reteica));
			/*
			$subtotal = '$ '.number_format($subtotal,0,',','.');	
			$tarifaIva = number_format($tarifaIva,1,',','.').'%';
			$valor_iva = '$ '.number_format($valor_iva,0,',','.');				
			$tarifaRetencionIva = number_format($tarifaRetencionIva,1,',','.').'%';
			$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');			
			$retencionFuente = number_format($retencionFuente,1,',','.').'%';
			$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');			
			$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
			$total = '$ '.number_format($total,0,',','.');	
			/**/
			if($subtotal != '0'){			
				$subtotal = '$ '.number_format($subtotal,0,',','.');
				$tarifaIva = number_format($tarifaIva,1,',','.').'%';
				$valor_iva = '$ '.number_format($valor_iva,0,',','.');	
				$tarifaRetencionIva = number_format($tarifaRetencionIva,1,',','.').'%';
				$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');	
				$retencionFuente = number_format($retencionFuente,1,',','.').'%';
				$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');
				$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
				$total = '$ '.number_format($total,0,',','.');
			}
			else{
				$subtotal = '';	
				$tarifaIva = '';
				$valor_iva = '';	
				$tarifaRetencionIva = '';	
				$valor_reteiva = '';	
				$retencionFuente = '';
				$valor_retefuente = '';	
				$valor_reteica = '';
				$total = '';
			}				
			
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,'Total Factura','TLR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$subtotal,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Tarifa de IVA a la que se hallan gravados los bienes o servicios'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$tarifaIva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('IVA teórico generado en la operación por'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_iva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Tarifa de Retención de IVA vigente'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$tarifaRetencionIva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Valor del impuesto asumido, Retención de IVA asumido'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_reteiva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('% de Retención en la Fuente'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$retencionFuente,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Valor Retención en la Fuente a título de Impuesto de Renta'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_retefuente,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('% Retención en la Fuente a título de Impuesto de Industria y Cio.'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$retencionIca,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Valor Retención en la Fuente a título de Impuesto de Industria y Cio.'),'LRB',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_reteica,1,1,'R');
			
			$pdf->Ln(5);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,'NETO A PAGAR','',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$total,1,1,'R');
			
			$pdf->Ln(20);
			$pdf->Cell(5);
			$pdf->Cell(80,5,'','B',2,'R');
			$pdf->Cell(80,5,'FIRMA DEL RESPONSABLE','',1,'C');
			
			$pdf->Ln(21);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(186,4,$direccionPrograma,'',1,'C');
			//$pdf->Cell(186,4,$municipioPrograma.', Colombia','',1,'C');			
			$pdf->Cell(186,4,'E-mail:corprodinco@gmail.com','',1,'C');
			
			if($estadoFactura == 2){
				$pdf->SetXY(15, 112);
				$pdf->SetTextColor(255,0,0);
				$pdf->SetFont('Arial','B',50);
				$pdf->Cell(186,5,'ANULADA','',1,'C');				
			}
			//COPIA
			$pdf->AddPage();
			
			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(186,233,'',1,1,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(186,6,'COPIA','',0,'C');
			
			$pdf->SetXY(60, 20);
			$pdf->SetFont('Arial','B',25);			
			$pdf->Image('../img/logo.png',21,23,33);
				
			$pdf->Cell(96,2,'','',2,'C');	
			$pdf->Cell(96,9,'CORPRODINCO','',2,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(96,3,utf8_decode('Corporación de Profesionales para el Desarrollo Integral Comunitario'),'',2,'C');			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(96,3,$descripcionPrograma,'',2,'C');			
			$pdf->Cell(96,3,'NIT. 804.003.003-2','',2,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(96,3,utf8_decode('Somos Grandes Contribuyentes Según Resolución No. 014047'),'',2,'C');
			$pdf->Cell(96,3,'de Diciembre 23 de 2009','',1,'C');
			
			$pdf->SetXY(156, 20);
			$pdf->Cell(45,5,'','',2,'C');			
			$pdf->Cell(5);
			$pdf->Cell(35,5,$tipo[0],'LTR',0,'C');
			$pdf->SetXY(156, 29);
			$pdf->Cell(5);
			$pdf->Cell(35,4,$tipo[1],'LR',0,'C');
			$pdf->SetXY(156, 33);
			$pdf->Cell(5);
			$pdf->Cell(18,8,$inic,'LB',0,'C');
			$pdf->Cell(17,8,$consecutivo,'RB',0,'C');
			$pdf->Cell(5,14,'','R',1,'C');
						
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','B',9);				
			$pdf->Cell(110,6,utf8_decode('CIUDAD Y FECHA DE LA OPERACIÓN'),'TLR',0,'C');
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(61,6,'RESPONSABLE DE IVA REGIMEN COMUN','TLR',1,'C');
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','',9);				
			$pdf->Cell(55,6,$ciudad,'LB',0,'C');
			$pdf->Cell(55,6,$fecha,'RB',0,'C');			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(61,6,'AGENTE DE RETENCION EN LA FUENTE','LRB',1,'C');
			
			$pdf->Ln(2);			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);								
			$pdf->Cell(61,6,'NIT','TL',0,'C');
			$pdf->Cell(5,6,'','T',0,'');
			$pdf->Cell(110,6,'NOMBRE PERSONA NATURAL','TR',1,'C');
						
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','',9);					
			$pdf->Cell(61,6,$nit,'L',0,'C');
			$pdf->Cell(5,6,'','',0,'');
			$pdf->Cell(110,6,$nombreTercero,'R',1,'C');
			
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','B',9);						
			$pdf->Cell(61,6,'ACTIVIDAD ECONOMICA','L',0,'C');
			$pdf->Cell(5,6,'','',0,'');
			$pdf->Cell(110,6,'DIRECCION','R',1,'C');
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(61,6,$actividadEconomica,'LB',0,'C');
			$pdf->Cell(5,6,'','B',0,'');
			$pdf->Cell(110,6,$direccionTercero,'RB',1,'C');		
						
			//info
			$pdf->Ln(2);	
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(20,6,'REF.',1,0,'C');
			$pdf->Cell(88,6,'DESCRIPCION DE LOS ARTICULOS',1,0,'C');			
			$pdf->Cell(20,6,'CANTIDAD',1,0,'C');
			$pdf->Cell(24,6,'VR. UNIT.',1,0,'C');
			$pdf->Cell(24,6,'VR. PARCIAL',1,1,'C');
								
			//Valores
			for($i=0; $i<9; $i++){
				$pdf->SetFont('Arial','',9);
				$pdf->Cell(5);
				$pdf->Cell(20,5,$referencia[$i],1,0,'C');
				$pdf->Cell(88,5,$descripcion[$i],1,0,'L');
				$pdf->Cell(20,5,$cantidad[$i],1,0,'C');		
				$pdf->Cell(24,5,$valor[$i],1,0,'R');
				$valor_parcial = '';
				if($cantidad_fe[$i] != '0'  && $cantidad_fe[$i] != '0'){
					$valor_parcial = $valor_fe[$i] * $cantidad_fe[$i];
					if($valor_parcial != 0)
						$valor_parcial = '$ '.number_format($valor_parcial,0,',','.');
					else	
						$valor_parcial = '';
					//$valor[$i] = '$ '.number_format($valor[$i],0,',','.');					
				}
				$pdf->Cell(24,5,$valor_parcial,1,1,'R');
			}
			
			$pdf->Cell(5);	
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,'Total Factura','TLR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$subtotal,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Tarifa de IVA a la que se hallan gravados los bienes o servicios'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$tarifaIva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('IVA teórico generado en la operación por'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_iva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Tarifa de Retención de IVA vigente'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$tarifaRetencionIva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Valor del impuesto asumido, Retención de IVA asumido'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_reteiva,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('% de Retención en la Fuente'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$retencionFuente,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Valor Retención en la Fuente a título de Impuesto de Renta'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_retefuente,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('% Retención en la Fuente a título de Impuesto de Industria y Cio.'),'LR',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$retencionIca,1,1,'R');
			
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,utf8_decode('Valor Retención en la Fuente a título de Impuesto de Industria y Cio.'),'LRB',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$valor_reteica,1,1,'R');
			
			$pdf->Ln(5);
			$pdf->Cell(5);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(152,5,'NETO A PAGAR','',0,'R');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(24,5,$total,1,1,'R');
			
			$pdf->Ln(20);
			$pdf->Cell(5);
			$pdf->Cell(80,5,'','B',2,'R');
			$pdf->Cell(80,5,'FIRMA DEL RESPONSABLE','',1,'C');
						
			$pdf->Ln(21);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(186,4,$direccionPrograma,'',1,'C');
			//$pdf->Cell(186,4,$municipioPrograma.' , Colombia','',1,'C');			
			$pdf->Cell(186,4,'E-mail:corprodinco@gmail.com','',1,'C');
			
			if($estadoFactura == 2){
				$pdf->SetXY(15, 112);
				$pdf->SetTextColor(255,0,0);
				$pdf->SetFont('Arial','B',50);
				$pdf->Cell(186,5,'ANULADA','',1,'C');				
			}
		}
		//mysqli_free_result($result);
		$pdf->Output('FACTURA EQUIVALENTE.pdf', 'I');	
	}
	else
		header("Location: ../index.html");
?>	