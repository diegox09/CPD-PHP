<?
// bd2local
// =FECHANUMERO("")
function implota($fecha){
	if (($fecha == "") || ($fecha == "0000-00-00"))
		return "";
	$vector_fecha = explode("-",$fecha);
	$aux = $vector_fecha[2];
	$vector_fecha[2] = $vector_fecha[0];
	$vector_fecha[0] = $aux;
	return implode("/",$vector_fecha);
}

// local2bd
// =TEXTO("";"dd/mm/yyyy")
function explota($fecha){
	$vector_fecha = explode("/",$fecha);
	$aux = $vector_fecha[2];
	$vector_fecha[2] = $vector_fecha[0];
	$vector_fecha[0] = $aux;
	return implode("-",$vector_fecha);
}

// edad
function edad($fecha){
	if(($fecha == "") || ($fecha == "0000-00-00"))
		return "";
		
	$fecha = explode("-",$fecha);		
	$year = date('Y');
	$mes = date('m');
	$dia = date('d');
 	 
   	//resto los años de las dos fechas 
   	$edad = $year - $fecha[0] - 1; //-1 porque no se si ha cumplido años ya este año 

   	//si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido 
   	if($mes - $fecha[1] < 0)
      	return $edad;
   	if($mes - $fecha[1] > 0){ 
      	$edad = $edad + 1; 	
      	return $edad;
	}

   	//entonces es que eran iguales. miro los dias 
   	//si resto los dias y me da menor que 0 entonces no ha cumplido años. Si da mayor o igual si ha cumplido 
   	if($dia - $fecha[2] >= 0){ 
		$edad = $edad + 1; 	
      	return $edad;
	}

   	return $edad;
}

// cortar
function cortar($cadena, $limite, $separador) {	
	if(strlen($cadena) <= $limite)
		return $cadena;
	
	// is $separador present between $limit and the end of the string? 
	if(false !== ($punto_separador = strpos($cadena, $separador, $limite))) {
		if($punto_separador < strlen($cadena))
			$cadena = substr($cadena, 0, $punto_separador);
	}
	
	if(strlen($cadena) > $limite){
		$punto_separador = strrpos($cadena, $separador);
		$cadena = substr($cadena, 0, $punto_separador);
	}
	
	return $cadena;	
}
?>
