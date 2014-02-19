<?php
class Porcentaje extends mysqli {

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
		
	public function get_porcentaje() {		
        return $this->query('SELECT * FROM porcentaje_retencion ORDER BY tipoConcepto, concepto');
    }
	
	public function get_porcentaje_by_id($idPorcentaje) {		
        return $this->query('SELECT * FROM porcentaje_retencion WHERE idPorcentajeRetencion = "'.$idPorcentaje.'"');
    }	
	
	public function get_porcentaje_by_concepto($concepto) {		
        return $this->query('SELECT * FROM porcentaje_retencion WHERE concepto = "'.$concepto.'"');
    }	
	
	public function insert_porcentaje($tipoConcepto, $concepto, $tarifaIva, $retencionIva, $retencionFuente) {
        return $this->query('INSERT INTO porcentaje_retencion (tipoConcepto, concepto, tarifaIva, retencionIva, retencionFuente) VALUES("'.$tipoConcepto.'", "'.$concepto.'", "'.$tarifaIva.'", "'.$retencionIva.'", "'.$retencionFuente.'")');
    }
	
	public function update_porcentaje($idPorcentaje, $tipoConcepto, $concepto, $tarifaIva, $retencionIva, $retencionFuente) {		
       return $this->query('UPDATE porcentaje_retencion SET tipoConcepto = "'.$tipoConcepto.'", concepto = "'.$concepto.'", tarifaIva = "'.$tarifaIva.'", retencionIva = "'.$retencionIva.'", retencionFuente = "'.$retencionFuente.'" WHERE idPorcentajeRetencion = "'.$idPorcentaje.'"');
    }
	
	public function delete_porcentaje($idPorcentaje) {
        return $this->query('DELETE FROM porcentaje_retencion WHERE idPorcentajeRetencion = "'.$idPorcentaje.'"');
    }	
}
?>
