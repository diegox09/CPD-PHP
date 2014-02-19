<?php
class User extends mysqli {

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
		
	public function verify_credentials($user, $passwd) {
        $user = $this->real_escape_string($user);
        $passwd = $this->real_escape_string($passwd);
        $result = $this->query('SELECT 1 FROM usuario WHERE user = "'.$user.'" AND passwd = "'.$passwd.'"');
        return $result->data_seek(0);
	}	
	
	public function verify_passwd($idUser, $passwd) {
        $idUser = $this->real_escape_string($idUser);
        $passwd = $this->real_escape_string($passwd);
        $result = $this->query('SELECT 1 FROM usuario WHERE idUser = "'.$idUser.'" AND passwd = "'.$passwd.'"');
        return $result->data_seek(0);
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
	
	public function get_user() {       
        return $this->query('SELECT usuario.idPerfil, usuario.idUser, usuario.nombre, usuario.email, usuario.user, perfil.descripcion FROM usuario, perfil WHERE usuario.idPerfil = perfil.idPerfil');
    }
	
	public function get_user_by_id($idUser) {       
        return $this->query('SELECT usuario.idPerfil, usuario.idUser, usuario.nombre, usuario.email, usuario.user, perfil.descripcion FROM usuario, perfil WHERE usuario.idUser = "'.$idUser.'" AND usuario.idPerfil = perfil.idPerfil');
    }
	
	public function get_user_by_name($user) {       
        return $this->query('SELECT usuario.idPerfil, usuario.idUser, usuario.nombre, usuario.email, usuario.user, perfil.descripcion FROM usuario, perfil WHERE usuario.user = "'.$user.'" AND usuario.idPerfil = perfil.idPerfil');
    }
			
	public function get_menu_user_by_perfil($perfil) {       
        return $this->query('SELECT submenu.descripcion, item_menu.descripcion, item_menu.iniciales FROM menu, submenu, item_menu  WHERE menu.idPerfil = "'.$perfil.'" AND menu.idSubmenu = submenu.idSubmenu AND menu.idItem = item_menu.idItem ORDER BY submenu.idSubmenu, item_menu.idItem');
    }
	
	public function get_administrador() {       
        return 3;
    }
	
	public function change_passwd($idUser, $passwdNew) {
        $idUser = $this->real_escape_string($idUser);		
		$passwdNew = $this->real_escape_string($passwdNew);
        return $this->query('UPDATE usuario SET passwd = "'.$passwdNew.'" WHERE idUser = "'.$idUser.'"');
    }	
	
	public function insert_user($user, $nombre, $passwd, $email, $idPerfil) {
        $user = $this->real_escape_string($user);
		$nombre = $this->real_escape_string($nombre);
		$passwd = $this->real_escape_string($passwd);
		$email = $this->real_escape_string($email);
		$idPerfil = $this->real_escape_string($idPerfil);
        return $this->query('INSERT INTO usuario (user, nombre, passwd, email, idPerfil) VALUES("'.$user.'", "'.$nombre.'", "'.$passwd.'", "'.$email.'", "'.$idPerfil.'")');
    }
	
	public function update_user($idUser, $user, $nombre, $email, $idPerfil) {
        $idUser = $this->real_escape_string($idUser);
        $user = $this->real_escape_string($user);
		$nombre = $this->real_escape_string($nombre);		
		$email = $this->real_escape_string($email);
		$idPerfil = $this->real_escape_string($idPerfil);
        return $this->query('UPDATE usuario SET user = "'.$user.'", nombre = "'.$nombre.'", email = "'.$email.'", idPerfil = "'.$idPerfil.'" WHERE idUser = "'.$idUser.'"');
    }
	
	public function delete_user($idUser) {
        return $this->query('DELETE FROM usuario WHERE idUser = "'.$idUser.'"');
    }
}
?>
