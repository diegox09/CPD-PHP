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
				//$temp = 'temp'.date('His').'.xls';
				$temp = 'temp.xls';
                
                if ($_FILES['userfile']['type'] != "application/vnd.ms-excel")
                    echo "<div class='error'>La extensión del archivo no es correcta, solo se permiten archivos .xls</div>";
									                    
                else{				
                   // if(move_uploaded_file($_FILES['userfile']['tmp_name'], $temp)){
                        //if(file_exists ($temp) && is_readable ($temp)){							
							$tipoDocumento = array('' => 0, 'Cedula de Ciudadania' => 1, 'CC' => 1, 'Nuip' => 2, 'N' => 2, 'Registro Civil' => 3, 'RC' => 3, 'Tarjeta de Identidad' => 4, 'TI' => 4);
							$generos = array('' => 0, 'Femenino' => 1, 'F' => 1, 'Masculino' => 2, 'M' => 2);
							$tallaUniformes = array('' => 0, 6 => 6, 8 => 8, 10 => 10, 12 => 12, 13 => 13, 14 => 14, 16 => 16, 18 => 18, 28 => 28, 32 => 32, 35 => 35, 36 => 36, 'S (38-40)' => 38, 'S' => 38, 38 => 38, 'M (40-42)' => 40, 'M' => 40, 40 => 40, 'L (42-44)' => 42, 'L' => 42, 42 => 42);
							$sisben = array('' => 0, 'I' => 1, 'II' => 2, 'III' => 3, '1' => 1, '2' => 2, '3' => 3);	
							$estado = array('' => 0, 'Activo' => 1, 'A' => 1, 'Inactivo' => 2, 'I' => 2);
							$razonRetiro = array('' => 0, 'Desertor' => 1, 'D' => 1, 'Expulsado' => 2, 'E' => 2, 'Retirado' => 3, 'R' => 3);				
							$jornadas = array('' => 0, 'Mañana' => 1, 'Tarde' => 2, 'Sabados' => 3, 'Noche' => 4);
							$confirmar = array('' => 0, 'X' => 1);							
							
							echo '<div><strong>Año: '.$year.'</strong></div>';
							                   
                            $objPHPExcel = PHPExcel_IOFactory::load($temp);
                            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                                $worksheetTitle     = $worksheet->getTitle();	
                                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                                if($worksheet->getCellByColumnAndRow(1, 2)->getValue() == 'NOMBRES' && $worksheet->getCellByColumnAndRow(2, 2)->getValue() == 'APELLIDOS' && $worksheet->getCellByColumnAndRow(7, 2)->getValue() == 'NUMERO DOCUMENTO' && $worksheet->getCellByColumnAndRow(15, 2)->getValue() == 'DEPARTAMENTO' && $worksheet->getCellByColumnAndRow(29, 2)->getValue() == 'PROFESIONAL' && $worksheet->getCellByColumnAndRow(30, 2)->getValue() == 'COORDINADOR' && $worksheet->getCellByColumnAndRow(33, 2)->getValue() == 'COLEGIO'){ 
								
									$contArs = 0;
									$contDepartamento = 0;
									$contMunicipio = 0;
									$contBarrio = 0;
									$contSitioTrabajo = 0;
									$contActividadLaboral = 0;
									$contEscuelaFormacion = 0;
									$contColegio = 0;
									$contSede = 0;
									
									$contBeneficiario = 0;
									$contPronino = 0;
									$contAcudiente = 0;
									$contYear = 0;
									$errores = array();
								                                   
                                    for ($row = 3; $row <= $highestRow; ++ $row) {	
										/*Informacion del Beneficiario*/			
                                        $item = trim($worksheet->getCellByColumnAndRow(0, $row)->getValue());
                                        $nombreBeneficiario = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(1, $row)->getValue())));
                                        $apellidoBeneficiario = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(2, $row)->getValue())));
                                        $idGenero = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                                        $fechaNacimiento = explota(trim($worksheet->getCellByColumnAndRow(4, $row)->getValue()));
                                        $td = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                                        $documentoBeneficiario = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                                        $tallaUniforme = trim($worksheet->getCellByColumnAndRow(8, $row)->getValue());
                                        $tallaZapato = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                                        $idSisben = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());										
                                        $nombreArs = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(11, $row)->getValue())));										
										/*ARS*/
										$idArs = 0;
										if($nombreArs != ''){
											$result = Pronino::getInstance()->get_ars_by_nombre($nombreArs);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_ars($nombreArs, $idUser, $fechaActual); 									
												$result = Pronino::getInstance()->get_ars_by_nombre($nombreArs);	
												if($consulta)
													$contArs ++;
											}
											$ars = mysqli_fetch_array($result);
											$idArs = $ars['idArs'];	
										}
                                        										
										/*Informacion del Acudiente*/
										$documentoAcudiente = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
                                        $nombreAcudiente = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(13, $row)->getValue())));
										$apellidoAcudiente = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(14, $row)->getValue())));
																				
										if($apellidoAcudiente == ''){
											$array = explode(" ",$nombreAcudiente);
											$longitud = count($array);
											
											$j=0;
											for($i=0;$i<$longitud;$i++){
												if($array[$i] == 'DE' || $array[$i] == 'DEL' || $array[$i] == 'LA' || $array[$i] == 'LOS' || $array[$i] == 'DE LA' || $array[$i] == 'DE LOS'  || $array[$i] == 'VDA'){
													$array[($i+1)] = $array[$i].' '.$array[($i+1)];
													unset($array[$i]);
												}
												else{
													if($array[$i] != ''){
														switch($j){
															case 0: $nombreAcudiente = $array[$i];
																	break;
															case 1: $nombreAcudiente = $nombreAcudiente.' '.$array[$i];
																	break;
															case 2: $apellidoAcudiente = $array[$i];
																	break;
															default:$apellidoAcudiente = $apellidoAcudiente.' '.$array[$i];
																	break;							
														}
														$j++;	
													}	
												}
											}
										}
				
										$nombreDepartamento = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(15, $row)->getValue())));
										/*Departamento*/
										$idDepartamento = 0;
										if($nombreDepartamento != ''){
											$result = Pronino::getInstance()->get_departamento_by_nombre($nombreDepartamento);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_departamento($nombreDepartamento, $idUser, $fechaActual); 
												$result = Pronino::getInstance()->get_departamento_by_nombre($nombreDepartamento);	
												if($consulta)
													$contDepartamento ++;
											}	
											$departamento = mysqli_fetch_array($result);				
											$idDepartamento = $departamento['idDepartamento'];	
										}
										
										$nombreMunicipio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(16, $row)->getValue())));
										/*Municipio*/
										$idMunicipio = 0;										
										if($idDepartamento != '' && $idDepartamento != 0 && $nombreMunicipio != ''){											
											$result = Pronino::getInstance()->get_municipio_by_nombre($idDepartamento, $nombreMunicipio);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_municipio($idDepartamento, $nombreMunicipio, $idUser, $fechaActual); 
												$result = Pronino::getInstance()->get_municipio_by_nombre($idDepartamento, $nombreMunicipio);	
												if($consulta)
													$contMunicipio ++;													
											}	
											$municipio = mysqli_fetch_array($result);				
											$idMunicipio = $municipio['idMunicipio'];											
										}
                                        $direccion = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(17, $row)->getValue())));
                                        $nombreBarrio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(18, $row)->getValue())));
										/*Barrio*/
										$idBarrio = 0;										
										if($idMunicipio != '' && $idMunicipio != 0 && $nombreBarrio != ''){
											$result = Pronino::getInstance()->get_barrio_by_nombre($idMunicipio, $nombreBarrio);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_barrio($idMunicipio, $nombreBarrio, $idUser, $fechaActual); 
												$result = Pronino::getInstance()->get_barrio_by_nombre($idMunicipio, $nombreBarrio);	
												if($consulta)
													$contBarrio ++;
											}	
											$barrio = mysqli_fetch_array($result);
											$idBarrio = $barrio['idBarrio'];	
										}										
                                        $telefono = trim($worksheet->getCellByColumnAndRow(19, $row)->getValue());
										
										/*Informacion Programa Proniño*/      
                                        $fechaIngreso = explota(trim($worksheet->getCellByColumnAndRow(20, $row)->getValue()));
                                        $idEstado = trim($worksheet->getCellByColumnAndRow(21, $row)->getValue());										
                                        $fechaRetiro = explota(trim($worksheet->getCellByColumnAndRow(22, $row)->getValue()));
										
										/*Deshabilitado la Razon de retiro //Pte. $razonEgresado, $razonBaja*/
										$idRazonRetiro = "";
                                        //$idRazonRetiro = trim($worksheet->getCellByColumnAndRow(23, $row)->getValue());
										
                                        $nombreSitio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(24, $row)->getValue())));
										/*Sitio Trabajo*/
										$sitioTrabajo = 0;
										if($nombreSitio != ''){
											$result = Pronino::getInstance()->get_sitio_by_nombre($nombreSitio);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_sitio($nombreSitio, $idUser, $fechaActual);
												$result = Pronino::getInstance()->get_sitio_by_nombre($nombreSitio);
												if($consulta)
													$contSitioTrabajo ++;	
											}	
											$sitio = mysqli_fetch_array($result);				
											$sitioTrabajo = $sitio['idSitio'];	
										}
                                        $nombreActividad = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(25, $row)->getValue())));
										/*Actividad Laboral*/
										$actividadLaboral = 0;
										if($nombreActividad != ''){
											$result = Pronino::getInstance()->get_actividad_by_nombre($nombreActividad);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_actividad($nombreActividad, $idUser, $fechaActual);
												$result = Pronino::getInstance()->get_actividad_by_nombre($nombreActividad);
												if($consulta)
													$contActividadLaboral ++;	
											}	
											$actividad = mysqli_fetch_array($result);				
											$actividadLaboral = $actividad['idActividad'];	
										}
                                        $actividadEspecifica = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(26, $row)->getValue())));
										
                                        $nombreEscuela1 = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(27, $row)->getValue())));					
										$nombreEscuela2 = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(28, $row)->getValue())));					
										/*Escuelas de Formacion*/
										$escuelaFormacion1 = 0;
										$escuelaFormacion2 = 0;
										if($nombreEscuela1 != ''){
											$result = Pronino::getInstance()->get_escuela_by_nombre($nombreEscuela1);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_escuela($nombreEscuela1, $idUser, $fechaActual);
												$result = Pronino::getInstance()->get_escuela_by_nombre($nombreEscuela1);
												if($consulta)
													$contEscuelaFormacion ++;	
											}	
											$escuela = mysqli_fetch_array($result);				
											$escuelaFormacion1 = $escuela['idEscuela'];	
										}
										if($nombreEscuela2 != ''){
											$result = Pronino::getInstance()->get_escuela_by_nombre($nombreEscuela2);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_escuela($nombreEscuela2, $idUser, $fechaActual);
												$result = Pronino::getInstance()->get_escuela_by_nombre($nombreEscuela2);
												if($consulta)
													$contEscuelaFormacion ++;	
											}	
											$escuela = mysqli_fetch_array($result);				
											$escuelaFormacion2 = $escuela['idEscuela'];	
										}
										//Profesional
										$nombreUsuario1 = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(29, $row)->getValue())));
										//Coordinador
										$nombreUsuario2 = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(30, $row)->getValue())));
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
                                        $observacionesYear = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(31, $row)->getValue())));
                                        
										/*Informacion de la Institucion*/ 
										$nombreMunicipioColegio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(32, $row)->getValue())));
										/*Municipio*/
										$idMunicipioColegio = 0;										
										if($idDepartamento != '' && $idDepartamento != 0 && $nombreMunicipioColegio != ''){
											$result = Pronino::getInstance()->get_municipio_by_nombre($idDepartamento, $nombreMunicipioColegio);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_municipio($idDepartamento, $nombreMunicipioColegio, $idUser, $fechaActual); 
												$result = Pronino::getInstance()->get_municipio_by_nombre($idDepartamento, $nombreMunicipioColegio);	
												if($consulta)
													$contMunicipio ++;
											}	
											$municipioColegio = mysqli_fetch_array($result);				
											$idMunicipioColegio = $municipioColegio['idMunicipio'];	
										}                                       
                                        $nombreColegio = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(33, $row)->getValue())));										
										/*Colegio*/
										$idColegio = 0;
										if($idMunicipioColegio != '' && $idMunicipioColegio != 0 && $nombreColegio != ''){
											$update = true;$result = Pronino::getInstance()->get_colegio_by_nombre($idMunicipio, $nombreColegio);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_colegio($idMunicipio, $nombreColegio, $idUser, $fechaActual);
												$result = Pronino::getInstance()->get_colegio_by_nombre($idMunicipio, $nombreColegio);	
												if($consulta)
													$contColegio ++;
											}	
											$colegio = mysqli_fetch_array($result);				
											$idColegio = $colegio['idColegio'];
										}
                                        $nombreSede = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(34, $row)->getValue())));
																																								
										$grado = trim($worksheet->getCellByColumnAndRow(35, $row)->getValue());
										//Pte. Adicionar Seccion al grado
										$seccion = "";
										/*
											$seccion
										*/
										
                                        $jornada = trim($worksheet->getCellByColumnAndRow(36, $row)->getValue());
										
										$nombreCoordinador = utf8_decode(strtoupper(trim($worksheet->getCellByColumnAndRow(37, $row)->getValue())));
										/*Sede Colegio*/
										$idSedeColegio = 0;
										if($idColegio != '' && $idColegio != 0 && $nombreSede != ''){
											$result = Pronino::getInstance()->get_sede_by_nombre($idColegio, $nombreSede);
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_sede($idColegio, $nombreSede, $nombreCoordinador, $idUser, $fechaActual); 
												$result = Pronino::getInstance()->get_sede_by_nombre($idColegio, $nombreSede);
												if($consulta)
													$contSede ++;
											}	
											$sede = mysqli_fetch_array($result);				
											$idSedeColegio = $sede['idSedeColegio'];
										}						
										                              
                                        //Pte. Incluir Notas
										/*
										
										*/
										
										/*Informacion Adicional*/
                                        $desplazados = trim($worksheet->getCellByColumnAndRow(54, $row)->getValue());
                                        $juntos = trim($worksheet->getCellByColumnAndRow(55, $row)->getValue());
                                        $familiasAccion = trim($worksheet->getCellByColumnAndRow(56, $row)->getValue());
                                        $comedorInfantil = trim($worksheet->getCellByColumnAndRow(57, $row)->getValue());
										
                                        $kitEscolar = explota(trim($worksheet->getCellByColumnAndRow(58, $row)->getValue()));
                                        $uniforme = explota(trim($worksheet->getCellByColumnAndRow(59, $row)->getValue()));
                                        $zapatos = explota(trim($worksheet->getCellByColumnAndRow(60, $row)->getValue()));
																				
                                        $visitaDomiciliaria = explota(trim($worksheet->getCellByColumnAndRow(61, $row)->getValue()));
										$visitaAcademica = explota(trim($worksheet->getCellByColumnAndRow(62, $row)->getValue()));
                                        $visitaPsicosocial = explota(trim($worksheet->getCellByColumnAndRow(63, $row)->getValue()));                                        
                                        $intervencionPsicologica = explota(trim($worksheet->getCellByColumnAndRow(64, $row)->getValue()));
                                        $valoracionMedica = explota(trim($worksheet->getCellByColumnAndRow(65, $row)->getValue()));
                                        $valoracionOdontologica = explota(trim($worksheet->getCellByColumnAndRow(66, $row)->getValue()));
										$kitNutricional = explota(trim($worksheet->getCellByColumnAndRow(67, $row)->getValue()));
                                        $visitaSeguimiento = explota(trim($worksheet->getCellByColumnAndRow(68, $row)->getValue()));  
										
										if($documentoBeneficiario != ''){
											$result = Pronino::getInstance()->get_beneficiario_by_documento($documentoBeneficiario);
											$insert = false;
											if(mysqli_num_rows($result) == 0){
												$consulta = Pronino::getInstance()->insert_beneficiario($nombreBeneficiario, $apellidoBeneficiario, $tipoDocumento[$td], $documentoBeneficiario, $fechaNacimiento, $generos[$idGenero], $telefono, $direccion, $idMunicipio, $idBarrio, $idUser, $fechaActual);																		
												if($consulta){
													$insert = true;
													$contBeneficiario ++;
													echo "<div class='insert'>Beneficiario creado correctamente - Fila: ".$row."</div>";
												}
												else{
													$errores[] = $row;
													echo "<div class='error'>Error al crear el beneficiario - Fila: ".$row."</div>";
												}
												$result = Pronino::getInstance()->get_beneficiario_by_documento($documentoBeneficiario);
											}
											
											if(mysqli_num_rows($result) != 0){
												$update = false;	
												$beneficiario = mysqli_fetch_array($result);					
												$idBeneficiario = $beneficiario['idBeneficiario'];																							
																								
												if($beneficiario['nombreBeneficiario'] != '')
													$nombreBeneficiario = $beneficiario['nombreBeneficiario'];
												else
													$update = true;	
												if($beneficiario['apellidoBeneficiario'] != '')
													$apellidoBeneficiario = $beneficiario['apellidoBeneficiario'];
												else
													$update = true;	
												if($beneficiario['td'] != 0)
													$td = $beneficiario['td'];													
												else{
													$update = true;
													$td = $tipoDocumento[$td];
												}												
												if($beneficiario['fechaNacimiento'] != '0000-00-00')
													$fechaNacimiento = $beneficiario['fechaNacimiento'];
												else
													$update = true;	
												if($beneficiario['genero'] != 0)
													$idGenero = $beneficiario['genero'];													
												else{
													$update = true;
													$idGenero = $generos[$idGenero];
												}												
												if($beneficiario['telefono'] != '')
													$telefono = $beneficiario['telefono'];													
												else
													$update = true;	
												if($beneficiario['direccion'] != '')
													$direccion = $beneficiario['direccion'];													
												else
													$update = true;	
												if($beneficiario['idMunicipio'] != 0)
													$idMunicipio = $beneficiario['idMunicipio'];													
												else
													$update = true;	
												if($beneficiario['idBarrio'] != 0)
													$idBarrio = $beneficiario['idBarrio'];													
												else
													$update = true;	
																							
												if($update){
													$consulta = Pronino::getInstance()->update_beneficiario($idBeneficiario, $nombreBeneficiario, $apellidoBeneficiario, $td, $documentoBeneficiario, $fechaNacimiento, $idGenero, $telefono, $direccion, $idMunicipio, $idBarrio, $idUser, $fechaActual);
													if(!$insert){					
														if($consulta)
															echo "<div>Beneficiario modificado correctamente - Fila: ".$row."</div>";
														else{	
															$errores[] = $row;
															echo "<div class='error'>Error al modificar el beneficiario - Fila: ".$row."</div>";
														}
													}
												}
												
												$result = Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario);
												$insert = false;
												$idAcudiente = 0;
												if(mysqli_num_rows($result) == 0){
													$consulta = Pronino::getInstance()->insert_beneficiario_pronino($idBeneficiario, $idUser, $fechaActual);																		
													if($consulta){
														$insert = true;
														$contPronino ++;
														echo "<div class='insert'>Beneficiario asignado al programa proniño correctamente - Fila: ".$row."</div>";
													}
													else{
														$errores[] = $row;
														echo "<div class='error'>Error al asignar el beneficiario al programa proniño - Fila: ".$row."</div>";
													}
													$result = Pronino::getInstance()->get_beneficiario_pronino_by_id($idBeneficiario);
												}
												if(mysqli_num_rows($result) != 0){
													$update = false;	
													$beneficiario = mysqli_fetch_array($result);
													
													if($beneficiario['item'] != NULL)
														$item = $beneficiario['item'];
													else
														$update = true;	
													if($beneficiario['tallaUniforme'] != 0)
														$tallaUniforme = $beneficiario['tallaUniforme'];													
													else{
														$update = true;
														$tallaUniforme = $tallaUniformes[$tallaUniforme];
													}	
													if($beneficiario['tallaZapato'] != 0)
														$tallaZapato = $beneficiario['tallaZapato'];													
													else
														$update = true;
													if($beneficiario['sisben'] != 0)
														$idSisben = $beneficiario['sisben'];													
													else{
														$update = true;	
														$idSisben = $sisben[$idSisben];	
													}
													if($beneficiario['idArs'] != 0)
														$idArs = $beneficiario['idArs'];													
													else
														$update = true;
/*
													if($beneficiario['idUsuario1'] != 0)
														$idUsuario1 = $beneficiario['idUsuario1'];													
													else
														$update = true;
													if($beneficiario['idUsuario2'] != 0)
														$idUsuario2 = $beneficiario['idUsuario2'];													
													else
														$update = true;	
*/
													if($beneficiario['fechaIngreso'] != '0000-00-00')
														$fechaIngreso = $beneficiario['fechaIngreso'];
													else
														$update = true;	
													if($beneficiario['estado'] != 0){
														$idEstado = $beneficiario['estado'];
														//$update = true;	
														//$idEstado = $estado[$idEstado];	
													}													
													else{
														$update = true;	
														$idEstado = $estado[$idEstado];					
													}
													if($idEstado == 2){
														if($beneficiario['fechaRetiro'] != '0000-00-00')
															$fechaRetiro = $beneficiario['fechaRetiro'];
														else
															$update = true;	
														if($beneficiario['razonRetiro'] != 0)
															$idRazonRetiro = $beneficiario['razonRetiro'];													
														else{
															$update = true;	
															$idRazonRetiro = $razonRetiro[$idRazonRetiro];					
														}
													}
													else{
														$fechaRetiro = 	'0000-00-00';
														$idRazonRetiro = 0;
													}
													
													$idAcudiente = $beneficiario['idAcudiente'];
													
													if($update){
														//Pte. $razonEgresado, $razonBaja
														$consulta = Pronino::getInstance()->update_beneficiario_pronino($idBeneficiario, $item, $tallaUniforme, $tallaZapato, $idSisben, $idArs, $idUsuario1, $idUsuario2, $fechaIngreso, $idEstado, $fechaRetiro, $idRazonRetiro, $idUser, $fechaActual);
														if(!$insert){					
															if($consulta)
																echo "<div>Informacion del programa proniño modificada correctamente - Fila: ".$row."</div>";
															else{	
																$errores[] = $row;
																echo "<div class='error'>Error al modificar la Informacion del programa proniño - Fila: ".$row."</div>";
															}
														}
													}
												}
												
												if($idAcudiente == 0){
													$result = Pronino::getInstance()->get_beneficiario_by_documento($documentoAcudiente);
													$insert = false;
													if(mysqli_num_rows($result) == 0){
														$consulta = Pronino::getInstance()->insert_beneficiario($nombreAcudiente, $apellidoAcudiente, 1, $documentoAcudiente, '', '', $telefono, $direccion, $idMunicipio, $idBarrio, $idUser, $fechaActual);																		
														if($consulta){
															$insert = true;
															$contAcudiente ++;
															echo "<div class='insert'>Acudiente creado correctamente - Fila: ".$row."</div>";
														}
														else{
															$errores[] = $row;
															echo "<div class='error'>Error al crear el acudiente - Fila: ".$row."</div>";
														}
														$result = Pronino::getInstance()->get_beneficiario_by_documento($documentoAcudiente);
													}
													
													if(mysqli_num_rows($result) != 0){
														$beneficiario = mysqli_fetch_array($result);					
														$idAcudiente = $beneficiario['idBeneficiario'];
														
														$consulta = Pronino::getInstance()->update_acudiente_pronino($idBeneficiario, $idAcudiente, $idUser, $fechaActual);	
														if($consulta)
															echo "<div>Acudiente asignado correctamente - Fila: ".$row."</div>";
														else{	
															$errores[] = $row;
															echo "<div class='error'>Error al asignar el acudiente - Fila: ".$row."</div>";			
														}
													}
												}
												
												if($idEstado == 1 || $idEstado == 0){	
													$result = Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year);												
													if(mysqli_num_rows($result) == 0){
														$consulta = Pronino::getInstance()->insert_beneficiario_year($idBeneficiario, $year, $sitioTrabajo, $actividadLaboral, $actividadEspecifica, $observaciones, $idMunicipioColegio, $idColegio, $idSedeColegio, $grado, $jornada, $escuelaFormacion1, $escuelaFormacion2, $desplazados, $juntos, $familiasAccion, $comedorInfantil, $kitEscolar, $uniforme, $zapatos, $visitaDomiciliaria, $visitaPsicosocial, $visitaAcademica, $intervencionPsicologica, $valoracionMedica, $valoracionOdontologica, $idUser, $fechaActual);
														if($consulta){
															$contYear ++;
															echo "<div class='insert'>Se adiciono la informacion (".$year.") - Fila: ".$row."</div>";
															}
														else{	
															$errores[] = $row;
															echo "<div class='error'>Error al adicionar la informacion (".$year.") - Fila: ".$row."</div>";
														}
													}
													else{
														$update = false;
														$beneficiario = mysqli_fetch_array($result);											
													
														if($beneficiario['sitioTrabajo'] != 0)
															$sitioTrabajo = $beneficiario['sitioTrabajo'];
														else
															$update = true;														
														if($beneficiario['actividadLaboral'] != 0)
															$actividadLaboral = $beneficiario['actividadLaboral'];
														else
															$update = true;
														if($beneficiario['actividadEspecifica'] != '')
															$actividadEspecifica = $beneficiario['actividadEspecifica'];
														else
															$update = true;	
														
														if($beneficiario['observaciones'] != '')	
															$observaciones = $beneficiario['observaciones'];
														else	
															$update = true;
														
														if($beneficiario['idMunicipioColegio'] != 0)
															$idMunicipioColegio = $beneficiario['idMunicipioColegio'];
														else
															$update = true;
														if($beneficiario['idColegio'] != 0)
															$idColegio = $beneficiario['idColegio'];
														else
															$update = true;
														if($beneficiario['idSedeColegio'] != 0)
															$idSedeColegio = $beneficiario['idSedeColegio'];
														else
															$update = true;
														if($beneficiario['grado'] != 0)
															$grado = $beneficiario['grado'];
														else
															$update = true;
														if($beneficiario['jornada'] != 0)
															$jornada = $beneficiario['jornada'];
														else{
															$update = true;
															$jornada = $jornadas[$jornada];
														}
														if($beneficiario['escuelaFormacion1'] != 0)
															$escuelaFormacion1 = $beneficiario['escuelaFormacion1'];
														else
															$update = true;	
														if($beneficiario['escuelaFormacion2'] != 0)
															$escuelaFormacion2 = $beneficiario['escuelaFormacion2'];
														else
															$update = true;	
														if($beneficiario['desplazados'] != 0)
															$desplazados = $beneficiario['desplazados'];
														else{
															$update = true;	
															$desplazados = $confirmar[$desplazados];
														}
														if($beneficiario['juntos'] != 0)
															$juntos = $beneficiario['juntos'];
														else{													
															$update = true;
															$juntos = $confirmar[$juntos];
														}
														if($beneficiario['familiasAccion'] != 0)
															$familiasAccion = $beneficiario['familiasAccion'];
														else{														
															$update = true;	
															$familiasAccion = $confirmar[$familiasAccion];
														}
														if($beneficiario['comedorInfantil'] != 0)
															$comedorInfantil = $beneficiario['comedorInfantil'];
														else{
															$update = true;	
															$comedorInfantil = $confirmar[$comedorInfantil];
														}
														if($beneficiario['kitEscolar'] != '0000-00-00')
															$kitEscolar = $beneficiario['kitEscolar'];
														else
															$update = true;	
														if($beneficiario['uniforme'] != '0000-00-00')
															$uniforme = $beneficiario['uniforme'];
														else
															$update = true;	
														if($beneficiario['zapatos'] != '0000-00-00')
															$zapatos = $beneficiario['zapatos'];
														else
															$update = true;	
														if($beneficiario['visitaDomiciliaria'] != '0000-00-00')
															$visitaDomiciliaria = $beneficiario['visitaDomiciliaria'];
														else
															$update = true;
														if($beneficiario['visitaPsicosocial'] != '0000-00-00')
															$visitaPsicosocial = $beneficiario['visitaPsicosocial'];
														else
															$update = true;		
														if($beneficiario['visitaAcademica'] != '0000-00-00')
															$visitaAcademica = $beneficiario['visitaAcademica'];
														else
															$update = true;
														if($beneficiario['intervencionPsicologica'] != '0000-00-00')
															$intervencionPsicologica = $beneficiario['intervencionPsicologica'];
														else
															$update = true;	
														if($beneficiario['valoracionMedica'] != '0000-00-00')
															$valoracionMedica = $beneficiario['valoracionMedica'];
														else
															$update = true;	
														if($beneficiario['valoracionOdontologica'] != '0000-00-00')
															$valoracionOdontologica = $beneficiario['valoracionOdontologica'];
														else
															$update = true;	
														if($beneficiario['kitNutricional'] != '0000-00-00')
															$kitNutricional = $beneficiario['kitNutricional'];
														else
															$update = true;				
														if($beneficiario['visitaSeguimiento'] != '0000-00-00')
															$visitaSeguimiento = $beneficiario['visitaSeguimiento'];
														else
															$update = true;	
																					
										
														if($update){
															$consulta = Pronino::getInstance()->update_beneficiario_year($idBeneficiario, $year, $sitioTrabajo, $actividadLaboral, $actividadEspecifica, $observaciones, $idMunicipioColegio, $idColegio, $idSedeColegio, $grado, $jornada, $escuelaFormacion1, $escuelaFormacion2, $desplazados, $juntos, $familiasAccion, $comedorInfantil, $kitEscolar, $uniforme, $zapatos, $visitaDomiciliaria, $visitaPsicosocial, $visitaAcademica, $intervencionPsicologica, $valoracionMedica, $valoracionOdontologica, $idUser, $fechaActual, $seccion, $kitNutricional, $visitaSeguimiento);	
															if($consulta)
																echo "<div>Informacion modificada correctamente (".$year.") - Fila: ".$row."</div>";
															else{	
																$errores[] = $row;
																echo "<div class='error'>Error al modificar la Informacion (".$year.") - Fila: ".$row."</div>";
															}
														}
													}
													//Fin else(mysqli_num_rows($result))
												}
												//Fin if($idEstado)
											}											
											mysqli_free_result($result);
										}
										//Fin if($documentoBeneficiario)
                                    }
									//Fin for
									
									echo "<br>";
									if($contBeneficiario != 0)
										echo "<div><strong>Se Crearon: ".$contBeneficiario." Beneficiario(s)</strong></div>";
									if($contPronino != 0)	
										echo "<div><strong>Se Asignaron: ".$contPronino." Beneficiario(s) al programa Proniño</strong></div>";
									if($contYear != 0)	
										echo "<div><strong>Se Adicionaron: ".$contYear." Beneficiario(s) al Año ".$year."</strong></div>";	
									if($contAcudiente != 0)	
										echo "<div><strong>Se Crearon: ".$contAcudiente." Acudiente(s)</strong></div>";	
										
									if($contArs != 0)	
										echo "<div><strong>Se Crearon: ".$contArs." Ars(s)</strong></div>";
									if($contDepartamento != 0)	
										echo "<div><strong>Se Crearon: ".$contDepartamento." Departamento(s)</strong></div>";
									if($contMunicipio != 0)	
										echo "<div><strong>Se Crearon: ".$contMunicipio." Municipio(s)</strong></div>";	
									if($contBarrio != 0)	
										echo "<div><strong>Se Crearon: ".$contBarrio." Barrio(s)</strong></div>";
									if($contSitioTrabajo != 0)	
										echo "<div><strong>Se Crearon: ".$contSitioTrabajo." Sitio(s) de Trabajo</strong></div>";
									if($contActividadLaboral != 0)	
										echo "<div><strong>Se Crearon: ".$contActividadLaboral." Actividad(es) Laboral(es)</strong></div>";							
									if($contEscuelaFormacion != 0)	
										echo "<div><strong>Se Crearon: ".$contEscuelaFormacion." Escuela(s) de Formacion</strong></div>";												
									if($contColegio != 0)	
										echo "<div><strong>Se Crearon: ".$contColegio." Colegio(s)</strong></div>";	
									if($contSede != 0)	
										echo "<div><strong>Se Crearon: ".$contSede." Sede(s) de Colegio(s)</strong></div>";														
									
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
						/*else
							echo "<div class='error'>El archivo no existe o no se puede leer</div>";
                    }
                    else
                        echo "<div class='error'>Ocurrió algún error al subir el fichero. No pudo guardarse</div>";
                }      */     
            ?>
            <div id="botones">
             	<input type="button" id="regresar" class="boton_azul" value="Regresar" title="Regresar"/> 
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
        	<a href="../index.php">Inicio</a>
            &nbsp;|&nbsp;            
        	<a href="../administracion.php">Administracion</a>
            &nbsp;|&nbsp;
            <a href="../doc/ayuda.pdf" target="_blank" id="ayuda" title="Ayuda">&nbsp;&nbsp;&nbsp;</a>
     	</div>       
    </div>
    
    <div id="error"></div> 
</body>
</html>