<?php
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
           /* if ($_FILES['userfile']['type'] != "application/vnd.ms-excel")
                    echo "<div class='error'>La extensión del archivo no es correcta, solo se permiten archivos .xls</div>";
                    
			else{				
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'archivos/leer.xls')){ */
					if(file_exists ('archivos/leer.xls') && is_readable ('archivos/leer.xls')){
							
						$objPHPExcel = PHPExcel_IOFactory::load('archivos/leer.xls');
						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
							$worksheetTitle     = $worksheet->getTitle();	
							$highestRow         = $worksheet->getHighestRow(); // e.g. 10
																
							for ($row = 2; $row <= $highestRow; ++ $row) {					
								$id = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
								echo $id.',';
							}             
						}	
					//	unlink('archivos/leer.xls');		
					}
					/*else
						echo "<div class='error'><strong>El archivo no existe o no se puede leer: leer.xls</strong></div>";
				}
				else
                	echo "<div class='error'>Ocurrió algún error al subir el fichero. No pudo guardarse</div>";
			}*/
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
