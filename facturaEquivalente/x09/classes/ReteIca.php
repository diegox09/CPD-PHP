<?php
class ReteIca extends mysqli {

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
		
	public function get_reteica() {		
        return $this->query('SELECT * FROM reteica ORDER BY tipoActividad, actividad');
    }	
	
	public function get_reteica_by_id($idReteica) {		
        return $this->query('SELECT * FROM reteica WHERE idTarifaIca = "'.$idReteica.'"');
    }
	
	public function get_reteica_by_actividad($actividad) {		
        return $this->query('SELECT * FROM reteica WHERE actividad = "'.$actividad.'"');
    }	
	
	public function insert_reteica($ciiu, $tipoActividad, $actividad, $tarifa) {
        return $this->query('INSERT INTO reteica (ciiu, tipoActividad, actividad, tarifa) VALUES("'.$ciiu.'", "'.$tipoActividad.'", "'.$actividad.'", "'.$tarifa.'")');
    }
	
	public function update_reteica($idReteica, $ciiu, $tipoActividad, $actividad, $tarifa) {		
       return $this->query('UPDATE reteica SET ciiu = "'.$ciiu.'", tipoActividad = "'.$tipoActividad.'", actividad = "'.$actividad.'", tarifa = "'.$tarifa.'" WHERE idTarifaIca = "'.$idReteica.'"');
    }
	
	public function delete_reteica($idReteica) {
        return $this->query('DELETE FROM reteica WHERE idTarifaIca = "'.$idReteica.'"');
    }
}
?>
