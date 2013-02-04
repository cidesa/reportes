<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farfaartpvp.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;

		function pdfreporte()
		{
			$this->conf="l";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();
			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");

			$this->farfaartpvp = new Farfaartpvp();
		    $this->arrp = $this->farfaartpvp->sqlp($this->coddes,$this->codhas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();
			//H::PrintR($this->arrp);exit;
		}

	function llenartitulosmaestro()
		{
				$this->titulosm[0]="CODIGO";
				$this->titulosm[1]="CODIGO ARTICULO";
				$this->titulosm[2]="DESCRIPCION ARTICULO";
				$this->titulosm[3]="PRECIO ARTICULO";
				$this->titulosm[4]="CODIGO DESCUENTO";
				$this->titulosm[5]="DESCRIPCION DESCUENTO";
		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=90;
		$this->anchos[3]=50;
		$this->anchos[4]=65;
		$this->anchos[5]=35;
		$this->anchos[6]=25;
	}

function Header()
		{
			$this->cab->poner_cabecera($this,H::GetPost(""),$this->conf,"l","n");
			$this->setFont("Arial","B",8);
			$this->setFont("Arial","B",14);
			$this->SetXY(35,30);
			$this->cell(220,5,H::GetPost("titulo"),0,0,'C');
			$this->setFont("Arial","B",8);
			$this->Ln(10);
			$this->SetWidths(array($this->anchos[6],$this->anchos[5],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[4]));
    	    $this->SetAligns(array("C","C","C","C","C","C"));
    	    $this->SetBorder(1);
    	    $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4],$this->titulosm[5]));
    	    $this->SetBorder(0);
    	    $this->line(10,$this->getY(),270,$this->getY());
   			$this->ln();

		}

function Cuerpo()

		{

	    $reg=1;
		$cod="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codigo"]!=$cod)
             {
				$this->setFont("Arial","",8);
                $this->SetWidths(array($this->anchos[6],$this->anchos[5],$this->anchos[4],$this->anchos[5],$this->anchos[5],$this->anchos[4]));
    	        $this->SetAligns(array("C","C","L","R","C","L"));
    	        $this->RowM(array($dato["codigo"],$dato["codart"],$dato["desart"],H::FormatoMonto($dato["pvp"]),$dato["codpvp"],$dato["despvp"]));
    	        $cod=$dato["codigo"];

            }

            }
		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }



		}

}//fin de la clase

?>