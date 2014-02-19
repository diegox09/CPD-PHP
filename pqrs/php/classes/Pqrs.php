<?php
class Pqrs extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
	
    private $user = 'admincorpro_pqrs';
    private $passwd = 'DiEgOx09';
    private $dbName = 'admincorpro_pqrs';
    private $dbHost = 'pdb1.awardspace.com';
	
	/*
	private $user = 'root';
    private $passwd = 'sputnik';
    private $dbName = 'pqrs';
    private $dbHost = 'localhost';
	*/	
	/*
	Tipo de Usuario
	1. Usuario
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
        return $this->query('SELECT * FROM usuario WHERE idUser = "'.$idUser.'"');
    }
	
	public function get_user_by_nombre($nombreUser) { 
		$nombreUser = $this->real_escape_string($nombreUser);
        return $this->query('SELECT * FROM usuario WHERE user = "'.$nombreUser.'"');
    }
	
	public function get_cliente_by_id($idCliente) { 
        return $this->query('SELECT * FROM cliente WHERE idCliente = "'.$idCliente.'"');
    }
	
	public function get_pqrs_by_id($idPqrs) { 
        return $this->query('SELECT * FROM pqrs WHERE idPqrs = "'.$idPqrs.'"');
    }	
}
?>
