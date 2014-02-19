<?php
header("Content-Type: text/html; charset=UTF-8");
require_once 'Classes/PHPExcel/IOFactory.php';

require_once('../classes/Factura.php');

$objPHPExcel = PHPExcel_IOFactory::load('archivos/cambiar.xls');
setlocale(LC_CTYPE, 'es');

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	$worksheetTitle     = $worksheet->getTitle();	
	$highestRow         = $worksheet->getHighestRow(); // e.g. 10
	
	$idPrograma = 5;
				
	for ($row = 1; $row <= $highestRow; ++ $row) {
		$numeroFactura = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
		$numeroNuevo = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		
		$result = Factura::getInstance()->get_id_factura($idPrograma, $numeroFactura);			
		if(mysqli_num_rows($result) > 0){	
			$factura = mysqli_fetch_array($result);	
			$idFactura = $factura['idFactura'];	
			
			$consulta = Factura::getInstance()->update_numero_factura($idFactura, $numeroNuevo);
			if(!$consulta)
				echo '<strong>Error al cambiar el numero - Fila: '.$row.'</strong><br>';					
			else	
				echo 'Ok - Fila: '.$row.'<br>';
		}
		else
			echo 'Error el numero no existe - Fila: '.$row.'<br>';	
	}
}
?>