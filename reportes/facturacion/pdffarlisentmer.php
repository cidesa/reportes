<?
	  require_once("../../lib/general/fpdf/fpdf.php");
	  require_once("../../lib/general/Herramientas.class.php");
	  require_once("../../lib/bd/basedatosAdo.php");
	  require_once("../../lib/general/cabecera.php");
	  require_once("../../lib/modelo/sqls/facturacion/Farlisentmer.class.php");

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

			$this->codpdes=H::GetPost("codpdes");
			$this->codphas=H::GetPost("codphas");

			$this->farlisentmer = new Farlisentmer();
		    $this->arrp = $this->farlisentmer->sqlp($this->coddes,$this->codhas,$this->codpdes,$this->codphas);
			$this->llenartitulosmaestro();
			$this->llenaranchos();
		}

	function llenartitulosmaestro()
		{
              //  $this->titulosm=array();
				$this->titulosm[0]="Codigo Articulo";
				$this->titulosm[1]="Descripcion";
				$this->titulosm[2]="Almacen";
				//$this->titulosm[3]="Tipo";
				$this->titulosm[3]="Persona";
				$this->titulosm[4]="Comision";
		}

function llenaranchos()
	{
		$this->anchos=array();
		$this->anchos[0]=190;
		$this->anchos[1]=150;
		$this->anchos[2]=100;
		$this->anchos[3]=50;
		$this->anchos[4]=40;
		$this->anchos[5]=30;
	}

function Header()
		{
		    	$this->cab->poner_cabecera($this,H::GetPost("titulo"),$this->conf,"s","n");
			    $this->setFont("Arial","",9);
			    $this->Ln();
			    $this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[3],$this->anchos[4],$this->anchos[5]));
    	        $this->SetAligns(array("C","C","C","C","C","C"));
    	        $this->setBorder(1);
    	        $this->Row(array($this->titulosm[0],$this->titulosm[1],$this->titulosm[2],$this->titulosm[3],$this->titulosm[4]));

		}

function Cuerpo()

		{

	    $reg=1;
		$codart="";
		$registro=count($this->arrp);
		//H::PrintR($this->arrp);
		foreach($this->arrp as $dato)
            {

             $reg++;
             if($dato["codart"]!=$codart)
              {
                $this->SetWidths(array($this->anchos[5],$this->anchos[3],$this->anchos[3],$this->anchos[4],$this->anchos[5]));
    	        $this->SetAligns(array("L","L","C","C","R"));
    	        $this->setBorder(1);
    	        $this->RowM(array($dato["codart"],$dato["desart"],$dato["nomalm"],$dato["codpro"],$dato["comisi"]));

              }
            }

		if ($reg<=$registro)
		        {
		        	$this->addpage();
		       }

		}

}//fin de la clase
?>
