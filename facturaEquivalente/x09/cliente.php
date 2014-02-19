<?php
	require_once('classes/User.php');
	require_once('classes/Cliente.php');
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
		$nit = $_GET['nit_persona'];	
		$opc = $_GET['opc'];
		$consulta = true;				
		switch($opc){
			case 'buscar': 	if($nit == 'all')
								$result = Cliente::getInstance()->get_cliente();			
							else{	
								$result = Cliente::getInstance()->get_cliente_by_nit($nit);									
								if(mysqli_num_rows($result) == 0){	
									$consulta = Cliente::getInstance()->insert_nit_cliente($nit);										
									$result = Cliente::getInstance()->get_cliente_by_nit($nit);
								}
							}
							break;	
			case 'buscar_n':$nombres = utf8_decode($_GET['persona_natural']);
							$result = Cliente::getInstance()->get_cliente_by_nombres($nombres);							
							break;	
			case 'delete':	$idCliente = $_GET['id_persona'];		
							$result = Factura::getInstance()->get_factura_by_nit($idCliente);
							if(mysqli_num_rows($result) == 0){
								$consulta = Cliente::getInstance()->delete_cliente($idCliente);
								if($consulta)
									$respuesta['idCliente'] = $idCliente;								
							}
							else{
								$consulta = false;
								$respuesta['mensaje'] = ', Esta Relacionado con alguna Factura';
							}
							$result = false;
							break;															
			case 'insert':	$nombres = strtoupper(utf8_decode($_GET['persona_natural']));	
							$actividadEconomica = $_GET['actividad_economica'];	
							$direccion = strtoupper(utf8_decode($_GET['direccion_persona']));							
							$consulta = Cliente::getInstance()->insert_cliente($nit, $nombres, $actividadEconomica, $direccion);												
							$result = Cliente::getInstance()->get_cliente_by_nit($nit);	
							break;										
			case 'update':	$idCliente = $_GET['id_persona'];
							$nombres = strtoupper(utf8_decode($_GET['persona_natural']));	
							$actividadEconomica = $_GET['actividad_economica'];	
							$direccion = strtoupper(utf8_decode($_GET['direccion_persona']));							
							$consulta = Cliente::getInstance()->update_cliente($idCliente, $nit, $nombres, $actividadEconomica, $direccion);
							$result = Cliente::getInstance()->get_cliente_by_id($idCliente);	
							break;						
			default : 		$idCliente = $_GET['id_persona'];
							$result = Cliente::getInstance()->get_cliente_by_id($idCliente);
							break;						
		}				
		
		if($opc != 'delete'){
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
			while ($cliente = mysqli_fetch_array($result)){
				$respuesta['idCliente'][] = $cliente['idCliente'];
				$respuesta['nitCliente'][] = $cliente['nit'];		
				$respuesta['nombreCliente'][] = utf8_encode($cliente['nombres']);		
				$respuesta['actividadEconomica'][] = $cliente['actividadEconomica'];		
				$respuesta['direccionCliente'][] = utf8_encode($cliente['direccion']);		
			}		
		}
		mysqli_free_result($result);
		$respuesta['opc'] = $opc;		
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 