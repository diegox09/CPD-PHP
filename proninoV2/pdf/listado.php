<?php	
	session_start();
	
	require_once('../../php/fpdf/fpdf.php');
	require_once('../php/classes/Pronino.php');
	
	class PDF extends FPDF{
		// Cabecera de página
		function Header(){
			/*
			$this->SetFont('Arial','B',12);
			$this->SetTextColor(0,0,0);
			$this->Cell(80,17,'','',0,'C');
			$this->Image('../img/telefonica.png',38,16,25);
			$this->Cell(175,17,'','',0,'C');	
			$this->Image('../img/logo.png',165,16,25);
			$this->Cell(80,17,'','',1,'C');	
			$this->Image('../img/pronino.png',293,16,25);
			$this->Ln(5);	
			*/		
		}
		
		// Pie de página
		function Footer(){
			// Posición: a 1,5 cm del final
			$this->SetY(-15);			
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,utf8_decode('Página '.$this->PageNo().'/{nb}'),0,0,'C');
		}
	}	
	
	$logonSuccess = false;
	
	if (array_key_exists('id_pn', $_SESSION)) {
		$logonSuccess = true;		
	}
				
	if($logonSuccess){		
		$year = $_GET['year'];
		$idMunicipio = $_GET['id_municipio'];
		$idColegio = $_GET['id_colegio'];
		$temp = '';
		
		$seccion = array('', '(1)', '(2)', '(3)', '(4)', '(5)', '(A)', '(B)', '(C)', '(D)', '(E)');
		$jornada = array('', 'Mañana', 'Tarde');
		
		$idUser = $_SESSION['id_pn'];
		$usuario = mysqli_fetch_array(Pronino::getInstance()->get_user_by_id($idUser));
		$perfilUser = $usuario['tipoUser'];
				
		$colegio = mysqli_fetch_array(Pronino::getInstance()->get_colegio_by_id($idColegio));
		$nombreColegio = $colegio['nombreColegio'];
		$idMunicipio = $colegio['idMunicipio'];	
		
		$nombreMunicipio = '';
		if($idMunicipio != 0){
			$municipio = mysqli_fetch_array(Pronino::getInstance()->get_municipio_by_id($idMunicipio));	
			$nombreMunicipio = $municipio['nombreMunicipio'];
			$idDepartamento = $municipio['idDepartamento'];
		}
		
		$nombreDepartamento = '';
		if($idDepartamento != 0){
			$departamento = mysqli_fetch_array(Pronino::getInstance()->get_departamento_by_id($idDepartamento));	
			$nombreDepartamento = $departamento['nombreDepartamento'];
		}
					
		$pdf = new PDF();	
		$pdf->FPDF('L','mm','Legal');
		$pdf->SetTitle('CONTROL ACADEMICO - PRONIÑO');
		$pdf->SetAuthor('CORPRODINCO');
		$pdf->SetMargins(10,15,10);	
				
		$pdf->AliasNbPages();						
		$pdf->AddPage();
		
		/*Cabecera*/
		$pdf->SetFont('Arial','B',12);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(80,17,'','',0,'C');
		$pdf->Image('../img/telefonica.png',38,16,25);
		$pdf->Cell(175,17,'','',0,'C');	
		$pdf->Image('../img/logo.png',162,18,35);
		$pdf->Cell(80,17,'','',1,'C');	
		$pdf->Image('../img/pronino.png',293,16,25);
		$pdf->Ln(5);
		
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(335,7,utf8_decode('CONTROL ACADEMICO PERIODICO - PRONIÑO COLOMBIA'),'',1,'C');
		
		$pdf->SetFillColor(230,235,245);
		
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(50,5,utf8_decode('FUNDACIÓN/ ENTIDAD ALIADA'),'TLR',0,'C',1);
		$pdf->Cell(40,5,'DEPARTAMENTO','TLR',0,'C',1);
		$pdf->Cell(40,5,'CIUDAD','TLR',0,'C',1);
		$pdf->Cell(125,5,'COLEGIO','TLR',0,'C',1);
		$pdf->Cell(80,5,'PERIODO','TLRB',1,'C',1);
		//$pdf->Cell(20,5,'NOTA FINAL','TLR',1,'C',1);
				
		$pdf->Cell(50,5,'','LRB',0,'C',1);
		$pdf->Cell(40,5,'','LRB',0,'C',1);
		$pdf->Cell(40,5,'','LRB',0,'C',1);
		$pdf->Cell(125,5,'','LRB',0,'C',1);
		$pdf->Cell(20,5,'PRIMERO','TLRB',0,'C',1);
		$pdf->Cell(20,5,'SEGUNDO','TLRB',0,'C',1);
		$pdf->Cell(20,5,'TERCERO','TLRB',0,'C',1);
		$pdf->Cell(20,5,'CUARTO','TLRB',1,'C',1);
		//$pdf->Cell(20,5,'','LRB',1,'C',1);
		
		$pdf->Cell(50,7,'CORPRODINCO',1,0,'C');
		$pdf->Cell(40,7,$nombreDepartamento,1,0,'C');
		$pdf->Cell(40,7,$nombreMunicipio,1,0,'C');
		$pdf->Cell(125,7,$nombreColegio,1,0,'C');
		$pdf->Cell(20,7,'',1,0,'C');
		$pdf->Cell(20,7,'',1,0,'C');
		$pdf->Cell(20,7,'',1,0,'C');
		$pdf->Cell(20,7,'',1,1,'C');
		//$pdf->Cell(20,7,'',1,1,'C');
		
		$pdf->Ln(4);
		//$pdf->SetFont('Arial','',9);
		$pdf->Cell(15,5,'ITEM','TLR',0,'C',1);
		$pdf->Cell(55,5,'NOMBRES','TLR',0,'C',1);
		$pdf->Cell(55,5,'APELLIDOS','TLR',0,'C',1);
		$pdf->Cell(14,5,'GRADO','TLR',0,'C',1);
		$pdf->Cell(16,5,'JORNADA','TLR',0,'C',1);
		$pdf->Cell(60,5,'NOTA MATEMATICAS','TLRB',0,'C',1);
		$pdf->Cell(60,5,utf8_decode('NOTA ESPAÑOL'),'TLRB',0,'C',1);
		$pdf->Cell(60,5,'OBSERVACIONES','TLR',1,'C',1);
		
		$pdf->Cell(15,5,'','LRB',0,'C',1);
		$pdf->Cell(55,5,'','LRB',0,'C',1);
		$pdf->Cell(55,5,'','LRB',0,'C',1);
		$pdf->Cell(14,5,'','LRB',0,'C',1);
		$pdf->Cell(16,5,'','LRB',0,'C',1);
		$pdf->Cell(15,5,'B','TLRB',0,'C',1);
		$pdf->Cell(15,5,'BS','TLRB',0,'C',1);
		$pdf->Cell(15,5,'AL','TLRB',0,'C',1);
		$pdf->Cell(15,5,'SUP','TLRB',0,'C',1);		
		$pdf->Cell(15,5,'B','TLRB',0,'C',1);
		$pdf->Cell(15,5,'BS','TLRB',0,'C',1);
		$pdf->Cell(15,5,'AL','TLRB',0,'C',1);
		$pdf->Cell(15,5,'SUP','TLRB',0,'C',1);
		$pdf->Cell(60,5,'','LRB',1,'C',1);
		
		if($perfilUser == 3)		
			$result = Pronino::getInstance()->get_beneficiario_year_by_colegio($year, $idColegio);
		else
			$result = Pronino::getInstance()->get_beneficiario_year_by_user_colegio($year, $idUser, $idColegio);							
		while ($beneficiario = mysqli_fetch_array($result)){
			$item = $beneficiario['item'];
			$nombre = $beneficiario['nombreBeneficiario'];
			$apellido = $beneficiario['apellidoBeneficiario'];
			$grado = $beneficiario['grado'];
			if($grado == 0)
				$grado = '';
			$idSeccion = $beneficiario['seccion'];
			$idJornada = $beneficiario['jornada'];			
		
			$idSede = $beneficiario['idSedeColegio'];
			if($temp != $idSede){
				//if($temp != '')
				//	$pdf->AddPage();
				$temp = $idSede;
				if($idSede != 0){
					$sede = mysqli_fetch_array(Pronino::getInstance()->get_sede_by_id($idSede));
					$nombreSede = $sede['nombreSede'];
					$pdf->Cell(335,7,$nombreSede,'TLRB',1,'C',1);
				}
			}
			
			$MB = '';
			$MBS = '';
			$MAL = '';
			$MSUP = '';			
			$EB = '';
			$EBS = '';
			$EAL = '';
			$ESUP = '';						
			
			$pdf->Cell(15,7,$item,'TLRB',0,'C');
			$pdf->Cell(55,7,$nombre,'TLRB',0,'L');
			$pdf->Cell(55,7,$apellido,'TLRB',0,'L');
			$pdf->Cell(14,7,$grado." ".$seccion[$idSeccion],'TLRB',0,'C');
			$pdf->Cell(16,7,utf8_decode($jornada[$idJornada]),'TLRB',0,'C');
			$pdf->Cell(15,7,$MB,'TLRB',0,'C');
			$pdf->Cell(15,7,$MBS,'TLRB',0,'C');
			$pdf->Cell(15,7,$MAL,'TLRB',0,'C');
			$pdf->Cell(15,7,$MSUP,'TLRB',0,'C');		
			$pdf->Cell(15,7,$EB,'TLRB',0,'C');
			$pdf->Cell(15,7,$EBS,'TLRB',0,'C');
			$pdf->Cell(15,7,$EAL,'TLRB',0,'C');
			$pdf->Cell(15,7,$ESUP,'TLRB',0,'C');
			$pdf->Cell(60,7,'','TLRB',1,'C');		
		}
			
		$pdf->Output('CONTROL ACADEMICO - PRONIÑO.pdf', 'I');
	}
	else
		header("Location: ../");
?>	