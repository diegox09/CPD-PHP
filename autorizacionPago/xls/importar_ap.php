<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');
	
	session_start();
		
	if(!array_key_exists('id_ap', $_SESSION)) {
		header('Location: ../');
	}		
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Autorización de Pago</title>  
  	<link rel="shortcut icon" href="../img/application_view_gallery.png" type="image/ico" /> 
    <link rel="stylesheet" type="text/css" href="../css/tablesorter.min.css" />
  	<link rel="stylesheet" type="text/css" href="../css/index.css" />
  	<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>   
    <script type="text/javascript" src="../js/tablesorter.min.js"></script> 
  	<script type="text/javascript" src="../js/importar.js"></script>
</head>
<body>
	<div id="cargando">
    	<span>Cargando <img src="../img/ajax-loader.gif" />
    </span></div>   
      
	<div id="header">    	
    	<span id="nombre_user" ></span> 
    	<a id="salir" href="#" title="Salir de la aplicación">Salir</a>
  	</div> 
    
    <div id="corprodinco">
        <div style="width:20%">
            <img src="../img/logo.png" height="70" />
        </div>
        <div style="width:80%">
            Corporación de Profesionales<br>
            para el Desarrollo Integral Comunitario<br> 
        </div>
    </div>	
    
    <div id="info" style="background:#f5f5f5">    	
    	<div class="info">
			<?php
                require_once('../php/classes/AutorizacionPago.php');
                require_once('../php/funciones/funciones.php');
                require_once '../../php/phpexcel/PHPExcel/IOFactory.php';	
				
				$idUser = $_SESSION['id_ap'];
				date_default_timezone_set('America/Bogota'); 
				$fechaActual = date('Y-m-d H:i:s');	
				$id = '';
                
                if (($_FILES['userfile']['type'] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") && ($_FILES['userfile']['type'] != "application/vnd.ms-excel"))
                	echo "<div class='error'>La extensión del archivo no es correcta, solo se permiten archivos .xls</div>";
									                    
                else{	
					$temp = basename($_FILES['userfile']['name']);			
                    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $temp)){
                        if(file_exists ($temp) && is_readable ($temp)){																		
							$tipoPagos = array('' => 0, 'CHEQUE' => 1, 'TRANSFERENCIA' => 2);
							$sumaIva = array('' => 0, 'SI' => 1);
							$quitar = array('%' => '', '$' => '', ' ' => '', '.' => '');
							$cambiar = array(',' => '.');
																			                   
                            $objPHPExcel = PHPExcel_IOFactory::load("AUTORIZACIONES DE PAGO.xlsx");
                            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
								
                                $worksheetTitle     = $worksheet->getTitle();	
                                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
								
								echo '</br><div><strong>Hoja: '.$worksheetTitle.'</strong></div></br>';
                                if($worksheet->getCellByColumnAndRow(1, 1)->getValue() == 'PROGRAMA' && $worksheet->getCellByColumnAndRow(2, 1)->getValue() == 'SOLICITADO POR' && $worksheet->getCellByColumnAndRow(3, 1)->getValue() == 'MUNICIPIO' && $worksheet->getCellByColumnAndRow(5, 1)->getValue() == 'FECHA' && $worksheet->getCellByColumnAndRow(6, 1)->getValue() == 'NIT/C.C.' && $worksheet->getCellByColumnAndRow(7, 1)->getValue() == 'A FAVOR DE' && $worksheet->getCellByColumnAndRow(8, 1)->getValue() == 'CONCEPTO' && $worksheet->getCellByColumnAndRow(13, 1)->getValue() == 'IVA'){ 
								
									$contAP = 0;						
									$contTercero = 0;
									$errores = array();
									echo "1....";
								                                   
                                    for ($row = 2; $row <= $highestRow; ++ $row) {											
                                        $nombrePrograma = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue())));
                                        $nombreResponsable = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getValue())));
                                        $nombreMunicipio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(3, $row)->getValue())));
										
										$consecutivo = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                                        $fecha = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
										
										if($fecha != ''){
											$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha+1);
											$fecha = date("Y-m-d",$timestamp);
										}
										
										$identificacionCliente = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                                        $nombreCliente = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(7, $row)->getValue())));
										
										$concepto = utf8_decode(trim($worksheet->getCellByColumnAndRow(8, $row)->getValue()));
										$cuenta = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                                        $tipoPago = $tipoPagos[trim($worksheet->getCellByColumnAndRow(11, $row)->getValue())];
										
                                        $iva = strtr(trim($worksheet->getCellByColumnAndRow(13, $row)->getValue()), $quitar);										
                                        $valorIva = strtr(trim($worksheet->getCellByColumnAndRow(14, $row)->getValue()), $quitar);
										$retencionIva = strtr(trim($worksheet->getCellByColumnAndRow(15, $row)->getValue()), $quitar);										
                                        $valorRetencionIva = strtr(trim($worksheet->getCellByColumnAndRow(16, $row)->getValue()), $quitar);
										$retencionFuente = strtr(trim($worksheet->getCellByColumnAndRow(17, $row)->getValue()), $quitar);										
                                        $valorRetencionFuente = strtr(trim($worksheet->getCellByColumnAndRow(18, $row)->getValue()), $quitar);
										$retencionIca = strtr(trim($worksheet->getCellByColumnAndRow(19, $row)->getValue()), $quitar);										
                                        $valorRetencionIca = strtr(trim($worksheet->getCellByColumnAndRow(20, $row)->getValue()), $quitar);
										$sumarIva = $sumaIva[trim($worksheet->getCellByColumnAndRow(21, $row)->getValue())];
																														
										/*Programa*/
										$idPrograma = 0;
										if($nombrePrograma != ''){
											$programa = mysqli_fetch_array(AutorizacionPago::getInstance()->get_programa_by_nombre($nombrePrograma));
											$idPrograma = $programa['idPrograma'];	
										}
                                        										
										/*Responsable*/
										$idResponsable = 0;
										if($nombreResponsable != ''){
											$responsable = mysqli_fetch_array(AutorizacionPago::getInstance()->get_responsable_by_nombre($nombreResponsable));
											$idResponsable = $responsable['idPersona'];	
										}
										
										/*Municipio*/
										$idMunicipio = 0;
										if($nombreMunicipio != ''){
											$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_nombre($nombreMunicipio));
											$idMunicipio = $municipio['idMunicipio'];	
										}
										
										/*Cliente*/
										$idCliente = 0;
										if($identificacionCliente != ''){
											$documento = explode('-', $identificacionCliente);	
											$identificacion = strtr($documento[0],$quitar);
											$dv = $documento[1];
											$result = AutorizacionPago::getInstance()->get_persona_by_identificacion($identificacion);
											if(mysqli_num_rows($result) == 0){
												if($nombreCliente != ''){
													$consulta = AutorizacionPago::getInstance()->insert_persona($identificacion, $dv, $nombreCliente, '', '', '', 0, '');
													if($consulta){
														$contTercero++;
														$result = AutorizacionPago::getInstance()->get_persona_by_identificacion($identificacion);
													}
													else{
														$errores[] = $row;
														echo "<div class='error'>Error al crear el Tercero - Fila: ".$row."</div>";
													}														
												}
											}
											$cliente = mysqli_fetch_array($result);
											$idCliente = $cliente['idPersona'];											
										}									
													
										
										echo $idPrograma;
										/**/								
										if($idPrograma != '' && $idResponsable != '' && $idMunicipio != '' && $idCliente != '' && $concepto != ''){
											$verificar = AutorizacionPago::getInstance()->verificar_ap($idPrograma, $idCliente, $fecha, $concepto);
											if(mysqli_num_rows($verificar) == 0){
												if($consecutivo == ''){
													$ap = mysqli_fetch_array(AutorizacionPago::getInstance()->get_numero_ap($idPrograma));			
													if($ap[0] == NULL)
														$consecutivo = 1;	
													else			
														$consecutivo = ++$ap[0];
												}
													
												$consulta = AutorizacionPago::getInstance()->insert_ap($idPrograma, $consecutivo, $fecha, $idResponsable, $idCliente, $idMunicipio, $concepto, $tipoPago, $idUser, $idUser, $fechaActual, $cuenta);
												
												if($consulta){
													$contAP++;											
													echo "<div class='insert'>Autorizacion de Pago creada correctamente - Fila: ".$row." - (".$nombrePrograma.", No. ".$consecutivo.")</div>";
													$ap = mysqli_fetch_array(AutorizacionPago::getInstance()->get_id_ap($idPrograma, $consecutivo));
													$idAutorizacionPago = $ap['idAutorizacionPago'];
													if($id == '')
														$id = $idAutorizacionPago;												
													else	
														$id = $id.','.$idAutorizacionPago;
													
													if($valorIva != '')
														$iva = 0;
													if($valorRetencionIva != '')
														$retencionIva = 0;
													if($valorRetencionFuente != '')
														$retencionFuente = 0;														
													$valorReteica = explode("*",$valorRetencionIca);	
													if(count($valorReteica) == 2)
														$retencionIca = '';	
															
													$consulta = AutorizacionPago::getInstance()->update_retenciones_ap($idAutorizacionPago, $iva, $valorIva, $retencionIva, $valorRetencionIva, $retencionFuente, $valorRetencionFuente, $retencionIca, $valorRetencionIca, $sumarIva, $idUser, $fechaActual);								
													/***/													
													for($i=23;$i<=62;$i+=5){
														$numeroPago = trim($worksheet->getCellByColumnAndRow($i, $row)->getValue());
														$comprobanteEgreso = trim($worksheet->getCellByColumnAndRow($i+1, $row)->getValue());
														$descripcion = trim($worksheet->getCellByColumnAndRow($i+2, $row)->getValue());
														$centroCosto = trim($worksheet->getCellByColumnAndRow($i+3, $row)->getValue());
														$valor = strtr(trim($worksheet->getCellByColumnAndRow($i+4, $row)->getValue()), $quitar);
														
														if($descripcion != '' && $valor != ''){	
															$item_ap = mysqli_fetch_array(AutorizacionPago::getInstance()->get_numero_item_ap($idAutorizacionPago));			
															if($item_ap[0] == NULL)
																$item = 1;	
															else			
																$item = ++$item_ap[0];									
															
															$consulta = AutorizacionPago::getInstance()->insert_item_ap($idAutorizacionPago, $item, $numeroPago, $comprobanteEgreso, $descripcion, $centroCosto, $valor);					
														}
													}
												}
												else{
													$errores[] = $row;
													echo "<div class='error'>Error al crear la Autorizacion de Pago - Fila: ".$row."</div>";
												}	
											}
											else{
												$errores[] = $row;
												echo "<div class='error'>Verificar por que ya existe una Autorizacion de Pago - Fila: ".$row."</div>";
											}
										}
										//Fin if($idPrograma != '' && $idResponsable != '' && $idMunicipio != '' && $idCliente != '' && $concepto)
                                    }
									//Fin for
									
									echo "<br>";
									if($contTercero != 0)
										echo "<div><strong>Se Crearon: ".$contTercero." Terceros</strong></div>";
									if($contAP != 0)	
										echo "<div><strong>Se Crearon: ".$contAP." Autorizaciones de Pago</strong></div>";
									
									if(count($errores) > 0){
										echo "<br>";
										echo "<div><strong>Posibles Errores (".count($errores)."), Revisar las Filas:</strong></div>";
										for($i=0; $i < count($errores); $i++)
											echo "<div>Fila: ".$errores[$i].'</div>';
									}
                                }
                                else
                                    echo "<div class='error'>El nombre de los campos es Incorrecto</div>";
                            }	
							unlink($temp);							
                        }
						else
							echo "<div class='error'>El archivo no existe o no se puede leer</div>";
                    }
                    else
                        echo "<div class='error'>Ocurrió algún error al subir el fichero. No pudo guardarse</div>";
                } 
				
				echo '<input type="hidden" id="lista" value="'.$id.'"/>';				          
            ?>         
            <table id="tabla" cellspacing="1" class="tablesorter" ></table>
            <div id="botones">
             	<input type="button" id="regresar" class="boton_gris" value="Regresar" title="Regresar"/>
                &nbsp;&there4;&nbsp;
                <input type="button" id="deshacer_ap" class="boton_naranja" value="Deshacer" title="Deshacer"/>
                &nbsp;&there4;&nbsp;   
                <input type="button" id="imprimir_ap" class="boton_azul" value="Imprimir" title="Imprimir"/>           
          	</div>      
    	</div>
    </div> 
    
    <div class="espacio"></div>    
              
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
            &nbsp;|&nbsp;       	
        	<a href="../../">SGC</a>
            &nbsp;|&nbsp;            
        	<a href="../contenido.php">Inicio</a>
            &nbsp;|&nbsp;            
        	<a href="../administracion.php">Administracion</a>
     	</div>       
    </div>
    
    <div id="error"></div> 
</body>
</html>