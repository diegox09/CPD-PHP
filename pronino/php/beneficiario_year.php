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
		$sitioTrabajo = $_GET['sitio_trabajo'];
		$actividadLaboral = $_GET['actividad_laboral'];	
		$actividadEspecifica = utf8_decode($_GET['actividad_especifica']);
		$observaciones = utf8_decode($_GET['observaciones']);
				
		$escuelaFormacion1 = $_GET['escuela_formacion1'];
		$escuelaFormacion2 = $_GET['escuela_formacion2'];
		
		$kitEscolar = explota($_GET['kit_escolar']);
		$kitNutricional = explota($_GET['kit_nutricional']);
		$uniforme = explota($_GET['uniforme']);
		$zapatos = explota($_GET['zapatos']);
		$visitaDomiciliaria = explota($_GET['visita_domiciliaria']);
		$visitaSeguimiento = explota($_GET['visita_seguimiento']);
		$visitaAcademica = explota($_GET['visita_academica']);
		$visitaPsicosocial = explota($_GET['visita_psicosocial']);		
		$intervencionPsicologica = explota($_GET['intervencion_psicologica']);
		$valoracionMedica = explota($_GET['valoracion_medica']);
		$valoracionOdontologica = explota($_GET['valoracion_odontologica']);
		
		$desplazados = $_GET['desplazados'];
		$juntos = $_GET['juntos'];
		$familiasAccion = $_GET['familias_accion'];
		$comedorInfantil = $_GET['comedor_infantil'];		
		
		$idMunicipio = $_GET['id_municipio'];
		$idColegio = $_GET['id_colegio'];	
		$idSedeColegio = $_GET['id_sede'];	
		$grado = $_GET['grado'];
		$seccion = $_GET['seccion'];
		$jornada = $_GET['jornada'];
		//Modificacion
		$actualmenteTrabaja = $_GET['actualmente_trabaja'];
		$problemaSalud = $_GET['problema_salud'];
		$ingresosMes = $_GET['ingresos_mes'];
		$gastaIngresos = $_GET['gasta_ingresos'];
		$ingresosPercibidos = $_GET['ingresos_percibidos'];
		$porqueTrabaja = $_GET['porque_trabaja'];
		$situacionEspecial = $_GET['situacion_especial'];
		$folioUnidos = $_GET['folio_unidos'];
		$escolarizado = $_GET['escolarizado'];
		$ciclo = $_GET['ciclo'];
		
		$idUser = $_SESSION['id_pn'];
		date_default_timezone_set('America/Bogota'); 
		$fechaActual = date('Y-m-d H:i:s');
						
		switch($opc){				
			case 'cargar':	$result = Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year);								
							break;
			case 'eliminar':$consulta = Pronino::getInstance()->delete_beneficiario_mes_by_year($idBeneficiario, $year);	
							if($consulta){
								$consulta = Pronino::getInstance()->delete_beneficiario_nota_by_year($idBeneficiario, $year);	
								if($consulta)
									$consulta = Pronino::getInstance()->delete_beneficiario_year_by_year($idBeneficiario, $year);
							}
							break;										
			case 'guardar':	$result = Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year);
							if(mysqli_num_rows($result) == 0)
								$consulta = Pronino::getInstance()->insert_beneficiario_year($idBeneficiario, $year, $sitioTrabajo, $actividadLaboral, $actividadEspecifica, $observaciones, $idMunicipio, $idColegio, $idSedeColegio, $grado, $jornada, $escuelaFormacion1, $escuelaFormacion2, $desplazados, $juntos, $familiasAccion, $comedorInfantil, $kitEscolar, $uniforme, $zapatos, $visitaDomiciliaria, $visitaPsicosocial, $visitaAcademica, $intervencionPsicologica, $valoracionMedica, $valoracionOdontologica, $idUser, $fechaActual, $seccion, $kitNutricional, $visitaSeguimiento, $actualmenteTrabaja, $problemaSalud, $ingresosMes, $gastaIngresos, $ingresosPercibidos, $porqueTrabaja, $situacionEspecial, $folioUnidos, $escolarizado, $ciclo);
							else
								$consulta = Pronino::getInstance()->update_beneficiario_year($idBeneficiario, $year, $sitioTrabajo, $actividadLaboral, $actividadEspecifica, $observaciones, $idMunicipio, $idColegio, $idSedeColegio, $grado, $jornada, $escuelaFormacion1, $escuelaFormacion2, $desplazados, $juntos, $familiasAccion, $comedorInfantil, $kitEscolar, $uniforme, $zapatos, $visitaDomiciliaria, $visitaPsicosocial, $visitaAcademica, $intervencionPsicologica, $valoracionMedica, $valoracionOdontologica, $idUser, $fechaActual, $seccion, $kitNutricional, $visitaSeguimiento, $actualmenteTrabaja, $problemaSalud, $ingresosMes, $gastaIngresos, $ingresosPercibidos, $porqueTrabaja, $situacionEspecial, $folioUnidos, $escolarizado, $ciclo);								
							$result = Pronino::getInstance()->get_beneficiario_year($idBeneficiario, $year);								
							break;										
			default:		$result = false;
							break;			
		}		
		
		if($opc != 'eliminar'){	
			if(mysqli_num_rows($result) == 0)	
				$consulta = false;
				
			else{				
				$programa = mysqli_fetch_array($result);
				$respuesta['sitioTrabajo'] = $programa['sitioTrabajo'];
				$respuesta['actividadLaboral'] = $programa['actividadLaboral'];
				$respuesta['actividadEspecifica'] = utf8_encode($programa['actividadEspecifica']);
				$respuesta['observaciones'] = utf8_encode($programa['observaciones']);
				
				$respuesta['escuelaFormacion1'] = $programa['escuelaFormacion1'];
				$respuesta['escuelaFormacion2'] = $programa['escuelaFormacion2'];
								
				$respuesta['kitEscolar'] = implota($programa['kitEscolar']);
				$respuesta['kitNutricional'] = implota($programa['kitNutricional']);
				$respuesta['uniforme'] = implota($programa['uniforme']);
				$respuesta['zapatos'] = implota($programa['zapatos']);
				$respuesta['visitaDomiciliaria'] = implota($programa['visitaDomiciliaria']);
				$respuesta['visitaSeguimiento'] = implota($programa['visitaSeguimiento']);
				$respuesta['visitaAcademica'] = implota($programa['visitaAcademica']);
				$respuesta['visitaPsicosocial'] = implota($programa['visitaPsicosocial']);				
				$respuesta['intervencionPsicologica'] = implota($programa['intervencionPsicologica']);
				$respuesta['valoracionMedica'] = implota($programa['valoracionMedica']);
				$respuesta['valoracionOdontologica'] = implota($programa['valoracionOdontologica']);				
								
				$respuesta['desplazados'] = $programa['desplazados'];
				$respuesta['juntos'] = $programa['juntos'];				
				$respuesta['familiasAccion'] = $programa['familiasAccion'];				
				$respuesta['comedorInfantil'] = $programa['comedorInfantil'];
				
				$respuesta['grado'] = $programa['grado'];
				$respuesta['seccion'] = $programa['seccion'];
				$respuesta['jornada'] = $programa['jornada'];
				//Modificacion
				$respuesta['actualmenteTrabaja'] = $programa['actualmenteTrabaja'];
				$respuesta['problemaSalud'] = $programa['problemaSalud'];
				$respuesta['ingresosMes'] = $programa['ingresosMes'];
				$respuesta['gastaIngresos'] = $programa['gastaIngresos'];
				$respuesta['ingresosPercibidos'] = $programa['ingresosPercibidos'];
				$respuesta['porqueTrabaja'] = $programa['porqueTrabaja'];
				$respuesta['situacionEspecial'] = $programa['situacionEspecial'];
				$respuesta['folioUnidos'] = $programa['folioUnidos'];
				$respuesta['escolarizado'] = $programa['escolarizado'];
				$respuesta['ciclo'] = $programa['ciclo'];

				$respuesta['idMunicipio'] = $programa['idMunicipioColegio'];
				$respuesta['idColegio'] = $programa['idColegio'];
				$idSedeColegio = $programa['idSedeColegio'];
				$respuesta['idSedeColegio'] = $idSedeColegio;				
				$respuesta['nombreCoordinador'] = '';
				if($idSedeColegio != 0){								
					$sede = mysqli_fetch_array(Pronino::getInstance()->get_sede_by_id($idSedeColegio));	
					$respuesta['coordinador'] = $sede['nombreCoordinador'];	
				}
				
				$respuesta['fechaActualizacion'] = $programa['fechaActualizacion'];					
				$idUser = $programa['idUser'];
				
				$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));					
				$respuesta['nombreUser'] = htmlentities($usuario['user']);
			}
			mysqli_free_result($result);
		}
										
		$respuesta['opc'] = $opc;
		$respuesta['consulta'] = $consulta;
		
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($_SESSION['id_pn']));
		$respuesta['perfil'] = $usuario['tipoUser'];				
	}		
		
	$respuesta['login'] = $logonSuccess;		
	print_r(json_encode($respuesta));	
?> 