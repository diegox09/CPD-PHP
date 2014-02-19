<?php
	session_start();
	
	require_once('classes/Humanitaria.php');
	require_once('funciones/funciones.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$idDamnificado = $_GET['id_damnificado'];
		$opc = $_GET['opc'];
		$consulta = true;	
		$fase = $_GET['fase'];		
		$ficho = $_GET['ficho'];		
		$fechaKitAseo = explota($_GET['fecha_kit_aseo']);
		$fechaMercado1 = explota($_GET['fecha_mercado1']);
		$fechaMercado2 = explota($_GET['fecha_mercado2']);
		$fechaMercado3 = explota($_GET['fecha_mercado3']);
		$fechaMercado4 = explota($_GET['fecha_mercado4']);
		$observaciones = utf8_decode($_GET['observaciones']);
		$estado = $_GET['bloquear'];
		$idUser = $_SESSION['id_hu'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
		$fecha = date('Y-m-d');
						
		switch($opc){		
			case 'cargar':	$result = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);								
							break;
			case 'eliminar':$consulta = Humanitaria::getInstance()->delete_entregas($idDamnificado, $fase);								
							break;										
			case 'guardar':	$consulta = Humanitaria::getInstance()->update_entregas($idDamnificado, $fase, $ficho, $fechaKitAseo, $fechaMercado1, $fechaMercado2, $fechaMercado3, $fechaMercado4, $estado, $observaciones, $fechaActual, $idUser);							
							$result = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);								
							break;
			case 'todo':	$entregas = mysqli_fetch_array(Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase));							
							if($entregas['fecha_kit_aseo'] != '0000-00-00')
								$fechaKitAseo = $entregas['fecha_kit_aseo'];
							else
								$fechaKitAseo = $fecha;								
							if($entregas['fecha_mercado1'] != '0000-00-00')
								$fechaMercado1 = $entregas['fecha_mercado1'];							
							else
								$fechaMercado1 = $fecha;	
							if($entregas['fecha_mercado2'] != '0000-00-00')
								$fechaMercado2 = $entregas['fecha_mercado2'];							
							else
								$fechaMercado2 = $fecha;	
							if($entregas['fecha_mercado3'] != '0000-00-00')
								$fechaMercado3 = $entregas['fecha_mercado3'];							
							else
								$fechaMercado3 = $fecha;	
							if($entregas['fecha_mercado4'] != '0000-00-00')
								$fechaMercado4 = $entregas['fecha_mercado4'];							
							else
								$fechaMercado4 = $fecha;	
							$consulta = Humanitaria::getInstance()->update_entregas($idDamnificado, $fase, $ficho, $fechaKitAseo, $fechaMercado1, $fechaMercado2, $fechaMercado3, $fechaMercado4, $estado, $observaciones, $fechaActual, $idUser);							
							$result = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);								
							break;					
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$entregas = mysqli_fetch_array($result);									
				$respuesta['fechaKitAseo'] = implota($entregas['fecha_kit_aseo']);
				$respuesta['fechaMercado1'] = implota($entregas['fecha_mercado1']);
				$respuesta['fechaMercado2'] = implota($entregas['fecha_mercado2']);
				$respuesta['fechaMercado3'] = implota($entregas['fecha_mercado3']);
				$respuesta['fechaMercado4'] = implota($entregas['fecha_mercado4']);
				$respuesta['estado'] = $entregas['id_estado'];
				$respuesta['fecha'] = $entregas['fecha'];
				$respuesta['observaciones'] = utf8_encode($entregas['observaciones']);
				if($entregas['ficho'] == NULL)
					$respuesta['ficho'] = '';
				else
					$respuesta['ficho'] = $entregas['ficho'];	
				
				$idUser = $entregas['id_usuario'];				
				$usuario = mysqli_fetch_array(Humanitaria::getInstance()->get_user_by_id($idUser));					
				$respuesta['user'] = $usuario['user'];
			}
			mysqli_free_result($result);
		}
										
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		$respuesta['perfil'] = $_SESSION['perfil_hu'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 