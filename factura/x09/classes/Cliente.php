<?php
class Cliente extends mysqli {

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
	
	public function get_cliente() {
		return $this->query('SELECT * FROM cliente WHERE idCliente != "0" ORDER BY nombres');
    }
		
	public function get_cliente_by_nit($nit) {
        $nit = $this->real_escape_string($nit);
		return $this->query('SELECT * FROM cliente WHERE nit = "'.$nit.'"');
    }
	
	public function get_cliente_by_nombres($nombres) {
        $nombres = $this->real_escape_string($nombres);
		return $this->query('SELECT * FROM cliente WHERE nombres LIKE "%'.$nombres.'%" ORDER BY nombres LIMIT 15');
    }
	
	public function get_cliente_by_id($id) {
        $id = $this->real_escape_string($id);
		return $this->query('SELECT * FROM cliente WHERE idCliente = "'.$id.'"');
    }
	
	public function insert_nit_cliente($nit) {
        $nit = $this->real_escape_string($nit);		
        return $this->query('INSERT INTO cliente (nit) VALUES("'.$nit.'")');
    }
		
	public function insert_cliente($nit, $nombres, $telefono, $direccion) {
        $nit = $this->real_escape_string($nit);
		$nombres = $this->real_escape_string($nombres);
		$telefono = $this->real_escape_string($telefono);
		$direccion = $this->real_escape_string($direccion);
        return $this->query('INSERT INTO cliente (nit, nombres, telefono, direccion) VALUES("'.$nit.'", "'.$nombres.'", "'.$telefono.'", "'.$direccion.'")');
    }
	
	public function update_cliente($idCliente, $nit, $nombres, $telefono, $direccion) {
        $idCliente = $this->real_escape_string($idCliente);
		$nit = $this->real_escape_string($nit);
		$nombres = $this->real_escape_string($nombres);
		$telefono = $this->real_escape_string($telefono);
		$direccion = $this->real_escape_string($direccion);
        return $this->query('UPDATE cliente SET nit = "'.$nit.'", nombres = "'.$nombres.'", telefono = "'.$telefono.'", direccion = "'.$direccion.'" WHERE idCliente = "'.$idCliente.'"');
    }	
	
	public function delete_cliente($idCliente) {
        return $this->query('DELETE FROM cliente WHERE idCliente = "'.$idCliente.'"');
    }
}
?>
