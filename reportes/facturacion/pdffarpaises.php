<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farpaises.class.php");

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

			$this->farpaises = new Farpaises();
		    $this->arrp = $this->farpaises->sqlp($this->coddes,$this->codhas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();
			//H::PrintR($this->arrp);
			///

		}

	function llenartitulosmaestro()
		{
              //  $this->titulosm=array();
				$this->titulosm[0]="Codigo";
				$this->titulosm[1]="Descripcion";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=10;
		$this->anchos[1]=150;
		$this->anchos[2]=160;
		$this->anchos[3]=80;
		$this->anchos[5]=40;
		$this->anchos[6]=50;




	}

function Header()
		{
		    	$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",10);
			     $this->Ln();
			    $this->SetWidths(array($this->anchos[6],$this->anchos[5]));
    	        $this->SetAligns(array("L","C"));
    	        $this->setBorder(0);
    	        $this->Row(array($this->titulosm[0],$this->titulosm[1]));
                $this->Ln();

		}

function Cuerpo()

		{
	    $reg=1;
		$codpai="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {
            	//H::PrintR($dato);

             $reg++;
             if($dato["id"]!=$codpai)
              {
                $this->SetWidths(array($this->anchos[6],$this->anchos[2]));
    	        $this->SetAligns(array("L","L"));
    	        $this->setBorder(0);
    	        $this->Row(array($dato["id"],$dato["nompai"]));

              }
            }

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>