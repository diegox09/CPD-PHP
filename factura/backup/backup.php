<?php
date_default_timezone_set('America/Bogota'); 
$fecha = date('d.m.Y_H.i');	
$archivo = 'sql/factura_'.$fecha.'.sql';
exec('C:\wamp\bin\mysql\mysql5.5.8\bin\mysqldump --opt --host=localhost --user=root --password=sputnik factura > '.$archivo);
?>