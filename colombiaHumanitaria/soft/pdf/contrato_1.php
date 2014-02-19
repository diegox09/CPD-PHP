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
		$pdf->SetTitle('FORMATO REGISTRO DE APOYOS');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetSubject('Formato Registro de Apoyos');
		$pdf->SetMargins(15,15,15);
						
		foreach ($array as $id) {
			$nombreArrendador = '';
			$documentoArrendador = '';
			$telefonoArrendador = '';
			
			$nombreDamnificado = '';
			$documentoDamnificado = '';
			$telefonoDamnificado = '';
			$direccionDamnificado = '';
			$barrioDamnificado = '';
			
			$lugarFecha = '';
			$canon = '';
			$valorArriendo = '';
			$duracion = '';
			$inicio = '';
			$servicios = '';
			$dia = '';
			$mes = '';
			$year = '';
			
			$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($id, $fase);
			if(mysqli_num_rows($result) != 0){
				$arriendo = mysqli_fetch_array($result);					
				$idDamnificado = $arriendo['id_damnificado'];
				$idArrendador = $arriendo['id_arrendador'];	
				
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
					$documentoDamnificado = number_format($damnificado['documento_damnificado'],0,',','.');
					$telefonoDamnificado = $damnificado['telefono'];
					$direccionDamnificado = $damnificado['direccion'];
					$barrioDamnificado = $damnificado['barrio'];
				}
				
				$result = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);
				if(mysqli_num_rows($result) == 0){	
					$nombreArrendador = '';
					$documentoArrendador = '';
					$telefonoArrendador = '';
				}
				else{	
					$arrendador = mysqli_fetch_array($result);									
					$nombreArrendador = $arrendador['nombre_arrendador'];
					$documentoArrendador = number_format($arrendador['documento_arrendador'],0,',','.');
					$telefonoArrendador = $arrendador['telefono_arrendador'];
				}
				
				$lugarFecha = 'CUCUTA, 01 DE NOVIEMBRE DE 2011';
				$canon = 'DOSCIENTOS MIL PESOS';
				$valorArriendo = '200.000';
				$duracion = 'TRES MESES Y MEDIO';
				$inicio = '01 DE NOVIEMBRE DE 2011';
				$servicios = 'AGUA Y ENERGIA';
				$dia = '01';
				$mes = 'NOVIEMBRE';
				$year = '2011';
			}
			mysqli_free_result($result);
			
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','BU',10);
			$pdf->Cell(30,7,'',0,0,'C');		
			$pdf->Cell(125,7,'CONTRATO DE ARRENDAMIENTO DE VIVIENDA URBANA',0,0,'C');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10,7,utf8_decode('N°'),0,0,'R');
			$pdf->Cell(20,7,'',0,1,'L');
			
			$pdf->Ln(4);			
			$pdf->Cell(43,7,'Lugar y fecha del contrato:',0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(142,7,' '.mb_strtoupper($lugarFecha),'B',1,'L');
			
			$pdf->Ln(4);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(20,5,'Arrendador:',0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(165,5,' '.mb_strtoupper($nombreArrendador),'B',1,'L');
			
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(14,5,utf8_decode('Cédula:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(80,5,' '.$documentoArrendador,'B',0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(16,5,utf8_decode('Teléfono:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(75,5,' '.$telefonoArrendador,'B',1,'L');
			
			$pdf->Ln(4);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(22,5,'Arrendatario:',0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(163,5,' '.mb_strtoupper($nombreDamnificado),'B',1,'L');
			
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(14,5,utf8_decode('Cédula:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(80,5,' '.$documentoDamnificado,'B',0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(16,5,utf8_decode('Teléfono:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(75,5,' '.$telefonoDamnificado,'B',1,'L');
			
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(17,5,utf8_decode('Dirección:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(168,5,' '.mb_strtoupper($direccionDamnificado.' '.$barrioDamnificado),'B',1,'L');
			
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(13,5,'Canon:',0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(105,5,' '.$canon,'B',0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15,5,'Pesos($ ',0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(18,5,'  '.$valorArriendo,'B',0,'L');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(34,5,' ) M/cte., mensuales.',0,1,'L');
			
			$pdf->Ln(1);
			$pdf->Cell(35,5,utf8_decode('Término de duración:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(150,5,' '.$duracion,'B',1,'L');
			
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(33,5,utf8_decode('Fecha de iniciación:'),0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(152,5,' '.$inicio,'B',1,'L');
			
			$pdf->Ln(1);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(21,5,'Servicios de:',0,0,'L');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(164,5,' '.$servicios,'B',1,'L');		
			$pdf->Ln(3);
			
			$texto1 = 'Además de las anteriores estipulaciones, el ARRENDADOR y el ARRENDATARIO convienen las siguientes: Primera. Pago, oportunidad y sitio. - El ARRENDATARIO se obliga a pagar el canon acordado dentro de los plazos previstos en';
			$texto2 = 'El canon se reajustará anualmente en la proporción máxima que autorice el gobierno, en principio el incremento será del 90% del incremento del índice de precios al consumidor en el año calendario inmediato anterior. Segunda. Mora. - La mora por falta de pago de la renta mensual en la oportunidad y forma acordada facultará al ARRENDADOR para cesar el arriendo y exigir judicial o extrajudicialmente la restitución del bien. Tercera. Destinación. - El ARRENDATARIO se obliga a usar el inmueble para la vivienda de él y de su familia y no podrá darle otro uso, ni ceder o transferir el arrendamiento sin la autorización escrita del ARRENDADOR. El incumplimiento de esta cláusula dará derecho al ARRENDADOR para dar por terminado el contrato y exigir la entrega del inmueble o, en caso de cesión o subarriendo, celebrar un nuevo contrato con los usuarios reales, sin necesidad de requerimientos judiciales o privados, a los cuales renuncia el ARRENDATARIO. Cuarta. Recibo y estado. - El ARRENDATARIO declara que ha recibido el inmueble objeto de este contrato en buen estado, conforme al inventario que se adjunta, el cual hace parte de este contrato; en el mismo se determinan los servicios, cosas y usos conexos adicionales. El ARRENDATARIO, a la terminación del contrato, deberá devolver al ARRENDADOR el inmueble en el mismo estado, salvo el deterioro proveniente del tiempo y uso legítimos. Quinta. Mejoras. - El ARRENDATARIO tendrá a su cargo las reparaciones locativas a que se refiere la Ley (C.C. arts. 2028, 2029 y 2030) y no podrá realizar otras sin el consentimiento escrito del ARRENDADOR. Sexta. Obligaciones de las partes. - Son obligaciones de las partes las siguientes: a) Del ARRENDADOR: 1. Entregar al ARRENDATARIO en la fecha convenida el inmueble dado en arrendamiento en buen estado de servicio, seguridad y sanidad y poner a su disposición los servicios, cosas o usos conexos y los adicionales aquí convenidos. 2. Mantener en el inmueble los servicios, las cosas y los usos conexos y adicionales en buen estado de servir para el fin convenido en el contrato. 3. Entregar al ARRENDATARIO una copia del reglamento interno de propiedad horizontal al que se encuentra sometido el inmueble (ello cuando el inmueble arrendado esté sometido a dicho régimen). 4. Las demás obligaciones consagradas para los arrendadores en el capítulo II, Título XXVI, Libro 4 del Código Civil (Ley 820 de 2003, art. 8, núm. 5). b) Del ARRENDATARIO: 1. Pagar al ARRENDADOR en el lugar convenido en la cláusula primera del presente contrato, el precio del arrendamiento. En el evento que el ARRENDADOR rehúse recibir en las condiciones y lugar aquí acordado, el ARRENDATARIO podrá efectuarlo mediante consignación a favor del ARRENDADOR en las instituciones autorizadas por el Gobierno Nacional para tal efecto de acuerdo con el procedimiento legal vigente. 2. Cuidar el inmueble y las cosas recibidas en arrendamiento. En caso de daños o deterioros distintos derivados del uso normal o de la acción del tiempo y que fueren imputables al mal uso del inmueble o a su propia culpa, efectuar oportunamente y por su cuenta las reparaciones o sustituciones necesarias. 3. Cumplir con las normas consagradas en el reglamento de propiedad horizontal al que se encuentra sometido el inmueble arrendado (ello cuando el mismo esté sometido a dicho régimen), así como las demás disposiciones que dicte el Gobierno Nacional dirigidas a la protección de los derechos de todos los vecinos. 4. Las demás obligaciones consagradas para los arrendatarios el capítulo III, Título XXVI, Libro 4 del Código Civil (Ley 820 de 2003, art. 9, núm. 5). Séptima. Terminación del contrato. - Son causales de terminación del contrato en forma unilateral, por parte del ARRENDADOR las previstas por el artículo 22 de la Ley 820 de 2003; y por parte del ARRENDATARIO las consagradas en el artículo 23 de la misma Ley. Parágrafo. - No obstante, las partes en cualquier tiempo y de común acuerdo podrán dar por terminado el presente contrato (Ley 820 de 2003 art. 21). Octava. Preaviso. - El ARRENDADOR podrá dar por terminado el contrato de arrendamiento durante cualquiera de sus prórrogas, mediante previo aviso escrito dirigido al ARRENDATARIO A través del servicio postal autorizado, con tres meses de anticipación y el pago de la indemnización que prevé la Ley (Ley 820 de 2003, art. 22, núm. 7). Así mismo, el ARRENDATARIO podrá dar por terminado unilateralmente el contrato de arrendamiento dentro del término inicial o el de sus prórrogas mediante previo aviso dirigido al ARRENDADOR a través del servicio postal autorizado, con un plazo no menor de tres meses y el pago de una indemnización equivalente al precio de tres (3)'; 
			/*meses de arrendamiento. Cumplidas estas condiciones el ARRENDADOR estará obligado a recibir el inmueble; si no lo hiciere, el ARRENDATARIO podrá hacer entrega provisional mediante la intervención de la autoridad administrativa competente, sin perjuicio de acudir a la acción judicial correspondiente. Novena. Cláusula penal - El incumplimiento por cualquiera de las partes de las obligaciones derivadas de este contrato la constituirá en deudora de otra por la suma de ......... a título de pena sin menos cabo canon y de los perjuicios que pudieren ocasionarse como consecuencia del incumplimiento. Décima. Linderos. - el ARRENDADOR podrá llenar el espacio correspondiente a la determinación de los linderos del inmueble objeto del presente contrato. Décima primera. Gastos. - Los gastos que cause este instrumento serán a cargo de ......... Décima segunda. Coarrendatario(s). - Para garantizar al ARRENDADOR el cumplimiento de sus obligaciones, el ARRENDATARIO tiene como coarrendatario (o como sus coarrendatarios) a ......... mayor(es) y vecino(s).  de ......... identificado(s) con cédula de ciudadanía N° ... quien(es) declaran que se obligan solidariamente con el ARRENDADOR durante el término de duración del contrato y el de sus prórrogas y portando el tiempo que permanezca el inmueble en poder de éste. Décima tercera. Servicios Públicos. - (Las reglas que se transcriben a continuación sobre los servicios públicos, establecidas en el artículo 15 de la Ley 820 de 10 de julio de 2003, entrarán en vigencia en el término de un (1) año, contado a partir de la promulgación de la presente Ley, es decir, a partir del 10 de julio de 2004, con el fin de que las empresas prestadoras de los servicios públicos domiciliarios realicen los ajustes de carácter técnico y las inversiones a que hubiere lugar). 1. El pago de los servicios públicos del inmueble objeto del presente contrato estarán a cargo del ARRENDATARIO, para lo cual, conforme al numeral 1° del artículo 15 de la Ley 820 de 2003, constituirá como garantía la suma de $ ......... , con el fin de garantizar a cada una de las empresas prestadoras de servicios públicos domiciliarios el pago de las facturas correspondientes. (Dispone la Ley 820 de 2003, artículo 15, numeral 1°, que esta suma no puede, "en ningún caso, exceder el valor de los servicios públicos correspondientes al cargo fijo, al cargo por aportes de conexión y al cargo por unidad de consumo, correspondiente a dos (2) períodos consecutivos de facturación, de conformidad con lo establecido en el artículo 18 de la Ley 689 de 2001. El cargo fijo por unidad de consumo se establecerá por el promedio de los tres (3) últimos períodos de facturación, aumentado en un cincuenta por ciento (50%)"). 2. El ARRENDADOR podrá abstenerse de cumplir las obligaciones derivadas del contrato de arrendamiento hasta tanto el ARRENDATARIO no le haga entrega de las garantías o fianzas constituidas. El ARRENDADOR podrá dar por terminado de pleno derecho el contrato de arrendamiento, si el ARRENDATARIO no cumple con esta obligación dentro de un plazo de quince (15) días hábiles contados a partir de la fecha de celebración del contrato. 3. Prestadas las garantías o depósitos a favor de la respectiva empresa de servicios públicos domiciliarios, el ARRENDADOR denunciará ante la respectiva empresa, la existencia del contrato de arrendamiento y remitirá las garantías o depósitos constituidos. El ARRENDADOR no será responsable y su inmueble dejará de estar afecto al pago de los servicios públicos, a partir del vencimiento del período de facturación correspondiente a aquél en el que se efectúa la denuncia del contrato y se remitan las garantías o depósitos constituidos. 4. Una vez notificada la empresa y acaecido el vencimiento del período de facturación, la responsabilidad sobre el pago de los servicios públicos recaerá única y exclusivamente en el ARRENDATARIO. En caso de no pago, la empresa de servicios públicos domiciliarios podrá hacer exigibles las garantías o depósitos constituidos, y si éstas no fueron suficientes, podrá ejercer las acciones a que hubiere lugar contra el ARRENDATARIO. Décima cuarta. Reparaciones indispensables no locativas. - En el caso previsto en el artículo 1993 del Código Civil, el ARRENDATARIO podrá descontar el costo de las reparaciones del valor de la renta. Tales descuentos no podrán exceder el treinta por ciento (30%) del valor de la misma; si el costo total de las reparaciones indispensables no locativas excede dicho porcentaje, el ARRENDATARIO podrá efectuar descuentos periódicos hasta el treinta por ciento (30%) del valor de la renta, hasta completar el costo total en que haya incurrido por dichas reparaciones. Para lo previsto en el artículo 1994 del Código Civil, previo cumplimiento de las condiciones previstas en dicho artículo, las partes podrán pactar contra el valor de la renta. En el evento en que los descuentos periódicos efectuados, no cubran el costo total de las reparaciones indispensables no locativas, por causa de la terminación del contrato, el ARRENDATARIO podría ejercer el derecho de retención en los términos del artículo 26 de la Ley 820 de 2003, hasta tanto el saldo insoluto no sea satisfecho íntegramente por el ARRENDADOR. Décima quinta, Subarriendo y cesión. - El ARRENDATARIO no tiene la facultad de ceder el arriendo al subarrendar, salvo autorización expresa del ARRENDADOR. En caso de contravención, el ARRENDADOR podrá dar por terminado el contrato de arrendamiento y exigir la entrega del inmueble o celebrar un nuevo contrato con los usuarios reales, caso en el cual el contrato anterior quedará sin efectos, situaciones éstas que se comunicarán por escrito al ARRENDATARIO. Décima sexta. Notificaciones. - Para efectos de notificaciones judiciales y extrajudiciales relacionadas con el presente contrato, el ARRENDADOR las recibirá en ......... , el ARRENDATARIO en ......... y el COARRENDATARIO en la ......... las direcciones aquí suministradas conservarán plena validez para todos los efectos legales, hasta tanto no sea informado a la otra parte del contrato, el cambio de la misma, para lo cual se deberá utilizar el servicio postal autorizado, siendo aplicable en lo pertinente, lo dispuesto en el artículo 10 de la Ley 820 de 2003, el cual regula el procedimiento de pago por consignación extrajudicial. El ARRENDADOR deberá informar el cambio de dirección al ARRENDATARIO Y COARRENDATARIO, mientras que éstos sólo están obligados a reportar el cambio al ARRENDADOR.';*/
			
			
			$pdf->SetFont('Arial','',9);	
			$pdf->MultiCell(185,4,utf8_decode($texto1),'0','J');
			$pdf->SetXY(176, 100);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(23,4,'  $  '.$valorArriendo,'B',1,'L');
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(185,4,utf8_decode($texto2),'0','J');
			
			/*	
			$pdf->Ln(3);		
			$pdf->Cell(83,4,utf8_decode('En constancia de lo anterior se firma por las partes el día:'),0,0,'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(15,4,$dia,'B',0,'C');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(5,4,'de',0,0,'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(30,4,$mes,'B',0,'C');
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(5,4,'de',0,0,'L');
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(15,4,$year,'B',1,'C');
			
			$pdf->Ln(12);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(20,4,'Arrendador: ',0,0,'L');
			$pdf->Cell(45,4,'','B',0,'L');
			$pdf->Cell(30,4,'',0,0,'L');
			$pdf->Cell(22,4,'Arrendatario: ',0,0,'L');
			$pdf->Cell(45,4,'','B',0,'L');
			$pdf->Cell(23,4,'',0,1,'L');
			
			$pdf->Ln(8);
			$pdf->Cell(10,4,'C.C.: ',0,0,'L');
			$pdf->Cell(55,4,'','B',0,'L');
			$pdf->Cell(30,4,'',0,0,'L');
			$pdf->Cell(10,4,'C.C.: ',0,0,'L');
			$pdf->Cell(57,4,'','B',0,'L');
			$pdf->Cell(23,4,'',0,1,'L');	
			*/
			
		}	
		$pdf->Output('CONTRATO DE ARRENDAMIENTO DE VIVIENDA URBANA.pdf', 'I');
	}
	else
		header("Location: ../");	
?>	