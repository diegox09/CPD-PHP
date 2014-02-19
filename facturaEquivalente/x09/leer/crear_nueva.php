<?php
header("Content-Type: text/html; charset=UTF-8");
require_once 'Classes/PHPExcel/IOFactory.php';

require_once('../classes/Factura.php');

$objPHPExcel = PHPExcel_IOFactory::load('archivos/nuevo.xls');
setlocale(LC_CTYPE, 'es');

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	$worksheetTitle     = $worksheet->getTitle();	
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	
	$idPrograma = 5;
	date_default_timezone_set('America/Bogota'); 
	$fechaActual = date('Y-m-d H:i:s');
	$ciudad = 'BARRANCABERMEJA';
				
	for ($row = 1; $row <= $highestRow; ++ $row) {		
		$numeroFactura = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
		$fecha = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
		
		if($numeroFactura != ''){
			$result = Factura::getInstance()->get_id_factura($idPrograma, $numeroFactura);			
			if(mysqli_num_rows($result) == 0){	
				$consulta = Factura::getInstance()->insert_factura($idPrograma, $numeroFactura, $ciudad, $fecha, $fechaActual, '', 1, 1, '', '', '', '', '');			
				
				$result = Factura::getInstance()->get_id_factura($idPrograma, $numeroFactura);			
				if(mysqli_num_rows($result) > 0){	
					$factura = mysqli_fetch_array($result);	
					$idFactura = $factura['idFactura'];				
					
					$error = false;
					for($i=1; $i<10; $i++){
						$referencia = '';
						$descripcion = '';
						$cantidad = '';	
						$valor = '';	
						$consulta = Factura::getInstance()->insert_item($idFactura, $i, $referencia, $descripcion, $cantidad, $valor);
						if(!$consulta)
							$error = true;
					}
					if($error)
						echo 'Error al crear el item - Fila: '.$row.'<br>';	
					else
						echo 'Ok - Fila: '.$row.'<br>';		
				}
				else
					echo 'Error al crear la factura - Fila: '.$row.'<br>';	
			}
			else
				echo 'Error el numero de factura ya existe - Fila: '.$row.'<br>';	
		}
	}
}
?>