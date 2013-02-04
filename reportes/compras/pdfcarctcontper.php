<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
    require_once("../../lib/general/Herramientas.class.php");
    require_once("../../lib/general/funciones.php");
    require_once("../../lib/modelo/sqls/compras/Carctcontper.class.php");

	class pdfreporte extends fpdf
	{
		var $mes = array(
						 "01"=>"ENERO",
						 "02"=>"FEBRERO",
						 "03"=>"MARZO",
						 "04"=>"ABRIL",
						 "05"=>"MAYO",
						 "06"=>"JUNIO",
						 "07"=>"JULIO",
						 "08"=>"AGOSTO",
						 "09"=>"SEPTIEMBRE",
						 "10"=>"OCTUBRE",
						 "11"=>"NOVIEMBRE",
						 "12"=>"DICIEMBRE"
						 );
		var $i = 0;
		var $codrefdes = '';
		var $codrefhas = '';
		var $rifpromin = '';
		var $rifpromax = '';


		function pdfreporte()
		{
			$this->fpdf("p","mm","Letter");
            $this->cab=new cabecera();
	        $this->arrp=array("no_vacio");
	        $this->codorddes = H::GetPost("codorddes");
			$this->codordhas = H::GetPost("codordhas");
			$this->codprodes = H::GetPost("codprodes");
			$this->codprohas = H::GetPost("codprohas");
			$this->fechamin = H::GetPost("fecreg1");
			$this->fechamax = H::GetPost("fecreg2");
			$this->auto = H::GetPost("auto");
			$this->autocar = H::GetPost("autocar");
			$this->ced1 = H::GetPost("ced1");
			$this->elab = H::GetPost("elab");
			$this->elabcar = H::GetPost("elabcar");
			$this->ced2 = H::GetPost("ced2");
			$this->carctcontper= new Carctcontper();
		    $this->arrp = $this->carctcontper->sqlp($this->codorddes ,$this->codordhas,$this->codprodes,$this->codprohas,$this->fechamin,$this->fechamax);

		}

		function suma_fechas($fecha,$ndias)
		{
			if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
            	list($dia,$mes,$año)=split("/", $fecha);
            if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            	list($dia,$mes,$año)=split("-",$fecha);
            $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
            $nuevafecha=date("d-m-Y",$nueva);

            return ($nuevafecha);
		}

		function Footer()
	{   $this->setFont("Arial","",9);
        $this->ln(10);
		$this->SetX(10);
		$this->multicell(95,3,$this->auto,0,'C');
		$this->SetX(100);
		$this->multicell(95,3,$this->elab,0,'C');
		$this->SetX(10);
		$this->multicell(95,3,$this->autocar,0,'C');
		$this->SetX(100);
		$this->multicell(95,3,$this->elabcar,0,'C');



		$this->SetY(-50);

		$this->cell(30,5,'ORIGINAL:',0,0,'L');
		$this->SetX(40);
		$this->multicell(100,5,'DIRECCION DE ADMINISTRACION Y FINANZAS');

		$this->cell(30,5,'COPIA:',0,0,'L');
		$this->SetX(40);
		$this->multicell(100,5,'EXPEDIENTE DE ORDEN DE COMPRA Y/O SERVICIO');

		$this->cell(30,5,'ELABORADO POR:',0,0,'L');
		$this->SetX(40);
		$this->multicell(100,5,'NOMBRE: '.$this->elab);
		$this->SetX(40);
		$this->multicell(100,5,'CARGO: '.$this->elabcar);
		$this->SetX(100);

		$this->SetY(-20);
		$this->Line(15,$this->GetY(),200,$this->GetY());
		$this->Cell(190,5,'Av. Francisco de Miranda, Centro Plaza, Torre "C". Piso 20, Caracas - Venezuela ',0,0,'C');
		$this->ln();
		$this->Cell(190,5,' Teléfonos: (0212)285.19.66 285.52.60',0,0,'C');
	}

		function Header()
		{
		    $dir = parse_url($_SERVER["HTTP_REFERER"]);
			$parte = explode("/",$dir["path"]);
			$ubica = count($parte)-2;
			$this->cab->poner_cabecera($this,$_POST[""],"p","n",$parte[$ubica]);
			$this->setFont("Arial","B",9);
			$this->ln();
		//	$this->MultiCell(190,5,"Caracas, ".date("d")." de ".$this->mes[date("m")]." de ".date("Y"),0,'R');

		}
function Cuerpo2(){}
		function Cuerpo()
		{
		     $total = count($this->arrp);
			 foreach($this->arrp as $registro)
			{
				$this->ln();
				$this->MultiCell(120,5,'ACTA DE CONTROL PERCEPTIVO',0,0,'C');
				$this->ln(10);
			    $this->setFont("Arial","",9);
			    $this->setx(20);
				$this->MCPlus(175,5,"\t\t\t".'En la ciudad de Caracas, a los <@'.$this->arrp[$this->i]["fecha"].'<,>arial,B,9@>, reunidos en la Dirección de Administración y Finanzas de la Contraloría Municipal de Chacao Ubicada en la Av. Francisco de Miranda, Centro Plaza, Torre "C". Piso 20, Caracas, Los Ciudadanos, '.$this->auto.' titular de la Cédula de identidad '.$this->ced1.' quien se desempeña como '.$this->autocar.' y '.$this->elab.' titular de la Cédula de identidad '.$this->ced2.'  quien se desempeña como '.$this->elabcar.' Procedieron a practicar el control Perceptivo, dejándose constancia de lo siguiente; PRIMERO: para llevar a cabo la inspección se utilizó la técnica de verificación In Situ. SEGUNDO: Se constató la recepción de artículos de acuerdo con las especificaciones establecidas en la Orden de Compra  <@'.$this->arrp[$this->i]["ordcom"].'<,>arial,B, 9@>, adjudicada a la Empresa <@'.$this->arrp[$this->i]["nompro"].'<,>arial,B,9@>.'  );
				$this->ln();
				 $this->setx(20);
				$this->MCPlus(175,5,"\t\t\t".'Concluido acto, se emite un original, el cual reposará en el archivo de la Dirección de Administración y Finanzas, y un ejemplar que reposara en el expediente de la orden de compra y/o servicio, se lee la presente Acta de Control Perceptivo y en señal de conformidad firman:'  );

			$this->Ln(5);

			$this->i++;
			if($this->i < $total)
			{
				$this->AddPage();
			}
			}
		}
	}
?>