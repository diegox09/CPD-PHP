<?php
	session_start();
	
	require_once('classes/Pronino.php');
	require_once('funciones/funciones.php');
	
	$logonSuccess = false;
	$respuesta = array();	
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){
		$consulta = true;
		$opc = $_GET['opc'];
		$idBeneficiario = $_GET['id_beneficiario'];
		$year = $_GET['year'];
		$mes = $_GET['id_mes'];
		$actividades = $_GET['actividades_mes'];
		
		$actividades = explode(":",$actividades);
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){				
			case 'cargar':	$result = Pronino::getInstance()->get_actividades_by_periodo($idBeneficiario, $year, $mes);								
							break;						
			case 'guardar':	if($year != 0 && $mes != 0){
								$consulta = Pronino::getInstance()->delete_actividades_mes($idBeneficiario, $year, $mes);
								foreach($actividades as $actividad){
									$actividad = explode("_",$actividad);
									$dia = $actividad[0];
									$hora = $actividad[1];
									$act = $actividad[2];
									if($dia != 0 && $act != 0)
										$consulta = Pronino::getInstance()->insert_actividad_mes($idBeneficiario, $year, $mes, $dia, $hora, $act, $idUser, $fechaActual);
								}
							}
							$result = Pronino::getInstance()->get_actividades_by_periodo($idBeneficiario, $year, $mes);								
							break;										
			default:		$result = false;
							break;			
		}		
		
		
		if(mysqli_num_rows($result) == 0)	
			$consulta = false;
		
		else{
			$periodoLectivo = array(0,0,0,0,0,0);
			$periodoVacaciones = array(0,0,0,0,0,0);
			
			$meses = array(0,0,0,0,0,0);				
			$dias = array(0,0,0);
			$horas = array(0,0,0,0);
			
			$diaHora = array('');
			$actividadMes = array('');	
			
			$periodo = 0;
			
			$mesesPeriodo = array('','','','','','');
			$mesesPeriodoL = 0;
			$mesesPeriodoV = 0;			
							
			while ($semana = mysqli_fetch_array($result)){					
				if($semana['mes'] == 1 || $semana['mes'] == 6 || $semana['mes'] == 7 || $semana['mes'] == 12){
					switch($semana['idActividad']){
						case 1:	$periodoVacaciones[0]++;
								break;
						case 2:	$periodoVacaciones[1]++;
								break;
						case 3:	$periodoVacaciones[2]++;
								break;
						case 4:	$periodoVacaciones[3]++;
								break;
						case 5:	$periodoVacaciones[4]++;
								break;
						case 6:	$periodoVacaciones[5]++;
								break;								
					}
				}
				else{
					switch($semana['idActividad']){
						case 1:	$periodoLectivo[0]++;
								break;
						case 2:	$periodoLectivo[1]++;
								break;
						case 3:	$periodoLectivo[2]++;
								break;
						case 4:	$periodoLectivo[3]++;
								break;
						case 5:	$periodoLectivo[4]++;
								break;
						case 6:	$periodoLectivo[5]++;
								break;								
					}
				}
				
				
				if($mes <= 6){
					$periodo = 1;
					
					switch($semana['mes']){
						case 1:	$mesesPeriodo[0] = 'X';							
								break;
						case 2:	$mesesPeriodo[1] = 'X';
								break;
						case 3:	$mesesPeriodo[2] = 'X';
								break;
						case 4:	$mesesPeriodo[3] = 'X';
								break;
						case 5:	$mesesPeriodo[4] = 'X';
								break;
						case 6:	$mesesPeriodo[5] = 'X';
								break;									
					}
					
					if($semana['idActividad'] == 4){				
						switch($semana['mes']){
							case 1:	$meses[0]++;										
									break;
							case 2:	$meses[1]++;
									break;
							case 3:	$meses[2]++;
									break;
							case 4:	$meses[3]++;
									break;
							case 5:	$meses[4]++;
									break;
							case 6:	$meses[5]++;	
									break;									
						}
						
						switch($semana['dia']){
							case 1:	$dias[0]++;
									break;
							case 2:	$dias[0]++;
									break;
							case 3:	$dias[0]++;
									break;
							case 4:	$dias[0]++;
									break;
							case 5:	$dias[0]++;
									break;
							case 6:	$dias[1]++;
									break;
							case 7:	$dias[1]++;
									break;					
						}
						
						switch($semana['hora']){
							case 0:	$horas[0]++;
									break;
							case 1:	$horas[0]++;
									break;
							case 2:	$horas[0]++;
									break;
							case 3:	$horas[0]++;
									break;
							case 4:	$horas[0]++;
									break;
							case 5:	$horas[1]++;
									break;
							case 6:	$horas[1]++;
									break;
							case 7:	$horas[1]++;
									break;
							case 8:	$horas[1]++;
									break;
							case 9:	$horas[1]++;
									break;
							case 10:$horas[1]++;
									break;
							case 11:$horas[1]++;
									break;
							case 12:$horas[2]++;
									break;
							case 13:$horas[2]++;
									break;
							case 14:$horas[2]++;
									break;
							case 15:$horas[2]++;
									break;
							case 16:$horas[2]++;
									break;																		
							case 17:$horas[2]++;
									break;
							case 18:$horas[3]++;
									break;	
							case 19:$horas[3]++;
									break;	
							case 20:$horas[3]++;
									break;	
							case 21:$horas[3]++;
									break;	
							case 22:$horas[3]++;
									break;	
							case 23:$horas[3]++;
									break;															
						}
					}
				}
				
				else{
					$periodo = 2;
					
					switch($semana['mes']){
						case 7:	$mesesPeriodo[0] = 'X';
								break;
						case 8:	$mesesPeriodo[1] = 'X';
								break;
						case 9:	$mesesPeriodo[2] = 'X';
								break;
						case 10:$mesesPeriodo[3] = 'X';
								break;
						case 11:$mesesPeriodo[4] = 'X';
								break;
						case 12:$mesesPeriodo[5] = 'X';
								break;										
					}
					
					if($semana['idActividad'] == 4){
						switch($semana['mes']){
							case 7:	$meses[0]++;
									break;
							case 8:	$meses[1]++;
									break;
							case 9:	$meses[2]++;
									break;
							case 10:$meses[3]++;
									break;
							case 11:$meses[4]++;
									break;
							case 12:$meses[5]++;
									break;										
						}
						
						switch($semana['dia']){
							case 1:	$dias[0]++;
									break;
							case 2:	$dias[0]++;
									break;
							case 3:	$dias[0]++;
									break;
							case 4:	$dias[0]++;
									break;
							case 5:	$dias[0]++;
									break;
							case 6:	$dias[1]++;
									break;
							case 7:	$dias[1]++;
									break;					
						}
						
						switch($semana['hora']){
							case 0:	$horas[0]++;
									break;
							case 1:	$horas[0]++;
									break;
							case 2:	$horas[0]++;
									break;
							case 3:	$horas[0]++;
									break;
							case 4:	$horas[0]++;
									break;
							case 5:	$horas[1]++;
									break;
							case 6:	$horas[1]++;
									break;
							case 7:	$horas[1]++;
									break;
							case 8:	$horas[1]++;
									break;
							case 9:	$horas[1]++;
									break;
							case 10:$horas[1]++;
									break;
							case 11:$horas[1]++;
									break;
							case 12:$horas[2]++;
									break;
							case 13:$horas[2]++;
									break;
							case 14:$horas[2]++;
									break;
							case 15:$horas[2]++;
									break;
							case 16:$horas[2]++;
									break;																		
							case 17:$horas[2]++;
									break;
							case 18:$horas[3]++;
									break;	
							case 19:$horas[3]++;
									break;	
							case 20:$horas[3]++;
									break;	
							case 21:$horas[3]++;
									break;	
							case 22:$horas[3]++;
									break;	
							case 23:$horas[3]++;
									break;															
						}
					}
				}
				
				if($semana['mes'] == $mes){
					$diaHora[] = $semana['dia'].'_'.$semana['hora'];	
					$actividadMes[] = $semana['idActividad'];				
				}
			}
			mysqli_free_result($result);				
			
			for($i=0; $i<6; $i++){
				if($i == 0 || $i == 5){
					if($mesesPeriodo[$i] != '')
						$mesesPeriodoV ++;
				}
				else{	
					if($mesesPeriodo[$i] != '')
						$mesesPeriodoL ++;	
				}
			}
			
			if($mesesPeriodoL != 0){
				for($i=0; $i<6; $i++)
					$periodoLectivo[$i] = number_format(($periodoLectivo[$i] / $mesesPeriodoL),0);
			}
			
			if($mesesPeriodoV != 0){
				for($i=0; $i<6; $i++)
					$periodoVacaciones[$i] = number_format(($periodoVacaciones[$i] / $mesesPeriodoV),0);
			}					
			
			$respuesta['periodo'] = $periodo;
			$respuesta['mesesPeriodo'] = $mesesPeriodo;
			
			$respuesta['diaHora'] = $diaHora;	
			$respuesta['actividad'] = $actividadMes;
			
			$respuesta['periodoLectivo1'] = $periodoLectivo;
			$respuesta['periodoVacaciones1'] = $periodoVacaciones;
			
			$respuesta['ml'] = $mesesPeriodoL;
			$respuesta['mv'] = $mesesPeriodoV;
															
			$respuesta['periodoLectivo'] = $periodoLectivo;
			$respuesta['periodoVacaciones'] = $periodoVacaciones;
			
			$respuesta['meses'] = $meses;				
			$respuesta['horas'] = $horas;
			$respuesta['horasTrabajadas'] = $horasTrabajadas;
			
			if($dias[0] != '' && $dias[1] != ''){
				$dias[2] = $dias[0] + $dias[1];
				$dias[0] = 0;
				$dias[1] = 0;
			}
			$respuesta['dias'] = $dias;	
			
			$fechaActualizacion = '';
			$idUser = 0;
			$max = mysqli_fetch_array(Pronino::getInstance()->get_ultima_fecha_actualizacion_mes($idBeneficiario, $mes));
			if($max[0] != NULL){
				$fechaActualizacion = $max[0];	
				$idUser = $max[1];
			}
			
			$respuesta['fechaActualizacion'] = $fechaActualizacion;
			$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
			$respuesta['nombreUser'] = htmlentities($usuario['user']);
		}
										
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']));
		$respuesta['perfil'] = $usuario['tipoUser'];
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 