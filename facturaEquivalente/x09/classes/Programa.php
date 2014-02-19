<?php
class Programa extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = 'diegox09';
    private $passwd = 'sputnik_86';
    private $dbName = 'cpd_fe';
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
			
	public function get_programa() {		
        return $this->query('SELECT programa.idPrograma, programa.nombre, programa.contrato, programa.direccion, programa.ciudad, tipo_factura.iniciales, tipo_factura.idTipoFactura, tipo_factura.descripcion FROM programa, tipo_factura WHERE programa.idTipoFactura = tipo_factura.idTipoFactura ORDER BY tipo_factura.idTipoFactura, programa.nombre');
    }
	
	public function get_programa_by_user($idUser) {		
        return $this->query('SELECT programa.idPrograma, programa.nombre, programa.contrato, programa.direccion, programa.ciudad, tipo_factura.iniciales, tipo_factura.idTipoFactura, tipo_factura.descripcion FROM user_programa, programa, tipo_factura WHERE user_programa.idUser = "'.$idUser.'" AND user_programa.idPrograma = programa.idPrograma AND programa.idTipoFactura = tipo_factura.idTipoFactura ORDER BY programa.nombre');
    }	
	
	public function get_programa_by_user_tf($idUser, $idTipoFactura) {		
        return $this->query('SELECT programa.idPrograma, programa.nombre, programa.contrato, programa.direccion, programa.ciudad, tipo_factura.iniciales, tipo_factura.idTipoFactura, tipo_factura.descripcion FROM user_programa, programa, tipo_factura WHERE user_programa.idUser = "'.$idUser.'" AND user_programa.idPrograma = programa.idPrograma AND programa.idTipoFactura = "'.$idTipoFactura.'" AND programa.idTipoFactura = tipo_factura.idTipoFactura ORDER BY programa.nombre');
    }
	
	public function get_programa_by_user_p($idPrograma) {		
        return $this->query('SELECT * FROM user_programa, programa WHERE user_programa.idPrograma = "'.$idPrograma.'" AND user_programa.idPrograma = programa.idPrograma');
    }
			
	
	public function get_programa_by_id($idPrograma) {		
        return $this->query('SELECT programa.idPrograma, programa.nombre, programa.contrato, programa.direccion, programa.ciudad, tipo_factura.iniciales, tipo_factura.idTipoFactura, tipo_factura.descripcion FROM programa, tipo_factura WHERE programa.idPrograma = "'.$idPrograma.'" AND programa.idTipoFactura = tipo_factura.idTipoFactura');
    }
	
	public function get_programa_by_nombre($nombre, $idTipoFactura) {		
        return $this->query('SELECT programa.idPrograma, programa.nombre, programa.contrato, programa.direccion, programa.ciudad, tipo_factura.iniciales, tipo_factura.idTipoFactura, tipo_factura.descripcion FROM programa, tipo_factura WHERE programa.nombre = "'.$nombre.'" AND programa.idTipoFactura = "'.$idTipoFactura.'" AND programa.idTipoFactura = tipo_factura.idTipoFactura');
    }
	
	public function insert_programa($nombre, $idTipoFactura, $contrato, $direccion, $ciudad) {
        return $this->query('INSERT INTO programa (nombre, idTipoFactura, contrato, direccion, ciudad) VALUES("'.$nombre.'", "'.$idTipoFactura.'", "'.$contrato.'", "'.$direccion.'", "'.$ciudad.'")');
    }
	
	public function insert_user_programa($idUser, $idPrograma) {
        return $this->query('INSERT INTO user_programa (idUser, idPrograma) VALUES("'.$idUser.'", "'.$idPrograma.'")');
    }
	
	public function update_programa($idPrograma, $nombre, $idTipoFactura, $contrato, $direccion, $ciudad) {		
       return $this->query('UPDATE programa SET nombre = "'.$nombre.'", idTipoFactura = "'.$idTipoFactura.'", contrato = "'.$contrato.'", direccion = "'.$direccion.'", ciudad = "'.$ciudad.'" WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	public function delete_programa($idPrograma) {
        return $this->query('DELETE FROM programa WHERE idPrograma = "'.$idPrograma.'"');
    }
	
	public function delete_user_programa($idUser, $idPrograma) {
        return $this->query('DELETE FROM user_programa WHERE idUser = "'.$idUser.'" AND idPrograma = "'.$idPrograma.'"');
    }
}
?>
