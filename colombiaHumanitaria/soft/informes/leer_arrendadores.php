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
           /* if ($_FILES['userfile']['type'] != "application/vnd.ms-excel")
                    echo "<div class='error'>La extensión del archivo no es correcta, solo se permiten archivos .xls</div>";
                    
			else{				
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'archivos/leer.xls')){ */
					if(file_exists ('archivos/leer.xls') && is_readable ('archivos/leer.xls')){
						$fase = 3;
						$idUser = $_SESSION['id_hu'];
						date_default_timezone_set('America/Bogota'); 
						$fechaActual = date('Y-m-d H:i:s');              
							
						$objPHPExcel = PHPExcel_IOFactory::load('archivos/leer.xls');
						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
							$worksheetTitle     = $worksheet->getTitle();	
							$highestRow         = $worksheet->getHighestRow(); // e.g. 10
												
							$contArriendos = 0;							
							$errores = array();
												
							echo '<div><strong>Fase: '.$fase.'</strong></div>';
									
							for ($row = 2; $row <= $highestRow; ++ $row) {				
								
								$documentoDamnificado = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
																
								$nombreArrendador = utf8_decode(trim($worksheet->getCellByColumnAndRow(11, $row)->getValue()));
								$documentoArrendador = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
								$direccionArrendador = utf8_decode(trim($worksheet->getCellByColumnAndRow(13, $row)->getValue()));
								$telefonoArrendador = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());	
									
								$fechaArriendo = explota(trim($worksheet->getCellByColumnAndRow(15, $row)->getValue()));
								$comprobante = trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
								$estadoArriendo = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
								$observacionesArriendo = utf8_decode(trim($worksheet->getCellByColumnAndRow(18, $row)->getValue()));
																																
								//Damnificado				
								if($documentoDamnificado != ''){
									$result = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);
											
									if(mysqli_num_rows($result) != 0){
										$damnificado = mysqli_fetch_array($result);									
										$idDamnificado = $damnificado['id_damnificado'];
										//Arrendador
										if($documentoArrendador != ''){ 
											$resultArrendador = false;                                  
											$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento($documentoArrendador);					                                    
											if(mysqli_num_rows($resultBuscar) == 0){										
												$consulta = Humanitaria::getInstance()->insert_arrendador($documentoArrendador, $fechaActual, $idUser);					
												if($consulta){
													echo '<div class="insert">Arrendador creado correctamente - Fila: '.$row.'</div>';
													$contArrendadores ++;
													$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_documento($documentoArrendador);
												}
												else{
													$errores[] = $row;
													echo '<div class="error">Error al crear el arrendador - Fila: '.$row.'</div>';
												}								
											}
											else{
												$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_documento($documentoArrendador);
											}									
											
											//Arriendo							
											if(mysqli_num_rows($resultArrendador) != 0){
												$arrendador = mysqli_fetch_array($resultArrendador);
												$idArrendador = $arrendador['id_arrendador'];
												$documentoArrendador_bd = $arrendador['documento_arrendador'];
												$nombreArrendador_bd = $arrendador['nombre_arrendador'];
												$telefonoArrendador_bd = $arrendador['telefono_arrendador'];
												$direccionArrendador_bd = $arrendador['direccion_arrendador'];
												
												if($nombreArrendador_bd != '')
													$nombreArrendador = $nombreArrendador_bd;	
												if($telefonoArrendador_bd != ''){
													if($telefonoArrendador_bd != ''){	
														$buscarTelefono = strpos($telefonoArrendador_bd, $telefonoArrendador);													
														if($buscarTelefono === false)
															$telefonoArrendador = $telefonoArrendador_bd.' '.$telefonoArrendador;
													}
													else
														$telefonoArrendador = $telefonoArrendador_bd;
												}
												if($direccionArrendador_bd != '')
													$direccionArrendador = $direccionArrendador_bd;
													
												$consulta = Humanitaria::getInstance()->update_arrendador($idArrendador, $nombreArrendador, $documentoArrendador, $direccionArrendador, $telefonoArrendador, $fechaActual, $idUser);
										
												if(!$consulta){
													$errores[] = $row;
													echo '<div class="error">Error al modificar el arrendador - Fila: '.$row.'</div>';
												}
												 
												$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);
												if(mysqli_num_rows($result) == 0){
													$consulta = Humanitaria::getInstance()->insert_arriendo($idDamnificado, $fase, $fechaActual, $idUser);							
													if($consulta){
														echo '<div class="insert">Se adiciono el arriendo al damnificado - Fila: '.$row.'</div>';
														$contArriendos ++;
														$consulta = Humanitaria::getInstance()->update_arriendo($idDamnificado, $fase, $idArrendador, $comprobante, $fechaArriendo, $estadoArriendo, $observacionesArriendo, $fechaActual, $idUser);
														if(!$consulta){										
															$errores[] = $row;
															echo '<div class="error">Error al modificar el arriendo - Fila: '.$row.'</div>';
														}
													}
													else{
														$errores[] = $row;
														echo '<div class="error">Error al adicionar el arriendo - Fila: '.$row.'</div>';
													}
												}
												else{
													echo '<div>Ya tiene Arriendo creado - Fila: '.$row.'</div>';
												}												
											}										
										}                                                                                
									}	
									else{
										$errores[] = $row;
										echo '<div class="error">Error el numero de documento no esta registrado - Fila: '.$row.'</div>';									
									}																
								}
								
								mysqli_free_result($result);
								mysqli_free_result($resultBuscar);
								mysqli_free_result($resultArrendador);
							}
							
							if($contArriendos != 0)	
                        		echo "<div><strong>Se Adicionaron: ".$contArriendos." Arriendos</strong></div>";
							
							if(count($errores) > 0){
								echo "<div><strong>Posibles Errores (".count($errores)."), Revisar las Filas:</strong></div>";
								for($i=0; $i < count($errores); $i++)
									echo "<div>Fila: ".$errores[$i].'</div>';
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
