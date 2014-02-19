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
				if(move_uploaded_file($_FILES['userfile']['tmp_name'], 'archivos/leer.xls')){            
					if(file_exists ('archivos/leer.xls') && is_readable ('archivos/leer.xls')){
						$fase = $_POST['fase'];
						$idUser = $_SESSION['id_hu'];
						date_default_timezone_set('America/Bogota'); 
						$fechaActual = date('Y-m-d H:i:s');
											
						$objPHPExcel = PHPExcel_IOFactory::load('archivos/leer.xls');
						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
							$worksheetTitle     = $worksheet->getTitle();	
							$highestRow         = $worksheet->getHighestRow(); // e.g. 10
							
							$contDamnificados = 0;	
							$contArrendadores = 0;
							$contArriendos = 0;
							$contEntregas = 0;
							$contReparaciones = 0;
							$fraudes = array();
							$errores = array();                                        
							echo '<div><strong>Fase: '.$fase.'</strong></div>';	
								
							for ($row = 2; $row <= $highestRow; ++ $row) {				
								$primerNombre = utf8_decode(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue()));
								$segundoNombre = utf8_decode(trim($worksheet->getCellByColumnAndRow(2, $row)->getValue()));
								$primerApellido = utf8_decode(trim($worksheet->getCellByColumnAndRow(3, $row)->getValue()));
								$segundoApellido = utf8_decode(trim($worksheet->getCellByColumnAndRow(4, $row)->getValue()));				
								$genero = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
								switch($genero){
									case "M":	$genero = 1;
												break;
									case "F": 	$genero = 2;
												break;
									default:$genero = "";
											break;		
								}
								$td = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
								switch($td){
									case "CC":	$td = 1;
												break;
									case "TI":	$td = 2;
												break;
									default:$td = "";
											break;		
								}
								$documentoDamnificado = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
								$direccionDamnificado = utf8_decode(trim($worksheet->getCellByColumnAndRow(8, $row)->getValue()));
								$barrioDamnificado = utf8_decode(trim($worksheet->getCellByColumnAndRow(9, $row)->getValue()));
								$telefonoDamnificado = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
								
								$nombreArrendador = utf8_decode(trim($worksheet->getCellByColumnAndRow(11, $row)->getValue()));
								$documentoArrendador = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
								$direccionArrendador = utf8_decode(trim($worksheet->getCellByColumnAndRow(13, $row)->getValue()));
								$telefonoArrendador = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());	
									
								$fechaArriendo = explota(trim($worksheet->getCellByColumnAndRow(15, $row)->getValue()));
								$comprobante = trim($worksheet->getCellByColumnAndRow(16, $row)->getValue());
								$estadoArriendo = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
								$observacionesArriendo = utf8_decode(trim($worksheet->getCellByColumnAndRow(18, $row)->getValue()));
								
								$fechaMercado1 = explota(trim($worksheet->getCellByColumnAndRow(19, $row)->getValue()));
								$fechaMercado2 = explota(trim($worksheet->getCellByColumnAndRow(20, $row)->getValue()));
								$fechaMercado3 = explota(trim($worksheet->getCellByColumnAndRow(21, $row)->getValue()));
								$fechaMercado4 = explota(trim($worksheet->getCellByColumnAndRow(22, $row)->getValue()));
								$fechaKitAseo = explota(trim($worksheet->getCellByColumnAndRow(23, $row)->getValue()));
								$fichoEntregas = trim($worksheet->getCellByColumnAndRow(24, $row)->getValue());		
								$estadoEntregas = trim($worksheet->getCellByColumnAndRow(25, $row)->getValue());
								$observacionesEntregas = utf8_decode(trim($worksheet->getCellByColumnAndRow(26, $row)->getValue()));
								
								$fechaReparacion = explota(trim($worksheet->getCellByColumnAndRow(27, $row)->getValue()));
								$comprobanteReparacion = trim($worksheet->getCellByColumnAndRow(28, $row)->getValue());
								$estadoReparacion = trim($worksheet->getCellByColumnAndRow(29, $row)->getValue());
								$observacionesReparacion = utf8_decode(trim($worksheet->getCellByColumnAndRow(30, $row)->getValue()));
								
								$confirmacion = utf8_decode(trim($worksheet->getCellByColumnAndRow(31, $row)->getValue()));					
									
								//Damnificado				
								if($documentoDamnificado != ''){
									$result = false;
									$resultBuscar = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);
									if(mysqli_num_rows($resultBuscar) == 0){
										$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);						
										if(mysqli_num_rows($resultArrendador) == 0){
											if($primerNombre != '' && $primerApellido != ''){
												$consulta = Humanitaria::getInstance()->insert_damnificado($documentoDamnificado, $fechaActual, $idUser);							
												if($consulta){
													echo '<div class="insert">Damnificado creado correctamente - Fila: '.$row.'</div>';
													$contDamnificados ++;
													$result = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);
												}
												else{
													$errores[] = $row;
													echo '<div class="error">Error al crear el damnificado - Fila: '.$row.'</div>';										
												}
											}
											else{
												$errores[] = $row;
												echo '<div class="error">Error al crear el damnificado, falta el primer nombre y el primer apellido - Fila: '.$row.'</div>';										
											}
											
										}
										else{
											$fraudes[] = $row;
											echo '<div class="fraude">El damnificado aparece como arrendador - Fila: '.$row.'</div>';
										}																								
									}
									else{
										//echo '<div>Damnificado ya existe - Fila: '.$row.'</div>';
										$result = Humanitaria::getInstance()->get_damnificado_by_documento($documentoDamnificado);
									}
											
									if(mysqli_num_rows($result) != 0){				
										$damnificado = mysqli_fetch_array($result);									
										$idDamnificado = $damnificado['id_damnificado'];
										$primerNombre_bd = $damnificado['primer_nombre'];
										$segundoNombre_bd = $damnificado['segundo_nombre'];
										$primerApellido_bd = $damnificado['primer_apellido'];
										$segundoApellido_bd = $damnificado['segundo_apellido'];
										$genero_bd = $damnificado['genero'];
										$td_bd = $damnificado['td'];
										$documentoDamnificado_bd = $damnificado['documento_damnificado'];				
										$telefonoDamnificado_bd = $damnificado['telefono'];
										$direccionDamnificado_bd = $damnificado['direccion'];
										$barrioDamnificado_bd = $damnificado['barrio'];		
										$confirmacion_bd = $damnificado['observaciones'];
										
										if($primerNombre_bd != '')
											$primerNombre = $primerNombre_bd;							
										if($segundoNombre_bd != '')
											$segundoNombre = $segundoNombre_bd;						
										if($primerApellido_bd != '')
											$primerApellido = $primerApellido_bd;						
										if($segundoApellido_bd != '')
											$segundoApellido = $segundoApellido_bd;							
										if($genero_bd != '0')
											$genero = $genero_bd;							
										if($td_bd != '0')
											$td = $td_bd;		
										if($telefonoDamnificado_bd != ''){
											if($telefonoDamnificado != ''){	
												$buscarTelefono = strpos($telefonoDamnificado_bd, $telefonoDamnificado);													
												if($buscarTelefono === false)
													$telefonoDamnificado = $telefonoDamnificado_bd.' '.$telefonoDamnificado;
											}
											else
												$telefonoDamnificado = $telefonoDamnificado_bd;
										}
										if($direccionDamnificado_bd != '')
											$direccionDamnificado = $direccionDamnificado_bd;
										if($barrioDamnificado_bd != '')
											$barrioDamnificado = $barrioDamnificado_bd;
													
										$consulta = Humanitaria::getInstance()->update_damnificado($idDamnificado, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $genero, $td, $documentoDamnificado, $direccionDamnificado, $barrioDamnificado, $telefonoDamnificado, $confirmacion, $fechaActual, $idUser);
										
										if(!$consulta){
											$errores[] = $row;
											echo '<div class="error">Error al modificar el damnificado - Fila: '.$row.'</div>';										
										}
										
										//Entregas				
										if(mysqli_num_rows($resultArrendador) == 0){
											$result = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
											if(mysqli_num_rows($result) == 0){
												if($fechaKitAseo != '-' || $fechaMercado1 != '-' || $fechaMercado2 != '-' || $fechaMercado3 != '-' || $fechaMercado4 != '-'){
													$consulta = Humanitaria::getInstance()->insert_entregas($idDamnificado, $fase, $fechaActual, $idUser);							
													if($consulta){
														echo '<div class="insert">Se adicionaron las entregas al damnificado - Fila: '.$row.'</div>';
														$contEntregas ++;
														$consulta = Humanitaria::getInstance()->update_entregas($idDamnificado, $fase, $fichoEntregas, $fechaKitAseo, $fechaMercado1, $fechaMercado2, $fechaMercado3, $fechaMercado4, $estadoEntregas, $observacionesEntregas, $fechaActual, $idUser);
														if(!$consulta){										
															$errores[] = $row;
															echo '<div class="error">Error al modificar las entregas - Fila: '.$row.'</div>';
														}
													}
													else{
														$errores[] = $row;	
														echo '<div class="error">Error al adicionar las entregas - Fila: '.$row.'</div>';
													}
												}
											}
											else{			
												$entregas = mysqli_fetch_array($result);									
												if($entregas['fecha_kit_aseo'] != '0000-00-00')
													$fechaKitAseo = $entregas['fecha_kit_aseo'];							
												if($entregas['fecha_mercado1'] != '0000-00-00')
													$fechaMercado1 = $entregas['fecha_mercado1'];							
												if($entregas['fecha_mercado2'] != '0000-00-00')
													$fechaMercado2 = $entregas['fecha_mercado2'];							
												if($entregas['fecha_mercado3'] != '0000-00-00')
													$fechaMercado3 = $entregas['fecha_mercado3'];							
												if($entregas['fecha_mercado4'] != '0000-00-00')
													$fechaMercado4 = $entregas['fecha_mercado4'];
												if($entregas['ficho'] != NULL)
														$ficho = $entregas['ficho'];		
												
												$consulta = Humanitaria::getInstance()->update_entregas($idDamnificado, $fase, $ficho, $fechaKitAseo, $fechaMercado1, $fechaMercado2, $fechaMercado3, $fechaMercado4, $estadoEntregas, $observacionesEntregas, $fechaActual, $idUser);
												if(!$consulta){										
													$errores[] = $row;
													echo '<div class="error">Error al modificar las entregas - Fila: '.$row.'</div>';									
												}
											}								
										}
										else{
											$fraudes[] = $row;
											echo '<div class="fraude">El damnificado aparece como arrendador - Fila: '.$row.'</div>';
										}
										
										//Reparacion	
										if(mysqli_num_rows($resultArrendador) == 0){
											$result = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);
											if(mysqli_num_rows($result) == 0){
												$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);							
												if(mysqli_num_rows($result) == 0){
													if($fechaReparacion != '-'){		
														$consulta = Humanitaria::getInstance()->insert_reparacion($idDamnificado, $fase, $fechaActual, $idUser);							
														if($consulta){
															echo '<div class="insert">Se adiciono la reparacion de vivienda al damnificado - Fila: '.$row.'</div>';
															$contReparaciones ++;
															$consulta = Humanitaria::getInstance()->update_reparacion($idDamnificado, $fase, $comprobanteReparacion, $fechaReparacion, $estadoReparacion, $observacionesReparacion, $fechaActual, $idUser);
															if(!$consulta){										
																$errores[] = $row;
																echo '<div class="error">Error al modificar la reparacion de vivienda - Fila: '.$row.'</div>';
															}
														}
														else{
															$errores[] = $row;	
															echo '<div class="error">Error al adicionar la reparacion de vivienda - Fila: '.$row.'</div>';
														}
													}
												}
												else{
													$errores[] = $row;	
													echo '<div class="error">Error al adicionar la reparacion de vivienda, el damnificado tiene arriendo en esta fase - Fila: '.$row.'</div>';
												}
											}
											else{			
												$reparacion = mysqli_fetch_array($result);									
												if($reparacion['fecha_reparacion'] != '0000-00-00')
													$fechaReparacion = $reparacion['fecha_reparacion'];
												if($reparacion['comprobante'] != NULL)
													  $comprobanteReparacion = $reparacion['comprobante'];	
																							
												$consulta = Humanitaria::getInstance()->update_reparacion($idDamnificado, $fase, $comprobanteReparacion, $fechaReparacion, $estadoReparacion, $observacionesReparacion, $fechaActual, $idUser);
												if(!$consulta){										
													$errores[] = $row;
													echo '<div class="error">Error al modificar la reparacion de vivienda - Fila: '.$row.'</div>';									
												}
											}								
										}
										else{
											$fraudes[] = $row;
											echo '<div class="fraude">El damnificado aparece como arrendador - Fila: '.$row.'</div>';
										} 
										
										//Arrendador
										if($documentoArrendador != ''){ 
											$resultArrendador = false;                                  
											$resultBuscar = Humanitaria::getInstance()->get_arrendador_by_documento($documentoArrendador);					                                    
											if(mysqli_num_rows($resultBuscar) == 0){
												$resultEntregas = Humanitaria::getInstance()->get_entregas_damnificado_by_documento_arrendador($documentoArrendador, $fase);
												$resultArriendo = Humanitaria::getInstance()->get_arriendo_damnificado_by_documento_arrendador($documentoArrendador, $fase);								
												if(mysqli_num_rows($resultEntregas) == 0 && mysqli_num_rows($resultArriendo) == 0){
													if($nombreArrendador != ''){
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
														$errores[] = $row;
														echo '<div class="error">Error al crear el arrendador, falta el nombre - Fila: '.$row.'</div>';
													}
												}
												else{
													$fraudes[] = $row;
													echo '<div class="fraude">El arrendador aparece como damnificado - Fila: '.$row.'</div>';									
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
													
												if(mysqli_num_rows($resultEntregas) == 0 && mysqli_num_rows($resultArriendo) == 0){	
													$result = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);
													if(mysqli_num_rows($result) == 0){
														$result = Humanitaria::getInstance()->get_arrendador_by_documento_damnificado($documentoDamnificado, $fase);
														if(mysqli_num_rows($result) == 0){
															$result = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);							
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
																$errores[] = $row;
																echo '<div class="error">Error al adicionar el arriendo, el damnificado tiene reparacion de vivienda en esta fase - Fila: '.$row.'</div>';
															}
														}
														else{
															$errores[] = $row;
															echo '<div class="error">Error al adicionar el arriendo, el damnificado aparece como arrendador en esta fase - Fila: '.$row.'</div>';
														}
													}
													else{			
														$arriendo = mysqli_fetch_array($result);									
														if($arriendo['comprobante'] != NULL)
															$comprobante = $arriendo['comprobante'];
														if($arriendo['fecha_arriendo'] != '0000-00-00')	
															$fechaArriendo = $arriendo['fecha_arriendo'];
														
														$consulta = Humanitaria::getInstance()->update_arriendo($idDamnificado, $fase, $idArrendador, $comprobante, $fechaArriendo, $estadoArriendo, $observacionesArriendo, $fechaActual, $idUser);	
														if(!$consulta){										
															$errores[] = $row;
															echo '<div class="error">Error al modificar el arriendo - Fila: '.$row.'</div>';									
														}
													}
												}
												else{
													$fraudes[] = $row;
													echo '<div class="fraude">El arrendador aparece como damnificado - Fila: '.$row.'</div>';									
												}							
											}
										}                                                                           
									}																	
								}
								
								mysqli_free_result($result);
								mysqli_free_result($resultBuscar);
								mysqli_free_result($resultEntregas);
								mysqli_free_result($resultArriendo);
								mysqli_free_result($resultArrendador);
							}
							
							if($contDamnificados != 0)
								echo "<div><strong>Se Crearon: ".$contDamnificados." Damnificados</strong></div>";
							if($contArrendadores != 0)	
								echo "<div><strong>Se Crearon: ".$contArrendadores." Arrendadores</strong></div>";
							if($contArriendos != 0)	
								echo "<div><strong>Se Adicionaron: ".$contArriendos." Arriendos</strong></div>";	
							if($contEntregas != 0)	
								echo "<div><strong>Se Adicionaron: ".$contEntregas." Entregas</strong></div>";		
							
							if(count($fraudes) > 0){
								echo "<div><strong>Posibles Fraudes (".count($fraudes)."), Revisar las Filas:</strong></div>";
								for($i=0; $i < count($fraudes); $i++)
									echo "<div>Fila: ".$fraudes[$i].'</div>';
							}
							
							if(count($errores) > 0){
								echo "<div><strong>Posibles Errores (".count($errores)."), Revisar las Filas:</strong></div>";
								for($i=0; $i < count($errores); $i++)
									echo "<div>Fila: ".$errores[$i].'</div>';
							}                   
						}
						unlink('archivos/leer.xls');		
					}
					else
						echo "<div class='error'><strong>El archivo no existe o no se puede leer: leer.xls</strong></div>";
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
