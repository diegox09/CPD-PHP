<?php
	include_once('../../php/mail/class.phpmailer.php');
	require_once('classes/Pronino.php');
		
	$usuario = utf8_decode($_GET['user']);
		
	$result = Pronino::getInstance()->get_passwd_by_usuario($usuario);
	
	if(mysqli_num_rows($result) == 0)	
		$consulta = false;
	else{	
		while ($user = mysqli_fetch_array($result)){
			$consulta = true;				
			$nombre = utf8_encode($user['nombreUser']);			
			$passwd = utf8_encode($user['passwd']);
			$email = utf8_encode($user['email']);				
			
			$body = '<p>Cordial Saludo,</p>
					<p><strong>'.$nombre.'</strong></p>
					<div style="text-align:justify">Datos de ingreso</div>
					<p>
						Usuario: <strong>'.$usuario.'</strong><br> 
						Contraseña: <strong>'.$passwd.'</strong>
					</p>
					<p><a href="sgc.corprodinco.org/pronino" >sgc.corprodinco.org/pronino</a></p>
					<p><img src="../img/logo.png" /></p>';

			$mail             = new PHPMailer();
						
			$mail->IsSendmail(); // telling the class to use SendMail transport
			
			$mail->From       = "sgc@corprodinco.org";
			$mail->FromName   = "Corprodinco";
			$mail->Subject    = "Recordatorio de datos de ingreso";			
			$mail->WordWrap   = 50;
			$mail->MsgHTML($body);
			$mail->AddAddress($email, $nombre); 
			$mail->AddCC("sgc@diegox09.co.cc"); 
			$mail->IsHTML(true); 
			
			if(!$mail->Send())
			  	$error = true;
			else
			  	$error = false;
		}
		$respuesta['email'] = $email;
	}
	$respuesta['error'] = $error;
	$respuesta['consulta'] = $consulta;
	$respuesta['usuario'] = $usuario;
	
	print_r(json_encode($respuesta));
?>
