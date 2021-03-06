<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');
	
	session_start();
		
	require_once('../php/classes/AutorizacionPago.php');
	require_once('../php/funciones/funciones.php');
	
	$logonSuccess = false;
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;		
	}
	
	if($logonSuccess){		
		$fecha_inicial = explota($_GET['fecha_inicial']);
		$fecha_final = explota($_GET['fecha_final']);
		$programa = ($_GET['programa']);
		
		error_reporting(E_ALL);
		require_once '../../php/phpexcel/PHPExcel.php';
		require_once '../../php/phpexcel/PHPExcel/IOFactory.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();		
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Diego Rodriguez")
									 ->setLastModifiedBy("Diego Rodriguez")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");	
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'ID') 
					->setCellValue('B1', 'FECHA')          
					->setCellValue('C1', 'MUNICIPIO')
					->setCellValue('D1', 'DOCUMENTO DE INDENTIDAD')
					->setCellValue('E1', 'NOMBRES Y APELLIDOS')	
					->setCellValue('F1', 'BANCO')									
					->setCellValue('G1', 'TIPO DE CUENTA')	
					->setCellValue('H1', 'NUMERO DE CUENTA')									
					->setCellValue('I1', 'VALOR')
					->setCellValue('J1', 'AUTORIZADO POR')
					->setCellValue('K1', 'ESTADO');
		
		//ancho
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);		
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFA07A');
				
		$objPHPExcel->getActiveSheet()->freezePane('A2');		
		
		$fila = 1;
		$tiposCuenta = array('', 'AHORROS', 'CORRIENTE');
		$estados = array('', 'AUTORIZADO', 'PAGADO');
		
		$result = AutorizacionPago::getInstance()->get_exportar_ap($programa, $fecha_inicial, $fecha_final); 			
		while ($info = mysqli_fetch_array($result)){	
			$fila ++;
						
			$id = $info['idAutorizacionPago'];
			$idPrograma = $info['idPrograma'];
			$idUser = $info['idUser'];			
			$idMunicipio = $info['idMunicipio'];						
			$consecutivo = $info['consecutivo'];
			$fechaAP = implota($info['fecha']);			
			$idResponsable = $info['idResponsable'];			
			$idPersona = $info['idCliente'];	
			$tipoPago = $info['tipoPago'];	
			$idCreador = $info['idCreador'];
			$banco = utf8_encode($info['banco']);
			$idTipoCuenta = $info['tipoCuenta'];	
			$numeroCuenta = $info['numeroCuenta'];
			$idEstado = $info['estado'];	
			
			$fechaActualizacion = $info['fechaActualizacion'];
			$fecha = implota(substr($fechaActualizacion,0,10));
			$hora = substr($fechaActualizacion,11,8);
			$respuesta['fechaActualizacion'][] = $fecha.' '.$hora;
			
			$concepto = utf8_encode($info['concepto']);
										
			//Programa
			$programa = mysqli_fetch_array(AutorizacionPago::getInstance()->get_programa_by_id($idPrograma));						
			$nombrePrograma = utf8_encode($programa['nombre']);	
			
			//Municipio
			$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio));
			$nombreMunicipio = utf8_encode($municipio['nombre']);
			
			//Creador
			$creador = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idCreador));
			$nombreCreador = utf8_encode($creador['nombre']);
			
			//Usuario
			$usuario = mysqli_fetch_array(AutorizacionPago::getInstance()->get_user_by_id($idUser));
			$nombreUsuario = utf8_encode($usuario['nombre']);
						
			//Responsable
			$responsable = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idResponsable));
			$nombreResponsable = utf8_encode($responsable['nombre']);
			
			//Cliente
			$cliente = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idPersona));
			$identificacion = number_format($cliente['identificacion'],0,',','.');	
			$dv = $cliente['dv'];
			if($dv == 0)
				$dv = '';
			else
				$dv = '-'.$dv;							
			$identificacionCliente = $identificacion.$dv; 
			$nombreCliente = utf8_encode($cliente['nombre']);
			
			$iva = $info['iva'];
			$valorIva = $info['valorIva'];
			$retencionIva = $info['retencionIva'];
			$valorRetencionIva = $info['valorRetencionIva'];
			$retencionFuente = $info['retencionFuente'];
			$valorRetencionFuente = $info['valorRetencionFuente'];
			$retencionIca = $info['retencionIca'];	
			$valorRetencionIca = $info['valorRetencionIca'];
			$sumarIva = $info['sumarIva'];	
						
			//Valores
			$items = AutorizacionPago::getInstance()->get_item_ap($id);
			$subtotal = 0;					
			$total = '';		
			while ($info_item = mysqli_fetch_array($items)){
				$subtotal = $subtotal + $info_item['valor'];
			}
				
			if($iva != '0.0')
				$valorIva = $subtotal * ($iva / 100);
				
			if($retencionIva != '0.0')
				$valorRetencionIva = $valorIva * ($retencionIva / 100);
			
			if($retencionFuente != '0.0')
				$valorRetencionFuente = $subtotal * ($retencionFuente / 100);
			
			if($retencionIca != ''){
				$reteica = explode('*', $retencionIca);
				if(count($reteica) == 2){	
					$valor1 = $reteica[0];
					$valor2 = $reteica[1];							
					$valorRetencionIca = ($reteica[0] / $reteica[1]) * $subtotal;
				}
				else
					$valor_reteica = 0;
			}
			
			if($sumarIva == 1)
				$total = ($subtotal + ($valorIva - $valorRetencionIva) - ($valorRetencionFuente + $valorRetencionIca));
			else
				$total = ($subtotal - ($valorRetencionFuente + $valorRetencionIca));
			
			if($subtotal != 0)			
				$subtotal = '$ '.number_format($subtotal,0,',','.');	
			else
				$subtotal = '';				
				
			if($iva != 0)
				$iva = number_format($iva,1,',','.').'%';
			else
				$iva = '';	
				
			if($valorIva != 0)		
				$valorIva = '$ '.number_format($valorIva,0,',','.');				
			else
				$valorIva = '';	
				
			if($retencionIva != 0)	
				$retencionIva = number_format($retencionIva,1,',','.').'%';
			else
				$retencionIva = '';
				
			if($valorRetencionIva != 0)		
				$valorRetencionIva = '$ '.number_format($valorRetencionIva,0,',','.');			
			else	
				$valorRetencionIva = '';
				
			if($retencionFuente != 0)	
				$retencionFuente = number_format($retencionFuente,1,',','.').'%';
			else	
				$retencionFuente = '';
				
			if($valorRetencionFuente != 0)	
				$valorRetencionFuente = '$ '.number_format($valorRetencionFuente,0,',','.');			
			else
				$valorRetencionFuente = '';
				
			if($valorRetencionIca != '' && $valorRetencionIca != 0)	
				$valorRetencionIca = '$ '.number_format($valorRetencionIca,0,',','.');
			else
				$valorRetencionIca = '';
				
			if($total != 0)	 				
				$total = '$ '.number_format($total,0,',','.');
			else 
				$total = '';	
						
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue("A".$fila, $id)
						->setCellValue("B".$fila, $fechaAP)
						->setCellValue("C".$fila, $nombreMunicipio)
						->setCellValue("D".$fila, $identificacionCliente)
						->setCellValue("E".$fila, $nombreCliente)						
						->setCellValue("F".$fila, $banco)
						->setCellValue("G".$fila, $tiposCuenta[$idTipoCuenta])		
						->setCellValue("H".$fila, $numeroCuenta)						
						->setCellValue("I".$fila, $subtotal)										
						->setCellValue("J".$fila, $nombreUsuario)																	
						->setCellValue("K".$fila, $estados[$idEstado]);
		}
		mysqli_free_result($result);				
												
		$objPHPExcel->getActiveSheet()->getStyle('A1:K'.$fila)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('B2:C'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('F2:H'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('I2:I'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('K2:K'.$fila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
													
		// Rename sheet
		$nombre = 'AUTORIZACIONES DE PAGO';
		$objPHPExcel->getActiveSheet()->setTitle($nombre);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		date_default_timezone_set('America/Bogota'); 
		$nombre = "AUTORIZACIONES DE PAGO.xlsx";
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$nombre.'"');
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); 
		exit;		
	}
	else
		header("Location: ../");
?>	