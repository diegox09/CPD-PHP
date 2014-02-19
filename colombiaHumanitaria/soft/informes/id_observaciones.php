<?php	
	session_start();	
		
	require_once('../php/classes/Humanitaria.php');
	require_once('../php/funciones/funciones.php');
	
	$logonSuccess = false;
	
	if (array_key_exists('id_hu', $_SESSION)) {
		$logonSuccess = true;		
	}
	
	if($logonSuccess){			
		$result = Humanitaria::getInstance()->get_damnificados();
		while ($damnificado = mysqli_fetch_array($result)){	
			//if($damnificado['observaciones'] == 'miercoles' || $damnificado['observaciones'] == 'MIERCOLES'){
				echo $damnificado['id_damnificado'].',';
			//}	
		}
		mysqli_free_result($result);
	}		
		
	else
		header("Location: ../");
?>	