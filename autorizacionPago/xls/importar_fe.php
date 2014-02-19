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
  	<title>Factura Equivalente</title>  
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
                require_once('../../facturaEquivalente/x09/classes/User.php');
				require_once('../../facturaEquivalente/x09/classes/Factura.php');	
				require_once('../../facturaEquivalente/x09/classes/Cliente.php');	
				require_once('../../facturaEquivalente/x09/classes/Programa.php');
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
							$quitar = array('%' => '', '$' => '', ' ' => '', '.' => '');
							$cambiar = array(',' => '.');
							$iniciales = array('FE' => 1,'CM' => 2);
														                   
                            $objPHPExcel = PHPExcel_IOFactory::load($temp);
                            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                                $worksheetTitle     = $worksheet->getTitle();	
                                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
								
								echo '</br><div><strong>Hoja: '.$worksheetTitle.'</strong></div></br>';
                                if($worksheet->getCellByColumnAndRow(1, 1)->getValue() == 'PROGRAMA' && $worksheet->getCellByColumnAndRow(2, 1)->getValue() == 'TIPO FACTURA' && $worksheet->getCellByColumnAndRow(3, 1)->getValue() == 'MUNICIPIO' && $worksheet->getCellByColumnAndRow(5, 1)->getValue() == 'FECHA' && $worksheet->getCellByColumnAndRow(6, 1)->getValue() == 'NIT/C.C.' && $worksheet->getCellByColumnAndRow(7, 1)->getValue() == 'A FAVOR DE' && $worksheet->getCellByColumnAndRow(9, 1)->getValue() == 'IVA'){ 
								
									$contFE = 0;						
									$contTercero = 0;
									$errores = array();
								                                   
                                    for ($row = 2; $row <= $highestRow; ++ $row) {											
                                        $nombrePrograma = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue())));
                                        $tipoFactura = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                                        $nombreMunicipio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(3, $row)->getValue())));
										
										$consecutivo = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                                        $fecha = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
										
										if($fecha != ''){
											$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha+1);
											$fecha = date("Y-m-d",$timestamp);
										}
										
										$identificacionCliente = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                                        $nombreCliente = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(7, $row)->getValue())));
																			
                                        $iva = strtr(trim($worksheet->getCellByColumnAndRow(9, $row)->getValue()), $quitar);										
                                        $valorIva = strtr(trim($worksheet->getCellByColumnAndRow(10, $row)->getValue()), $quitar);
										$retencionIva = strtr(trim($worksheet->getCellByColumnAndRow(11, $row)->getValue()), $quitar);										
                                        $valorRetencionIva = strtr(trim($worksheet->getCellByColumnAndRow(12, $row)->getValue()), $quitar);
										$retencionFuente = strtr(trim($worksheet->getCellByColumnAndRow(13, $row)->getValue()), $quitar);										
                                        $valorRetencionFuente = strtr(trim($worksheet->getCellByColumnAndRow(14, $row)->getValue()), $quitar);
										$retencionIca = strtr(trim($worksheet->getCellByColumnAndRow(15, $row)->getValue()), $quitar);										
                                        $valorRetencionIca = strtr(trim($worksheet->getCellByColumnAndRow(16, $row)->getValue()), $quitar);
										$estadoFactura = trim($worksheet->getCellByColumnAndRow(17, $row)->getValue());
										
										if($estadoFactura == 1)
											$idEstadoFactura == 1;
										else	
											$idEstadoFactura == 0;
																														
										/*Programa*/
										$idPrograma = 0;
										$idTipoFactura = strtr($tipoFactura,$iniciales);
										if($nombrePrograma != ''){
											$programa = mysqli_fetch_array(Programa::getInstance()->get_programa_by_nombre($nombrePrograma, $idTipoFactura));
											$idPrograma = $programa['idPrograma'];	
										}
                                      											
										/*Cliente*/
										$idCliente = 0;
										if($identificacionCliente != ''){
											$result = Cliente::getInstance()->get_cliente_by_nit($identificacionCliente);
											if(mysqli_num_rows($result) == 0){
												if($nombreCliente != ''){
													$consulta = Cliente::getInstance()->insert_cliente($identificacionCliente, $nombreCliente, '', '');
													if($consulta){
														$contTercero++;
														$result = Cliente::getInstance()->get_cliente_by_nit($identificacionCliente);
													}
													else{
														$errores[] = $row;
														echo "<div class='error'>Error al crear el Tercero - Fila: ".$row."</div>";
													}														
												}
											}
											$cliente = mysqli_fetch_array($result);
											$idCliente = $cliente['idCliente'];											
										}									
													
										/**/								
										if($idPrograma != '' && $idCliente != ''){
											//$verificar = AutorizacionPago::getInstance()->verificar_ap($idPrograma, $idCliente, $fecha, $concepto);
											//if(mysqli_num_rows($verificar) == 0){
												$numero = mysqli_fetch_array(Factura::getInstance()->set_numero($idPrograma));			
												if($numero[0] == NULL)
													$numeroFactura = 1;	
												else			
													$numeroFactura = ++$numero[0];
												
												$consulta = Factura::getInstance()->insert_factura($idPrograma, $numeroFactura, $nombreMunicipio, $fecha, $fechaActual, $idCliente, $idUser, $idEstadoFactura, $iva, $retencionIva, $retencionFuente, $valorRetencionFuente, $retencionIca, $valorIva);												
												if($consulta){
													$contFE++;											
													echo "<div class='insert'>Factura Equivalente creada correctamente - Fila: ".$row." - (".$nombrePrograma.", No. ".$numeroFactura.")</div>";
													$fe = mysqli_fetch_array(Factura::getInstance()->get_id_factura($idPrograma, $numeroFactura));
													$idFactura = $fe['idFactura'];
													if($id == '')
														$id = $idFactura;												
													else	
														$id = $id.','.$idFactura;
													
													if($valorIva != '')
														$iva = 0;
													if($valorRetencionIva != '')
														$retencionIva = 0;
													if($valorRetencionFuente != '')
														$retencionFuente = 0;														
													$valorReteica = explode("*",$valorRetencionIca);	
													if(count($valorReteica) == 2)
														$retencionIca = '';	
															
													/***/
													$j=1;													
													for($i=19;$i<=63;$i+=5){
														$referencia = trim($worksheet->getCellByColumnAndRow($i, $row)->getValue());
														$descripcion = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow($i+1, $row)->getValue())));
														$cantidad = strtr(trim($worksheet->getCellByColumnAndRow($i+2, $row)->getValue()), $quitar);
														$valorUnitario = strtr(trim($worksheet->getCellByColumnAndRow($i+3, $row)->getValue()), $quitar);
														$valorParcial = strtr(trim($worksheet->getCellByColumnAndRow($i+4, $row)->getValue()), $quitar);
														if($cantidad == 'GL')
															$cantidad = -1;
														
														$consulta = Factura::getInstance()->update_item($idFactura, $j, $referencia, $descripcion, $cantidad, $valorUnitario);
														$j++;														
													}
												}
												else{
													$errores[] = $row;
													echo "<div class='error'>Error al crear la Factura Equivalente - Fila: ".$row."</div>";
												}	
											/*}
											else{
												$errores[] = $row;
												echo "<div class='error'>Verificar por que ya existe una Autorizacion de Pago - Fila: ".$row."</div>";
											}*/
										}
										//Fin if($idPrograma != '' && $idResponsable != '' && $idMunicipio != '' && $idCliente != '' && $concepto)
                                    }
									//Fin for
									
									
									
									echo "<br>";
									if($contTercero != 0)
										echo "<div><strong>Se Crearon: ".$contTercero." Terceros</strong></div>";
									if($contFE != 0)	
										echo "<div><strong>Se Crearon: ".$contFE." Facturas Equivalentes</strong></div>";
									
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
                <input type="button" id="deshacer_fe" class="boton_naranja" value="Deshacer" title="Deshacer"/>
                &nbsp;&there4;&nbsp;   
                <input type="button" id="imprimir_fe" class="boton_azul" value="Imprimir" title="Imprimir"/>           
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