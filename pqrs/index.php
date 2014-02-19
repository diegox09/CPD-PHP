<?php	
	session_start();
	  		
	if (array_key_exists('id_pqr', $_SESSION))
		header("Location: inbox.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Diego Fernando Rodriguez Rincon">
	<title>Recepción y Tratamiento de Quejas y Reclamos</title>    
	<link id="favicon" type="image/png" rel="shortcut icon" href="img/application_view_gallery.png" />
    
    <link type="text/css" rel="stylesheet" href="css/index.css" />
        
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
  	<script type="text/javascript" src="js/index.js"></script>  
</head>	
<body>
    <div id="cargando">
        <span>Cargando <img src="img/ajax-loader.gif" /></span>
    </div> 
         
    <div class="login">
        <form id="form_login" action="#" method="get"> 
            <div class="header">Recepción y Tratamiento de Quejas y Reclamos</div> 
            <div>
                <div>          	          	
                    <label for="usuario">Nombre de usuario:</label>
                </div>    
                <div>
                    <input type="text" id="usuario" name="user" value="pqr" maxlength="15" label="Digite el nombre de usuario" />
                </div>
                <div>	
                    <span id="mensaje_usuario"></span>
                </div>        
            </div>    
            <div>	
                <div>
                    <label for="password">Contraseña:</label>
                </div>
                <div>    
                    <input type="password" id="passwd" name="passwd" value="pqr" maxlength="15" label="Digite la contraseña" />
                </div>       
                <div>	
                    <span id="mensaje_passwd"></span>
                </div>        
            </div>       	
            <div>
                <input type="submit" id="acceder" class="boton_azul" value="Ingresar" title="Ingresar a la aplicación" />
            </div> 
        </form>         
    </div> 
    
    <div id="footer">
        <div>
            <a href="http://www.corprodinco.org" target="_blank">&copy; 2011 - Corprodinco</a>
            &nbsp;|&nbsp;
            <a href="../">Inicio</a>
        </div>       
    </div>
    
    <div id="error"></div>
</body>
</html>