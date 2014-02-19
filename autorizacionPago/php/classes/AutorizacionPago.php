<?php
class AutorizacionPago extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
	
	private $user = 'diegox09';
    private $passwd = 'sputnik_86';
    private $dbName = 'cpd_ap';
    private $dbHost = 'localhost';

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
		
	public function verify_credentials($user, $passwd) {
        $user = $this->real_escape_string($user);
        $passwd = $this->real_escape_string($passwd);
        $result = $this->query('SELECT 1 FROM usuario WHERE user = "'.$user.'" AND passwd = "'.$passwd.'"');
        return $result->data_seek(0);
	}	
	
	public function verify_passwd($idUser, $passwd) {
        $passwd = $this->real_escape_string($passwd);
        $result = $this->query('SELECT 1 FROM usuario WHERE idUser = "'.$idUser.'" AND passwd = "'.$passwd.'"');
        return $result->data_seek(0);
	}	
		
	public function get_passwd_by_user($user) {     
		$usuario = $this->real_escape_string($user);      
        return $this->query('SELECT * FROM usuario, persona WHERE user = "'.$user.'" AND persona.idPersona = usuario.idUser');
    }	
	
	public function get_id_user($user) {
        $user = $this->real_escape_string($user);
        $user = $this->query('SELECT idUser FROM usuario WHERE user = "'.$user.'"');
        if ($user->num_rows > 0){
            $row = $user->fetch_row();
            return $row[0];
        } else
            return null;
    }
	
	public function get_verificar_user($idUser) {       
        return $this->query('SELECT * FROM usuario, usuario_programa WHERE usuario.idUser = "'.$idUser.'" AND usuario_programa.idUser = "'.$idUser.'" LIMIT 1');
    }
		
	public function get_user() {       
        return $this->query('SELECT persona.* FROM usuario, persona WHERE usuario.idUser = persona.idPersona ORDER BY persona.nombre');
    }
	
	public function get_user_by_id($idUser) {       
        return $this->query('SELECT * FROM usuario, persona WHERE usuario.idUser = "'.$idUser.'" AND persona.idPersona = usuario.idUser');
    }	
	
	public function get_verificar_user_by_programa($idUser, $idPrograma) {       
        return $this->query('SELECT * FROM usuario_programa, persona WHERE usuario_programa.idUser = "'.$idUser.'" AND usuario_programa.idPrograma = "'.$idPrograma.'" AND usuario_programa.idUser = persona.idPersona ORDER BY persona.nombre');
    }
		
	public function get_user_by_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT persona.* FROM usuario, persona WHERE usuario.idUser = persona.idPersona AND nombre = "'.$nombre.'"');
    }
	
	public function get_buscar_user_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT persona.* FROM usuario, persona WHERE usuario.idUser = persona.idPersona AND persona.nombre LIKE "%'.$nombre.'%" ORDER BY persona.nombre');
    }	
					
	public function get_menu_user_by_perfil($idPerfil) {       
        return $this->query('SELECT submenu.descripcion, item_submenu.descripcion, item_submenu.iniciales FROM menu, submenu, item_submenu  WHERE menu.idPerfil = "'.$idPerfil.'" AND menu.idSubmenu = submenu.idSubmenu AND menu.idItem = item_submenu.idItem ORDER BY submenu.idSubmenu, item_submenu.idItem');
    }
	
	public function get_administrador() {       
        return 3;
    }
	
	public function get_administrador_ap() {       
        return 1;
    }
	
	public function change_passwd($idUser, $email, $passwd) {
        $email = $this->real_escape_string($email);		
		$passwd = $this->real_escape_string($passwd);
        return $this->query('UPDATE usuario SET emailUser = "'.$email.'", passwd = "'.$passwd.'" WHERE idUser = "'.$idUser.'"');
    }
	
	public function insert_user($idUser, $user, $user, $idPerfil, $idMunicipio) {        
		$user = $this->real_escape_string($user);
        return $this->query('INSERT INTO usuario (idUser, user, passwd, idPerfil, idMunicipio) VALUES("'.$idUser.'", "'.$user.'", "'.$user.'", "'.$idPerfil.'", "'.$idMunicipio.'")');
    }
	
	public function insert_user_programa($idUser, $idPrograma) { 
        return $this->query('INSERT INTO usuario_programa (idUser, idPrograma) VALUES("'.$idUser.'", "'.$idPrograma.'")');
    }
	
	public function update_user($idUser, $user, $idPerfil, $idMunicipio) {        
		$user = $this->real_escape_string($user);
        return $this->query('UPDATE usuario SET user = "'.$user.'", idPerfil = "'.$idPerfil.'", idMunicipio = "'.$idMunicipio.'" WHERE idUser = "'.$idUser.'"');
    }
	
	public function delete_user($idUser) {
        return $this->query('DELETE FROM usuario WHERE idUser = "'.$idUser.'"');
    }
	
	public function delete_user_programa($idUser, $idPrograma) {
        return $this->query('DELETE FROM usuario_programa WHERE idUser = "'.$idUser.'" AND idPrograma = "'.$idPrograma.'"');
    }
	
	//Perfil
	public function get_perfil() {		
        return $this->query('SELECT * FROM perfil ORDER BY descripcion');
    }	
	
	//Departamento
	public function get_verificar_departamento($idDepartamento) {		
        return $this->query('SELECT * FROM municipio WHERE idDepartamento = "'.$idDepartamento.'" ORDER BY nombre');
    }
	
	public function get_departamento() {		
        return $this->query('SELECT * FROM departamento ORDER BY nombre');
    }			
	
	public function get_departamento_by_id($idDepartamento) {		
        return $this->query('SELECT * FROM departamento WHERE idDepartamento = "'.$idDepartamento.'"');
    }
	
	public function get_departamento_by_nombre($nombre) {	
		$nombre = $this->real_escape_string($nombre);	
        return $this->query('SELECT * FROM departamento WHERE nombre = "'.$nombre.'"');
    }
	
	public function get_buscar_departamento($nombre) {	
		$nombre = $this->real_escape_string($nombre);	
        return $this->query('SELECT * FROM departamento WHERE nombre LIKE "%'.$nombre.'%"');
    }
	
	public function insert_departamento($nombre) {
		$nombre = $this->real_escape_string($nombre);
        return $this->query('INSERT INTO departamento (nombre) VALUES("'.$nombre.'")');
    }
		
	public function update_departamento($idDepartamento, $nombre) {	
		$nombre = $this->real_escape_string($nombre);	
       	return $this->query('UPDATE departamento SET nombre = "'.$nombre.'" WHERE idDepartamento = "'.$idDepartamento.'"');
    }
	
	public function delete_departamento($idDepartamento) {
        return $this->query('DELETE FROM departamento WHERE idDepartamento = "'.$idDepartamento.'"');
    }
	
	//Municipio
	public function get_verificar_municipio($idMunicipio) {       
        return $this->query('SELECT * FROM usuario, responsable, barrio, programa, autorizacion_pago WHERE usuario.idMunicipio = "'.$idMunicipio.'" OR responsable.idMunicipio = "'.$idMunicipio.'" OR barrio.idMunicipio = "'.$idMunicipio.'" OR programa.idMunicipio = "'.$idMunicipio.'" OR autorizacion_pago.idMunicipio = "'.$idMunicipio.'" LIMIT 1');
    }
	
	public function get_municipio() {		
        return $this->query('SELECT * FROM municipio ORDER BY nombre');
    }			
	
	public function get_municipio_by_id($idMunicipio) {		
        return $this->query('SELECT * FROM municipio WHERE idMunicipio = "'.$idMunicipio.'"');
    }
	
	public function get_municipio_by_departamento($idDepartamento) {		
        return $this->query('SELECT * FROM municipio WHERE idDepartamento = "'.$idDepartamento.'" ORDER BY nombre');
    }
	
	public function get_municipio_by_nombre($nombre) {	
		$nombre = $this->real_escape_string($nombre);	
        return $this->query('SELECT * FROM municipio WHERE nombre = "'.$nombre.'"');
    }
	
	public function get_buscar_municipio($nombre) {	
		$nombre = $this->real_escape_string($nombre);	
        return $this->query('SELECT * FROM municipio WHERE nombre LIKE "%'.$nombre.'%"');
    }

	public function insert_municipio($idDepartamento, $nombre) {
		$nombre = $this->real_escape_string($nombre);
        return $this->query('INSERT INTO municipio (idDepartamento, nombre) VALUES("'.$idDepartamento.'", "'.$nombre.'")');
    }
		
	public function update_municipio($idMunicipio, $idDepartamento, $nombre) {
		$nombre = $this->real_escape_string($nombre);		
       	return $this->query('UPDATE municipio SET idDepartamento = "'.$idDepartamento.'", nombre = "'.$nombre.'" WHERE idMunicipio = "'.$idMunicipio.'"');
    }
	
	public function delete_municipio($idMunicipio) {
        return $this->query('DELETE FROM municipio WHERE idMunicipio = "'.$idMunicipio.'"');
    }	
	
	//Programa
	public function get_verificar_programa($idPrograma) {       
        return $this->query('SELECT * FROM autorizacion_pago WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	public function get_programa() {		
        return $this->query('SELECT * FROM programa ORDER BY nombre');
    }			
	
	public function get_programa_by_id($idPrograma) {		
        return $this->query('SELECT * FROM programa WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	public function get_programa_by_user($idUser) {		
        return $this->query('SELECT programa.* FROM usuario_programa, programa WHERE usuario_programa.idUser = "'.$idUser.'" AND usuario_programa.idPrograma = programa.idPrograma ORDER BY programa.nombre');
    }
	
	public function get_programa_by_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT * FROM programa WHERE nombre = "'.$nombre.'"');
    }
	
	public function get_buscar_programa($nombre) {	
		$nombre = $this->real_escape_string($nombre);	
        return $this->query('SELECT * FROM programa WHERE nombre LIKE "%'.$nombre.'%"');
    }
	
	public function insert_programa($nombre, $descripcion, $idMunicipio) {
		$nombre = $this->real_escape_string($nombre);
        return $this->query('INSERT INTO programa (nombre, descripcion, idMunicipio) VALUES("'.$nombre.'", "'.$descripcion.'", "'.$idMunicipio.'")');
    }
		
	public function update_programa($idPrograma, $nombre, $descripcion, $idMunicipio) {	
		$nombre = $this->real_escape_string($nombre);	
      	return $this->query('UPDATE programa SET nombre = "'.$nombre.'", descripcion = "'.$descripcion.'", idMunicipio = "'.$idMunicipio.'" WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	public function delete_programa($idPrograma) {
        return $this->query('DELETE FROM programa WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	//Barrio
	public function get_verificar_barrio($idBarrio) {
        return $this->query('SELECT * FROM persona WHERE idBarrio = "'.$idBarrio.'"');
    }
	
	public function get_barrio() {		
        return $this->query('SELECT * FROM barrio ORDER BY nombre');
    }			
	
	public function get_barrio_by_id($idBarrio) {		
        return $this->query('SELECT * FROM barrio WHERE idBarrio = "'.$idBarrio.'"');
    }
	
	public function get_barrio_by_municipio($idMunicipio) {		
        return $this->query('SELECT * FROM barrio WHERE idMunicipio = "'.$idMunicipio.'" ORDER BY nombre');
    }
	
	public function get_barrio_by_nombre($nombre) {	
		$nombre = $this->real_escape_string($nombre);	
        return $this->query('SELECT * FROM barrio WHERE nombre = "'.$nombre.'"');
    }
	
	public function get_buscar_barrio($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT * FROM barrio WHERE nombre LIKE "%'.$nombre.'%"');
    }
	
	public function get_barrio_by_municipio_nombre($idMunicipio, $nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT * FROM barrio WHERE idMunicipio = "'.$idMunicipio.'" AND nombre = "'.$nombre.'"');
    }
	
	public function insert_barrio($idMunicipio, $nombre) {
		$nombre = $this->real_escape_string($nombre);
        return $this->query('INSERT INTO barrio (idMunicipio, nombre) VALUES("'.$idMunicipio.'", "'.$nombre.'")');
    }
		
	public function update_barrio($idBarrio, $idMunicipio, $nombre) {	
		$nombre = $this->real_escape_string($nombre);	
       return $this->query('UPDATE barrio SET idMunicipio = "'.$idMunicipio.'", nombre = "'.$nombre.'" WHERE idBarrio = "'.$idBarrio.'"');
    }
	
	public function delete_barrio($idBarrio) {
        return $this->query('DELETE FROM barrio WHERE idBarrio = "'.$idBarrio.'"');
    }	
	
	//Persona
	public function get_verificar_persona($idPersona) {       
        return $this->query('SELECT * FROM autorizacion_pago, usuario WHERE autorizacion_pago.idUser = "'.$idPersona.'" OR autorizacion_pago.idResponsable = "'.$idPersona.'" OR autorizacion_pago.idCreador = "'.$idPersona.'" OR autorizacion_pago.idCliente = "'.$idPersona.'" OR usuario.idUser = "'.$idPersona.'" LIMIT 1');
    }		
	
	public function get_persona_by_id($idPersona) {		
        return $this->query('SELECT * FROM persona WHERE idPersona = "'.$idPersona.'"');
    }
	
	public function get_persona_by_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT * FROM persona WHERE nombre = "'.$nombre.'"');
    }
		
	public function get_persona_by_identificacion($identificacion) {
		$identificacion = $this->real_escape_string($identificacion);		
        return $this->query('SELECT * FROM persona WHERE identificacion = "'.$identificacion.'"');
    }
	
	public function get_buscar_persona($nombre, $identificacion) {
		$nombre = $this->real_escape_string($nombre);		
		$identificacion = $this->real_escape_string($identificacion);		
        return $this->query('SELECT * FROM persona WHERE nombre LIKE "%'.$nombre.'%" AND identificacion LIKE "%'.$identificacion.'%" ORDER BY nombre LIMIT 10');
    }
	
	public function get_buscar_persona_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT * FROM persona WHERE nombre LIKE "%'.$nombre.'%" ORDER BY nombre');
    }
		
	public function insert_persona($identificacion, $dv, $nombre, $telefono, $celular, $direccion, $idBarrio, $email) {
		$identificacion = $this->real_escape_string($identificacion);
		$dv = $this->real_escape_string($dv);	
		$nombre = $this->real_escape_string($nombre);	
		$telefono = $this->real_escape_string($telefono);	
		$celular = $this->real_escape_string($celular);	
		$direccion = $this->real_escape_string($direccion);	
		$email = $this->real_escape_string($email);
        return $this->query('INSERT INTO persona (identificacion, dv, nombre, telefono, celular, direccion, idBarrio, email) VALUES("'.$identificacion.'", "'.$dv.'", "'.$nombre.'", "'.$telefono.'", "'.$celular.'", "'.$direccion.'", "'.$idBarrio.'", "'.$email.'")');
    }
		
	public function update_persona($idPersona, $identificacion, $dv, $nombre, $telefono, $celular, $direccion, $idBarrio, $email) {		
		$identificacion = $this->real_escape_string($identificacion);
		$dv = $this->real_escape_string($dv);	
		$nombre = $this->real_escape_string($nombre);	
		$telefono = $this->real_escape_string($telefono);	
		$celular = $this->real_escape_string($celular);	
		$direccion = $this->real_escape_string($direccion);	
		$email = $this->real_escape_string($email);
       	return $this->query('UPDATE persona SET identificacion = "'.$identificacion.'", dv = "'.$dv.'", nombre = "'.$nombre.'", telefono = "'.$telefono.'", celular = "'.$celular.'", direccion = "'.$direccion.'", idBarrio = "'.$idBarrio.'", email = "'.$email.'"  WHERE idPersona = "'.$idPersona.'"');
    }
	
	public function delete_persona($idPersona) {
        return $this->query('DELETE FROM persona WHERE idPersona = "'.$idPersona.'"');
    }	
	
	//Responsable
	public function get_responsable() {       
        return $this->query('SELECT DISTINCT persona.* FROM responsable, persona WHERE responsable.idResponsable = persona.idPersona ORDER BY persona.nombre');
    }
	
	public function get_responsable_by_id($idResponsable) {       
        return $this->query('SELECT DISTINCT persona.* FROM responsable, persona WHERE responsable.idResponsable = "'.$idResponsable.'" AND persona.idPersona = responsable.idResponsable');
    }
	
	public function get_responsable_by_programa($idPrograma) {       
        return $this->query('SELECT * FROM responsable, persona WHERE responsable.idPrograma = "'.$idPrograma.'" AND  responsable.idResponsable = persona.idPersona ORDER BY persona.nombre');
    }
	
	public function get_verificar_responsable_by_programa($idUser, $idPrograma) {       
        return $this->query('SELECT * FROM responsable, persona WHERE responsable.idUser = "'.$idUser.'" AND responsable.idPrograma = "'.$idPrograma.'" AND  responsable.idResponsable = persona.idPersona ORDER BY persona.nombre');
    }
	
	public function get_programa_by_responsable($idResponsable) {       
        return $this->query('SELECT programa.* FROM responsable, programa WHERE responsable.idResponsable = "'.$idResponsable.'" AND  responsable.idPrograma = programa.idPrograma ORDER BY programa.nombre');
    }
		
	public function get_responsable_by_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT DISTINCT persona.* FROM responsable, persona WHERE responsable.idResponsable = persona.idPersona AND nombre = "'.$nombre.'"');
    }
	
	public function get_buscar_responsable_nombre($nombre) {
		$nombre = $this->real_escape_string($nombre);		
        return $this->query('SELECT DISTINCT persona.* FROM responsable, persona WHERE responsable.idResponsable = persona.idPersona AND persona.nombre LIKE "%'.$nombre.'%" ORDER BY persona.nombre');
    }
				
	public function insert_responsable($idResponsable, $idPrograma) {
        return $this->query('INSERT INTO responsable (idResponsable, idPrograma) VALUES("'.$idResponsable.'", "'.$idPrograma.'")');
    }
	
	public function delete_responsable($idResponsable, $idPrograma) {
        return $this->query('DELETE FROM responsable WHERE idResponsable = "'.$idResponsable.'" AND idPrograma = "'.$idPrograma.'"');		
    }
	
	//Autorizacion de Pago
	public function get_numero_ap($idPrograma) {		
        return $this->query('SELECT max(consecutivo) as numero FROM autorizacion_pago WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	public function get_id_ap($idPrograma, $consecutivo) {	
        return $this->query('SELECT idAutorizacionPago FROM autorizacion_pago WHERE consecutivo = "'.$consecutivo.'" AND idPrograma = "'.$idPrograma.'"');
    }
			
	public function get_ap_by_id($idAutorizacionPago) {       
        return $this->query('SELECT * FROM autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function get_ap_by_cliente($documento) { 
		$documento = $this->real_escape_string($documento);
        return $this->query('SELECT DISTINCT autorizacion_pago.* FROM autorizacion_pago, persona, municipio, programa WHERE autorizacion_pago.idCliente = persona.idPersona AND autorizacion_pago.idMunicipio = municipio.idMunicipio AND autorizacion_pago.idPrograma = programa.idPrograma AND persona.identificacion = "'.$documento.'" ORDER BY autorizacion_pago.fecha DESC LIMIT 10');
    }
	/*
	public function get_ap_by_consecutivo($consecutivo) { 
		$consecutivo = $this->real_escape_string($consecutivo);      
        return $this->query('SELECT * FROM autorizacion_pago WHERE consecutivo = "'.$consecutivo.'" ORDER BY idPrograma');
    }
	
	public function get_ap_by_fecha($fecha) {       
        return $this->query('SELECT * FROM autorizacion_pago WHERE fecha = "'.$fecha.'" ORDER BY idPrograma, consecutivo');
    }
	*/
	public function get_buscar_ap($buscar) { 
		$buscar = $this->real_escape_string($buscar);
        return $this->query('SELECT DISTINCT autorizacion_pago.* FROM autorizacion_pago, persona, municipio, programa WHERE (autorizacion_pago.idCliente = persona.idPersona OR autorizacion_pago.idResponsable = persona.idPersona) AND autorizacion_pago.idMunicipio = municipio.idMunicipio AND autorizacion_pago.idPrograma = programa.idPrograma AND(autorizacion_pago.consecutivo = "'.$buscar.'" OR persona.identificacion = "'.$buscar.'" OR persona.nombre LIKE "%'.$buscar.'%" OR municipio.nombre LIKE "%'.$buscar.'%" OR programa.nombre LIKE "%'.$buscar.'%") ORDER BY autorizacion_pago.idPrograma, autorizacion_pago.consecutivo');
    }
		
	public function get_buscar_ap_by_programa($buscar, $idPrograma) { 
		$buscar = $this->real_escape_string($buscar);
        return $this->query('SELECT DISTINCT autorizacion_pago.* FROM autorizacion_pago, persona, municipio, programa WHERE autorizacion_pago.idPrograma = "'.$idPrograma.'" AND (autorizacion_pago.idCliente = persona.idPersona OR autorizacion_pago.idResponsable = persona.idPersona) AND autorizacion_pago.idMunicipio = municipio.idMunicipio AND autorizacion_pago.idPrograma = programa.idPrograma AND(autorizacion_pago.consecutivo = "'.$buscar.'" OR persona.identificacion = "'.$buscar.'" OR persona.nombre LIKE "%'.$buscar.'%" OR municipio.nombre LIKE "%'.$buscar.'%" OR programa.nombre LIKE "%'.$buscar.'%") ORDER BY autorizacion_pago.consecutivo');
    }
	
	public function get_numero_item_ap($idAutorizacionPago) {		
        return $this->query('SELECT max(item) as numero FROM item_autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function get_id_creador_ap($idAutorizacionPago) {       
        return $this->query('SELECT idCreador FROM autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function get_id_user_ap($idAutorizacionPago) {       
        return $this->query('SELECT idUser FROM autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function get_item_ap($idAutorizacionPago) {       
        return $this->query('SELECT * FROM item_autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'" ORDER BY item');
    }
	
	public function get_item_ap_by_id($idAutorizacionPago, $item) {       
        return $this->query('SELECT * FROM item_autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'" AND item = "'.$item.'"');
    }			
		
	public function insert_ap($idPrograma, $consecutivo, $fecha, $idResponsable, $idCliente, $idMunicipio, $concepto, $tipoPago, $idCreador, $idUser, $fechaActualizacion, $banco, $tipoCuenta, $numeroCuenta, $estado) {
		$fecha = $this->real_escape_string($fecha);
		$concepto = $this->real_escape_string($concepto);
		$banco = $this->real_escape_string($banco);
		$numeroCuenta = $this->real_escape_string($numeroCuenta);		
        return $this->query('INSERT INTO autorizacion_pago (idPrograma, consecutivo, fecha, idResponsable, idCliente, idMunicipio, concepto, tipoPago, idCreador, idUser, fechaActualizacion, banco, tipoCuenta, numeroCuenta, estado) VALUES("'.$idPrograma.'", "'.$consecutivo.'", "'.$fecha.'", "'.$idResponsable.'", "'.$idCliente.'", "'.$idMunicipio.'", "'.$concepto.'", "'.$tipoPago.'", "'.$idCreador.'", "'.$idUser.'", "'.$fechaActualizacion.'", "'.$banco.'" , "'.$tipoCuenta.'" , "'.$numeroCuenta.'" , "'.$estado.'")');
    }
	
	public function insert_item_ap($idAutorizacionPago, $item, $numeroPago, $comprobanteEgreso, $descripcion, $centroCosto, $valor) {
		$numeroPago = $this->real_escape_string($numeroPago);
		$comprobanteEgreso = $this->real_escape_string($comprobanteEgreso);
		$descripcion = $this->real_escape_string($descripcion);
		$centroCosto = $this->real_escape_string($centroCosto);
		$valor = $this->real_escape_string($valor);		
        return $this->query('INSERT INTO item_autorizacion_pago (idAutorizacionPago, item, numeroPago, comprobanteEgreso, descripcion, centroCosto, valor) VALUES("'.$idAutorizacionPago.'", "'.$item.'", "'.$numeroPago.'", "'.$comprobanteEgreso.'", "'.$descripcion.'", "'.$centroCosto.'", "'.$valor.'")');
    }	
	
	public function update_ap($idAutorizacionPago, $fecha, $idResponsable, $idCliente, $idMunicipio, $concepto, $tipoPago, $idUser, $fechaActualizacion, $banco, $tipoCuenta, $numeroCuenta, $estado) {
		$fecha = $this->real_escape_string($fecha);
		$concepto = $this->real_escape_string($concepto);
		$banco = $this->real_escape_string($banco);
		$numeroCuenta = $this->real_escape_string($numeroCuenta);
        return $this->query('UPDATE autorizacion_pago SET fecha = "'.$fecha.'", idResponsable = "'.$idResponsable.'", idCliente = "'.$idCliente.'", idMunicipio = "'.$idMunicipio.'", concepto = "'.$concepto.'", tipoPago = "'.$tipoPago.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActualizacion.'", banco = "'.$banco.'" , tipoCuenta = "'.$tipoCuenta.'" , numeroCuenta = "'.$numeroCuenta.'" , estado = "'.$estado.'" WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function update_user_ap($idAutorizacionPago, $idUser, $fechaActual) {
        return $this->query('UPDATE autorizacion_pago SET idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'" WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function update_consecutivo_ap($idAutorizacionPago, $consecutivo) {
		$consecutivo = $this->real_escape_string($consecutivo);
        return $this->query('UPDATE autorizacion_pago SET consecutivo = "'.$consecutivo.'" WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }	
	
	public function update_item_ap($idAutorizacionPago, $item, $numeroPago, $comprobanteEgreso, $descripcion, $centroCosto, $valor) {
		$numeroPago = $this->real_escape_string($numeroPago);
		$comprobanteEgreso = $this->real_escape_string($comprobanteEgreso);
		$descripcion = $this->real_escape_string($descripcion);
		$centroCosto = $this->real_escape_string($centroCosto);
		$valor = $this->real_escape_string($valor);
        return $this->query('UPDATE item_autorizacion_pago SET numeroPago = "'.$numeroPago.'", comprobanteEgreso = "'.$comprobanteEgreso.'", descripcion = "'.$descripcion.'", centroCosto = "'.$centroCosto.'", valor = "'.$valor.'" WHERE idAutorizacionPago = "'.$idAutorizacionPago.'" AND item = "'.$item.'"');
    }
	
	public function update_retenciones_ap($idAutorizacionPago, $iva, $valorIva, $retencionIva, $valorRetencionIva, $retencionFuente, $valorRetencionFuente, $retencionIca, $valorRetencionIca, $sumarIva, $idUser, $fechaActualizacion) {
		$iva = $this->real_escape_string($iva);
		$valorIva = $this->real_escape_string($valorIva);
		$retencionIva = $this->real_escape_string($retencionIva);
		$valorRetencionIva = $this->real_escape_string($valorRetencionIva);
		$retencionFuente = $this->real_escape_string($retencionFuente);
		$valorRetencionFuente = $this->real_escape_string($valorRetencionFuente);
		$retencionIca = $this->real_escape_string($retencionIca);
		$valorRetencionIca = $this->real_escape_string($valorRetencionIca);	
        return $this->query('UPDATE autorizacion_pago SET iva = "'.$iva.'", valorIva = "'.$valorIva.'", retencionIva = "'.$retencionIva.'", valorRetencionIva = "'.$valorRetencionIva.'", retencionFuente = "'.$retencionFuente.'", valorRetencionFuente = "'.$valorRetencionFuente.'", retencionIca = "'.$retencionIca.'", valorRetencionIca = "'.$valorRetencionIca.'", sumarIva = "'.$sumarIva.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActualizacion.'" WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function delete_ap($idAutorizacionPago) {
        return $this->query('DELETE FROM autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	public function delete_item_ap($idAutorizacionPago, $item) {
        return $this->query('DELETE FROM item_autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'" AND item = "'.$item.'"');
    }
	
	public function delete_all_item_ap($idAutorizacionPago) {
        return $this->query('DELETE FROM item_autorizacion_pago WHERE idAutorizacionPago = "'.$idAutorizacionPago.'"');
    }
	
	/*Exportar Programa*/
	public function get_exportar_ap($idPrograma, $fechaInicial, $fechaFinal) {
		if($idPrograma != '0'){
			if($fechaInicial != '-' && $fechaFinal != '-')
				return $this->query('SELECT * FROM autorizacion_pago WHERE idPrograma = "'.$idPrograma.'" AND fecha BETWEEN "'.$fechaInicial.'" AND "'.$fechaFinal.'" ORDER BY consecutivo');	
			else 
				return $this->query('SELECT * FROM autorizacion_pago WHERE idPrograma = "'.$idPrograma.'" ORDER BY consecutivo');				
		}
		else{
			if($fechaInicial != '' && $fechaFinal != '')
				return $this->query('SELECT * FROM autorizacion_pago WHERE fecha BETWEEN "'.$fechaInicial.'" AND "'.$fechaFinal.'" ORDER BY  idPrograma, consecutivo');
		}
    }
	
	/*Importar*/
	public function verificar_ap($idPrograma, $idCliente, $fecha, $concepto) {	
        return $this->query('SELECT idAutorizacionPago FROM autorizacion_pago WHERE idPrograma = "'.$idPrograma.'" AND idCliente = "'.$idCliente.'" AND fecha = "'.$fecha.'" AND concepto = "'.$concepto.'"');
    }		
}
?>
