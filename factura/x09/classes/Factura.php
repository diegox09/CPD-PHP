<?php
class Factura extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = 'diegox09';
    private $passwd = 'sputnik_86';
    private $dbName = 'cpd_factura';
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
        parent::set_charset('utf-8');
    }
		
	public function set_numero() {		
        return $this->query('SELECT max(numeroFactura) as numero FROM factura');
    }
	
	public function get_min_factura() {       
        return 1744;
    }
	
	public function get_max_factura() {       
        return 2300;
    }	
	
	public function get_id_factura($numeroFactura) {		
        return $this->query('SELECT idFactura FROM factura WHERE numeroFactura = "'.$numeroFactura.'"');
    }
	
	public function get_all_factura() {		
        return $this->query('SELECT * FROM factura');
    }
	
	public function get_factura($numeroFactura) {		
        return $this->query('SELECT * FROM factura WHERE numeroFactura = "'.$numeroFactura.'"');
    }
	
	public function get_factura_by_id($idFactura) {		
        return $this->query('SELECT * FROM factura WHERE idFactura = "'.$idFactura.'"');
    }
			
	public function get_factura_by_nit($nit) {		
        return $this->query('SELECT * FROM factura WHERE nit = "'.$nit.'" ORDER BY numeroFactura');
    }
	
	public function get_factura_by_user($idUser) {		
        return $this->query('SELECT * FROM factura WHERE idUser = "'.$idUser.'" ORDER BY numeroFactura');
    }
			
	public function get_factura_by_fecha($fecha) {		
        return $this->query('SELECT * FROM factura WHERE fecha = "'.$fecha.'" ORDER BY numeroFactura');
    }		
		
	public function insert_factura($numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $nit, $nombres, $telefono, $direccion, $idUser, $idEstadoFactura, $descripcion, $valor, $tarifaIva, $observaciones, $descripcionValor, $subtotal, $valorIva, $facturaManual) {		
        return $this->query('INSERT INTO factura (numeroFactura, ciudad, fecha, fechaActualizacion, idCliente, nit, nombres, telefono, direccion, idUser, idEstadoFactura, descripcion, valor, tarifaIva, observaciones, descripcionValor, subtotal, valorIva, facturaManual) VALUES("'.$numeroFactura.'", "'.$ciudad.'", "'.$fecha.'", "'.$fechaActual.'", "'.$idCliente.'", "'.$nit.'", "'.$nombres.'", "'.$telefono.'", "'.$direccion.'", "'.$idUser.'", "'.$idEstadoFactura.'", "'.$descripcion.'", "'.$valor.'", "'.$tarifaIva.'", "'.$observaciones.'", "'.$descripcionValor.'", "'.$subtotal.'", "'.$valorIva.'", "'.$facturaManual.'")');
    }
		
	public function update_factura($numeroFactura, $ciudad, $fecha, $fechaActual, $idCliente, $nit, $nombres, $telefono, $direccion, $idUser, $idEstadoFactura, $descripcion, $valor, $tarifaIva, $observaciones, $descripcionValor, $subtotal, $valorIva, $facturaManual) {				
       return $this->query('UPDATE factura SET ciudad = "'.$ciudad.'", fecha = "'.$fecha.'", fechaActualizacion = "'.$fechaActual.'", idCliente = "'.$idCliente.'", nit = "'.$nit.'", nombres = "'.$nombres.'", telefono = "'.$telefono.'", direccion = "'.$direccion.'", idUser = "'.$idUser.'", idEstadoFactura = "'.$idEstadoFactura.'", descripcion = "'.$descripcion.'", valor = "'.$valor.'", tarifaIva = "'.$tarifaIva.'", observaciones = "'.$observaciones.'", descripcionValor = "'.$descripcionValor.'", subtotal = "'.$subtotal.'", valorIva = "'.$valorIva.'", facturaManual = "'.$facturaManual.'" WHERE numeroFactura = "'.$numeroFactura.'"');
    }			
}
?>
