<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
      require_once("../../lib/modelo/sqls/cuentasxcobrar/Cobrdesdoc.class.php");

	class pdfreporte extends fpdf
	{

		var $bd;


		function pdfreporte()
		{
			$this->conf="p";
			$this->fpdf($this->conf,"mm","Letter");

	        $this->arrp=array("no_vacio");
			$this->cab=new cabecera();
			$this->bd=new basedatosAdo();

			$this->coddes=H::GetPost("coddes");
			$this->codhas=H::GetPost("codhas");

			$this->tipclides=H::GetPost("tipclides");
			$this->tipclihas=H::GetPost("tipclihas");

			$this->cobrdesdoc = new Cobrdesdoc();
		    $this->arrp = $this->cobrdesdoc->sqlp($this->coddes,$this->codhas,$this->tipclides,$this->tipclihas);

			$this->llenartitulosmaestro();
			$this->llenaranchos();



		}

	function llenartitulosmaestro()
		{
                //$this->titulosm=array();
				$this->titulosm[0]="Referencia del Documento";
				$this->titulosm[1]="Cliente";
				$this->titulosm[2]="Descuento";
				$this->titulosm[3]="Fecha del Descuento";
				$this->titulosm[4]="Monto";
				$this->titulosm[6]="TIPO DE CLIENTE: ";

				$this->titulosm[7]="Totales por Ipo de Cliente";
				$this->titulosm[8]="Total General";
				$this->titulosm[100]="";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=60;
		$this->anchos[5]=30;
		$this->anchos[6]=40;
		$this->anchos[7]=20;
		$this->anchos[8]=20;
	}

function Header()
		{
				$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);


                $this->SetWidths(array($this->anchos[5]));
    	        $this->SetAligns(array("L"));
    	        $this->setBorder(1);
    	        $this->RowM(array($this->titulosm[6]));
		}

function Cuerpo()

		{

	    $reg=1;
		$codtipo="";
		$codpro="";
		$registro=count($this->arrp);
		//$this->arrp1 = $this->cobrdesdoc->sqlp1($dato["codpro"],$codtipo);
		foreach($this->arrp as $dato)

            {

             $reg++;
             if($dato["tipo"]!=$codtipo)
                 {

                  $this->SetWidths(array($this->anchos[5]));
    	          $this->SetAligns(array("L"));
    	          $this->setBorder(0);
    	          $this->RowM(array($dato["tipo"]));
                  $codtipo=$dato["codtipo"];

                 }

                   if($dato["codpro"]!=$codpro){
	                $this->arrp1 = $this->cobrdesdoc->sqlp1($dato["codpro"],$codtipo);
	                $monto=0;
	                $this->Ln();
				    $this->SetWidths(array(38,38,38,38,38));
	    	        $this->SetAligns(array("C","C","C","C","C","C"));
	    	        $this->setBorder(1);
	    	        $this->RowM(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4]));
	                $this->Ln();
                   }

                 foreach($this->arrp1 as $dato1)

                   {

                    {
                    $codpro=$dato1["codpro"];
                    $monto=$monto+$dato1["monto"];
                    $this->SetWidths(array(38,38,38,38,38));
    	            $this->SetAligns(array("C","L","L","C","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array($dato1["codigo"],$dato1["nombre"],$dato1["descuento"],$dato1["fecha"],H::FormatoMonto($dato1["monto"])));

                   }

                   $totmonto=$totmonto+$monto;

                   }

                    $this->SetWidths(array(152,38));
    	            $this->SetAligns(array("R","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array("Total por cliente",H::FormatoMonto($totmonto)));



            }
                    $this->SetWidths(array(152,38));
    	            $this->SetAligns(array("R","R"));
    	            $this->setBorder(0);
    	            $this->RowM(array("Total General",H::FormatoMonto($totmonto)));

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>
