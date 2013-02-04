<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/funciones.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $tipo;
		var $referencia;
		var $sql;
		var $tbg;

		function pdfreporte()
		{
			$this->fpdf("p","mm","Letter");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->tipo=$_POST["tipo"];
			$this->referencia=H::GETPOST("referencia");

			$this->sql=("select
						c.montot,
						c.codpre,
						b.desing,
						b.anoing,
						b.tipmov,
						b.ctaban,
						to_char(b.fecing,'dd/mm/yyyy') as fecha,
						a.destip
						from
						citiping a, cireging b, ciimping c
						where
						b.codtip = a.codtip and
						b.refing = c.refing and
						trim(b.refing) = trim('".$this->referencia."') --and
						--lower(a.destip) like '%reintegro%'");
						#print ("<pre>".$this->sql);

			$this->cab=new cabecera();
			$this->tbg = $this->bd->select($this->sql);
		}


		function cuadros($posx, $posy, $ancho, $alto, $cantidadh, $cantidadv, $estilo)
		{
			/*******************************************/
			/****ESTA FUNCION ES PARA PINTAR CUADROS****/
			/*******************************************/
			for($x=0;$x < $cantidadh;$x++)
			{
				for($y=0;$y < $cantidadv;$y++)
				{
					$forx=$posx+($x*$ancho);
					$fory=$posy+($y*$alto);
					$this->Rect($forx,$fory,$ancho,$alto,$estilo);
				}
			}
		}

		function Header()
		{
			$this->SetAutoPageBreak(false);
			$this->Image("../../img/logo_1.jpg",35,13,45);
			$tb3=$this->bd->select("select * from empresa where codemp='001'");
			if(!$tb3->EOF)
			{
				$nombre=strtoupper($tb3->fields["nomemp"]);
				$direccion=strtoupper($tb3->fields["diremp"]);
				$telef=strtoupper($tb3->fields["tlfemp"]);
				$fax=strtoupper($tb3->fields["faxemp"]);
			}
	    	//Titulo Descripcion de la Empresa
			$this->setFont("Arial","B",7);
			$a1=35;
			$a2=33;
    		$this->SetXY($a1,$a2);
    		$this->Cell(45,5,$direccion,0,0,'C');
    		$this->SetXY($a1,$a2+3);
    		$this->Cell(45,5,'Tlf:'.$telef,0,0,'C');
    		$this->SetXY($a1,$a2+6);
    		$this->Cell(45,5,'Fax:'.$fax,0,0,'C');
			$this->cuadros(115,14,70,10,1,3,'D');
			$this->SetXY(115,14);
			$this->setFont("Arial","B",12);
			$this->Cell(70,10,$_POST["titulo"],0,0,'C');
			$this->SetXY(115,24);
			$this->Cell(70,10,"No.  ".$this->referencia);
			$this->SetXY(115,34);
			$this->Cell(70,6,"RAMO:");
			$this->SetXY(115,38);
			$this->Cell(70,6,$this->tbg->fields["destip"],0,0,'C');
			$this->SetXY(115,50);
			$mes = array("01" => "Enero",
						 "02" => "Febrero",
						 "03" => "Marzo",
						 "04" => "Abril",
						 "05" => "Mayo",
						 "06" => "Junio",
						 "07" => "Julio",
						 "08" => "Agosto",
						 "09" => "Septiembre",
						 "10" => "Octubre",
						 "11" => "Noviembre",
						 "12" => "Diciembre");
			$this->setFont("Arial","",8);
			$fecha = explode("/",$this->tbg->fields["fecha"]);
			$this->Cell(1,5,"Maturin, ".$fecha[0]." de ".$mes[$fecha[1]]." de ".$fecha[2]);
			$this->SetY(58);
			$this->setFont("Arial","B",10);
			$this->Cell(25,5,"CIUDADANO:");
			$this->Ln(5);
			$this->Cell(30,5,"TESORERO GENERAL DEL ESTADO");
			$this->Ln(5);
			$this->Cell(40,5,"SIRVASE RECIBIR DE:");
			//$this->Cell(30,5,"Otro Rufino Antonio Blanco Fombona");
			$this->Ln(6);
			$this->Rect(10,$this->GetY(),195,195);
			$this->Cell(1,5,"CONSIGNATARIO:");
			$this->ln(5);
		}

		function Cuerpo()
		{
			$dividir=explode("#",$this->tbg->fields["desing"]);
			$descripcion = $dividir[0];
			$div2 = explode(" ",$dividir[1]);
			$ano = $div2[0];
			$partida = explode("-",$div2[1]);
			for($co=1;$co<=2;$co++)
			{
				$this->setFont("Arial","B",10);
				$this->SetX(30);
				$this->Multicell(150,4,"tesoreria general del estado");
				$this->Ln(2);
				$this->Line(10,$this->GetY()-1,205,$this->GetY()-1);
				$this->Cell(190,4,"CANTIDAD: ");
				$this->SetX(10);
				$this->setFont("Arial","",10);
				$this->Multicell(190,4,"                     ".ucwords(strtolower(montoescrito($this->tbg->fields["montot"],$this->bd))));
				$this->Ln(2);
				$this->Line(10,$this->GetY()-1,205,$this->GetY()-1);
				$this->setFont("Arial","B",10);
				$this->Cell(10,4,"Bs. ");
				$this->setFont("Arial","",10);
				$this->Cell(190,4,number_format($this->tbg->fields["montot"],2,'.',','));
				$this->Ln(6);
				$this->Line(10,$this->GetY()-1,205,$this->GetY()-1);
				$this->setFont("Arial","B",10);
				$this->Cell(190,4,"CORRESPONDIENTE: ");
				$this->SetX(10);
				$this->setFont("Arial","",10);
				$this->Multicell(190,4,"                                        ".ucwords(strtolower($descripcion)));
				$this->Ln(2);
				$this->Line(10,$this->GetY()-1,205,$this->GetY()-1);
				/*AHORA VIENE EL CUADRITO DE ADENTRO*/
				$this->Ln(4);
				$this->SetX(13);
				$this->Cell(13,6,"Ano",1,0,'C');
				$this->Cell(20,6,"Sector",1,0,'C');
				$this->Cell(20,6,"Prog.",1,0,'C');
				$this->Cell(20,6,"Actividad",1,0,'C');
				$this->Cell(20,6,"Partida",1,0,'C');
				$this->Cell(38,6,"Generica-Especifica",1,0,'C');
				$this->Cell(20,6,"Numeral",1,0,'C');
				$this->Cell(38,6,"",1,0,'C');
				$this->Ln(6);
				$this->setFont("Arial","",8);
				$this->SetX(13);
				$this->Cell(13,15,$ano,1,0,'C');
				$this->Cell(20,15,$partida[0],1,0,'C');
				$this->Cell(20,15,$partida[1],1,0,'C');
				$this->Cell(20,15,"",1,0,'C');
				$this->Cell(20,15,"",1,0,'C');
				$this->Cell(38,15,$partida[2],1,0,'C');
				$this->Cell(20,15,"",1,0,'C');
				$this->Cell(38,15,"",1,0,'C');
				/*FIN DEL CUADRITO DE ADENTRO*/
				$this->Ln(56);
				$this->Line(25,$this->GetY(),90,$this->GetY());
				$this->setFont("Arial","B",10);
				$this->SetX(25);
				$this->Cell(65,5,"",0,0,'C');
				$this->Ln(5);
				$this->SetX(25);
				$this->Cell(65,5,"LIQUIDADOR",0,0,'C');
				$this->Ln(20);
				$this->Cell(30,5,"DEPOSITO:");
				$this->Cell(65,5,$this->tbg->fields["tipmov"]);
				$this->Ln(10);
				$this->Cell(30,5,"BANCO:");
				$this->Cell(65,5,"BANCO FEDERAL");
				$this->Ln(10);
				$this->Cell(30,5,"CUENTA No. ");
				$this->Cell(65,5,$this->tbg->fields["ctaban"]);
				$this->Ln(25);
				$this->Cell(65,5,"CC.CONTABILIDAD");
				$this->SetXY(95,225);
				$this->Cell(65,5,"RECIBI CONFORME");
				$this->SetXY(130,240);
				$this->Cell(65,5,"",0,0,'C');
				$this->SetXY(130,245);
				$this->Cell(65,5,"Tesoreria General del estado (E)",0,0,'C');
				$this->SetTextColor(255,192,203);
				$this->SetDrawColor(255,192,203);
				$this->SetXY(50,256);
				$this->setFont("Arial","B",26);
				if($co==1)
				{
					$this->Cell(58,11,"ORIGINAL",1,0,'C');
				}
				else
				{
					$this->Cell(40,11,"COPIA",1,0,'C');
				}
				$this->SetDrawColor(0,0,0);
				$this->SetTextColor(0,0,0);
				if($co==1)
				{
					$this->AddPage();
				}



			}

		}
	}
?>