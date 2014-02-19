<?php
	set_time_limit(240);
	ini_set('memory_limit','256M');	
	
	session_start();
	
	require_once('classes/Humanitaria.php');
	require_once('funciones/funciones.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = false;
		$fase = $_GET['fase'];
		$fecha = explota($_GET["fecha"]);
				
		if($fecha == '0000-00-00'){
			$titulo = 'Pendientes x Entregar';
			$pendientes = true;
		}
		else{
			$titulo = 'Entregas - '.implota($fecha);
			$pendientes = false;
		}
		
		$totalDamnificados = 0;		
		$totalArriendos = 0;
		$totalMercados = 0;
		$totalKitsAseo = 0;
		$totalReparaciones = 0;
		
		$damnificados = array();
		
		$result = Humanitaria::getInstance()->get_entregas_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_arriendos_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_reparaciones_by_fase($fase);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$respuesta['damnificados'] = count($damnificados);	
		
		if($pendientes){
			foreach ($damnificados as $id){
				$consulta = true;
				$idDamnificado = $id;
						
				$contDamnificado = false;					
				$resultArriendo = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultArriendo) != 0){
					$arriendo = mysqli_fetch_array($resultArriendo);					
					if($arriendo['fecha_arriendo'] != '0000-00-00'){
						$contDamnificado = true;
						$totalArriendos ++;
					}
				}	
				mysqli_free_result($resultArriendo);		
												
				$resultEntregas = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
				if(mysqli_num_rows($resultEntregas) != 0){				
					$entregas = mysqli_fetch_array($resultEntregas);
					
					if($entregas['fecha_kit_aseo'] != '0000-00-00'){
						$contDamnificado = true;
						$totalKitsAseo ++;					
					}
					if($entregas['fecha_mercado1'] != '0000-00-00'){
						$contDamnificado = true;
						$totalMercados ++;						
					}
					if($entregas['fecha_mercado2'] != '0000-00-00'){
						$contDamnificado = true;
						$totalMercados ++;						
					}
					if($entregas['fecha_mercado3'] != '0000-00-00'){
						$contDamnificado = true;
						$totalMercados ++;						
					}
					if($entregas['fecha_mercado4'] != '0000-00-00'){
						$contDamnificado = true;
						$totalMercados ++;
					}
				}	
				mysqli_free_result($resultEntregas);
				
				$resultReparacion = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultReparacion) != 0){
					$reparacion = mysqli_fetch_array($resultReparacion);					
					if($reparacion['fecha_reparacion'] != '0000-00-00'){
						$contDamnificado = true;
						$totalReparaciones ++;
					}
				}	
				mysqli_free_result($resultReparacion);
				
				if($contDamnificado)
					$totalDamnificados ++;
			}
			
			$respuesta['damnificadosAtendidos'] = $totalDamnificados;
			$respuesta['arriendosEntregados'] = $totalArriendos;
			$respuesta['mercadosEntregados'] = $totalMercados;
			$respuesta['kitsAseoEntregados'] = $totalKitsAseo;	
			$respuesta['reparacionesEntregadas'] = $totalReparaciones;	
		}	
		
		$totalDamnificados = 0;
		$totalArriendos = 0;
		$totalMercados = 0;
		$totalKitsAseo = 0;
		$totalReparaciones = 0;
		
		$damnificados = array();
		$result = Humanitaria::getInstance()->get_entregas_by_fase_fecha($fase, $fecha);		
		while ($info = mysqli_fetch_array($result)){
			$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_arriendos_by_fase_fecha($fase, $fecha);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		$result = Humanitaria::getInstance()->get_reparaciones_by_fase_fecha($fase, $fecha);		
		while ($info = mysqli_fetch_array($result)){
			if(!in_array($info['id_damnificado'], $damnificados))
				$damnificados[] = $info['id_damnificado'];		
		}
		mysqli_free_result($result);
		
		foreach ($damnificados as $id){
			$totalDamnificados ++;
			$consulta = true;
			$idDamnificado = $id;
			$resultDamnificado = Humanitaria::getInstance()->get_damnificado_by_id($idDamnificado);
			
			if(mysqli_num_rows($resultDamnificado) != 0){					
				$damnificado = mysqli_fetch_array($resultDamnificado);
				$nombreDamnificado = utf8_encode($damnificado['primer_nombre']);
				if($damnificado['segundo_nombre'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_nombre']);
				if($damnificado['primer_apellido'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['primer_apellido']);
				if($damnificado['segundo_apellido'] != '')
					$nombreDamnificado = $nombreDamnificado.' '.utf8_encode($damnificado['segundo_apellido']);		
				
				$respuesta['nombreDamnificado'][] = $nombreDamnificado;
				$respuesta['documentoDamnificado'][] = $damnificado['documento_damnificado'];
				$respuesta['telefonoDamnificado'][] = $damnificado['telefono'];	
					
				$contArriendo = '';
				$nombreArrendador = '';	
				$telefonoArrendador = '';						
				$comprobante = '';
				$hora = '';
				
				$contReparacion = '';	
				
				$contKitAseo = '';
				$contMercados = 0;
												
				$resultEntregas = Humanitaria::getInstance()->get_entregas_by_damnificado($idDamnificado, $fase);
				if(mysqli_num_rows($resultEntregas) != 0){				
					$entregas = mysqli_fetch_array($resultEntregas);
					
					if($entregas['fecha_kit_aseo'] == $fecha){
						$totalKitsAseo ++;
						$contKitAseo = 1;					
					}
					
					if($entregas['fecha_mercado1'] == $fecha){
						$totalMercados ++;
						$contMercados ++;	
					}
					if($entregas['fecha_mercado2'] == $fecha){
						$totalMercados ++;
						$contMercados ++;
					}
					if($entregas['fecha_mercado3'] == $fecha){
						$totalMercados ++;
						$contMercados ++;	
					}
					if($entregas['fecha_mercado4'] == $fecha){
						$totalMercados ++;
						$contMercados ++;
					}
						
					if($contMercados > 0 || $contKitAseo != '')	
						$hora = substr($entregas['fecha'],10,6);
				}
				mysqli_free_result($resultEntregas);	
				
				if($contMercados == 0)
					$contMercados = '';											
															
				$resultArriendo = Humanitaria::getInstance()->get_arriendo_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultArriendo) != 0){
					$arriendo = mysqli_fetch_array($resultArriendo);					
					if($arriendo['fecha_arriendo'] == $fecha){
						$totalArriendos ++;
						$contArriendo = 1;	
						$comprobante = $arriendo['comprobante'];
						$hora = substr($arriendo['fecha'],10,6);
						
						$idArrendador = $arriendo['id_arrendador'];
						$resultArrendador = Humanitaria::getInstance()->get_arrendador_by_id($idArrendador);
						if(mysqli_num_rows($resultArrendador) != 0){
							$arrendador = mysqli_fetch_array($resultArrendador);							
							$nombreArrendador = utf8_encode($arrendador['nombre_arrendador']);
							$telefonoArrendador = utf8_encode($arrendador['telefono_arrendador']);
						}
						mysqli_free_result($resultArrendador);
					}
				}
				mysqli_free_result($resultArriendo);
				
				$resultReparacion = Humanitaria::getInstance()->get_reparacion_by_damnificado($idDamnificado, $fase);				
				if(mysqli_num_rows($resultReparacion) != 0){
					$reparacion = mysqli_fetch_array($resultReparacion);					
					if($reparacion['fecha_reparacion'] == $fecha){
						$totalReparaciones ++;
						$contReparacion = 1;	
						$comprobante = $reparacion['comprobante'];
						$hora = substr($reparacion['fecha'],10,6);						
					}
				}
				mysqli_free_result($resultReparacion);			
				
				if($comprobante == NULL)
					$comprobante = '';	
					
				$respuesta['mercados'][] = $contMercados;
				$respuesta['kitAseo'][] = $contKitAseo;
				$respuesta['arriendo'][] = $contArriendo;
				$respuesta['reparacion'][] = $contReparacion;
				$respuesta['nombreArrendador'][] = $nombreArrendador;
				$respuesta['telefonoArrendador'][] = $telefonoArrendador;
				$respuesta['comprobante'][] = $comprobante;				
				$respuesta['hora'][] = $hora;			
			}			
			mysqli_free_result($resultDamnificado);							
		}
		
		$respuesta['titulo'] = $titulo;
		$respuesta['pendientes'] = $pendientes;
		$respuesta['totalDamnificados'] = $totalDamnificados;
		$respuesta['totalArriendos'] = $totalArriendos;
		$respuesta['totalMercados'] = $totalMercados;
		$respuesta['totalKitsAseo'] = $totalKitsAseo;
		$respuesta['totalReparaciones'] = $totalReparaciones;
			
		$respuesta['consulta'] = $consulta;	
		$respuesta['perfil'] = $_SESSION['perfil_hu'];
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 