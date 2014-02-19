<?php	
	session_start();
	  		
	if (array_key_exists('id_ap', $_SESSION))
		header("Location: contenido.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="author" content="Diego Fernando Rodriguez Rincon">
	<title>Autorización de Pago</title>    
	<link id="favicon" type="image/png" rel="shortcut icon" href="img/application_view_gallery.png" />
    
    <link type="text/css" rel="stylesheet" href="css/index.css" />        
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
  	<script type="text/javascript" src="js/index.js"></script>  
</head>	
<body>
    <div id="cargando">
        <span>Cargando <img src="img/ajax-loader.gif" /></span>
    </div> 
    
    <div id="header"></div>
    
    <div id="corprodinco">
        <div style="width:20%">
            <img src="img/logo.png" height="70" />
        </div>
        <div style="width:80%">
            Corporación de Profesionales<br>
            para el Desarrollo Integral Comunitario<br> 
        </div>
    </div>
         
    <div class="login" id="div_login">
        <form id="form_login" action="#" method="get"> 
            <div class="header">Autorización de Pago</div> 
            <div>
                <div>          	          	
                    <label for="usuario">Nombre de usuario:</label>
                </div>    
                <div>
                    <input type="text" id="usuario" name="user" value="" maxlength="15" label="Digite el nombre de usuario" />
                </div>
                <div>	
                    <span id="mensaje_usuario"></span>
                </div>        
            </div>    
            <div>	
                <div>
                    <label>Contraseña:</label>
                </div>
                <div>    
                    <input type="password" id="passwd" name="passwd" value="" maxlength="15" label="Digite la contraseña" />
                </div>       
                <div>	
                    <span id="mensaje_passwd"></span>
                </div>        
            </div>       	
            <div>
                <input type="submit" id="acceder" class="boton_azul" value="Ingresar" title="Ingresar a la aplicación" />
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="#" id="enlace_login">Recordar Contraseña?</a>	
            </div> 
        </form>         
    </div>
    
    <div class="login" id="div_passwd" style="display:none">
        <form id="form_passwd" action="#" method="get"> 
            <div class="header">Recordar Contraseña</div> 
            <div>
                <div>          	          	
                    <label>Nombre de usuario:</label>
                </div>    
                <div>
                    <input type="text" id="usuario_passwd" name="user" value="" maxlength="15" label="Digite el nombre de usuario" />
                </div>
                <div>	
                    <span id="mensaje_usuario_passwd"></span>
                </div>        
            </div> 
            <div>
                <input type="submit" id="recordar" class="boton_azul" value="Recordar" title="Recordar Contraseña" />
                &nbsp;
                <a href="#" id="enlace_passwd">Ingresar a la Aplicacion!</a>
            </div> 
        </form>         
    </div> 
    
    <div id="footer">
        <div>
            <a href="http://www.corprodinco.org" target="_blank">&copy; 2012 - Corprodinco</a>  
            &nbsp;|&nbsp;          
            <a href="../">SGC</a>
        </div>       
    </div>
    
    <div id="error"></div>
</body>
</html>