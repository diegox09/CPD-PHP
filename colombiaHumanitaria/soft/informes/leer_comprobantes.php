<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');	
	
	session_start();
	
	require_once('../php/classes/Humanitaria.php');
	require_once('../php/funciones/funciones.php');
			
	if(!array_key_exists('id_hu', $_SESSION)) {
		header('Location: ../');
	}		
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Colombia Humanitaria</title>  
  	<link rel="shortcut icon" href="../img/application_view_gallery.png" type="image/ico" />
  	<link rel="stylesheet" type="text/css" href="../css/index.css" />
</head>
<body> 
	<div id="header">    	
    	<a href="#" id="nombre_user" title=""></a>
        <input type="hidden" id="perfil" name="perfil" value="" />  
    	<a id="salir" href="../php/salir.php" title="Salir de la aplicación">Salir</a>
   		Colombia Humanitaria        
  	</div>
    
    <div id="resumen">
		<?php
            require_once '../php/phpexcel/PHPExcel/IOFactory.php';
			if ($_FILES['userfile']['type'] != "application/vnd.ms-excel")
                    echo "<div class='error'>La extensión del archivo no es correcta, solo se permiten archivos .xls</div>";
                    
			else{				
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'archivos/comprobantes.xls')){ 
					if(file_exists ('archivos/comprobantes.xls') && is_readable ('archivos/comprobantes.xls')){
						$fase = $_POST['fase'];
						$idUser = $_SESSION['id_hu'];
						date_default_timezone_set('America/Bogota'); 
						$fechaActual = date('Y-m-d H:i:s');
											
						$objPHPExcel = PHPExcel_IOFactory::load('archivos/comprobantes.xls');
						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
							$worksheetTitle     = $worksheet->getTitle();	
							$highestRow         = $worksheet->getHighestRow(); // e.g. 10
									   							  
							$errores = array();					
							echo '<div><strong>Fase: '.$fase.'</strong></div>';	
								
							for ($row = 2; $row <= $highestRow; ++ $row) {
								$documentoDamnificado = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
								$comprobante = trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
								$estado = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
								$cheque = trim($worksheet->getCellByColumnAndRow(18, $row)->getValue());	
								
								//Damnificado				
								if($documentoDamnificado != ''){                           
									$result = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);
											
									if(mysqli_num_rows($result) != 0){	
										$damnificado = mysqli_fetch_array($result);									
										$idDamnificado = $damnificado['id_damnificado'];
																		
										$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);
										$arriendo = mysqli_fetch_array($result);
										if($arriendo['comprobante'] != NULL)
											$comprobante = $arriendo['comprobante'];
											
										$consulta = Humanitaria::getInstance()->update_comprobante($idDamnificado, $fase, $comprobante, $cheque, $estado, $fechaActual, $idUser);	
										if(!$consulta){										
											$errores[] = $row;
											echo '<div class="error">Error al modificar el arriendo - Fila: '.$row.'</div>';									
										}
									}																											
								}								
								mysqli_free_result($result);
							}
														
							if(count($errores) > 0){
								echo "<div><strong>Posibles Errores (".count($errores)."), Revisar las Filas:</strong></div>";
								for($i=0; $i < count($errores); $i++)
									echo "<div>Fila: ".$errores[$i].'</div>';
							}                   
						}
						unlink('archivos/comprobantes.xls');	
					}
					else
						echo "<div class='error'><strong>El archivo no existe o no se puede leer: comprobantes.xls</strong></div>";
				}
				else
					echo "<div class='error'>Ocurrió algún error al subir el fichero. No pudo guardarse</div>";
			}	
        ?>
    </div>   
    <div id="espacio"></div>    
    
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2011 - Corprodinco</a>
        	&nbsp;|&nbsp;
        	<a href="http://diegox09.co.cc" target="_blank">Diegox09</a>
            &nbsp;|&nbsp;
        	<a href="../" >Inicio</a>
            &nbsp;|&nbsp;
        	<a href="../resumen.php" >Informes</a>
     	</div>       
    </div>
</body>
</html>
