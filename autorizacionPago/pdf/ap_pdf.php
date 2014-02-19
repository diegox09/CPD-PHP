<?php
	session_start();
	
	require_once('../php/classes/AutorizacionPago.php');	
	require_once('../php/funciones/funciones.php');
	require_once('../../php/fpdf/fpdf.php');
	
	$logonSuccess = true;
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
			
	if($logonSuccess){		
		$idAutorizacionPago = $_GET['id_ap'];
		$array = explode(',',$idAutorizacionPago);
			
		$pdf = new FPDF('P','mm','Letter');
		$pdf->SetTitle('MPA-02-F-01-3 Autorización de Pago');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetSubject('Autorizacion de Pago');
		$pdf->SetMargins(15,14,15);
		
		foreach ($array as $id) {
			$result = AutorizacionPago::getInstance()->get_ap_by_id($id);
			if(mysqli_num_rows($result) == 0){
				$id_ap = '';
				$consecutivo_ap = '';
				$nombrePrograma = '';	
				$nombreMunicipio = '';	
				$fecha_ap = '';
				$nombreResponsable = '';	
				$nombreCliente = '';	
				$identificacionCliente = '';
							
				$concepto_ap = '';	
				
				$tipoPago_ap = '';
				$iva_ap = '';	
				$valorIva_ap = '';
				$retencionIva_ap = '';
				$valorRetencionIva_ap = '';
				$retencionFuente_ap = '';	
				$valorRetencionFuente_ap = '';					
				$retencionIca_ap = '';
				$valorRetencionIca_ap = '';	
				
				$sumarIva_ap = '';			
				
				$numeroPago = array();
				$comprobanteEgreso = array();
				$centroCosto = array();
				$valor = array();
				$descripcion = array();	
			}
			else{
				$info = mysqli_fetch_array($result);
				
				$id_ap = $info['idAutorizacionPago'];
				$idPrograma_ap = $info['idPrograma'];					
				$idMunicipio_ap = $info['idMunicipio'];	
				$fecha_ap = $info['fecha'];
				$consecutivo_ap = $info['consecutivo'];
				$idResponsable_ap = $info['idResponsable'];	
				$idCliente_ap = $info['idCliente'];	
						
				$concepto_ap = mb_strtoupper($info['concepto']);
																			
				$tipoPago_ap = $info['tipoPago'];
				$iva_ap = $info['iva'];
				$valorIva_ap = $info['valorIva'];
				$retencionIva_ap = $info['retencionIva'];	
				$valorRetencionIva_ap = $info['valorRetencionIva'];
				$retencionFuente_ap = $info['retencionFuente'];	
				$valorRetencionFuente_ap = $info['valorRetencionFuente'];
				$retencionIca_ap = $info['retencionIca'];
				$valorRetencionIca_ap = $info['valorRetencionIca'];	
				
				$sumarIva_ap = $info['sumarIva'];	
				
				$items = AutorizacionPago::getInstance()->get_item_ap($id_ap);
				$numeroPago = array();
				$comprobanteEgreso = array();
				$centroCosto = array();
				$valor = array();
				$descripcion = array();			
				$i = 0;
				if(mysqli_num_rows($items) != 0){					
					while ($info_item = mysqli_fetch_array($items)){						
						$numeroPago[$i] = $info_item['numeroPago'];
						$comprobanteEgreso[$i] = $info_item['comprobanteEgreso'];
						$centroCosto[$i] = $info_item['centroCosto'];
						$valor[$i] = $info_item['valor'];
						
						$descripcion_ap =  mb_strtoupper($info_item['descripcion']);
						$longitud_ap = strlen($descripcion_ap);
						while($longitud_ap > 50){							
							$descripcion[$i] = cortar($descripcion_ap,50,' ');						
							$longitud = strlen($descripcion[$i]);
							$descripcion_ap  = trim(substr($descripcion_ap, $longitud, $longitud_ap));								
							$longitud_ap = strlen($descripcion_ap);
							$i++;
						}
						$descripcion[$i] = $descripcion_ap;
						$i++;						
					}
				}
				
				$programa = mysqli_fetch_array(AutorizacionPago::getInstance()->get_programa_by_id($idPrograma_ap));						
				$nombrePrograma = mb_strtoupper($programa['nombre']);
				
				$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio_ap));
				$nombreMunicipio =  mb_strtoupper($municipio['nombre']);				
				
				$responsable = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idResponsable_ap));
				$nombreResponsable_ap = mb_strtoupper($responsable['nombre']);
				$nombreResponsable = cortar($nombreResponsable_ap,35,' ');
				
				$cliente = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idCliente_ap));
				$identificacionCliente = number_format($cliente['identificacion'],0,',','.');	
				$dv = $cliente['dv'];
				if($dv == 0)
					$dv = '';
				else
					$dv = '-'.$dv;							
				$identificacionCliente = $identificacionCliente.$dv;
				$nombreCliente_ap = mb_strtoupper($cliente['nombre']);	
				$nombreCliente = cortar($nombreCliente_ap,35,' ');
			}			
			
			$cheque = '';
			$transferencia = '';
				
			if($tipoPago_ap == 1)
				$cheque = 'X';
			else{	
				if($tipoPago_ap == 2)
					$transferencia = 'X';
			}
			
			$pdf->AddPage();
			$fecha_v3 = "2013-03-20";
			$fecha_v4 = "2013-09-23";

			//FORMATO VERSION 4
			if($id_ap == "" || (strtotime($fecha_ap) >= strtotime($fecha_v4))){
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(45,21,'',1,0,'C');
				$pdf->Image('../img/logo.png',17,17,41);	
				$pdf->Cell(77,7,'MANUAL DE PROCESOS DE APOYO',1,0,'C');
				$pdf->Cell(64,7,'MPA-02-F-01-3',1,1,'C');
				
				$pdf->Cell(45);
				$pdf->Cell(77,7,'GESTION FINANCIERA',1,0,'C');
				$pdf->Cell(32,7,'FECHA: 23/09/13',1,0,'C');
				$pdf->Cell(32,7,'VERSION: 4',1,1,'C');
				
				$pdf->Cell(45);
				$pdf->Cell(77,7,'CONTROLES INTERNOS CONTABLES',1,0,'C');
				$pdf->Cell(64,7,'Pagina 1 de 1',1,1,'C');
							
				$pdf->Ln(2);
				$pdf->SetFont('Arial','B',10);					
				$pdf->Cell(186,6,'AUTORIZACION DE PAGO','TLRB',1,'C');
				$pdf->Cell(186,6,'','',1,'C');				
							
				//info
				$pdf->Ln(1);
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(26,7,'CONSECUTIVO:',0,0,'L');
				$pdf->SetFont('Arial','',9);	
				$pdf->Cell(60,7,$consecutivo_ap,'B',0,'L');
				$pdf->Cell(5);	
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(30,7,'PROGRAMA:',0,0,'L');
				$pdf->SetFont('Arial','',9);	
				$pdf->Cell(63,7,$nombrePrograma,'B',1,'L');
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(26,7,'FECHA:',0,0,'L');
				$pdf->SetFont('Arial','',9);	
				$pdf->Cell(60,7,implota($fecha_ap),'B',0,'L');
				$pdf->Cell(5);	
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(30,7,'SOLICITADO POR:',0,0,'L');
				$pdf->SetFont('Arial','',8);	
				$pdf->Cell(63,7,$nombreResponsable,'B',1,'L');
				
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(26,7,'A FAVOR DE:',0,0,'L');
				$pdf->SetFont('Arial','',8);	
				$pdf->Cell(60,7,$nombreCliente,'B',0,'L');
				$pdf->Cell(5);
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(30,7,'NIT/CC:',0,0,'L');
				$pdf->SetFont('Arial','',9);	
				$pdf->Cell(63,7,$identificacionCliente,'B',1,'L');
				
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(26,7,'CIUDAD:',0,0,'L');
				$pdf->SetFont('Arial','',8);	
				$pdf->Cell(60,7,$nombreMunicipio,'B',1,'L');
									
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(26,7,'CONCEPTO:',0,0,'L');
																
				$pdf->SetFont('Arial','',8);
				$pdf->Ln(1);
				$pdf->Cell(26);
				$pdf->MultiCell(158,6,$concepto_ap);
				$pdf->SetXY(15, 79);
				for($i=0; $i<2; $i++){
					$pdf->Cell(26);
					$pdf->Cell(158,7,'','B',1,'L');				
				}
				
				//Valores
				$subtotal = 0;
				$valor_iva = '';
				$valor_reteiva = '';
				$valor_retefuente = '';
				$valor_reteica = '';
				$total = '';			
							
				for($i=0; $i<10; $i++){					
					if($valor[$i] != '')
						$subtotal = $subtotal + $valor[$i];					
				}
						
				if($iva_ap == '0.0')
					$valor_iva = $valorIva_ap;
				else
					$valor_iva = $subtotal * ($iva_ap / 100);
					
				if($retencionIva_ap == '0.0')
					$valor_reteiva = $valorRetencionIva_ap;
				else
					$valor_reteiva = $valor_iva * ($retencionIva_ap / 100);
				
				if($retencionFuente_ap == '0.0')
					$valor_retefuente = $valorRetencionFuente_ap;
				else
					$valor_retefuente = $subtotal * ($retencionFuente_ap / 100);
				
				if($retencionIca_ap == '')
					$valor_reteica = $valorRetencionIca_ap; 
				else{	
					$reteica = explode('*', $retencionIca_ap);
					if(count($reteica) == 2){	
						$valor1 = $reteica[0];
						$valor2 = $reteica[1];							
						$valor_reteica = ($reteica[0] / $reteica[1]) * $subtotal;
					}
					else
						$valor_reteica = 0;
				}
				
				if($sumarIva_ap == 1)
					$total = ($subtotal + ($valor_iva - $valor_reteiva) - ($valor_retefuente + $valor_reteica));
				else
					$total = ($subtotal - ($valor_retefuente + $valor_reteica));
				
				$pdf->SetFont('Arial','',9);
				if(mysqli_num_rows($result) != 0){
					$subtotal = '$ '.number_format($subtotal,0,',','.');
					$iva_ap = number_format($iva_ap,1,',','.').'%';
					$valor_iva = '$ '.number_format($valor_iva,0,',','.');
					$retencionIva_ap = number_format($retencionIva_ap,1,',','.').'%';
					$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');
					$retencionFuente_ap = number_format($retencionFuente_ap,1,',','.').'%';
					$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');
					$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
					$total = '$ '.number_format($total,0,',','.');
				}
				else{
					$subtotal = '';
					$iva_ap = '';
					$valor_iva = '';
					$retencionIva_ap = '';
					$valor_reteiva = '';
					$retencionFuente_ap = '';
					$valor_retefuente = '';
					$valor_reteica = '';
					$total = '';
					}
				
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(42,7,'GIRAR DE LA CUENTA No:',0,0,'L');
				$pdf->Cell(142,7,$descripcion[0],'B',1,'L');

				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(42,7,'VALOR A CONSIGNAR:',0,0,'L');
				$pdf->Cell(142,7,$total,'B',1,'L');	

				$pdf->SetXY(15, 110);
				$pdf->SetFont('Arial','B',9);	
				$pdf->Cell(26,6,'CHEQUE:',0,0,'L');
				$pdf->SetFont('Arial','B',11);
				$pdf->Cell(8,6,$cheque,1,0,'C');
				$pdf->Cell(58);
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(33,6,'TRANSFERENCIA:',0,0,'L');
				$pdf->SetFont('Arial','B',11);
				$pdf->Cell(8,6,$transferencia,1,1,'C');						
					
				//Firmas
				$pdf->Ln(2.5);
				$pdf->SetFont('Arial','B',10);	
				$pdf->Cell(62,8,'','',0);
				$pdf->Cell(62,8,'','',0);
				$pdf->Cell(62,8,'','',1);
				
				$pdf->Cell(36,7,'AUTORIZADO POR:',0,0,'L');
				$pdf->Cell(52,7,'','B',1,'L');								
				
			}

			else{
				//FORMATO VERSION 3			
				if((strtotime($fecha_ap) >= strtotime($fecha_v3))){
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(45,21,'',1,0,'C');
					$pdf->Image('../img/logo.png',17,17,41);	
					$pdf->Cell(77,7,'MANUAL DE PROCESOS DE APOYO',1,0,'C');
					$pdf->Cell(64,7,'MPA-02-F-01-3',1,1,'C');
					
					$pdf->Cell(45);
					$pdf->Cell(77,7,'GESTION FINANCIERA',1,0,'C');
					$pdf->Cell(32,7,'FECHA: 20/03/13',1,0,'C');
					$pdf->Cell(32,7,'VERSION: 3',1,1,'C');
					
					$pdf->Cell(45);
					$pdf->Cell(77,7,'CONTROLES INTERNOS CONTABLES',1,0,'C');
					$pdf->Cell(64,7,'Pagina 1 de 1',1,1,'C');
								
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',10);					
					$pdf->Cell(186,6,'AUTORIZACION DE PAGO','TLRB',1,'C');
					$pdf->Cell(186,6,'','',1,'C');				
								
					//info
					$pdf->Ln(1);
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'CONSECUTIVO:',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(60,7,$consecutivo_ap,'B',0,'L');
					$pdf->Cell(5);	
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'PROGRAMA:',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(67,7,$nombrePrograma,'B',1,'L');
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'FECHA:',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(60,7,implota($fecha_ap),'B',0,'L');
					$pdf->Cell(5);	
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'SOLICITADO:',0,0,'L');
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(67,7,$nombreResponsable,'B',1,'L');
					
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(26,7,'A FAVOR DE:',0,0,'L');
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(60,7,$nombreCliente,'B',0,'L');
					$pdf->Cell(5);
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'NIT/CC:',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(67,7,$identificacionCliente,'B',1,'L');
					
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'CIUDAD:',0,0,'L');
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(60,7,$nombreMunicipio,'B',1,'L');
										
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'CONCEPTO:',0,0,'L');
											
					$pdf->SetFont('Arial','',8);
					$pdf->Ln(1);
					$pdf->Cell(26);
					$pdf->MultiCell(158,6,$concepto_ap);
					
					$pdf->SetXY(15, 79);
					for($i=0; $i<4; $i++){
						$pdf->Cell(26);
						$pdf->Cell(158,6,'','B',1,'L');				
					}	
												
					$pdf->SetXY(15, 104);
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,6,'CHEQUE:',0,0,'L');
					$pdf->SetFont('Arial','B',11);
					$pdf->Cell(8,6,$cheque,1,0,'C');
					$pdf->Cell(58);
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(33,6,'TRANSFERENCIA:',0,0,'L');
					$pdf->SetFont('Arial','B',11);
					$pdf->Cell(8,6,$transferencia,1,1,'C');
					
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',10);			
					$pdf->Cell(186,7,'CONTABILIZACION',1,1,'C');
					
					//Cabecera
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(28,5,'CHEQUE /','T,L,R',2,'C');	
					$pdf->Cell(28,5,'TRANSFERENCIA','L,R,B',0,'C');
					
					$pdf->SetXY(43, 119);
					$pdf->Cell(19,10,'C.E.',1,0,'C');
					$pdf->Cell(89,10,'DESCRIPCION',1,0,'C');			
					$pdf->Cell(20,5,'CENTRO DE','T,L,R',2,'C');
					$pdf->Cell(20,5,'COSTOS','L,R,B',0,'C');
					
					$pdf->SetXY(171, 119);
					$pdf->Cell(30,10,'VALOR',1,1,'C');
					
					//Valores
					$subtotal = 0;
					$valor_iva = '';
					$valor_reteiva = '';
					$valor_retefuente = '';
					$valor_reteica = '';
					$total = '';			
								
					for($i=0; $i<10; $i++){
						$pdf->SetFont('Arial','',9);
						$pdf->Cell(28,6,$numeroPago[$i],1,0,'L');
						$pdf->Cell(19,6,$comprobanteEgreso[$i],1,0,'L');
						$pdf->SetFont('Arial','',8);
						$pdf->Cell(89,6,$descripcion[$i],1,0,'L');	
						$pdf->SetFont('Arial','',9);		
						$pdf->Cell(20,6,$centroCosto[$i],1,0,'C');
						if($valor[$i] != ''){
							$subtotal = $subtotal + $valor[$i];
							$valor[$i] = '$ '.number_format($valor[$i],0,',','.');					
						}
						$pdf->Cell(30,6,$valor[$i],1,1,'R');
					}
							
					if($iva_ap == '0.0')
						$valor_iva = $valorIva_ap;
					else
						$valor_iva = $subtotal * ($iva_ap / 100);
						
					if($retencionIva_ap == '0.0')
						$valor_reteiva = $valorRetencionIva_ap;
					else
						$valor_reteiva = $valor_iva * ($retencionIva_ap / 100);
					
					if($retencionFuente_ap == '0.0')
						$valor_retefuente = $valorRetencionFuente_ap;
					else
						$valor_retefuente = $subtotal * ($retencionFuente_ap / 100);
					
					if($retencionIca_ap == '')
						$valor_reteica = $valorRetencionIca_ap; 
					else{	
						$reteica = explode('*', $retencionIca_ap);
						if(count($reteica) == 2){	
							$valor1 = $reteica[0];
							$valor2 = $reteica[1];							
							$valor_reteica = ($reteica[0] / $reteica[1]) * $subtotal;
						}
						else
							$valor_reteica = 0;
					}
					
					if($sumarIva_ap == 1)
						$total = ($subtotal + ($valor_iva - $valor_reteiva) - ($valor_retefuente + $valor_reteica));
					else
						$total = ($subtotal - ($valor_retefuente + $valor_reteica));
					
					$pdf->SetFont('Arial','',9);
					if(mysqli_num_rows($result) != 0){
						$subtotal = '$ '.number_format($subtotal,0,',','.');
						$iva_ap = number_format($iva_ap,1,',','.').'%';
						$valor_iva = '$ '.number_format($valor_iva,0,',','.');
						$retencionIva_ap = number_format($retencionIva_ap,1,',','.').'%';
						$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');
						$retencionFuente_ap = number_format($retencionFuente_ap,1,',','.').'%';
						$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');
						$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
						$total = '$ '.number_format($total,0,',','.');
					}
					else{
						$subtotal = '';
						$iva_ap = '';
						$valor_iva = '';
						$retencionIva_ap = '';
						$valor_reteiva = '';
						$retencionFuente_ap = '';
						$valor_retefuente = '';
						$valor_reteica = '';
						$total = '';
					}
										
					//Retenciones
					$pdf->Ln(2.5);			
					$pdf->Cell(156,7,'SUBTOTAL',1,0,'R');
					$pdf->Cell(30,7,$subtotal,1,1,'R');
					$pdf->Cell(136,7,'IVA',1,0,'R');
					$pdf->Cell(20,7,$iva_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_iva,1,1,'R');
					$pdf->Cell(136,7,'Ret. IVA',1,0,'R');			
					$pdf->Cell(20,7,$retencionIva_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_reteiva,1,1,'R');
					$pdf->Cell(136,7,utf8_decode('Retención en la Fuente'),1,0,'R');
					$pdf->Cell(20,7,$retencionFuente_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_retefuente,1,1,'R');
					$pdf->Cell(136,7,'Rete ICA',1,0,'R');
					$pdf->Cell(20,7,$retencionIca_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_reteica,1,1,'R');
					//Total	4	
					$pdf->Cell(156,7,'TOTAL',1,0,'R');
					$pdf->Cell(30,7,$total,1,1,'R');
					
					//Firmas
					$pdf->Ln(2.5);
					$pdf->SetFont('Arial','B',10);	
					$pdf->Cell(62,14,'','',0);
					$pdf->Cell(62,14,'','',0);
					$pdf->Cell(62,14,'','',1);
					
					$pdf->Cell(5,7,'','',0);
					$pdf->Cell(52,7,'ELABORADO POR:','T',0,'C');
				}

				//FORMATO VERSION 2
				else{			
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(45,21,'',1,0,'C');
					$pdf->Image('../img/logo.png',17,17,41);	
					$pdf->Cell(77,7,'MANUAL DE PROCESOS DE APOYO',1,0,'C');
					$pdf->Cell(64,7,'MPA-02-F-01-3',1,1,'C');
					
					$pdf->Cell(45);
					$pdf->Cell(77,7,'GESTION FINANCIERA',1,0,'C');
					$pdf->Cell(32,7,'FECHA: 14/09/11',1,0,'C');
					$pdf->Cell(32,7,'VERSION: 2',1,1,'C');
					
					$pdf->Cell(45);
					$pdf->Cell(77,7,'CONTROLES INTERNOS CONTABLES',1,0,'C');
					$pdf->Cell(64,7,'Pagina 1 de 1',1,1,'C');
								
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',10);					
					$pdf->Cell(186,6,'AUTORIZACION DE PAGO','TLR',1,'C');
					$pdf->Cell(186,6,$nombrePrograma,'LRB',1,'C');				
								
					//info
					$pdf->Ln(1);
					$pdf->Cell(91);
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(33,7,'CONSECUTIVO No.',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(60,7,$consecutivo_ap,'B',1,'L');
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'FECHA:',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(60,7,implota($fecha_ap),'B',0,'L');
					$pdf->Cell(5);	
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(33,7,'SOLICITADO POR:',0,0,'L');
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(60,7,$nombreResponsable,'B',1,'L');
					
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(26,7,'A FAVOR DE:',0,0,'L');
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(60,7,$nombreCliente,'B',0,'L');
					$pdf->Cell(5);
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(33,7,'NIT/CC:',0,0,'L');
					$pdf->SetFont('Arial','',9);	
					$pdf->Cell(60,7,$identificacionCliente,'B',1,'L');
					
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'CIUDAD:',0,0,'L');
					$pdf->SetFont('Arial','',8);	
					$pdf->Cell(60,7,$nombreMunicipio,'B',1,'L');
										
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,7,'CONCEPTO:',0,0,'L');
											
					$pdf->SetFont('Arial','',8);
					$pdf->Ln(1);
					$pdf->Cell(26);
					$pdf->MultiCell(158,6,$concepto_ap);
					
					$pdf->SetXY(15, 79);
					for($i=0; $i<4; $i++){
						$pdf->Cell(26);
						$pdf->Cell(158,6,'','B',1,'L');				
					}	
												
					$pdf->SetXY(15, 104);
					$pdf->SetFont('Arial','B',9);	
					$pdf->Cell(26,6,'CHEQUE:',0,0,'L');
					$pdf->SetFont('Arial','B',11);
					$pdf->Cell(8,6,$cheque,1,0,'C');
					$pdf->Cell(58);
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(33,6,'TRANSFERENCIA:',0,0,'L');
					$pdf->SetFont('Arial','B',11);
					$pdf->Cell(8,6,$transferencia,1,1,'C');
					
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',10);			
					$pdf->Cell(186,7,'CONTABILIZACION',1,1,'C');
					
					//Cabecera
					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(28,5,'CHEQUE /','T,L,R',2,'C');	
					$pdf->Cell(28,5,'TRANSFERENCIA','L,R,B',0,'C');
					
					$pdf->SetXY(43, 119);
					$pdf->Cell(19,10,'C.E.',1,0,'C');
					$pdf->Cell(89,10,'DESCRIPCION',1,0,'C');			
					$pdf->Cell(20,5,'CENTRO DE','T,L,R',2,'C');
					$pdf->Cell(20,5,'COSTOS','L,R,B',0,'C');
					
					$pdf->SetXY(171, 119);
					$pdf->Cell(30,10,'VALOR',1,1,'C');
					
					//Valores
					$subtotal = 0;
					$valor_iva = '';
					$valor_reteiva = '';
					$valor_retefuente = '';
					$valor_reteica = '';
					$total = '';			
								
					for($i=0; $i<10; $i++){
						$pdf->SetFont('Arial','',9);
						$pdf->Cell(28,6,$numeroPago[$i],1,0,'L');
						$pdf->Cell(19,6,$comprobanteEgreso[$i],1,0,'L');
						$pdf->SetFont('Arial','',8);
						$pdf->Cell(89,6,$descripcion[$i],1,0,'L');	
						$pdf->SetFont('Arial','',9);		
						$pdf->Cell(20,6,$centroCosto[$i],1,0,'C');
						if($valor[$i] != ''){
							$subtotal = $subtotal + $valor[$i];
							$valor[$i] = '$ '.number_format($valor[$i],0,',','.');					
						}
						$pdf->Cell(30,6,$valor[$i],1,1,'R');
					}
							
					if($iva_ap == '0.0')
						$valor_iva = $valorIva_ap;
					else
						$valor_iva = $subtotal * ($iva_ap / 100);
						
					if($retencionIva_ap == '0.0')
						$valor_reteiva = $valorRetencionIva_ap;
					else
						$valor_reteiva = $valor_iva * ($retencionIva_ap / 100);
					
					if($retencionFuente_ap == '0.0')
						$valor_retefuente = $valorRetencionFuente_ap;
					else
						$valor_retefuente = $subtotal * ($retencionFuente_ap / 100);
					
					if($retencionIca_ap == '')
						$valor_reteica = $valorRetencionIca_ap; 
					else{	
						$reteica = explode('*', $retencionIca_ap);
						if(count($reteica) == 2){	
							$valor1 = $reteica[0];
							$valor2 = $reteica[1];							
							$valor_reteica = ($reteica[0] / $reteica[1]) * $subtotal;
						}
						else
							$valor_reteica = 0;
					}
					
					if($sumarIva_ap == 1)
						$total = ($subtotal + ($valor_iva - $valor_reteiva) - ($valor_retefuente + $valor_reteica));
					else
						$total = ($subtotal - ($valor_retefuente + $valor_reteica));
					
					$pdf->SetFont('Arial','',9);
					if(mysqli_num_rows($result) != 0){
						$subtotal = '$ '.number_format($subtotal,0,',','.');
						$iva_ap = number_format($iva_ap,1,',','.').'%';
						$valor_iva = '$ '.number_format($valor_iva,0,',','.');
						$retencionIva_ap = number_format($retencionIva_ap,1,',','.').'%';
						$valor_reteiva = '$ '.number_format($valor_reteiva,0,',','.');
						$retencionFuente_ap = number_format($retencionFuente_ap,1,',','.').'%';
						$valor_retefuente = '$ '.number_format($valor_retefuente,0,',','.');
						$valor_reteica = '$ '.number_format($valor_reteica,0,',','.');
						$total = '$ '.number_format($total,0,',','.');
					}
					else{
						$subtotal = '';
						$iva_ap = '';
						$valor_iva = '';
						$retencionIva_ap = '';
						$valor_reteiva = '';
						$retencionFuente_ap = '';
						$valor_retefuente = '';
						$valor_reteica = '';
						$total = '';
					}			
				
					//Retenciones
					$pdf->Ln(2.5);			
					$pdf->Cell(156,7,'SUBTOTAL',1,0,'R');
					$pdf->Cell(30,7,$subtotal,1,1,'R');
					$pdf->Cell(136,7,'IVA',1,0,'R');
					$pdf->Cell(20,7,$iva_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_iva,1,1,'R');
					$pdf->Cell(136,7,'Ret. IVA',1,0,'R');			
					$pdf->Cell(20,7,$retencionIva_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_reteiva,1,1,'R');
					$pdf->Cell(136,7,utf8_decode('Retención en la Fuente'),1,0,'R');
					$pdf->Cell(20,7,$retencionFuente_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_retefuente,1,1,'R');
					$pdf->Cell(136,7,'Rete ICA',1,0,'R');
					$pdf->Cell(20,7,$retencionIca_ap,1,0,'R');
					$pdf->Cell(30,7,$valor_reteica,1,1,'R');
					//Total	4	
					$pdf->Cell(156,7,'TOTAL',1,0,'R');
					$pdf->Cell(30,7,$total,1,1,'R');
					
					//Firmas
					$pdf->Ln(2.5);
					$pdf->SetFont('Arial','B',10);	
					$pdf->Cell(62,14,'','T,L',0);
					$pdf->Cell(62,14,'','T,L,R',0);
					$pdf->Cell(62,14,'','T,R',1);
					
					$pdf->Cell(5,7,'','L,B',0);
					$pdf->Cell(52,7,'ELABORADO POR:','T,B',0,'C');
					$pdf->Cell(5,7,'','R,B',0);
					$pdf->Cell(5,7,'','B',0);
					$pdf->Cell(52,7,'VB COORDINADOR:','T,B',0,'C');
					$pdf->Cell(5,7,'','R,B',0);
					$pdf->Cell(5,7,'','B',0);
					$pdf->Cell(52,7,'REVISADO POR:','T,B',0,'C');
					$pdf->Cell(5,7,'','R,B',1);	
				}
			}			
							
		}
		mysqli_free_result($result);

		if($id_ap == "" || (strtotime($fecha_ap) >= strtotime($fecha_v4)))
			$pdf->Output('MPA-02-F-01-3 Autorización de Pago V4.pdf', 'I');
		else{
			if((strtotime($fecha_ap) >= strtotime($fecha_v3)))
				$pdf->Output('MPA-02-F-01-3 Autorización de Pago V3.pdf', 'I');
			else
				$pdf->Output('MPA-02-F-01-3 Autorización de Pago V2.pdf', 'I');
		}	
			
	}
	else
		header("Location: ../index.html");
?>	