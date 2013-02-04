<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/modelo/sqls/compras/Catranslados.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;
		var $titulos;
		var $titulos2;
		var $anchos;
		var $anchos2;
		var $campos;
		var $sql1;
		var $sql2;
		var $rep;
		var $numero;
		var $cab;
		var $codesde;
		var $codhasta;
		var $coddphdes;
		var $coddphhas;
		var $fechadesde;
		var $fechahasta;
		var $estado;
		var $conf;
		var $nombre;
		var $direccion;
		var $telefono;
		var $sqlp=array();

		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
			$this->coddphdes=H::GetPost("coddphdes");
			$this->coddphhas=H::GetPost("coddphhas");
			$this->coddesde=H::GetPost("codesde");
			$this->codhasta=H::GetPost("codhasta");
			$this->fechadesde=H::GetPost("fechadesde");
			$this->fechahasta=H::GetPost("fechahasta");
			$this->estado=H::GetPost("estado");
			$this->SetAutoPageBreak(false);

			if($this->estado=='Ambos')
			{
				$sta1='A';
				$sta2='N';
			}
			else if($this->estado=='Activas')
			{
				$sta1='A';
				$sta2='A';
			}
			else if($this->estado=='Anuladas')
			{
				$sta1='N';
				$sta2='N';
			}

            $this->cardphpre = new Catranslados();
		    $this->sqlp=$this->cardphpre->sqlp($this->coddphdes,$this->coddphhas,$this->coddesde,$this->codhasta,$this->fechadesde,$this->fechahasta,$sta1,$sta2);
		    $this->arrp=$this->sqlp;
		    $this->otros();
		}

		function otros()
		{
			$otros=$this->cardphpre->otros();
			foreach($otros as $dato1)
			{
				$this->nombre=$dato1["nombre"];
				$this->direccion=$dato1["dir"];
				$this->telefono=$dato1["telf"];
			}
		}

		function Header()
		{


				$this->setFont("Arial","B",8);
				$this->line(10,10,200,10);
				$this->line(10,10,10,270);
				$this->setTextcolor(0,0,150);
				$this->Image("../../img/logo_1.jpg",13,12,20);
				$this->cell(200,10,'N° TRASLADO                                ',0,0,'R');
				$this->ln(5);
				$this->setTextcolor(0,0,0);
				$this->ln(6);
				$this->setTextcolor(0,0,150);
				$this->cell(200,10,'FECHA                                      		   ',0,0,'R');
				$this->ln(5);
				$this->setTextcolor(0,0,0);
				$this->ln(1);
				$this->setTextcolor(0,0,150);
			    $this->setFont("Arial","B",14);
				$this->cell(200,25,H::GetPost("titulo"),0,0,'C');
			    $this->setFont("Arial","B",8);
			    $this->ln(18);
			    $this->SetX(15);
			    $this->cell(20,5,'');
			     $this->ln(2);
			      $this->SetX(15);
			    $this->cell(50,10,'DESCRIPCION TRASLADO: ');
			    $this->setTextcolor(0,0,0);
				$this->line(15,45,195,45);
				//$this->line(15,65,195,65);
				$this->line(15,45,15,65);
				$this->line(195,45,195,65);
				$this->line(145,12,195,12);
				$this->line(145,12,145,35);
				$this->line(145,23.5,195,23.5);
				$this->line(195,12,195,35);
				$this->line(145,35,195,35);
				$this->ln(10);
				$this->SetXY(15,57);
				$this->cell(95,5,'Almacen de Origen:');
				$this->cell(80,5,'Ubicación Origen:');
					$this->SetXY(15,61);
				$this->cell(95,5,'Almacen de Destino: ');
				$this->cell(80,5,'Ubicación de Destino: ');
				$this->SetXY(15,57);
				$this->ln(8);
				$this->line(15,$this->getY(),195,$this->getY());

				$this->line(15,$this->getY(),15,230);
				$this->line(195,$this->getY(),195,230);

				$this->setTextcolor(150,0,0);
				$this->SetX(15);

			 $this->setwidths(array(40,80,20,20,20));
			 $this->setaligns(array("C","C","C","C","C"));
			 $this->setBorder(1);
			 $this->rowm(array('Cod.Material','Descripcion Material','Cant. Trasl','Exit. Dest','Exit Orig.'));
			 $this->setBorder(0);


				$this->ln(5);
				$this->line(15,$this->getY(),195,$this->getY());
				$this->line(200,10,200,270);
				$this->line(10,270,200,270);
				$this->line(15,230,195,230);
				$this->line(15,235,195,235);
				$this->SetTextColor(0,0,150);
				$this->setXY(15,236);
				$this->cell(30,3,'Conforme:');
				$this->setXY(100,236);
				$this->cell(30,3,'Conforme:');
				$this->setXY(15,250);
				$this->cell(30,3,'Firma y Sello:');
				$this->setXY(100,250);
				$this->cell(30,3,'Firma y Sello');
				$this->setXY(15,260);
				$this->cell(30,3,'ALMACEN ORIGEN');
				$this->setXY(100,260);
				$this->cell(30,3,'ALMACEN DESTINO');


				$this->line(100,235,100,265);
		//		$this->line(15,256,195,256);
				$this->line(15,235,15,265);
				$this->line(195,235,195,265);
				$this->line(15,265,195,265);
				$this->SetTextColor(0,0,0);
				$this->setY(76);

		}
		function Cuerpo()
		{
			$this->setFont("Arial","",8);
			$ref=$this->sqlp[0]["codtra"];
			$acum1=0;
			$x=0;
			$this->setXY(15,13);
			$this->cell(167,10,$this->sqlp[0]["codtra"],0,0,'R');
			$this->setXY(15,27);
			$this->cell(164,5,$this->sqlp[0]['fectra'],0,0,'R');
			$this->setXY(55,50.5);
    	    $this->MultiCell(130,3,$this->sqlp[0]["destra"]);
			$this->setXY(45,57);
			$this->cell(95,5,$this->AlmaCen($this->sqlp[0]['almori']),0,0,'L');
			$this->cell(80,5,$this->AlmaCenubi($this->sqlp[0]['codubiori']),0,0,'L');
			$this->setXY(45,61);
			$this->cell(95,5,$this->AlmaCen($this->sqlp[0]['almdes']),0,0,'L');
			$this->cell(80,5,$this->AlmaCenubi($this->sqlp[0]['codubides']),0,0,'L');
		    //$this->setXY(41,57);
	    	$this->setXY(40,45);
			$this->cell(40,5,$this->sqlp[0]['reqart'],0,0,'L');
			$this->setY(76);
			$ok=false;
			foreach($this->sqlp as $this->sqlp)
			{
			  if($this->sqlp["codtra"]!=$ref)
			  {
				$this->setXY(15,230);
				$this->setFont("Arial","B",8);
			  	#$this->cell(200,5,'TOTAL BOLIVARES:	'.number_format($acum1,2,'.',',').'																							',0,0,'R');
				$this->setFont("Arial","",8);
				$acum1=0;
				$this->setXY(15,268);
			  	//$this->cell(200,0,$this->direccion.'  -  '.$this->telefono,0,0,'C');
			  	$this->cell(200,0,"",0,0,'C');
			  	$this->AddPage();
				$ok=true;
			    $this->setXY(15,13);
			    $this->cell(170,10,$this->sqlp["codtra"],0,0,'R');
			    $this->setXY(15,27);
			    $this->cell(170,5,$this->sqlp['fectra'],0,0,'R');
				$this->setXY(55,50.5);
	    	    $this->MultiCell(130,3,$this->sqlp["destra"]);
				$this->setXY(45,57);
				$this->cell(95,5,$this->AlmaCen($this->sqlp['almori']),0,0,'L');
				$this->cell(80,5,$this->AlmaCenubi($this->sqlp['codubiori']),0,0,'L');
				$this->setXY(45,61);
				$this->cell(95,5,$this->AlmaCen($this->sqlp['almdes']),0,0,'L');
				$this->cell(80,5,$this->AlmaCenubi($this->sqlp['codubides']),0,0,'L');
			    $this->setXY(40,45);
			    $this->cell(40,5,$this->sqlp['reqart'],0,0,'L');

			    $this->setY(76);
				$temp=$ref;
			  }
			 $this->setX(13);
			 	 $this->setwidths(array(40,80,20,20,20));
			 $this->setaligns(array("C","L","C","C","C"));
			 $this->rowm(array($this->sqlp["codart"],$this->sqlp["desart"],number_format($this->sqlp["canart"],0,'.',','),number_format($this->sqlp["exiact"],0,'.',','),number_format($this->sqlp["exiact2"],0,'.',',')));

			 $acum1=$acum1+$this->sqlp["pretot"];
			  if($this->getY()>=225)
			     {
			     	$this->addPage();
			     }
			 $ref=$this->sqlp["codtra"];

  		  }
		  $this->setXY(15,230);
		  $this->setFont("Arial","B",8);
	  	  #$this->cell(200,5,'TOTAL BOLIVARES:	'.number_format($acum1,2,'.',',').'																							',0,0,'R');
		  $this->setFont("Arial","",8);
		  $this->otros();
		  $this->setXY(15,268);
	 // 	  $this->cell(200,0,$this->direccion.'  -  '.$this->telefono,0,0,'C');
	  	  $this->cell(200,0,"",0,0,'C');
		}
	}
?>