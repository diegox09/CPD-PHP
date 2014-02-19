<?php
class Factura extends mysqli {

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
		
	public function set_numero($idPrograma) {
		$idPrograma = $this->real_escape_string($idPrograma);
        return $this->query('SELECT max(numeroFactura) as numero FROM factura WHERE idPrograma = "'.$idPrograma.'"');
    }	
	
	public function get_id_factura($idPrograma, $numeroFactura) {		
        return $this->query('SELECT idFactura FROM factura WHERE idPrograma = "'.$idPrograma.'" AND numeroFactura = "'.$numeroFactura.'"');
    }
	
	public function get_factura($idPrograma, $numeroFactura) {		
        return $this->query('SELECT * FROM factura WHERE idPrograma = "'.$idPrograma.'" AND numeroFactura = "'.$numeroFactura.'"');
    }
	
	public function get_factura_by_id($idFactura) {		
        return $this->query('SELECT * FROM factura WHERE idFactura = "'.$idFactura.'"');
    }
	
	public function get_factura_by_programa_fecha($idPrograma, $fecha) {		
        return $this->query('SELECT * FROM factura WHERE idPrograma = "'.$idPrograma.'" AND fecha = "'.$fecha.'" ORDER BY numeroFactura');
    }
	
	public function get_factura_by_nit($idCliente) {		
        return $this->query('SELECT * FROM factura WHERE idCliente = "'.$idCliente.'" ORDER BY fecha, idPrograma');
    }
	
	public function get_factura_by_user($idUser) {		
        return $this->query('SELECT * FROM factura WHERE idUser = "'.$idUser.'" ORDER BY fecha, idPrograma');
    }
		
	public function get_factura_by_programa($idPrograma) {		
        return $this->query('SELECT * FROM factura WHERE idPrograma = "'.$idPrograma.'" ORDER BY numeroFactura');
    }
	
	public function get_factura_by_fecha($fecha) {		
        return $this->query('SELECT * FROM factura WHERE fecha = "'.$fecha.'" ORDER BY idPrograma, numeroFactura');
    }		
	
	public function get_item($idFactura) {
		return $this->query('SELECT * FROM item_factura WHERE idFactura = "'.$idFactura.'" ORDER BY ubicacion');
    }
	
	public function insert_factura($idPrograma, $numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $idUser, $idEstadoFactura, $tarifaIva, $tarifaRetencionIva, $retencionFuente, $impuestoRenta, $retencionIca, $ivaAsumido) {		
        return $this->query('INSERT INTO factura (idPrograma, numeroFactura, ciudad, fecha, fechaActualizacion, idCliente, idUser, idEstadoFactura, tarifaIva, tarifaRetencionIva, retencionFuente, impuestoRenta, retencionIca, ivaAsumido) VALUES("'.$idPrograma.'", "'.$numeroFactura.'", "'.$ciudad.'", "'.$fecha.'", "'.$fechaActual.'", "'.$idCliente.'", "'.$idUser.'", "'.$idEstadoFactura.'", "'.$tarifaIva.'", "'.$tarifaRetencionIva.'", "'.$retencionFuente.'", "'.$impuestoRenta.'", "'.$retencionIca.'" , "'.$ivaAsumido.'")');
    }
	
	public function insert_item($idFactura, $ubicacion, $referencia, $descripcion, $cantidad, $valor) {        
        return $this->query('INSERT INTO item_factura (idFactura, ubicacion, referencia, descripcion, cantidad, valor) VALUES("'.$idFactura.'", "'.$ubicacion.'", "'.$referencia.'", "'.$descripcion.'", "'.$cantidad.'", "'.$valor.'")');
    }
	
	public function update_factura($idPrograma, $numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $idUser, $idEstadoFactura, $tarifaIva, $tarifaRetencionIva, $retencionFuente, $impuestoRenta, $retencionIca, $ivaAsumido) {		
       return $this->query('UPDATE factura SET ciudad = "'.$ciudad.'", fecha = "'.$fecha.'", fechaActualizacion = "'.$fechaActual.'", idCliente = "'.$idCliente.'", idUser = "'.$idUser.'", idEstadoFactura = "'.$idEstadoFactura.'", tarifaIva = "'.$tarifaIva.'", tarifaRetencionIva = "'.$tarifaRetencionIva.'", retencionFuente = "'.$retencionFuente.'", impuestoRenta = "'.$impuestoRenta.'", retencionIca = "'.$retencionIca.'", ivaAsumido = "'.$ivaAsumido.'" WHERE idPrograma = "'.$idPrograma.'" AND numeroFactura = "'.$numeroFactura.'"');
    }		
	
	public function update_item($idFactura, $ubicacion, $referencia, $descripcion, $cantidad, $valor) {
        return $this->query('UPDATE item_factura SET referencia = "'.$referencia.'", descripcion = "'.$descripcion.'", cantidad = "'.$cantidad.'", valor = "'.$valor.'" WHERE idFactura = "'.$idFactura.'" AND ubicacion = "'.$ubicacion.'"');
    }
	
	public function update_numero_factura($idFactura, $numeroNuevo) {
        return $this->query('UPDATE factura SET numeroFactura = "'.$numeroNuevo.'" WHERE idFactura = "'.$idFactura.'"');
    }
		
	public function delete_factura($idFactura) {
        return $this->query('DELETE FROM factura WHERE idFactura = "'.$idFactura.'"');
    }
	
	public function delete_item_factura($idFactura) {
        return $this->query('DELETE FROM item_factura WHERE idFactura = "'.$idFactura.'"');
    }
}
?>
