<?php
class Humanitaria extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
	

    private $user = 'diegox09';
    private $passwd = 'sputnik_86';
    private $dbName = 'cpd_hu';
    private $dbHost = 'localhost';
	
	/*
	Tipo de Usuario
	1. Consultas
	2. Entregas
	3. Administrador
	*/

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->passwd, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error ('. mysqli_connect_errno() .') '. mysqli_connect_error());
        }
        //parent::set_charset('utf-8');
    }
	/*Usuario*/
	public function get_user($user, $passwd) { 
		$user = $this->real_escape_string($user);      
		$passwd = $this->real_escape_string($passwd);      
        return $this->query('SELECT * FROM usuario WHERE user = "'.$user.'" AND passwd = "'.$passwd.'"');
    }
	
	public function get_user_by_id($idUser) { 
        return $this->query('SELECT * FROM usuario WHERE id_user = "'.$idUser.'"');
    }
	
	/*Damnificado*/
	public function get_damnificados(){			
        return $this->query('SELECT * FROM damnificado WHERE observaciones = "JUEVES - SAN RAFAEL"');
    }
		
	public function get_damnificado_by_nombre($buscar){
		$buscar = $this->real_escape_string($buscar);			
        return $this->query('SELECT id_damnificado, documento_damnificado, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM damnificado WHERE CONCAT(primer_nombre," ",segundo_nombre," ",primer_apellido," ",segundo_apellido) LIKE "%'.$buscar.'%" OR CONCAT(primer_nombre," ",primer_apellido) LIKE "%'.$buscar.'%" ORDER BY primer_nombre, segundo_nombre, primer_apellido, segundo_apellido LIMIT 100');
    }
	
	public function get_damnificado_by_documento($documentoDamnificado){
		$documentoDamnificado = $this->real_escape_string($documentoDamnificado);			
        return $this->query('SELECT * FROM damnificado WHERE documento_damnificado = "'.$documentoDamnificado.'"');
    }	
	
	public function get_damnificado_by_id($idDamnificado){			
        return $this->query('SELECT * FROM damnificado WHERE id_damnificado = "'.$idDamnificado.'"');
    }
	
	public function get_damnificado_by_nombre_arrendador($buscar){
		$buscar = $this->real_escape_string($buscar);			
        return $this->query('SELECT DISTINCT damnificado.id_damnificado, damnificado.documento_damnificado, damnificado.primer_nombre, damnificado.segundo_nombre, damnificado.primer_apellido, damnificado.segundo_apellido, arrendador.documento_arrendador, arrendador.nombre_arrendador FROM arrendador, arriendo_damnificado, damnificado WHERE arrendador.nombre_arrendador LIKE "%'.$buscar.'%" AND arrendador.id_arrendador = arriendo_damnificado.id_arrendador AND arriendo_damnificado.id_damnificado = damnificado.id_damnificado ORDER BY arrendador.nombre_arrendador, damnificado.primer_nombre, damnificado.segundo_nombre, damnificado.primer_apellido, damnificado.segundo_apellido LIMIT 50');
    }
	
	public function get_damnificado_by_documento_arrendador($documentoArrendador){
		$documentoArrendador = $this->real_escape_string($documentoArrendador);			
        return $this->query('SELECT DISTINCT damnificado.id_damnificado, damnificado.documento_damnificado, damnificado.primer_nombre, damnificado.segundo_nombre, damnificado.primer_apellido, damnificado.segundo_apellido, arrendador.documento_arrendador, arrendador.nombre_arrendador FROM arrendador, arriendo_damnificado, damnificado WHERE arrendador.documento_arrendador = "'.$documentoArrendador.'" AND arrendador.id_arrendador = arriendo_damnificado.id_arrendador AND arriendo_damnificado.id_damnificado = damnificado.id_damnificado ORDER BY arrendador.nombre_arrendador, damnificado.primer_nombre, damnificado.segundo_nombre, damnificado.primer_apellido, damnificado.segundo_apellido');
    }
	
	public function get_arrendador_by_documento_damnificado($documentoDamnificado, $fase){
		$documentoDamnificado = $this->real_escape_string($documentoDamnificado);			
        return $this->query('SELECT * FROM arrendador, arriendo_damnificado WHERE arrendador.documento_arrendador = "'.$documentoDamnificado.'" AND arrendador.id_arrendador = arriendo_damnificado.id_arrendador AND arriendo_damnificado.id_periodo = "'.$fase.'"');
    }
	
	public function get_arriendo_by_damnificado($idDamnificado, $fase){			
        return $this->query('SELECT * FROM arriendo_damnificado WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
    }
	
	public function get_entregas_by_damnificado($idDamnificado, $fase){			
        return $this->query('SELECT * FROM entregas_damnificado WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
    }
	
	public function get_reparacion_by_damnificado($idDamnificado, $fase){			
        return $this->query('SELECT * FROM reparacion_damnificado WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
    }
	
	public function insert_damnificado($documentoDamnificado, $fechaActual, $idUser){
		$documentoDamnificado = $this->real_escape_string($documentoDamnificado);
        return $this->query('INSERT INTO damnificado (documento_damnificado, fecha, id_usuario) VALUES("'.$documentoDamnificado.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function insert_arriendo($idDamnificado, $fase, $fechaActual, $idUser){
        return $this->query('INSERT INTO arriendo_damnificado (id_damnificado, id_periodo, fecha, id_usuario) VALUES("'.$idDamnificado.'", "'.$fase.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function insert_entregas($idDamnificado, $fase, $fechaActual, $idUser){
        return $this->query('INSERT INTO entregas_damnificado (id_damnificado, id_periodo, fecha, id_usuario) VALUES("'.$idDamnificado.'", "'.$fase.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function insert_reparacion($idDamnificado, $fase, $fechaActual, $idUser){
        return $this->query('INSERT INTO reparacion_damnificado (id_damnificado, id_periodo, fecha, id_usuario) VALUES("'.$idDamnificado.'", "'.$fase.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_damnificado($idDamnificado, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $genero, $td, $documentoDamnificado, $direccion, $barrio, $telefono, $observaciones, $fechaActual, $idUser){			
		$primerNombre = $this->real_escape_string($primerNombre);	
		$segundoNombre = $this->real_escape_string($segundoNombre);	
		$primerApellido = $this->real_escape_string($primerApellido);	
		$segundoApellido = $this->real_escape_string($segundoApellido);	
		$documentoDamnificado = $this->real_escape_string($documentoDamnificado);	
		$direccion = $this->real_escape_string($direccion);	
		$barrio = $this->real_escape_string($barrio);
		$telefono = $this->real_escape_string($telefono);		
		$observaciones = $this->real_escape_string($observaciones);	
       	return $this->query('UPDATE damnificado SET primer_nombre = "'.$primerNombre.'", segundo_nombre = "'.$segundoNombre.'", primer_apellido = "'.$primerApellido.'", segundo_apellido = "'.$segundoApellido.'", genero = "'.$genero.'", td = "'.$td.'", documento_damnificado = "'.$documentoDamnificado.'", direccion = "'.$direccion.'", barrio = "'.$barrio.'", telefono = "'.$telefono.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'"');
    }
	
	public function update_entregas($idDamnificado, $fase, $ficho, $fechaKitAseo, $fechaMercado1, $fechaMercado2, $fechaMercado3, $fechaMercado4, $estado, $observaciones, $fechaActual, $idUser){
		$ficho = $this->real_escape_string($ficho);
		$fechaKitAseo = $this->real_escape_string($fechaKitAseo);	
		$$fechaMercado1 = $this->real_escape_string($fechaMercado1);	
		$fechaMercado2 = $this->real_escape_string($fechaMercado2);	
		$fechaMercado3 = $this->real_escape_string($fechaMercado3);	
		$fechaMercado4 = $this->real_escape_string($fechaMercado4);
		$observaciones = $this->real_escape_string($observaciones);
		if($ficho == '')	
			return $this->query('UPDATE entregas_damnificado SET ficho = NULL, fecha_kit_aseo = "'.$fechaKitAseo.'", fecha_mercado1 = "'.$fechaMercado1.'", fecha_mercado2 = "'.$fechaMercado2.'", fecha_mercado3 = "'.$fechaMercado3.'", fecha_mercado4 = "'.$fechaMercado4.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
		else	
       		return $this->query('UPDATE entregas_damnificado SET ficho = "'.$ficho.'", fecha_kit_aseo = "'.$fechaKitAseo.'", fecha_mercado1 = "'.$fechaMercado1.'", fecha_mercado2 = "'.$fechaMercado2.'", fecha_mercado3 = "'.$fechaMercado3.'", fecha_mercado4 = "'.$fechaMercado4.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
	}
	
	public function update_arriendo($idDamnificado, $fase, $idArrendador, $comprobante, $fechaArriendo, $estado, $observaciones, $fechaActual, $idUser){
		$comprobante = $this->real_escape_string($comprobante);
		$fechaArriendo = $this->real_escape_string($fechaArriendo);	
		$observaciones = $this->real_escape_string($observaciones);
		if($comprobante == '')	
			return $this->query('UPDATE arriendo_damnificado SET id_arrendador = "'.$idArrendador.'", comprobante = NULL, fecha_arriendo = "'.$fechaArriendo.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
		else	
       		return $this->query('UPDATE arriendo_damnificado SET id_arrendador = "'.$idArrendador.'", comprobante = "'.$comprobante.'", fecha_arriendo = "'.$fechaArriendo.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
	}
	
	public function update_arriendo2($idDamnificado, $fase, $idArrendador, $comprobante, $cheque, $fechaArriendo, $estado, $observaciones, $fechaActual, $idUser){
		$comprobante = $this->real_escape_string($comprobante);
		$cheque = $this->real_escape_string($cheque);
		$fechaArriendo = $this->real_escape_string($fechaArriendo);	
		$observaciones = $this->real_escape_string($observaciones);
		if($comprobante == '')	
			return $this->query('UPDATE arriendo_damnificado SET id_arrendador = "'.$idArrendador.'", comprobante = NULL, cheque = "'.$cheque.'", fecha_arriendo = "'.$fechaArriendo.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
		else	
       		return $this->query('UPDATE arriendo_damnificado SET id_arrendador = "'.$idArrendador.'", comprobante = "'.$comprobante.'",  cheque = "'.$cheque.'", fecha_arriendo = "'.$fechaArriendo.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
	}	
	
	public function update_comprobante($idDamnificado, $fase, $comprobante, $cheque, $fechaActual, $idUser){
		$comprobante = $this->real_escape_string($comprobante);
		$cheque = $this->real_escape_string($cheque);
		if($comprobante == '')	
			return $this->query('UPDATE arriendo_damnificado SET comprobante = NULL, cheque = "'.$cheque.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
		else	
       		return $this->query('UPDATE arriendo_damnificado SET comprobante = "'.$comprobante.'", cheque = "'.$cheque.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
	}	


	public function update_reparacion($idDamnificado, $fase, $comprobante, $fechaReparacion, $estado, $observaciones, $fechaActual, $idUser){
		$comprobante = $this->real_escape_string($comprobante);
		$fechaArriendo = $this->real_escape_string($fechaArriendo);	
		$observaciones = $this->real_escape_string($observaciones);
		if($comprobante == '')	
       		return $this->query('UPDATE reparacion_damnificado SET comprobante = NULL, fecha_reparacion = "'.$fechaReparacion.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
		else	
			return $this->query('UPDATE reparacion_damnificado SET comprobante = "'.$comprobante.'", fecha_reparacion = "'.$fechaReparacion.'", id_estado = "'.$estado.'", observaciones = "'.$observaciones.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
	}
	
	public function delete_arriendo($idDamnificado, $fase){
        return $this->query('DELETE FROM arriendo_damnificado WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
    }
	
	public function delete_entregas($idDamnificado, $fase){
        return $this->query('DELETE FROM entregas_damnificado WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
    }
	
	public function delete_reparacion($idDamnificado, $fase){
        return $this->query('DELETE FROM reparacion_damnificado WHERE id_damnificado = "'.$idDamnificado.'" AND id_periodo = "'.$fase.'"');
    }
	
	/*Arrendador*/	
	public function get_arrendador_by_id($idArrendador){			
        return $this->query('SELECT * FROM arrendador WHERE id_arrendador = "'.$idArrendador.'"');
    }
	
	public function get_arrendador_by_documento($documentoArrendador){			
        return $this->query('SELECT * FROM arrendador WHERE documento_arrendador = "'.$documentoArrendador.'"');
    }
	
	public function get_entregas_damnificado_by_documento_arrendador($documentoArrendador, $fase){
		$documentoArrendador = $this->real_escape_string($documentoArrendador);			
        return $this->query('SELECT * FROM damnificado, entregas_damnificado WHERE damnificado.documento_damnificado = "'.$documentoArrendador.'" AND damnificado.id_damnificado = entregas_damnificado.id_damnificado AND entregas_damnificado.id_periodo = "'.$fase.'"');
    }
	
	public function get_arriendo_damnificado_by_documento_arrendador($documentoArrendador, $fase){
		$documentoArrendador = $this->real_escape_string($documentoArrendador);			
        return $this->query('SELECT * FROM damnificado, arriendo_damnificado WHERE damnificado.documento_damnificado = "'.$documentoArrendador.'" AND damnificado.id_damnificado = arriendo_damnificado.id_damnificado AND arriendo_damnificado.id_periodo = "'.$fase.'"');
    }
	
	public function insert_arrendador($documentoArrendador, $fechaActual, $idUser){
		$documentoArrendador = $this->real_escape_string($documentoArrendador);
        return $this->query('INSERT INTO arrendador (documento_arrendador, fecha, id_usuario) VALUES("'.$documentoArrendador.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_arrendador($idArrendador, $nombre, $documentoArrendador, $direccion, $telefono, $fechaActual, $idUser){			
		$nombre = $this->real_escape_string($nombre);
		$documentoArrendador = $this->real_escape_string($documentoArrendador);	
		$direccion = $this->real_escape_string($direccion);	
		$telefono = $this->real_escape_string($telefono);
       	return $this->query('UPDATE arrendador SET nombre_arrendador = "'.$nombre.'", documento_arrendador = "'.$documentoArrendador.'", direccion_arrendador = "'.$direccion.'", telefono_arrendador = "'.$telefono.'", fecha = "'.$fechaActual.'", id_usuario = "'.$idUser.'"  WHERE id_arrendador = "'.$idArrendador.'"');
    }
	
	/*Repetidos*/	
	public function get_damnificados_repetidos($documentoDamnificado, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido){
		$documentoDamnificado = $this->real_escape_string($documentoDamnificado);
		$primerNombre = $this->real_escape_string($primerNombre);	
		$segundoNombre = $this->real_escape_string($segundoNombre);	
		$primerApellido = $this->real_escape_string($primerApellido);	
		$segundoApellido = $this->real_escape_string($segundoApellido);				
        return $this->query('SELECT * FROM damnificado WHERE damnificado.documento_damnificado != "'.$documentoDamnificado.'" AND (damnificado.primer_nombre LIKE "%'.$primerNombre.'%" OR damnificado.segundo_nombre LIKE "%'.$segundoNombre.'%" OR damnificado.primer_apellido LIKE "%'.$primerApellido.'%" OR damnificado.segundo_apellido LIKE "%'.$segundoApellido.'%") ORDER BY primer_nombre, segundo_nombre, primer_apellido, segundo_apellido');
    }	
	
	/*Arriendos*/	
	public function get_arriendos_by_fase($fase){				
        return $this->query('SELECT id_damnificado FROM arriendo_damnificado WHERE id_periodo = "'.$fase.'"');
    }
	
	public function get_arriendos_atendidos_by_fase($fase){				
        return $this->query('SELECT id_damnificado FROM arriendo_damnificado WHERE fecha_arriendo != "0000-00-00" AND id_periodo = "'.$fase.'"');
    }
	
	public function get_fechas_arriendos_by_fase($fase){				
        return $this->query('SELECT DISTINCT fecha_arriendo FROM arriendo_damnificado WHERE fecha_arriendo != "0000-00-00" AND id_periodo = "'.$fase.'" ORDER BY fecha_arriendo');
    }
	
	public function get_arriendos_by_fase_fecha($fase, $fecha){				
        return $this->query('SELECT * FROM arriendo_damnificado WHERE fecha_arriendo = "'.$fecha.'" AND id_periodo = "'.$fase.'"');
    }
	
	/*Entregas*/
	public function get_entregas_by_fase($fase){			
        return $this->query('SELECT id_damnificado FROM entregas_damnificado WHERE id_periodo = "'.$fase.'"');
    }
	
	public function get_entregas_atendidas_by_fase($fase){			
        return $this->query('SELECT id_damnificado FROM entregas_damnificado WHERE (fecha_kit_aseo != "0000-00-00" OR fecha_mercado1 != "0000-00-00" OR fecha_mercado2 != "0000-00-00" OR fecha_mercado3 != "0000-00-00" OR fecha_mercado4 != "0000-00-00") AND id_periodo = "'.$fase.'"');
    }
	
	public function get_entregas_by_fase_fecha($fase, $fecha){			
        return $this->query('SELECT id_damnificado FROM entregas_damnificado WHERE (fecha_mercado1 = "'.$fecha.'" OR fecha_mercado2 = "'.$fecha.'" OR fecha_mercado3 = "'.$fecha.'" OR fecha_mercado4 = "'.$fecha.'" OR fecha_kit_aseo = "'.$fecha.'") AND id_periodo = "'.$fase.'"');
    }
	
	/*Kits*/
	public function get_fechas_kits_aseo_by_fase($fase){				
        return $this->query('SELECT DISTINCT fecha_kit_aseo FROM entregas_damnificado WHERE fecha_kit_aseo != "0000-00-00" AND id_periodo = "'.$fase.'" ORDER BY fecha_kit_aseo');
    }
	
	public function get_kits_aseo_by_fase_fecha($fase, $fecha){				
        return $this->query('SELECT * FROM entregas_damnificado WHERE fecha_kit_aseo = "'.$fecha.'" AND id_periodo = "'.$fase.'"');
    }
	
	/*Mercados*/
	public function get_fechas_mercados_by_fase($fase){				
        return $this->query('SELECT * FROM entregas_damnificado WHERE (fecha_mercado1 != "0000-00-00" OR fecha_mercado2 != "0000-00-00" OR fecha_mercado3 != "0000-00-00" OR fecha_mercado4 != "0000-00-00") AND id_periodo = "'.$fase.'"');
    }
	
	public function get_mercados_by_fase_fecha($fase, $fecha){						
        return $this->query('SELECT * FROM entregas_damnificado WHERE (fecha_mercado1 = "'.$fecha.'" OR fecha_mercado2 = "'.$fecha.'" OR fecha_mercado3 = "'.$fecha.'" OR fecha_mercado4 = "'.$fecha.'") AND id_periodo = "'.$fase.'"');
    }
	
	/*Reparaciones*/	
	public function get_reparaciones_by_fase($fase){				
        return $this->query('SELECT id_damnificado FROM reparacion_damnificado WHERE id_periodo = "'.$fase.'"');
    }
	
	public function get_reparaciones_atendidas_by_fase($fase){				
        return $this->query('SELECT id_damnificado FROM reparacion_damnificado WHERE fecha_reparacion != "0000-00-00" AND id_periodo = "'.$fase.'"');
    }
	
	public function get_fechas_reparaciones_by_fase($fase){				
        return $this->query('SELECT DISTINCT fecha_reparacion FROM reparacion_damnificado WHERE fecha_reparacion != "0000-00-00" AND id_periodo = "'.$fase.'" ORDER BY fecha_reparacion');
    }
	
	public function get_reparaciones_by_fase_fecha($fase, $fecha){				
        return $this->query('SELECT * FROM reparacion_damnificado WHERE fecha_reparacion = "'.$fecha.'" AND id_periodo = "'.$fase.'"');
    }
	
	/*Formato 1016*/
	public function get_entregas(){			
        return $this->query('SELECT DISTINCT id_damnificado FROM entregas_damnificado');
    }
	
	public function get_entregas_damnificado($idDamnificado){			
        return $this->query('SELECT * FROM entregas_damnificado WHERE id_damnificado = "'.$idDamnificado.'" ORDER BY id_periodo');
    }
	
	public function get_arriendos_damnificado($idDamnificado){			
        return $this->query('SELECT * FROM arriendo_damnificado, arrendador WHERE arriendo_damnificado.id_damnificado = "'.$idDamnificado.'" AND arriendo_damnificado.id_arrendador = arrendador.id_arrendador ORDER BY arriendo_damnificado.id_periodo');
    }
	
	public function get_arriendos(){			
        return $this->query('SELECT DISTINCT id_arrendador FROM arriendo_damnificado');
    }
	
	public function get_arriendos_arrendador($idArrendador){			
        return $this->query('SELECT * FROM arriendo_damnificado WHERE id_arrendador = "'.$idArrendador.'" ORDER BY id_periodo');
    }
	
	public function get_1016(){			
		return $this->query('SELECT DISTINCT entregas_damnificado.id_damnificado FROM entregas_damnificado, arriendo_damnificado WHERE entregas_damnificado.id_damnificado = arriendo_damnificado.id_damnificado');
	}
}
?>
