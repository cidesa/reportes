<?
	require_once("../../lib/general/fpdf/fpdf.php");
	require_once("../../lib/general/Herramientas.class.php");
	require_once("../../lib/bd/basedatosAdo.php");
	require_once("../../lib/general/cabecera.php");
	require_once("../../lib/modelo/sqls/compras/Carplicompre.class.php");

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
		var $analizado;
		var $evaluado;
		var $autorizado;
		var $conf;
		var $a;
		var $b;


		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");
	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->titulos=array();
			$this->titulos2=array();
			$this->campos=array();
			$this->anchos=array();
			$this->anchos2=array();
                     $this->codreqdes=H::GetPost("codreqdes");
			$this->rifpro=H::GetPost("rifpro");
			$this->asesor=H::GetPost("asesor");
			$this->analizado=H::GetPost("analizado");
			$this->revisado=H::GetPost("revisado");
			$this->autorizado=H::GetPost("autorizado");
			$this->dias=H::GetPost("dias");
	  	    $this->carplicompre= new Carplicompre();
		    $this->arrp2=$this->carplicompre->sqlp($this->codreqdes,$this->rifpro);

		}
		function Header()
		{

				$arriba=$this->GetY();
			    $this->SetDrawColor(255,255,255);
			    $this->cab->poner_cabecera($this,"","p","s");
			    $this->SetDrawColor(0,0,0);
                $this->SetY($arriba+5);
                	//Borde superior izquierdo
                $this->line(8,6,207,6);
				$this->line(8,6,8,260);
					//Borde Inferior y Derecho
			$this->line(207,6,207,260);
			$this->line(8,260,207,260);
				$this->ln(3);
				//Paginas
				$this->setx(45);
					$this->setFont("Arial","B",9);
				$this->Cell(170,5,'G200045000',0,0,'L',0);
				$this->ln(3);
					$this->setFont("Arial","B",9);
				$this->cell(205,10,'Solicitud de Cotización Nro: '.$this->arrp2[0]["reqart"],0,0,'C');


			///////////////////////////////////////////
			$this->ln(15);
			$this->setFont("Arial","B",8);
			$this->setx(15);
			$this->cell(160,10,				H::GetPost("titulo"),0,0,'C',0 );
			$this->ln(10);
			//cuadro 1
			$this->line(15,$this->getY(),200,$this->getY());
		    $this->line(15,$this->getY(),15,65);
			$this->line(200,$this->getY(),200,65);
			$this->setXY(15,$this->getY());
		    $y=$this->getY();
			$this->setFont("Arial","B",8);
			$this->setXY(15,$this->getY()-2);
			$this->cell(20,10,'Proveedor: ');
			$this->setXY(15,$this->getY()+6);
			$this->cell(20,10,'Dirección: ');
			$this->setXY(15,$this->getY()+8);
			$this->cell(20,10,'Atención:    '.$this->asesor);
			$this->setXY(155,$y);
			$this->cell(20,10,'Rif: ');
			$this->setXY(155,$this->getY()+5);
			$this->cell(20,10,'Teléfono: ');
			$this->setXY(155,$this->getY()+7);
			$this->cell(20,10,'Fax: ');
			$this->line(15,$this->getY()+7,200,$this->getY()+7);

			//cuadro 2
		//	$this->line(15,71,200,71);
            $a=2;
			$this->setXY(25,71-$a);
			$this->setFont("Arial","",8);
			$this->multicell(170,3,'Me permito solicitarle informar a esta Institución en un tiempo no mayor a '.$this->dias.' días hábiles, de la fecha de la presente solicitud, sus mejores precios para los bienes y/o servicios que se describen a continuación, expresando lo siguiente:');
			$this->setXY(25,79-$a);
			$this->setFont("Arial","B",8);
			$this->multicell(170,3,' Número de Cotización o Presupuesto, Condiciones de Pago, Plazo de Entrega, Fecha, RIF, y VALIDEZ DE OFERTA,');
			$this->setXY(25,85-$a);
			$this->cell(170,3,'Importante:');
			$this->setFont("Arial","",8);
			$this->setXY(42,85-$a);
			$this->cell(170,3,'Caso Contrario no se tramitara la Oferta');
			$this->line(15,91,200,91);
			$this->setXY(15,91);
			$this->setFont("Arial","B",8);
			$this->cell(35,5,'Cantidad');
			$this->cell(60,5,'Unidad de Medida');
			$this->cell(100,5,'Descripción');
        	$this->line(15,96,200,96);
			$this->line(35,91,35,210);
			$this->line(100,91,100,210);
			$this->line(15,91,15,210);
			$this->line(200,91,200,210);
			$this->line(15,210,200,210);
			//cuadro 3
			$this->line(15,215,200,215);
			$this->line(15,215,15,232);
			$this->setXY(15,215);
			$this->multicell(185,5,'OBSERVACIONES:'.$this->arrp2[0]["obsreq"]);
			$this->line(200,215,200,232);
			$this->line(15,232,200,232);
			$this->setXY(15,247);		
			////////////////////////////////////////////cabecera
			 $this->setFont("Arial","B",8);
			       $this->setWidths(array(25,120,40));
			       $this->setAligns(array("L","L","C"));
			       $this->setXY(245,22);
				 $this->setFont("Arial","B",9);
				 //numero
				 $this->cell(30,5,$this->arrp2[0]["reqart"]);
				 $this->setFont("Arial","",8);
				 //proveedor
				 	$this->setXY(33,48);
				 $this->multicell(115,3,$this->arrp2[0]["nompro"]);
				 	$this->setXY(170,48);
				 //rif
				 $this->cell(30,5,$this->arrp2[0]["rifpro"]);
					 $this->setXY(33,54);
				 //direccion
				 $this->multicell(105,3,$this->arrp2[0]["dirpro"]);
				
				 //telefono
					 $this->setXY(170,53);
				 $this->multicell(20,4,$this->arrp2[0]["telpro"]."/".$this->arrp2[0]["telpro"]);
				  $this->setXY(170,60.5);
				 $this->cell(30,5,$this->arrp2[0]["faxpro"]);
				 //venderdor
				    $this->setXY(35,58);
		}
		function Cuerpo()
		{  $y=98;
			 $y2=0;

			foreach($this->arrp2 as $dato)
			{
			     $this->setFont("Arial","",8);
                 $this->setXY(15,$y);
			     //$this->setwidths(array(35,50,150));
			     $this->setwidths(array(20,65,100));
			     $this->setaligns(array("R","C","L"));
			     $this->rowm(array($dato["canreq"],$dato["unimed"],$dato["desart"]));
				 $this->ln();

				  $y=$this->GetY();
				  $y2=$this->GetY();

					     if($y2>=210)
					     {
					     $this->AddPage();
					     $y=98;
					     $y2=0;

					     }//if

                 $this->setFont("Arial","B",8);
			//	 $this->AddPage();
			}//fin de foreach
               //FIRMAS
               $this->Rect(15,234,185,23);
               $this->line(77,234,77,257);
               $this->line(139,234,139,257);
               $this->setXY(15,234);
	       $this->cell(62,5,"ANALIZADO POR: ");
	       $this->cell(62,5,"REVISADO POR: ");
	       $this->cell(62,5,"AUTORIZADO POR: ");
	       $this->ln();
               $this->setX(15);
	       $this->cell(62,5,H::GetPost("analizado"));
	       $this->cell(62,5,H::GetPost("revisado"));
	       $this->cell(62,5,H::GetPost("autorizado"));

			}//funcion cuerpo
	}
?>
