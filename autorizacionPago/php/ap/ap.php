<?php
	session_start();
	
	require_once('../classes/AutorizacionPago.php');	
	require_once('../funciones/funciones.php');	
	
	$logonSuccess = false;
	$respuesta = array();		
	
	if (array_key_exists('id_ap', $_SESSION)) {
		$logonSuccess = true;
		$administrador = false;
		if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap())
			$administrador = true;
		$respuesta['administrador'] = $administrador;
	}
				
	if($logonSuccess){		
		$idAutorizacionPago= $_GET['id_ap'];
		$opc = $_GET['opc'];
		$consulta = true;
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){	
			case 'ap': 	$buscar = utf8_decode($_GET['buscar']);	
						$idPrograma = $_GET['id_programa'];	
						if($idPrograma == 0 || $idPrograma == '')
							$result = AutorizacionPago::getInstance()->get_buscar_ap($buscar); 
						else
							$result = AutorizacionPago::getInstance()->get_buscar_ap_by_programa($buscar, $idPrograma);
						break;		
			case 'buscar_ap': 	$result = AutorizacionPago::getInstance()->get_ap_by_id($idAutorizacionPago); 
								break;
			case 'buscar_cliente':	$idPersona = $_GET['id_cliente'];			
									$result  = AutorizacionPago::getInstance()->get_persona_by_id($idPersona);	
									break;						
			case 'cambiar_consecutivo':	$consecutivo = $_GET['consecutivo'];			
										$consulta = AutorizacionPago::getInstance()->update_consecutivo_ap($idAutorizacionPago, $consecutivo);	
										$result = AutorizacionPago::getInstance()->get_ap_by_id($idAutorizacionPago);
										break;
			case 'desbloquear':	$id = mysqli_fetch_array(AutorizacionPago::getInstance()->get_id_creador_ap($idAutorizacionPago));															
								if($id[0] == NULL)
									$consulta = false;
								else
									$consulta = AutorizacionPago::getInstance()->update_user_ap($idAutorizacionPago, $id[0], $fechaActual);											
								
								$result = AutorizacionPago::getInstance()->get_ap_by_id($idAutorizacionPago);
								break;						
			case 'eliminar':$result = AutorizacionPago::getInstance()->get_item_ap($idAutorizacionPago);
							if(mysqli_num_rows($result) == 0)	
								$consulta = AutorizacionPago::getInstance()->delete_ap($idAutorizacionPago);
							else
								$consulta = false;	
							break;							
			case 'guardar':	$idPrograma = $_GET['id_programa_ap'];	
							$idResponsable = $_GET['id_responsable_ap'];
							$idMunicipio = $_GET['id_municipio_ap'];
							$fecha = explota($_GET['fecha']);
							$idCliente = $_GET['id_cliente'];							
							$concepto = utf8_decode($_GET['concepto']);					
							$tipoPago = $_GET['tipo_pago'];
							$idUser = $_SESSION['id_ap'];
							$banco = utf8_decode($_GET['banco']);
							$tipoCuenta = $_GET['tipo_cuenta'];
							$numeroCuenta = $_GET['numero_cuenta'];
							$estado = $_GET['estado'];		
														
							if($idAutorizacionPago == ''){				
								$ap = mysqli_fetch_array(AutorizacionPago::getInstance()->get_numero_ap($idPrograma));			
								if($ap[0] == NULL)
									$consecutivo = 1;	
								else			
									$consecutivo = ++$ap[0];									
			
								$consulta = AutorizacionPago::getInstance()->insert_ap($idPrograma, $consecutivo, $fecha, $idResponsable, $idCliente, $idMunicipio, $concepto, $tipoPago, $idUser, $idUser, $fechaActual, $banco, $tipoCuenta, $numeroCuenta, $estado);
								
								$ap = mysqli_fetch_array(AutorizacionPago::getInstance()->get_id_ap($idPrograma, $consecutivo));
								$idAutorizacionPago = $ap['idAutorizacionPago'];
								$respuesta['idAutorizacion'] = $idAutorizacionPago;
							}
							else{
								$id = mysqli_fetch_array(AutorizacionPago::getInstance()->get_id_user_ap($idAutorizacionPago));
								if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap() || $_SESSION['id_ap'] == $id[0])
									$consulta = AutorizacionPago::getInstance()->update_ap($idAutorizacionPago, $fecha, $idResponsable, $idCliente, $idMunicipio, $concepto, $tipoPago, $idUser, $fechaActual, $banco, $tipoCuenta, $numeroCuenta, $estado);									
								else
									$consulta = false;	
							}
								
							$result = AutorizacionPago::getInstance()->get_ap_by_id($idAutorizacionPago);
							break;	
			default:		$result = false;				
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{	
				$lista = false;			
				while ($info = mysqli_fetch_array($result)){
					switch($opc){
						case 'buscar_cliente': 	$respuesta['idCliente'][] = $info['idPersona'];
												$respuesta['nombreCliente'][] = utf8_encode($info['nombre']);
												$identificacion = number_format($info['identificacion'],0,',','.');	
												$dv = $info['dv'];
												if($dv == 0)
													$dv = '';
												else
													$dv = '-'.$dv;							
												$respuesta['identificacionCliente'][] = $identificacion.$dv; 
												$cargar = false;
												break;
						default:	$cargar = true;
									break;						
					}						
					if($cargar){						
						//Editable
						$idUser = $info['idUser'];
						$idPrograma = $info['idPrograma'];
						
						$verificar_programa = AutorizacionPago::getInstance()->get_verificar_user_by_programa($_SESSION['id_ap'], $idPrograma);
						if(mysqli_num_rows($verificar_programa) == 0)
							$pdf = false;
						else
							$pdf = true;
													
						if($_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador() || $_SESSION['perfil_ap'] == AutorizacionPago::getInstance()->get_administrador_ap() || $_SESSION['id_ap'] == $idUser)
							$editable = true;
						else
							$editable = false;						
							
						if($editable || $pdf){
							$lista = true;								
							$respuesta['idUser'][] = $idUser;
							$respuesta['pdf'][] = $pdf;
							$respuesta['editable'][] = $editable;
							
							$respuesta['id'][] = $info['idAutorizacionPago'];
							$respuesta['idPrograma'][] = $idPrograma;
							
							$idMunicipio = $info['idMunicipio'];
							$respuesta['idMunicipio'][] = $idMunicipio;
							
							$respuesta['consecutivo'][] = $info['consecutivo'];
							$respuesta['fecha'][] = implota($info['fecha']);
							
							$idResponsable = $info['idResponsable'];
							$respuesta['idResponsable'][] = $idResponsable;	
							
							$idPersona = $info['idCliente'];
							$respuesta['idCliente'][] = $idPersona;							
							
							$respuesta['tipoPago'][] = $info['tipoPago'];	
							$idCreador = $info['idCreador'];	
							$respuesta['idCreador'][] = $idCreador;		
							
							$fechaActualizacion = $info['fechaActualizacion'];
							$fecha = implota(substr($fechaActualizacion,0,10));
							$hora = substr($fechaActualizacion,11,8);
							$respuesta['fechaActualizacion'][] = $fecha.' '.$hora;
							
							$concepto = utf8_encode($info['concepto']);						
							$respuesta['concepto'][] = $concepto;	
							$respuesta['conceptoLista'][] = cortar($concepto,70,' ');	
							
							$respuesta['banco'][] = $banco = utf8_encode($info['banco']);
							$respuesta['tipoCuenta'][] = $tipoCuenta = $info['tipoCuenta'];
							$respuesta['numeroCuenta'][] = $numeroCuenta = $info['numeroCuenta'];
							$respuesta['estado'][] = $estado = $info['estado'];	
														
							//Programa
							$programa = mysqli_fetch_array(AutorizacionPago::getInstance()->get_programa_by_id($idPrograma));						
							$respuesta['nombrePrograma'][] = utf8_encode($programa['nombre']);	
							
							//Municipio
							$municipio = mysqli_fetch_array(AutorizacionPago::getInstance()->get_municipio_by_id($idMunicipio));
							$respuesta['idDepartamento'][] = $municipio['idDepartamento'];								
							$respuesta['nombreMunicipio'][] = utf8_encode($municipio['nombre']);
							
							//Creador
							$creador = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idCreador));
							$respuesta['nombreCreador'][] = utf8_encode($creador['nombre']);
													
							if($idCreador == $_SESSION['id_ap'])
								$creador = true;
							else
								$creador = false;
							$respuesta['creador'][] = $creador;
							
							//Usuario
							$usuario = mysqli_fetch_array(AutorizacionPago::getInstance()->get_user_by_id($idUser));
							$respuesta['nombreUsuario'][] = utf8_encode($usuario['nombre']);
							$idPerfil = $usuario['idPerfil'];
													
							if($idPerfil == AutorizacionPago::getInstance()->get_administrador() || $idPerfil == AutorizacionPago::getInstance()->get_administrador_ap())
								$bloqueo = true;
							else
								$bloqueo = false;
							$respuesta['bloqueo'][] = $bloqueo;
							
							//Responsable
							$responsable = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idResponsable));
							$respuesta['nombreResponsable'][] = utf8_encode($responsable['nombre']);
							
							//Cliente
							$cliente = mysqli_fetch_array(AutorizacionPago::getInstance()->get_persona_by_id($idPersona));
							$identificacion = number_format($cliente['identificacion'],0,',','.');	
							$dv = $cliente['dv'];
							if($dv == 0)
								$dv = '';
							else
								$dv = '-'.$dv;							
							$respuesta['identificacionCliente'][] = $identificacion.$dv; 
							$respuesta['nombreCliente'][] = utf8_encode($cliente['nombre']);
							
							//Retenciones
							if($opc == 'buscar_ap'){
								$respuesta['iva'] = $info['iva'].'%';
								$respuesta['valorIva'] = '$ '.number_format($info['valorIva'],0,',','.');
								$respuesta['retencionIva'] = $info['retencionIva'].'%';
								$respuesta['valorRetencionIva'] = '$ '.number_format($info['valorRetencionIva'],0,',','.');
								$respuesta['retencionFuente'] = $info['retencionFuente'].'%';
								$respuesta['valorRetencionFuente'] = '$ '.number_format($info['valorRetencionFuente'],0,',','.');
								$respuesta['retencionIca'] = $info['retencionIca'];	
								$respuesta['valorRetencionIca'] = '$ '.number_format($info['valorRetencionIca'],0,',','.');
								
								$respuesta['sumarIva'] = $info['sumarIva'];	
							}
						}						
					}
				}			
				mysqli_free_result($result);
				if(!$lista && ($opc == 'ap' || $opc == 'buscar_ap'))
					$consulta = false;
			}
		}
		else
			$respuesta['id'] = $idAutorizacionPago;
							
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;	
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 