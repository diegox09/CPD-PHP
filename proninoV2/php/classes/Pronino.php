<?php
class Pronino extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
		
	private $user = 'diegox09';
    private $passwd = 'sputnik_86';
    private $dbName = 'prueba_pronino';
    private $dbHost = 'localhost';
		
	/*
	Tipo de Usuario
	1. Usuario
	2. Coordinador
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
        return $this->query('SELECT * FROM pronino_usuario WHERE user = "'.$user.'" AND passwd = "'.$passwd.'"');
    }
	
	public function get_passwd($idUsuario, $passwd) {     
		$passwd = $this->real_escape_string($passwd);      
        return $this->query('SELECT * FROM pronino_usuario WHERE idUser = "'.$idUsuario.'" AND passwd = "'.$passwd.'"');
    }
	
	public function get_passwd_by_usuario($usuario) {     
		$usuario = $this->real_escape_string($usuario);      
        return $this->query('SELECT * FROM pronino_usuario WHERE user = "'.$usuario.'"');
    }
	
	public function get_user_by_id($idUser) { 
        return $this->query('SELECT * FROM pronino_usuario WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_user_by_nombre($usuario) { 
		$usuario = $this->real_escape_string($usuario);
        return $this->query('SELECT * FROM pronino_usuario WHERE user = "'.$usuario.'"');
    }	
	
	public function get_user_like_nombre($usuario) { 
		$usuario = $this->real_escape_string($usuario);
        return $this->query('SELECT * FROM pronino_usuario WHERE user LIKE "%'.$usuario.'%"');
    }
	
	public function get_user_by_tipo($tipoUser) { 
        return $this->query('SELECT * FROM pronino_usuario WHERE tipoUser = "'.$tipoUser.'" ORDER BY user');
    }
	
	public function get_all_user() { 
        return $this->query('SELECT * FROM pronino_usuario WHERE tipoUser = 1 OR tipoUser = 2 ORDER BY user');
    }
	
	public function get_actividad_by_user($idUser) { 		
        return $this->query('SELECT * FROM actividad_laboral WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_ars_by_user($idUser) { 		
        return $this->query('SELECT * FROM ars WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_barrio_by_user($idUser) { 		
        return $this->query('SELECT * FROM barrio WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_colegio_by_user($idUser) { 		
        return $this->query('SELECT * FROM colegio WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_departamento_by_user($idUser) { 		
        return $this->query('SELECT * FROM departamento WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_escuela_by_user($idUser) { 		
        return $this->query('SELECT * FROM escuela_formacion WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_municipio_by_user($idUser) { 		
        return $this->query('SELECT * FROM municipio WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_sede_by_user($idUser) { 		
        return $this->query('SELECT * FROM sede_colegio WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_sitio_by_user($idUser) { 		
        return $this->query('SELECT * FROM sitio_trabajo WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_beneficiario_by_user($idUser) { 		
        return $this->query('SELECT * FROM beneficiario WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_beneficiario_pronino_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_beneficiario WHERE idUsuario1 = "'.$idUser.'" OR idUsuario2 = "'.$idUser.'" OR idUser = "'.$idUser.'"');
    }
	
	public function get_diagnostico_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_diagnostico WHERE idProfesional = "'.$idUser.'" OR idUser = "'.$idUser.'"');
    }
	
	public function get_actividades_mes_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_mes WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_notas_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_nota WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_psicosocial_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_psicosocial WHERE remitido = "'.$idUser.'" OR responsable = "'.$idUser.'" OR direccionado = "'.$idUser.'" OR idUser = "'.$idUser.'"');
    }
	
	public function get_seguimiento_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_seguimiento WHERE idProfesional = "'.$idUser.'" OR idUser = "'.$idUser.'"');
    }
	
	public function get_year_by_user($idUser) { 		
        return $this->query('SELECT * FROM pronino_year WHERE idUser = "'.$idUser.'"');
    }
	
	public function insert_user($usuario, $tipoUser, $nombreUser, $idUser, $fechaActual){		
		$usuario = $this->real_escape_string($usuario);
		$nombreUser = $this->real_escape_string($nombreUser);
        return $this->query('INSERT INTO pronino_usuario (user, passwd, tipoUser, nombreUser, fechaActualizacion, idUserAct) VALUES("'.$usuario.'", "'.$usuario.'", "'.$tipoUser.'", "'.$nombreUser.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_user($idUsuario, $usuario, $tipoUser, $nombreUser, $idUser, $fechaActual){
		$usuario = $this->real_escape_string($usuario);
		$nombreUser = $this->real_escape_string($nombreUser);
        return $this->query('UPDATE pronino_usuario SET user = "'.$usuario.'", tipoUser = "'.$tipoUser.'", nombreUser = "'.$nombreUser.'", fechaActualizacion = "'.$fechaActual.'", idUserAct = "'.$idUser.'" WHERE idUser = "'.$idUsuario.'"');		
    }
	
	public function update_passwd($idUsuario, $passwd, $email, $idUser, $fechaActual){
		$passwd = $this->real_escape_string($passwd);
        return $this->query('UPDATE pronino_usuario SET passwd = "'.$passwd.'", email = "'.$email.'", fechaActualizacion = "'.$fechaActual.'", idUserAct = "'.$idUser.'" WHERE idUser = "'.$idUsuario.'"');		
    }
	
	public function delete_user($idUsuario) {
        return $this->query('DELETE FROM pronino_usuario WHERE idUser = "'.$idUsuario.'"');
    }
	
	/*Beneficiario*/	
	public function get_buscar_beneficiario($buscar){
		$buscar = $this->real_escape_string($buscar);			
        return $this->query('SELECT * FROM beneficiario, pronino_beneficiario WHERE beneficiario.idBeneficiario = pronino_beneficiario.idBeneficiario AND (CONCAT(beneficiario.nombreBeneficiario," ",beneficiario.apellidoBeneficiario) LIKE "%'.$buscar.'%" OR beneficiario.documentoBeneficiario LIKE "%'.$buscar.'%" OR pronino_beneficiario.item LIKE "%'.$buscar.'%") ORDER BY beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario LIMIT 100');
    }
	
	public function get_buscar_beneficiario_by_user($buscar, $idUser){
		$buscar = $this->real_escape_string($buscar);			
        return $this->query('SELECT * FROM beneficiario, pronino_beneficiario WHERE beneficiario.idBeneficiario = pronino_beneficiario.idBeneficiario AND ((CONCAT(beneficiario.nombreBeneficiario," ",beneficiario.apellidoBeneficiario) LIKE "%'.$buscar.'%" OR beneficiario.documentoBeneficiario LIKE "%'.$buscar.'%" OR pronino_beneficiario.item LIKE "%'.$buscar.'%") AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'")) ORDER BY beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario LIMIT 100');
    }
	
	public function get_buscar_beneficiario_by_municipio($buscar, $idMunicipio){
		$buscar = $this->real_escape_string($buscar);			
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE beneficiario.idBeneficiario = pronino_beneficiario.idBeneficiario AND pronino_year.idBeneficiario = beneficiario.idBeneficiario AND beneficiario.idMunicipio = "'.$idMunicipio.'" AND (CONCAT(beneficiario.nombreBeneficiario," ",beneficiario.apellidoBeneficiario) LIKE "%'.$buscar.'%" OR beneficiario.documentoBeneficiario LIKE "%'.$buscar.'%" OR pronino_beneficiario.item LIKE "%'.$buscar.'%") ORDER BY beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario LIMIT 100');
    }
	
	public function get_buscar_beneficiario_by_user_municipio($buscar, $idUser, $idMunicipio){
		$buscar = $this->real_escape_string($buscar);			
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE beneficiario.idBeneficiario = pronino_beneficiario.idBeneficiario AND pronino_year.idBeneficiario = beneficiario.idBeneficiario AND beneficiario.idMunicipio = "'.$idMunicipio.'" AND ((CONCAT(beneficiario.nombreBeneficiario," ",beneficiario.apellidoBeneficiario) LIKE "%'.$buscar.'%" OR beneficiario.documentoBeneficiario LIKE "%'.$buscar.'%" OR pronino_beneficiario.item LIKE "%'.$buscar.'%") AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'")) ORDER BY beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario LIMIT 100');
    }
	
	public function get_buscar_beneficiario_year_by_colegio($buscar, $year, $idColegio){
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND pronino_year.idColegio = "'.$idColegio.'" AND (CONCAT(beneficiario.nombreBeneficiario," ",beneficiario.apellidoBeneficiario) LIKE "%'.$buscar.'%" OR beneficiario.documentoBeneficiario LIKE "%'.$buscar.'%" OR pronino_beneficiario.item LIKE "%'.$buscar.'%") ORDER BY pronino_year.idSedeColegio, pronino_year.grado, pronino_year.jornada, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function get_buscar_beneficiario_year_by_user_colegio($buscar, $idUser, $year, $idColegio){
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND pronino_year.idColegio = "'.$idColegio.'" AND ((CONCAT(beneficiario.nombreBeneficiario," ",beneficiario.apellidoBeneficiario) LIKE "%'.$buscar.'%" OR beneficiario.documentoBeneficiario LIKE "%'.$buscar.'%" OR pronino_beneficiario.item LIKE "%'.$buscar.'%") AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'")) ORDER BY pronino_year.idSedeColegio, pronino_year.grado, pronino_year.jornada, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function get_beneficiario_by_documento($documento){
		$documento = $this->real_escape_string($documento);			
        return $this->query('SELECT * FROM beneficiario WHERE documentoBeneficiario = "'.$documento.'"');
    }
	
	public function get_beneficiario_by_id($idBeneficiario){		
        return $this->query('SELECT * FROM beneficiario WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function get_mes_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function get_nota_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_nota WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function get_year_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_year WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
		
	public function get_beneficiario_like_nombre($documento, $nombreBeneficiario, $apellidoBeneficiario){	
		$nombreBeneficiario = $this->real_escape_string($nombreBeneficiario);
		$apellidoBeneficiario = $this->real_escape_string($apellidoBeneficiario);
		$documento = $this->real_escape_string($documento);
		if($nombreBeneficiario == '')
			$nombreBeneficiario = '-';
		if($apellidoBeneficiario == '')
			$apellidoBeneficiario = '-';	
        return $this->query('SELECT * FROM beneficiario WHERE documentoBeneficiario = "'.$documento.'" OR nombreBeneficiario LIKE "%'.$nombreBeneficiario.'%" OR apellidoBeneficiario LIKE "%'.$apellidoBeneficiario.'%"');
    }
	
	public function insert_beneficiario($nombreBeneficiario, $apellidoBeneficiario, $td, $documento, $fechaNacimiento, $genero, $telefono, $direccion, $idMunicipio, $idBarrio, $idUser, $fechaActual){
		$nombreBeneficiario = $this->real_escape_string($nombreBeneficiario);
		$apellidoBeneficiario = $this->real_escape_string($apellidoBeneficiario);
		$documento = $this->real_escape_string($documento);
		$fechaNacimiento = $this->real_escape_string($fechaNacimiento);		
		$telefono = $this->real_escape_string($telefono);
		$direccion = $this->real_escape_string($direccion);
        return $this->query('INSERT INTO beneficiario (nombreBeneficiario, apellidoBeneficiario, tipoDocumento, documentoBeneficiario, fechaNacimiento, genero, telefono, direccion, idMunicipio, idBarrio, fechaActualizacion, idUser) VALUES("'.$nombreBeneficiario.'", "'.$apellidoBeneficiario.'", "'.$td.'", "'.$documento.'", "'.$fechaNacimiento.'", "'.$genero.'", "'.$telefono.'", "'.$direccion.'", "'.$idMunicipio.'", "'.$idBarrio.'", "'.$fechaActual.'", "'.$idUser.'")');
    }	
	
	public function update_beneficiario($idBeneficiario, $nombreBeneficiario, $apellidoBeneficiario, $td, $documento, $fechaNacimiento, $genero, $telefono, $direccion, $idMunicipio, $idBarrio, $idUser, $fechaActual){
		$nombreBeneficiario = $this->real_escape_string($nombreBeneficiario);
		$apellidoBeneficiario = $this->real_escape_string($apellidoBeneficiario);
		$documento = $this->real_escape_string($documento);
		$fechaNacimiento = $this->real_escape_string($fechaNacimiento);		
		$telefono = $this->real_escape_string($telefono);
		$direccion = $this->real_escape_string($direccion);
		return $this->query('UPDATE beneficiario SET nombreBeneficiario = "'.$nombreBeneficiario.'", apellidoBeneficiario = "'.$apellidoBeneficiario.'", tipoDocumento = "'.$td.'", documentoBeneficiario = "'.$documento.'", fechaNacimiento = "'.$fechaNacimiento.'", genero = "'.$genero.'", telefono = "'.$telefono.'", direccion = "'.$direccion.'", idMunicipio = "'.$idMunicipio.'", idBarrio = "'.$idBarrio.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }	
	
	public function delete_beneficiario($idBeneficiario) {
        return $this->query('DELETE FROM beneficiario WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	/*Beneficiario Proniño*/
	public function get_beneficiario_pronino_by_id($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_beneficiario WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function asignar_usuario($idBeneficiario, $idUsuario1, $idUsuario2){
		return $this->query('UPDATE pronino_beneficiario SET idUsuario1 = "'.$idUsuario1.'", idUsuario2 = "'.$idUsuario2.'" WHERE idBeneficiario = "'.$idBeneficiario.'"');	
    }
	
	public function insert_beneficiario_pronino($idBeneficiario, $idUser, $fechaActual, $perfilUser){
		if($perfilUser == '1'){
			return $this->query('INSERT INTO pronino_beneficiario (idBeneficiario, fechaActualizacion, idUser, idUsuario1) VALUES("'.$idBeneficiario.'", "'.$fechaActual.'", "'.$idUser.'", "'.$idUser.'")');
		}
		else{
			if($perfilUser == '2')
				return $this->query('INSERT INTO pronino_beneficiario (idBeneficiario, fechaActualizacion, idUser, idUsuario2) VALUES("'.$idBeneficiario.'", "'.$fechaActual.'", "'.$idUser.'" , "'.$idUser.'")');
			else{	
				return $this->query('INSERT INTO pronino_beneficiario (idBeneficiario, fechaActualizacion, idUser) VALUES("'.$idBeneficiario.'", "'.$fechaActual.'", "'.$idUser.'")');
			}
		}
    }
	
	public function update_beneficiario_pronino($idBeneficiario, $item, $tallaUniforme, $tallaZapato, $sisben, $idArs, $idUsuario1, $idUsuario2, $fechaIngreso, $estado, $fechaRetiro, $razonRetiro, $idUser, $fechaActual, $razonEgresado, $razonBaja){
		$item = $this->real_escape_string($item);
		$fechaIngreso = $this->real_escape_string($fechaIngreso);
		$fechaRetiro = $this->real_escape_string($fechaRetiro);
		if($item == '')
        	return $this->query('UPDATE pronino_beneficiario SET item = NULL, tallaUniforme = "'.$tallaUniforme.'", tallaZapato = "'.$tallaZapato.'", sisben = "'.$sisben.'", idArs = "'.$idArs.'", idUsuario1 = "'.$idUsuario1.'", idUsuario2 = "'.$idUsuario2.'", fechaIngreso = "'.$fechaIngreso.'", estado = "'.$estado.'", fechaRetiro = "'.$fechaRetiro.'", razonRetiro = "'.$razonRetiro.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'", razonEgresado = "'.$razonEgresado.'", razonBaja = "'.$razonBaja.'" WHERE idBeneficiario = "'.$idBeneficiario.'"');
		else
			return $this->query('UPDATE pronino_beneficiario SET item = "'.$item.'", tallaUniforme = "'.$tallaUniforme.'", tallaZapato = "'.$tallaZapato.'", sisben = "'.$sisben.'", idArs = "'.$idArs.'", idUsuario1 = "'.$idUsuario1.'", idUsuario2 = "'.$idUsuario2.'", fechaIngreso = "'.$fechaIngreso.'", estado = "'.$estado.'", fechaRetiro = "'.$fechaRetiro.'", razonRetiro = "'.$razonRetiro.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'", razonEgresado = "'.$razonEgresado.'", razonBaja = "'.$razonBaja.'" WHERE idBeneficiario = "'.$idBeneficiario.'"');	
    }
	
	public function delete_beneficiario_pronino($idBeneficiario) {
        return $this->query('DELETE FROM pronino_beneficiario WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	/*Acudiente Proniño*/
	public function get_acudiente_pronino_by_id($idAcudiente){		
        return $this->query('SELECT * FROM pronino_beneficiario WHERE idAcudiente = "'.$idAcudiente.'"');
    }
	
	public function get_acudiente_pronino_by_beneficiario($idBeneficiario, $idAcudiente){		
        return $this->query('SELECT * FROM pronino_beneficiario WHERE idAcudiente = "'.$idAcudiente.'" AND idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function update_acudiente_pronino($idBeneficiario, $idAcudiente, $idUser, $fechaActual){
		return $this->query('UPDATE pronino_beneficiario SET idAcudiente = "'.$idAcudiente.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idBeneficiario = "'.$idBeneficiario.'"');	
    }
	
	/*Departamento*/
	public function get_departamentos(){		
        return $this->query('SELECT * FROM departamento ORDER BY nombreDepartamento');
    }
	
	public function get_departamento_by_id($idDepartamento){		
        return $this->query('SELECT * FROM departamento WHERE idDepartamento = "'.$idDepartamento.'"');
    }
	
	public function get_departamento_by_nombre($nombreDepartamento){	
		$nombreDepartamento = $this->real_escape_string($nombreDepartamento);	
        return $this->query('SELECT * FROM departamento WHERE nombreDepartamento = "'.$nombreDepartamento.'"');
    }	
	
	public function get_departamento_like_nombre($nombreDepartamento){	
		$nombreDepartamento = $this->real_escape_string($nombreDepartamento);	
        return $this->query('SELECT * FROM departamento WHERE nombreDepartamento LIKE "%'.$nombreDepartamento.'%"');
    }
	
	public function get_municipio_by_departamento($idDepartamento){		
        return $this->query('SELECT * FROM municipio WHERE idDepartamento = "'.$idDepartamento.'" ORDER BY nombreMunicipio');
    }	
	
	public function insert_departamento($nombreDepartamento, $idUser, $fechaActual){
		$nombreDepartamento = $this->real_escape_string($nombreDepartamento);
        return $this->query('INSERT INTO departamento (nombreDepartamento, fechaActualizacion, idUser) VALUES("'.$nombreDepartamento.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_departamento($idDepartamento, $nombreDepartamento, $idUser, $fechaActual){
		$nombreDepartamento = $this->real_escape_string($nombreDepartamento);
        return $this->query('UPDATE departamento SET nombreDepartamento = "'.$nombreDepartamento.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idDepartamento = "'.$idDepartamento.'"');		
    }
	
	public function delete_departamento($idDepartamento) {
        return $this->query('DELETE FROM departamento WHERE idDepartamento = "'.$idDepartamento.'"');
    }	
	
	/*Municipio*/
	public function get_municipios(){		
        return $this->query('SELECT * FROM municipio ORDER BY nombreMunicipio');
    }
	
	public function get_municipio_by_id($idMunicipio){		
        return $this->query('SELECT * FROM municipio WHERE idMunicipio = "'.$idMunicipio.'"');
    }
	
	public function get_municipio_by_nombre($idDepartamento, $nombreMunicipio){	
		$nombreMunicipio = $this->real_escape_string($nombreMunicipio);	
        return $this->query('SELECT * FROM municipio WHERE nombreMunicipio = "'.$nombreMunicipio.'" AND idDepartamento = "'.$idDepartamento.'"');
    }	
	
	public function get_municipio_like_nombre($idDepartamento, $nombreMunicipio){	
		$nombreMunicipio = $this->real_escape_string($nombreMunicipio);	
        return $this->query('SELECT * FROM municipio WHERE nombreMunicipio LIKE "%'.$nombreMunicipio.'%" AND idDepartamento = "'.$idDepartamento.'"');
    }
	
	public function get_barrio_by_municipio($idMunicipio){		
        return $this->query('SELECT * FROM barrio WHERE idMunicipio = "'.$idMunicipio.'" ORDER BY nombreBarrio');
    }
	
	public function get_colegio_by_municipio($idMunicipio){		
        return $this->query('SELECT * FROM colegio WHERE idMunicipio = "'.$idMunicipio.'" ORDER BY nombreColegio');
    }
	
	public function get_benficiario_by_municipio($idMunicipio){		
        return $this->query('SELECT * FROM beneficiario WHERE idMunicipio = "'.$idMunicipio.'"');
    }
	
	public function get_benficiario_year_by_municipio($idMunicipio){		
        return $this->query('SELECT * FROM beneficiario_year WHERE idMunicipioColegio = "'.$idMunicipio.'"');
    }
	
	public function insert_municipio($idDepartamento, $nombreMunicipio, $idUser, $fechaActual){
		$nombreMunicipio = $this->real_escape_string($nombreMunicipio);
        return $this->query('INSERT INTO municipio (idDepartamento, nombreMunicipio, fechaActualizacion, idUser) VALUES("'.$idDepartamento.'", "'.$nombreMunicipio.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_municipio($idMunicipio, $idDepartamento, $nombreMunicipio, $idUser, $fechaActual){
		$nombreMunicipio = $this->real_escape_string($nombreMunicipio);
        return $this->query('UPDATE municipio SET idDepartamento = "'.$idDepartamento.'", nombreMunicipio = "'.$nombreMunicipio.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idMunicipio = "'.$idMunicipio.'"');		
    }
	
	public function delete_municipio($idMunicipio) {
        return $this->query('DELETE FROM municipio WHERE idMunicipio = "'.$idMunicipio.'"');
    }
	
	/*Barrio*/	
	public function get_barrio_by_id($idBarrio){		
        return $this->query('SELECT * FROM barrio WHERE idBarrio = "'.$idBarrio.'"');
    }
	
	public function get_barrio_by_nombre($idMunicipio, $nombreBarrio){	
		$nombreBarrio = $this->real_escape_string($nombreBarrio);	
        return $this->query('SELECT * FROM barrio WHERE idMunicipio = "'.$idMunicipio.'" AND nombreBarrio = "'.$nombreBarrio.'"');
    }	
	
	public function get_barrio_like_nombre($idMunicipio, $nombreBarrio){	
		$nombreBarrio = $this->real_escape_string($nombreBarrio);	
        return $this->query('SELECT * FROM barrio WHERE idMunicipio = "'.$idMunicipio.'" AND nombreBarrio LIKE "%'.$nombreBarrio.'%"');
    }
	
	public function get_beneficiario_by_barrio($idBarrio){		
        return $this->query('SELECT * FROM beneficiario WHERE idBarrio = "'.$idBarrio.'"');
    }
	
	public function insert_barrio($idMunicipio, $nombreBarrio, $idUser, $fechaActual){
		$nombreBarrio = $this->real_escape_string($nombreBarrio);
        return $this->query('INSERT INTO barrio (idMunicipio, nombreBarrio, fechaActualizacion, idUser) VALUES("'.$idMunicipio.'", "'.$nombreBarrio.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_barrio($idBarrio, $idMunicipio, $nombreBarrio, $idUser, $fechaActual){
		$nombreBarrio = $this->real_escape_string($nombreBarrio);
        return $this->query('UPDATE barrio SET idMunicipio = "'.$idMunicipio.'", nombreBarrio = "'.$nombreBarrio.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idBarrio = "'.$idBarrio.'"');		
    }
	
	public function delete_barrio($idBarrio) {
        return $this->query('DELETE FROM barrio WHERE idBarrio = "'.$idBarrio.'"');
    }
	
	/*Actividad Laboral*/
	public function get_actividades(){		
        return $this->query('SELECT * FROM actividad_laboral ORDER BY nombreActividad');
    }
	
	public function get_actividad_by_id($idActividad){		
        return $this->query('SELECT * FROM actividad_laboral WHERE idActividad = "'.$idActividad.'"');
    }
	
	public function get_actividad_by_nombre($nombreActividad){	
		$nombreActividad = $this->real_escape_string($nombreActividad);	
        return $this->query('SELECT * FROM actividad_laboral WHERE nombreActividad = "'.$nombreActividad.'"');
    }
	
	public function get_actividad_like_nombre($nombreActividad){	
		$nombreActividad = $this->real_escape_string($nombreActividad);	
        return $this->query('SELECT * FROM actividad_laboral WHERE nombreActividad LIKE "%'.$nombreActividad.'%"');
    }
	
	public function get_beneficiario_by_actividad($idActividad){			
        return $this->query('SELECT * FROM beneficiario WHERE idActividadLaboral = "'.$idActividad.'"');
    }
	
	public function insert_actividad($nombreActividad, $idUser, $fechaActual){
		$nombreActividad = $this->real_escape_string($nombreActividad);
        return $this->query('INSERT INTO actividad_laboral (nombreActividad, fechaActualizacion, idUser) VALUES("'.$nombreActividad.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_actividad($idActividad, $nombreActividad, $idUser, $fechaActual){
		$nombreActividad = $this->real_escape_string($nombreActividad);
        return $this->query('UPDATE actividad_laboral SET nombreActividad = "'.$nombreActividad.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idActividad = "'.$idActividad.'"');		
    }
	
	public function delete_actividad($idActividad) {
        return $this->query('DELETE FROM actividad_laboral WHERE idActividad = "'.$idActividad.'"');
    }
	
	/*Ars*/
	public function get_arss(){		
        return $this->query('SELECT * FROM ars ORDER BY nombreArs');
    }
	
	public function get_ars_by_id($idArs){		
        return $this->query('SELECT * FROM ars WHERE idArs = "'.$idArs.'"');
    }
	
	public function get_ars_by_nombre($nombreArs){	
		$nombreArs = $this->real_escape_string($nombreArs);	
        return $this->query('SELECT * FROM ars WHERE nombreArs = "'.$nombreArs.'"');
    }
	
	public function get_ars_like_nombre($nombreArs){	
		$nombreArs = $this->real_escape_string($nombreArs);	
        return $this->query('SELECT * FROM ars WHERE nombreArs LIKE "%'.$nombreArs.'%"');
    }
	
	public function get_beneficiario_by_ars($idArs){			
        return $this->query('SELECT * FROM beneficiario WHERE idArs = "'.$idArs.'"');
    }
	
	public function insert_ars($nombreArs, $idUser, $fechaActual){
		$nombreArs = $this->real_escape_string($nombreArs);
        return $this->query('INSERT INTO ars (nombreArs, fechaActualizacion, idUser) VALUES("'.$nombreArs.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_ars($idArs, $nombreArs, $idUser, $fechaActual){
		$nombreArs = $this->real_escape_string($nombreArs);
        return $this->query('UPDATE ars SET nombreArs = "'.$nombreArs.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idArs = "'.$idArs.'"');		
    }
	
	public function delete_ars($idArs) {
        return $this->query('DELETE FROM ars WHERE idArs = "'.$idArs.'"');
    }
	
	/*Colegio*/	
	public function get_colegio_by_id($idColegio){		
        return $this->query('SELECT * FROM colegio WHERE idColegio = "'.$idColegio.'"');
    }
	
	public function get_colegio_by_nombre($idMunicipio, $nombreColegio){	
		$nombreColegio = $this->real_escape_string($nombreColegio);	
        return $this->query('SELECT * FROM colegio WHERE idMunicipio = "'.$idMunicipio.'" AND nombreColegio = "'.$nombreColegio.'"');
    }
	
	public function get_colegio_like_nombre($idMunicipio, $nombreColegio){	
		$nombreColegio = $this->real_escape_string($nombreColegio);	
        return $this->query('SELECT * FROM colegio WHERE idMunicipio = "'.$idMunicipio.'" AND nombreColegio LIKE "%'.$nombreColegio.'%"');
    }
	
	public function get_sede_by_colegio($idColegio){		
        return $this->query('SELECT * FROM sede_colegio WHERE idColegio = "'.$idColegio.'" ORDER BY nombreSede');
    }
	
	public function get_beneficiario_by_colegio($idColegio){		
        return $this->query('SELECT * FROM beneficiario_year WHERE idColegio = "'.$idColegio.'"');
    }
		
	public function insert_colegio($idMunicipio, $nombreColegio, $idUser, $fechaActual){
		$nombreColegio = $this->real_escape_string($nombreColegio);
        return $this->query('INSERT INTO colegio (idMunicipio, nombreColegio, fechaActualizacion, idUser) VALUES("'.$idMunicipio.'", "'.$nombreColegio.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_colegio($idColegio, $idMunicipio, $nombreColegio, $idUser, $fechaActual){
		$nombreColegio = $this->real_escape_string($nombreColegio);
        return $this->query('UPDATE colegio SET idMunicipio = "'.$idMunicipio.'", nombreColegio = "'.$nombreColegio.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idColegio = "'.$idColegio.'"');		
    }
	
	public function delete_colegio($idColegio) {
        return $this->query('DELETE FROM colegio WHERE idColegio = "'.$idColegio.'"');
    }
	
	/*Sede Colegio*/
	public function get_sede_by_id($idSede){		
        return $this->query('SELECT * FROM sede_colegio WHERE idSedeColegio = "'.$idSede.'"');
    }
	
	public function get_sede_by_nombre($idColegio, $nombreSede){	
		$nombreSede = $this->real_escape_string($nombreSede);	
        return $this->query('SELECT * FROM sede_colegio WHERE idColegio = "'.$idColegio.'" AND nombreSede = "'.$nombreSede.'"');
    }	
	
	public function get_sede_like_nombre($idColegio, $nombreSede){	
		$nombreSede = $this->real_escape_string($nombreSede);	
        return $this->query('SELECT * FROM sede_colegio WHERE idColegio = "'.$idColegio.'" AND nombreSede LIKE "%'.$nombreSede.'%"');
    }
	
	public function get_beneficiario_by_sede($idSede){
        return $this->query('SELECT * FROM pronino_year WHERE idSedeColegio = "'.$idSede.'"');
    }
	
	public function insert_sede($idColegio, $nombreSede, $coordinador, $idUser, $fechaActual){
		$nombreSede = $this->real_escape_string($nombreSede);
        return $this->query('INSERT INTO sede_colegio (idColegio, nombreSede, nombreCoordinador, fechaActualizacion, idUser) VALUES("'.$idColegio.'", "'.$nombreSede.'", "'.$coordinador.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_sede($idSede, $idColegio, $nombreSede, $coordinador, $idUser, $fechaActual){
		$nombreSede = $this->real_escape_string($nombreSede);
        return $this->query('UPDATE sede_colegio SET idColegio = "'.$idColegio.'", nombreSede = "'.$nombreSede.'", nombreCoordinador = "'.$coordinador.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idSedeColegio = "'.$idSede.'"');		
    }
	
	public function delete_sede($idSede) {
        return $this->query('DELETE FROM sede_colegio WHERE idSedeColegio = "'.$idSede.'"');
    }
	
	/*Escuela*/
	public function get_escuelas(){		
        return $this->query('SELECT * FROM escuela_formacion ORDER BY nombreEscuela');
    }
	
	public function get_escuela_by_id($idEscuela){		
        return $this->query('SELECT * FROM escuela_formacion WHERE idEscuela = "'.$idEscuela.'"');
    }
	
	public function get_escuela_by_nombre($nombreEscuela){	
		$nombreEscuela = $this->real_escape_string($nombreEscuela);	
        return $this->query('SELECT * FROM escuela_formacion WHERE nombreEscuela = "'.$nombreEscuela.'"');
    }	
	
	public function get_escuela_like_nombre($nombreEscuela){	
		$nombreEscuela = $this->real_escape_string($nombreEscuela);	
        return $this->query('SELECT * FROM escuela_formacion WHERE nombreEscuela LIKE "%'.$nombreEscuela.'%"');
    }
	
	public function get_beneficiario_by_escuela($idEscuela){
        return $this->query('SELECT * FROM pronino_year WHERE escuelaFormacion1 = "'.$idEscuela.'" OR escuelaFormacion2 = "'.$idEscuela.'"');
    }
	
	public function insert_escuela($nombreEscuela, $idUser, $fechaActual){
		$nombreEscuela = $this->real_escape_string($nombreEscuela);
        return $this->query('INSERT INTO escuela_formacion (nombreEscuela, fechaActualizacion, idUser) VALUES("'.$nombreEscuela.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_escuela($idEscuela, $nombreEscuela, $idUser, $fechaActual){
		$nombreEscuela = $this->real_escape_string($nombreEscuela);
        return $this->query('UPDATE escuela_formacion SET nombreEscuela = "'.$nombreEscuela.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idEscuela = "'.$idEscuela.'"');		
    }
	
	public function delete_escuela($idEscuela) {
        return $this->query('DELETE FROM escuela_formacion WHERE idEscuela = "'.$idEscuela.'"');
    }
	
	/*Sitio Trabajo*/
	public function get_sitios(){		
        return $this->query('SELECT * FROM sitio_trabajo ORDER BY nombreSitio');
    }
	
	public function get_sitio_by_id($idSitio){		
        return $this->query('SELECT * FROM sitio_trabajo WHERE idSitio = "'.$idSitio.'"');
    }
	
	public function get_sitio_by_nombre($nombreSitio){	
		$nombreSitio = $this->real_escape_string($nombreSitio);	
        return $this->query('SELECT * FROM sitio_trabajo WHERE nombreSitio = "'.$nombreSitio.'"');
    }
	
	public function get_sitio_like_nombre($nombreSitio){	
		$nombreSitio = $this->real_escape_string($nombreSitio);	
        return $this->query('SELECT * FROM sitio_trabajo WHERE nombreSitio LIKE "%'.$nombreSitio.'%"');
    }
	
	public function get_beneficiario_by_sitio($idSitio){			
        return $this->query('SELECT * FROM beneficiario WHERE idSitioTrabajo = "'.$idSitio.'"');
    }
	
	public function insert_sitio($nombreSitio, $idUser, $fechaActual){
		$nombreSitio = $this->real_escape_string($nombreSitio);
        return $this->query('INSERT INTO sitio_trabajo (nombreSitio, fechaActualizacion, idUser) VALUES("'.$nombreSitio.'", "'.$fechaActual.'", "'.$idUser.'")');
    }
	
	public function update_sitio($idSitio, $nombreSitio, $idUser, $fechaActual){
		$nombreSitio = $this->real_escape_string($nombreSitio);
        return $this->query('UPDATE sitio_trabajo SET nombreSitio = "'.$nombreSitio.'", fechaActualizacion = "'.$fechaActual.'", idUser = "'.$idUser.'" WHERE idSitio = "'.$idSitio.'"');		
    }
	
	public function delete_sitio($idSitio) {
        return $this->query('DELETE FROM sitio_trabajo WHERE idSitio = "'.$idSitio.'"');
    }
		
	/*Year*/	
	public function get_beneficiario_year($idBeneficiario, $year){		
        return $this->query('SELECT * FROM pronino_year WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'"');
    }
	
	public function get_exportar_by_year($year){		
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function get_exportar_by_year_by_user($year, $idUser){		
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE pronino_beneficiario.estado != 2 AND pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'") ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function get_exportar_by_departamento($year, $idDepartamento){		
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario, municipio WHERE pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" ORDER BY beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function get_exportar_by_departamento_by_user($year, $idDepartamento, $idUser){				
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario, municipio WHERE pronino_beneficiario.estado != 2 AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'") ORDER BY beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }	
	
	public function get_exportar_detalle_actividades($year, $idActividad){		
        return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario WHERE pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND idActividad = "'.$idActividad.'" ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	/*
	public function get_exportar_detalle_actividades_by_user($year, $idActividad, $idUser){		
        return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario WHERE pronino_beneficiario.estado != 2 AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND idActividad = "'.$idActividad.'" AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'") ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	*/
	public function get_exportar_detalle_actividades_by_departamento($year, $idDepartamento, $idActividad){		
		return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario, municipio WHERE beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND idActividad = "'.$idActividad.'" ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
	}
	/*
	public function get_exportar_detalle_actividades_by_departamento_by_user($year, $idDepartamento, $idActividad, $idUser){		
		return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario, municipio WHERE pronino_beneficiario.estado != 2 AND beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND idActividad = "'.$idActividad.'"  AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'") ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
	}
	*/
	public function get_exportar_resumen_actividades($year, $idDepartamento, $idPeriodo){
		if($idPeriodo <= 6)	
			return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario, municipio WHERE beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND pronino_mes.mes BETWEEN 0 AND 7 ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
		else	
			return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario, municipio WHERE beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND pronino_mes.mes BETWEEN 7 AND 13 ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
		
	}
	/*
	public function get_exportar_resumen_actividades_by_user($year, $idDepartamento, $idPeriodo, $idUser){	
		if($idPeriodo <= 6)	
			return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario, municipio WHERE pronino_beneficiario.estado != 2 AND beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND pronino_mes.mes BETWEEN 0 AND 7  AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'")) ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
		else	
			return $this->query('SELECT DISTINCT pronino_mes.idBeneficiario FROM pronino_mes, beneficiario, pronino_beneficiario, municipio WHERE beneficiario.idMunicipio = municipio.idMunicipio AND municipio.idDepartamento = "'.$idDepartamento.'" AND pronino_mes.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_mes.year = "'.$year.'" AND pronino_mes.mes BETWEEN 7 AND 13  AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'") ORDER BY beneficiario.idMunicipio, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');	
	}
	*/
	public function get_trabajo_infantil_by_year($idBeneficiario, $year, $idActividad){		
        return $this->query('SELECT * FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND idActividad = "'.$idActividad.'"');
    }	
	
	public function get_beneficiario_year_by_colegio($year, $idColegio){
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND pronino_year.idColegio = "'.$idColegio.'" ORDER BY pronino_year.idSedeColegio, pronino_year.grado, pronino_year.jornada, pronino_year.seccion, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function get_beneficiario_year_by_user_colegio($year, $idUser, $idColegio){
        return $this->query('SELECT * FROM pronino_year, beneficiario, pronino_beneficiario WHERE pronino_year.idBeneficiario = beneficiario.idBeneficiario AND pronino_beneficiario.idBeneficiario = beneficiario.idBeneficiario AND pronino_year.year = "'.$year.'" AND pronino_year.idColegio = "'.$idColegio.'" AND (pronino_beneficiario.idUsuario1 = "'.$idUser.'" OR pronino_beneficiario.idUsuario2 = "'.$idUser.'") ORDER BY pronino_year.idSedeColegio, pronino_year.grado, pronino_year.jornada, pronino_year.seccion, beneficiario.nombreBeneficiario, beneficiario.apellidoBeneficiario');
    }
	
	public function insert_beneficiario_year($idBeneficiario, $year, $sitioTrabajo, $actividadLaboral, $actividadEspecifica, $observaciones, $idMunicipio, $idColegio, $idSedeColegio, $grado, $jornada, $escuelaFormacion1, $escuelaFormacion2, $desplazados, $juntos, $familiasAccion, $comedorInfantil, $kitEscolar, $uniforme, $zapatos, $visitaDomiciliaria, $visitaPsicosocial, $visitaAcademica, $intervencionPsicologica, $valoracionMedica, $valoracionOdontologica, $idUser, $fechaActual, $seccion, $kitNutricional, $visitaSeguimiento){
		$actividadEspecifica = $this->real_escape_string($actividadEspecifica);
		$observaciones = $this->real_escape_string($observaciones);
        return $this->query('INSERT INTO pronino_year (idBeneficiario, year, sitioTrabajo, actividadLaboral, actividadEspecifica, observaciones, idMunicipioColegio, idColegio, idSedeColegio, grado, jornada, escuelaFormacion1, escuelaFormacion2, desplazados, juntos, familiasAccion, comedorInfantil, kitEscolar, uniforme, zapatos, visitaDomiciliaria, visitaPsicosocial, visitaAcademica, intervencionPsicologica, valoracionMedica, valoracionOdontologica, idUser, fechaActualizacion, seccion, kitNutricional, visitaSeguimiento) VALUES("'.$idBeneficiario.'", "'.$year.'", "'.$sitioTrabajo.'", "'.$actividadLaboral.'", "'.$actividadEspecifica.'", "'.$observaciones.'", "'.$idMunicipio.'", "'.$idColegio.'", "'.$idSedeColegio.'", "'.$grado.'", "'.$jornada.'", "'.$escuelaFormacion1.'", "'.$escuelaFormacion2.'", "'.$desplazados.'", "'.$juntos.'", "'.$familiasAccion.'", "'.$comedorInfantil.'", "'.$kitEscolar.'", "'.$uniforme.'", "'.$zapatos.'", "'.$visitaDomiciliaria.'", "'.$visitaPsicosocial.'", "'.$visitaAcademica.'", "'.$intervencionPsicologica.'", "'.$valoracionMedica.'", "'.$valoracionOdontologica.'", "'.$idUser.'", "'.$fechaActual.'", "'.$seccion.'", "'.$kitNutricional.'", "'.$visitaSeguimiento.'")');
    }
	
	public function update_beneficiario_year($idBeneficiario, $year, $sitioTrabajo, $actividadLaboral, $actividadEspecifica, $observaciones, $idMunicipio, $idColegio, $idSedeColegio, $grado, $jornada, $escuelaFormacion1, $escuelaFormacion2, $desplazados, $juntos, $familiasAccion, $comedorInfantil, $kitEscolar, $uniforme, $zapatos, $visitaDomiciliaria, $visitaPsicosocial, $visitaAcademica, $intervencionPsicologica, $valoracionMedica, $valoracionOdontologica, $idUser, $fechaActual, $seccion, $kitNutricional, $visitaSeguimiento){
		$actividadEspecifica = $this->real_escape_string($actividadEspecifica);
		$observaciones = $this->real_escape_string($observaciones);
		return $this->query('UPDATE pronino_year SET sitioTrabajo = "'.$sitioTrabajo.'", actividadLaboral = "'.$actividadLaboral.'", actividadEspecifica = "'.$actividadEspecifica.'", observaciones = "'.$observaciones.'",  idMunicipioColegio = "'.$idMunicipio.'", idColegio = "'.$idColegio.'", idSedeColegio = "'.$idSedeColegio.'", grado = "'.$grado.'", jornada = "'.$jornada.'", escuelaFormacion1 = "'.$escuelaFormacion1.'", escuelaFormacion2 = "'.$escuelaFormacion2.'", desplazados = "'.$desplazados.'", juntos = "'.$juntos.'", familiasAccion = "'.$familiasAccion.'", comedorInfantil = "'.$comedorInfantil.'", kitEscolar = "'.$kitEscolar.'", uniforme = "'.$uniforme.'", zapatos = "'.$zapatos.'", visitaDomiciliaria = "'.$visitaDomiciliaria.'", visitaPsicosocial = "'.$visitaPsicosocial.'", visitaAcademica = "'.$visitaAcademica.'", intervencionPsicologica = "'.$intervencionPsicologica.'", valoracionMedica = "'.$valoracionMedica.'", valoracionOdontologica = "'.$valoracionOdontologica.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'", seccion = "'.$seccion.'", kitNutricional = "'.$kitNutricional.'", visitaSeguimiento = "'.$visitaSeguimiento.'" WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'"');	
    }	
	
	public function delete_beneficiario_year_by_year($idBeneficiario, $year){
        return $this->query('DELETE FROM pronino_year WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'"');
    }
	
	/*Notas*/
	public function get_beneficiario_notas_by_year($idBeneficiario, $year){		
        return $this->query('SELECT * FROM pronino_nota WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" ORDER BY idPeriodo, idMateria');
    }
	
	public function get_beneficiario_nota_by_materia($idBeneficiario, $year, $periodo, $materia){		
        return $this->query('SELECT * FROM pronino_nota WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND idPeriodo = "'.$periodo.'" AND idMateria = "'.$materia.'"');
    }
	
	public function insert_beneficiario_nota($idBeneficiario, $year, $periodo, $materia, $tipoNota, $nota, $observaciones, $idUser, $fechaActual){
		$nota = $this->real_escape_string($nota);
		$observaciones = $this->real_escape_string($observaciones);
        return $this->query('INSERT INTO pronino_nota (idBeneficiario, year, idPeriodo, idMateria, tipoNota, nota, observaciones, idUser, fechaActualizacion) VALUES("'.$idBeneficiario.'", "'.$year.'", "'.$periodo.'", "'.$materia.'", "'.$tipoNota.'", "'.$nota.'", "'.$observaciones.'", "'.$idUser.'", "'.$fechaActual.'")');
    }
	
	public function update_beneficiario_nota($idBeneficiario, $year, $periodo, $materia, $tipoNota, $nota, $observaciones, $idUser, $fechaActual){
		$nota = $this->real_escape_string($nota);
		$observaciones = $this->real_escape_string($observaciones);
		return $this->query('UPDATE pronino_nota SET tipoNota = "'.$tipoNota.'", nota = "'.$nota.'", observaciones = "'.$observaciones.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'" WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND idPeriodo = "'.$periodo.'" AND idMateria = "'.$materia.'"');	
    }	
	
	public function delete_beneficiario_nota_by_year($idBeneficiario, $year){
        return $this->query('DELETE FROM pronino_nota WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'"');
    }
	
	public function delete_beneficiario_nota_by_materia($idBeneficiario, $year, $periodo, $materia){
        return $this->query('DELETE FROM pronino_nota WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND idPeriodo = "'.$periodo.'" AND idMateria = "'.$materia.'"');
    }
	
	/*Actividades*/
	public function get_actividades_by_mes($idBeneficiario, $year, $mes){		
        return $this->query('SELECT * FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND mes = "'.$mes.'"');
    }
	
	public function get_actividades_by_periodo($idBeneficiario, $year, $mes){		
		if($mes <= 6)
			return $this->query('SELECT * FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND mes <= 6 ORDER BY dia');
		else	
			return $this->query('SELECT * FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND mes BETWEEN 7 AND 12 ORDER BY dia');
    }
	
	public function get_fecha_actualizacion_year($idBeneficiario, $year){		
        return $this->query('SELECT idUser, fechaActualizacion FROM pronino_year WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'"');
    }
	
	public function get_ultima_fecha_actualizacion_mes($idBeneficiario, $mes){		
        return $this->query('SELECT MAX(fechaActualizacion), idUser FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND mes = "'.$mes.'"');
    }
	
	public function get_ultima_fecha_actualizacion($idBeneficiario){		
        return $this->query('SELECT MAX(fechaActualizacion), idUser FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function insert_actividad_mes($idBeneficiario, $year, $mes, $dia, $hora, $actividad, $idUser, $fechaActual){		
        return $this->query('INSERT INTO pronino_mes (idBeneficiario, year, mes, dia, hora, idActividad, idUser, fechaActualizacion) VALUES("'.$idBeneficiario.'", "'.$year.'", "'.$mes.'", "'.$dia.'", "'.$hora.'", "'.$actividad.'", "'.$idUser.'", "'.$fechaActual.'")');
    }
	
	public function delete_actividades_mes($idBeneficiario, $year, $mes){		
        return $this->query('DELETE FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'" AND mes = "'.$mes.'"');
    }	
	
	public function delete_beneficiario_mes_by_year($idBeneficiario, $year){
        return $this->query('DELETE FROM pronino_mes WHERE idBeneficiario = "'.$idBeneficiario.'" AND year = "'.$year.'"');
    }
	
	/*Diagnostico Inicial*/
	public function get_diagnostico_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_diagnostico WHERE pronino_diagnostico.idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	public function insert_beneficiario_diagnostico($idBeneficiario, $remitido, $profesional, $situacionLaboral, $descripcion, $observaciones, $idUser, $fechaActual){
		$situacionLaboral = $this->real_escape_string($situacionLaboral);
		$descripcion = $this->real_escape_string($descripcion);
		$observaciones = $this->real_escape_string($observaciones);
        return $this->query('INSERT INTO pronino_diagnostico (idBeneficiario, remitido, idProfesional, situacionLaboral, descripcionEscenarios, observacionesDiagnostico, idUser, fechaActualizacion) VALUES("'.$idBeneficiario.'", "'.$remitido.'", "'.$profesional.'", "'.$situacionLaboral.'", "'.$descripcion.'", "'.$observaciones.'", "'.$idUser.'", "'.$fechaActual.'")');
    }
	
	public function update_beneficiario_diagnostico($idBeneficiario, $remitido, $profesional, $situacionLaboral, $descripcion, $observaciones, $idUser, $fechaActual){
		$situacionLaboral = $this->real_escape_string($situacionLaboral);
		$descripcion = $this->real_escape_string($descripcion);
		$observaciones = $this->real_escape_string($observaciones);
		return $this->query('UPDATE pronino_diagnostico SET remitido = "'.$remitido.'", idProfesional = "'.$profesional.'", situacionLaboral = "'.$situacionLaboral.'", descripcionEscenarios = "'.$descripcion.'", observacionesDiagnostico = "'.$observaciones.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'" WHERE idBeneficiario = "'.$idBeneficiario.'"');	
    }
	
	public function delete_beneficiario_diagnostico($idBeneficiario){
        return $this->query('DELETE FROM pronino_diagnostico WHERE idBeneficiario = "'.$idBeneficiario.'"');
    }
	
	/*Seguimiento Visitas Domiciliarias*/
	public function get_seguimiento_by_id($idSeguimiento){		
        return $this->query('SELECT * FROM pronino_seguimiento WHERE idSeguimiento = "'.$idSeguimiento.'"');
    }
	
	public function get_seguimiento_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_seguimiento WHERE idBeneficiario = "'.$idBeneficiario.'" ORDER BY fechaSeguimiento, fechaActualizacion');
    }
	
	public function insert_beneficiario_seguimiento($idBeneficiario, $fechaSeguimiento, $profesional, $motivo, $descripcion, $idUser, $fechaActual){
		$motivo = $this->real_escape_string($motivo);
		$descripcion = $this->real_escape_string($descripcion);	
        return $this->query('INSERT INTO pronino_seguimiento (idBeneficiario, fechaSeguimiento, idProfesional, motivo, descripcion, idUser, fechaActualizacion) VALUES("'.$idBeneficiario.'", "'.$fechaSeguimiento.'", "'.$profesional.'", "'.$motivo.'", "'.$descripcion.'", "'.$idUser.'", "'.$fechaActual.'")');
    }
	
	public function update_beneficiario_seguimiento($idSeguimiento, $idBeneficiario, $fechaSeguimiento, $profesional, $motivo, $descripcion, $idUser, $fechaActual){
		$motivo = $this->real_escape_string($motivo);
		$descripcion = $this->real_escape_string($descripcion);
		return $this->query('UPDATE pronino_seguimiento SET fechaSeguimiento = "'.$fechaSeguimiento.'", idProfesional = "'.$profesional.'", motivo = "'.$motivo.'", descripcion = "'.$descripcion.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'" WHERE idSeguimiento = "'.$idSeguimiento.'"');	
    }
	
	public function delete_beneficiario_seguimiento($idSeguimiento){
        return $this->query('DELETE FROM pronino_seguimiento WHERE idSeguimiento = "'.$idSeguimiento.'"');
    }
	
	/*Atencion Psicosocial*/
	public function get_psicosocial_by_id($idPsicosocial){		
        return $this->query('SELECT * FROM pronino_psicosocial WHERE idAtencionPsicosocial = "'.$idPsicosocial.'"');
    }
	
	public function get_psicosocial_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_psicosocial WHERE idBeneficiario = "'.$idBeneficiario.'" ORDER BY fechaRemision, fechaActualizacion');
    }
	
	public function insert_beneficiario_psicosocial($idBeneficiario, $fechaRemision, $remitido, $aspectoAcademico, $aspectoComportamiento, $aspectoComunicativo, $aspectoFamiliar, $motivoAspectoAcademico, $motivoAspectoComportamiento, $motivoAspectoComunicativo, $motivoAspectoFamiliar, $accionesRealizadas, $remitidoUAI, $remitidoPsicologia, $remitidoTerapiaOcupacional, $remitidoRefuerzoEscolar, $remitidoOtrasInstituciones, $idUser, $fechaActual){
		$motivoAspectoAcademico = $this->real_escape_string($motivoAspectoAcademico);
		$motivoAspectoComportamiento = $this->real_escape_string($motivoAspectoComportamiento);
		$motivoAspectoComunicativo = $this->real_escape_string($motivoAspectoComunicativo);
		$motivoAspectoFamiliar = $this->real_escape_string($motivoAspectoFamiliar);
		$accionesRealizadas = $this->real_escape_string($accionesRealizadas);
		$remitidoOtrasInstituciones = $this->real_escape_string($remitidoOtrasInstituciones);
        return $this->query('INSERT INTO pronino_psicosocial (idBeneficiario, fechaRemision, remitido, aspectoAcademico, aspectoComportamiento, aspectoComunicativo, aspectoFamiliar, motivoAspectoAcademico, motivoAspectoComportamiento, motivoAspectoComunicativo, motivoAspectoFamiliar, accionesRealizadas, remitidoUAI, remitidoPsicologia, remitidoTerapiaOcupacional, remitidoRefuerzoEscolar, remitidoOtrasInstituciones, idUser, fechaActualizacion) VALUES("'.$idBeneficiario.'", "'.$fechaRemision.'", "'.$remitido.'", "'.$aspectoAcademico.'", "'.$aspectoComportamiento.'", "'.$aspectoComunicativo.'", "'.$aspectoFamiliar.'", "'.$motivoAspectoAcademico.'", "'.$motivoAspectoComportamiento.'", "'.$motivoAspectoComunicativo.'", "'.$motivoAspectoFamiliar.'", "'.$accionesRealizadas.'", "'.$remitidoUAI.'", "'.$remitidoPsicologia.'", "'.$remitidoTerapiaOcupacional.'", "'.$remitidoRefuerzoEscolar.'", "'.$remitidoOtrasInstituciones.'", "'.$idUser.'", "'.$fechaActual.'")');
    }
	
	public function update_beneficiario_psicosocial($idPsicosocial, $idBeneficiario, $fechaRemision, $remitido, $aspectoAcademico, $aspectoComportamiento, $aspectoComunicativo, $aspectoFamiliar, $motivoAspectoAcademico, $motivoAspectoComportamiento, $motivoAspectoComunicativo, $motivoAspectoFamiliar, $accionesRealizadas, $remitidoUAI, $remitidoPsicologia, $remitidoTerapiaOcupacional, $remitidoRefuerzoEscolar, $remitidoOtrasInstituciones, $idUser, $fechaActual){
		$motivoAspectoAcademico = $this->real_escape_string($motivoAspectoAcademico);
		$motivoAspectoComportamiento = $this->real_escape_string($motivoAspectoComportamiento);
		$motivoAspectoComunicativo = $this->real_escape_string($motivoAspectoComunicativo);
		$motivoAspectoFamiliar = $this->real_escape_string($motivoAspectoFamiliar);
		$accionesRealizadas = $this->real_escape_string($accionesRealizadas);
		$remitidoOtrasInstituciones = $this->real_escape_string($remitidoOtrasInstituciones);
		return $this->query('UPDATE pronino_psicosocial SET fechaRemision = "'.$fechaRemision.'", remitido = "'.$remitido.'", aspectoAcademico = "'.$aspectoAcademico.'", aspectoComportamiento = "'.$aspectoComportamiento.'", aspectoComunicativo = "'.$aspectoComunicativo.'", aspectoFamiliar = "'.$aspectoFamiliar.'", motivoAspectoAcademico = "'.$motivoAspectoAcademico.'", motivoAspectoComportamiento = "'.$motivoAspectoComportamiento.'", motivoAspectoComunicativo = "'.$motivoAspectoComunicativo.'", motivoAspectoFamiliar = "'.$motivoAspectoFamiliar.'", accionesRealizadas = "'.$accionesRealizadas.'", remitidoUAI = "'.$remitidoUAI.'", remitidoPsicologia = "'.$remitidoPsicologia.'", remitidoTerapiaOcupacional = "'.$remitidoTerapiaOcupacional.'", remitidoRefuerzoEscolar = "'.$remitidoRefuerzoEscolar.'", remitidoOtrasInstituciones = "'.$remitidoOtrasInstituciones.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'" WHERE idAtencionPsicosocial = "'.$idPsicosocial.'"');	
    }	
	
	public function delete_beneficiario_psicosocial($idPsicosocial){
        return $this->query('DELETE FROM pronino_psicosocial WHERE idAtencionPsicosocial = "'.$idPsicosocial.'"');
    }
	
	/*Atencion Psicologia*/
	public function get_psicologia_by_id($idPsicologia){		
        return $this->query('SELECT * FROM pronino_psicologia WHERE idAtencionPsicologia = "'.$idPsicologia.'"');
    }
	
	public function get_psicologia_by_beneficiario($idBeneficiario){		
        return $this->query('SELECT * FROM pronino_psicologia WHERE idBeneficiario = "'.$idBeneficiario.'" ORDER BY fechaActualizacion');
    }
	
	public function insert_beneficiario_psicologia($idBeneficiario, $fechaAtencionPsicologia, $observacionesPsicologia, $impresionDiagnostica, $planIntervencion, $idUser, $fechaActual){
		$observacionesPsicologia = $this->real_escape_string($observacionesPsicologia);
		$impresionDiagnostica = $this->real_escape_string($impresionDiagnostica);
		$planIntervencion = $this->real_escape_string($planIntervencion);		
        return $this->query('INSERT INTO pronino_psicologia (idBeneficiario, fechaAtencionPsicologia observacionesPsicologia, impresionDiagnostica, planIntervencion, idUser, fechaActualizacion) VALUES("'.$idBeneficiario.'", "'.$fechaAtencionPsicologia.'", "'.$observacionesPsicologia.'", "'.$impresionDiagnostica.'", "'.$planIntervencion.'", "'.$idUser.'", "'.$fechaActual.'")');
    }
	
	public function update_beneficiario_psicologia($idPsicologia, $idBeneficiario, $fechaAtencionPsicologia, $observacionesPsicologia, $impresionDiagnostica, $planIntervencion, $idUser, $fechaActual){
		$observacionesPsicologia = $this->real_escape_string($observacionesPsicologia);
		$impresionDiagnostica = $this->real_escape_string($impresionDiagnostica);
		$planIntervencion = $this->real_escape_string($planIntervencion);
		return $this->query('UPDATE pronino_psicologia SET fechaAtencionPsicologia = "'.$fechaAtencionPsicologia.'", observacionesPsicologia = "'.$observacionesPsicologia.'", impresionDiagnostica = "'.$impresionDiagnostica.'", planIntervencion = "'.$planIntervencion.'", idUser = "'.$idUser.'", fechaActualizacion = "'.$fechaActual.'" WHERE idAtencionPsicologia = "'.$idPsicologia.'"');	
    }	
	
	public function delete_beneficiario_psicologia($idPsicologia){
        return $this->query('DELETE FROM pronino_psicologia WHERE idAtencionPsicologia = "'.$idPsicologia.'"');
    }
}
?>
