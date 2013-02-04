<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farfamarca.class.php");

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

			$this->farfamarca = new Farfamarca();
		    $this->arrp = $this->farfamarca->sqlp($this->coddes,$this->codhas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();

		}

	function llenartitulosmaestro()
		{
              	$this->titulosm[0]="CÓDIGO";
				$this->titulosm[1]="DESCRIPCIÓN";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=140;
		$this->anchos[2]=110;
		$this->anchos[3]=100;
		$this->anchos[5]=50;
		//$this->anchos[5]=140;
	}

function Header()
		{
		    	$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","B",8);
				$this->ln(5);
			    $this->SetWidths(array($this->anchos[5],$this->anchos[1]));
    	        $this->SetAligns(array("C","L"));
    	        $this->Row(array($this->titulosm[0],$this->titulosm[1]));
    	        $this->line(10,$this->getY(),200,$this->getY());
   				$this->ln();
		}

function Cuerpo()

		{

	    $reg=1;
		$codmarca="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["id"]!=$codmarca)
              {
              	$this->setFont("Arial","",8);
                $this->SetWidths(array($this->anchos[5],$this->anchos[1]));
    	        $this->SetAligns(array("C","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($dato["id"],$dato["nommar"]));

              }
            }

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>
