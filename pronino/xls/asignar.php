<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');
	
	session_start();
		
	if(!array_key_exists('id_pn', $_SESSION)) {
		header('Location: ../');
	}		
?>	
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  	<meta name="author" content="Diego Fernando Rodriguez Rincon">	
  	<title>Proniño</title>  
  	<link rel="shortcut icon" href="../img/application_view_gallery.png" type="image/ico" />  
  	<link rel="stylesheet" type="text/css" href="../css/index.css" />
  	<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script> 
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
                require_once('../php/classes/Pronino.php');
                require_once('../php/funciones/funciones.php');
                require_once '../../php/phpexcel/PHPExcel/IOFactory.php';	
				
				$year = $_POST['year'];
				$idUser = $_SESSION['id_pn'];
				date_default_timezone_set('America/Bogota'); 
				$fechaActual = date('Y-m-d H:i:s');
				$temp = 'temp'.date('His').'.xls';	
                
                if ($_FILES['userfile']['type'] != "application/vnd.ms-excel")
                    echo "<div class='error'>La extensión del archivo no es correcta, solo se permiten archivos .xls</div>";
									                    
                else{				
                    if(move_uploaded_file($_FILES['userfile']['tmp_name'], $temp)){
                        if(file_exists ($temp) && is_readable ($temp)){
                            $objPHPExcel = PHPExcel_IOFactory::load($temp);
                            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                                $worksheetTitle     = $worksheet->getTitle();	
                                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                                if($worksheet->getCellByColumnAndRow(1, 2)->getValue() == 'NOMBRES' && $worksheet->getCellByColumnAndRow(2, 2)->getValue() == 'APELLIDOS' && $worksheet->getCellByColumnAndRow(7, 2)->getValue() == 'NUMERO DOCUMENTO' && $worksheet->getCellByColumnAndRow(15, 2)->getValue() == 'DEPARTAMENTO' && $worksheet->getCellByColumnAndRow(29, 2)->getValue() == 'PROFESIONAL' && $worksheet->getCellByColumnAndRow(30, 2)->getValue() == 'COORDINADOR' && $worksheet->getCellByColumnAndRow(33, 2)->getValue() == 'COLEGIO'){ 
									
									$errores = array();
								                                   
                                    for ($row = 3; $row <= $highestRow; ++ $row) {	
										/*Informacion del Beneficiario*/			
                                        $item = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                                        $documentoBeneficiario = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                                       
										$nombreUsuario1 = utf8_decode(trim($worksheet->getCellByColumnAndRow(29, $row)->getValue()));
										$nombreUsuario2 = utf8_decode(trim($worksheet->getCellByColumnAndRow(30, $row)->getValue()));
										/*Usuarios*/
										$idUsuario1 = 0;
										$idUsuario2 = 0;
										if($nombreUsuario1 != ''){
											$result = Pronino::getInstance()->get_user_by_nombre($nombreUsuario1);
											$usuario = mysqli_fetch_array($result);	
											if($usuario['tipoUser'] == 1)			
												$idUsuario1 = $usuario['idUser'];	
										}
										if($nombreUsuario2 != ''){
											$result = Pronino::getInstance()->get_user_by_nombre($nombreUsuario2);
											$usuario = mysqli_fetch_array($result);	
											if($usuario['tipoUser'] == 2)				
												$idUsuario2 = $usuario['idUser'];	
										}                                         
										           									
										if($documentoBeneficiario != ''){
											$result = Pronino::getInstance()->get_beneficiario_by_documento($documentoBeneficiario);
											
											if(mysqli_num_rows($result) != 0){
												$beneficiario = mysqli_fetch_array($result);					
												$idBeneficiario = $beneficiario['idBeneficiario'];
												
												$result = Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year);
												if(mysqli_num_rows($result) == 0){
													$consulta = Pronino::getInstance()->asignar_usuario($idBeneficiario, $idUsuario1, $idUsuario2);
													if(!$consulta){
														$errores[] = $row;
														echo "<div class='error'>Error al asignar el usuario - Fila: ".$row."</div>";
													}
													else
														echo "<div>Usuario asignado Correctamente - Fila: ".$row."</div>";
												}
											}											
											mysqli_free_result($result);
										}
                                    }
									
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
            ?>
            <div id="botones">
             	<input type="button" id="regresar" class="boton_azul" value="Regresar" title="Regresar"/> 
          	</div>      
    	</div>
    </div>     
              
  	<div id="footer">
    	<div>
        	<a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a> 
            &nbsp;|&nbsp;       	
        	<a href="../../">SGC</a>
            &nbsp;|&nbsp;            
        	<a href="../index.php">Inicio</a>
            &nbsp;|&nbsp;            
        	<a href="../administracion.php">Administracion</a>
     	</div>       
    </div>
    
    <div id="error"></div> 
</body>
</html>