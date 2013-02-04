<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Carcatart.class.php");

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

			$this->eximin=H::GetPost("eximin");
			$this->eximax=H::GetPost("eximax");

			$this->carcatart = new Carcatart();
		    $this->arrp = $this->carcatart->sqlp($this->coddes,$this->codhas,$this->eximin,$this->eximax);
			$this->llenartitulosmaestro();
			$this->llenaranchos();
			//H::PrintR($this->arrp);
			///

		}

	function llenartitulosmaestro()
		{
              //  $this->titulosm=array();
				$this->titulosm[0]="CÓDIGO";
				$this->titulosm[1]="DESCRIPCIÓN";
				$this->titulosm[2]="UNIDAD DE MEDIDA";
				//$this->titulosm[3]="Presentacion";
				$this->titulosm[4]="CÓDIGO CONTABLE";
				$this->titulosm[5]="CÓDIGO PARTIDA";
				$this->titulosm[6]="EXISTENCIA";

		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=110;
		$this->anchos[3]=90;
		$this->anchos[5]=45;
		$this->anchos[5]=30;




	}

function Header()
		{
          $this->cab->poner_cabecera($this,H::GetPost(""),$this->conf,"s","n");
          $this->setY(25);
          $this->cell(240,10,H::GetPost("titulo"),0,0,'C');
          $this->setFont("Arial","B",8);

          $this->Ln(15);
			    $this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[5],$this->anchos[5]+10,$this->anchos[5]+10,$this->anchos[5]));
    	        $this->SetAligns(array("C","L","C","C","C","C"));
    	        $this->Row(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[4],$this->titulosm[5],$this->titulosm[6]));
				$this->line(10,$this->getY(),270,$this->getY());
   				$this->ln();
		}

function Cuerpo()

		{

	    $reg=1;
		$codart="";
		$registro=count($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codart"]!=$codart)
              {
              	$this->setFont("Arial","",8);
                $this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[5],$this->anchos[5]+10,$this->anchos[5]+10,$this->anchos[5]));
    	        $this->SetAligns(array("L","L","C","L","L","C"));
    	        $this->Row(array($dato["codart"],$dato["desart"],$dato["unimed"],$dato["codcta"],$dato["codpar"],(int)$dato["exitot"]));

              }
            }

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>
