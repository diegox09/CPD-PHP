<?php
	require_once('classes/User.php');
	require_once('classes/Programa.php');
	require_once('classes/Factura.php');	
	
	$logonSuccess = false;
	$respuesta = array();	
	
	session_start();
	if (array_key_exists('id_fe', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_fe'] == User::getInstance()->get_administrador())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){	
		$idPrograma = $_GET['id_programa'];
		$idTipoFactura = $_GET['tipo_factura'];		
		$opc = $_GET['opc'];
		$consulta = true;		
		if($idPrograma != ''){			
			switch($opc){
				case 'delete': 		$result = Factura::getInstance()->get_factura_by_programa($idPrograma);
									if(mysqli_num_rows($result) == 0){
										$result = Programa::getInstance()->get_programa_by_user_p($idPrograma);
										if(mysqli_num_rows($result) == 0){		
											$consulta = Programa::getInstance()->delete_programa($idPrograma);
											if($consulta)
												$respuesta['idPrograma'] = $idPrograma;	
										}
										else{
											$consulta = false;
											$respuesta['mensaje'] = ', Esta Relacionado con algun Usuario';
										}
									}
									else{
										$consulta = false;
										$respuesta['mensaje'] = ', Esta Relacionado con alguna Factura';
									}
									break;
				case 'delete_up': 	$idUser = $_GET['id_user'];	
									$consulta = Programa::getInstance()->delete_user_programa($idUser, $idPrograma);
									break; 								
				case 'insert': 		$idUser = $_GET['id_user'];	
									$consulta = Programa::getInstance()->insert_user_programa($idUser, $idPrograma); 
									break;
				case 'update' :		$nombre = utf8_decode($_GET['nombre']);
									$contrato = utf8_decode($_GET['contrato']);
									$direccion = utf8_decode($_GET['direccion']);
									$ciudad = utf8_decode($_GET['ciudad']);
									$consulta = Programa::getInstance()->update_programa($idPrograma, $nombre, $idTipoFactura, $contrato, $direccion, $ciudad);
									break;
			}
			if($opc != 'delete')
				$result = Programa::getInstance()->get_programa_by_id($idPrograma);
		}
		else{		
			switch($opc){
				case 'all': 	$result = Programa::getInstance()->get_programa(); 
								break;	
							
				case 'insert':  $nombre = utf8_decode($_GET['nombre']);
								$contrato = utf8_decode($_GET['contrato']);
								$direccion = utf8_decode($_GET['direccion']);
								$ciudad = utf8_decode($_GET['ciudad']);
								$consulta = Programa::getInstance()->insert_programa($nombre, $idTipoFactura, $contrato, $direccion, $ciudad); 
								$result = Programa::getInstance()->get_programa_by_nombre($nombre, $idTipoFactura);
								break;				
				case 'user': 	$idUser = $_GET['id_user'];									
								$result = Programa::getInstance()->get_programa_by_user($idUser); 
								break;					
				default: 		$idUser = $_SESSION['id_fe'];	
								$respuesta['idUser'] = $idUser;				
								$result = Programa::getInstance()->get_programa_by_user_tf($idUser, $idTipoFactura);
								date_default_timezone_set('America/Bogota'); 
								$fechaActual = date('Y-m-d');						
								$respuesta['fecha'] = $fechaActual;				
								break;
			}	
		}					
		
		if($opc != 'delete'){
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;			
			else{
				while ($row = mysqli_fetch_array($result)){
					$respuesta['idPrograma'][] = $row['idPrograma'];
					$respuesta['nombre'][] = utf8_encode($row['nombre']);
					$respuesta['contrato'][] = utf8_encode($row['contrato']);
					$respuesta['direccion'][] = utf8_encode($row['direccion']);
					$respuesta['ciudad'][] = utf8_encode($row['ciudad']);
					$respuesta['inicFactura'][] = $row['iniciales'];
					$respuesta['idTipoFactura'][] = $row['idTipoFactura'];
					$respuesta['tipoFactura'][] = utf8_encode($row['descripcion']);
				}	
				mysqli_free_result($row);		
			}		
		}
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 