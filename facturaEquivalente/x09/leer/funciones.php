<?
// bd2local
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
function explota($fecha){
	$vector_fecha = explode("/",$fecha);
	$aux = $vector_fecha[2];
	$vector_fecha[2] = $vector_fecha[0];
	$vector_fecha[0] = $aux;
	return implode("-",$vector_fecha);
}

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
