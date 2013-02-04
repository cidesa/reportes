<?
require_once ("../../lib/bd/basedatosAdo.php");

class cabecera {

	var $bd;

	function cabecera() {
		$this->bd = new basedatosAdo();
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Funcion que imprime la cabecera que se desea en el reporte                                                 //
	// $objeto: es el objeto fpdf que construye la cabecera                                                       //
	// $rep: es el Titulo del Reporte                                                                             //
	// $configuracion: es la manera de como vamos a mostrar las paginas (p) si es Vertical y (l) si es Horizontal //
	// $pagina: es el valor para mostrar el numero y el total de paginas (s) las muestra y (n) no las muestra     //
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function poner_cabecera($objeto, $rep, $configuracion, $pagina) {
		if ($configuracion == "p") {
			//configuro la pagina con Orientacion Vertical
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = $tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 8);
			//Logo de la Empresa
			$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			//33
			//fecha actual
			$fecha = date("d/m/Y");
			
                     $objeto->Cell(196, 10, 'Fecha: '. $fecha, 0, 0, 'R');

			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(200, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'R');
			}
			//Titulo Descripcion de la Empresa
			/*$objeto->Ln(-5);
			$objeto->Cell(180,5,$nombre,0,0,'L');
			$objeto->Ln(3);
			$objeto->Cell(180,5,$direccion,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Tlf:'.$telef,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Fax:'.$fax,0,0,'C');
			$objeto->Ln(8);*/
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$tab = 45;
			$objeto->setX($tab);
			$objeto->Cell(270, 10, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 10, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, '', 0, 0, 'L');
			$objeto->Ln(10);
			$objeto->setFont("Arial", "B", 12);
			//$objeto->setX(80);
			$objeto->Cell(180, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(10);
			$objeto->Line(10, 35, 210, 35);
		} else {
			//configuro la pagina con Orientacion Horizontal
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = $tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 10);
			//Logo de la Empresa
			$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			//fecha actual
			$fecha = date("d/m/Y");
			$objeto->Cell(470, 10, 'Fecha: ' . $fecha, 0, 0, 'C');
			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(470, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'C');
			}
			//Titulo Descripcion de la Empresa
			$tab = 45;
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 5, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, '', 0, 0, 'L');
			$objeto->Ln(10);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(270, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(10);
			$objeto->Line(10, 35, 270, 35);
		}
	}
		function poner_cabecera_f($objeto, $rep, $configuracion, $pagina,$fec_ha='n',$cintillo='n') {
		if ($configuracion == "p") {
			//configuro la pagina con Orientacion Vertical
			//busco la descripcion y direccion de la empresa
			if ($cintillo == 's') {
				$objeto->Image("../../img/image.jpeg", 8,8, 150,10);
			}
			else{			
				$tb3 = $this->bd->select("select * from empresa where codemp='001'");
				if (!$tb3->EOF) {
					$nombre = $tb3->fields["nomemp"];
					$direccion = $tb3->fields["diremp"];
					$telef = $tb3->fields["tlfemp"];
					$fax = $tb3->fields["faxemp"];
				}
				$objeto->setFont("Arial", "B", 8);
				//Logo de la Empresa
					$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
				//33
				//fecha actual
			}	
				if($fec_ha=='s'){
				$fecha = date("d/m/Y");
			$objeto->Cell(470, 10, 'Fecha: ' . $fecha, 0, 0, 'C');
			}
			//
			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(200, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'R');
			}
			//Titulo Descripcion de la Empresa
			/*$objeto->Ln(-5);
			$objeto->Cell(180,5,$nombre,0,0,'L');
			$objeto->Ln(3);
			$objeto->Cell(180,5,$direccion,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Tlf:'.$telef,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Fax:'.$fax,0,0,'C');
			$objeto->Ln(8);*/
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$tab = 45;
			$objeto->setX($tab);
			if ($cintillo == 's') {
				$objeto->Cell(270, 5, '', 0, 0, 'L');
			}
			else{			
				$objeto->Cell(270, 10, 'República Bolivariana de Venezuela', 0, 0, 'L');
			}	
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 10, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, '', 0, 0, 'L');
			$objeto->Ln(10);
			$objeto->setFont("Arial", "B", 12);
			//$objeto->setX(80);
			$objeto->Cell(180, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(10);
			$objeto->Line(10, 35, 200, 35);
		} else {
			//configuro la pagina con Orientacion Horizontal
			//busco la descripcion y direccion de la empresa
			if ($cintillo == 's') {
				$objeto->Image("../../img/image.jpeg", 8,8, 250,10);
			}
			else{
				$tb3 = $this->bd->select("select * from empresa where codemp='001'");
				if (!$tb3->EOF) {
					$nombre = $tb3->fields["nomemp"];
					$direccion = $tb3->fields["diremp"];
					$telef = $tb3->fields["tlfemp"];
					$fax = $tb3->fields["faxemp"];
				}
				$objeto->setFont("Arial", "B", 10);
				//Logo de la Empresa
					$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			}	
			if($fec_ha=='s'){
				$fecha = date("d/m/Y");
				$objeto->Cell(470, 10, 'Fecha: ' . $fecha, 0, 0, 'C');
			}
			//fecha actual

			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(470, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'C');
			}
			//Titulo Descripcion de la Empresa
			$tab = 45;
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$objeto->setX($tab);
			if ($cintillo == 's') {
			$objeto->Cell(270, 5, '', 0, 0, 'L');
			}
			else{
			$objeto->Cell(270, 5, 'República Bolivariana de Venezuela', 0, 0, 'L');	
			}
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 5, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, '', 0, 0, 'L');
			$objeto->Ln(10);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(270, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(10);
			$objeto->Line(10, 35, 270, 35);
		}
	}


	function poner_cabecera_f2($objeto, $rep, $configuracion, $pagina,$fec_ha) {
		if ($configuracion == "p") {
			//configuro la pagina con Orientacion Vertical
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = "La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 8);
			//Logo de la Empresa
				$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			//33
			//fecha actual
				if($fec_ha=='s'){
				$fecha = date("d/m/Y");
			$objeto->Cell(470, 10, 'Fecha de Emisión: ' . $fecha, 0, 0, 'C');
			}
			//
			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(200, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'R');
			}
			//Titulo Descripcion de la Empresa
			/*$objeto->Ln(-5);
			$objeto->Cell(180,5,$nombre,0,0,'L');
			$objeto->Ln(3);
			$objeto->Cell(180,5,$direccion,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Tlf:'.$telef,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Fax:'.$fax,0,0,'C');
			$objeto->Ln(8);*/
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$tab = 45;
			$objeto->setX($tab);
			$objeto->Cell(270, 10, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 10, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, '', 0, 0, 'L');
			$objeto->Ln(10);
			$objeto->setFont("Arial", "B", 12);
			//$objeto->setX(80);
			$objeto->Cell(180, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(10);
			$objeto->Line(10, 35, 200, 35);
		} else if ($configuracion == "ll"){
			//configuro la pagina con Orientacion Horizontal
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = "La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 10);
			//Logo de la Empresa
				$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			if($fec_ha=='s'){
				$fecha = date("d/m/Y");
			$objeto->Cell(610, 10, 'Fecha: ' . $fecha, 0, 0, 'C');
			}
			//fecha actual

			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(610, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'C');
			}
			//Titulo Descripcion de la Empresa
			$tab = 45;
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 5, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, '', 0, 0, 'L');
				$objeto->Ln(6);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(0, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(4);
			$objeto->Cell(0, 10, " ", 0, 0, 'C', 0);
			$objeto->ln(10);



			$objeto->Line(10, 35, 340, 35);
		} else {
			//configuro la pagina con Orientacion Horizontal
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = "La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 10);
			//Logo de la Empresa
				$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			if($fec_ha=='s'){
				$fecha = date("d/m/Y");
			$objeto->Cell(470, 10, 'Fecha de Emisión: ' . $fecha, 0, 0, 'C');
			}
			//fecha actual

			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(470, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'C');
			}
			//Titulo Descripcion de la Empresa
			$tab = 45;
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 5, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, '', 0, 0, 'L');
			$objeto->Ln(10);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(270, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(10);
			$objeto->Line(10, 35, 270, 35);
		}
	}

	function poner_cabecera_f_b($objeto, $rep, $configuracion, $pagina,$fec_ha) {
		if ($configuracion == "p") {
			//configuro la pagina con Orientacion Vertical
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = "La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 8);
			//Logo de la Empresa
				$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			//33
			//fecha actual
				if($fec_ha=='s'){
				$fecha = date("d/m/Y");
				$objeto->SetX(173);
			$objeto->Cell(30, 10, 'Fecha: ' . $fecha, 0, 0, 'l');
			}
			//
			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
					$objeto->SetX(173);
				$objeto->Cell(30, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'l');
			}
			//Titulo Descripcion de la Empresa
			/*$objeto->Ln(-5);
			$objeto->Cell(180,5,$nombre,0,0,'L');
			$objeto->Ln(3);
			$objeto->Cell(180,5,$direccion,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Tlf:'.$telef,0,0,'C');
			$objeto->Ln(3);
			$objeto->Cell(180,5,'Fax:'.$fax,0,0,'C');
			$objeto->Ln(8);*/
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$tab = 45;
			$objeto->setX($tab);
			$objeto->Cell(270, 10, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 10, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 10, '', 0, 0, 'L');
				$objeto->Ln(6);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(180, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(4);
			$objeto->Cell(180, 10, "(En Bolivares) ", 0, 0, 'C', 0);
	$objeto->ln(10);

			$objeto->Line(10, 35, 200, 35);
		} else if ($configuracion == "ll"){
			//configuro la pagina con Orientacion Horizontal
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = "La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 10);
			//Logo de la Empresa
				$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			if($fec_ha=='s'){
				$fecha = date("d/m/Y");
			$objeto->Cell(610, 10, 'Fecha: ' . $fecha, 0, 0, 'C');
			}
			//fecha actual

			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(610, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'C');
			}
			//Titulo Descripcion de la Empresa
			$tab = 45;
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 5, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, '', 0, 0, 'L');
				$objeto->Ln(6);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(0, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(4);
			$objeto->Cell(0, 10, "(En Bolivares) ", 0, 0, 'C', 0);
			$objeto->ln(10);



			$objeto->Line(10, 35, 340, 35);
		}else{
			//configuro la pagina con Orientacion Horizontal
			//busco la descripcion y direccion de la empresa
			$tb3 = $this->bd->select("select * from empresa where codemp='001'");
			if (!$tb3->EOF) {
				$nombre = "La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion = $tb3->fields["diremp"];
				$telef = $tb3->fields["tlfemp"];
				$fax = $tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial", "B", 10);
			//Logo de la Empresa
				$objeto->Image("../../img/logo_1.jpg", 8, 4, 25);
			if($fec_ha=='s'){
				$fecha = date("d/m/Y");
			$objeto->Cell(470, 10, 'Fecha: ' . $fecha, 0, 0, 'C');
			}
			//fecha actual

			$objeto->ln(5);
			//Paginas
			if ($pagina == "s") {
				$objeto->Cell(470, 10, 'Pagina ' . $objeto->PageNo() . ' de {nb}', 0, 0, 'C');
			}
			//Titulo Descripcion de la Empresa
			$tab = 45;
			$objeto->setFont("Arial", "B", 12);
			$objeto->Ln(-8);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, 'República Bolivariana de Venezuela', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->setFont("Arial", "B", 8);
			//$objeto->Cell(270, 5, 'Alcaldía de Chacao', 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, $nombre, 0, 0, 'L');
			$objeto->Ln(3);
			$objeto->setX($tab);
			$objeto->Cell(270, 5, '', 0, 0, 'L');
				$objeto->Ln(6);
			$objeto->setFont("Arial", "B", 12);
			$objeto->Cell(270, 10, $rep, 0, 0, 'C', 0);
			$objeto->ln(4);
			$objeto->Cell(270, 10, "(En Bolivares) ", 0, 0, 'C', 0);
			$objeto->ln(10);



			$objeto->Line(10, 35, 270, 35);
		}

	}

	function poner_cabecera2($objeto,$rep,$configuracion,$pagina,$fechaa)
	{
		if($configuracion=="p")
		{
			//configuro la pagina con Orientacion Vertical
			//busco la descripcion y direccion de la empresa
			$tb3=$this->bd->select("select * from empresa where codemp='001'");
			if(!$tb3->EOF)
			{
				$nombre="La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
				$direccion=$tb3->fields["diremp"];
				$telef=$tb3->fields["tlfemp"];
				$fax=$tb3->fields["faxemp"];
			}
			$objeto->setFont("Arial","B",8);
			//Logo de la Empresa
			$objeto->Image("../../img/logo_1.jpg",10,8,25);
			//33
			//fecha actual
			$fecha=date("d/m/Y");
			//$objeto->Cell(350,10,'Fecha: '.$fecha,0,0,'C');
			$objeto->ln(5);
			//Paginas
			if($pagina=="s")
			{
				$objeto->Cell(350,10,'Pagina '.$objeto->PageNo().' de {nb}',0,0,'C');
			}
	    	//Titulo Descripcion de la Empresa
    		/*$objeto->Ln(-5);
    		$objeto->Cell(180,5,$nombre,0,0,'L');
			$objeto->Ln(3);
    		$objeto->Cell(180,5,$direccion,0,0,'C');
			$objeto->Ln(3);
    		$objeto->Cell(180,5,'Tlf:'.$telef,0,0,'C');
			$objeto->Ln(3);
    		$objeto->Cell(180,5,'Fax:'.$fax,0,0,'C');
    		$objeto->Ln(8);*/
      $objeto->setFont("Arial","B",12);
      $objeto->Ln(-8);
       $tab = 45;
      $objeto->setX($tab);
      $objeto->Cell(270,10,'República Bolivariana de Venezuela',0,0,'L');
      $objeto->Ln(3);
      $objeto->setX($tab);
      $objeto->setFont("Arial","B",8);
      $objeto->Cell(270,10,'Ministerio del Poder Popular Para el Comercio',0,0,'L');
      $objeto->Ln(3);
      $objeto->setX($tab);
      $objeto->Cell(270,10,$nombre,0,0,'L');
      $objeto->Ln(3);
      $objeto->setX($tab);
      //$objeto->Cell(270,10,'',0,0,'L');
      $y= $objeto->getY();
      $this->Rect(10,$y,270,5);
      //denominacion del ente
      $this->setFont("Arial","",8);
	  $this->SetWidths(array(270));
	  $this->SetAligns(array("L","C"));
//	  $this->SetBorder(1);
	  $this->Row(array("DENOMINACIÓN DEL ENTE: ".$nombre));
	//  $this->SetBorder(0);
	  $this->SetFillTable(0);
	  //CODIGO DE ADSCRIPCION
	  $this->setFont("Arial","",8);
	  $this->SetWidths(array(270));
	  $this->SetAligns(array("L","C"));
	  //$this->SetBorder(1);
	  $this->Row(array("ORGANO DE ADSCRIPCIÓN: ALCALDIA DEL MUNICIPIO DE CHACAO"));
	  //$this->SetBorder(0);
	  $this->SetFillTable(0);

      //TITULO
      $this->setFont("Arial","B",8);
	  $this->SetWidths(array(270));
	  $this->SetAligns(array("C"));
	  //$this->SetBorder(1);
	  $this->Row(array("SOLICITUD DE TRASLADO PRESUPUESTARIAS"));
	  //$this->SetBorder(0);
	  $this->SetFillTable(0);

	  $this->setFont("Arial","",8);
	  $this->SetWidths(array(200,70));
	  $this->SetAligns(array("L","C"));
	  //$this->SetBorder(1);
	 // $this->Row(array("FUENTE DE FINANCIAMIENTO: RECURSOS ORDINARIOS", "FECHA DE LA SOLICITUD"));
	  //$this->SetBorder(0);
	  $this->SetFillTable(0);

      $this->setFont("Arial","",8);
	  $this->SetWidths(array(200,70));
	  $this->SetAligns(array("L","C"));
	  //$this->SetBorder(1);
	  //$this->Row(array("UNIDAD ADMINISTRADORA: DIRECCION DE PLANIFICACION Y PRESUPUESTO", $fechaa));
	  //$this->SetBorder(0);
	  $this->SetFillTable(0);

      }
///////////////////////////
 else
    {
      //configuro la pagina con Orientacion Horizontal
      //busco la descripcion y direccion de la empresa
      $tb3=$this->bd->select("select * from empresa where codemp='001'");
      if(!$tb3->EOF)
      {
        $nombre="La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
        $direccion=$tb3->fields["diremp"];
        $telef=$tb3->fields["tlfemp"];
        $fax=$tb3->fields["faxemp"];
      }
      $objeto->setFont("Arial","B",8);
      //Logo de la Empresa

      $objeto->Image("../../img/logo_1.jpg",10,1,20);
      //$objeto->Image("../../img/logo_1.jpg",10,8,25);
      //fecha actual
      $fecha=date("d/m/Y");
      $objeto->Cell(470,10,'Fecha: '.$fecha,0,0,'C');
      $objeto->ln(5);
      //Paginas
      if($pagina=="s")
      {
        $objeto->Cell(470,10,'Pagina '.$objeto->PageNo().' de {nb}',0,0,'C');
      }
        //Titulo Descripcion de la Empresa
         $tab = 45;
      $objeto->setFont("Arial","B",12);
      $objeto->Ln(-8);
      $objeto->setX($tab);
      $objeto->Cell(270,5,'República Bolivariana de Venezuela',0,0,'L');
      $objeto->Ln(3);
      $objeto->setX($tab);
      $objeto->setFont("Arial","B",8);
      $objeto->Cell(270,5,'',0,0,'L');
      $objeto->Ln(3);
      $objeto->setX($tab);
      $objeto->Cell(270,5,$nombre,0,0,'L');
      $objeto->Ln(3);
      $objeto->setX($tab);
      //$objeto->Cell(270,5,'',0,0,'L');
      $objeto->Ln(10);
      $y= $objeto->getY();
      $objeto->Rect(10,$y,260,20);
      //denominacion del ente
      $objeto->setFont("Arial","",8);
	  $objeto->SetWidths(array(270));
	  $objeto->SetAligns(array("L","C"));
//	  $this->SetBorder(1);
	  $objeto->Row(array("DENOMINACIÓN DEL ENTE: ". $nombre));
	//  $objeto->SetBorder(0);
	  $objeto->SetFillTable(0);
	  //CODIGO DE ADSCRIPCION
	  $objeto->setFont("Arial","",8);
	  $objeto->SetWidths(array(270));
	  $objeto->SetAligns(array("L","C"));
	  //$objeto->SetBorder(1);
//	  $objeto->Row(array("ORGANO DE ADSCRIPCIÓN: ALCALDIA DEL MUNICIPIO CHACAO"));
	  //$objeto->SetBorder(0);
	  $objeto->SetFillTable(0);

      //TITULO
      $objeto->setFont("Arial","B",12);
	  $objeto->SetWidths(array(270));
	  $objeto->SetAligns(array("C"));
	  //$objeto->SetBorder(1);
         $objeto->Row(array(""));
          $objeto->Row(array(""));
	  $objeto->Row(array("SOLICITUD DE TRASLADO PRESUPUESTARIO"));
	  //$objeto->SetBorder(0);
	  $objeto->SetFillTable(0);

	  $objeto->setFont("Arial","",8);
	  $objeto->SetWidths(array(200,70));
	  $objeto->SetAligns(array("L","C"));
	  //$objeto->SetBorder(1);
	  //$objeto->Row(array("", "FECHA DE LA SOLICITUD"));
	  //$objeto->SetBorder(0);
	  $objeto->SetFillTable(0);

      $objeto->setFont("Arial","",8);
	  $objeto->SetWidths(array(200,70));
	  $objeto->SetAligns(array("L","C"));
	  //$objeto->SetBorder(1);
	 //$objeto->Row(array("DIRECCION DE PLANIFICACION Y PRESUPUESTO", $fechaa));
	  //$objeto->SetBorder(0);
	  $objeto->SetFillTable(0);

      }
	}

  function poner_cabecera_legal($objeto,$rep,$configuracion,$pagina,$departamento = '')
  {
    $nomdep2="";
    if($departamento=='presupuesto' or $departamento=='instr20' or $departamento=='formulacion')
    {
      $nomdep="DIRECCION GENERAL DE PRESUPUESTO Y CONTROL DE GESTION";
    }
    elseif($departamento=='tesoreria' or $departamento=='compras' or $departamento=='bienes' or $departamento=='ingresos')
    {
      $nomdep="DIRECCION GENERAL DE ADMINISTRACION Y FINANZAS";
    }
    elseif($departamento=='contabilidad')
    {
      $nomdep2="DIVISION  DE CONTABILIDAD";
      $nomdep="DIRECCION GENERAL DE ADMINISTRACION Y FINANZAS";
    }
    elseif($departamento=='nomina')
    {
      $nomdep="DIRECCION GENERAL DE RECURSOS HUMANOS";
    }
//		else
//		{
//			$nomdep="error en ".$departamento;
//		}



    if($configuracion=="l")
    {
      //configuro la pagina con Orientacion Vertical
      //busco la descripcion y direccion de la empresa
      $tb3=$this->bd->select("select * from empresa where codemp='001'");
      if(!$tb3->EOF)
      {
        $nombre="La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
        $direccion=$tb3->fields["diremp"];
        $telef=$tb3->fields["tlfemp"];
        $fax=$tb3->fields["faxemp"];
      }
      $objeto->setFont("Arial","B",8);
      //Logo de la Empresa
      $objeto->Image("../../img/logo_1.jpg",10,8,40);
      //fecha actual

      //$fecha=strftime("%d/%B/%Y");

      $fecha=date("d/m/Y g:i a", strtotime("-30 minute"));
      $objeto->Cell(330,10,'Fecha: '.$fecha,0,0,'R');
      $objeto->ln(5);
      //Paginas
      if($pagina=="s")
      {
        $objeto->Cell(330,10,'Pagina '.$objeto->PageNo().' de {nb}',0,0,'R');
      }
        //Titulo Descripcion de la Empresa
        /*$objeto->Ln(-5);
        $objeto->Cell(180,5,$nombre,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(180,5,$direccion,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(180,5,'Tlf:'.$telef,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(180,5,'Fax:'.$fax,0,0,'C');
        $objeto->Ln(8);*/
      $objeto->Ln(-5);
        $objeto->Cell(330,5,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(330,5,'INSTITUTO NACIONAL DE DESARROLLO DE LA PEQUEÑA Y MEDIANA INDUSTRIA',0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(330,5,$nomdep,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(330,5,$nomdep2,0,0,'C');
        $objeto->Ln(8);
      //Titulo del Reporte
      $objeto->setFont("Arial","B",12);
      $objeto->Cell(330,10,$rep,0,0,'C',0);
      $objeto->ln(10);
      $objeto->Line(10,35,350,35);
    }
    else
    {
      //configuro la pagina con Orientacion Horizontal
      //busco la descripcion y direccion de la empresa
      $tb3=$this->bd->select("select * from empresa where codemp='001'");
      if(!$tb3->EOF)
      {
        $nombre="La Nueva Televisión del Sur, C.A.";//$tb3->fields["nomemp"];
        $direccion=$tb3->fields["diremp"];
        $telef=$tb3->fields["tlfemp"];
        $fax=$tb3->fields["faxemp"];
      }
      $objeto->setFont("Arial","B",8);
      //Logo de la Empresa
      $objeto->Image("../../img/logo_1.jpg",10,8,22);
      //fecha actual
      $fecha=date("d/m/Y g:i a");
      //$hora=date("G:H:s");
      $objeto->Cell(470,10,'Fecha: '.$fecha ,0,0,'C');
      $objeto->ln(5);
      //Paginas
      if($pagina=="s")
      {
        $objeto->Cell(470,10,'Pagina '.$objeto->PageNo().' de {nb}',0,0,'C');
      }
        //Titulo Descripcion de la Empresa
        /*$objeto->Ln(-5);
        $objeto->Cell(270,5,$nombre,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(270,5,$direccion,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(270,5,'Tlf:'.$telef,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(270,5,'Fax:'.$fax,0,0,'C');
        $objeto->Ln(8);*/
      $objeto->Ln(-5);
        $objeto->Cell(270,5,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(270,5,'INSTITUTO NACIONAL DE DESARROLLO DE LA PEQUEÑA Y MEDIANA INDUSTRIA',0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(270,5,$nomdep,0,0,'C');
      $objeto->Ln(3);
        $objeto->Cell(270,5,$nomdep2,0,0,'C');
        $objeto->Ln(8);
      //Titulo del Reporte
      $objeto->setFont("Arial","B",12);
      $objeto->Cell(270,10,$rep,0,0,'C',0);
      $objeto->ln(10);
      $objeto->Line(10,35,270,35);
    }

  }
}
?>
